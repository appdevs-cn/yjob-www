<?php
 /*
 * 74cms �ٱ�
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã��������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
require_once(QISHI_ROOT_PATH.'include/admin_weixin_fun.php');
require_once(QISHI_ROOT_PATH.'include/fun_weixin.php');
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);

if((empty($_SESSION['uid']) || empty($_SESSION['username']) || empty($_SESSION['utype'])) &&  $_COOKIE['QS']['username'] && $_COOKIE['QS']['password'] && $_COOKIE['QS']['uid'])
{
	require_once(QISHI_ROOT_PATH.'include/fun_user.php');
	if(check_cookie($_COOKIE['QS']['uid'],$_COOKIE['QS']['username'],$_COOKIE['QS']['password']))
	{
	update_user_info($_COOKIE['QS']['uid'],false,false);
	header("Location:".get_member_url($_SESSION['utype']));
	}
	else
	{
	unset($_SESSION['uid'],$_SESSION['username'],$_SESSION['utype'],$_SESSION['uqqid'],$_SESSION['activate_username'],$_SESSION['activate_email'],$_SESSION["openid"]);
	setcookie("QS[uid]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	setcookie('QS[username]',"", time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	setcookie('QS[password]',"", time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	setcookie("QS[utype]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	}
}
if ($_SESSION['uid']=='' || $_SESSION['username']=='')
{
	$captcha=get_cache('captcha');
	$smarty->assign('verify_userlogin',$captcha['verify_userlogin']);
	$smarty->display('plus/ajax_login.htm');
	exit();
}
if ($_SESSION['utype']!='1')
{
	exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		    <tr>
				<td width="20" align="right"></td>
				<td>
					��������ҵ��Ա�ſ��ԶԼ������б��״̬��
				</td>
		    </tr>
		</table>');
}
require_once(QISHI_ROOT_PATH.'include/fun_company.php');
$user=get_user_info($_SESSION['uid']);
if ($user['status']=="2") 
{
	exit('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		    <tr>
				<td width="20" align="right"></td>
				<td>
					�����˺Ŵ�����ͣ״̬������ϵ����Ա��Ϊ��������в�����
				</td>
		    </tr>
		</table>');
}

$resume_id=$_REQUEST['resume_id']?intval($_REQUEST['resume_id']):exit("����ID��ʧ��");
$setarr['resume_state']=$_REQUEST['resume_state']?intval($_REQUEST['resume_state']):exit("���״̬����");
$setarr['resume_state_cn']=$_REQUEST['resume_state_cn']?iconv('utf-8', 'gbk',trim($_REQUEST['resume_state_cn'])):exit("���״̬����");
$jobs_id=$setarr['jobs_id']=$_REQUEST['jobs_id'];

$setarr_lr['resume_state']=$_REQUEST['resume_state']?intval($_REQUEST['resume_state']):exit("���״̬����");
$setarr_lr['resume_state_cn']=$_REQUEST['resume_state_cn']?iconv('utf-8', 'gbk',trim($_REQUEST['resume_state_cn'])):exit("���״̬����");


/* $p_uid = $db->getone("SELECT uid FROM ".table('resume')." WHERE id={$resume_id} LIMIT 1 ");
$uid=intval($_SESSION['uid']);
$row=$db->getone("select resume_id from ".table("company_label_resume")." where uid=$uid and resume_id=$resume_id and jobs_id=$jobs_id limit 1"); */
$p_uid = $db->getone("SELECT uid FROM ".table('resume')." WHERE id={$resume_id} LIMIT 1 ");
$jobss = $db->getone("SELECT * FROM ".table('jobs')." WHERE id={$jobs_id} LIMIT 1 ");
$uid=intval($_SESSION['uid']);
$pid=$p_uid['uid'];
$panzi = $db->getone("SELECT * from ".table('members_info')." where uid={$pid} limit 1");
$panzi1 = $db->getone("SELECT * from ".table('members')." where uid={$pid} limit 1");
$panzi2 = $db->getone("SELECT * from ".table('company_profile')." where uid={$uid} limit 1");
$row=$db->getone("select resume_id from ".table("company_label_resume")." where uid=$uid and resume_id=$resume_id and jobs_id=$jobs_id limit 1");
	
	//$pid=$p_uid['uid'];
	
	//$value = $db->getone("select * from ".table('members')." where uid={$pid}";
	//$valuee = $db->getone("select * from ".table('members_info')." where uid={$pid}";
	//$valueee = $db->getone("select * from ".table('company_profile')." where uid='{$uid}'";
	$access_token = get_access_token();
	if(empty($access_token)){
		adminmsg("access_token��ȡʧ�ܣ�",1);
	}
	
	$time=time();
	$ttime=date('Y��m��d�� H:i',$time);
$tongzhifou1=$db->getone("select * from ".table('sms_config')." where name='set_jianlihs'");
$tongzhifou2=$db->getone("select * from ".table('sms_config')." where name='set_jianlibhs'");
$tongzhifou3=$db->getone("select * from ".table('sms_config')." where name='set_qxbaoming'");
$tongzhifou4=$db->getone("select * from ".table('sms_config')." where name='set_fanggz'");
$tongzhifou5=$db->getone("select * from ".table('weixin_config')." where name='set_jianlihs'");
$tongzhifou6=$db->getone("select * from ".table('weixin_config')." where name='set_jianlibhs'");
$tongzhifou7=$db->getone("select * from ".table('weixin_config')." where name='set_qxbaoming'");
$tongzhifou8=$db->getone("select * from ".table('weixin_config')." where name='set_fanggz'");
$timeee=date('Y-m-d H:i');
if(empty($row))
{
	$setarr_lable_resume['resume_id']=$resume_id;
	$setarr_lable_resume['jobs_id']=$jobs_id;
	$setarr_lable_resume['uid']=$uid;
	$setarr_lable_resume['personal_uid']=$p_uid['uid'];
	
	//$jobss['contents']=str_replace("<br />",'',htmlspecialchars_decode(strip_tags($jobss['contents']),ENT_QUOTES));
	$jobss['contents']=strip_tags(str_replace('&nbsp;','',htmlspecialchars_decode(strip_tags($jobss['contents']),ENT_QUOTES)));
	if($setarr_lr['resume_state']==1){
		//΢������
		
		
		if($panzi1['weixin_openid']){
			
			if($tongzhifou5['value']==1){
				set_apply_heshi($panzi1['weixin_openid'],$jobss['jobs_name'],$jobss['id'],$panzi['realname'],'�밴ʱ�ϸڣ�');
			}
		}
		
		//���Ͷ���֪ͨ
		if($panzi1['mobile']){
			$content="�𾴵�".$panzi['realname']."���������".$jobss['jobs_name']."�Ѿ����ͨ���������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou1['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		
		}
	}elseif($setarr_lr['resume_state']==2){
	
		if($panzi1['weixin_openid']){
			if($tongzhifou6['value']==1){
				set_apply_buheshi($panzi1['weixin_openid'],$panzi['realname'],$jobss['jobs_name'],$jobss['id']);
			}
		}
		
		if($panzi1['mobile']){
			$content="�𾴵�".$panzi['realname']."���������".$jobss['jobs_name']."δ��ͨ����ˣ������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou2['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
	}
	$db->inserttable(table('company_label_resume'),$setarr_lable_resume);
	//���鿴״̬���³��Ѿ��鿴
	$db->updatetable(table('personal_jobs_apply'),array('personal_look'=>'2','is_reply'=>$setarr['resume_state']),array("company_uid"=>$uid,"resume_id"=>$resume_id,'jobs_id'=>$setarr['jobs_id']));
}
else
{
	$jobss['contents']=strip_tags(str_replace('&nbsp;','',htmlspecialchars_decode(strip_tags($jobss['contents']),ENT_QUOTES)));
	
	if($setarr_lr['resume_state']==1){
		//΢������
		
		
		
		if($panzi1['weixin_openid']){
			if($tongzhifou5['value']==1){
				
				set_apply_heshi($panzi1['weixin_openid'],$jobss['jobs_name'],$jobss['id'],$panzi['realname'],'�밴ʱ�ϸڣ�');
			}
		}
		
		//���Ͷ���֪ͨ
		
		if($panzi1['mobile']){
			//$content=strip_tags($content);
			$content="�𾴵�".$panzi['realname']."�������".$jobss['jobs_name']."�Ѿ����ͨ���������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou1['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
		
	}elseif($setarr_lr['resume_state']==2){
		
		if($panzi1['weixin_openid']){
			if($tongzhifou6['value']==1){
				set_apply_buheshi($panzi1['weixin_openid'],$panzi['realname'],$jobss['jobs_name'],$jobss['id']);
			}
		}
		
		if($panzi1['mobile']){
			$content="�𾴵�".$panzi['realname']."�������".$jobss['jobs_name']."δ��ͨ����ˣ������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou2['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
	}elseif($setarr_lr['resume_state']==4){
	
		if($panzi1['weixin_openid']){
			if($tongzhifou8['value']==1){
				set_apply_fanggezi($panzi1['weixin_openid'],'����Ӱ������������',$jobss['id']);
			}
		}
		
		if($panzi1['mobile']){
			$content="�𾴵�".$panzi['realname']."���������".$jobss['jobs_name']."�����Ϊ�˷Ÿ���״̬�������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou4['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
	}elseif($setarr_lr['resume_state']==8){
		
		if($panzi1['weixin_openid']){
			if($tongzhifou7['value']==1){
				set_apply_quxiao($panzi1['weixin_openid'],$jobss['jobs_name'],$panzi['realname'],$panzi1['mobile'],$jobss['id']);
			}
		} 
		
		if($panzi1['mobile']){
			$content="�𾴵�".$panzi['realname']."�������".$jobss['jobs_name']."�Ѿ�ȡ���������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou3['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
	}
	$db->updatetable(table('company_label_resume'),$setarr_lr,array("uid"=>$uid,"resume_id"=>$resume_id,"jobs_id"=>$jobs_id));
	//���鿴״̬���³��Ѿ��鿴
	$db->updatetable(table('personal_jobs_apply'),array('personal_look'=>'2','is_reply'=>$setarr['resume_state']),array("company_uid"=>$uid,"resume_id"=>$resume_id,'jobs_id'=>$setarr['jobs_id']));
}
exit("ok");
?>