<?php
 /*
 * 74cms 共用配置文件
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
if(!defined('IN_QISHI'))
{
die('Access Denied!');
}
error_reporting(E_ERROR);
define('CRM_ROOT_PATH', str_replace('install/include/common.inc.php', '', str_replace('\\', '/', __FILE__)));
define('QISHI_ROOT_PATH', dirname(CRM_ROOT_PATH).'/');
session_cache_limiter('private, must-revalidate');
ini_set('session.save_handler', 'files');
session_save_path(QISHI_ROOT_PATH.'data/sessions/');
session_start();
require_once (CRM_ROOT_PATH.'install/include/common.fun.php');
if (!empty($_GET))
{
$_GET  = install_addslashes_deep($_GET);
}
if (!empty($_POST))
{
$_POST = install_addslashes_deep($_POST);
}
$_COOKIE   = install_addslashes_deep($_COOKIE);
$_REQUEST  = install_addslashes_deep($_REQUEST);
PHP_VERSION > '5.1'?date_default_timezone_set("PRC"):'';
 $timestamp = time();
 header("Content-Type:text/html;charset=".QISHI_CHARSET);
 $php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
 $url = $php_self."?".$_SERVER['QUERY_STRING'];
if (!file_exists(CRM_ROOT_PATH.'install/'))
{
echo "“install”目录不存在！";
exit();
}
if (!is_readable(CRM_ROOT_PATH.'install/') || !is_writable(CRM_ROOT_PATH.'install/') || !is_readable(CRM_ROOT_PATH.'install/compile/') || !is_writable(CRM_ROOT_PATH.'install/compile/'))
{
exit("请先将“install”目录以及此目录下的子目录设置为可读写状态（777）");
} 
 require_once(CRM_ROOT_PATH.'include/mysql.class.php');
 $db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass);
 require_once(QISHI_ROOT_PATH.'include/template_lite/class.template.php');
 $install_smarty = new Template_Lite();
 $install_smarty -> reserved_template_varname = "smarty";
 $install_smarty->cache = false;
 $install_smarty->template_dir = CRM_ROOT_PATH.'install/templates';
 $install_smarty->compile_dir = CRM_ROOT_PATH.'install/compile';
 $install_smarty->left_delimiter = "{#";
 $install_smarty->right_delimiter = "#}";
 $need_check_dirs = array(
                    'data'
                    );

?>
