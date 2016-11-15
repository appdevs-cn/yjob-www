<?php
 /*
 * 74cms WAP
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
define('REQUEST_MOBILE',true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
require_once(dirname(__FILE__).'/weixin_share.php');
wap_weixin_logon($_GET['from']);
$infoRst = https_request_api('job/info/'.$_GET['id']);
if($infoRst['codes']) {
    showmsg($infoRst['msg']);
}
$row=$infoRst['data'];
check_m_url($row['publish_city_id'],$smarty,$_CFG['m_job_url']);
////感兴趣的职位
$interest_show=interest_jobs($row['topclass'],$row['category'],$row['subclass'],$_GET['id']);
if($_SESSION["uid"] && $_SESSION["utype"]==2){
	$sql="select * from ".table("resume")." where uid=$_SESSION[uid] ";
	$resume_list = $db->getall($sql);
	$smarty->assign('resume_list',$resume_list);
}
$show=false;
if($_CFG['showjobcontact_wap']=='0')
{
	$show=true;
}
elseif($_CFG['showjobcontact_wap']=='1')
{
	if ($_SESSION['uid'] && $_SESSION['username'] && $_SESSION['utype']=='2')
	{
		$show=true;
	}
	else
	{
		$show=false;
	}
}
elseif($_CFG['showjobcontact_wap']=='2')
{
	if ($_SESSION['uid'] && $_SESSION['username'] && $_SESSION['utype']=='2')
	{
		$val=$db->getone("select uid from ".table('resume')." where uid='{$_SESSION['uid']}' LIMIT 1");
	 	if (!empty($val))
		{
			$show=true;
		}
		else
		{
			$show=false;
		}
	}
	else
	{
		$show=false;
	}
}
if($_SESSION['uid'] && $_SESSION['username'] && $_SESSION['utype']=='1' && $show==false)
{
	if($row['uid']==$_SESSION['uid'])
	{
		$show=true;
	}
	else
	{
		$show=false;
	}
}
//处理固话信息(将分机号为空的去掉)
$telarray = explode('-',$row['contact_tel']);
if(intval($telarray[0]) > 0)
{
	$landline_tel = $telarray[0];
}
if(intval($telarray[1]) > 0)
{
	$landline_tel = empty($landline_tel)?$telarray[1]:$landline_tel."-".$telarray[1];
}
if(intval($telarray[2]) > 0)
{
	$landline_tel = empty($landline_tel)?$telarray[2]:$landline_tel."-".$telarray[2];
}

$row['category_cn']=$row['category_name'];
$row['start_riqi']=date("n.j",$row['list'][0]['start_date']);
$row['start_shijian']=$row['list'][0]['work_start_time'];
$row['end_riqi']=date("n.j",$row['list'][0]['end_date']);
$row['end_shijian']=$row['list'][0]['work_end_time'];
$row['wage_amount']=$row['list'][0]['parttime_money'];
$row['address']=$row['list'][0]['adress'];
$row['contact']['landline_tel'] = $landline_tel;
$row['sex_cn'] = $row['sex_cn'] == 200 ? '男' : ($row['sex_cn'] == 300 ? '女' : '不限') ;
$tagSql = "SELECT * FROM ".table('category')." where c_alias='QS_jobtag'";
$tagArr = $db->getall($tagSql);
if($row['position_high']) {
    $row['position_high'] = array_flip(explode(",", $row['position_high']));
    foreach($tagArr as $tk => $tag) {
        if(isset($row['position_high'][$tag['c_id']])) {
           $row['tag_cn'][] = $tag['c_name'];
        }
    }
}
$row['tag'] = $row['tag'];
$row['tag_cn'] = $row['tag_cn'];
if($row['list']) {
    foreach($row['list'] as $lk => $plist) {
        $row['amount'] += $plist['parttime_nums'];
    }
}
//是否收藏
$favData['job_id'] = $_GET['id'];
$favData['uid'] = $_SESSION['uid'];
$resumeInfo = get_resume_basic_by_uids($_SESSION['uid']);
$isFavRst = https_request_api('job/isFav', $favData);
$row['is_fav'] = !$isFavRst['codes'] ? $isFavRst['data'] : 0;
//是否报名
$isEnrollRst = https_request_api('enroll/isEnroll', $favData);
$row['is_enroll'] = !$isEnrollRst['codes'] ? $isEnrollRst['data'] : 0;
$smarty->assign('is_show_tel',$show);
$smarty->assign('rid',$resumeInfo['id']);
$smarty->assign('show',$row);
$smarty->assign('interest_show',$interest_show);
$smarty->assign('goback',$_SERVER["HTTP_REFERER"]);
$smarty->display("m/m-jobs-show.html");
?>