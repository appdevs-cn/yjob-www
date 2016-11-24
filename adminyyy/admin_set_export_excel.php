<?php
// 配置文件
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/admin_common.inc.php');
// 获取提交过来的手机字符串
$phoneStr = isset($_POST['phonestr'])?$_POST['phonestr']:"";
$requestMarr = explode("\\',", $phoneStr);
$act = isset($_GET['act'])?$_GET['act']:'';
$phoneStr = str_replace("\\",'',$phoneStr);
$phoneArr = explode(',', $phoneStr);
$phoneArr = array_unique($phoneArr);
$phoneStr = implode(',', $phoneArr);

if($act == 'export'){
    // 导出数据
    $phoneStr = trim($phoneStr, ',');
    $phoneStr1 = str_replace("'",'',$phoneStr);
    $phoneArr1 = explode(',', $phoneStr1);
    $sql = "select * from ys_my_bank_card where user_mobile in (".$phoneStr.")";
    $data = $db->getall($sql);
    $str = "ID号,UID,姓名,手机号,卡号,银行,状态\n";
    $str = iconv('utf-8','gb2312',$str);
    foreach ($data as $key => $value) {
        $uesrname = $data[$key]['username'];
        $bank_name = str_replace('·', '/', $data[$key]['bank_name']);
        $hand_bank_name = $data[$key]['hand_bank_name'];
        if($hand_bank_name != ''){
            $bank_name = $hand_bank_name;
        }
        $str .= $data[$key]['id'].",\t".$data[$key]['uid'].",\t".$uesrname.",\t".$data[$key]['user_mobile'].",\t".$data[$key]['card_num'].",".$bank_name.",".$data[$key]['bank_status']."\n";
    }
    // 结果要提交过来的手机号但不在数据库中，进行返回false
    $sql = "select user_mobile from ys_my_bank_card";
    $allMobile = $db->getall($sql);
    $libMarr = [];
    foreach($allMobile as $key=>$value){
        $libMarr[$key] = $value['user_mobile'];
    }
    $diffArr = array_diff($phoneArr1, $libMarr);
    $str .= iconv('utf-8','gb2312', "错误手机号或没有绑定银行卡\n");
    foreach($diffArr as $v){
        $str .= $v."\n";
    }
//    echo $str;exit;
    date_default_timezone_set('PRC');
    $filename = date('YmdHi').'.csv';
    export_csv($filename,$str);
}

if ($act == 'import') { //导入CSV
    $filename = $_FILES['excel']['tmp_name'];
    if (empty ($filename)) {
        echo iconv('utf-8','gb2312','请选择要导入的CSV文件！');
        exit;
    }
    if($_FILES['excel']['type'] != 'application/vnd.ms-excel'){
        echo iconv('utf-8','gb2312','请选择CSV格式的文件！');
        exit;
    }
    $handle = fopen($filename, 'r');
    $result = input_csv($handle); //解析csv
    $len_result = count($result);
    if($len_result==0){
        echo iconv('utf-8','gb2312','没有任何数据！');
        exit;
    }
    $phoneVal = '';
    for ($i = 0; $i < $len_result; $i++) {
        $phoneVal .= $result[$i][0].",";
//        $phoneVal .= "'".$result[$i][0]."',";
    }
    $phoneVal = substr($phoneVal,0,-1); //去掉最后一个逗号
//    fclose($handle); //关闭指针
//    $sql = "select * from ys_my_bank_card where user_mobile in (".$phoneVal.")";
//    $result = mysqli_query($link, $sql);
//    while($row=mysqli_fetch_assoc($result)){
//        var_dump($row);
//    }


    echo "<form style='display:none;' id='form1' name='form1' method='post' action='http://www.yjob.net/adminyyy/admin_set_person_card.php?act=import'>
              <input name='phone' type='text' value='{$phoneVal}' />
            </form>
            <script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";
    exit;
}

function input_csv($handle) {
    $out = array ();
    $n = 0;
    while ($data = fgetcsv($handle, 10000)) {
        $num = count($data);
        for ($i = 0; $i < $num; $i++) {
            $out[$n][$i] = $data[$i];
        }
        $n++;
    }
    return $out;
}

function export_csv($filename,$data) {
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $data;
}
