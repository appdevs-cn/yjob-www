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
$idd = intval($_GET['id']);

$row3=$db->getone("select * from ".table('resume')." where id = {$idd}");


if($_GET['dsf']==""){
if($_SESSION['utype']==1){
	$row2=$db->getone("select * from ".table('personal_jobs_apply')." where resume_id = {$idd} and company_uid='{$_SESSION['uid']}'");
	if(empty($row2)){
		
		$link[0]['text'] = "������һҳ";
		$link[0]['href'] = 'javascript:history.go(-1)';
		showmsg('����Ȩ�鿴�ü�����',0,$link);
	}
}elseif($_SESSION['utype']==2){
	if($_SESSION['uid']!=$row3['uid']){
		$link[0]['text'] = "������һҳ";
		$link[0]['href'] = 'javascript:history.go(-1)';
		showmsg('����Ȩ�鿴�ü�����',0,$link);
	}
}
}
$row=resume_one($idd);
check_m_url($row['subsite_id'],$smarty,$_CFG['m_resume_url']);
wap_weixin_logon($_GET['from']);
if(intval($_SESSION["uid"])>0){
	$sql="select * from ".table("company_down_resume")." where company_uid=$_SESSION[uid] and resume_id=".$idd;
	$down_resume=$db->getone($sql);
	$smarty->assign('down_resume',$down_resume);
	$time=time();
	$jobs_sql="select * from ".table("jobs")." where uid=$_SESSION[uid] and display=1 and deadline>$time ";
	$jobs_row=$db->getall($jobs_sql);
	$smarty->assign('jobs_row',$jobs_row);
}
$smarty->assign('show',$row);
$smarty->assign('goback',$_SERVER["HTTP_REFERER"]);
$smarty->display("m/m-resume-show.html");
?>