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
require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'index';
if (intval($_SESSION['uid'])=='' || $_SESSION['username']==''||intval($_SESSION['utype'])==1)
{
	header("Location: ../login.php");
}
$user = get_user_info($_SESSION['uid']);
if($_CFG['login_per_audit_mobile'] && $user['mobile_audit']=="0" && $act != 'index')
{
	$str= "<script>";
	$str.="alert('请先验证手机！');";
	$str.="window.location.href='account_security.php';";
	$str.= "</script>";
	echo $str;
}
if ($act == 'index')
{
	$smarty->cache = false;
	$cjl="select * from ".table('resume')." where uid=".$_SESSION['uid'];
	$cdjl=$db->getone($cjl);
	$id=$cdjl['id'];
	$user=wap_get_user_info(intval($_SESSION['uid']));	
	$smarty->assign('user',$user);
	$resume_info=get_userprofile(intval($_SESSION['uid']));
	if(empty($resume_info))
	{
		header("Location: ?act=make_resume");
	}
	else
	{
		$resume_info['age']=date("Y")-$resume_info['birthday'];
		//统计简历数
		$smarty->assign('count_resume',count_resume(intval($_SESSION['uid'])));
		$smarty->assign('idp',$id);
		//统计面试邀请对方未查看数
		$smarty->assign('count_interview',count_interview($_SESSION['uid'],2,1));
		$smarty->assign('resume_info',$resume_info);
		$smarty->display("m/personal/m-user-personal-index.html");
	}
}
elseif ($act == 'favorites')
{
	$perpage = 7;
	$count  = 0;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$theurl = "wap_user.php?act=favorites";
	$start = ($page-1)*$perpage;
	$wheresql=" WHERE f.personal_uid='{$_SESSION['uid']}' ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('personal_favorites')." AS f {$wheresql} ";
	$count=$db->get_total($total_sql);
	$joinsql=" LEFT JOIN ".table('jobs')." as  j  ON f.jobs_id=j.id ";
	$smarty->assign('favorites',get_favorites($start,$perpage,$joinsql.$wheresql));
	$smarty->assign('pagehtml',wapmulti($count, $perpage, $page, $theurl));
	$smarty->display('m/personal/m-favorites.html');
}
elseif ($act == 'add_favorites')
{
	$id=isset($_POST['id'])?intval($_POST['id']):exit("err");
	if(intval($_SESSION['utype']!=2)){
		exit("请登录后收藏职位");
	}
        $favData['uid'] = $_SESSION['uid'];
        $favData['job_id'] = $id;
        $favRst = https_request_api("job/favJob/",$favData);
        if(!$favRst['codes']) {
            exit("已收藏");
        } else {
            exit($favRst['msg']);
        }
}
elseif ($act=='del_favorites')
{
	$yid =!empty($_POST['id'])?$_POST['id']:exit("你没有选择项目！");
	if($n=del_favorites($yid,$_SESSION['uid']))
	{
		exit("ok");
	}
	else
	{
		exit("err");
	}
}
// 填写简历
elseif($act == "make_resume")
{
	$smarty->cache = false;
	$uid=intval($_SESSION['uid']);
	$user=wap_get_user_info(intval($_SESSION['uid']));
	$smarty->assign('user',$user);
	$smarty->assign('userprofile',get_userprofile($_SESSION['uid']));
	$smarty->display('m/personal/m-make-resume.html');
}
elseif($act == "make_resume_save")
{	
	$_POST=array_map("utf8_to_gbk",$_POST);
	$setsqlarr['uid']=$_SESSION['uid'];
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):exit("请填写真实姓名");
	$setsqlarr['title']=trim($_POST['fullname'])."的简历";
	$setsqlarr['display_name']=1;
	$setsqlarr['sex']=trim($_POST['sex'])?trim($_POST['sex']):exit("请选择性别");
	$setsqlarr['sex_cn']=trim($_POST['sex_cn'])?trim($_POST['sex_cn']):exit("请选择性别");
	$setsqlarr['birthdate']=intval($_POST['birthdate'])?intval($_POST['birthdate']):exit("请选择出生年份");
	$setsqlarr['education']=intval($_POST['education'])?intval($_POST['education']):exit("请选择获得学历");
	$setsqlarr['education_cn']=trim($_POST['education_cn'])?trim($_POST['education_cn']):exit("请选择获得学历");
	$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):exit("请选择工作经验");
	$setsqlarr['experience_cn']=trim($_POST['experience_cn'])?trim($_POST['experience_cn']):exit("请选择工作经验");
	$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):exit("请填写邮箱");
	$setsqlarr['email_notify']=$_POST['email_notify']=="1"?1:0;
	$setsqlarr['telephone']=trim($_POST['telephone'])?trim($_POST['telephone']):exit("请填写手机");
	$setsqlarr['current']=intval($_POST['current'])?intval($_POST['current']):exit("请选择目前状态");
	$setsqlarr['current_cn']=trim($_POST['current_cn'])?trim($_POST['current_cn']):exit("请选择目前状态");
	$setsqlarr['intention_jobs']=trim($_POST['intention_jobs'])?trim($_POST['intention_jobs']):exit("请选择期望职位");
	$_POST['intention_jobs_id']=trim($_POST['intention_jobs_id'])?trim($_POST['intention_jobs_id']):exit("请选择期望职位");
	$setsqlarr['trade']=trim($_POST['trade'])?trim($_POST['trade']):exit("请选择期望行业");
	$setsqlarr['trade_cn']=trim($_POST['trade_cn'])?trim($_POST['trade_cn']):exit("请选择期望行业");
	$setsqlarr['subsite_id']=intval($_POST['subsite_id']);
	$setsqlarr['district']=trim($_POST['district']);
	$setsqlarr['sdistrict']=intval($_POST['sdistrict']);
	$setsqlarr['district_cn']=trim($_POST['district_cn'])?trim($_POST['district_cn']):exit("期望工作地区");
	/*$setsqlarr['nature']=intval($_POST['nature'])?intval($_POST['nature']):exit("请选择工作性质");
	$setsqlarr['nature_cn']=trim($_POST['nature_cn'])?trim($_POST['nature_cn']):exit("请选择工作性质");*/
	$setsqlarr['wage']=intval($_POST['wage'])?intval($_POST['wage']):exit("请选择期望薪资");
	$setsqlarr['wage_cn']=trim($_POST['wage_cn'])?trim($_POST['wage_cn']):exit("请选择期望薪资");
	// $setsqlarr['specialty']=trim($_POST['specialty'])?trim($_POST['specialty']):exit("请填写自我描述");
	$auto_refresh=intval($_POST['auto_refresh']);
	$auto_apply=intval($_POST['auto_apply']);
	$setsqlarr['refreshtime']=time();
	$setsqlarr['audit']=intval($_CFG['audit_resume']);
	//1->PC  2->APP  3->wap
	$setsqlarr['resume_from_pc']=3;
	$total=$db->get_total("SELECT COUNT(*) AS num FROM ".table('resume')." WHERE uid='{$_SESSION['uid']}'");
	if ($total>=intval($_CFG['resume_max']))
	{
	exit("您最多可以创建{$_CFG['resume_max']} 份简历,已经超出了最大限制！");
	}
	else
	{
	$setsqlarr['addtime']=time();
	$pid=$db->inserttable(table('resume'),$setsqlarr,1);
	$searchtab['id'] = $pid;
	$searchtab['uid'] = intval($_SESSION['uid']);
	
	$db->inserttable(table('resume_search_key'),$searchtab);
	$db->inserttable(table('resume_search_rtime'),$searchtab);
	if (empty($pid))exit("保存失败！");
	// 3天内自动刷新
	if($auto_refresh==1)
	{
		$time=time();
		$auto_refresh_row=$db->getone("select * from  ".table("resume_auto_refresh")." where  resume_id=".$pid." and  deadline_time>$time limit 1 ");
		$setarr['deadline_time']=$time+3600*24*3;
		if(empty($auto_refresh_row))
		{   
			$setarr['resume_id']=$pid;
			$db->inserttable(table("resume_auto_refresh"),$setarr);
		}
		else
		{
			$db->updatetable(table("resume_auto_refresh"),$setarr,array("resume_id"=>$pid));
		}
	}
	// 3天内 自动投递
	if($auto_apply==1)
	{
		$time=time();
		$auto_apply_row=$db->getone("select * from ".table("resume_entrust")." where id=$pid and uid=".$_SESSION['uid']." and entrust_end>$time ");
		if(empty($auto_apply_row))
		{
			$setarr_apply['id']=$pid;
			$setarr_apply['uid']=$_SESSION['uid'];
			$setarr_apply['fullname']=$setsqlarr['fullname'];
			$setarr_apply['entrust']=1;
			$setarr_apply['entrust_start']=time();
			$setarr_apply['entrust_end']=$time+3600*24*3;;
			$setarr_apply['isshield']=0;
			$setarr_apply['resume_addtime']=time();
			$db->inserttable(table("resume_entrust"),$setarr_apply);
			$db->query("update ".table("resume")." set entrust=1 where id=$pid and uid=".$_SESSION['uid']);
		}
	}

	if(!wap_add_resume_jobs($pid,intval($_SESSION['uid']),$_POST["intention_jobs_id"]))exit('err');
	check_resume($_SESSION['uid'],$pid);
	if(intval($_POST['entrust'])){
		set_resume_entrust($pid);
	}

	// 查看操作记录表 统计创建简历积分所奖励积分  判断是否超过上限   若没超过上限 则继续添加积分
	$today=mktime(0, 0, 0,date('m'), date('d'), date('Y'));
	$info=$db->getone("SELECT sum(points) as num FROM ".table('members_handsel')." WHERE uid ='{$_SESSION['uid']}' AND htype='createresume' AND addtime>{$today} ");
	if(intval($info['num']) >= intval($_CFG['create_resume_points_max']))
	{
		write_memberslog($_SESSION['uid'],2,1101,$_SESSION['username'],"创建了简历");
	}
	else
	{
		$points_rule=get_cache('points_rule');
		$user_points=get_user_points($_SESSION['uid']);
		if ($points_rule['create_resume']['value']>0)
		{
			$time=time();
			$members_handsel_arr['uid']=$_SESSION['uid'];
			$members_handsel_arr['htype']="createresume";
			$members_handsel_arr['points']=$points_rule['create_resume']['value'];
			$members_handsel_arr['addtime']=$time;
			$db->inserttable(table("members_handsel"),$members_handsel_arr);
			report_deal($_SESSION['uid'],$points_rule['create_resume']['type'],$points_rule['create_resume']['value']);
			$user_points=get_user_points($_SESSION['uid']);
			$operator=$points_rule['create_resume']['type']=="1"?"+":"-";
			write_memberslog($_SESSION['uid'],2,9001,$_SESSION['username'],"创建了简历：<strong>{$setsqlarr['title']}</strong>，({$operator}{$points_rule['create_resume']['value']})，(剩余:{$user_points})",2,1101,"创建了简历","{$operator}{$points_rule['create_resume']['value']}","{$user_points}");
		}
		else
		{
			write_memberslog($_SESSION['uid'],2,1101,$_SESSION['username'],"创建了简历");
		}
	}
	
	if(!get_userprofile(intval($_SESSION['uid']))){
		$infoarr['realname']=$setsqlarr['fullname'];
		$infoarr['sex']=$setsqlarr['sex'];
		$infoarr['sex_cn']=$setsqlarr['sex_cn'];
		$infoarr['birthday']=$setsqlarr['birthdate'];
		$infoarr['residence']=$setsqlarr['residence'];
		$infoarr['residence']=$setsqlarr['residence'];
		$infoarr['education']=$setsqlarr['education'];
		$infoarr['education_cn']=$setsqlarr['education_cn'];
		$infoarr['experience']=$setsqlarr['experience'];
		$infoarr['experience_cn']=$setsqlarr['experience_cn'];
		$infoarr['phone']=$setsqlarr['telephone'];
		$infoarr['email']=$setsqlarr['email'];
		$infoarr['uid']=intval($_SESSION['uid']);
		$db->inserttable(table('members_info'),$infoarr);
	}
	baidu_submiturl(url_rewrite('QS_resumeshow',array('id'=>$pid)),'addresume');
	echo $pid;
	// header("Location: ?act=resume_success&pid=".$pid);
	}
}
// 填写简历完成
elseif($act == "resume_success")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$sql="select j.* from ".table("jobs")." as j left join ".table("resume_jobs")." as r on r.category=j.category where r.pid=$id limit 5";
	$resume_jobs=$db->getall($sql);
	$smarty->assign('resume_jobs',$resume_jobs);
	$smarty->display('m/personal/create-resume-success.html');
}
// 简历列表
elseif($act == "resume_list")
{	
	$smarty->cache = false;
	/* $wheresql=" WHERE uid='".intval($_SESSION['uid'])."' ";
	$sql="SELECT * FROM ".table('resume').$wheresql;
	$resume_list=get_resume_list($sql,12,true,true,true);
	$smarty->assign('resume_list',$resume_list); */
	$sql_one = "select * from ".table('resume')." where uid='{$_SESSION['uid']}'";
	$resule_one = $db->getone($sql_one);
	$pid = $resule_one['id'];
	/* if($resule_one){
		header("Location: ?act=resume_one&pid=".$pid);
	}else{
		$smarty->display('m/personal/m-resumelist.html');
	} */
	header("Location: ?act=resume_one&pid=".$pid);
	
}
// 完善简历
elseif($act == "resume_one")
{
	$smarty->cache = false;
	
	$id=empty($_GET['pid'])?'0':intval($_GET['pid']);
	
	$resume_one=resume_one($id);
	/* var_dump($jianzhi);
	var_dump($quanzhi);
	exit(); */
	//$smarty->assign('resume_one',$resume_one);
	
	$smarty->assign('resume_one',$resume_one);
	$smarty->assign('resume_basic',get_resume_basic(intval($_SESSION['uid']),$id));
	$smarty->assign('resume_jobs',get_resume_jobs($id));
/* 	$smarty->assign('resume_education',get_resume_education(intval($_SESSION['uid']),$id));
	$smarty->assign('resume_work',get_resume_work(intval($_SESSION['uid']),$id));
	$smarty->assign('resume_training',get_resume_training(intval($_SESSION['uid']),$id)); */
	$smarty->display('m/personal/m-comlpete-resume.html');
}
elseif($act == "resume_basic")
{

	$smarty->cache = false;
	$cjl="select * from ".table('resume')." where uid=".$_SESSION['uid'];
	$cdjl=$db->getone($cjl);
	$id=intval($cdjl['id']);
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),$id);
	$resume_one=resume_one($id);
	
	$xinxi=$db->getone("select mobile from ".table('members')." where uid='{$_SESSION['uid']}'");

	$resume_basic['telephone']=$xinxi['mobile'];
	$smarty->assign('userprofile',get_userprofile(intval($_SESSION['uid'])));
	$smarty->assign('pkid',$id);
	$smarty->assign('resume_basic',$resume_basic);
	$smarty->assign('resume_one',$resume_one);
	$smarty->display('m/personal/m-personal-info.html');
}
elseif($act == "resume_basic_save")
{
	$smarty->cache = false;
	$_POST=array_map("utf8_to_gbk",$_POST);
	$setsqlarr['uid']=intval($_SESSION['uid']);
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):exit("请填写真实姓名");
	$setsqlarr['display_name']=intval($_POST['display_name']);
	$setsqlarr['sex']=trim($_POST['sex'])?trim($_POST['sex']):exit("请选择性别");
	$setsqlarr['sex_cn']=trim($_POST['sex_cn'])?trim($_POST['sex_cn']):exit("请选择性别");
	$setsqlarr['birthdate']=intval($_POST['birthdate'])?intval($_POST['birthdate']):exit("请选择出生年份");
	//$setsqlarr['residence']=trim($_POST['residence'])?trim($_POST['residence']):exit("请选择现居住地");
	//$setsqlarr['residence']=trim($_POST['residence'])?trim($_POST['residence']):exit("请选择现居住地");
	//$setsqlarr['education']=intval($_POST['education'])?intval($_POST['education']):exit("请选择获得学历");
	//$setsqlarr['education_cn']=trim($_POST['education_cn'])?trim($_POST['education_cn']):exit("请选择获得学历");
	//$setsqlarr['major']=intval($_POST['major'])?intval($_POST['major']):exit("请选择专业");
	//$setsqlarr['major_cn']=trim($_POST['major_cn'])?trim($_POST['major_cn']):exit("请选择专业");
	//$setsqlarr['experience']=intval($_POST['experience'])?intval($_POST['experience']):exit("请选择工作经验");
	//$setsqlarr['experience_cn']=trim($_POST['experience_cn'])?trim($_POST['experience_cn']):exit("请选择工作经验");
	//$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):'';
	
	/* if($setsqlarr['email']){
		if(!preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$setsqlarr['email']))
		{
			exit("邮箱格式错误");
		}
	} */
	
	$setsqlarr['current']=trim($_POST['current']);
	$setsqlarr['current_cn']=trim($_POST['current_cn']);
	if($_POST['current']==300){
		$setsqlarr['studyschool']=!empty($_POST['schoolname'])?trim($_POST['schoolname']):exit('请输入学校名称');
		$setsqlarr['biyetime']=!empty($_POST['biyeshijian'])?intval($_POST['biyeshijian']):exit('请输入毕业时间');
	}
	$setsqlarr['email_notify']=$_POST['email_notify']=="1"?1:0;
	$setsqlarr['telephone']=trim($_POST['telephone']);
	if(!preg_match("/^(13|15|14|17|18)\d{9}$/",$setsqlarr['telephone']))
	{
		exit("手机格式错误");
	}
	$setsqlarr['height']=trim($_POST['height']);
	$setsqlarr['specialty']=$_POST['miaoshu'];
	$setsqlarr['nickname']=trim($_POST['nickname'])?trim($_POST['nickname']):exit("请选择昵称");
	$setsqlarr['householdaddress']=trim($_POST['householdaddress']);
	//$setsqlarr['marriage']=intval($_POST['marriage']);
	//$setsqlarr['marriage_cn']=trim($_POST['marriage_cn']);
	$setatt['height']=$setsqlarr['height'];
	$setatt['realname']=$setsqlarr['fullname'];
	$setatt['phone']=$setsqlarr['telephone'];
	$setatt['sex']=$setsqlarr['sex'];
	$setatt['sex_cn']=$setsqlarr['sex_cn'];
	$setatt['birthday']=$setsqlarr['birthdate'];
	$setatt['householdaddress']=$setsqlarr['householdaddress'];
	$setatt['email']=$setsqlarr['email'];
	$cjl="select * from ".table('resume')." where uid=".$_SESSION['uid'];
	$cdjl=$db->getone($cjl);
	if(empty($cdjl)){
		if(!$db->inserttable(table('resume'),$setsqlarr))exit('err90');
		
	}else{
		$id=intval($cdjl['id']);
		$db->updatetable(table('resume'),$setsqlarr," id='".$id."'  AND uid='{$setsqlarr['uid']}'");
	}
	
	$db->updatetable(table('members_info'),$setatt," uid='".$_SESSION['uid']."'");
	$cxsearch=$db->query("select * from ".table('resume_search_rtime')." where uid=".$_SESSION['uid']);
	if(empty($cxsearch)){
		
		$searchtab['id'] = $_POST['pid'];
		$searchtab['uid'] = $_SESSION['uid'];
		$searchtab['subsite_id'] =0;
		$searchtab['display'] = 1;
		$searchtab['audit'] = 1;
		if(!$db->inserttable(table('resume_search_key'),$searchtab))exit('err44');
		if(!$db->inserttable(table('resume_search_rtime'),$searchtab))exit('err55');
	}
	check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
	if($_CFG['audit_edit_resume']!="-1"){
		set_resume_entrust(intval($_REQUEST['pid']));
	}
	write_memberslog($_SESSION['uid'],2,1105,$_SESSION['username'],"修改了简历({$_POST['title']})");

	$infoarr['realname']=$setsqlarr['fullname'];
	$infoarr['sex']=$setsqlarr['sex'];
	$infoarr['sex_cn']=$setsqlarr['sex_cn'];
	$infoarr['birthday']=$setsqlarr['birthdate'];
	$infoarr['residence']=$setsqlarr['residence'];
	$infoarr['education']=$setsqlarr['education'];
	$infoarr['education_cn']=$setsqlarr['education_cn'];
	$infoarr['major']=$setsqlarr['major'];
	$infoarr['major_cn']=$setsqlarr['major_cn'];
	$infoarr['experience']=$setsqlarr['experience'];
	$infoarr['experience_cn']=$setsqlarr['experience_cn'];
	$infoarr['phone']=$setsqlarr['telephone'];
	$infoarr['email']=$setsqlarr['email'];
	$infoarr['height']=$setsqlarr['height'];
	$infoarr['householdaddress']=$setsqlarr['householdaddress'];
	$infoarr['marriage']=$setsqlarr['marriage'];
	$infoarr['marriage_cn']=$setsqlarr['marriage_cn'];
	$infoarr['uid']=intval($_SESSION['uid']);
	$db->updatetable(table('members_info'),$infoarr," uid={$infoarr['uid']} ");
	exit("ok");
}
// 求职意向 职位
elseif($act == "resume_jobs")
{
	$smarty->cache = false;
	$id=$_GET['pid'];
	$resume_one=resume_one($id);
	$jianzhi=$db->getall("select id,categoryname from ".table('category_jobs')." where parentid=1065");
	$quanzhi=$db->getall("select id,categoryname from ".table('category_jobs')." where parentid=1066");
	$smarty->assign('jianzhi',$jianzhi);
	$smarty->assign('quanzhi',$quanzhi);
	$smarty->assign('resume_one',$resume_one);
	$resume_jobs = get_resume_jobs($id);
	if ($resume_jobs)
	{
		foreach($resume_jobs as $rjob)
		{
		$jobsid[]=$rjob['topclass'].".".$rjob['category'].".".$rjob['subclass'];
		}
		$resume_jobs_id=implode(",",$jobsid);
	}
	$smarty->assign('resume_jobs_id',$resume_jobs_id);
	$smarty->display('m/personal/m-want-job.html');
}
elseif($act == "resume_jobs_save")
{
	
	
	$smarty->cache = false;
	$_POST=array_map("utf8_to_gbk",$_POST);
	
	/* $setsqlarr['current']=trim($_POST['current'])?trim($_POST['current']):exit("请选择目前状态");
	$setsqlarr['current_cn']=trim($_POST['current_cn'])?trim($_POST['current_cn']):exit("请选择目前状态"); */
	$setsqlarr['intention_jobs']=trim($_POST['intention_jobs'])?trim($_POST['intention_jobs']):exit("请选择期望职位");
	$_POST['intention_jobs_id']=trim($_POST['intention_jobs_id'])?trim($_POST['intention_jobs_id']):exit("请选择期望职位");
	//var_dump($_POST['intention_jobs_id']);exit();
	//$setsqlarr['wage']=trim($_POST['wage'])?trim($_POST['wage']):exit("请选择期望薪资");
	//$setsqlarr['wage_cn']=trim($_POST['wage_cn'])?trim($_POST['wage_cn']):exit("请选择期望薪资");
	//$setsqlarr['nature']=trim($_POST['nature'])?trim($_POST['nature']):exit("请选择期望工作性质");
	//$setsqlarr['nature_cn']=trim($_POST['nature_cn'])?trim($_POST['nature_cn']):exit("请选择期望工作性质");
	$setsqlarr['trade']=trim($_POST['trade'])?trim($_POST['trade']):exit("请选择期望行业");
	$setsqlarr['trade_cn']=trim($_POST['trade_cn'])?trim($_POST['trade_cn']):exit("请选择期望行业");
	$setsqlarr['subsite_id']=trim($_POST['subsite_id']);
	$setsqlarr['district']=trim($_POST['district']);
	$setsqlarr['sdistrict']=trim($_POST['sdistrict']);
	$setsqlarr['current']=intval($_POST['current']);
	$setsqlarr['current_cn']=intval($_POST['current_cn']);
	$setsqlarr['district_cn']=trim($_POST['district_cn'])?trim($_POST['district_cn']):exit("请选择期望工作地区");
	/* if($_POST['current']==300){
		$setsqlarr['studyschool']=!empty($_POST['schoolname'])?utf8_to_gbk(trim($_POST['schoolname'])):exit('请输入学校名称');
		$setsqlarr['biyetime']=!empty($_POST['biyeshijian'])?$_POST['biyeshijian']:exit('请输入毕业时间');
	} */
	if(!$db->updatetable(table('resume'),$setsqlarr,array("id"=>intval($_POST['pid']),"uid"=>intval($_SESSION['uid']))))exit("err");
	$cxsearch=$db->getone("select * from ".table('resume_search_rtime')." where uid=".$_SESSION['uid']);
	if(empty($cxsearch)){
		
		$searchtab['id'] = $_REQUEST['pid'];
		$searchtab['uid'] = $_SESSION['uid'];
		if($setsqlarr['subsite_id']){
			$searchtab['subsite_id'] =$setsqlarr['subsite_id'];
		}else{
			$searchtab['subsite_id'] =0;
		}
		
		$searchtab['display'] = 1;
		$searchtab['audit'] = 1;
		if(!$db->inserttable(table('resume_search_key'),$searchtab))exit("err00");
		if(!$db->inserttable(table('resume_search_rtime'),$searchtab))exit("err11");
	}else{
		if($setsqlarr['subsite_id']){
			$searchtab['subsite_id'] =$setsqlarr['subsite_id'];
		}else{
			$searchtab['subsite_id'] =0;
		}
		if(!$db->query("update ".table('resume_search_key')." set subsite_id=".$searchtab['subsite_id']." where id=".$_REQUEST['pid']))exit("err22");
		if(!$db->query("update ".table('resume_search_rtime')." set subsite_id=".$searchtab['subsite_id']." where id=".$_REQUEST['pid']))exit("err33");
	}
	if(!wap_add_resume_jobs(intval($_POST['pid']),intval($_SESSION['uid']),$_POST['intention_jobs_id']))exit('err');
	if(!wap_add_resume_trade(intval($_POST['pid']),intval($_SESSION['uid']),$setsqlarr['trade']))exit('err');
	exit("ok");
}
//  工作经验
elseif($act == "resume_work_list")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_work_list=get_resume_work(intval($_SESSION['uid']),$id);
	$smarty->assign('resume_work',$resume_work_list);
	$smarty->display('m/personal/m-work-experience.html');
}
// 添加 修改 工作经验
elseif($act == "resume_work_add")
{	
	$smarty->cache = false;
	$id=intval($_GET['id']);
	$resume_work=get_this_work(intval($_SESSION['uid']),$id);
	if($resume_work){
		$smarty->assign('resume_work',$resume_work);
	}else{
		$smarty->assign('resume_work',false);
	}
	$smarty->display('m/personal/m-edit-work-experience.html');
}
elseif($act == "resume_work_save")
{
	$_POST=array_map("utf8_to_gbk",$_POST);
	// print_r($_POST);die;
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_POST['pid']);

	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 )exit('简历不存在');

	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_POST['pid']));
	if (empty($resume_basic)) exit('请先填写简历基本信息');
	$resume_work=get_resume_work($_SESSION['uid'],intval($_POST['pid']));
	if (count($resume_work)>=6)  exit('工作经历不能超过6条');
	$setsqlarr['companyname'] = trim($_POST['companyname'])?trim($_POST['companyname']):exit('请填写公司名称！');
	$setsqlarr['jobs'] = trim($_POST['jobs'])?trim($_POST['jobs']):exit("请填写职位名称！");
	if(trim($_POST['startyear'])==""||trim($_POST['startmonth'])==""||trim($_POST['endyear'])==""){
		exit("请选择任职时间!");
	}
	$setsqlarr['startyear'] = intval($_POST['startyear']);
	$setsqlarr['startmonth'] = intval($_POST['startmonth']);
	//至今 情况
	if(intval($_POST['endyear']) == -1)
	{
		$setsqlarr['endyear'] = 0;
		$setsqlarr['endmonth'] = 0;
		$setsqlarr['todate'] = 1;
	}
	else
	{
		$setsqlarr['endyear'] = intval($_POST['endyear']);
		$setsqlarr['endmonth'] = intval($_POST['endmonth']);
		$setsqlarr['todate'] = 0;
	}
	$setsqlarr['achievements'] = trim($_POST['achievements'])?trim($_POST['achievements']):exit("请填写工作职责！");
	
	if($id){
		$db->updatetable(table("resume_work"),$setsqlarr,array("id"=>$id,"uid"=>intval($_SESSION['uid'])));
		exit("ok");
	}else{
		$insert_id = $db->inserttable(table("resume_work"),$setsqlarr,1);
		if($insert_id){
			check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
			perfect_resume($_SESSION['uid'],$_SESSION['username'],$_REQUEST['pid'],1);
			exit("ok");
		}else{
			exit("err");
		}
	}
}
elseif($act == "resume_work_del")
{
	$smarty->cache = false;
	$id=intval($_GET['work_id']);
	$uid=intval($_SESSION["uid"]);
	$sql="delete from ".table("resume_work")." where id=$id and uid=$uid ";
	if($db->query($sql)){
		perfect_resume($_SESSION['uid'],$_SESSION['username'],$id,2);
		exit("ok");
	}else{
		exit("err");
	}
}
// 教育经历
elseif($act == "resume_education")
{	
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_education_list=get_resume_education(intval($_SESSION['uid']),$id);
	// var_dump($resume_education_list);
	$smarty->assign("resume_education_list",$resume_education_list);
	$smarty->display('m/personal/m-edu-experience.html');
}
// 添加 修改 教育经历
elseif($act == "resume_education_add")
{	
	$smarty->cache = false;
	$id=intval($_GET["id"]);
	$resume_edu=get_this_education(intval($_SESSION['uid']),$id);
	if($resume_edu){
		$smarty->assign('resume_edu',$resume_edu);
	}else{
		$smarty->assign('resume_edu',false);
	}
	$smarty->display('m/personal/m-edit-edu-experience.html');
}
elseif($act == "resume_education_save")
{
	// print_r($_POST);die;
	$_POST=array_map("utf8_to_gbk",$_POST);
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_POST['pid']);
	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 )exit('简历不存在');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_POST['pid']));
	if (empty($resume_basic)) exit('请先填写简历基本信息');
	$resume_education=get_resume_education($_SESSION['uid'],intval($_POST['pid']));
	if (count($resume_education)>=6)  exit('教育经历不能超过6条');
	$setsqlarr['school'] = trim($_POST['school'])?trim($_POST['school']):exit('请填写学校名称！');
	$setsqlarr['speciality'] = trim($_POST['speciality'])?trim($_POST['speciality']):exit("请填写专业名称！");
	if(trim($_POST['startyear'])==""||trim($_POST['startmonth'])==""||trim($_POST['endyear'])==""){
		exit("请选择就读时间！");
	}
	$setsqlarr['startyear'] = intval($_POST['startyear']);
	$setsqlarr['startmonth'] = intval($_POST['startmonth']);
	//至今 情况
	if(intval($_POST['endyear']) == -1)
	{
		$setsqlarr['endyear'] = 0;
		$setsqlarr['endmonth'] = 0;
		$setsqlarr['todate'] = 1;
	}
	else
	{
		$setsqlarr['endyear'] = intval($_POST['endyear']);
		$setsqlarr['endmonth'] = intval($_POST['endmonth']);
		$setsqlarr['todate'] = 0;
	}
	$setsqlarr['education'] = trim($_POST['education'])?trim($_POST['education']):exit("请选择获得学历");
	$setsqlarr['education_cn'] = trim($_POST['education_cn'])?trim($_POST['education_cn']):exit("请选择获得学历");
	if($id){
		$db->updatetable(table("resume_education"),$setsqlarr,array("id"=>$id,"uid"=>intval($_SESSION['uid'])));
		exit("ok");
	}else{
		$insert_id = $db->inserttable(table("resume_education"),$setsqlarr,1);
		if($insert_id){
			check_resume(intval($_SESSION['uid']),intval($_REQUEST['pid']));
			perfect_resume($_SESSION['uid'],$_SESSION['username'],$_REQUEST['pid'],1);
			exit("ok");
		}else{
			exit("err");
		}
	}
}
// 删除教育经历
elseif($act == "resume_education_del")
{
	$smarty->cache = false;
	$id=intval($_GET['education_id']);
	$uid=intval($_SESSION["uid"]);
	$sql="delete from ".table("resume_education")." where id=$id and uid=$uid ";
	if($db->query($sql)){
		perfect_resume($_SESSION['uid'],$_SESSION['username'],$id,2);
		exit("ok");
	}else{
		exit("err");
	}
}
// 培训经历 
elseif($act == "resume_train")
{
    $smarty->cache = false;
    $id=intval($_GET['pid']);
    $resume_train_list=get_resume_training(intval($_SESSION['uid']),$id);
    $smarty->assign("resume_train_list",$resume_train_list);
    $smarty->display('m/personal/m-train-experience.html');
}
elseif($act == "work_card") {
    if($_GET['id']) {
		// 获取职位报名信息
        $einfo = https_request_api('enroll/info', array('enroll_id' => $_GET['id']));
        if($einfo['codes'] || empty($einfo['data'])) {
          showmsg($einfo['msg']);  
        }
        $job_info_id = $einfo['data']['job_info_id'];
		// 获取职位详情
        $pyInfo = https_request_api('job/jobPtInfo', array('job_info_id' => $job_info_id));

        if($pyInfo['codes']) {
            showmsg($pyInfo['msg']);  
        }
		// 获取督导信息
        if($pyInfo['data']['dd_uid']) {
            $ddInfo = get_user_info($pyInfo['data']['dd_uid']);
        }
		if($ddInfo) {
			$cjl = "select fullname from " . table('resume') . " where uid=" . $ddInfo['uid'];
			$cdjl = $db->getone($cjl);
		}
		if($cdjl){
			$pyInfo['data']['dd_name'] = $cdjl['fullname'];
		}else {
			$pyInfo['data']['dd_name'] = '';
		}
        $pyInfo['data']['dd_mobile'] = $ddInfo['mobile'];
        $pyInfo['data']['job_info_id'] = $job_info_id;
        $pyInfo['data']['enroll_id'] = $_GET['id'];
        $jobInfoTmp = https_request_api('job/info/'.$pyInfo['data']['job_id']);
        if(!$jobInfoTmp['data']) {
            showmsg($jobInfoTmp['msg']);  
        }
        $signList = https_request_api('job/pastList', array('job_info_id' => $job_info_id, 'uid' => $einfo['data']['uid']));
        if($signList['data']['list']) {
            foreach($signList['data']['list'] as $sk => $sv) {
                if($sv['sign_type'] == 100) {
                    if($einfo['data']['work_date'] == $sv['work_date']) {
                        $signIned = true;
                    }
                    $sv['sign_time'] = date('m月d日 H:i:s', $sv['sign_time']);
                    $signIn[] = $sv;
                } elseif($sv['sign_type'] == 200) {
                    if($einfo['data']['work_date'] == $sv['work_date']) {
                        $signOuted = true;
                    }
                    $sv['sign_time'] = date('m月d日 H:i:s', $sv['sign_time']);
                    $signOut[] = $sv;
                }
            }
        }
        $where['uid'] = $_SESSION['uid'];
        $where['job_id'] = $pyInfo['data']['job_id'];
        $where['job_info_id'] = $pyInfo['data']['id'];
        $where['enroll_type'] = 200;
        $workListTmp = https_request_api('/enroll/list',$where);
        if($workListTmp['data']['list']) {
            foreach($workListTmp['data']['list'] as $wk => $v) {
                $workInfo['status'] = $v['status'];
                $workInfo['work_date'] = $v['work_date'];
                $workInfo['create_time'] = $v['create_time'];
                $workList[] = $workInfo;
                if(date('Ymd', $v['work_date']) == date('Ymd', strtotime("+1 days", time()))) {
                    $isxy = true;
                }
            }
        } else {
            $workList = [];
        }
    }
    $smarty->assign('isxy', $isxy);
    $smarty->assign('companyId', $jobInfoTmp['data']['company_id']);
    $smarty->assign('workList', $workList);
//    $smarty->assign('signOuted', $signOuted ? $signOuted : false);
//    $smarty->assign('signIned', $signIned ? $signIned : false);
    $smarty->assign('xxDate', strtotime("+1 days", time()));
    $smarty->assign('signInList', $signIn);
//	var_dump($signIn);exit;
	$smarty->assign('signOutList', $signOut ? $signOut : array());
    $smarty->assign('ptInfo', $pyInfo['data']);
	if($_GET['type'] == 'success'){
		$smarty->assign('status', 'success');
	}elseif($_GET['type'] == 'tui'){
		$smarty->assign('status', 'tui');
	}elseif($_GET['type'] == 'false'){
		$smarty->assign('status', 'false');
	}
	$smarty->assign('rewrite','work_card');
	$smarty->assign('rewrite_id',$_GET['id']);
    $smarty->display('m/personal/m-work-card.html');
}elseif($act == "work_manage") {
    if($_GET['id']) {
        $einfo = https_request_api('enroll/info', array('enroll_id' => $_GET['id']));
        if($einfo['codes'] || empty($einfo['data'])) {
          showmsg($einfo['msg']);  
        }
        $job_info_id = $einfo['data']['job_info_id'];
        $pyInfo = https_request_api('job/jobPtInfo', array('job_info_id' => $job_info_id));
        if($pyInfo['codes']) {
            showmsg($pyInfo['msg']);  
        }
       
        $sdata['job_id'] = $pyInfo['data']['job_id'];
        $sdata['job_info_id'] = $pyInfo['data']['id'];
        $statisticsRst = https_request_api('job/jobStatistics', $sdata);
        $statistics = $statisticsRst['data']['list'] ? current($statisticsRst['data']['list']) : array();
    }
	$statistics['total_rate'] = sprintf("%.2f", $statistics['total_rate']);  // 保留两位小数点
    $smarty->assign('statistics', $statistics ? $statistics : array());
    $smarty->assign('ptInfo', $pyInfo['data']);
	$smarty->assign('rewrite_id',$_GET['id']);
	$smarty->assign('rewrite',"work_manage");
    $smarty->display('m/personal/m-work-manage.html');
}
elseif($act == "signIn_manage") {
    if($_GET['id']) {
        $job_info_id = $_GET['id'];
        $ptInfo = https_request_api('job/jobPtInfo', array('job_info_id' => $job_info_id));
        if($ptInfo['codes']) {
            showmsg($ptInfo['msg']);  
        }
		if($ptInfo['data']['dd_uid']) {
			$ddInfo = get_user_info($ptInfo['data']['dd_uid']);
		}
		if($ddInfo) {
			$cjl = "select fullname from " . table('resume') . " where uid=" . $ddInfo['uid'];
			$cdjl = $db->getone($cjl);
		}
		if($cdjl){
			$ptInfo['data']['dd_name'] = $cdjl['fullname'];
		}else {
			$ptInfo['data']['dd_name'] = '';
		}
        $ptInfo['data']['dd_mobile'] = $ddInfo['mobile'];
        $ptInfo['data']['job_info_id'] = $job_info_id;
        $jobInfoTmp = https_request_api('job/info/'.$ptInfo['data']['job_id']);
        if(!isset($jobInfoTmp['data']) || !$jobInfoTmp['data']) {
            showmsg($jobInfoTmp['msg']);  
        }

        $days = intval(ceil(($ptInfo['data']['end_date']-$ptInfo['data']['start_date'])/ 86400));
        if($days > 0) {
            for($i = 0;$i < $days; $i++) {
                $ptInfo['data']['work_date'][] = strtotime('+'.$i.' days', $ptInfo['data']['start_date']);
            }
        }
        $jobInfo = $jobInfoTmp['data'];
        $ptInfo['data']['job_name'] = $jobInfo['job_name'];
       
        $sdata['job_id'] = $ptInfo['data']['job_id'];
        $sdata['job_info_id'] = $ptInfo['data']['id'];
        $sdata['type'] = $_GET['type'] ? $_GET['type'] : 100;
        $_GET['work_date'] && $sdata['date'] = $_GET['work_date'];
        switch ($_GET['status']) {
            case 1 : 
                $sdata['show_type'] = 200;
            case 2 :
                $sdata['status'] = 200;
                break;
            case 3 :
                $sdata['status'] = 300;
                break;
        }
        $passListTmp = https_request_api('job/pastList', $sdata);

		if($passListTmp['data']['totalCount'] > 0) {
            foreach($passListTmp['data']['list'] as $pk => &$passInfo) {
                $resumeInfo = get_resume_basic_by_uid($passInfo['uid']);
                $userInfo = get_user_info($passInfo['uid']);
                $userSignInfo[$passInfo['uid']]['info']['avatars'] = $userInfo['avatars'];
                $userSignInfo[$passInfo['uid']]['info']['mobile'] = $resumeInfo['telephone'];
                $userSignInfo[$passInfo['uid']]['info']['name'] = $resumeInfo['fullname'];
                $userSignInfo[$passInfo['uid']]['info']['enroll_id'] = $passInfo['enroll_id'];
                if($passInfo['confirm_status'] == 200 || $passInfo['confirm_status'] == 300) {
                    $userSignInfo[$passInfo['uid']]['info']['passCount'] += 1;
                } elseif($passInfo['confirm_status'] == 100) {
                    $userSignInfo[$passInfo['uid']]['info']['refuseCount'] += 1;
                }
                //是否放鸽子
                $stwhere['enroll_id'] = $passInfo['enroll_id'];
                $enrollInfoTmp = https_request_api('enroll/info', $stwhere);
                if(!empty($enrollInfoTmp['data'])) {
                    $userSignInfo[$passInfo['uid']]['info']['is_stood'] = $enrollInfoTmp['data']['stood'] == 100 ? 0 : 1;
                }
                $userSignInfo[$passInfo['uid']]['info']['passCount'] = $userSignInfo[$passInfo['uid']]['info']['passCount'] ? $userSignInfo[$passInfo['uid']]['info']['passCount'] : 0;
                $userSignInfo[$passInfo['uid']]['info']['refuseCount'] = $userSignInfo[$passInfo['uid']]['info']['refuseCount'] ? $userSignInfo[$passInfo['uid']]['info']['refuseCount'] : 0;
                $passInfo['sign_time'] = date("m/d H:i", $passInfo['sign_time']);
                $userSignInfo[$passInfo['uid']]['list'][] = $passInfo;
            }
        }
    }
    $smarty->assign('workdate', $_GET['work_date']);
    $smarty->assign('show_type', $_GET['show_type']);
    $smarty->assign('passList', $userSignInfo);
//	var_dump($userSignInfo[895]['list']);exit;
    $smarty->assign('ptInfo', $ptInfo['data']);
    $smarty->assign('cdate', $_GET['work_date'] ? $_GET['work_date'] : 0);
	$smarty->assign('rewrite',$_GET['rewrite']);
	$smarty->assign('rewrite',$_GET['rewrite']);
	$smarty->assign('rewrite_id',$_GET['rewrite_id']);
	$smarty->assign('act',$act);
	$smarty->assign('act_id',$_GET['id']);
	if($_GET['oneid']){
		$smarty->assign('oneid',$_GET['oneid']);
	}
    $smarty->display('m/personal/m-signIn-manage.html');
}
elseif($act == "signOut_manage") {
    if($_GET['id']) {
        $job_info_id = $_GET['id'];
        $ptInfo = https_request_api('job/jobPtInfo', array('job_info_id' => $job_info_id));
        if($ptInfo['codes']) {
            showmsg($ptInfo['msg']);  
        }
		if($ptInfo['data']['dd_uid']) {
			$ddInfo = get_user_info($ptInfo['data']['dd_uid']);
		}
		if($ddInfo) {
			$cjl = "select fullname from " . table('resume') . " where uid=" . $ddInfo['uid'];
			$cdjl = $db->getone($cjl);
		}
		if($cdjl){
			$ptInfo['data']['dd_name'] = $cdjl['fullname'];
		}else {
			$ptInfo['data']['dd_name'] = '';
		}
//        $ptInfo['data']['dd_name'] = $ddInfo['username'];
        $ptInfo['data']['dd_mobile'] = $ddInfo['mobile'];
        $ptInfo['data']['job_info_id'] = $job_info_id;
        $jobInfoTmp = https_request_api('job/info/'.$ptInfo['data']['job_id']);
        if(!isset($jobInfoTmp['data']) || !$jobInfoTmp['data']) {
            showmsg($jobInfoTmp['msg']);  
        }

        $days = intval(ceil(($ptInfo['data']['end_date']-$ptInfo['data']['start_date'])/ 86400));
        if($days > 0) {
            for($i = 0;$i < $days; $i++) {
                $ptInfo['data']['work_date'][] = strtotime('+'.$i.' days', $ptInfo['data']['start_date']);
            }
        }
        $jobInfo = $jobInfoTmp['data'];
        $ptInfo['data']['job_name'] = $jobInfo['job_name'];
       
        $sdata['job_id'] = $ptInfo['data']['job_id'];
        $sdata['job_info_id'] = $ptInfo['data']['id'];
        $sdata['type'] = $_GET['type'] ? $_GET['type'] : 100;
        $_GET['work_date'] && $sdata['date'] = $_GET['work_date'];
        switch ($_GET['status']) {
            case 1 : 
                $sdata['show_type'] = 200;
            case 2 :
                $sdata['status'] = 200;
                break;
            case 3 :
                $sdata['status'] = 300;
                break;
        }
        $passListTmp = https_request_api('job/pastList', $sdata);
        if($passListTmp['data']['totalCount'] > 0) {
            foreach($passListTmp['data']['list'] as $pk => &$passInfo) {
                $resumeInfo = get_resume_basic_by_uid($passInfo['uid']);
                $userInfo = get_user_info($passInfo['uid']);
                $userSignInfo[$passInfo['uid']]['info']['avatars'] = $userInfo['avatars'];
                $userSignInfo[$passInfo['uid']]['info']['mobile'] = $resumeInfo['telephone'];
                $userSignInfo[$passInfo['uid']]['info']['name'] = $resumeInfo['fullname'];
                $userSignInfo[$passInfo['uid']]['info']['enroll_id'] = $passInfo['enroll_id'];
                if($passInfo['confirm_status'] == 200 || $passInfo['confirm_status'] == 300) {
                    $userSignInfo[$passInfo['uid']]['info']['passCount'] += 1;
                } elseif($passInfo['confirm_status'] == 100) {
                    $userSignInfo[$passInfo['uid']]['info']['refuseCount'] += 1;
                }
                $stwhere['enroll_id'] = $passInfo['enroll_id'];
                $enrollInfoTmp = https_request_api('enroll/info', $stwhere);
//				var_dump($enrollInfoTmp);
                if(!empty($enrollInfoTmp['data'])) {
					// 判断是否为早退状态
                    $userSignInfo[$passInfo['uid']]['info']['leaveEarly'] = $enrollInfoTmp['data']['leaveEarly'] == 100 ? 1 : 0;
                }
                $userSignInfo[$passInfo['uid']]['info']['passCount'] = $userSignInfo[$passInfo['uid']]['info']['passCount'] ? $userSignInfo[$passInfo['uid']]['info']['passCount'] : 0;
                $userSignInfo[$passInfo['uid']]['info']['refuseCount'] = $userSignInfo[$passInfo['uid']]['info']['refuseCount'] ? $userSignInfo[$passInfo['uid']]['info']['refuseCount'] : 0;
                $passInfo['sign_time'] = date("m/d H:i", $passInfo['sign_time']);
                $userSignInfo[$passInfo['uid']]['list'][] = $passInfo;
            }
        }
//		exit;
    }
    $smarty->assign('passList', $userSignInfo);
    $smarty->assign('ptInfo', $ptInfo['data']);
    $smarty->assign('cdate', $_GET['work_date'] ? $_GET['work_date'] : 0);
	$smarty->assign('rewrite',$act);
	$smarty->assign('rewrite_id',$_GET['rewrite_id']);
	$smarty->assign('act',$act);
	$smarty->assign('act_id',$_GET['id']);
	if($_GET['oneid']){
		$smarty->assign('oneid',$_GET['oneid']);
	}
	if($_GET['type']){
		$smarty->assign('type',$_GET['type']);
	}
    $smarty->display('m/personal/m-signOut-manage.html');
}
elseif($act == "imghtml") {
	if($_GET['job_info_id']) {
		$signList = https_request_api('job/pastList', array('job_info_id' => $_GET['job_info_id'], 'uid' => $_GET['uid']));
		if($signList['data']['list']) {
			$data = array();
			foreach($signList['data']['list'] as $sk => $sv) {
				if($sv['id'] == $_GET['id']) {
					$data = $sv;
					if($data['sign_pic']){
						$data['sign_pic'] = explode("\n",$data['sign_pic']);
					}
				}
			}
		}
	}

	if($_GET['rewrite']){
		$smarty->assign('rewrite',$_GET['rewrite']);
	}
	if($_GET['rewrite_id']){
		$smarty->assign('rewrite_id',$_GET['rewrite_id']);
	}
	if($_GET['oneid']){
		$smarty->assign('oneid',$_GET['oneid']);
	}
	if($_GET['type']){
		$smarty->assign('type',$_GET['type']);
	}
	$smarty->assign('picInfo', $data);
	$smarty->display('m/personal/img.html');
}
elseif($act == "evelua_manage") {
    if($_GET['id']) {
        $job_info_id = $_GET['id'];
        $ptInfo = https_request_api('job/jobPtInfo', array('job_info_id' => $job_info_id));
        if($ptInfo['codes']) {
            showmsg($ptInfo['msg']);  
        }
		if($ptInfo['data']['dd_uid']) {
			$ddInfo = get_user_info($ptInfo['data']['dd_uid']);
		}
		if($ddInfo) {
			$cjl = "select fullname from " . table('resume') . " where uid=" . $ddInfo['uid'];
			$cdjl = $db->getone($cjl);
		}
		if($cdjl){
			$ptInfo['data']['dd_name'] = $cdjl['fullname'];
		}else {
			$ptInfo['data']['dd_name'] = '';
		}
		$jobs = array();
		if($ptInfo['data']['job_id']){
			$jobs['job_id'] = $ptInfo['data']['job_id'];
			$jobs['job_info_id'] = $job_info_id;
		}
//        $ptInfo['data']['dd_name'] = $ddInfo['username'];
        $ptInfo['data']['dd_mobile'] = $ddInfo['mobile'];
        $ptInfo['data']['job_info_id'] = $job_info_id;
        $jobInfoTmp = https_request_api('job/info/'.$ptInfo['data']['job_id']);
        if(!isset($jobInfoTmp['data']) || !$jobInfoTmp['data']) {
            showmsg($jobInfoTmp['msg']);  
        }

        $days = intval(ceil(($ptInfo['data']['end_date']-$ptInfo['data']['start_date'])/ 86400));
        if($days > 0) {
            for($i = 0;$i < $days; $i++) {
                $ptInfo['data']['work_date'][] = strtotime('+'.$i.' days', $ptInfo['data']['start_date']);
            }
        }
        $jobInfo = $jobInfoTmp['data'];
        $ptInfo['data']['job_name'] = $jobInfo['job_name'];
        $sdata['job_id'] = $ptInfo['data']['job_id'];
        $sdata['job_info_id'] = $ptInfo['data']['id'];
        $sdata['station_type'] = 100;
        $sdata['status'] = 200;
        $_GET['work_date'] && $sdata['date'] = $_GET['work_date'];
        $enrollListTmp = https_request_api('enroll/list', $sdata);
        if($enrollListTmp['data']['totalCount'] > 0) {
            foreach($enrollListTmp['data']['list'] as $pk => &$enrollInfo) {
                $resumeInfo = get_resume_basic_by_uid($enrollInfo['uid']);
                $userInfo = get_user_info($enrollInfo['uid']);
                $userEvaluateInfo[$enrollInfo['uid']]['avatars'] = $userInfo['avatars'];
                $userEvaluateInfo[$enrollInfo['uid']]['mobile'] = $resumeInfo['telephone'];
                $userEvaluateInfo[$enrollInfo['uid']]['name'] = $resumeInfo['fullname'];
                $userEvaluateInfo[$enrollInfo['uid']]['enroll_id'] = $enrollInfo['id'];
                $userEvaluateInfo[$enrollInfo['uid']]['evaluate_status'] = $enrollInfo['evaluate_status'];
                if($enrollInfo['evaluate_status'] == 200) {
                    $enrollInfoTmp = https_request_api('job/evaluateInfo', ['enroll_id' => $enrollInfo['id']]);
                    for($i=1;$i<=5;$i++) {
                        if($i <= $enrollInfoTmp['data']['punctual']) {
                            $userEvaluateInfo[$enrollInfo['uid']]['punctual'] .= '<i class="selected"></i>';
                        } else {
                            $userEvaluateInfo[$enrollInfo['uid']]['punctual'] .= '<i></i>';

                        }
                    }
                    switch ($enrollInfoTmp['data']['punctual']) {
                        case 1:
                            $userEvaluateInfo[$enrollInfo['uid']]['punctual_txt'] = '很差';
                            break;
                        case 2:
                            $userEvaluateInfo[$enrollInfo['uid']]['punctual_txt'] = '差';
                            break;
                        case 3:
                            $userEvaluateInfo[$enrollInfo['uid']]['punctual_txt'] = '一般';
                            break;
                        case 4:
                            $userEvaluateInfo[$enrollInfo['uid']]['punctual_txt'] = '好';
                            break;
                        case 5:
                            $userEvaluateInfo[$enrollInfo['uid']]['punctual_txt'] = '很好';
                            break;
                    }
                    for($i=1;$i<=5;$i++) {
                        if($i <= $enrollInfoTmp['data']['earnest']) {
                            $userEvaluateInfo[$enrollInfo['uid']]['earnest'] .= '<i class="selected"></i>';
                        } else {
                            $userEvaluateInfo[$enrollInfo['uid']]['earnest'] .= '<i></i>';

                        }
                    }
                     switch ($enrollInfoTmp['data']['earnest']) {
                        case 1:
                            $userEvaluateInfo[$enrollInfo['uid']]['earnest_txt'] = '很差';
                            break;
                        case 2:
                            $userEvaluateInfo[$enrollInfo['uid']]['earnest_txt'] = '差';
                            break;
                        case 3:
                            $userEvaluateInfo[$enrollInfo['uid']]['earnest_txt'] = '一般';
                            break;
                        case 4:
                            $userEvaluateInfo[$enrollInfo['uid']]['earnest_txt'] = '好';
                            break;
                        case 5:
                            $userEvaluateInfo[$enrollInfo['uid']]['earnest_txt'] = '很好';
                            break;
                    }
                    for($i=1;$i<=5;$i++) {
                        if($i <= $enrollInfoTmp['data']['effect']) {
                            $userEvaluateInfo[$enrollInfo['uid']]['effect'] .= '<i class="selected"></i>';
                        } else {
                            $userEvaluateInfo[$enrollInfo['uid']]['effect'] .= '<i></i>';
                        }
                    }
                    switch ($enrollInfoTmp['data']['effect']) {
                        case 1:
                            $userEvaluateInfo[$enrollInfo['uid']]['effect_txt'] = '很差';
                            break;
                        case 2:
                            $userEvaluateInfo[$enrollInfo['uid']]['effect_txt'] = '差';
                            break;
                        case 3:
                            $userEvaluateInfo[$enrollInfo['uid']]['effect_txt'] = '一般';
                            break;
                        case 4:
                            $userEvaluateInfo[$enrollInfo['uid']]['effect_txt'] = '好';
                            break;
                        case 5:
                            $userEvaluateInfo[$enrollInfo['uid']]['effect_txt'] = '很好';
                            break;
                    }
                    for($i=1;$i<=5;$i++) {
                        if($i <= $enrollInfoTmp['data']['performance']) {
                            $userEvaluateInfo[$enrollInfo['uid']]['performance'] .= '<i class="selected"></i>';
                        } else {
                            $userEvaluateInfo[$enrollInfo['uid']]['performance'] .= '<i></i>';

                        }
                    }
                    switch ($enrollInfoTmp['data']['performance']) {
                        case 1:
                            $userEvaluateInfo[$enrollInfo['uid']]['performance_txt'] = '很差';
                            break;
                        case 2:
                            $userEvaluateInfo[$enrollInfo['uid']]['performance_txt'] = '差';
                            break;
                        case 3:
                            $userEvaluateInfo[$enrollInfo['uid']]['performance_txt'] = '一般';
                            break;
                        case 4:
                            $userEvaluateInfo[$enrollInfo['uid']]['performance_txt'] = '好';
                            break;
                        case 5:
                            $userEvaluateInfo[$enrollInfo['uid']]['performance_txt'] = '很好';
                            break;
                    }
                    for($i=1;$i<=5;$i++) {
                        if($i <= $enrollInfoTmp['data']['ability']) {
                            $userEvaluateInfo[$enrollInfo['uid']]['ability'] .= '<i class="selected"></i>';
                        } else {
                            $userEvaluateInfo[$enrollInfo['uid']]['ability'] .= '<i></i>';
                        }
                    }
                    switch ($enrollInfoTmp['data']['ability']) {
                        case 1:
                            $userEvaluateInfo[$enrollInfo['uid']]['ability_txt'] = '很差';
                            break;
                        case 2:
                            $userEvaluateInfo[$enrollInfo['uid']]['ability_txt'] = '差';
                            break;
                        case 3:
                            $userEvaluateInfo[$enrollInfo['uid']]['ability_txt'] = '一般';
                            break;
                        case 4:
                            $userEvaluateInfo[$enrollInfo['uid']]['ability_txt'] = '好';
                            break;
                        case 5:
                            $userEvaluateInfo[$enrollInfo['uid']]['ability_txt'] = '很好';
                            break;
                    }
                    $userEvaluateInfo[$enrollInfo['uid']]['evaluate_content'] = $enrollInfoTmp['data']['evaluate_content'];
                }
            }
        }
    }

    $smarty->assign('evaluateList', $userEvaluateInfo);
    $smarty->assign('ptInfo', $ptInfo['data']);
    $smarty->assign('cdate', $_GET['work_date'] ? $_GET['work_date'] : 0);
	$smarty->assign('jobs', $jobs);
	$smarty->assign('rewrite',$_GET['rewrite']);
	$smarty->assign('rewrite_id',$_GET['rewrite_id']);
    $smarty->display('m/personal/m-evelua-manage.html');
}
elseif($act == "resume_train_add")
{
	$smarty->cache = false;
	$id=intval($_GET["id"]);
	$resume_train=get_this_training(intval($_SESSION['uid']),$id);
	if($resume_train){
		$smarty->assign('resume_train',$resume_train);
	}else{
		$smarty->assign('resume_train',false);
	}
	$smarty->display('m/personal/m-edit-train-experience.html');
}
elseif($act == "resume_train_save")
{
	// print_r($_POST);die;
	$_POST=array_map("utf8_to_gbk",$_POST);
	$id=intval($_POST['id']);
	$setsqlarr['uid'] = intval($_SESSION['uid']);
	$setsqlarr['pid'] = intval($_POST['pid']);
	if ($setsqlarr['uid']==0 || $setsqlarr['pid']==0 )exit('简历不存在');
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),intval($_POST['pid']));
	if (empty($resume_basic)) exit('请先填写简历基本信息');
	$resume_training=get_resume_training($_SESSION['uid'],intval($_POST['pid']));
	if (count($resume_training)>=6)  exit('培训经历不能超过6条');
	$setsqlarr['agency'] = trim($_POST['agency'])?trim($_POST['agency']):exit('请填写培训机构名称！');
	$setsqlarr['course'] = trim($_POST['course'])?trim($_POST['course']):exit("请填写培训专业名称！");
	if(trim($_POST['startyear'])==""||trim($_POST['startmonth'])==""||trim($_POST['endyear'])==""){
		exit("请选择培训时间！");
	}
	$setsqlarr['startyear'] = intval($_POST['startyear']);
	$setsqlarr['startmonth'] = intval($_POST['startmonth']);
	//至今 情况
	if(intval($_POST['endyear']) == -1)
	{
		$setsqlarr['endyear'] = 0;
		$setsqlarr['endmonth'] = 0;
		$setsqlarr['todate'] = 1;
	}
	else
	{
		$setsqlarr['endyear'] = intval($_POST['endyear']);
		$setsqlarr['endmonth'] = intval($_POST['endmonth']);
		$setsqlarr['todate'] = 0;
	}
	$setsqlarr['description'] = trim($_POST['description'])?trim($_POST['description']):exit("请填写培训内容！");
	if($id){
		$db->updatetable(table("resume_training"),$setsqlarr,array("id"=>$id,"uid"=>intval($_SESSION['uid'])));
		exit("ok");
	}else{
		$insert_id = $db->inserttable(table("resume_training"),$setsqlarr,1);
		if($insert_id){
			check_resume($_SESSION['uid'],intval($_REQUEST['pid']));
			perfect_resume($_SESSION['uid'],$_SESSION['username'],$_REQUEST['pid'],1);
			exit("ok");
		}else{
			exit("err");
		}
	}	
}
elseif($act == "resume_train_del")
{
	$smarty->cache = false;
	$id=intval($_GET['train_id']);
	$uid=intval($_SESSION["uid"]);
	$sql="delete from ".table("resume_training")." where id=$id and uid=$uid ";
	if($db->query($sql)){
		perfect_resume($_SESSION['uid'],$_SESSION['username'],$id,2);
		exit("ok");
	}else{
		exit("err");
	}
}
// 自我评价
elseif($act == "resume_specialty")
{
	$smarty->cache = false;
	$id=intval($_GET['pid']);
	$resume_basic=get_resume_basic(intval($_SESSION['uid']),$id);
	$smarty->assign('resume_basic',$resume_basic);
	$smarty->display('m/personal/m-evaluation.html');
}
elseif($act == "resume_specialty_save")
{
	$_POST=array_map("utf8_to_gbk",$_POST);
	$smarty->cache = false;
	$id=intval($_POST['pid']);
	$uid=intval($_SESSION["uid"]);
	$specialty=$_POST['specialty']?$_POST['specialty']:exit("请填写自我评价");
	$sql="update ".table("resume")." set specialty='$specialty' where id=$id and uid=$uid ";
	if($db->query($sql)){
		perfect_resume($_SESSION['uid'],$_SESSION['username'],$id,1);
		exit("ok");
	}else{
		exit("err");
	}
}
// 简历刷新
elseif($act == "resume_refresh")
{
	$smarty->cache = false;

	$resumeid = intval($_GET['pid']);
	$refrestime=get_last_refresh_date(intval($_SESSION['uid']),"2001");
	$duringtime=time()-$refrestime['max(addtime)'];
	$space = $_CFG['per_refresh_resume_space']*60;
	$refresh_time = get_today_refresh_times($_SESSION['uid'],"2001");
	if($_CFG['per_refresh_resume_time']!=0&&($refresh_time['count(*)']>=$_CFG['per_refresh_resume_time']))
	{
	exit("每天最多只能刷新".$_CFG['per_refresh_resume_time']."次,您今天已超过最大刷新次数限制！");	
	}
	elseif($duringtime<=$space)
	{
	exit($_CFG['per_refresh_resume_space']."分钟内不能重复刷新简历！");
	}
	else 
	{
	refresh_resume($resumeid,intval($_SESSION['uid']))?exit('ok'):exit("err");
	}
}
// 简历隐私设置
elseif($act == "resume_privacy")
{
	$smarty->cache = false;
	$pid=intval($_GET['pid']);
	//屏蔽的企业
	$uid=intval($_SESSION["uid"]);
	$shield_company=$db->getall("select * from ".table("personal_shield_company")." where uid=$uid and pid=$pid");
	$smarty->assign('shield_company',$shield_company);
	$smarty->assign('resume_one',resume_one($pid));
	$smarty->display('wap/personal/privacy-settings.html');
}
elseif($act == "resume_privacy_save")
{
	$smarty->cache = false;
	$uid=intval($_SESSION['uid']);
	$pid=intval($_POST['pid']);
	$setsqlarr['display']=intval($_POST['display']);
	$setsqlarr['display_name']=intval($_POST['display_name']);
	// $setsqlarr['photo_display']=intval($_POST['photo_display']);
	!$db->updatetable(table('resume'),$setsqlarr," uid='{$uid}' AND  id='{$pid}'");
	$setsqlarrdisplay['display']=intval($_POST['display']);
	!$db->updatetable(table('resume_search_key'),$setsqlarrdisplay," uid='{$uid}' AND  id='{$pid}'");
	!$db->updatetable(table('resume_search_rtime'),$setsqlarrdisplay," uid='{$uid}' AND  id='{$pid}'");
	$rst=write_memberslog($uid,2,1104,$_SESSION['username'],"设置简历隐私({$pid})");
	if($rst){
		exit("ok");
	}else{
		exit("err");
	}
}
elseif($act == "resume_del")
{
	$smarty->cache = false;
	$id=intval($_GET["pid"]);
	$uid=intval($_SESSION['uid']);
	del_resume($uid,$id)?exit('ok'):exit('err');
}
// 升级高级简历
elseif($act == "resume_talent")
{
	$smarty->cache = false;
	$id=intval($_GET["pid"]);
	$uid=intval($_SESSION['uid']);
	$resume=get_resume_basic($uid,$id);
	if ($resume['complete_percent']<$_CFG['elite_resume_complete_percent'])
	{
		exit("简历完整指数小于{$_CFG['elite_resume_complete_percent']}%，禁止申请！");
	}
	else
	{
		$setsqlarr["talent"]=3;
		$db->updatetable(table("resume"),$setsqlarr,array("id"=>$id,"uid"=>intval($_SESSION['uid'])))?exit("ok"):exit("err");
	}
}
// 修改简历名
elseif($act == 'resume_name_save')
{
	$smarty->cache = false;
	$_POST=array_map("utf8_to_gbk", $_POST);
	$resume_id=intval($_POST["resume_id"]);
	$uid=intval($_SESSION["uid"]);
	$title=trim($_POST['title'])?trim($_POST['title']):exit("请输入简历名称");
	$sql="update ".table("resume")." set title='$title' where id=$resume_id and uid=$uid ";
	if($db->query($sql)){
		exit("ok");
	}else{
		exit("err");
	}
	
}
// 保存简历头像
elseif ($act =='logo_save')
{
	require_once(QISHI_ROOT_PATH.'include/upload.php');
	!$_FILES['logo_img']['name']?exit('请上传图片！'):"";
	$logo_dir="../../data/photo/".date("Y/m/d/");
	$logo_thumb_dir="../../data/photo/thumb/".date("Y/m/d/");
	make_dir($logo_dir);
	make_dir($logo_thumb_dir);
	$setsqlarr['photo_img']=_asUpFiles($logo_dir, "logo_img",$_CFG['logo_max_size'],'gif/jpg/bmp/png',true);
	if ($setsqlarr['photo_img'])
	{
		copy($logo_dir.$setsqlarr['photo_img'], $logo_thumb_dir.$setsqlarr['photo_img']);
		$setsqlarr['photo_img']=date("Y/m/d/").$setsqlarr['photo_img'];
		$setsqlarr['photo_audit']=intval($_CFG['audit_resume_photo']);
		$setsqlarr['photo']=1;
		$pid=intval($_GET["pid"]);
		if($pid <= 0)
		{
			exit("-8");
		}
		$wheresql="uid='".$_SESSION['uid']."' and id=".$pid;
		if(!$db->updatetable(table('resume'),$setsqlarr,$wheresql))
		{
			exit("-6");
		}
		else
		{
			$data['isok'] = 1;
			$json_encode = json_encode($data);
			exit($json_encode);
		}
	}
	else
	{
	exit("-6");
	}
}
elseif($act=='invite') {

    $qrInfoSql ="select * from ".table('members_invite')." where uid=".$_SESSION['uid'];
    $qrInfo=$db->getone($qrInfoSql);
    if($qrInfo && $qrInfo['qr_code']) {
        $qurl = $qrInfo['qr_code'];
        $code = $qrInfo['code'];
    } else {
        require_once(QISHI_ROOT_PATH.'include/phpqrcode/phpqrcode.php');
        $code = create_guid();
        $qrInfo = 'http://m.yjob.net/m/user_reg.php?act=reg_info&utype=2&code='.$code;
        $fileNname ='qrcodes/invite/'.$_SESSION['uid'].'.png';
        QRcode::png($qrInfo, QISHI_ROOT_PATH.$fileNname,'', 10, 4,true);
        $qrInfo = array(
            'uid' => $_SESSION['uid'],
            'qr_code' => $fileNname,
            'code' => $code,
            'create_time' => time(),
        );
        $qid = $db->inserttable(table('members_invite'), $qrInfo, 1);
        $qurl = $fileNname;
    }
    $smarty->assign('qimgUrl', 'http://m.yjob.net/'.$qurl);
    $smarty->assign('qCode', $code);
    $smarty->display('m/personal/m-invite.html');
}

// 我的钱包 添加银行卡等
elseif($act == 'my_bank_card'){
	$uid = intval($_SESSION['uid']);
	$sql = "select mobile from qs_members where uid = ".$uid;
	$mobile = $db->getone($sql);
	$sql = "select * from ys_my_bank_card where uid = ".$uid;
	$result = $db->getone($sql);
	$smarty->assign('uid', $uid);
	$smarty->assign('mobile', $mobile['mobile']);
	if($result){
		$smarty->assign('my_bank_card', $result);
	}
	$smarty->display('m/personal/my-bank-card.html');
}


function create_guid() {
	static $guid = '';
	$uid = $_SESSION['uid'];
	$data = $namespace;
	$data .= $_SERVER ['REQUEST_TIME']; 	// 请求那一刻的时间戳
	$data .= $_SERVER ['HTTP_USER_AGENT']; 	// 获取访问者在用什么操作系统
	$data .= $_SERVER ['SERVER_ADDR']; 		// 服务器IP
	$data .= $_SERVER ['SERVER_PORT']; 		// 端口号
	$data .= $_SERVER ['REMOTE_ADDR']; 		// 远程IP
	$data .= $_SERVER ['REMOTE_PORT']; 		// 端口信息
	$hash = strtoupper ( hash ( 'ripemd128', $uid . $guid . md5 ( $data ) ) );
       
	$guid = substr ( $hash, 0, 8 ) . substr ( $hash, 8, 4 )  . substr ( $hash, 12, 4 ) . substr ( $hash, 16, 4 ) . substr ( $hash, 20, 12 );
        $start = rand(0,9);
	return substr($guid, $start,6);;
}

        
function getCodeByid($id) {
    $idCode = '';
    $id10 = (string)$_SESSION['uid'].time();
    $id10 = $id;
    for ($i = strlen($id10) - 6; $i > -6; $i -=6) {
        $offset1 = $i < 0 ? 0 : $i;
        $offset2 = $i + 6;
        $num = substr($id10, $offset1,$offset2-$offset1); 
        $num = to62Code($num);
        $idCode = $num .$idCode;
    }
    return $idCode;
}
    
function to62Code($cid) {
    $keys = array(
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        "a", "b", "c", "d", "e", "f", "g", "h", "i", 
        "j", "k", "l", "m", "n", "o", "p", "q", 
        "r", "s", "t", "u", "v", "w", "x", "y", 
        "z"
    );
    $s62 = '';
    $r = 0;
    while ($cid != 0) {
        $r = $cid % 62;
        $s62 = $keys[$r].$s62;
        $cid = floor($cid / 62);
    }
    return strtoupper($s62);
}
?>