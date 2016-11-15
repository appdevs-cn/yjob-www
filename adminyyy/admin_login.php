<?php
 /*
 * 74cms µÇÂ¼Ò³Ãæ
 * ============================================================================
 * °æÈ¨ËùÓÐ: ÆïÊ¿ÍøÂç£¬²¢±£ÁôËùÓÐÈ¨Àû¡£
 * ÍøÕ¾µØÖ·: http://www.74cms.com£»
 * ----------------------------------------------------------------------------
 * Õâ²»ÊÇÒ»¸ö×ÔÓÉÈí¼þ£¡ÄúÖ»ÄÜÔÚ²»ÓÃÓÚÉÌÒµÄ¿µÄµÄÇ°ÌáÏÂ¶Ô³ÌÐò´úÂë½øÐÐÐÞ¸ÄºÍ
 * Ê¹ÓÃ£»²»ÔÊÐí¶Ô³ÌÐò´úÂëÒÔÈÎºÎÐÎÊ½ÈÎºÎÄ¿µÄµÄÔÙ·¢²¼¡£
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/admin_common.inc.php');
// echo QISHI_ROOT_PATH;exit; // 项目根目录
// echo dirname(__FILE__);exit; // 当前文件的目录
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'login';
if($act == 'logout')
{
	unset($_SESSION['admin_id']);
	unset($_SESSION['admin_name']);
	unset($_SESSION['admin_purview']);
	setcookie('Qishi[admin_id]',"",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	setcookie('Qishi[admin_name]',"",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	setcookie('Qishi[admin_pwd]',"",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
	header("Location:?act=login");
}
elseif($act == 'login')
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	$smarty->assign('data','Êý¾ÝÊÇÓÃsmarty½øÐÐ´«ÊäµÄ!');
	if(isset($_SESSION['admin_id'],$_SESSION['admin_name'],$_SESSION['admin_purview']))
	{
	header("Location: admin_index.php"); 
	}
	$smarty->assign('random',mt_rand());
	$smarty->assign("QISHI_VERSION",QISHI_VERSION);
	get_token();
	$captcha=get_cache('captcha');
	$smarty->assign('verify_adminlogin',$captcha['verify_adminlogin']);
	$smarty->display('sys/admin_login.htm');
}
elseif($act == 'do_login')
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
 	$admin_name = isset($_POST['admin_name']) ? trim($_POST['admin_name']) : '';
 	$admin_pwd = isset($_POST['admin_pwd']) ? trim($_POST['admin_pwd']) : '';
	$postcaptcha = isset($_POST['postcaptcha']) ? $_POST['postcaptcha'] : '';
 	$remember = isset($_POST['rememberme']) ? intval($_POST['rememberme']) : 0;
 	if($admin_name == '')
	{
	header("Location:?act=login&err=".urlencode('ÓÃ»§Ãû²»ÄÜÎª¿Õ'));
	exit();
 	}
 	elseif($admin_pwd == '')
	{
	header("Location:?act=login&err=".urlencode('ÃÜÂë²»ÄÜÎª¿Õ'));
	exit();
 	}
	$captcha=get_cache('captcha');
	if(empty($postcaptcha) && $captcha['verify_adminlogin']=='1')
	{
		header("Location:?act=login&err=".urlencode('ÑéÖ¤Âë²»ÄÜÎª¿Õ'));
		exit();
 	}
	if ($captcha['verify_adminlogin']=='1' && strcasecmp($_SESSION['imageCaptcha_content'],$postcaptcha)!=0)
	{
		write_log("<span style=\"color:#FF0000\">ÑéÖ¤ÂëÌîÐ´´íÎó</span>",$admin_name,2);
		header("Location:?act=login&err=".urlencode('ÑéÖ¤ÂëÌîÐ´´íÎó'));
		exit();
	}
 	elseif(check_admin($admin_name,$admin_pwd))
	{
		$admininfo=get_admin_one($admin_name);
		if(!in_array($_CFG['subsite_id'],explode(',',$admininfo['site_purview'])) && $admininfo['purview']<>"all"){
			write_log("<span style=\"color:#FF0000\">ÄúÃ»ÓÐ¹ÜÀíÈ¨ÏÞ</span>",$admin_name,2);
			header("Location:?act=login&err=".urlencode('Ã»ÓÐ¹ÜÀíÈ¨ÏÞ'));
			exit();
		}
 		update_admin_info($admin_name);
		write_log("³É¹¦µÇÂ¼",$admin_name);
 		if($remember == 1)
		{
			$admininfo=get_admin_one($admin_name);
 			setcookie('Qishi[admin_id]', $_SESSION['admin_id'], time()+86400, $QS_cookiepath, $QS_cookiedomain);
 			setcookie('Qishi[admin_name]', $admin_name, time()+86400, $QS_cookiepath, $QS_cookiedomain);
			setcookie('Qishi[admin_pwd]', md5($admin_name.$admininfo['pwd'].$admininfo['pwd_hash'].$QS_pwdhash), time()+86400, $QS_cookiepath, $QS_cookiedomain);
 		}
 	}
	else
	{
		write_log("<span style=\"color:#FF0000\">ÓÃ»§Ãû»òÃÜÂë´íÎó</span>",$admin_name,2);
		header("Location:?act=login&err=".urlencode('ÓÃ»§Ãû»òÃÜÂë´íÎó'));
		exit();
 	}
header("Location: admin_index.php"); 
}
?>