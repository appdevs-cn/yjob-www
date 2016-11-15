<?php
 /*
 * 74cms 触屏版首页
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
$redirect_to_subsite = false;
$redirect_url = '';
$redirect_disname = '';
$redirect_sitename = '';

/*if(!$_SESSION['uid'] && !$_SESSION['username'] && !$_SESSION['utype'] &&  $_COOKIE['QS']['username'] && $_COOKIE['QS']['password'] )
{
	
	
	header("location:login.php"); 
	
}*/
if(intval($_CFG['subsite_id'])==0){
    $subinfo = check_m_subsite_url();
    if($subinfo){
            $redirect_to_subsite = true;
            $redirect_url = $subinfo['url'];
            $redirect_disname = $subinfo['disname'];
            $redirect_sitename = $subinfo['sitename'];
    }
}
$smarty->assign('redirect_to_subsite',$redirect_to_subsite);
$smarty->assign('redirect_url',$redirect_url);
$smarty->assign('redirect_disname',$redirect_disname);
$smarty->assign('redirect_sitename',$redirect_sitename);
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
require_once(dirname(__FILE__).'/weixin_share.php');
if($_CFG['subsite_id']>0){
	$subsite_wheresql = ' subsite_id='.intval($_CFG['subsite_id']).' ';
}else{
	$subsite_wheresql = ' 1=1 ';
}
//公告
$notice_list = $db->getall("SELECT * FROM ".table('notice')." where ".$subsite_wheresql."  ORDER BY `sort` DESC,`id` DESC LIMIT 5");	
$smarty->assign('notice_list',$notice_list);
//紧急职位
$emergency_jobs = $db->getall("SELECT id,subsite_id,jobs_name,district_cn,work_start,work_end,wage_amount,companyname,jobspecial_cn,wage_cn,refreshtime FROM ".table('jobs')." WHERE emergency=1 and ".$subsite_wheresql." ORDER BY `refreshtime` DESC,`id` DESC LIMIT 5");
foreach ($emergency_jobs as $key => $value) 
{
	$emergency_jobs[$key]['url'] = wap_url_rewrite("jobs-show",array("id"=>$value['id']),1,$value['subsite_id']);
	$emergency_jobs[$key]['r_time'] = daterange(time(),$value['refreshtime'],'Y-m-d',"#FF3300");
	if ($value['jobspecial_cn'])
	{
		$jobspecial_cn=explode(',',$value['jobspecial_cn']);
		$emergency_jobs[$key]['jobspecial_cn']=$jobspecial_cn;
	}
	else
	{
		$emergency_jobs[$key]['jobspecial_cn']=array();
	}
}
$smarty->assign('emergency_jobs',$emergency_jobs);
//推荐职位
$recommend_jobs = $db->getall("SELECT id,subsite_id,jobs_name,district_cn,work_start,work_end,jobspecial_cn,wage_amount,companyname,wage_cn,refreshtime FROM ".table('jobs')." WHERE recommend=1 and ".$subsite_wheresql." ORDER BY `refreshtime` DESC,`id` DESC LIMIT 5");
foreach ($recommend_jobs as $key => $value) 
{
	$recommend_jobs[$key]['url'] = wap_url_rewrite("jobs-show",array("id"=>$value['id']),1,$value['subsite_id']);
	$recommend_jobs[$key]['r_time'] = daterange(time(),$value['refreshtime'],'Y-m-d',"#FF3300");
	if ($value['jobspecial_cn'])
	{
		$jobspecial_cn=explode(',',$value['jobspecial_cn']);
		$recommend_jobs[$key]['jobspecial_cn']=$jobspecial_cn;
	}
	else
	{
		$recommend_jobs[$key]['jobspecial_cn']=array();
	}
}
$smarty->assign('recommend_jobs',$recommend_jobs);
//最新职位
$postData['page'] = 1;
$postData['size'] = 5;
$postData['order_type'] = 300;
$jobTmp = https_request_api('job/search', $postData);
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
$smarty->assign('new_jobs',$new_jobs);
//名企推荐广告位
$ad_list = $db->getall("SELECT id,img_path,img_url FROM ".table('ad')." WHERE alias='QS_yellowpage'  ORDER BY `show_order` DESC,`id` DESC LIMIT 6");
$smarty->assign('ad_list',$ad_list);
//热门关键字
$sql="select w_word,w_hot from ".table("hotword")." order by w_hot desc limit 15 ";
$hotword_list = $db->getall($sql);
$smarty->assign('hotword',$hotword_list);
//分站
$subsite=get_cache('subsite');
$subsitelist =array();
foreach ($subsite as $key => $value) {
	$subsitelist[] = $value;
}
$smarty->assign('subsitelist',$subsitelist);
$smarty->display("m/m-index.html");
?>