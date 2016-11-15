<?php
 /*
 * 74cms Ӫ������
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
require_once(CRM_ROOT_PATH.'include/crm_market_fun.php');
require_once(CRM_ROOT_PATH.'include/upload.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
$doc_dir="data/doc/";
$smarty->assign('pageheader',"�ĵ�����");
if($act == 'list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order BY h.h_order DESC,h_id DESC";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql=" WHERE h.h_filename like '%{$key}%'";
		$oederbysql="";
	}
	!empty($_GET['h_typeid'])? $wheresqlarr['h.h_typeid']=intval($_GET['h_typeid']):'';
	if (!empty($wheresqlarr)) $wheresql=wheresql($wheresqlarr);
	$joinsql=" LEFT JOIN  ".table('crm_doc_category')." AS c ON h.h_typeid=c.c_id ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_doc')." AS h ".$joinsql.$wheresql;
	$page = new page(array('total'=>$db->get_total($total_sql), 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$hrtools = get_doc($offset, $perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('category',get_doc_category());
	$smarty->assign('hrtools',$hrtools);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('navlabel',"list");
	$smarty->display('market/crm_doc.htm');
}
elseif($act == 'edit')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"edit_doc");
	$id = intval($_GET['id']);
	$sql = "select * from ".table('crm_doc')." AS h LEFT JOIN ".table('crm_doc_category')." AS c ON h.h_typeid=c.c_id where h.h_id='{$id}' LIMIT 1";
	$show=$db->getone($sql);
	$smarty->assign('show',$show);
	$smarty->assign('category',get_doc_category());
	$smarty->display('market/crm_doc_edit.htm');
}
elseif($act == 'editsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"edit_doc");
	$setsqlarr['h_filename']=!empty($_POST['h_filename'])?trim($_POST['h_filename']):crmmsg('�ĵ����Ʋ���Ϊ�գ�',1);
	$setsqlarr['h_typeid']=intval($_POST['h_typeid'])>0?intval($_POST['h_typeid']):crmmsg('��ѡ����࣡',1);
	$setsqlarr['h_color']=trim($_POST['h_color']);
	$setsqlarr['h_strong']=intval($_POST['h_strong']);
	$setsqlarr['h_order']=intval($_POST['h_order']);
	if (empty($_FILES['upfile']['name']) && empty($_POST['url']))
	{
	crmmsg('���ϴ��ļ�������д�ļ�·����',1);
	}
	if ($_FILES['upfile']['name'])
		{
			$doc_dir=$doc_dir.date("Y/m/");
			make_dir($doc_dir);
			$setsqlarr['h_fileurl']=_asUpFiles($doc_dir,"upfile",3000,'doc/docx/ppt/xls/rtf',true);
			if (empty($setsqlarr['h_fileurl']))
			{
			crmmsg('�ϴ��ļ�ʧ�ܣ�',1);
			}
			$setsqlarr['h_fileurl']=$doc_dir.$setsqlarr['h_fileurl'];
		}
		else
		{
			$setsqlarr['h_fileurl']=trim($_POST['url']);
		}
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = '?';
	!updatetable(table('crm_doc'),$setsqlarr," h_id=".intval($_POST['id'])."")?crmmsg("�޸�ʧ�ܣ�",0):crmmsg("�޸ĳɹ���",2,$link);
}
elseif($act == 'add')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"add_doc");
	$smarty->assign('category',get_doc_category());
	$smarty->assign('navlabel',"add");
	$smarty->display('market/crm_doc_add.htm');
}
elseif($act == 'addsave')
{	
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"add_doc");
	$setsqlarr['h_filename']=!empty($_POST['h_filename'])?trim($_POST['h_filename']):crmmsg('�ĵ����Ʋ���Ϊ�գ�',1);
	$setsqlarr['h_typeid']=intval($_POST['h_typeid'])>0?intval($_POST['h_typeid']):crmmsg('��ѡ����࣡',1);
	$setsqlarr['h_color']=trim($_POST['h_color']);
	$setsqlarr['h_strong']=intval($_POST['h_strong']);
	$setsqlarr['h_order']=intval($_POST['h_order']);
	if (empty($_FILES['upfile']['name']) && empty($_POST['url']))
	{
	crmmsg('���ϴ��ļ�������д�ļ�·����',1);
	}
	if ($_FILES['upfile']['name'])
		{
			$doc_dir=$doc_dir.date("Y/m/");
			make_dir($doc_dir);
			$setsqlarr['h_fileurl']=_asUpFiles($doc_dir,"upfile",3000,'doc/ppt/xls/rtf',true);
			if (empty($setsqlarr['h_fileurl']))
			{
			crmmsg('�ϴ��ļ�ʧ�ܣ�',1);
			}
			$setsqlarr['h_fileurl']=$doc_dir.$setsqlarr['h_fileurl'];
		}
		else
		{
			$setsqlarr['h_fileurl']=trim($_POST['url']);
		}
	$link[0]['text'] = "�������";
	$link[0]['href'] = "?act=add&h_typeid={$setsqlarr['h_typeid']}&h_typeid_cn={$_POST['h_typeid_cn']}";
	$link[1]['text'] = "�����б�";
	$link[1]['href'] = '?';
	!inserttable(table('crm_doc'),$setsqlarr)?crmmsg("���ʧ�ܣ�",0):crmmsg("��ӳɹ���",2,$link);
}
elseif($act == 'doc_del')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"del_doc");
	$id=$_REQUEST['id'];
	if ($num=del_doc($id))
	{
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
	}
}
elseif($act == 'category')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"market_category");
	$smarty->assign('category',get_doc_category());
	$smarty->assign('navlabel',"category");
	$smarty->display('market/crm_doc_category.htm');
}
elseif($act == 'category_add')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"market_category");
	$smarty->assign('navlabel',"category");
	$smarty->display('market/crm_doc_category_add.htm');
}
elseif($act == 'add_category_save')
{
	check_permissions($_SESSION['crm_admin_purview'],"market_category");
	check_token();
	$num=0;
	if (is_array($_POST['c_name']) && count($_POST['c_name'])>0)
	{
		for ($i =0; $i <count($_POST['c_name']);$i++){
			if (!empty($_POST['c_name'][$i]))
			{		
				$setsqlarr['c_name']=trim($_POST['c_name'][$i]);
				$setsqlarr['c_order']=intval($_POST['c_order'][$i]);	
				$setsqlarr['c_adminset']=0;		
				!inserttable(table('crm_doc_category'),$setsqlarr)?crmmsg("���ʧ�ܣ�",0):"";
				$num=$num+$db->affected_rows();
			}

		}

	}
	if ($num==0)
	{
	crmmsg("���ʧ��,���ݲ�����",1);
	}
	else
	{
	$link[0]['text'] = "���ط������";
	$link[0]['href'] = '?act=category';
	$link[1]['text'] = "�������";
	$link[1]['href'] = "?act=category_add";
	crmmsg("��ӳɹ��������".$num."������",2,$link);
	}
}
elseif($act == 'edit_category')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"market_category");
	$id=intval($_GET['id']);
	$smarty->assign('category',get_doc_category_one($id));
	$smarty->assign('navlabel',"category");
	$smarty->display('market/crm_doc_category_edit.htm');
}
elseif($act == 'edit_category_save')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"market_category");
	$id=intval($_POST['id']);	
	$setsqlarr['c_name']=!empty($_POST['c_name'])?trim($_POST['c_name']):crmmsg('����д�������ƣ�',1);
	$setsqlarr['c_order']=intval($_POST['c_order']);
	$link[0]['text'] = "�鿴�޸Ľ��";
	$link[0]['href'] = '?act=edit_category&id='.$id;
	$link[1]['text'] = "���ط������";
	$link[1]['href'] = '?act=category';
	!updatetable(table('crm_doc_category'),$setsqlarr," c_id=".$id."")?crmmsg("�޸�ʧ�ܣ�",0):crmmsg("�޸ĳɹ���",2,$link);
}
elseif($act == 'del_category')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"market_category");
	$id=$_REQUEST['id'];
	if ($num=del_doc_category($id))
	{
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
	}
}

?>