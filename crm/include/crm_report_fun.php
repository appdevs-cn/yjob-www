<?php
 /*
 * 74cms �����ƻ�
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
function get_myreport($offset, $perpage, $sql= '')
{
	global $db,$category;
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT * FROM ".table('crm_report').$sql.$limit);
	while($row = $db->fetch_array($result))
	{
	$row['status']=$category[$row['status_id']]['categoryname'];
	$admin = $db->getone("select admin_name from ".table('crm_admin')." where admin_id=".$row['crm_id']);
	$row['admin_name'] = $admin['admin_name'];
	$row_arr[] = $row;
	}
	return $row_arr;
}
function del_report($id)
{
	global $db;
	if (!is_array($id))$id=array($id);
	$sqlin=implode(",",$id);
	$return=0;
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if ($_SESSION['crm_admin_purview']=="all")
		{
		$wheresql="";
		}
		else
		{
		$wheresql=" AND crm_id ='{$_SESSION['crm_admin_id']}'";
		}
		if (!$db->query("Delete from ".table('crm_report')." WHERE id IN ({$sqlin}) {$wheresql}")) return false;
		$return=$return+$db->affected_rows();
		return $return;
	}
	else
	{
	return false;
	}
}
?>