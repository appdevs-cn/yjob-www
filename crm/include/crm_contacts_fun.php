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
 if(!defined('IN_QISHI'))
 {
 	die('Access Denied!');
 }
function get_contacts($offset, $perpage, $wheresql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	return $db->getall("SELECT * FROM ".table('crm_contacts').$wheresql.$limit);
}
function get_contacts_one($id)
{
	global $db;
	$sql = "select * from ".table('crm_contacts')." where id=".intval($id)." LIMIT 1";
	return $db->getone($sql);
}
function del_contacts($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("Delete from ".table('crm_contacts')." WHERE id IN (".$sqlin.") ")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
function get_my_contacts($offset, $perpage, $wheresql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	$return = $db->getall("SELECT * FROM ".table('crm_my_contacts').$wheresql.$limit);
	foreach ($return as $key => $value) {
		$arr[$key] = $value;
		$group_name = $db->getone("select group_name from ".table('crm_my_contacts_group')." where id=".$value['group_id']);
		$arr[$key]['group_name'] = $group_name['group_name'];
	}
	return $arr;
}
function get_my_contacts_one($id)
{
	global $db;
	$sql = "select * from ".table('crm_my_contacts')." where id=".intval($id)." LIMIT 1";
	return $db->getone($sql);
}
function del_my_contacts($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("Delete from ".table('crm_my_contacts')." WHERE id IN (".$sqlin.") ")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
function get_my_contacts_group($offset, $perpage, $wheresql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	return $db->getall("SELECT * FROM ".table('crm_my_contacts_group').$wheresql.$limit);
}
function get_my_contacts_group_one($id)
{
	global $db;
	$sql = "select * from ".table('crm_my_contacts_group')." where id=".intval($id)." LIMIT 1";
	return $db->getone($sql);
}
function del_my_contacts_group($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("Delete from ".table('crm_my_contacts_group')." WHERE id IN (".$sqlin.") ")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
?>