<?php
 /*
 * 74cms 管理员账户
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
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'users_config';
$smarty->assign('pageheader',"用户设置");
if($act == 'users_config')
{
	get_token();
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("权限不足！",1);
	$config = $db->getall("select * from ".table('crm_users_config'));
	$smarty->assign('max_receive_client_num',$config[0]);	
	$smarty->assign('follow_days',$config[1]);
	$smarty->assign('deal_days',$config[2]);
	$smarty->assign('navlabel','users_config');	
	$smarty->display('users_config/crm_users_config.htm');
}
elseif($act == 'users_config_save')
{
	check_token();
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("权限不足！",1);
	$db->query("UPDATE ".table('crm_users_config')." set config_value=".$_POST['max_receive_client_num']." where id=1");
	$db->query("UPDATE ".table('crm_users_config')." set config_value=".$_POST['follow_days']." where id=2");
	$db->query("UPDATE ".table('crm_users_config')." set config_value=".$_POST['deal_days']." where id=3");
	crmmsg("保存成功",2);
}
?>