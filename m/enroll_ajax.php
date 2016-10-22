<?php
define('IN_QISHI', true);
define('REQUEST_MOBILE',true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'index';
if($act == 'cancel')
{
    $data['enroll_ids'][] = $_POST['eid'];
    $data['status'] = 500;
    $rst = https_request_api('/enroll/status', $data);
    exit($rst['msg']);
}