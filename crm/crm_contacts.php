<?php
 /*
 * 74cms 通讯录
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
require_once(CRM_ROOT_PATH.'include/crm_contacts_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
$smarty->assign('act',$act);
$smarty->assign('pageheader',"通讯录");
if($act == 'list')
{	
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order BY id DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	if ($key)
	{
		$wheresql=" WHERE fullname like '%{$key}%'";
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_contacts')." ".$wheresql;
	$page = new page(array('total'=>$db->get_total($total_sql),'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$contacts = get_contacts($offset, $perpage,$wheresql.$oederbysql);	
	$smarty->assign('contacts',$contacts);
	$smarty->assign('navlabel',"list");
	$smarty->assign('url',request_url());	
	$smarty->assign('page',$page->show(3));	
	$smarty->display('contacts/crm_contacts_list.htm');
}
elseif($act == 'add')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"contacts_add");
	$smarty->assign('navlabel',"add");	
	$smarty->display('contacts/crm_contacts_add.htm');
}
elseif($act == 'addsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"contacts_add");
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):crmmsg('联系人必须填写！',1);
	$setsqlarr['tel']=trim($_POST['tel']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['qq']=trim($_POST['qq']);
	$setsqlarr['web']=trim($_POST['web']);
	$setsqlarr['address']=trim($_POST['address']);
	$link[0]['text'] = "继续添加";
	$link[0]['href'] = '?act=add&w_type=';
	$link[1]['text'] = "返回列表";
	$link[1]['href'] = '?';
	!inserttable(table('crm_contacts'),$setsqlarr)?crmmsg("添加失败！",0):crmmsg("添加成功！",2,$link);
}
elseif($act == 'edit')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"contacts_edit");
	$id=intval($_GET['id']);
	$smarty->assign('contacts',get_contacts_one($id));
	$smarty->display('contacts/crm_contacts_edit.htm');
}
elseif($act == 'editsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"contacts_edit");
	$id = !empty($_POST['id']) ? intval($_POST['id']) : crmmsg('参数错误',1);
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):crmmsg('联系人必须填写！',1);
	$setsqlarr['tel']=trim($_POST['tel']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['qq']=trim($_POST['qq']);
	$setsqlarr['web']=trim($_POST['web']);
	$setsqlarr['address']=trim($_POST['address']);
	$link[0]['text'] = "返回列表";
	$link[0]['href'] = '?';
 	!updatetable(table('crm_contacts'),$setsqlarr," id=".$id."")?crmmsg("修改失败！",0):crmmsg("修改成功！",2,$link);
}
elseif($act == 'contacts_del')
{
	check_permissions($_SESSION['crm_admin_purview'],"contacts_del");
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_contacts($id))
	{
	crmmsg("删除成功！共删除 {$num} 行",2);
	}
	else
	{
	crmmsg("删除失败！",0);
	}
}
?>