<?php
 /*
 * 74cms �ٱ�
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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

$resume_id=$_REQUEST['resume_id']?intval($_REQUEST['resume_id']):exit("������Ϣ��");
$jobs_id=$setarr['jobs_id']=$_REQUEST['jobs_id'];
$status = $_REQUEST['status']?intval($_REQUEST['status']):exit("״̬����Ϊ��!");
$udata['enroll_ids'] = array($resume_id);
$udata['status'] = $status;
$uRst = https_request_api('enroll/status', $udata);
if(!$uRst) {
    exit("���ʧ��!");
}

$uid=intval($_SESSION['uid']);
$pid=$uRst['data'][$resume_id]['uid'];
$panzi = $db->getone("SELECT * from ".table('members_info')." where uid={$pid} limit 1");
$panzi1 = $db->getone("SELECT * from ".table('members')." where uid={$pid} limit 1");
$panzi2 = $db->getone("SELECT * from ".table('company_profile')." where uid={$uid} limit 1");
$row=$uRst['data'][$resume_id];
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
	if($row['status']== 200){
		//΢������
		
		if($panzi1['weixin_openid']){
			if($tongzhifou5['value']==1){
				
				set_apply_heshi($panzi1['weixin_openid'],$row['job_name'],$row['job_id'],$panzi['realname'],'�밴ʱ�ϸڣ�');
			}
		}
		
		//���Ͷ���֪ͨ
		
		if($panzi1['mobile']){
			//$content=strip_tags($content);
			$content="�𾴵�".$panzi['realname']."�������".$row['job_name']."�Ѿ����ͨ���������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou1['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
		
	}elseif($row['status']== 400){
		
		if($panzi1['weixin_openid']){
			if($tongzhifou6['value']==1){
				set_apply_buheshi($panzi1['weixin_openid'],$panzi['realname'],$row['job_name'],$row['job_id']);
			}
		}
		
		if($panzi1['mobile']){
			$content="�𾴵�".$panzi['realname']."�������".$row['job_name']."δ��ͨ����ˣ������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou2['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
	}elseif($row['status']== 302){
	
		if($panzi1['weixin_openid']){
			if($tongzhifou8['value']==1){
				set_apply_fanggezi($panzi1['weixin_openid'],'����Ӱ������������',$row['job_id']);
			}
		}
		
		if($panzi1['mobile']){
			$content="�𾴵�".$panzi['realname']."���������".$row['job_name']."�����Ϊ�˷Ÿ���״̬�������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou4['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
	}elseif($row['status']== 500){
		
		if($panzi1['weixin_openid']){
			if($tongzhifou7['value']==1){
				set_apply_quxiao($panzi1['weixin_openid'],$row['job_name'],$panzi['realname'],$panzi1['mobile'],$row['job_id']);
			}
		} 
		if($panzi1['mobile']){
			$content="�𾴵�".$panzi['realname']."�������".$row['job_name']."�Ѿ�ȡ���������Ƽ�ְApp��ʵʱ�˽⹤������http://t.cn/RtOcIYd��";
			if($tongzhifou3['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
	}
        $usdata['check_status'] = 200;
        $usdata['enroll_id'] = $row['id'];
        $curst = https_request_api('enroll/update', $usdata);
        
exit("ok");
?>
