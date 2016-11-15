<?php
 /*
 * 74cms 管理中心 设置分类 数据调用函数
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
 if(!defined('IN_QISHI'))
 {
 	die('Access Denied!');
 }
function get_account_list()
{
	global $db;
	$sql = "select * from ".table('crm_account');
	return $db->getall($sql);
}
function get_account_one($id)
{
	global $db;
	$sql = "select * from ".table('crm_account')." WHERE id=".$id;
	return $db->getone($sql);
}
function del_account($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	foreach($id as $a)
	{
			if (!$db->query("Delete from ".table('crm_account')." WHERE id =".intval($a))) return false;
			$return=$return+$db->affected_rows();
	}
	return $return;
}
function get_employee_list()
{
	global $db;
	$sql = "select * from ".table('crm_employee');
	$result = $db->getall($sql);
	foreach ($result as $key => $value) {
		$department = $db->getone("select c_name from ".table('crm_category')." where c_id={$value['department']}");
		$result[$key]['department'] = $department['c_name'];
	}
	return $result;
}
function get_employee_one($id)
{
	global $db;
	$sql = "select * from ".table('crm_employee')." WHERE id=".$id;
	return $db->getone($sql);
}
function del_employee($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	foreach($id as $a)
	{
			if (!$db->query("Delete from ".table('crm_employee')." WHERE id =".intval($a))) return false;
			$return=$return+$db->affected_rows();
	}
	return $return;
}
function get_departments(){
	global $db;
	$sql = "select * from ".table('crm_category')." where c_alias='QS_crm_department'";
	return $db->getall($sql);
}
?>