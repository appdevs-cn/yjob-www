<?php

define('IN_QISHI', true);
//define('REQUEST_MOBILE',true);
require_once(dirname(__FILE__).'/../../include/common.inc.php');
//require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
//require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$encode = mb_detect_encoding($_POST['bankName'], array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
$_POST['userName'] = mb_convert_encoding($_POST['userName'], 'GBK', $encode);
$_POST['bankName'] = mb_convert_encoding($_POST['bankName'], 'GBK', $encode);
$_POST['handAdd'] = mb_convert_encoding($_POST['handAdd'], 'GBK', $encode);
$uid = isset($_POST['userId'])?$_POST['userId']:'2';
$sql = "select id from ys_my_bank_card where uid=" . $uid;
$result = $db->getone($sql);

if($_POST['userName'] && $_POST['userId'] && $_POST['cardId'] && $_POST['bankName']){
    $arr = [];
    $arr['uid'] = $_POST['userId'];
    $arr['username'] = $_POST['userName'];
    $arr['card_num'] = $_POST['cardId'];
    $arr['bank_name'] = $_POST['bankName'];
    $arr['hand_bank_name'] = $_POST['handAdd'];
}

if(!$result){
    $row = $db->inserttable('ys_my_bank_card', $arr);
    if($row){
        echo 1;
    }
}else{
    $row = $db->updatetable('ys_my_bank_card', $arr, array("uid"=>$arr['uid']));
    if($row){
        echo 1;
    }
}