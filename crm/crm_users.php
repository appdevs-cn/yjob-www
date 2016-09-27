<?php
 /*
 * 74cms ����Ա�˻�
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/crm_common.inc.php');
require_once(CRM_ROOT_PATH.'include/crm_users_fun.php');
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'list';
$smarty->assign('pageheader',"ϵͳ�û�");
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
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("Ȩ�޲��㣡",1);
	$smarty->assign('navlabel','add');	
	$smarty->display('users/crm_users_add.htm');
}
elseif($act == 'add_users_save')
{
	check_token();
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("Ȩ�޲��㣡",1);
	$setsqlarr['admin_name']=trim($_POST['admin_name'])?trim($_POST['admin_name']):crmmsg('����д�û�����',1);
	if (get_admin_one($setsqlarr['admin_name']))crmmsg('�û����Ѿ����ڣ�',1);
	$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):crmmsg('����дemail��',1);
	if (!preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/",$setsqlarr['email']))crmmsg('email��ʽ����',1);
	$password=trim($_POST['password'])?trim($_POST['password']):crmmsg('����д����',1);
	if (strlen($password)<6)crmmsg('���벻������6λ��',1);
	if ($password<>trim($_POST['password1']))crmmsg('������������벻��ͬ��',1);
	$setsqlarr['rank']=trim($_POST['rank'])?trim($_POST['rank']):crmmsg('����дͷ��',1);
	$setsqlarr['tel']=trim($_POST['tel']);
	$setsqlarr['add_time']=time();
	$setsqlarr['last_login_time']=0;
	$setsqlarr['last_login_ip']="��δ";
	$setsqlarr['pwd_hash']=randstr();
	$setsqlarr['pwd']=md5($password.$setsqlarr['pwd_hash'].$QS_pwdhash);		
	if (inserttable(table('crm_admin'),$setsqlarr))
	{
		$link[0]['text'] = "�����б�";
		$link[0]['href'] ="?act=";
		crmmsg('��ӳɹ���',2,$link);
	}
	else
	{
	crmmsg('���ʧ��',1);
	}	
}
elseif($act == 'del_users')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_users($id,$_SESSION['crm_admin_purview']))
	{
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
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
	crmmsg("��������",1);
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
	crmmsg("��������",1);
	}
}
elseif($act == 'edit_users_info_save' && $_SESSION['crm_admin_purview']=="all")//��������Ա�ſ����޸�����
{
	check_token();
		$id=intval($_POST['id']);
		$account=get_admin_account($id);
		if ($account['purview']=="all")crmmsg("��������",1);//��������Ա�����ϲ����޸�
		$setsqlarr['admin_name']=trim($_POST['admin_name'])?trim($_POST['admin_name']):crmmsg('�û�������Ϊ�գ�',1);
		$setsqlarr['email']=trim($_POST['email'])?trim($_POST['email']):crmmsg('email����Ϊ�գ�',1);
		$setsqlarr['rank']=trim($_POST['rank'])?trim($_POST['rank']):crmmsg('ͷ�β���Ϊ�գ�',1);
		$setsqlarr['tel']=trim($_POST['tel']);
			$sql = "select * from ".table('crm_admin')." where admin_name = '".$$setsqlarr['admin_name']."' AND admin_id<>".$id;
			$ck_info=$db->getone($sql);
			if (!empty($ck_info))crmmsg("�û������ظ���",1);
		if (updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id))
		{
			crmmsg("�޸ĳɹ���",2);
		 }
		 else
		{
			crmmsg("�޸�ʧ�ܣ�",0);
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
				if (strlen($_POST['password'])<6)crmmsg("���볤�Ȳ���С��6λ��",1);
				if ($_POST['password']<>$_POST['password1'])crmmsg("������������벻ͬ��",1);		
				$md5_pwd=md5($_POST['old_password'].$account['pwd_hash'].$QS_pwdhash);
				if ($md5_pwd<>$account['pwd'])crmmsg("�������������",1);
				$setsqlarr['pwd']=md5($_POST['password'].$account['pwd_hash'].$QS_pwdhash);
				if (updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id))
				{
					crmmsg("�޸ĳɹ���",2);
				 }
				 else
				 {
					crmmsg("�޸�ʧ�ܣ�",0);
				 }
	}
	else
	{
				if ($_SESSION['crm_admin_purview']=="all")
				{
					if (strlen($_POST['password'])<6)crmmsg("���볤�Ȳ���С��6λ��",1);
					$setsqlarr['pwd']=md5($_POST['password'].$account['pwd_hash'].$QS_pwdhash);
					if (!updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id)) crmmsg("�޸�ʧ�ܣ�",0);
				}
				else
				{
					if (strlen($_POST['password'])<6)crmmsg("���볤�Ȳ���С��6λ��",1);
					if ($_POST['password']<>$_POST['password1'])crmmsg("������������벻ͬ��",1);		
					$md5_pwd=md5($_POST['old_password'].$account['pwd_hash'].$QS_pwdhash);
					if ($md5_pwd<>$account['pwd'])crmmsg("�������������",1);
					$setsqlarr['pwd']=md5($_POST['password'].$account['pwd_hash'].$QS_pwdhash);
					if (!updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id)) crmmsg("�޸�ʧ�ܣ�",0);
				}
				 crmmsg("�޸ĳɹ���",2);
	}
}
elseif($act == 'loglist')
{
	get_token();
	$adminname=trim($_GET['adminname']);
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	if ($_SESSION['crm_admin_purview']=="all")//��������Ա���Բ鿴�κι���Ա����־
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
	$smarty->assign('pageheader',"��¼��־");
	$smarty->assign('list',$list);//�б�
	$smarty->assign('perpage',$perpage);//ÿҳ��ʾ����POST
		if ($total_val>$perpage)
		{
		$smarty->assign('page',$page->show(3));//��ҳ��
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
	if ($_SESSION['crm_admin_purview']<>"all")crmmsg("Ȩ�޲��㣡",1);
	$setsqlarr['purview']=$_POST['purview'];
	$setsqlarr['purview']=implode(',',$setsqlarr['purview']);
		if (updatetable(table('crm_admin'),$setsqlarr,' admin_id='.$id))
		{
			crmmsg("���óɹ���",2);
		 }
		 else
		{
			crmmsg("����ʧ�ܣ�",0);
		 }
}
?>