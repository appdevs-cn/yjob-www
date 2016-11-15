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

require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'interview';
wap_weixin_openid($_GET['code']);

if ($_SESSION['uid']=='' || $_SESSION['username']==''||intval($_SESSION['utype'])==1)
{
	header("Location: ../login.php");
}
$user = get_user_info($_SESSION['uid']);
if($_CFG['login_per_audit_mobile'] && $user['mobile_audit']=="0")
{
	$str= "<script>";
	$str.="alert('请先验证手机！');";
	$str.="window.location.href='account_security.php';";
	$str.= "</script>";
	echo $str;
}
//邀请面试
elseif ($act == 'interview')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	//$wheresql=" WHERE a.personal_uid='{$_SESSION['uid']}' ";
	$resume=$db->getone("select * from ".table('resume')." where uid='{$_SESSION['uid']}'");
	$rid=$resume['id'];
	$biaoqian=$db->getall("select * from ".table('company_label_resume')." where resume_id='{$rid}' and resume_state=1");
	$time=time();
	$biaoqian1=array();
	foreach($biaoqian as $k=>$v){
		$jid=$v['jobs_id'];
		$jobs=$db->getone("select * from ".table('jobs')." where id='{$jid}' and work_end > $time");
		if($jobs){
			$biaoqian[$k]['jobs_name']=$jobs['jobs_name'];
			$biaoqian[$k]['companyname']=$jobs['companyname'];
			$biaoqian[$k]['work_start']=date("Y-m-d H:i",$jobs['work_start']);
			$biaoqian1[$k]=$biaoqian[$k];
		}
		
	}
	$perpage = 6;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	$total_sql="select jobs_id from ".table('company_label_resume')." where resume_id='{$rid}' and resume_state=1";
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->assign('interview',$biaoqian1);
	$smarty->display("m/personal/m-interview.html");
}
?>