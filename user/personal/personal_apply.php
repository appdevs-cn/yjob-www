<?php
/*
 * 74cms ���˻�Ա����
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__) . '/personal_common.php');
require_once(QISHI_ROOT_PATH.'include/admin_weixin_fun.php');
$smarty->assign('leftmenu',"apply");
if ($act=='down')
{
	$perpage=10;
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$joinsql=" LEFT JOIN  ".table('company_profile')." AS c  ON d.company_uid=c.uid ";
	$wheresql=" WHERE d.resume_uid='{$_SESSION['uid']}' ";
	$resume_id =intval($_GET['resume_id']);
	if($resume_id>0)$wheresql.=" AND  d.resume_id='{$resume_id}' ";	
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
	$settr_val=strtotime("-".$settr." day");
	$wheresql.=" AND d.down_addtime>".$settr_val;
	}
	$total_sql="SELECT COUNT(*) AS num from ".table('company_down_resume')." AS d {$wheresql}";
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title',"˭���ص��ҵļ��� - ���˻�Ա���� - {$_CFG['site_name']}");
	$smarty->assign('mylist',get_com_downresume($offset,$perpage,$joinsql.$wheresql));
	$smarty->assign('page',$page->show(3));
	$smarty->assign('count',$total_val);
	$smarty->assign('act',$act);
	$smarty->assign('resume_list',get_auditresume_list($_SESSION['uid']));
	$smarty->display('member_personal/personal_downresume.htm');
}
//�������� �б�
elseif ($act=='interview')
{
	$perpage=10;
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$resume=$db->getone("select * from ".table('resume')." where uid='{$_SESSION['uid']}'");
	$rid=$resume['id'];
	$biaoqian=$db->getall("select jobs_id from ".table('company_label_resume')." where resume_id='{$rid}' and resume_state=1");
	$time=time();
	$biaoqian1=array();
	foreach($biaoqian as $k=>$v){
		$jid=$v['jobs_id'];
		$jobs=$db->getone("select * from ".table('jobs')." where id='{$jid}' and work_end > $time");
		if($jobs){
			$biaoqian[$k]['jobs_name']=$jobs['jobs_name'];
			$biaoqian[$k]['companyname']=$jobs['companyname'];
			$biaoqian[$k]['work_start']=date("Y-m-d H:i",$jobs['work_start']);
			$biaoqian[$k]['company_id']=$jobs['company_id'];
			$biaoqian1[$k]=$biaoqian[$k];
		}
		
	}
	$perpage = 6;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	$total_sql="select jobs_id from ".table('company_label_resume')." where resume_id='{$rid}' and resume_state=1";
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->assign('interview',$biaoqian);
	$smarty->assign('title','�ȴ��ϸ� - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	//var_dump($count);
	//$smarty->assign('count',$count);
	//var_dump($biaoqian);exit();
	$smarty->assign('interview',$biaoqian);
	$smarty->display('member_personal/personal_interview.htm');
}
elseif ($act=='baomingzhiwei')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$uid=$_SESSION['uid'];
	$uid=$_SESSION['uid'];
	$time=time();
	if($_POST['zhi']){
		if($_POST['tiaojian']==1){
			$where=" where companyname='{$_POST['zhi']}' and work_start > ".$time;
		}elseif($_POST["tiaojian"]==3){
			$where=" where jobs_name like '%".$_POST['zhi']."%' and work_start > ".$time;
		}
	}else{
		$where=" where work_start > ".$time;
	}
	
	$sql="select * from ".table('jobs').$where;
	$sql1="select * from ".table('resume')." where uid='{$uid}'";
	
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobs').$where;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$sql2="select * from ".table('personal_jobs_apply')." where personal_uid=".$uid." limit {$offset},{$perpage}";
	$jobs = $db->getall($sql);
	$resume = $db->getone($sql1);
	$jobs_apply = $db->getall($sql2);
	if($jobs){
		foreach($jobs as $k=>$v){
			if($jobs_apply){
				foreach($jobs_apply as $k1=>$v1){
					
					if($v['id']==$v1['jobs_id']){
						$jobs[$k]['tongzhiqy']=$v1['tongzhiqy'];
						
						$jobs[$k]['apid']=$v1['did'];
						$sqqq="select * from ".table('company_label_resume')." where jobs_id=".$v1['jobs_id']." and resume_id=".$v1['resume_id'];
						$rowwww=$db->getone($sqqq);
						if($rowwww['resume_state']==8){
							$jobs[$k]['bmzt']=2;
						}else{
							$jobs[$k]['bmzt']=1;
						}
					}
				}
			}
		}
	}
	if($total_val>$perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$time=time();//��ǰʱ��
	$time1=$_CFG['del_time'];
	$times=$time1*24*60*60;
	$smarty->assign('title','����ְλ');
	$smarty->assign('act',$act);
	$smarty->assign('resume',$resume);
	$smarty->assign('time',$time);
	$smarty->assign('times',$times);
	$smarty->assign('jobs',$jobs);
	
	
	
	$smarty->display('member_personal/personal_baomingzhiwei.htm');
}
elseif ($act=='set_interview')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("��û��ѡ����Ŀ��",1);
	$jobs_type=intval($_GET['jobs_type']);
	if($jobs_type == 1)
	{
		$n=set_hunter_invitation($yid,$_SESSION['uid'],2);
	}
	else
	{
		$n=set_invitation($yid,$_SESSION['uid'],2);
	}
	if($n)
	{
		showmsg("���óɹ���",2);
	}
	else
	{
		showmsg("����ʧ�ܣ�",0);
	}
}
elseif ($act=='interview_del')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("��û��ѡ����Ŀ��",1);
	//echo "yid=";var_dump($yid);
	$jobs_type=intval($_GET['jobs_type']);
	//echo "jobs_type=";var_dump($jobs_type);die;
	if($jobs_type == 1)
	{
		$n=del_hunter_interview($yid,$_SESSION['uid']);
	}
	else
	{
		$n=del_interview($yid,$_SESSION['uid']);
	}
	if(intval($n) > 0)
	{
	showmsg("ɾ���ɹ�����ɾ�� {$n} ��",2);
	}
	else
	{
	showmsg("ʧ�ܣ�",0);
	}
}
//ְλ�ղؼ��б�
elseif ($act=='favorites')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$wheresql=" WHERE f.personal_uid='{$_SESSION['uid']}' ";
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
	$settr_val=strtotime("-".$settr." day");
	$wheresql.=" AND f.addtime>".$settr_val;
	}
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('personal_favorites')." AS f {$wheresql} ";
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$smarty->assign('title','ְλ�ղؼ� - ���˻�Ա���� - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	$joinsql=" LEFT JOIN ".table('jobs')." as  j  ON f.jobs_id=j.id ";
	$smarty->assign('favorites',get_favorites($offset,$perpage,$joinsql.$wheresql));
	if($total_val > $perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$smarty->display('member_personal/personal_favorites.htm');
}
elseif ($act=='del_favorites')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("��û��ѡ����Ŀ��",1);
	if($n=del_favorites($yid,$_SESSION['uid']))
	{
		showmsg("ɾ���ɹ�����ɾ�� {$n} ��",2);
	}
	else
	{
		showmsg("ɾ��ʧ�ܣ�",0);
	}
}
elseif ($act=='ksbm_tz')
{
	if(empty($_POST['tongzhiqy'])){
		showmsg("�㻹û�б�����ְλ��",1);
	}
	$app_id=$_POST["apid"];
	$sql="update ".table('personal_jobs_apply')." set tongzhiqy=2 where did='{$app_id}'";
	$result=$db->query($sql);
	if($result){
		showmsg("��ҵ�Ѿ�֪ͨ��",2);
	}else{
		showmsg("�޸�ʧ��",2);
	}
}
elseif ($act=='ksbm_bm')
{
	if($_POST['bmzt']=="���ٱ���"){
		$resume_id=$_POST['idd'];
		$jobs_id=$_POST['id'];
		$sql="select * from ".table('resume')." where id='{$resume_id}'";
		$sql1="select * from ".table('jobs')." where id='{$jobs_id}'";
		$row=$db->getone($sql);
		$row1=$db->getone($sql1);
		$arr['resume_id']=$resume_id;
		$arr['jobs_id']=$jobs_id;
		/* $rrr=$db->getone("select * from ".table('personal_jobs_apply')." where resume_id='{$resume_id}' and jobs_id='{$jobs_id}'");
		if($rrr){
			exit('���Ѿ��������ְλ��');
		} */
		if(empty($row['sex_cn']) || empty($row['fullname'])){
			echo '<script type="text/javascript">
				alert("�������Ƹ��˼�����Ϣ��");
				window.location.href="personal/personal_resume.php?act=edit_resume&pid='.$resume_id.'&make=1";
			</script>';
		}else{
			$arr['company_id']=$row1['company_id'];
			$arr['personal_uid']=$_SESSION['uid'];
			$arr['resume_name']=$row['fullname'];
			$arr['jobs_name']=$row1['jobs_name'];
			$arr['company_name']=$row1['companyname'];
			$arr['company_uid']=$row1['uid'];
			$arr['apply_addtime']=time();
			$arr['personal_look']=1;
			$arr['is_reply']=1;
			$arr['is_apply']=1;
			$arr['tongzhiqy']=1;
			$arr['personal_interview']=0;
			$result=$db->inserttable(table('personal_jobs_apply'),$arr,true);
			if($result){
				showmsg("�����ɹ���",2);
			}
		}
		
	}elseif($_POST['bmzt']=="ȡ������"){
		$resume_id=$_POST['idd'];
		$jobs_id=$_POST['id'];
		$sqq="select * from ".table('personal_jobs_apply')." where resume_id='{$resume_id}' and jobs_id='{$jobs_id}'";
		$get=$db->getone($sqq);
		$sql="update ".table('company_label_resume')." set resume_state=8,resume_state_cn='��ȡ��' where resume_id='{$resume_id}' and jobs_id='{$jobs_id}'";
		$result=$db->query($sql);
		/* $sql1="select * from ".table('resume')." where id='{$resume_id}'";
		$row=$db->getone($sql1);
		$r=$row['cancel_sign']+1;
		$sql2="update ".table('resume')." set cancel_sign='{$r}' where id='{$resume_id}'";
		$result1=$db->query($sql2); */
		$uid=$_SESSION['uid'];
		$pid=$get['company_uid'];
		$ddd=$db->getone("select * from ".table('company_profile')." where uid='{$pid}'");
		$eee=$db->getone("select * from ".table('members')." where uid='{$uid}'");
		$time111=time();
		$time=date('Y-m-d H:i:s',$time111);
		$access_token = get_access_token();
		if(empty($access_token)){
			adminmsg("access_token��ȡʧ�ܣ�",1);
		}
		if($result){
			
			$access_token = get_access_token();
			$content="���ã����Ѿ��ɹ�ȡ����'".$get['jobs_name']."'ְλ�ı���
					��ְ���ƣ�'".$get['jobs_name']."'
					������'".$ddd['contact']."'
					��ϵ�绰��'".$ddd['telephone']."'
					����鿴��ְ��������";
			if($eee['weixin_openid']){
				
				send_weixin_msg($eee['weixin_openid'],$content,$access_token);
			} 
			
			if($eee['mobile']){
				$r=send_sms($eee['mobile'],$content);
	/* 			if ($r=="success")
				{
					//��д����Ա��־
				write_log("��̨���ŷ��ͳɹ���", $_SESSION['admin_name'],3);
				adminmsg('���ŷ��ͳɹ���',2);
				}
				else
				{
				adminmsg("���ŷ���ʧ�ܣ�$r",1);
				} */
			}
			showmsg("ȡ�������ɹ���",2);
		}else{
			showmsg("ȡ������ʧ�ܣ�",2);
		}
	}
	
}
//�����ְλ�б�
elseif ($act=='apply_jobs')
{
	$joinsql = '';
	$time=time();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$wheresql=" WHERE a.personal_uid='{$_SESSION['uid']}' ";
	$resume_id =intval($_GET['resume_id']);
	//ɸѡ����
	if($resume_id>0)
	{
		$wheresql.=" AND  a.resume_id='{$resume_id}' ";	
	}
	//ɸѡ �Է��Ƿ��Ѳ鿴
	$aetlook=intval($_GET['aetlook']);
	if($aetlook>0)
	{
		$wheresql.=" AND a.personal_look='{$aetlook}'";
	}
	//ɸѡ˫�������Ƿ��ѽ���
	$endinginterview=intval($_GET['endinginterview']);
	if($endinginterview>0)
	{
		$wheresql.=" AND a.personal_interview='{$endinginterview}'";
	}
	//ɸѡ ����ʱ��
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
	$settr_val=strtotime("-".$settr." day");
	$wheresql.=" AND a.apply_addtime>".$settr_val;
	}
	//ɸѡ ���� (1->��ҵδ�鿴  2->������  3->����  4->������  5->����  6->δ��ͨ)
	$reply_id=intval($_GET['reply_id']);
	if($reply_id == 1)
	{
		$wheresql.=" AND a.personal_look='1' ";
	}
	elseif($reply_id == 2)
	{
		$wheresql.=" AND a.personal_look='2' AND a.is_reply=0  ";
	}
	elseif($reply_id == 3)
	{
		$wheresql.=" AND a.personal_look='2' AND a.is_reply=1 ";
	}
	elseif($reply_id == 4)
	{
		$wheresql.=" AND a.personal_look='2' AND a.is_reply=2 ";
	}
	elseif($reply_id == 5)
	{
		$wheresql.=" AND a.personal_look='2' AND a.is_reply=3 ";
	}
	elseif($reply_id == 6)
	{
		$wheresql.=" AND a.personal_look='2' AND a.is_reply=4 ";
	}
	$perpage=10;
	//ɸѡ ��ְͨλ(0) �� ��ͷְλ(1)
	$jobs_type=intval($_GET['jobs_type']);
	if($jobs_type != 1)
	{
		$total_sql="SELECT COUNT(*) AS num FROM ".table('personal_jobs_apply')." AS a {$wheresql} ";
		$total_val=$db->get_total($total_sql);
		$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
		$currenpage=$page->nowindex;
		$offset=($currenpage-1)*$perpage;
		$joinsql.=" LEFT JOIN ".table('jobs')." AS j ON a.jobs_id=j.id ";
		$smarty->assign('jobs_apply',get_apply_jobs($offset,$perpage,$joinsql,$wheresql));
	}
	/* else
	{
		$total_sql="SELECT COUNT(*) AS num FROM ".table('personal_hunter_jobs_apply')." AS a {$wheresql} ";
		$total_val=$db->get_total($total_sql);
		$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
		$currenpage=$page->nowindex;
		$offset=($currenpage-1)*$perpage;
		$joinsql.=" LEFT JOIN ".table('hunter_jobs')." AS j ON a.jobs_id=j.id ";
		$smarty->assign('jobs_apply',get_apply_hunter_jobs($offset,$perpage,$joinsql,$wheresql));
	} */
	$smarty->assign('title','�������ְλ - ���˻�Ա���� - '.$_CFG['site_name']);
	$smarty->assign('act',$act);
	if($total_val > $perpage)
	{
		$smarty->assign('page',$page->show(3));
	}
	$count[0]=count_personal_jobs_apply($jobs_type,$_SESSION['uid'],1); //δ�鿴
	$count[1]=count_personal_jobs_apply($jobs_type,$_SESSION['uid'],2); //�Ѳ鿴
	$count[2]=$count[0]+$count[1]+$count[3]+$count[4]+$count[5];//����
	
	
	$count[3]=count_personal_jobs_interviews($jobs_type,$_SESSION['uid'],3); //���������
	$count[4]=count_personal_jobs_interviews($jobs_type,$_SESSION['uid'],4); //������ȡ��
	$count[5]=count_personal_jobs_interviews($jobs_type,$_SESSION['uid'],5); //�����Ѿܾ�
	
	$smarty->assign('count',$count);
	$smarty->assign('resume_list',get_apply_jobs_resumes($_SESSION['uid']));
	$smarty->display('member_personal/personal_apply_jobs.htm');
}
//ɾ��-�����ְλ�б�
elseif ($act=='del_jobs_apply')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("��û��ѡ����Ŀ��",1);
	$jobs_type=intval($_GET['jobs_type']);
	if($jobs_type == 1)
	{
		$n=del_hunter_jobs_apply($yid,$_SESSION['uid']);
	}
	else
	{
		$n=del_jobs_apply($yid,$_SESSION['uid']);
	}
	if(intval($n) > 0)
	{
		showmsg("ɾ���ɹ���",2);
	}
	else
	{
		showmsg("ɾ��ʧ�ܣ�",0);
	}
}
//�������ְλ�б�
elseif ($act=='my_attention')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$joinsql=" LEFT JOIN  ".table('jobs')." AS r  ON  a.jobsid=r.id ";
	$wheresql=" WHERE a.uid='{$_SESSION['uid']}' ";
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
	$settr_val=strtotime("-".$settr." day");
	$wheresql.=" AND a.addtime>".$settr_val;
	}
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('view_jobs')." AS a  {$wheresql} ";
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$offset=($page->nowindex-1)*$perpage;
	$smarty->assign('title','�����¼ - ���˻�Ա���� - '.$_CFG['site_name']);
	$smarty->assign('jobs_list',get_view_jobs($offset,$perpage,$joinsql.$wheresql));
	if($total_val > $perpage)
	{
		$smarty->assign('page',$page->show(3));	
	}
	$smarty->display('member_personal/personal_my_attention.htm');
}
//ɾ��  �������ְλ
elseif($act == 'del_view_jobs')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("��û��ѡ����Ŀ��",1);
	if($n=del_view_jobs($yid,$_SESSION['uid']))
	{
		showmsg("ɾ���ɹ�����ɾ�� {$n} ��",2);
	}
	else
	{
		showmsg("ɾ��ʧ�ܣ�",0);
	}
}
//˭�ڹ�ע��
elseif ($act=='attention_me')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$joinsql=" LEFT JOIN  ".table('resume')." AS r  ON  a.resumeid=r.id ";
	$resume = get_auditresume_list($_SESSION['uid']);
	foreach($resume as $k=>$v){
		$rid[] = $v['id'];
	}
	if(!empty($rid)){
		$rid_str = implode(",",$rid);
		$total_sql="SELECT COUNT(*) AS num FROM ".table('view_resume')." AS a where resumeid in (".$rid_str.")";
		$total_val=$db->get_total($total_sql);
		$wheresql=" where a.resumeid in (".$rid_str.") ";
	}else{
		$total_val = 0;
	}
	//ɸѡ �鿴����
	$resume_id =intval($_GET['resume_id']);
	if($resume_id>0)
	{
		$wheresql.=" AND  a.resumeid='{$resume_id}' ";
		$sql="select title from ".table("resume")." where id=".intval($_GET['resume_id'])." ";
		$row=$db->getone($sql);
		$smarty->assign('resume_title',$row["title"]);	
	}
	//ɸѡ �鿴ʱ��
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
	$settr_val=strtotime("-".$settr." day");
	$wheresql=$wheresql?$wheresql." AND a.addtime>".$settr_val:" WHERE a.addtime>".$settr_val;
	}
	$perpage=10;
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$offset=($page->nowindex-1)*$perpage;
	$smarty->assign('title','˭�ڹ�ע�� - ���˻�Ա���� - '.$_CFG['site_name']);
	$smarty->assign('view_list',get_view_resume($offset,$perpage,$joinsql.$wheresql));
	if($total_val > $perpage)
	{
		$smarty->assign('page',$page->show(3));	
	}
	$smarty->assign('act',$act);
	$smarty->assign('resume_list',$resume);
	$smarty->display('member_personal/personal_attention_me.htm');
}
elseif($act == 'del_view_resume')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("��û��ѡ����Ŀ��",1);
	if($n=del_view_resume($yid))
	{
		showmsg("ɾ���ɹ�����ɾ�� {$n} ��",2);
	}
	else
	{
		showmsg("ɾ��ʧ�ܣ�",0);
	}
}
//�����ⷢ��¼�б�
elseif ($act=='outward')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$wheresql=" WHERE uid = ".$_SESSION['uid']." ";
	//ɸѡ ��ؼ���
	$resume_id =intval($_GET['resume_id']);
	if($resume_id>0)
	{
		$wheresql.=" AND resume_id='{$resume_id}' ";
	}
	//ɸѡ ����ʱ��
	$settr=intval($_GET['settr']);
	if($settr>0)
	{
		$settr_val=strtotime("-".$settr." day");
		$wheresql.=" AND addtime>".$settr_val;
	}
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('resume_outward')." {$wheresql} ";
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$offset=($page->nowindex-1)*$perpage;
	$smarty->assign('title','�����ⷢ��¼ - ���˻�Ա���� - '.$_CFG['site_name']);
	$outward_list = $db->getall("SELECT * FROM ".table('resume_outward')." {$wheresql} ");
	$smarty->assign('outward',$outward_list);
	if($total_val > $perpage)
	{
		$smarty->assign('page',$page->show(3));	
	}
	$smarty->assign('act',$act);
	$smarty->assign('resume_list',get_outward_resumes($_SESSION['uid']));
	$smarty->display('member_personal/personal_outward.htm');
}
//ɾ���ⷢ������¼
elseif($act == 'del_outward')
{
	$yid =!empty($_REQUEST['y_id'])?$_REQUEST['y_id']:showmsg("��û��ѡ����Ŀ��",1);
	if($n=del_outward($yid))
	{
		showmsg("ɾ���ɹ�����ɾ�� {$n} ��",2);
	}
	else
	{
		showmsg("ɾ��ʧ�ܣ�",0);
	}
}
unset($smarty);
?>