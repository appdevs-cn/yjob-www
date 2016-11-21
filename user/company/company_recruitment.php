<?php
/*
 * 74cms 企业会员中心
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/company_common.php');
$smarty->assign('leftmenu',"recruitment");
if ($act=='apply_jobs')
{
    $_GET['look'] && $listData['check_status'] = $_GET['look'];
    $_GET['job_id'] && $listData['job_id'] = $_GET['job_id'];
    $_GET['date'] && $listData['date'] = $_GET['date'];
    $_GET['position_type'] && $listData['position_type'] = $_GET['position_type'];
    $_GET['sid'] && $listData['job_info_id'] = $_GET['sid'];

    $companyInfo = get_company_by_uid($_SESSION['uid']);
    $listData['company_id'] = $companyInfo['id'];
    $resumeList = https_request_api('/enroll/list', $listData);
    require_once(QISHI_ROOT_PATH.'include/page.class.php');
    if($resumeList['codes']) {
        showmsg("获取审核列表失败！",1);
    }
    $listData['company_id'] = $companyInfo['id'];
    $jobListTmp = https_request_api('job/list/', $listData);
    if(!$jobListTmp['codes'] && $jobListTmp['data']['list']) {
        foreach($jobListTmp['data']['list'] as $jlk => $job) {
            if($job['list']) {
                foreach($job['list'] as $jk => $jv) {
                    $station_list_tmp[$jv['job_id']][$jv['id']] = $jv;
                    $station_list[$jv['id']] = $jv;
                    $sData[] = $jv['start_date'];
                    $eData[] = $jv['end_date'];
                }
            }
            $jobList[$job['id']] = $job;
        }
    }
    $perpage=10;
    $total= $resumeList['data']['totalCount'] ? $resumeList['data']['totalCount'] : 0;
    $page = new page(array('total'=>$total, 'perpage'=>$perpage));
    $offset=($page->nowindex-1)*$perpage;
    $smarty->assign('act',$act);
    $smarty->assign('title','收到的职位申请 - 企业会员中心 - '.$_CFG['site_name']);
    foreach($resumeList['data']['list'] as $resumeKey => &$resume) {
        $jobInfo = $jobList[$resume['job_id']];
        if($jobInfo['list']) {
            foreach($jobInfo['list'] as $jk => $jobInfoV) {
                $sData[] = $jobInfoV['start_date'];
                $eData[] = $jobInfoV['end_date'];
                //$resume['position_list'][$jobInfoV['job_id']]['name'] = $jobInfoV['address'];
                //$resume['position_list'][$jobInfoV['job_id']]['id'] = $jobInfoV['job_id'];
            }
        }
        $user_resume = current(get_resume_uid($resume['uid']));
        $resume['telephone'] = $user_resume['telephone'];
        $resume['fullname'] = $user_resume['fullname'];
        $resume['sex_cn'] = $user_resume['sex_cn'];
        $resume['education_cn'] = $user_resume['education_cn'];
        $resume['audit'] = $user_resume['audit'];
        $resume['nature_cn'] = $user_resume['nature_cn'];
        $resume['education_cn'] = $user_resume['education_cn'];
        $resume['display'] = $user_resume['display'];
        $resume['resume_url'] = $user_resume['resume_url'];
        $resume['job_info_id'] = $resume['job_info_id'];
    }
    asort($sData);
    arsort($eData);
    $startDate = current($sData);
    $endDate = current($eData);
    $days = ceil(($endDate - $startDate) / 86400);
    if($days >= 0) {
        for($i = 0; $i <= $days; $i++) {
            $work_date[] = strtotime('+'.$i.'days', $startDate);
        }
    }
    $smarty->assign('jobs_apply', $resumeList['data']['list']);
   
    if($total>$perpage)
    {
            $smarty->assign('page',$page->show(3));
    }
    //$smarty->assign('jobsid',$jobsid);
    $smarty->assign('work_date', $work_date);
    $smarty->assign('count', $resumeList['data']['totalCount']);
    $smarty->assign('count1', $resumeList['data']['nvcount']);
    $smarty->assign('count2', $resumeList['data']['vcount']);
    $smarty->assign('joblist', $jobList);
    $smarty->assign('station_options',$station_list_tmp);
    $smarty->assign('station_list',$station_list);
    $smarty->assign('jobs',$resumeList['data']['list']);
    $smarty->display('member_company/company_apply_jobs.htm');
}
elseif ($act=='apply_jobs_weixin')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	
	$wheresql=" WHERE uid='{$_SESSION['uid']}' ";
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('weixin_baoming')." {$wheresql} ";
	$total=$db->get_total($total_sql);
	$page = new page(array('total'=>$total, 'perpage'=>$perpage));
	$offset=($page->nowindex-1)*$perpage;
	$smarty->assign('act',$act);
	$smarty->assign('title','收到的职位申请 - 企业会员中心 - '.$_CFG['site_name']);
	$smarty->assign('jobs_apply',get_apply_weixin($offset,$perpage,$joinsql.$wheresql));
	if($total>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->display('member_company/company_apply_jobs_weixin.htm');
}
elseif ($act=='set_apply_jobs')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择任何项目！",1);
	set_apply($yid,$_SESSION['uid'],2)?showmsg("设置成功！",2):showmsg("设置失败！",0);
}
elseif ($act=='apply_jobs_del')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择项目！",1);
	if ($n=del_apply_jobs($yid,$_SESSION['uid']))
	{
	showmsg("删除成功！共删除 {$n} 行",2);
	}
	else
	{
	showmsg("失败！",0);
	}
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
elseif ($act=='fastapply')
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
	$time=time();
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('resume').$where;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	
	$sql="select * from ".table('resume').$where." limit {$offset},{$perpage}";
	$sql1="select * from ".table('jobs')." where uid='{$uid}' and work_start > ".$time;
	$sql2="select * from ".table('personal_jobs_apply')." where company_uid=".$uid;
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
	
	$smarty->display('member_company/company_fastapply.htm');
}
elseif ($act=='down_resume_list')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$perpage=10;
	$joinsql=" LEFT JOIN  ".table('resume')." as r ON d.resume_id=r.id ";
	$wheresql=" WHERE  d.company_uid='{$_SESSION['uid']}' ";
	$settr=intval($_GET['settr']);
	$talent=intval($_GET['talent']);
	$state=intval($_GET['state']);//标记状态
	if($settr>0)
	{
	$settr_val=strtotime("-{$settr} day");
	$wheresql.=" AND d.down_addtime>{$settr_val} ";
	}
	if($talent){
		$wheresql.=" AND r.talent=1 ";
	}
	if($state>0)
	{
		$joinsql.=" left join ".table('company_label_resume')." as l on l.resume_id=d.resume_id ";
		$wheresql.=" AND l.resume_state=$state ";
	}

	$total_sql="SELECT COUNT(*) AS num FROM ".table('company_down_resume')." as d".$joinsql.$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title','已下载的简历 - 企业会员中心 - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	$smarty->assign('list',get_down_resume($offset,$perpage,$joinsql.$wheresql));
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->display('member_company/company_down_resume.htm');
}
elseif ($act=='down_resume_del')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择简历！",1);
	if ($n=del_down_resume($yid,$_SESSION['uid']))
	{
	showmsg("删除成功！共删除 {$n} 行",2);
	}
	else
	{
	showmsg("失败！",0);
	}
}
elseif ($act=='perform')
{
	$id =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择简历！",1);
	if(!empty($_REQUEST['shift'])){
		$num=down_to_favorites($id,$_SESSION['uid']);
		if ($num==='full')
		{
		showmsg("人才库已满!",1);
		}
		elseif($num>0)
		{
		showmsg("添加成功，共添加 {$num} 条",2);
		}
		else
		{
		showmsg("添加失败,已经存在！",1);
		}
	}elseif(!empty($_REQUEST['attention_shift'])){
		$num=attention_to_favorites($id,$_SESSION['uid']);
		if ($num==='full')
		{
		showmsg("人才库已满!",1);
		}
		elseif($num>0)
		{
		showmsg("添加成功，共添加 {$num} 条",2);
		}
		else
		{
		showmsg("添加失败,已经存在！",1);
		}
	}
	
}
elseif ($act=='favorites_list')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$perpage=10;
	$joinsql=" LEFT JOIN  ".table('resume')." AS r ON  f.resume_id=r.id ";
	$wheresql= " WHERE f.company_uid='{$_SESSION['uid']}' ";
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
	$settr_val=strtotime("-".$settr." day");
	$wheresql.=" AND f.favoritesa_ddtime>".$settr_val;
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('company_favorites')." AS f ".$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$offset=($page->nowindex-1)*$perpage;
	$smarty->assign('title','企业人才库 - 企业会员中心 - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	$smarty->assign('favorites',get_favorites($offset, $perpage,$joinsql.$wheresql));
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->display('member_company/company_favorites.htm');
}
elseif ($act=='favorites_del')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择简历！",1);
	if ($n=del_favorites($yid,$_SESSION['uid']))
	{
	showmsg("删除成功！共删除 {$n} 行",2);
	}
	else
	{
	showmsg("失败！",0);
	}
}
//已邀请面试列表
elseif ($act=='interview_list')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$perpage=10;
	$joinsql=" LEFT JOIN ".table('resume')." as r ON i.resume_id=r.id ";
	$wheresql=" WHERE i.company_uid='{$_SESSION['uid']}' ";
	//面试职位 筛选
	$jobsid=intval($_GET['jobsid']);
	if($jobsid>0)
	{
		$wheresql.=" AND i.jobs_id='{$jobsid}' ";
	}
	//对方查看状态 帅选
	$look=intval($_GET['look']);
	if($look>0)$wheresql.=" AND  i.personal_look='{$look}' ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('company_interview')." as i ".$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$resume = get_interview($offset, $perpage,$joinsql.$wheresql);
	$smarty->assign('act',$act);
	$smarty->assign('title','我发起的面试邀请 - 企业会员中心 - '.$_CFG['site_name']);
	$smarty->assign('resume',$resume);
	$count1=count_interview($_SESSION['uid'],1,$jobsid);//未查看
	$count2=count_interview($_SESSION['uid'],2,$jobsid);//已查看
	$count=$count1+$count2;
	$smarty->assign('count',$count);
	$smarty->assign('count1',$count1);
	$smarty->assign('count2',$count2);
	$smarty->assign('filter_jobs',get_interview_jobs($_SESSION['uid']));
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->display('member_company/company_interview.htm');
}
//删除面试邀请信息
elseif ($act=='interview_del')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择简历！",1);
	if (del_interview($yid,$_SESSION['uid']))
	{
		showmsg("删除成功！",2);
	}
	else
	{
		showmsg("删除失败！",0);
	}
}
//浏览过的简历
elseif ($act=='my_attention')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$joinsql=" LEFT JOIN  ".table('resume')." AS r  ON  a.resumeid=r.id ";
	$wheresql=" WHERE a.uid='{$_SESSION['uid']}' ";
	//查看时间筛选
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
	$settr_val=strtotime("-".$settr." day");
	$wheresql.=" AND a.addtime>".$settr_val;
	}
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('view_resume')." AS a  {$wheresql} ";
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$offset=($page->nowindex-1)*$perpage;
	$smarty->assign('title','浏览记录 - 企业会员中心 - '.$_CFG['site_name']);
	$smarty->assign('resume_list',get_my_attention($offset,$perpage,$joinsql.$wheresql));
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->display('member_company/company_my_attention.htm');
}
//删除 浏览过的简历
elseif($act == 'del_my_attention')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择简历！",1);
	if ($n=del_my_attention($yid,$_SESSION['uid']))
	{
	showmsg("删除成功！共删除 {$n} 行",2);
	}
	else
	{
	showmsg("删除失败！",0);
	}
}
//收藏 简历
elseif($act == 'fav_att_resume')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择简历！",1);
	$n = add_favorites($yid,$_SESSION['uid']);
	if(intval($n) > 0)
	{
	showmsg("收藏成功！共收藏 {$n} 行",2);
	}
	else
	{
	showmsg("收藏失败！",0);
	}
}
//查看 "谁看过我的职位" 信息
elseif ($act=='view_jobs_log')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	//筛选 职位
	if(intval($_GET['jobsid'])>0)
	{
		$wheresql=" WHERE `jobsid`=".intval($_GET['jobsid'])." ";
	}
	else
	{
		$my_jobs = get_my_jobs(intval($_SESSION['uid']));
		if(empty($my_jobs)){
			$wheresql=" WHERE 0";
		}
		else{
			$wheresql=" WHERE `jobsid` in(".$my_jobs.") ";
		}
		
	}
	//筛选 查看时间
	$settr = intval($_GET['settr']);
	if($settr>0)
	{
		if(empty($wheresql))
		{
			$settr_val=strtotime("-".$settr." day");
			$wheresql="WHERE addtime>".$settr_val;
		}
		else
		{
			$settr_val=strtotime("-".$settr." day");
			$wheresql.=" AND addtime>".$settr_val;
		}
	}
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('view_jobs')." {$wheresql} ";
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$offset=($page->nowindex-1)*$perpage;
	$smarty->assign('title','浏览记录 - 企业会员中心 - '.$_CFG['site_name']);
	$smarty->assign('jobs',get_my_jobs($_SESSION['uid'],true));	
	$smarty->assign('user_list',get_view_users($offset,$perpage,$wheresql));
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->display('member_company/company_view_jobs.htm');
}
//删除 "谁看过我的职位" 记录
elseif($act == 'del_view_jobs')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("你没有选择项目！",1);
	if(!del_view_jobs($yid))
	{
		showmsg("删除失败！",0);
	}
	else
	{
		showmsg("删除成功！",2);
	}
}
// 预约刷新
elseif($act == "refresh_appointment")
{
	/* 判断套餐 */
	if ($_CFG['operation_mode']=="3")
	{
		$setmeal=get_user_setmeal($_SESSION['uid']);
		if($_CFG['setmeal_to_points']=="1")
		{
		$add_mode = 1;
		}
		else
		{
		$add_mode = 2;
		}
	}
	elseif ($_CFG['operation_mode']=="2")
	{
		$add_mode = 2;
	}
	elseif ($_CFG['operation_mode']=="1")
	{
		$add_mode = 1;
	}

	if($add_mode==2)
	{
		exit("该模式下不能使用预约刷新！");
	}
	else
	{
		$get_data=$_GET['data_arr'];
		if (is_string($get_data))
		{
			$array=explode(",",$get_data);
			$data_arr[]=$array;
		}
		else
		{
			foreach ($get_data as $key => $value)
			{
				$array=explode(",",$value);
				$data_arr[$key]=$array;
			}
		}
		foreach ($data_arr as $key => $value)
		{
			$points+=$value[2];
		}
		$user_points=get_user_points($_SESSION['uid']);
		if($points>$user_points)
		{
			exit("本次预约需要".$points."积分,您的积分为".$user_points.",积分不足,请充值后再进行预约！");
		}
		else
		{
			foreach ($data_arr as $key => $value)
			{
				$setarr['uid']=$_SESSION['uid'];
				$setarr['jobs_id']=$value[0];
				$setarr['appointment_time']=$value[1];
				$setarr['appointment_time_available']=$value[1];
				$setarr['points']=$value[2];
				$db->inserttable(table('jobs_appointment_refresh'),$setarr);
				$jobarr['auto_refresh']=1;
				$db->updatetable(table('jobs'),$jobarr,array("id"=>$setarr['jobs_id'],"uid"=>$setarr['uid']));
				/* 操作积分  */
			}
			report_deal($_SESSION['uid'],2,$points);
			exit("预约刷新成功！");
		}
	}
} elseif($act = 'update_enroll') {
    if(!$_POST['resume_id']) {
        exit('报名信息不存在');
    }
    $_POST['station'] && $data['job_info_id'] = $_POST['station'];
    $_POST['position_type'] && $data['position_type'] = $_POST['position_type'];
    $_POST['desc'] && $data['desc'] = urldecode($_POST['desc']);
    $_POST['resume_id'] && $data['enroll_id'] = $_POST['resume_id'];
    $rst = https_request_api('enroll/update', $data);
    exit('ok');
}
unset($smarty);
?>
