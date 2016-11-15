<?php
 /*
 * 74cms 资源池
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
require_once(CRM_ROOT_PATH.'include/crm_report_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'report_list';
if($act == 'report_list')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"report_list");
	if(isset($_POST['starttime'])&&isset($_POST['endtime'])){
		$starttime = strtotime($_POST['starttime']);
		$endtime = strtotime($_POST['endtime']);
		if($starttime==0&&$endtime==0){
			crmmsg("请选择开始时间和结束时间！",1);
		}elseif($starttime>0&&$endtime==0){
			crmmsg("请选择结束时间！",1);
		}elseif($starttime==0&&$endtime>0){
			crmmsg("请选择开始时间！",1);
		}elseif($starttime>$endtime){
			crmmsg("开始时间不能小于结束时间！",1);
		}else{
			$wheresql = " addtime>=".$starttime." and addtime<=".$endtime." ";
		}
	}else{
		$starttime = strtotime(date("Y-m-d"));
		$endtime = $starttime+3600*24;
	}
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	if ($_SESSION['crm_admin_purview']=="all")
	{
	$wheresql="";
	$is_admin = 1;
	}
	else
	{
	$wheresql=" crm_id ='{$_SESSION['crm_admin_id']}'";
	$is_admin = 0;
	}
	$oederbysql=" order BY addtime desc,last_followtime desc ";
	$wheresql = empty($wheresql)?" addtime>={$starttime} and addtime<={$endtime} ":$wheresql." and addtime>={$starttime} and addtime<={$endtime}";
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$perpage = intval($_POST['perpage'])==0?10:intval($_POST['perpage']);
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_report').$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$category=get_cache('crm_category');
	$admins = $db->getall("select * from ".table('crm_admin'));
	$smarty->assign('admins',$admins);
	$smarty->assign('is_admin',$is_admin);
	$clist = get_myreport($offset,$perpage,$joinsql.$wheresql.$oederbysql);
	$show_start_time = $starttime==0?"--":date("Y-m-d",$starttime);
	$show_end_time = $endtime==0?"--":date("Y-m-d",$endtime);
	$smarty->assign('perpage',$perpage);
	$smarty->assign('start_time',$show_start_time);
	$smarty->assign('end_time',$show_end_time);
	$smarty->assign('pageheader',"报表");
	$smarty->assign('clist',$clist);
	$smarty->assign('crm_admin_id',$_SESSION['crm_admin_id']);
	$smarty->assign('certificate_dir',$certificate_dir);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('total_val',$total_val);
	// $smarty->assign('admin_list',get_admin_list());	
	$smarty->display('report/crm_report_list.htm');
}
elseif($act == "create"){
	check_permissions($_SESSION['crm_admin_purview'],"report_create");
	if($_SESSION['crm_admin_purview']=="all"){
		crmmsg("超级管理员不能执行此操作！",1);
	}
	$now = time();
	$today = strtotime(date("Y-m-d"));
	$tomorrow = $today+3600*24;
	$category = $db->getall("select c_id,c_alias,c_name from ".table('crm_category'));
	foreach ($category as $key => $value) {
		$category_arr[$value['c_alias']][$value['c_id']] = $value['c_name'];
	}
	$db->query("delete from ".table('crm_report')." where addtime>=".$today." and addtime<=".$tomorrow." and crm_id=".$_SESSION['crm_admin_id']);
	$data = $db->getall("select * from ".table('crm_client')." where crm_id=".$_SESSION['crm_admin_id']." and edittime>=".$today." and edittime<=".$tomorrow);
	foreach ($data as $key => $value) {
		$setsqlarr['crm_id'] = intval($_SESSION['crm_admin_id']);
		$setsqlarr['addtime'] = $now;
		$setsqlarr['client_number'] = $value['id'];
		$setsqlarr['client_name'] = $value['companyname'];
		$setsqlarr['contact'] = $value['contact'];
		$setsqlarr['tel'] = $value['telephone'];
		$setsqlarr['email'] = $value['email'];
		$setsqlarr['client_addtime'] = $value['addtime'];
		$setsqlarr['last_followtime'] = $value['followtime'];
		$setsqlarr['next_followtime'] = $value['nexttime'];
		$last_follow_text = $db->getone("select client_log from ".table('crm_client_log')." where client_id={$value['id']} order by addtime desc limit 1");
		$setsqlarr['last_follow_text'] = $last_follow_text['client_log'];
		$setsqlarr['client_status'] = $value['status_id']==0?"未知":$category_arr['QS_crm_status'][$value['status_id']];
		$client_demand = $db->getone("select client_other from ".table('crm_client_demand')." where client_id=".$setsqlarr['client_number']);
		$setsqlarr['client_demand'] = $client_demand['client_other'];
		$client_remark = $db->getone("select client_other from ".table('crm_client_other')." where client_id=".$setsqlarr['client_number']);
		$setsqlarr['client_remark'] = $client_remark['client_other'];
		inserttable(table('crm_report'),$setsqlarr);
	}
	crmmsg("生成完成！",2);
}
elseif($act == 'del_report')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"del_report");
	$yid =!empty($_POST['y_id'])?$_POST['y_id']:crmmsg("你没有选择报表！",1);
	$num=del_report($yid);
	if ($num>0)
	{
		crmmsg("操作成功！共影响".$num."行",2);
	}
	else
	{
		crmmsg("操作失败！",0);
	}
}
elseif($act == "report_export"){
	check_permissions($_SESSION['crm_admin_purview'],"report_export");
	$yid =!empty($_POST['y_id'])?$_POST['y_id']:crmmsg("你没有选择报表！",1);
	$yid_str = implode(",", $yid);
	$oederbysql=" order BY addtime desc,last_followtime desc ";
	$wheresql = empty($wheresql)?" id in ({$yid_str}) ":" and id in ({$yid_str}) ";
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$data = $db->getall("select * from ".table('crm_report').$wheresql);
	if(empty($data)){
		crmmsg("当前没有数据！",1);
	}
	foreach ($data as $key => $value) {
		$data[$key]['addtime'] = date("Y-m-d H:i:s",$data[$key]['addtime']);
		$data[$key]['client_addtime'] = date("Y-m-d H:i:s",$data[$key]['client_addtime']);
		$data[$key]['last_followtime'] = $data[$key]['last_followtime']==0?"未跟进":date("Y-m-d H:i:s",$data[$key]['last_followtime']);
		$data[$key]['next_followtime'] = $data[$key]['next_followtime']==0?"未设置":date("Y-m-d",$data[$key]['next_followtime']);
	}
	$top_str = "记录编号\t客户经理\t报表生成时间\t客户编号\t客户名称\t联系人\t电话\t邮箱\t客户录入时间\t最后跟进时间\t最后跟进内容\t下次跟进时间\t客户状态\t客户需求\t备注\t\n";
	create_excel($top_str,$data);
}
?>