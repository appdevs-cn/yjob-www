<?php
 /*
 * 74cms WAP
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
if(!$_SESSION['uid']) {
    header('location:login.php');
}
$postData['page'] = $_GET['page'] ? $_GET['page'] : 0;
$postData['size'] = $_GET['size'] ? $_GET['size'] : 10;
$postData['uid'] = $_SESSION['uid'];
$jobsListTmp = https_request_api('/enroll/list', $postData);

if(!$jobsListTmp['codes'] && $jobsListTmp['data']) {

    foreach ($jobsListTmp['data']['list'] as $ekey => $eVal) 
    {
        $jobInfo = https_request_api('/job/info/'.$eVal['job_id']);
        if(!$jobInfo['data']) {
            continue; 
        }
        $enrollInfo['job_name'] = $jobInfo['data']['job_name'];
        $enrollInfo['category_name'] = $jobInfo['data']['category_name'];
        $enrollInfo['job_id'] = $jobInfo['data']['id'];
        $enrollInfo['eid'] = $eVal['id'];
        $enrollInfo['job_info_id'] = $eVal['job_info_id'];
        $enrollInfo['etype'] = $eVal['enroll_type'];
        $enrollInfo['status'] = $eVal['status'];
        $enrollInfo['work_date'] = $eVal['work_date'];
        $enrollInfo['estatus'] = $eVal['evaluate_status'];
        $enrollInfo['ptype'] = $eVal['position_type'];
        $enrollInfo['url'] = wap_url_rewrite("jobs-show",array("id"=>$jobInfo['data']['id']),1,$jobInfo['data']['publish_city_id']);
        if(in_array($eVal['status'], [100, 200, 300])){
            $enrollList[$eVal['status']][] = $enrollInfo;
        } else {
            $enrollList[0][] = $enrollInfo;
        }
    }
}
$subsite=get_cache('subsite');
$subsitelist =array();
foreach ($subsite as $key => $value) {
	$subsitelist[] = $value;
}
$smarty->assign("subsite",$subsitelist);
$smarty->assign('enrollList',$enrollList);
$smarty->assign('pagehtml',wapmulti($count, $perpage, $page, $theurl));
$smarty->display("m/m-user-jobs.html");
?>