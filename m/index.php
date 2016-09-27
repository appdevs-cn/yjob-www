<?php
 /*
 * 74cms ��������ҳ
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
//����
$notice_list = $db->getall("SELECT * FROM ".table('notice')." where ".$subsite_wheresql."  ORDER BY `sort` DESC,`id` DESC LIMIT 5");	
$smarty->assign('notice_list',$notice_list);
//����ְλ
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
//�Ƽ�ְλ
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
//����ְλ
$new_jobs = $db->getall("SELECT id,subsite_id,category,category_cn,subclass,jobs_name,district_cn,companyname,work_start,work_end,wage_amount,jobspecial_cn,wage_cn,refreshtime FROM ".table('jobs')." where ".$subsite_wheresql."  ORDER BY `refreshtime` DESC,`id` DESC LIMIT 5");
foreach ($new_jobs as $key => $value) 
{
	$new_jobs[$key]['url'] = wap_url_rewrite("jobs-show",array("id"=>$value['id']),1,$value['subsite_id']);
	$new_jobs[$key]['r_time'] = daterange(time(),$value['refreshtime'],'Y-m-d',"#FF3300");
	$new_jobs[$key]['work_start'] = date("n.j",$value['work_start']);
	$new_jobs[$key]['work_end'] = date("n.j",$value['work_end']);
	$category_cn=explode('/',$value['category_cn']);
	$count=count($category_cn);
	$ke1=$count-1;
	$new_jobs[$key]['category_cn'] = $category_cn[$ke1];
	if ($value['jobspecial_cn'])
	{
		$jobspecial_cn=explode(',',$value['jobspecial_cn']);
		$new_jobs[$key]['jobspecial_cn']=$jobspecial_cn;
	}
	else
	{
		$new_jobs[$key]['jobspecial_cn']=array();
	}
}
$smarty->assign('new_jobs',$new_jobs);
//�����Ƽ����λ
$ad_list = $db->getall("SELECT id,img_path,img_url FROM ".table('ad')." WHERE alias='QS_yellowpage'  ORDER BY `show_order` DESC,`id` DESC LIMIT 6");
$smarty->assign('ad_list',$ad_list);
//���Źؼ���
$sql="select w_word,w_hot from ".table("hotword")." order by w_hot desc limit 15 ";
$hotword_list = $db->getall($sql);
$smarty->assign('hotword',$hotword_list);
//��վ
$subsite=get_cache('subsite');
$subsitelist =array();
foreach ($subsite as $key => $value) {
	$subsitelist[] = $value;
}
$smarty->assign('subsitelist',$subsitelist);
$smarty->display("m/m-index.html");
?>