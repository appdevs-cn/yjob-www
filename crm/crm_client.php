<?php
 /*
 * 74cms 资源池
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/crm_common.inc.php');
require_once(CRM_ROOT_PATH.'include/crm_client_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'company_list';
if($act == 'company_list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	if ($_GET['crm_id']<>"")
	{
		$crm_id=intval($_GET['crm_id']);
		$wheresql.=" AND c.crm_id ='{$crm_id}'";
	}
	else
	{
		$_GET['crm_id']=0;
		$wheresql.=" AND c.crm_id ='0'";
	}
	$oederbysql=" order BY c.id DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql.=" AND c.companyname like '%{$key}%'";
		elseif ($key_type===2)$wheresql.=" AND c.id ='".intval($key)."'";
		elseif ($key_type===3)$wheresql.=" AND m.username like '{$key}%'";
		elseif ($key_type===4)$wheresql.=" AND c.uid ='".intval($key)."'";
		elseif ($key_type===5)$wheresql.=" AND c.address  like '%{$key}%'";
		elseif ($key_type===6)$wheresql.=" AND c.telephone  like '{$key}%'";
		$oederbysql="";
	}
	if (!empty($_GET['settr']))
	{
		$settr=strtotime("-".intval($_GET['settr'])." day");
		$wheresql.=" AND c.addtime> ".$settr;
	}
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$joinsql=" LEFT JOIN ".table('members')." AS m ON c.uid=m.uid  ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('company_profile')." AS c".$joinsql.$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$clist = get_company($offset,$perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('pageheader',"资源池");
	$smarty->assign('clist',$clist);
	$smarty->assign('crm_admin_id',$_SESSION['crm_admin_id']);
	$smarty->assign('certificate_dir',$certificate_dir);
	$smarty->assign('page',$page->show(3));
	$smarty->display('company/crm_company_list.htm');
}
elseif($act == 'receive')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"receive_client");
	$cid=intval($_GET['id']);
	$sql = "select * from ".table('company_profile')." where id='{$cid}'";
	$com=$db->getone($sql);
	$count = $db->getone("select count(*) from ".table('crm_client')." where crm_id=".$_SESSION['crm_admin_id']);
	$max_receive_client_num = $db->getone("select config_value from ".table('crm_users_config')." where id=1");

	if (empty($com))
	{
	crmmsg("资源不存在！",1);
	}
	elseif ($com['crm_id']<>'0')
	{
	crmmsg("资源已被领取！",1);
	}
	elseif ($count['count(*)']>=$max_receive_client_num['config_value'])
	{
	crmmsg("您已达到可领取最大数量！",1);
	}
	else
	{
		$setsqlarr['crm_id']=intval($_SESSION['crm_admin_id']);
		$setsqlarr['company_id']=intval($com['id']);
		$setsqlarr['companyname']=trim($com['companyname']);
		$setsqlarr['trade_cn']=trim($com['trade_cn']);
		$setsqlarr['district_cn']=trim($com['district_cn']);
		$setsqlarr['scale_cn']=trim($com['scale_cn']);
		$setsqlarr['address']=trim($com['address']);
		$setsqlarr['contact']=trim($com['contact']);
		$setsqlarr['telephone']=trim($com['telephone']);
		$setsqlarr['email']=trim($com['email']);
		$setsqlarr['website']=trim($com['website']);
		$setsqlarr['note']='';
		$setsqlarr['addtime']=time();
		$setsqlarr['edittime']=time();
		$setsqlarr['followtime']=0;
		$setsqlarr['nexttime']=0;
		$setsqlarr['grade_id']=6;
		$setsqlarr['type_id']=4;
		$setsqlarr['source_id']=9;
		$setsqlarr=array_map('addslashes',$setsqlarr);
		$insert_id=inserttable(table('crm_client'),$setsqlarr,true);
		//
		$setsql['client_id']=$insert_id;
		inserttable(table('crm_client_demand'),$setsql);
		inserttable(table('crm_client_other'),$setsql);
		inserttable(table('crm_client_financial'),$setsql);
		$db->query("UPDATE ".table('company_profile')." SET crm_id = '{$_SESSION['crm_admin_id']}' WHERE id='{$cid}'  LIMIT 1");
		$link[0]['text'] = "查看我的客户";
		$link[0]['href'] = "?act=members_list";
		$link[1]['text'] = "返回上一页";
		$link[1]['href'] = "javascript:history.go(-1)";
		crmmsg("领取成功！",2);	
	}	
}
?>