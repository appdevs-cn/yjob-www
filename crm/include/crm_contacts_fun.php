<?php
 /*
 * 74cms 通讯录
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