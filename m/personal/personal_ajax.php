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
if($act == 'sign')
{
    $data['uid'] = $_SESSION['uid'];
    $data['job_info_id'] = $_POST['jobInfoId'];
    $data['enroll_id'] = $_POST['enrollId'];
    $data['job_id'] = $_POST['jobId'];
    $data['sign_time'] = strtotime($_POST['signTime']);
    $data['sign_address'] = iconv("utf-8", "gbk", $_POST['signAddr']);
    $data['remark'] = iconv("utf-8", "gbk", $_POST['signDesc']);
    $data['sign_type'] = $_POST['type'];
    if($_POST['pics']) {
        $data['sign_pic'] = implode("\n", $_POST['pics']);
    }
    $rst = https_request_api('/job/past', $data);
    exit($rst['msg']);
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
} elseif($act == 'leaveEarly') {
    $data['enroll_id']  = $_POST['eid'];
    $data['status']  = $_POST['status'];
    $rst = https_request_api('enroll/leaveEarly', $data);
    exit($rst['msg']);
} elseif($act == 'eveluate') {
    $data['enroll_id'] = $_POST['eid'];
    $data['uid'] = $_POST['uid'];
    $typekey = $_POST['typekey'];
    $data['evaluate_uid'] = $_SESSION['uid'];
    $_POST['content'] && $data['evaluate_content'] = iconv('utf8', 'gbk', $_POST['content']);
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
    $rst = https_request_api('/job/evaluate', $data);
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