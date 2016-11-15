<?php
 /*
 * 74cms 计划任务
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
require_once(dirname(__FILE__).'/include/crm_crons_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
check_permissions($_SESSION['crm_admin_purview'],"crons");
$smarty->assign('pageheader',"计划任务");
if($act == 'list')
{
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_crons');
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$list = get_crons($offset,$perpage,$wheresql.$oederbysql);
	$smarty->assign('list',$list);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('navlabel',"list");
	get_token();
	$smarty->display('crons/crm_crons.htm');
}
elseif($act == 'add')
{
	get_token();
	$smarty->assign('navlabel',"add");
	$smarty->display('crons/crm_crons_add.htm');
}
elseif($act == 'add_save')
{
	check_token();
$setsqlarr['name']=!empty($_POST['name'])?trim($_POST['name']):crmmsg('名称不能为空',1);
$setsqlarr['filename']=!empty($_POST['filename'])?trim($_POST['filename']):crmmsg('任务脚本不能为空',1);
$setsqlarr['weekday']=intval($_POST['weekday']);
$setsqlarr['day']=intval($_POST['day']);
$setsqlarr['hour']=trim($_POST['hour']);
$setsqlarr['minute']=trim($_POST['minute']);
if (!empty($setsqlarr['minute']) && !preg_match("/^(\d{1,10},)*(\d{1,10})$/",$setsqlarr['minute']))
{
$setsqlarr['minute']=intval($setsqlarr['minute'])>60?60:intval($setsqlarr['minute']);
}
$setsqlarr['admin_set']=0;
$setsqlarr['available']=intval($_POST['available']);
	if (inserttable(table('crm_crons'),$setsqlarr))
	{
	$link[0]['text'] = "返回列表";
	$link[0]['href'] ="?act=";
	crmmsg("添加成功！",2,$link);
	}
	else
	{
	crmmsg("添加失败！",0);
	}
}
elseif($act == 'edit')
{
	get_token();
	$smarty->assign('show',get_crons_one(intval($_GET['id'])));
	$smarty->display('crons/crm_crons_edit.htm');
}
elseif($act == 'edit_save')
{
	check_token();
	$link[0]['text'] = "返回列表";
	$link[0]['href'] ="?act=";
	$setsqlarr['name']=!empty($_POST['name'])?trim($_POST['name']):crmmsg('名称不能为空',1);
	$setsqlarr['filename']=!empty($_POST['filename'])?trim($_POST['filename']):crmmsg('任务脚本不能为空',1);
	$setsqlarr['weekday']=intval($_POST['weekday']);
	$setsqlarr['day']=intval($_POST['day']);
	$setsqlarr['hour']=intval($_POST['hour']);
	$setsqlarr['minute']=trim($_POST['minute']);
	if (!empty($setsqlarr['minute']) && !preg_match("/^(\d{1,10},)*(\d{1,10})$/",$setsqlarr['minute']))
	{
	$setsqlarr['minute']=intval($setsqlarr['minute'])>60?60:intval($setsqlarr['minute']);
	}
	$setsqlarr['available']=intval($_POST['available']);
	$wheresql=" cronid=".intval($_POST['cronid']);;
	!updatetable(table('crm_crons'),$setsqlarr,$wheresql)?crmmsg("修改失败！",0):crmmsg("修改成功！",2,$link);
}
elseif($act == 'del')
{
	get_token();
	$id=$_REQUEST['id'];
	if (empty($id)) crmmsg("请选择项目！",0);
	if ($num=del_crons($id))
	{
	crmmsg("删除成功！共删除".$num."行",2);
	}
	else
	{
	crmmsg("删除失败！".$num,1);
	}
}
elseif($act == 'execution')
{
	check_token();
	$id=intval($_GET['id']);
	$crons=$db->getone("select * from ".table('crm_crons')." WHERE  cronid='{$id}' LIMIT 1 ");
	if (!empty($crons))
	{
		if (!file_exists(CRM_ROOT_PATH."include/crons/".$crons['filename']))
		{
		crmmsg("任务文件 {$crons['filename']} 不存在！",0);
		}
	require_once(CRM_ROOT_PATH."include/crons/".$crons['filename']);
	crmmsg("执行成功！",2);
	}	
}
?>