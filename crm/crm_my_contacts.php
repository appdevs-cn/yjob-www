<?php
 /*
 * 74cms ͨѶ¼
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
require_once(CRM_ROOT_PATH.'include/crm_contacts_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
$smarty->assign('act',$act);
$smarty->assign('pageheader',"�ҵ�ͨѶ¼");
if($act == 'list')
{	
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order BY id DESC ";
	$wheresql=" where crm_id={$_SESSION['crm_admin_id']}";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	if ($key)
	{
		$wheresql=" WHERE fullname like '%{$key}%' AND crm_id={$_SESSION['crm_admin_id']}";
	}
	if(isset($_GET['group_id']) && intval($_GET['group_id'])>0){
		$wheresql=isset($wheresql)?$wheresql." AND group_id={$_GET['group_id']}":" WHERE group_id={$_GET['group_id']}";
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_my_contacts')." ".$wheresql;
	$page = new page(array('total'=>$db->get_total($total_sql),'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$contacts = get_my_contacts($offset, $perpage,$wheresql.$oederbysql);	
	$group = $db->getall("select * from ".table('crm_my_contacts_group')." where admin_id={$_SESSION['crm_admin_id']}");
	$smarty->assign('group',$group);
	$smarty->assign('contacts',$contacts);
	$smarty->assign('navlabel',"list");
	$smarty->assign('url',request_url());	
	$smarty->assign('page',$page->show(3));	
	$smarty->display('mycontacts/crm_contacts_list.htm');
}
elseif($act == 'add')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_add");
	$group = $db->getall("select * from ".table('crm_my_contacts_group')." where admin_id={$_SESSION['crm_admin_id']}");
	$smarty->assign('group',$group);
	$smarty->assign('navlabel',"add");	
	$smarty->display('mycontacts/crm_contacts_add.htm');
}
elseif($act == 'addsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_add");
	$setsqlarr['group_id']=intval($_POST['group']);
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):crmmsg('��ϵ�˱�����д��',1);
	$setsqlarr['tel']=trim($_POST['tel']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['qq']=trim($_POST['qq']);
	$setsqlarr['web']=trim($_POST['web']);
	$setsqlarr['address']=trim($_POST['address']);
	$setsqlarr['crm_id']=intval($_SESSION['crm_admin_id']);
	$link[0]['text'] = "�������";
	$link[0]['href'] = '?act=add&w_type=';
	$link[1]['text'] = "�����б�";
	$link[1]['href'] = '?';
	!inserttable(table('crm_my_contacts'),$setsqlarr)?crmmsg("���ʧ�ܣ�",0):crmmsg("��ӳɹ���",2,$link);
}
elseif($act == 'edit')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_edit");
	$id=intval($_GET['id']);
	$group = $db->getall("select * from ".table('crm_my_contacts_group')." where admin_id={$_SESSION['crm_admin_id']}");
	$smarty->assign('group',$group);
	$smarty->assign('contacts',get_my_contacts_one($id));
	$smarty->display('mycontacts/crm_contacts_edit.htm');
}
elseif($act == 'editsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_edit");
	$id = !empty($_POST['id']) ? intval($_POST['id']) : crmmsg('��������',1);
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):crmmsg('��ϵ�˱�����д��',1);
	$setsqlarr['group_id']=intval($_POST['group']);
	$setsqlarr['tel']=trim($_POST['tel']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['qq']=trim($_POST['qq']);
	$setsqlarr['web']=trim($_POST['web']);
	$setsqlarr['address']=trim($_POST['address']);
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = '?';
 	!updatetable(table('crm_my_contacts'),$setsqlarr," id=".$id."")?crmmsg("�޸�ʧ�ܣ�",0):crmmsg("�޸ĳɹ���",2,$link);
}
elseif($act == 'contacts_del')
{
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_del");
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_my_contacts($id))
	{
	crmmsg("ɾ���ɹ�����ɾ�� {$num} ��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
	}
}
elseif($act == 'grouplist')
{	
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order BY id DESC ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_my_contacts_group')." ".$wheresql;
	$page = new page(array('total'=>$db->get_total($total_sql),'perpage'=>$perpage));
	$wheresql .= " WHERE admin_id={$_SESSION['crm_admin_id']}";
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$contacts = get_my_contacts_group($offset, $perpage,$wheresql.$oederbysql);	
	$smarty->assign('contacts',$contacts);
	$smarty->assign('navlabel',"grouplist");
	$smarty->assign('url',request_url());	
	$smarty->assign('page',$page->show(3));	
	$smarty->display('mycontacts/crm_contacts_group_list.htm');
}
elseif($act == 'addgroup')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_addgroup");
	$smarty->assign('navlabel',"addgroup");	
	$smarty->display('mycontacts/crm_contacts_addgroup.htm');
}
elseif($act == 'addgroupsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_addgroup");
	$setsqlarr['group_name']=trim($_POST['group_name'])?trim($_POST['group_name']):crmmsg('�������Ʊ�����д��',1);
	$setsqlarr['admin_id']=intval($_SESSION['crm_admin_id']);
	$link[0]['text'] = "�������";
	$link[0]['href'] = '?act=addgroup&w_type=';
	$link[1]['text'] = "�����б�";
	$link[1]['href'] = '?';
	!inserttable(table('crm_my_contacts_group'),$setsqlarr)?crmmsg("���ʧ�ܣ�",0):crmmsg("��ӳɹ���",2,$link);
}
elseif($act == 'editgroup')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_editgroup");
	$id=intval($_GET['id']);
	$smarty->assign('contacts',get_my_contacts_group_one($id));
	$smarty->display('mycontacts/crm_contacts_editgroup.htm');
}
elseif($act == 'editgroupsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_editgroup");
	$id = !empty($_POST['id']) ? intval($_POST['id']) : crmmsg('��������',1);
	$setsqlarr['group_name']=trim($_POST['group_name'])?trim($_POST['group_name']):crmmsg('����д�������ƣ�',1);
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = '?act=grouplist';
 	!updatetable(table('crm_my_contacts_group'),$setsqlarr," id=".$id."")?crmmsg("�޸�ʧ�ܣ�",0):crmmsg("�޸ĳɹ���",2,$link);
}
elseif($act == 'contacts_delgroup')
{
	check_permissions($_SESSION['crm_admin_purview'],"my_contacts_delgroup");
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_my_contacts_group($id))
	{
	crmmsg("ɾ���ɹ�����ɾ�� {$num} ��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
	}
}
?>