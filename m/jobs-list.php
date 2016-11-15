<?php
 /*
 * 74cms WAP
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
define('REQUEST_MOBILE',true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$postData['page'] = $_GET['page'] ? $_GET['page'] : 0;
$postData['size'] = $_GET['size'] ? $_GET['size'] : 10;
$_GET['subclass'] && $postData['category_id'] = intval($_GET['subclass']);
$postData['order_type'] = intval($_GET['order_type']) ? intval($_GET['order_type']) : 100;
$_GET['district'] && $postData['province_id'] = intval($_GET['district']);
$_GET['sdistrict'] && $postData['city_id'] = intval($_GET['sdistrict']);
$jobTmp = https_request_api('job/search', $postData);
if(!$jobTmp['codes'] && $jobTmp['data']) {
    $new_jobs = $jobTmp['data'];
    foreach ($new_jobs as $key => $jobs) 
    {
        unset($new_jobs[$key]['job_desc']);
            $new_jobs[$key]['url'] = wap_url_rewrite("jobs-show",array("id"=>$jobs['id']),1,$jobs['publish_city_id']);
            $new_jobs[$key]['r_time'] = daterange(time(),$jobs['refreshtime'],'Y-m-d',"#FF3300");
            $new_jobs[$key]['work_start'] = date("n.j",$jobs['work_start']);
            $new_jobs[$key]['work_end'] = date("n.j",$jobs['work_end']);
            $tagSql = "SELECT * FROM ".table('category')." where c_alias='QS_jobtag'";
            $tagArr = $db->getall($tagSql);
            if($jobs['position_high']) {
                $jobs['position_high'] = array_flip(explode(",", $jobs['position_high']));
                foreach($tagArr as $tk => $tag) {
                    if(isset($jobs['position_high'][$tag['c_id']])) {
                       $jobs['tag'][] = $tag['c_id'];
                       $jobs['tag_cn'][] = $tag['c_name'];
                    }
                }
            }
            $new_jobs[$key]['tag'] = $jobs['tag'];
            $new_jobs[$key]['tag_cn'] = $jobs['tag_cn'];
            //职位标签
            $tagSql = "SELECT * FROM ".table('category')." where c_alias='jobspecial'";
            $tagArr = $db->getall($tagSql);
            if($jobs['position_character']) {
                $jobs['position_character'] = array_flip(explode(",", $jobs['position_character']));
                foreach($tagArr as $tk => $tag) {
                    if(isset($jobs['position_character'][$tag['c_id']])) {
                       $jobs['jobspecial'][] = $tag['c_id'];
                       $jobs['jobspecial_cn'][] = $tag['c_name'];
                    }
                }
            }
            $new_jobs[$key]['jobspecial'] = $jobs['jobspecial'];
            $new_jobs[$key]['jobspecial_cn'] = $jobs['jobspecial_cn'];
            //学历
            $tagSql = "SELECT * FROM ".table('category')." where c_alias='QS_education'";
            $tagArr = $db->getall($tagSql);
            if($jobs['education']) {
                $jobs['education_bak'] = array_flip(explode(",", $jobs['education']));
                unset($jobs['education']);
                foreach($tagArr as $tk => $tag) {
                    if(isset($jobs['education_bak'][$tag['c_id']])) {
                       $jobs['education'][] = $tag['c_id'];
                       $jobs['education_cn'][] = $tag['c_name'];
                    }
                }
            }
            $new_jobs[$key]['education'] = $jobs['education'];
            $new_jobs[$key]['education_cn'] = $jobs['education_cn'];
            $tagSql = "SELECT * FROM ".table('category')." where c_alias='QS_experience'";
            $tagArr = $db->getall($tagSql);
            if($jobs['experience']) {
                $jobs['experience_bak'] = array_flip(explode(",", $jobs['experience']));
                unset($jobs['experience']);
                foreach($tagArr as $tk => $tag) {
                    if(isset($jobs['experience_bak'][$tag['c_id']])) {
                       $jobs['experience'][] = $tag['c_id'];
                       $jobs['experience_cn'][] = $tag['c_name'];
                    }
                }
            }
            foreach(get_all_subsite() as $sk => $site) {
                if($site['s_id'] == $jobs['publish_city_id']) {
                    $jobs['site'] = $site;
                    $jobs['subsite_id'] = $site['s_id'];
                    $jobs['subsite_name'] = $site['s_sitename'];
                }
            }
            $new_jobs[$key]['start_date'] = date('Y年m月d日', $new_jobs[$key]['start_date']);
            $new_jobs[$key]['end_date'] = date('Y年m月d日', $new_jobs[$key]['end_date']);
            $new_jobs[$key]['district_cn'] = $jobs['site']['s_districtname'];
            $new_jobs[$key]['experience'] = $jobs['experience'];
            $new_jobs[$key]['experience_cn'] = $jobs['experience_cn'];
    }
}
$subsite=get_cache('subsite');
$subsitelist =array();
foreach ($subsite as $key => $value) {
	$subsitelist[] = $value;
}
$smarty->assign("subsite",$subsitelist);
$smarty->assign('jobs',$new_jobs);//print_r($jobs);exit;
$smarty->assign('pagehtml',wapmulti($count, $perpage, $page, $theurl));
$smarty->display("m/m-jobs-list.html");
?>