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

require_once(dirname(__FILE__).'/../../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/fun_wap.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/fun_personal.php');
$smarty->cache = false;
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
wap_weixin_openid($_GET['code']);
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'baomingzhiwei';
if ($_SESSION['uid']=='' || $_SESSION['username']==''||intval($_SESSION['utype'])==1)
{
	header("Location: ../login.php");
}
$user = get_user_info($_SESSION['uid']);
if($_CFG['login_per_audit_mobile'] && $user['mobile_audit']=="0")
{
	$str= "<script>";
	$str.="alert('������֤�ֻ���');";
	$str.="window.location.href='account_security.php';";
	$str.= "</script>";
	echo $str;
}
if ($act=='baomingzhiwei')
{
	
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
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
	$sql2="select * from ".table('personal_jobs_apply')." where personal_uid=".$uid;
	$perpage=10;
	$total_sql="SELECT COUNT(*) AS num FROM ".table('jobs').$where;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage,'getarray'=>$_GET));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
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
						$jobs[$k]['company_id']=$v1['company_id'];
						$jobs[$k]['jobs_id']=$v1['jobs_id'];
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
	
	//$smarty->display("m/personal/m-attentionme.html");
	$smarty->display("m/personal/m-baomingzhiwei.html");
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
		showmsg("�Ѿ�֪ͨ��ҵ��",2);
	}else{
		showmsg("�޸�ʧ��",2);
	}
}
elseif ($act=='ksbm_bm')
{
		$id=$_GET['id'];
		$sql11="select * from ".table('company_label_resume')." where id='{$id}'";
		$cjg11=$db->query($sql11);
		$resume_id=$cjg11['resume_id'];
		$jobs_id=$cjg11['jobs_id'];
		$sqq="select * from ".table('personal_jobs_apply')." where resume_id='{$resume_id}' and jobs_id='{$jobs_id}'";
		$get=$db->getone($sqq);
		$sql="update ".table('company_label_resume')." set resume_state=8,resume_state_cn='��ȡ��' where id='{$id}'";
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
		$tongzhifou3=$db->getone("select * from ".table('sms_config')." where name='set_qxbaoming'");
		$tongzhifou7=$db->getone("select * from ".table('weixin_config')." where name='set_qxbaoming'");
		if($result){
			
			$access_token = get_access_token();
			$content="���ã����Ѿ��ɹ�ȡ����'".$get['jobs_name']."'ְλ�ı���
					��ְ���ƣ�'".$get['jobs_name']."'
					������'".$ddd['contact']."'
					��ϵ�绰��'".$ddd['telephone']."'
					����鿴��ְ��������";
					
					
			if($eee['weixin_openid']){
				if($tongzhifou7['value']==1){
					send_weixin_msg($eee['weixin_openid'],$content,$access_token);
				}
			} 
			
			if($eee['mobile']){
				if($tongzhifou3['value']==1){
					$r=send_sms($eee['mobile'],$content);
				}
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

?>