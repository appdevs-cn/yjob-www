<?php
 /*
 * 74cms WAP
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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
$row=jobs_one($_GET['id']);
check_m_url($row['subsite_id'],$smarty,$_CFG['m_job_url']);
//����Ȥ��ְλ
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
//����̻���Ϣ(���ֻ���Ϊ�յ�ȥ��)
$telarray = explode('-',$row['contact']['landline_tel']);
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
$shumu=$db->getone("select count(did)  from ".table('personal_jobs_apply')." where jobs_id='{$row['id']}'");
$category_cn=explode('/',$row['category_cn']);
$count=count($category_cn);
$ke1=$count-1;
$row['category_cn']=$category_cn[$ke1];
$row['counts']=$shumu['count(did)'];
$row['start_riqi']=date("n.j",$row['work_start']);
$row['start_shijian']=date("G:i",$row['work_start']);
$row['end_riqi']=date("n.j",$row['work_end']);
$row['end_shijian']=date("G:i",$row['work_end']);
$row['contact']['landline_tel'] = $landline_tel;
$smarty->assign('is_show_tel',$show);
$smarty->assign('show',$row);
$smarty->assign('interest_show',$interest_show);
$smarty->assign('goback',$_SERVER["HTTP_REFERER"]);
$smarty->display("m/m-jobs-show.html");
?>