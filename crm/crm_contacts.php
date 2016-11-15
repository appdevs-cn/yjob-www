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
$smarty->assign('pageheader',"ͨѶ¼");
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
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):crmmsg('��ϵ�˱�����д��',1);
	$setsqlarr['tel']=trim($_POST['tel']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['qq']=trim($_POST['qq']);
	$setsqlarr['web']=trim($_POST['web']);
	$setsqlarr['address']=trim($_POST['address']);
	$link[0]['text'] = "�������";
	$link[0]['href'] = '?act=add&w_type=';
	$link[1]['text'] = "�����б�";
	$link[1]['href'] = '?';
	!inserttable(table('crm_contacts'),$setsqlarr)?crmmsg("���ʧ�ܣ�",0):crmmsg("��ӳɹ���",2,$link);
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
	$id = !empty($_POST['id']) ? intval($_POST['id']) : crmmsg('��������',1);
	$setsqlarr['fullname']=trim($_POST['fullname'])?trim($_POST['fullname']):crmmsg('��ϵ�˱�����д��',1);
	$setsqlarr['tel']=trim($_POST['tel']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['qq']=trim($_POST['qq']);
	$setsqlarr['web']=trim($_POST['web']);
	$setsqlarr['address']=trim($_POST['address']);
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = '?';
 	!updatetable(table('crm_contacts'),$setsqlarr," id=".$id."")?crmmsg("�޸�ʧ�ܣ�",0):crmmsg("�޸ĳɹ���",2,$link);
}
elseif($act == 'contacts_del')
{
	check_permissions($_SESSION['crm_admin_purview'],"contacts_del");
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_contacts($id))
	{
	crmmsg("ɾ���ɹ�����ɾ�� {$num} ��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
	}
}
?>