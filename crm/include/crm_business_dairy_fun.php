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
function get_dairy($offset, $perpage, $sql= '')
{
	global $db;
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT w.*,a.admin_name FROM ".table('crm_business_dairy')." AS w ".$sql.$limit);
	while($row = $db->fetch_array($result))
	{
	$row_arr[] = $row;
	}
	return $row_arr;
}
function del_dairy($id)
{
	global $db;
	if(!is_array($id)) $id=array($id);
	$return=0;
	$sqlin=implode(",",$id);
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
		if (!$db->query("Delete from ".table('crm_business_dairy')." WHERE id IN (".$sqlin.") {$wheresql}")) return false;
		$return=$return+$db->affected_rows();
	}
	return $return;
}
?>