<?php
 /*
 * 74cms 管理员账户
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/crm_common.inc.php');
require_once(CRM_ROOT_PATH.'include/crm_users_fun.php');
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'list';
$smarty->assign('pageheader',"系统用户");
if($act == 'list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	if ($_SESSION['crm_admin_purview']<>"all")
	{
		$wheresql=" WHERE admin_name='".$_SESSION['crm_admin_name']."'";
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('admin').$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$list = get_admin_list($offset,$perpage,$wheresql);	
	$smarty->assign('list',$list);
	$smarty->assign('crm_admin_purview',$_SESSION['crm_admin_purview']);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('navlabel','list');	
	$smarty->display('users/crm_users_list.htm');
}
elseif($act == 'add_users')
{
	get_token();
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("权限不足！",1);
	$smarty->assign('navlabel','add');	
	$smarty->display('users/crm_users_add.htm');
}
elseif($act == 'add_users_save')
{
	check_token();
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("权限不足！",1);
	$setsqlarr['admin_name']=trim($_POST['admin_name'])?trim($_POST['admin_name']):crmmsg('请填写用户名！',1);
	if (get_admin_one($setsqlarr['admin_name']))crmmsg('用户名已经存在！',1);
	$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):crmmsg('请填写email！',1);
	if (!preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/",$setsqlarr['email']))crmmsg('email格式错误！',1);
	$password=trim($_POST['password'])?trim($_POST['password']):crmmsg('请填写密码',1);
	if (strlen($password)<6)crmmsg('密码不能少于6位！',1);
	if ($password<>trim($_POST['password1']))crmmsg('两次输入的密码不相同！',1);
	$setsqlarr['rank']=trim($_POST['rank'])?trim($_POST['rank']):crmmsg('请填写头衔',1);
	$setsqlarr['tel']=trim($_POST['tel']);
	$setsqlarr['add_time']=time();
	$setsqlarr['last_login_time']=0;
	$setsqlarr['last_login_ip']="从未";
	$setsqlarr['pwd_hash']=randstr();
	$setsqlarr['pwd']=md5($password.$setsqlarr['pwd_hash'].$QS_pwdhash);		
	if (inserttable(table('crm_admin'),$setsqlarr))
	{
		$link[0]['text'] = "返回列表";
		$link[0]['href'] ="?act=";
		crmmsg('添加成功！',2,$link);
	}
	else
	{
	crmmsg('添加失败',1);
	}	
}
elseif($act == 'del_users')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_users($id,$_SESSION['crm_admin_purview']))
	{
	crmmsg("删除成功！共删除".$num."行",2);
	}
	else
	{
	crmmsg("删除失败！",0);
	}
}
elseif($act == 'edit_users')
{
	get_token();
	$id=intval($_GET['id']);
	$account=get_admin_account($id);
	if ($account['admin_name']==$_SESSION['crm_admin_name'] || $_SESSION['crm_admin_purview']=="all")
	{
	$smarty->assign('account',$account);
	$smarty->assign('crm_admin_purview',$_SESSION['crm_admin_purview']);
	$smarty->display('users/crm_users_edit.htm');
	}
	else
	{
	crmmsg("参数错误！",1);
	}
}
elseif($act == 'edit_users_pwd')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"password_edit");
	$id=intval($_GET['id']);
	$account=get_admin_account($id);
	if ($account['admin_name']==$_SESSION['crm_admin_name'] || $_SESSION['crm_admin_purview']=="all")
	{
	$smarty->assign('account',$account);
	$smarty->assign('crm_admin_purview',$_SESSION['crm_admin_purview']);
	$smarty->display('users/crm_users_edit_pwd.htm');
	}
	else
	{
	crmmsg("参数错误！",1);
	}
}
elseif($act == 'edit_users_info_save' && $_SESSION['crm_admin_purview']=="all")//超级管理员才可以修改资料
{
	check_token();
		$id=intval($_POST['id']);
		$account=get_admin_account($id);
		if ($account['purview']=="all")crmmsg("参数错误！",1);//超级管理员的资料不能修改
		$setsqlarr['admin_name']=trim($_POST['admin_name'])?trim($_POST['admin_name']):crmmsg('用户名不能为空！',1);
		$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):crmmsg('email不能为空！',1);
		$setsqlarr['rank']=trim($_POST['rank'])?trim($_POST['rank']):crmmsg('头衔不能为空！',1);
		$setsqlarr['tel']=trim($_POST['tel']);
			$sql = "select * from ".table('crm_admin')." where admin_name = '".$$setsqlarr['admin_name']."' AND admin_id<>".$id;
			$ck_info=$db->getone($sql);
			if (!empty($ck_info))crmmsg("用户名有重复！",1);
		if (updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id))
		{
			crmmsg("修改成功！",2);
		 }
		 else
		{
			crmmsg("修改失败！",0);
		 }
}
elseif($act == 'edit_users_pwd_save')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"password_edit");
	$id=intval($_POST['id']);
	$account=get_admin_account($id);
	if ($account['purview']=="all" && $_SESSION['crm_admin_purview']=="all")
	{
				if (strlen($_POST['password'])<6)crmmsg("密码长度不能小于6位！",1);
				if ($_POST['password']<>$_POST['password1'])crmmsg("两次输入的密码不同！",1);		
				$md5_pwd=md5($_POST['old_password'].$account['pwd_hash'].$QS_pwdhash);
				if ($md5_pwd<>$account['pwd'])crmmsg("旧密码输入错误！",1);
				$setsqlarr['pwd']=md5($_POST['password'].$account['pwd_hash'].$QS_pwdhash);
				if (updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id))
				{
					crmmsg("修改成功！",2);
				 }
				 else
				 {
					crmmsg("修改失败！",0);
				 }
	}
	else
	{
				if ($_SESSION['crm_admin_purview']=="all")
				{
					if (strlen($_POST['password'])<6)crmmsg("密码长度不能小于6位！",1);
					$setsqlarr['pwd']=md5($_POST['password'].$account['pwd_hash'].$QS_pwdhash);
					if (!updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id)) crmmsg("修改失败！",0);
				}
				else
				{
					if (strlen($_POST['password'])<6)crmmsg("密码长度不能小于6位！",1);
					if ($_POST['password']<>$_POST['password1'])crmmsg("两次输入的密码不同！",1);		
					$md5_pwd=md5($_POST['old_password'].$account['pwd_hash'].$QS_pwdhash);
					if ($md5_pwd<>$account['pwd'])crmmsg("旧密码输入错误！",1);
					$setsqlarr['pwd']=md5($_POST['password'].$account['pwd_hash'].$QS_pwdhash);
					if (!updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id)) crmmsg("修改失败！",0);
				}
				 crmmsg("修改成功！",2);
	}
}
elseif($act == 'loglist')
{
	get_token();
	$adminname=trim($_GET['adminname']);
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	if ($_SESSION['crm_admin_purview']=="all")//超级管理员可以查看任何管理员的日志
	{
		$wheresql="";
		if ($_GET['adminname']<>'')
		{
		$wheresql=" WHERE admin_name='".$_GET['adminname']."'";
		}
	}
	else
	{
		$wheresql=" WHERE admin_name='".$_SESSION['crm_admin_name']."'";
	}
	if (!empty($_GET['log_type']))
	{
		$wheresql=empty($wheresql)?" WHERE log_type= ".intval($_GET['log_type']):$wheresql." AND log_type=".intval($_GET['log_type']);
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('admin_log').$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$list = get_admin_log($offset,$perpage,$wheresql);
	$smarty->assign('pageheader',"登录日志");
	$smarty->assign('list',$list);//列表
	$smarty->assign('perpage',$perpage);//每页显示数量POST
		if ($total_val>$perpage)
		{
		$smarty->assign('page',$page->show(3));//分页符
		}
	$smarty->display('users/crm_users_log.htm');
}
elseif($act == 'users_set')
{
	get_token();
	$id=intval($_GET['id']);
	$account=get_admin_account($id);
	$smarty->assign('account',$account);
	$smarty->assign('crm_admin_purview',$_SESSION['crm_admin_purview']);
	$smarty->assign('admin_set',explode(',',$account['purview']));
	$smarty->display('users/crm_users_set.htm');
}
elseif($act == 'users_set_save')
{
	check_token();
	$id=intval($_POST['id']);
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("权限不足！",1);
	$setsqlarr['purview']=$_POST['purview'];
	$setsqlarr['purview']=implode(',',$setsqlarr['purview']);
		if (updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id))
		{
			crmmsg("设置成功！",2);
		 }
		 else
		{
			crmmsg("设置失败！",0);
		 }
}
?>