<?php
 /*
 * 74cms �������� ���÷��� ���ݵ��ú���
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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