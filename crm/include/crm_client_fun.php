<?php
 /*
 * 74cms 管理中心 企业用户相关函数
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
function get_company($offset,$perpage,$get_sql= '')
{
	global $db;
	$row_arr = array();
	$limit=" LIMIT ".$offset.','.$perpage;
	$result = $db->query("SELECT c.*,m.username FROM ".table('company_profile')." AS c ".$get_sql.$limit);
	while($row = $db->fetch_array($result))
	{
	$row['company_url']=url_rewrite('QS_companyshow',array('id'=>$row['id']));
	$row_arr[] = $row;
	}
	return $row_arr;
}
?>