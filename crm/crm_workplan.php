<?php
 /*
 * 74cms 工作计划
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
require_once(CRM_ROOT_PATH.'include/crm_workplan_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
$smarty->assign('act',$act);
$smarty->assign('pageheader',"工作计划");
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
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_workplan')." AS w ".$wheresql;
	$page = new page(array('total'=>$db->get_total($total_sql), 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$workplan = get_workplan($offset, $perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('workplan',$workplan);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('navlabel',"list");
	$smarty->display('workplan/crm_workplan.htm');
}
elseif($act == 'edit')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"edit_workplan");
	$id = !empty($_GET['id']) ? intval($_GET['id']) : '';
	$sql = "select * from ".table('crm_workplan')." where id=".$id." LIMIT 1";
	$workplan=$db->getone($sql);
	$smarty->assign('workplan',$workplan);
	$smarty->display('workplan/crm_workplan_edit.htm');
}
elseif($act == 'editsave')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"edit_workplan");
	$id = !empty($_POST['id']) ? intval($_POST['id']) : crmmsg('参数错误',1);
	$setsqlarr['title']=trim($_POST['title'])?trim($_POST['title']):crmmsg('请填写标题！',1);
	$setsqlarr['content']=trim($_POST['content']);
	$link[0]['text'] = "返回列表";
	$link[0]['href'] = '?';
	$link[1]['text'] = "查看已修改";
	$link[1]['href'] = "?act=edit&id=".$id;
 	!updatetable(table('crm_workplan'),$setsqlarr," id=".$id."")?crmmsg("修改失败！",0):crmmsg("修改成功！",2,$link);
}
elseif($act == 'add')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"add_workplan");
	$smarty->assign('navlabel',"add");
	$smarty->display('workplan/crm_workplan_add.htm');
}
elseif($act == 'addsave')
{	
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"add_workplan");
	$setsqlarr['title']=trim($_POST['title'])?trim($_POST['title']):crmmsg('请填写标题！',1);
	$setsqlarr['content']=trim($_POST['content']);
	$setsqlarr['crm_id']=intval($_SESSION['crm_admin_id']);
	$setsqlarr['addtime']=time();
	$link[0]['text'] = "返回列表";
	$link[0]['href'] = '?';
	$link[1]['text'] = "继续添加";
	$link[1]['href'] = '?act=add';
	!inserttable(table('crm_workplan'),$setsqlarr)?crmmsg("添加失败！",0):crmmsg("添加成功！",2,$link);
}
elseif($act == 'workplan_del')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"del_workplan");
	$id=$_REQUEST['id'];
	if ($num=del_workplan($id))
	{
	crmmsg("删除成功！共删除".$num."行",2);
	}
	else
	{
	crmmsg("删除失败！",0);
	}
}
?>