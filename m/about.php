<?php
 /*
 * 74cms �������������
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
wap_weixin_openid($_GET['code']);
//��վ��飨˵��ҳ�� 
$site_detail = $db->getone("SELECT * FROM ".table('explain')." WHERE id=2 ");
$smarty->assign('site_detail',htmlspecialchars_decode($site_detail["content"],ENT_QUOTES));
$smarty->assign('goback',$_SERVER["HTTP_REFERER"]);
$smarty->display("m/about.html");
?>