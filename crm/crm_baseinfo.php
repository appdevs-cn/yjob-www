<?php
 /*
 * 74cms ����
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
require_once(CRM_ROOT_PATH.'include/crm_baseinfo_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'account_info_list';
check_permissions($_SESSION['crm_admin_purview'],"account_info");
$smarty->assign('pageheader',"�˻���Ϣ����");
if($act == 'account_info_list')
{
	get_token();
	// $smarty->assign('navlabel',"group");
	$smarty->assign('account_list',get_account_list());	
	$smarty->display('baseinfo/crm_account_list.htm');
}
elseif($act == 'account_add')
{
	get_token();
	$smarty->assign('navlabel',"group");
	$smarty->display('baseinfo/crm_account_add.htm');
}
elseif($act == 'account_add_save')
{
	check_token();
	$setsqlarr['accountname']=!empty($_POST['accountname']) ?trim($_POST['accountname']) : crmmsg("����д�˻�����",1);
	$setsqlarr['bank']=!empty($_POST['bank']) ?trim($_POST['bank']) : crmmsg("����д������",1);
	$setsqlarr['account']=!empty($_POST['account']) ?trim($_POST['account']) : crmmsg("����д�˺�",1);
	$setsqlarr['amount_money']=trim($_POST['amount_money']);
	$setsqlarr['remark']=trim($_POST['remark']);
	$link[0]['text'] = "�˻��б�";
	$link[0]['href'] = '?act=account_info_list';
	$link[1]['text'] = "��������˻�";
	$link[1]['href'] = "?act=account_add";
	inserttable(table('crm_account'),$setsqlarr)?crmmsg("��ӳɹ���",2,$link):crmmsg("���ʧ�ܣ�",0);	
	
}
elseif($act == 'account_edit')
{
	get_token();
	// $smarty->assign('navlabel',"group");
	$smarty->assign('account',get_account_one($_GET['id']));
	$smarty->display('baseinfo/crm_account_edit.htm');
}
elseif($act == 'account_edit_save')
{
	check_token();
	$setsqlarr['accountname']=!empty($_POST['accountname']) ?trim($_POST['accountname']) : crmmsg("����д�˻�����",1);
	$setsqlarr['bank']=!empty($_POST['bank']) ?trim($_POST['bank']) : crmmsg("����д������",1);
	$setsqlarr['account']=!empty($_POST['account']) ?trim($_POST['account']) : crmmsg("����д�˺�",1);
	$setsqlarr['amount_money']=trim($_POST['amount_money']);
	$setsqlarr['remark']=trim($_POST['remark']);
	$link[0]['text'] = "�˻��б�";
	$link[0]['href'] = '?act=account_info_list';
	$link[1]['text'] = "�鿴�޸Ľ��";
	$link[1]['href'] = "?act=account_edit&id=".$_POST['id'];
	updatetable(table('crm_account'),$setsqlarr," id=".intval($_POST['id']))?'':crmmsg("�޸�ʧ�ܣ�",0);
	crmmsg("�޸ĳɹ���",2,$link);	
}
elseif($act == 'account_del')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_account($id))
	{
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",1);
	}
}
elseif($act == 'employee_list')
{
	get_token();
	// $smarty->assign('navlabel',"group");
	$smarty->assign('employee_list',get_employee_list());	
	$smarty->display('baseinfo/crm_employee_list.htm');
}
elseif($act == 'employee_add')
{
	get_token();
	$smarty->assign('departments',get_departments());
	$smarty->display('baseinfo/crm_employee_add.htm');
}
elseif($act == 'employee_add_save')
{
	check_token();
	$setsqlarr['name']=!empty($_POST['name']) ?trim($_POST['name']) : crmmsg("����дԱ������",1);
	$setsqlarr['sex']=trim($_POST['sex']);
	$setsqlarr['birthday']=strtotime($_POST['birthday']);
	$setsqlarr['education']=trim($_POST['education']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['phone']=trim($_POST['phone']);
	$setsqlarr['mobile']=trim($_POST['mobile']);
	$setsqlarr['department']=intval($_POST['department']);
	$setsqlarr['job_position']=trim($_POST['job_position']);
	$setsqlarr['wage']=trim($_POST['wage']);
	$setsqlarr['address']=trim($_POST['address']);
	$setsqlarr['postalcode']=trim($_POST['postalcode']);
	$setsqlarr['remark']=trim($_POST['remark']);
	$link[0]['text'] = "Ա���б�";
	$link[0]['href'] = '?act=employee_list';
	$link[1]['text'] = "�������Ա��";
	$link[1]['href'] = "?act=employee_add";
	inserttable(table('crm_employee'),$setsqlarr)?crmmsg("��ӳɹ���",2,$link):crmmsg("���ʧ�ܣ�",0);	
	
}
elseif($act == 'employee_edit')
{
	get_token();
	// $smarty->assign('navlabel',"group");
	$smarty->assign('departments',get_departments());
	$smarty->assign('employee',get_employee_one($_GET['id']));
	$smarty->display('baseinfo/crm_employee_edit.htm');
}
elseif($act == 'employee_edit_save')
{
	check_token();
	$setsqlarr['name']=!empty($_POST['name']) ?trim($_POST['name']) : crmmsg("����дԱ������",1);
	$setsqlarr['sex']=trim($_POST['sex']);
	$setsqlarr['birthday']=strtotime($_POST['birthday']);
	$setsqlarr['education']=trim($_POST['education']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['phone']=trim($_POST['phone']);
	$setsqlarr['mobile']=trim($_POST['mobile']);
	$setsqlarr['department']=intval($_POST['department']);
	$setsqlarr['job_position']=trim($_POST['job_position']);
	$setsqlarr['wage']=trim($_POST['wage']);
	$setsqlarr['address']=trim($_POST['address']);
	$setsqlarr['postalcode']=trim($_POST['postalcode']);
	$setsqlarr['remark']=trim($_POST['remark']);
	$link[0]['text'] = "Ա���б�";
	$link[0]['href'] = '?act=employee_list';
	$link[1]['text'] = "�鿴�޸Ľ��";
	$link[1]['href'] = "?act=employee_edit&id=".$_POST['id'];
	updatetable(table('crm_employee'),$setsqlarr," id=".intval($_POST['id']))?'':crmmsg("�޸�ʧ�ܣ�",0);
	crmmsg("�޸ĳɹ���",2,$link);	
}
elseif($act == 'employee_del')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_employee($id))
	{
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",1);
	}
}
?>