<?php
 /*
 * 74cms ����������ҳ
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/crm_common.inc.php');
$act=!empty($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
if($act=='')
{
	$smarty->display('sys/crm_index.htm');
}
elseif($act=='top')
{
	$admininfo=get_admin_one($_SESSION['crm_admin_name']);
	$smarty->assign('admin_rank', $admininfo['rank']);
	$smarty->assign('admin_name', $_SESSION['crm_admin_name']);
	$smarty->display('sys/crm_top.htm');
}
elseif($act=='left')
{
	$smarty->display('sys/crm_left.htm');
}
elseif($act == 'main')
{
	$admindir_warning=substr(CRM_ROOT_PATH,-5)=='/crm/'?"���Ŀͻ���ϵ����ϵͳĿ¼Ϊ ./crm �����ڰ�ȫ�Ŀ��ǣ����ǽ������޸�Ŀ¼����":null;
	$install_warning=file_exists('install')?"����û��ɾ�� install �ļ��У����ڰ�ȫ�Ŀ��ǣ����ǽ�����ɾ�� install �ļ��С�":null;
	$system_info = array();
	$system_info['version'] = QISHI_VERSION;
	$system_info['release'] = QISHI_RELEASE;
	$system_info['os'] = PHP_OS;
	$system_info['web_server'] = $_SERVER['SERVER_SOFTWARE'];
	$system_info['php_ver'] = PHP_VERSION;
	$system_info['mysql_ver'] = $db->dbversion();
	$system_info['max_filesize'] = ini_get('upload_max_filesize');
	$smarty->assign('site_domain',$_SERVER['SERVER_NAME']);
	$smarty->assign('system_info',$system_info);
	$smarty->assign('random',mt_rand());
	$smarty->assign('admindir_warning',$admindir_warning);
	$smarty->assign('install_warning',$install_warning);
	$smarty->assign('pageheader',"��ʿ�˲�ϵͳ - �ͻ���ϵ����ϵͳ");
	$smarty->display('sys/crm_main.htm');
}
?>