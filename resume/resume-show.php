<?php
 /*
 * 74cms 简历详细页面
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
$alias="QS_resumeshow";
require_once(dirname(__FILE__).'/../include/common.inc.php');

require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$idd=$_GET['id'];

if($_GET['dsf']==""){
if($_SESSION['utype']==1){
	$row2=$db->getone("select * from ".table('personal_jobs_apply')." where resume_id = {$idd} and company_uid='{$_SESSION['uid']}'");
	
	if(empty($row2)){
		$link[0]['text'] = "返回上一页";
		$link[0]['href'] = 'javascript:history.go(-1)';
		showmsg('此简历没有投递您的职位，您无权查看该简历！',0,$link);
	}
}elseif($_SESSION['utype']==2){
	
	if($_SESSION['uid']!=$row3['uid']){
		$link[0]['text'] = "返回上一页";
		$link[0]['href'] = 'javascript:history.go(-1)';
		showmsg('个人会员无权查看别人的简历！',0,$link);
	}
}
}

$xiazaikg=$db->getone("select * from ".table('config')." where name='down_resume_open'");
if(browser()=="mobile" && $_SESSION['iswap']==""){
	header("location:".$_CFG['wap_domain'].'/resume-show.php?id='.intval($_GET['id']));
}

if($mypage['caching']>0){
        $smarty->cache =true;
		$smarty->cache_lifetime=$mypage['caching'];
	}else{
		$smarty->cache = false;
	}
$cached_id=$alias.(isset($_GET['id'])?"|".(intval($_GET['id'])%100).'|'.intval($_GET['id']):'').(isset($_GET['page'])?"|p".intval($_GET['page'])%100:'');
$sql="select * from ".table('resume_comment')." where jlid = {$idd}";
$row=$db->getall($sql);
$sql1="select sgshu,qxshu,fgzshu,uid,id from ".table('resume')." where id = {$idd}";
$row1=$db->getone($sql1);

unset($dbhost,$dbuser,$dbpass,$dbname);
$mypage['tpl']=get_tpl("resume",$_GET['id']).$mypage['tpl'];
$haop=0;$zhongp=0;$chap=0;
foreach($row as $k=>$v){
	if($v["title"]==1){
		$haop += 1;
	}elseif($v["title"]==2){
		$zhongp += 1;
	}elseif($v["title"]==3){
		$chap += 1;
	}
}
$admin=$_SESSION['admin_id'];
$uid1=$_SESSION['uid'];
$uid=$row1['uid'];
$utype=$_SESSION['utype'];
$rowww=$db->getone("select * from ".table('resume')." where id='{$idd}'");
$smarty->assign("uid",$uid);
$smarty->assign("value",$xiazaikg['value']);
$smarty->assign("uid1",$uid1);
$smarty->assign("utype",$utype);
$smarty->assign("admin",$admin);
$smarty->assign("sgshu",$rowww['job_number']);
$smarty->assign("qxshu",$rowww['cancel_sign']);
$smarty->assign("fgzshu",$rowww['fly_number']);
$smarty->assign("haop",$haop);
$smarty->assign("zhongp",$zhongp);
$smarty->assign("chap",$chap);
$smarty->display($mypage['tpl'],$cached_id);
$db->close();
unset($smarty);
?>