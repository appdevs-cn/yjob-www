<?php
define('IN_QISHI', true);
define('REQUEST_MOBILE',true);
require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'index';
function ResizeImage($im,$maxwidth,$maxheight,$name){
    //取得当前图片大小
    $width = imagesx($im);
    $height = imagesy($im);
    //生成缩略图的大小
    if(($width > $maxwidth) || ($height > $maxheight)){
        $widthratio = $maxwidth/$width;
        $heightratio = $maxheight/$height;
        if($widthratio < $heightratio){
            $ratio = $widthratio;
        }else{
            $ratio = $heightratio;
        }
        $newwidth = $width * $ratio;
        $newheight = $height * $ratio;

        if(function_exists("imagecopyresampled")){
            $newim = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        }else{
            $newim = imagecreate($newwidth, $newheight);
            imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        }
        ImageJpeg ($newim, $name . ".jpg");
        ImageDestroy ($newim);
    }else{
        ImageJpeg ($im,$name . ".jpg");
    }
}

if($act == 'sign')
{

    $data['uid'] = $_SESSION['uid'];
    $data['job_info_id'] = $_POST['jobInfoId'];
    $data['enroll_id'] = $_POST['enrollId'];
    $data['job_id'] = $_POST['jobId'];
    $data['sign_time'] = strtotime($_POST['signTime']);
//    $data['sign_address'] = iconv("utf-8", "gbk", $_POST['signAddr']);
    $data['sign_address'] = $_POST['signAddr']?$_POST['signAddr']:'没有获取到地理位置';
//    $data['remark'] = iconv("utf-8", "gbk", $_POST['signDesc']);
    $data['remark'] = $_POST['signDesc'];
    $data['sign_type'] = $_POST['type'];
    $pic_name=date("YmdHis");
    if($_FILES['pics']['size']){
        $num = count($_FILES['pics']['name'])-1;
        $pic_arr = array();
        for($i=0;$i<$num;$i++){
            if($_FILES['pics']['type'][$i] == "image/pjpeg" || $_FILES['pics']['type'][$i] == "image/jpg" || $_FILES['pics']['type'][$i] == "image/jpeg"){
                $im = imagecreatefromjpeg($_FILES['pics']['tmp_name'][$i]);
            }elseif($_FILES['pics']['type'][$i] == "image/x-png" || $_FILES['pics']['type'][$i] == "image/png"){
                $im = imagecreatefrompng($_FILES['pics']['tmp_name'][$i]);
            }elseif($_FILES['pics']['type'][$i] == "image/gif"){
                $im = imagecreatefromgif($_FILES['pics']['tmp_name'][$i]);
            }

            if($im){
                if(file_exists($pic_name.$i.'.jpg')){
                    unlink($pic_name.$i.'.jpg');
                }
                $pic_str = 'http://www.yjob.net/upload/'.$pic_name.$i.'.jpg';
                ResizeImage($im,600,600,'../../upload/'.$pic_name.$i); // 统一生成100 * 100 的jpg图片
                ImageDestroy ($im);
                array_push($pic_arr,$pic_str);
            }
        }
    }
    if($pic_arr) {
        $data['sign_pic'] = implode("\n", $pic_arr);
    }
//    var_dump($data);exit;
    $rst = https_request_api('/job/past', $data);
//    exit($rst['msg']);
    if($rst['msg']=='签到成功!'){
        header("Location:user.php?act=work_card&id=".$_POST['enrollId']."&type=success");
    }elseif($rst['msg']=='签退成功!'){
        header("Location:user.php?act=work_card&id=".$_POST['enrollId']."&type=tui");
    }else{
        header("Location:user.php?act=work_card&id=".$_POST['enrollId']."&type=false");
    }
} elseif($act == 'stood') {
    $data['enroll_id']  = $_POST['eid'];
    $data['status']  = $_POST['status'];
    $rst = https_request_api('enroll/stood', $data);
    exit($rst['msg']);
} elseif($act == 'changeStatus') {
    $data['sign_ids']  = $_POST['sids'];
    $userInfo = get_user_info($_SESSION['uid']);
    $data['confirm_uid']  = $userInfo['uid'];
    $data['confirm_user_name']  = $userInfo['username'];
    $data['confirm_user_position']  = 100;
    $data['status']  = $_POST['status'];
    $rst = https_request_api('job/confirm', $data);
    exit($rst['msg']);
} elseif($act == 'leaveEarly') {  // 修改放鸽子、早退等状态
    $data['enroll_id']  = $_POST['eid'];
    $data['status']  = $_POST['status'];
        $rst = https_request_api('enroll/leaveEarly', $data);
    exit($rst['msg']);
} elseif($act == 'eveluate') {  // 督导通过ajax评价管理
    $data['enroll_id'] = $_POST['eid'];
    $data['job_id'] = $_POST['job_id'];
    $data['job_info_id'] = $_POST['job_info_id'];
    $data['uid'] = $_POST['uid'];
    $typeKey = $_POST['typekey'];
    $data['evaluate_uid'] = $_SESSION['uid'];
//    $_POST['content'] && $data['evaluate_content'] = iconv('utf8', 'gbk', $_POST['content']);
    $data['evaluate_content'] = iconv('utf-8', 'gbk', $_POST['content']);
    $_POST['score'] && $data['score'] = $_POST['score'];
    switch($typeKey) {
        case 'punctual':
            $data['type'] = 101;
            break;
        case 'earnest':
            $data['type'] = 102;
            break;
        case 'effect':
            $data['type'] = 103;
            break;
        case 'performance':
            $data['type'] = 104;
            break;
        case 'ability':
            $data['type'] = 105;
            break;
    }
//    $data['job_id'] = 100;
//    $data['job_info_id'] = 101;
//    $data['enroll_id'] = 305;
//    $data['uid'] = 895;
//    $data['type'] = 102;
//    $data['evaluate_uid'] = $_SESSION['uid'];
//    $data['evaluate_content'] = 'sss1111111';
//    $data['score'] = 2;
    $rst = https_request_api('/job/evaluate', $data);
    var_dump($rst);exit;
} elseif($act == 're_enroll') {
    if(!$_POST['jobid']) {
        exit('jobid不能为空!');
    }
    if(!$_POST['jobinfo_id']) {
        exit('jobinfoid不能为空!');
    }
    $data['job_id'] = $_POST['jobid'];
    $data['job_info_id'] = $_POST['jobinfo_id'];
    $data['uid'] = $_SESSION['uid'];
    $data['enroll_type'] = 200;
    $nextDay = strtotime(date('Y-m-d', time()));
    $data['date'] = strtotime('+1 days', $nextDay);
    $resumeInfo = get_resume_basic_by_uid($_SESSION['uid']);
    $data['resume_id'] = $resumeInfo['id'];
    $data['company_id'] = $_POST['cid'];
    $rst = https_request_api('/enroll/add', $data);
    exit($rst['msg']);
} elseif($act == 'uplode_img') {
    $img = isset($_POST['img'])? $_POST['img'] : '';  
    // 获取图片
    list($type, $data) = explode(',', $img);  

    // 判断类型  
    if(strstr($type,'image/jpeg')!==''){  
        $ext = '.jpg';  
    }elseif(strstr($type,'image/gif')!==''){  
        $ext = '.gif';  
    }elseif(strstr($type,'image/png')!==''){  
        $ext = '.png';
    }
//    echo strlen($data);exit;
    // 生成的文件名  
    $photo = time().$ext;
    $img = base64_decode($data);
    // 生成文件  
    $ss = file_put_contents(QISHI_ROOT_PATH.'upload/'.$photo, $img, true);
    // 返回  
    echo 'http://www.yjob.net/upload/'.$photo;
    
}