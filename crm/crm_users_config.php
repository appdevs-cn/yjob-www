<?php
 /*
 * 74cms ����Ա�˻�
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
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'users_config';
$smarty->assign('pageheader',"�û�����");
if($act == 'users_config')
{
	get_token();
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("Ȩ�޲��㣡",1);
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
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("Ȩ�޲��㣡",1);
	$db->query("UPDATE ".table('crm_users_config')." set config_value=".$_POST['max_receive_client_num']." where id=1");
	$db->query("UPDATE ".table('crm_users_config')." set config_value=".$_POST['follow_days']." where id=2");
	$db->query("UPDATE ".table('crm_users_config')." set config_value=".$_POST['deal_days']." where id=3");
	crmmsg("����ɹ�",2);
}
?>