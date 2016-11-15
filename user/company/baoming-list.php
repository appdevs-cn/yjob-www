<?php
 /*
 * 74cms 触屏版职位管理模块
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
require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/fun_company.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
wap_weixin_openid($_GET['code']);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'index';
if ($_SESSION['uid']=='' || $_SESSION['username']==''||intval($_SESSION['utype'])==2)
{
	header("Location: ../login.php");
}
$user = get_user_info($_SESSION['uid']);
if($_CFG['login_com_audit_mobile'] && $user['mobile_audit']=="0")
{
	$str= "<script>";
	$str.="alert('请先验证手机！');";
	$str.="window.location.href='account_security.php';";
	$str.= "</script>";
	echo $str;
}
elseif ($act == 'index')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$uid=$_SESSION['uid'];
	/* $uid=$_SESSION['uid'];
	$sqlc="select ksbm from ".table('members')." where uid='{$uid}'";
	$resultc=$db->getone($sqlc);
	$smarty->assign('ksbm',$resultc['ksbm']); */
	if($_POST['zhi']){
		if($_POST['tiaojian']==1){
			$where=" where fullname='{$_POST['zhi']}'";
		}elseif($_POST['tiaojian']==2){
			$where=" where telephone='{$_POST['zhi']}'";
		}
	}else{
		$where="";
	}
	$sql="select * from ".table('resume').$where;
	$sql1="select * from ".table('jobs')." where uid='{$uid}'";
	$sql2="select * from ".table('personal_jobs_apply')." where company_uid=".$uid;
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('resume').$where;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$resume = $db->getall($sql);
	$jobs = $db->getall($sql1);
	$jobs_apply = $db->getall($sql2);
	foreach($resume as $k=>$v){
		foreach($jobs_apply as $k1=>$v1){
			if($v['id']==$v1['resume_id']){
				$resume[$k]['bmzt']=1;
				$resume[$k]['bmid']=$v1['jobs_id'];
			}
		}
	}
	$smarty->assign('act',$act);
	$smarty->assign('title','快速报名');
	$smarty->assign('resume',$resume);
	$smarty->assign('jobs',$jobs);
	
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->display("m/company/m-baoming.html");	
}
elseif ($act=='ksbm_bm')
{
	$resume_id=$_POST['id'];
	$jobs_id=!empty($_POST['zhiwei'])?$_POST['zhiwei']:showmsg("你没有发布职位！",1);
	$uid=$_SESSION['uid'];
	$sql="select * from ".table('resume')." where id='{$resume_id}'";
	$sql1="select * from ".table('jobs')." where id='{$jobs_id}'";
	$sql2="select * from ".table('company_profile')." where uid='{$uid}'";
	$row=$db->getone($sql);
	$row1=$db->getone($sql1);
	$row2=$db->getone($sql2);
	$addarr['resume_id']=$resume_id;
	if(empty($row['sex_cn']) || empty($row['fullname'])){
		exit('此简历基本信息不完整！');
	}
	$addarr['resume_name']=$row["fullname"];
	$addarr['personal_uid']=$row['uid'];
	$addarr['jobs_name']=$row1['jobs_name'];
	$addarr['company_id']=$row2['id'];
	$addarr['company_name']=$row2['companyname'];
	$addarr['apply_addtime']=time();
	$addarr['personal_look']=1;
	$addarr['is_reply']=1;
	$addarr['is_apply']=1;
	$addarr['personal_interview']=0;
	$addarr['company_uid']=$uid;
	$addarr['jobs_id']=$jobs_id;
	
	$result=$db->inserttable(table('personal_jobs_apply'),$addarr,true);
	if($result){
		showmsg("报名成功！",2);
	}
}


?>