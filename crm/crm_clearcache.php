<?php
 /*
 * 74cms �������
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
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'select_cache';
$smarty->assign('pageheader',"���»���");
check_permissions($_SESSION['crm_admin_purview'],"clear_cache");
if ($act=="select_cache")
{
	
	$smarty->display('sys/crm_clear_cache.htm');
}
elseif ($act=="clear_cache")
{
	refresh_crm_category_cache();
	crmmsg('���³ɹ���',2);
}
?>