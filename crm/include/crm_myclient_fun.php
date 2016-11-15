<?php
 /*
 * 74cms 客户管理
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
function get_myclient($offset,$perpage,$get_sql= '')
{
	global $db,$category;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT c.* FROM ".table('crm_client')." AS c ".$get_sql.$limit);
	while($row = $db->fetch_array($result))
	{
	$row['source']=$category[$row['source_id']]['categoryname'];
	$row['grade']=$category[$row['grade_id']]['categoryname'];
	$row['status']=$category[$row['status_id']]['categoryname'];
	$row['type']=$category[$row['type_id']]['categoryname'];
	$row['trustworthiness']=$category[$row['trustworthiness_id']]['categoryname'];
	if ($row['company_id']>0)
	{
	$row['company_url']=url_rewrite('QS_companyshow',array('id'=>$row['company_id']));
	$members = $db->getone("select uid from ".table('company_profile')." where id=".$row['company_id']);
	$row['uid'] = $members['uid'];
	}
	else
	{
	$row['company_url']='';
	}
	$latest_follow = $db->getone("select client_log from ".table('crm_client_log')." where client_id={$row['id']} order by addtime desc limit 1");
	$row['client_log'] = $latest_follow['client_log'];
	$admin = $db->getone("select admin_name from ".table('crm_admin')." where admin_id=".$row['crm_id']);
	$row['admin_name'] = $admin['admin_name'];
	$row_arr[] = $row;
	}
	return $row_arr;
}
function get_myclient_tmp($offset,$perpage,$get_sql= '')
{
	global $db,$category;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT c.* FROM ".table('crm_client_tmp')." AS c ".$get_sql.$limit);
	while($row = $db->fetch_array($result))
	{
	$row['source']=$category[$row['source_id']]['categoryname'];
	$row['grade']=$category[$row['grade_id']]['categoryname'];
	$row['status']=$category[$row['status_id']]['categoryname'];
	$row['type']=$category[$row['type_id']]['categoryname'];
	$row['trustworthiness']=$category[$row['trustworthiness_id']]['categoryname'];
	if ($row['company_id']>0)
	{
	$row['company_url']=url_rewrite('QS_companyshow',array('id'=>$row['company_id']));
	}
	else
	{
	$row['company_url']='';
	}
	$latest_follow = $db->getone("select client_log from ".table('crm_client_log')." where client_id={$row['id']} order by addtime desc limit 1");
	$row['client_log'] = $latest_follow['client_log'];
	$admin = $db->getone("select admin_name from ".table('crm_admin')." where admin_id=".$row['crm_id']);
	$row['admin_name'] = $admin['admin_name'];
	$row_arr[] = $row;
	}
	return $row_arr;
}
function get_myclient_one_id($id,$crm_id=NULL)
{
	global $db;
	$id=intval($id);
	if (!empty($crm_id))
	{
	$crm_id=intval($crm_id);
	$wheresql=" AND crm_id='{$crm_id}'";
	}
	$sql = "select * from ".table('crm_client')." where id='{$id}' {$wheresql}";
	$val=$db->getone($sql);
	if (empty($val))
	{
	$sql = "select * from ".table('crm_client_tmp')." where id='{$id}' {$wheresql}";
	$val=$db->getone($sql);
	}
	if ($val['company_id']>0)
	{
	$val['company_url']=url_rewrite('QS_companyshow',array('id'=>$val['company_id']));
	}
	else
	{
	$val['company_url']='';
	}
	$sql = "select * from ".table('crm_client_log')." WHERE client_id='{$id}' ORDER BY `id` DESC ";
	$val['log']=$db->getall($sql);
	$sql = "select * from ".table('crm_client_financial')." WHERE client_id='{$id}'";
	$val['financial']=$db->getone($sql);
	$sql = "select * from ".table('crm_client_demand')." WHERE client_id='{$id}'";
	$val['demand']=$db->getone($sql);
	$sql = "select * from ".table('crm_client_other')." WHERE client_id='{$id}'";
	$val['other']=$db->getone($sql);
	$sql = "select * from ".table('crm_admin')." WHERE admin_id='{$val['crm_id']}'";
	$val['admin']=$db->getone($sql);
	return $val;
}
function get_crm_category_alias($alias)
{
	global $db;
	$sql = "select * from ".table('crm_category')." WHERE c_alias='{$alias}'";
	$val=$db->getall($sql);
	return $val;
}
function set_client($type,$id,$v)
{
	global $db;
	if (!is_array($id))$id=array($id);
	$sqlin=implode(",",$id);
	$return=0;
	$v=intval($v);
	$time = time();
	$typearray=array('grade_id','status_id','type_id','source_id','trustworthiness_id','crm_id');
	if (!in_array($type,$typearray))
	{
	return false;
	}
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		if($type=="status_id"&&$v==3){
			if (!$db->query("update  ".table('crm_client')." SET {$type}={$v},dealtime=".$time.",edittime=".$time." WHERE id IN ({$sqlin})")) return false;
			$return=$return+$db->affected_rows();
			if (!$db->query("update  ".table('crm_client_tmp')." SET {$type}={$v},dealtime=".$time.",edittime=".$time." WHERE id IN ({$sqlin})")) return false;
		}else{
			if (!$db->query("update  ".table('crm_client')." SET {$type}={$v},edittime=".$time." WHERE id IN ({$sqlin})")) return false;
			$return=$return+$db->affected_rows();
			if (!$db->query("update  ".table('crm_client_tmp')." SET {$type}={$v},edittime=".$time." WHERE id IN ({$sqlin})")) return false;
		}
		
		if ($type=='crm_id')
		{
		if (!$db->query("update  ".table('crm_client')." SET addtime=".$time.",edittime=".$time."  WHERE id IN ({$sqlin})")) return false;
		if (!$db->query("update  ".table('crm_client_tmp')." SET addtime=".$time.",edittime=".$time."  WHERE id IN ({$sqlin})")) return false;
		}
		return $return;
	}
	else
	{
	return false;
	}
}
function set_fail($id,$crm_id)
{
	global $db;
	$crm_id=intval($crm_id);
	if (!is_array($id))$id=array($id);
	$sqlin=implode(",",$id);
	$return=0;
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		$result = $db->query("SELECT * FROM ".table('crm_client')." WHERE crm_id='{$crm_id}' AND id IN ({$sqlin}) ");
		while($row = $db->fetch_array($result))
		{
		$setsql=array_map('addslashes',$row);
		$setsql['edittime'] = time();
		inserttable(table('crm_client_tmp'),$setsql);
	 	$return++;
		}
		if (!$db->query("Delete from ".table('crm_client')." WHERE crm_id='{$crm_id}' AND id IN ({$sqlin})")) return false;
		return $return;
	}
	else
	{
	return false;
	}
}
function set_effective($id,$crm_id)
{
	global $db;
	$crm_id=intval($crm_id);
	if (!is_array($id))$id=array($id);
	$sqlin=implode(",",$id);
	$return=0;
	if (preg_match("/^(\d{1,10},)*(\d{1,10})$/",$sqlin))
	{
		$result = $db->query("SELECT * FROM ".table('crm_client_tmp')." WHERE crm_id='{$crm_id}' AND id IN ({$sqlin}) ");
		while($row = $db->fetch_array($result))
		{
		$setsql=array_map('addslashes',$row);
		$setsql['edittime'] = time();
		inserttable(table('crm_client'),$setsql);
	 	$return++;
		}
		if (!$db->query("Delete from ".table('crm_client_tmp')." WHERE crm_id='{$crm_id}' AND id IN ({$sqlin})")) return false;
		return $return;
	}
	else
	{
	return false;
	}
}
function del_client($id)
{
	global $db;
	if (!is_array($id))$id=array($id);
	$sqlin=implode(",",$id);
	foreach ($id as $key => $value) {
		$company = $db->getone("select company_id from ".table('crm_client_tmp')." where id=".$value);
		$companyid_arr[$key] = $company['company_id'];
	}
	$company_str = implode(",",$companyid_arr);
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
		if (!$db->query("Delete from ".table('crm_client_tmp')." WHERE id IN ({$sqlin}) {$wheresql}")) return false;
		$return=$return+$db->affected_rows();
		if (!$db->query("Delete from ".table('crm_client_demand')." WHERE client_id IN ({$sqlin}) {$wheresql}")) return false;
		if (!$db->query("Delete from ".table('crm_client_financial')." WHERE client_id IN ({$sqlin}) {$wheresql}")) return false;
		if (!$db->query("Delete from ".table('crm_client_log')." WHERE client_id IN ({$sqlin}) {$wheresql}")) return false;
		if (!$db->query("Delete from ".table('crm_client_other')." WHERE client_id IN ({$sqlin}) {$wheresql}")) return false;
		$db->query("UPDATE ".table('company_profile')." SET crm_id = 0 WHERE id IN ({$company_str}) {$wheresql}");
		return $return;
	}
	else
	{
	return false;
	}
}
function get_admin_list($admin_id)
{
	global $db;
	$sql = "select * from ".table('crm_admin')."  ";
	return $db->getall($sql);
}
function get_user($uid)
{
	global $db;
	$sql = "select * from ".table('members')." where uid=".intval($uid)." LIMIT 1";
	return $db->getone($sql);
}
?>