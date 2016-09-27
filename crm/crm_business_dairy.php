<?php
 /*
 * 74cms �����ƻ�
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
require_once(CRM_ROOT_PATH.'include/crm_business_dairy_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
$smarty->assign('act',$act);
$smarty->assign('pageheader',"ҵ���ռ�");
if($act == 'list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order by w.id DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql=" AND w.title like '%{$key}%'";
		$oederbysql="";
	}
	if (!empty($_GET['settr']))
	{
		$settr=strtotime("-".intval($_GET['settr'])." day");
		$wheresql.=" AND w.addtime> ".$settr;
	}
	if ($_SESSION['crm_admin_purview']=="all")
	{
		$wheresql.="";
	}
	else
	{
		$wheresql.=" AND w.crm_id ='{$_SESSION['crm_admin_id']}'";
	}
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$joinsql=" LEFT JOIN ".table('crm_admin')." AS a ON w.crm_id=a.admin_id ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_business_dairy')." AS w ".$wheresql;
	$page = new page(array('total'=>$db->get_total($total_sql), 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$dairy = get_dairy($offset, $perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('dairy',$dairy);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('navlabel',"list");
	$smarty->display('business_dairy/crm_business_dairy.htm');
}
elseif($act == 'edit')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"edit_dairy");
	$id = !empty($_GET['id']) ? intval($_GET['id']) : '';
	$sql = "select * from ".table('crm_business_dairy')." where id=".$id." LIMIT 1";
	$dairy=$db->getone($sql);
	$smarty->assign('dairy',$dairy);
	$smarty->display('business_dairy/crm_business_dairy_edit.htm');
}
elseif($act == 'editsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"edit_dairy");
	$id = !empty($_POST['id']) ? intval($_POST['id']) : crmmsg('��������',1);
	$setsqlarr['title']=trim($_POST['title'])?trim($_POST['title']):crmmsg('����д���⣡',1);
	$setsqlarr['content']=trim($_POST['content']);
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = '?';
	$link[1]['text'] = "�鿴���޸�";
	$link[1]['href'] = "?act=edit&id=".$id;
 	!updatetable(table('crm_business_dairy'),$setsqlarr," id=".$id."")?crmmsg("�޸�ʧ�ܣ�",0):crmmsg("�޸ĳɹ���",2,$link);
}
elseif($act == 'add')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"add_dairy");
	$smarty->assign('navlabel',"add");
	$smarty->display('business_dairy/crm_business_dairy_add.htm');
}
elseif($act == 'addsave')
{	
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"add_dairy");
	$setsqlarr['title']=trim($_POST['title'])?trim($_POST['title']):crmmsg('����д���⣡',1);
	$setsqlarr['content']=trim($_POST['content']);
	$setsqlarr['crm_id']=intval($_SESSION['crm_admin_id']);
	$setsqlarr['addtime']=time();
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = '?';
	$link[1]['text'] = "�������";
	$link[1]['href'] = '?act=add';
	!inserttable(table('crm_business_dairy'),$setsqlarr)?crmmsg("���ʧ�ܣ�",0):crmmsg("��ӳɹ���",2,$link);
}
elseif($act == 'dairy_del')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"del_dairy");
	$id=$_REQUEST['id'];
	if ($num=del_dairy($id))
	{
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
	}
}
?>