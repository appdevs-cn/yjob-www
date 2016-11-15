<?php
 /*
 * 74cms 清除缓存
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
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'select_cache';
$smarty->assign('pageheader',"更新缓存");
check_permissions($_SESSION['crm_admin_purview'],"clear_cache");
if ($act=="select_cache")
{
	
	$smarty->display('sys/crm_clear_cache.htm');
}
elseif ($act=="clear_cache")
{
	refresh_crm_category_cache();
	crmmsg('更新成功！',2);
}
?>