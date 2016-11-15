<?php
 /*
 * 74cms 管理中心首页
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
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
	$admindir_warning=substr(CRM_ROOT_PATH,-5)=='/crm/'?"您的客户关系管理系统目录为 ./crm ，出于安全的考虑，我们建议您修改目录名。":null;
	$install_warning=file_exists('install')?"您还没有删除 install 文件夹，出于安全的考虑，我们建议您删除 install 文件夹。":null;
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
	$smarty->assign('pageheader',"骑士人才系统 - 客户关系管理系统");
	$smarty->display('sys/crm_main.htm');
}
?>