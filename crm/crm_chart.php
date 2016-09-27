<?php
 /*
 * 74cms ���Źؼ���
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
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'client30day';
require_once(CRM_ROOT_PATH.'include/crm_flash_statement_fun.php');
$smarty->assign('act',$act);
$smarty->assign('pageheader',"���߷���");
check_permissions($_SESSION['crm_admin_purview'],"chart_show");
if($act == 'client30day')
{
	get_token();
	client30day();	
	$smarty->display('chart/crm_chart_client30day.htm');
}
elseif($act == 'client')
{
	get_token();
	clientstatistical();	
	$smarty->display('chart/crm_chart_clientstatistical.htm');
}
elseif($act == 'client_status')
{
	get_token();
	client_status();	
	$smarty->display('chart/crm_chart_client_status.htm');
}
elseif($act == 'deal30day')
{
	get_token();
	deal30day();	
	$smarty->display('chart/crm_chart_deal30day.htm');
}
elseif($act == 'lastyear_client30day')
{
	get_token();
	$today = date('Y');
	for ($i=1; $i < 5; $i++) { 
		$select_years[$i]['key'] = $today-$i;
		$select_years[$i]['value'] = $today-$i."��";
	}
	if(isset($_POST['choosetime'])){
		$start = strtotime("-".(($today-$_POST['choosetime'])*365+30)." days");
		$end = strtotime("-".(($today-$_POST['choosetime'])*365)." days");
	}else{
		$start = strtotime("-395 days");
		$end = strtotime("-365 days");
	}
	lastyear_client30day($start,$end);	
	$smarty->assign("select_years",$select_years);
	$smarty->assign("choosetime",date("Y",$start));
	$smarty->display('chart/crm_chart_lastyear_client30day.htm');
}
elseif($act == 'lastyear_deal30day')
{
	get_token();
	$today = date('Y');
	for ($i=1; $i < 5; $i++) { 
		$select_years[$i]['key'] = $today-$i;
		$select_years[$i]['value'] = $today-$i."��";
	}
	if(isset($_POST['choosetime'])){
		$start = strtotime("-".(($today-$_POST['choosetime'])*365+30)." days");
		$end = strtotime("-".(($today-$_POST['choosetime'])*365)." days");
	}else{
		$start = strtotime("-395 days");
		$end = strtotime("-365 days");
	}
	lastyear_deal30day($start,$end);	
	$smarty->assign("select_years",$select_years);
	$smarty->assign("choosetime",date("Y",$start));
	$smarty->display('chart/crm_chart_lastyear_deal30day.htm');
}
?>