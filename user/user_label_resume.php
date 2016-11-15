<?php
 /*
 * 74cms 举报
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
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
					必须是企业会员才可以对简历进行标记状态！
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
					您的账号处于暂停状态，请联系管理员设为正常后进行操作！
				</td>
		    </tr>
		</table>');
}

$resume_id=$_REQUEST['resume_id']?intval($_REQUEST['resume_id']):exit("报名信息！");
$jobs_id=$setarr['jobs_id']=$_REQUEST['jobs_id'];
$status = $_REQUEST['status']?intval($_REQUEST['status']):exit("状态不能为空!");
$udata['enroll_ids'] = array($resume_id);
$udata['status'] = $status;
$uRst = https_request_api('enroll/status', $udata);
if(!$uRst) {
    exit("审核失败!");
}

$uid=intval($_SESSION['uid']);
$pid=$uRst['data'][$resume_id]['uid'];
$panzi = $db->getone("SELECT * from ".table('members_info')." where uid={$pid} limit 1");
$panzi1 = $db->getone("SELECT * from ".table('members')." where uid={$pid} limit 1");
$panzi2 = $db->getone("SELECT * from ".table('company_profile')." where uid={$uid} limit 1");
$row=$uRst['data'][$resume_id];
	$access_token = get_access_token();
	if(empty($access_token)){
		adminmsg("access_token获取失败！",1);
	}
	
$time=time();
$ttime=date('Y年m月d日 H:i',$time);
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
		//微信推送
		
		if($panzi1['weixin_openid']){
			if($tongzhifou5['value']==1){
				
				set_apply_heshi($panzi1['weixin_openid'],$row['job_name'],$row['job_id'],$panzi['realname'],'请按时上岗！');
			}
		}
		
		//发送短信通知
		
		if($panzi1['mobile']){
			//$content=strip_tags($content);
			$content="尊敬的".$panzi['realname']."您申请的".$row['job_name']."已经审核通过！下载云兼职App，实时了解工作详情http://t.cn/RtOcIYd。";
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
			$content="尊敬的".$panzi['realname']."您申请的".$row['job_name']."未能通过审核！下载云兼职App，实时了解工作详情http://t.cn/RtOcIYd。";
			if($tongzhifou2['value']==1){
				$r=send_sms($panzi1['mobile'],$content);
			}
		}
	}elseif($row['status']== 302){
	
		if($panzi1['weixin_openid']){
			if($tongzhifou8['value']==1){
				set_apply_fanggezi($panzi1['weixin_openid'],'将会影响您的信誉！',$row['job_id']);
			}
		}
		
		if($panzi1['mobile']){
			$content="尊敬的".$panzi['realname']."，您申请的".$row['job_name']."被标记为了放鸽子状态！下载云兼职App，实时了解工作详情http://t.cn/RtOcIYd。";
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
			$content="尊敬的".$panzi['realname']."您申请的".$row['job_name']."已经取消！下载云兼职App，实时了解工作详情http://t.cn/RtOcIYd。";
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
