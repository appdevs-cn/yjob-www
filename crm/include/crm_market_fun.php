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
 if(!defined('IN_QISHI'))
{
 	die('Access Denied!');
}
function get_doc_category()
{
	global $db;
	$sql = "select * from ".table('crm_doc_category')."  order BY c_order desc,c_id ASC";
	return $db->getall($sql);
}
function get_doc_category_one($id)
{
	global $db;
	$sql = "select * from ".table('crm_doc_category')." where c_id=".intval($id)." LIMIT 1";
	return $db->getone($sql);
}
function get_doc($offset, $perpage, $sql= '')
{
	global $db,$_CFG;
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT * FROM ".table('crm_doc')." AS h ".$sql.$limit);
	while($row = $db->fetch_array($result))
	{
		if ($row['h_strong']=="1")
		{
		$row['h_filename']="<strong>{$row['h_filename']}</strong>";
		}
		if ($row['h_color'])
		{
		$row['h_filename']="<span style=\"color:{$row['h_color']}\">{$row['h_filename']}</span>";
		}
	$row_arr[] = $row;
	}
	return $row_arr;
}
function del_doc($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("Delete from ".table('crm_doc')." WHERE h_id IN (".$sqlin.") ")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
function del_doc_category($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	$sqlin=implode(",",$id);
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if (!$db->query("Delete from ".table('crm_doc_category')." WHERE c_id IN (".$sqlin.")  AND c_adminset<>1")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
?>