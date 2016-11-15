<?php
 /*
 * 74cms 分类
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
require_once(CRM_ROOT_PATH.'include/crm_baseinfo_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'account_info_list';
check_permissions($_SESSION['crm_admin_purview'],"account_info");
$smarty->assign('pageheader',"账户信息管理");
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
	$setsqlarr['accountname']=!empty($_POST['accountname']) ?trim($_POST['accountname']) : crmmsg("请填写账户名称",1);
	$setsqlarr['bank']=!empty($_POST['bank']) ?trim($_POST['bank']) : crmmsg("请填写开户行",1);
	$setsqlarr['account']=!empty($_POST['account']) ?trim($_POST['account']) : crmmsg("请填写账号",1);
	$setsqlarr['amount_money']=trim($_POST['amount_money']);
	$setsqlarr['remark']=trim($_POST['remark']);
	$link[0]['text'] = "账户列表";
	$link[0]['href'] = '?act=account_info_list';
	$link[1]['text'] = "继续添加账户";
	$link[1]['href'] = "?act=account_add";
	inserttable(table('crm_account'),$setsqlarr)?crmmsg("添加成功！",2,$link):crmmsg("添加失败！",0);	
	
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
	$setsqlarr['accountname']=!empty($_POST['accountname']) ?trim($_POST['accountname']) : crmmsg("请填写账户名称",1);
	$setsqlarr['bank']=!empty($_POST['bank']) ?trim($_POST['bank']) : crmmsg("请填写开户行",1);
	$setsqlarr['account']=!empty($_POST['account']) ?trim($_POST['account']) : crmmsg("请填写账号",1);
	$setsqlarr['amount_money']=trim($_POST['amount_money']);
	$setsqlarr['remark']=trim($_POST['remark']);
	$link[0]['text'] = "账户列表";
	$link[0]['href'] = '?act=account_info_list';
	$link[1]['text'] = "查看修改结果";
	$link[1]['href'] = "?act=account_edit&id=".$_POST['id'];
	updatetable(table('crm_account'),$setsqlarr," id=".intval($_POST['id']))?'':crmmsg("修改失败！",0);
	crmmsg("修改成功！",2,$link);	
}
elseif($act == 'account_del')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_account($id))
	{
	crmmsg("删除成功！共删除".$num."行",2);
	}
	else
	{
	crmmsg("删除失败！",1);
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
	$setsqlarr['name']=!empty($_POST['name']) ?trim($_POST['name']) : crmmsg("请填写员工姓名",1);
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
	$link[0]['text'] = "员工列表";
	$link[0]['href'] = '?act=employee_list';
	$link[1]['text'] = "继续添加员工";
	$link[1]['href'] = "?act=employee_add";
	inserttable(table('crm_employee'),$setsqlarr)?crmmsg("添加成功！",2,$link):crmmsg("添加失败！",0);	
	
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
	$setsqlarr['name']=!empty($_POST['name']) ?trim($_POST['name']) : crmmsg("请填写员工姓名",1);
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
	$link[0]['text'] = "员工列表";
	$link[0]['href'] = '?act=employee_list';
	$link[1]['text'] = "查看修改结果";
	$link[1]['href'] = "?act=employee_edit&id=".$_POST['id'];
	updatetable(table('crm_employee'),$setsqlarr," id=".intval($_POST['id']))?'':crmmsg("修改失败！",0);
	crmmsg("修改成功！",2,$link);	
}
elseif($act == 'employee_del')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_employee($id))
	{
	crmmsg("删除成功！共删除".$num."行",2);
	}
	else
	{
	crmmsg("删除失败！",1);
	}
}
?>