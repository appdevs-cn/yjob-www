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
require_once(CRM_ROOT_PATH.'include/crm_category_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'grouplist';
check_permissions($_SESSION['crm_admin_purview'],"category_set");
$smarty->assign('pageheader',"�������");
if($act == 'grouplist')
{
	get_token();
	$smarty->assign('navlabel',"group");
	$smarty->assign('group',get_category_group());	
	$smarty->display('category/crm_category_group.htm');
}
elseif($act == 'add_group')
{
	get_token();
	$smarty->assign('navlabel',"group");
	$smarty->display('category/crm_category_group_add.htm');
}
elseif($act == 'add_group_save')
{
	check_token();
	$setsqlarr['g_name']=!empty($_POST['g_name']) ?trim($_POST['g_name']) : crmmsg("����д������",1);
	$setsqlarr['g_alias']=!empty($_POST['g_alias']) ?trim($_POST['g_alias']) : crmmsg("����д������",1);
	$info=get_category_group_one($setsqlarr['g_alias']);
	if (empty($info))
	{
		if (stripos($setsqlarr['g_alias'],"qs_")===0)
		{
			crmmsg("�����������á�qs_����ͨ",0);
		}
		else
		{
			$link[0]['text'] = "�������б�";
			$link[0]['href'] = '?act=grouplist';
			$link[1]['text'] = "������ӷ�����";
			$link[1]['href'] = "?act=add_group";
			inserttable(table('crm_category_group'),$setsqlarr)?crmmsg("��ӳɹ���",2,$link):crmmsg("���ʧ�ܣ�",0);			
		}
	}
	else
	{
	 crmmsg("���ʧ��,���������ظ�",0);
	}
}
elseif($act == 'edit_group')
{
	get_token();
	$smarty->assign('navlabel',"group");
	$smarty->assign('group',get_category_group_one($_GET['alias']));
	$smarty->display('category/crm_category_group_edit.htm');
}
elseif($act == 'edit_group_save')
{
	check_token();
	$setsqlarr['g_name']=!empty($_POST['g_name']) ?trim($_POST['g_name']) : crmmsg("����д������",1);
	$setsqlarr['g_alias']=!empty($_POST['g_alias']) ?trim($_POST['g_alias']) : crmmsg("����д������",1);
	$info=get_category_group_one($setsqlarr['g_alias']);
	if (empty($info) || $info['g_id']==intval($_POST['g_id']))
	{
		if (stripos($setsqlarr['g_alias'],"qs_")===0)
		{
			crmmsg("�����������á�qs_����ͨ",0);
		}
		else
		{
			$link[0]['text'] = "�������б�";
			$link[0]['href'] = '?act=grouplist';
			$link[1]['text'] = "�鿴�޸Ľ��";
			$link[1]['href'] = "?act=edit_group&alias=".$setsqlarr['g_alias'];
			updatetable(table('category_group'),$setsqlarr," g_id=".intval($_POST['g_id']))?'':crmmsg("�޸�ʧ�ܣ�",0);
			//ͬʱ�޸ķ������µķ������
			$catarr['c_alias']=$setsqlarr['g_alias'];
			updatetable(table('category'),$catarr," c_alias='".$_POST['old_g_alias']."'")?'':crmmsg("�޸�ʧ�ܣ�",0);
			refresh_crm_category_cache();
			crmmsg("�޸ĳɹ���",2,$link);						
		}
	}
	else
	{
	 crmmsg("���ʧ��,���������ظ�",0);
	}
}
elseif($act == 'del_group')
{
	check_token();
	$alias=$_REQUEST['alias'];
	if ($num=del_group($alias))
	{
	refresh_crm_category_cache();
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",1);
	}
}
elseif($act == 'show_category')
{
	get_token();
	$smarty->assign('navlabel',"group");
	$smarty->assign('group',get_category_group_one($_GET['alias']));
	$smarty->assign('category',get_category($_GET['alias']));	
	$smarty->display('category/crm_category_list.htm');
}
elseif($act == 'category_save')
{
	check_token();
	if (is_array($_POST['c_id']) && count($_POST['c_id'])>0)
	{
		for ($i =0; $i <count($_POST['c_id']);$i++){
			if (!empty($_POST['c_name'][$i]))
			{	
				$setsqlarr['c_name']=trim($_POST['c_name'][$i]);
				$setsqlarr['c_order']=intval($_POST['c_order'][$i]);
				$setsqlarr['c_index']=getfirstchar($setsqlarr['c_name']);
				!updatetable(table('crm_category'),$setsqlarr," c_id=".intval($_POST['c_id'][$i]))?crmmsg("���ʧ�ܣ�",0):"";
				$num=$num+$db->affected_rows();
			}

		}

	}
	refresh_crm_category_cache();
	crmmsg("�޸���ɣ�",2);
}
elseif($act == 'add_category')
{
	get_token();
	$smarty->assign('navlabel',"group");
	$smarty->assign('group',get_category_group_one($_GET['alias']));
	$smarty->display('category/crm_category_add.htm');
}
elseif($act == 'add_category_save')
{
	check_token();
	$num=0;
	if (is_array($_POST['c_name']) && count($_POST['c_name'])>0)
	{
		for ($i =0; $i <count($_POST['c_name']);$i++){
			if (!empty($_POST['c_name'][$i]))
			{		
				$setsqlarr['c_name']=trim($_POST['c_name'][$i]);
				$setsqlarr['c_alias']=trim($_POST['c_alias'][$i]);
				$setsqlarr['c_order']=intval($_POST['c_order'][$i]);
				$setsqlarr['c_index']=getfirstchar($setsqlarr['c_name']);
				// $setsqlarr['c_note']=trim($_POST['c_note'][$i]);				
				!inserttable(table('crm_category'),$setsqlarr)?crmmsg("���ʧ�ܣ�",0):"";
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
	refresh_crm_category_cache();
	$link[0]['text'] = "���ط����б�";
	$link[0]['href'] = "?act=show_category&alias=".$setsqlarr['c_alias'];
	$link[1]['text'] = "������ӷ���";
	$link[1]['href'] = "?act=add_category&alias=".$setsqlarr['c_alias'];
	crmmsg("��ӳɹ��������".$num."������",2,$link);
	}
}
elseif($act == 'edit_category')
{	
	get_token();
	$smarty->assign('navlabel',"group");
	$smarty->assign('category',get_category_one($_GET['id']));
	$smarty->display('category/crm_category_edit.htm');
}
elseif($act == 'edit_category_save')
{
	check_token();
	$setsqlarr['c_name']=!empty($_POST['c_name']) ?trim($_POST['c_name']) : crmmsg("����д����",1);
	$setsqlarr['c_order']=intval($_POST['c_order']);
	$setsqlarr['c_parentid']=intval($_POST['c_parentid']);
	$setsqlarr['c_index']=getfirstchar($setsqlarr['c_name']);
	$setsqlarr['c_note']=trim($_POST['c_note']);				
	!updatetable(table('crm_category'),$setsqlarr," c_id=".intval($_POST['c_id']))?crmmsg("����ʧ�ܣ�",0):"";
	$link[0]['text'] = "�����б�";
	$link[0]['href'] = '?act=show_category&alias='.$_POST['c_alias'];
	$link[1]['text'] = "�鿴�޸Ľ��";
	$link[1]['href'] = "?act=edit_category&id=".intval($_POST['c_id']);
	refresh_crm_category_cache();
	crmmsg("����ɹ���",2,$link);
}
elseif($act == 'del_category')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_category($id))
	{
	refresh_crm_category_cache();
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",1);
	}
}
?>