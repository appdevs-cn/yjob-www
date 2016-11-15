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
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/crm_common.inc.php');
require_once(CRM_ROOT_PATH.'include/crm_myclient_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'myclient_list';
if($act == 'myclient_list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	if ($_SESSION['crm_admin_purview']=="all")
	{
	$wheresql="";
	$is_admin = 1;
	}
	else
	{
	$wheresql=" AND c.crm_id ='{$_SESSION['crm_admin_id']}'";
	$is_admin = 0;
	}
	$oederbysql=" order BY c.nexttime asc ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql.=" AND c.companyname like '%{$key}%'";
		elseif ($key_type===2)$wheresql.=" AND c.address like '%{$key}%'";
		elseif ($key_type===3)$wheresql.=" AND c.contact like '%{$key}%'";
		elseif ($key_type===4)$wheresql.=" AND c.telephone like '%{$key}%'";
		elseif ($key_type===5)$wheresql.=" AND c.email  like '%{$key}%'";
		elseif ($key_type===6)$wheresql.=" AND c.website  like '%{$key}%'";
		$oederbysql="";
	}
	if (!empty($_GET['nofollow']))
	{
		if(intval($_GET['nofollow'])==1){
			$wheresql.=" AND c.followtime=0";
		}
	}
	if (!empty($_GET['todayfollow']))
	{
		$today = strtotime(date("Y-m-d"));
		if(intval($_GET['todayfollow'])==1){
			$wheresql.=" AND c.nexttime={$today}";
		}
	}

	if (!empty($_GET['status_id']))
	{
		$wheresql.=" AND c.status_id= ".intval($_GET['status_id']);
	}
	if (!empty($_GET['grade_id']))
	{
		$wheresql.=" AND c.grade_id= ".intval($_GET['grade_id']);
	}
	if (!empty($_GET['source_id']))
	{
		$wheresql.=" AND c.source_id= ".intval($_GET['source_id']);
	}
	if (!empty($_GET['trustworthiness_id']))
	{
		$wheresql.=" AND c.trustworthiness_id= ".intval($_GET['trustworthiness_id']);
	}
	if (!empty($_GET['followtime']))
	{
		$settr=strtotime("-".intval($_GET['followtime'])." day");
		$wheresql.=" AND c.followtime> ".$settr;
	}
	if (!empty($_GET['nexttime']))
	{
		$settr=strtotime("+".intval($_GET['nexttime'])." day");
		$wheresql.=" AND c.nexttime< ".$settr;
	}
	if (!empty($_GET['admin_id']))
	{
		$wheresql.=" AND c.crm_id=".$_GET['admin_id'];
	}
	if(!empty($_GET['willdeadline'])){
		if(intval($_GET['willdeadline'])==1){
			$today = strtotime(date("Y-m-d"));
			$willdeadline = $today+3600*24*7;
			$deadline_members_setmeal = $db->getall("select uid,setmeal_id,endtime from ".table('members_setmeal')." where endtime>{$today} and endtime<{$willdeadline}");
			foreach ($deadline_members_setmeal as $key => $value) {
				$uid_arr[] = $value['uid'];
			}
			$uid_str = implode(",", $uid_arr);
			if($uid_str!=""){
				$companyids = $db->getall("select id from ".table('company_profile')." where uid in ($uid_str)");
				foreach ($companyids as $key => $value) {
					$company_arr[] = $value['id'];
				}
				$company_str = implode(",", $company_arr);
				if($company_str!=""){
					$total9 = $db->get_total("select count(*) AS num from ".table('crm_client')." where company_id in ($company_str) and crm_id={$_SESSION['crm_admin_id']}");
				$wheresql.=" AND c.company_id in (".$company_str.")";
				}
			}else{
				$wheresql=" id>9999999";
			}
		}
	}
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$perpage = intval($_POST['perpage'])==0?10:intval($_POST['perpage']);
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_client')." AS c".$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$category=get_cache('crm_category');
	$admins = $db->getall("select * from ".table('crm_admin'));
	$smarty->assign('admins',$admins);
	$smarty->assign('is_admin',$is_admin);
	$clist = get_myclient($offset,$perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('pageheader',"客户管理");
	$smarty->assign('clist',$clist);
	$smarty->assign('crm_admin_id',$_SESSION['crm_admin_id']);
	$smarty->assign('certificate_dir',$certificate_dir);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('total_val',$total_val);
	$category_status=get_crm_category_alias('QS_crm_status');
	$category_type=get_crm_category_alias('QS_crm_type');
	$category_grade=get_crm_category_alias('QS_crm_grade');
	$category_source=get_crm_category_alias('QS_crm_source');
	$category_trustworthiness=get_crm_category_alias('QS_crm_trustworthiness');
	$my_contacts_group = $db->getall("select * from ".table('crm_my_contacts_group')." where admin_id=".$_SESSION['crm_admin_id']);
	$smarty->assign('perpage',$perpage);
	$smarty->assign('my_contacts_group',$my_contacts_group);
	$smarty->assign('category_status',$category_status);
	$smarty->assign('category_type',$category_type);
	$smarty->assign('category_grade',$category_grade);
	$smarty->assign('category_source',$category_source);
	$smarty->assign('category_trustworthiness',$category_trustworthiness);
	$smarty->assign('admin_list',get_admin_list());	
	$smarty->display('myclient/crm_myclient_list.htm');
}
elseif($act == 'deal_list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	if ($_SESSION['crm_admin_purview']=="all")
	{
	$wheresql="";
	$is_admin = 1;
	}
	else
	{
	$wheresql=" AND c.crm_id ='{$_SESSION['crm_admin_id']}'";
	$is_admin = 0;
	}
	$oederbysql=" order BY c.dealtime desc ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql.=" AND c.companyname like '%{$key}%'";
		elseif ($key_type===2)$wheresql.=" AND c.address like '%{$key}%'";
		elseif ($key_type===3)$wheresql.=" AND c.contact like '%{$key}%'";
		elseif ($key_type===4)$wheresql.=" AND c.telephone like '%{$key}%'";
		elseif ($key_type===5)$wheresql.=" AND c.email  like '%{$key}%'";
		elseif ($key_type===6)$wheresql.=" AND c.website  like '%{$key}%'";
		$oederbysql="";
	}
	if (!empty($_GET['status_id']))
	{
		$wheresql.=" AND c.status_id= ".intval($_GET['status_id']);
	}
	if (!empty($_GET['grade_id']))
	{
		$wheresql.=" AND c.grade_id= ".intval($_GET['grade_id']);
	}
	if (!empty($_GET['source_id']))
	{
		$wheresql.=" AND c.source_id= ".intval($_GET['source_id']);
	}
	if (!empty($_GET['trustworthiness_id']))
	{
		$wheresql.=" AND c.trustworthiness_id= ".intval($_GET['trustworthiness_id']);
	}
	if (!empty($_GET['followtime']))
	{
		$settr=strtotime("-".intval($_GET['followtime'])." day");
		$wheresql.=" AND c.followtime> ".$settr;
	}
	if (!empty($_GET['nexttime']))
	{
		$settr=strtotime("+".intval($_GET['nexttime'])." day");
		$wheresql.=" AND c.nexttime< ".$settr;
	}
	if (!empty($_GET['admin_id']))
	{
		$wheresql.=" AND c.crm_id=".$_GET['admin_id'];
	}
	$wheresql .= " AND status_id=3 ";
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$perpage = intval($_POST['perpage'])==0?10:intval($_POST['perpage']);
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_client')." AS c".$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$category=get_cache('crm_category');
	$admins = $db->getall("select * from ".table('crm_admin'));
	$smarty->assign('admins',$admins);
	$smarty->assign('is_admin',$is_admin);
	$clist = get_myclient($offset,$perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('pageheader',"已成交客户");
	$smarty->assign('clist',$clist);
	$smarty->assign('crm_admin_id',$_SESSION['crm_admin_id']);
	$smarty->assign('certificate_dir',$certificate_dir);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('total_val',$total_val);
	$category_status=get_crm_category_alias('QS_crm_status');
	$category_type=get_crm_category_alias('QS_crm_type');
	$category_grade=get_crm_category_alias('QS_crm_grade');
	$category_source=get_crm_category_alias('QS_crm_source');
	$category_trustworthiness=get_crm_category_alias('QS_crm_trustworthiness');
	$my_contacts_group = $db->getall("select * from ".table('crm_my_contacts_group')." where admin_id=".$_SESSION['crm_admin_id']);
	$smarty->assign('perpage',$perpage);
	$smarty->assign('my_contacts_group',$my_contacts_group);
	$smarty->assign('category_status',$category_status);
	$smarty->assign('category_type',$category_type);
	$smarty->assign('category_grade',$category_grade);
	$smarty->assign('category_source',$category_source);
	$smarty->assign('category_trustworthiness',$category_trustworthiness);
	$smarty->assign('admin_list',get_admin_list());	
	$smarty->display('myclient/crm_myclient_deal_list.htm');
}
elseif($act == 'myclient_edit')
{
	get_token();
	check_permissions($_SESSION['crm_admin_purview'],"client_edit");
	$yid =!empty($_REQUEST['id'])?intval($_REQUEST['id']):crmmsg("你没有选择客户！",1);
	if ($_SESSION['crm_admin_purview']=="all")
	{
	$myclient=get_myclient_one_id($yid);
	}
	else
	{
	$myclient=get_myclient_one_id($yid,$_SESSION['crm_admin_id']);
	}
	$category_status=get_crm_category_alias('QS_crm_status');
	$category_type=get_crm_category_alias('QS_crm_type');
	$category_grade=get_crm_category_alias('QS_crm_grade');
	$category_source=get_crm_category_alias('QS_crm_source');
	$category_trustworthiness=get_crm_category_alias('QS_crm_trustworthiness');
	$smarty->assign('pageheader',"客户管理");
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->assign('myclient',$myclient);
	$smarty->assign('category_status',$category_status);
	$smarty->assign('category_type',$category_type);
	$smarty->assign('category_grade',$category_grade);
	$smarty->assign('category_source',$category_source);
	$smarty->assign('category_trustworthiness',$category_trustworthiness);
	$smarty->assign('url',request_url());
	$smarty->display('myclient/crm_myclient_edit.htm');
}
elseif($act == 'crm_client_save')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"client_edit");
	$id=intval($_POST['id']);
	$setsqlarr['companyname']=trim($_POST['companyname'])?trim($_POST['companyname']):crmmsg('您填写客户名称！',1);
	$setsqlarr['trade_cn']=trim($_POST['trade_cn']);
	$setsqlarr['scale_cn']=trim($_POST['scale_cn']);
	$setsqlarr['district_cn']=trim($_POST['district_cn']);
	$setsqlarr['address']=trim($_POST['address']);
	$setsqlarr['website']=trim($_POST['website']);
	$setsqlarr['contact']=trim($_POST['contact']);
	$setsqlarr['telephone']=trim($_POST['telephone']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['edittime']=time();
	$wheresql=" id='{$id}'";
	updatetable(table('crm_client'),$setsqlarr,$wheresql);
	crmmsg('操作成功！',2);
}
elseif($act == 'add_log')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"client_add_log");
	$id=intval($_POST['id']);
	$setsqlarr['client_log']=trim($_POST['client_log'])?trim($_POST['client_log']):crmmsg('您填写跟进日志！',1);
	if ($_POST['nexttime']=="")
	{
	crmmsg('您填写下次跟进日期！',1);
	}
	$setsqlarr['addtime']=time();
	$setsqlarr['client_id']=$id;
	inserttable(table('crm_client_log'),$setsqlarr);
	//
	$follo['followtime']=time();
	$follo['edittime']=time();
	if ($_POST['nexttime']<>"")
	{
		$nexttime=convert_datefm($_POST['nexttime'],2);
		if ($nexttime=='')
		{
		crmmsg('日期格式错误！',0);	
		}
		else
		{
			if($nexttime<$timestamp)
			{
				crmmsg('下次联系日期不能小于今天！',0);	
			}
			else
			{
				$follo['nexttime']=$nexttime;
			}
		}
	}
	$wheresql=" id='{$id}'";
	updatetable(table('crm_client'),$follo,$wheresql);
	crmmsg('操作成功！',2);
}
elseif($act == 'details_save')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"client_edit");
	$id=intval($_POST['id']);
	$setsqlarr['grade_id']=intval($_POST['grade_id']);
	$setsqlarr['status_id']=intval($_POST['status_id']);
	$setsqlarr['type_id']=intval($_POST['type_id']);
	$setsqlarr['source_id']=intval($_POST['source_id']);
	$setsqlarr['trustworthiness_id']=intval($_POST['trustworthiness_id']);
	$setsqlarr['dealtime'] = $setsqlarr['status_id']==3?time():0;
	$setsqlarr['edittime']=time();
	$wheresql=" id='{$id}'";
	updatetable(table('crm_client'),$setsqlarr,$wheresql);
	crmmsg('操作成功！',2);
}
elseif($act == 'financial_save')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"client_edit");
	$id=intval($_POST['id']);
	$setsqlarr['client_bank']=trim($_POST['client_bank']);
	$setsqlarr['client_bank_acc']=trim($_POST['client_bank_acc']);
	$setsqlarr['client_note']=trim($_POST['client_note']);
	$wheresql=" client_id='{$id}'";
	updatetable(table('crm_client_financial'),$setsqlarr,$wheresql);
	$follo['edittime'] = time();
	$wheresqlfollo=" id='{$id}'";
	updatetable(table('crm_client'),$follo,$wheresqlfollo);
	crmmsg('操作成功！',2);
}
elseif($act == 'demand_save')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"client_edit");
	$id=intval($_POST['id']);
	$setsqlarr['client_other']=trim($_POST['client_other']);
	$wheresql=" client_id='{$id}'";
	updatetable(table('crm_client_demand'),$setsqlarr,$wheresql);
	$follo['edittime'] = time();
	$wheresqlfollo=" id='{$id}'";
	updatetable(table('crm_client'),$follo,$wheresqlfollo);
	crmmsg('操作成功！',2);
}
elseif($act == 'other_save')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"client_edit");
	$id=intval($_POST['id']);
	$setsqlarr['client_other']=trim($_POST['client_other']);
	$wheresql=" client_id='{$id}'";
	updatetable(table('crm_client_other'),$setsqlarr,$wheresql);
	$follo['edittime'] = time();
	$wheresqlfollo=" id='{$id}'";
	updatetable(table('crm_client'),$follo,$wheresqlfollo);
	crmmsg('操作成功！',2);
}
elseif($act == 'perform')
{
	check_token();
	$yid =!empty($_POST['y_id'])?$_POST['y_id']:crmmsg("你没有选择客户！",1);
	if (!empty($_REQUEST['set_status']))
		{
			check_permissions($_SESSION['crm_admin_purview'],"client_edit");
			$status_id=intval($_POST['status_id']);
			if ($status_id===0)
			{
			crmmsg("请选择选项！",0);
			}
			$num=set_client('status_id',$yid,$status_id);
			if ($num>0)
			{
			crmmsg("操作成功！共影响".$num."行",2);
			}
			else
			{
			crmmsg("操作失败！",0);
			}
		}
		elseif (!empty($_POST['set_grade']))
		{
			check_permissions($_SESSION['crm_admin_purview'],"client_edit");
			$grade_id=intval($_POST['grade_id']);
			if ($grade_id===0)
			{
			crmmsg("请选择选项！",0);
			}
			$num=set_client('grade_id',$yid,$grade_id);
			if ($num>0)
			{
			crmmsg("操作成功！共影响".$num."行",2);
			}
			else
			{
			crmmsg("操作失败！",0);
			}
		}
		elseif (!empty($_POST['set_trustworthiness']))
		{
			check_permissions($_SESSION['crm_admin_purview'],"client_edit");
			$trustworthiness_id=intval($_POST['trustworthiness_id']);
			if ($trustworthiness_id===0)
			{
			crmmsg("请选择选项！",0);
			}
			$num=set_client('trustworthiness_id',$yid,$trustworthiness_id);
			if ($num>0)
			{
			crmmsg("操作成功！共影响".$num."行",2);
			}
			else
			{
			crmmsg("操作失败！",0);
			}
		}
		elseif (!empty($_POST['set_deliver']))
		{
			check_permissions($_SESSION['crm_admin_purview'],"client_fail");
			$crm_id=intval($_POST['crm_id']);
			if ($crm_id===0)
			{
			crmmsg("请选择选项！",0);
			}
			$num=set_client('crm_id',$yid,$crm_id);
			if ($num>0)
			{
			crmmsg("操作成功！共影响".$num."行",2);
			}
			else
			{
			crmmsg("操作失败！",0);
			}
		}
		elseif(!empty($_POST['to_mycontacts'])){
			check_permissions($_SESSION['crm_admin_purview'],"to_mycontacts");
			$yid_str = implode(",", $yid);
			$clients_info = $db->getall("select * from ".table('crm_client')." where id in (".$yid_str.")");
			foreach ($clients_info as $key => $value) {
				$setsqlarr['crm_id'] = $_SESSION['crm_admin_id'];
				$setsqlarr['fullname'] = $value['contact'];
				$setsqlarr['tel'] = $value['telephone'];
				$setsqlarr['email'] = $value['email'];
				$setsqlarr['web'] = $value['website'];
				$setsqlarr['address'] = $value['address'];
				$setsqlarr['group_id'] = intval($_POST['group_id']);
				inserttable(table("crm_my_contacts"),$setsqlarr);
			}
			crmmsg("导入完成",2);
		}
}
elseif($act == 'myclient_add')
{
	check_permissions($_SESSION['crm_admin_purview'],"add_client");
	get_token();
	$category_status=get_crm_category_alias('QS_crm_status');
	$category_type=get_crm_category_alias('QS_crm_type');
	$category_grade=get_crm_category_alias('QS_crm_grade');
	$category_source=get_crm_category_alias('QS_crm_source');
	$category_trustworthiness=get_crm_category_alias('QS_crm_trustworthiness');
	$smarty->assign('pageheader',"新增客户");
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->assign('category_status',$category_status);
	$smarty->assign('category_type',$category_type);
	$smarty->assign('category_grade',$category_grade);
	$smarty->assign('category_source',$category_source);
	$smarty->assign('category_trustworthiness',$category_trustworthiness);
	$smarty->display('myclient/crm_myclient_add.htm');
 
}
elseif($act == 'add_save')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"add_client");
	$setsqlarr['crm_id']=intval($_SESSION['crm_admin_id']);
	$setsqlarr['company_id']=0;	
	$setsqlarr['companyname']=trim($_POST['companyname'])?trim($_POST['companyname']):crmmsg('您填写客户名称！',1);
	$setsqlarr['trade_cn']=trim($_POST['trade_cn']);
	$setsqlarr['district_cn']=trim($_POST['district_cn']);
	$setsqlarr['scale_cn']=trim($_POST['scale_cn']);
	$setsqlarr['address']=trim($_POST['address']);
	$setsqlarr['website']=trim($_POST['website']);
	$setsqlarr['contact']=trim($_POST['contact']);
	$setsqlarr['telephone']=trim($_POST['telephone']);
	$setsqlarr['email']=trim($_POST['email']);
	$setsqlarr['addtime']=time();
	$setsqlarr['grade_id']=intval($_POST['grade_id']);
	$setsqlarr['status_id']=intval($_POST['status_id']);
	$setsqlarr['type_id']=intval($_POST['type_id']);
	$setsqlarr['source_id']=intval($_POST['source_id']);
	$setsqlarr['trustworthiness_id']=intval($_POST['trustworthiness_id']);
	$setsqlarr['dealtime'] = $setsqlarr['status_id']==3?time():0;
	$setsqlarr['edittime'] = $setsqlarr['addtime'];
	$insert_id=inserttable(table('crm_client'),$setsqlarr,true);
	$setsql['client_id']=$insert_id;
	$setsql['client_other']=trim($_POST['demand_other']);	
	inserttable(table('crm_client_demand'),$setsql);
	unset($setsql);
	$setsql['client_id']=$insert_id;
	$setsql['client_other']=trim($_POST['other_other']);
	inserttable(table('crm_client_other'),$setsql);
	unset($setsql);
	$setsql['client_id']=$insert_id;
	$setsql['client_bank']=trim($_POST['client_bank']);
	$setsql['client_bank_acc']=trim($_POST['client_bank_acc']);
	$setsql['client_note']=trim($_POST['bank_note']);
	inserttable(table('crm_client_financial'),$setsql);
	$link[0]['text'] = "继续添加客户";
	$link[0]['href'] = "?act=add_save";
	$link[1]['text'] = "客户列表";
	$link[1]['href'] = "?";
	crmmsg("添加成功！",2);	
}
elseif($act == 'set_fail')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"set_fail");
	$yid =!empty($_POST['y_id'])?$_POST['y_id']:crmmsg("你没有选择客户！",1);
	$num=set_fail($yid,$_SESSION['crm_admin_id']);
	if ($num>0)
	{
		crmmsg("操作成功！共影响".$num."行",2);
	}
	else
	{
		crmmsg("操作失败！",0);
	}
}
elseif($act == 'fail_list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	if ($_SESSION['crm_admin_purview']=="all")
	{
	$wheresql="";
	}
	else
	{
	$wheresql=" AND c.crm_id ='{$_SESSION['crm_admin_id']}'";
	}
	$oederbysql=" order BY c.id DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql.=" AND c.companyname like '%{$key}%'";
		elseif ($key_type===2)$wheresql.=" AND c.address like '%{$key}%'";
		elseif ($key_type===3)$wheresql.=" AND c.contact like '%{$key}%'";
		elseif ($key_type===4)$wheresql.=" AND c.telephone like '%{$key}%'";
		elseif ($key_type===5)$wheresql.=" AND c.email  like '%{$key}%'";
		elseif ($key_type===6)$wheresql.=" AND c.website  like '%{$key}%'";
		$oederbysql="";
	}
	if (!empty($_GET['status_id']))
	{
		$wheresql.=" AND c.status_id= ".intval($_GET['status_id']);
	}
	if (!empty($_GET['grade_id']))
	{
		$wheresql.=" AND c.grade_id= ".intval($_GET['grade_id']);
	}
	if (!empty($_GET['source_id']))
	{
		$wheresql.=" AND c.source_id= ".intval($_GET['source_id']);
	}
	if (!empty($_GET['trustworthiness_id']))
	{
		$wheresql.=" AND c.trustworthiness_id= ".intval($_GET['trustworthiness_id']);
	}
	if (!empty($_GET['followtime']))
	{
		$settr=strtotime("-".intval($_GET['followtime'])." day");
		$wheresql.=" AND c.followtime> ".$settr;
	}
	if (!empty($_GET['nexttime']))
	{
		$settr=strtotime("+".intval($_GET['nexttime'])." day");
		$wheresql.=" AND c.nexttime< ".$settr;
	}
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_client_tmp')." AS c".$wheresql;
	$total_val=$db->get_total($total_sql);
	$page = new page(array('total'=>$total_val, 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$category=get_cache('crm_category');
	$clist = get_myclient_tmp($offset,$perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('pageheader',"无效客户");
	$smarty->assign('clist',$clist);
	$smarty->assign('crm_admin_id',$_SESSION['crm_admin_id']);
	$smarty->assign('certificate_dir',$certificate_dir);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('total_val',$total_val);
	$category_status=get_crm_category_alias('QS_crm_status');
	$category_type=get_crm_category_alias('QS_crm_type');
	$category_grade=get_crm_category_alias('QS_crm_grade');
	$category_source=get_crm_category_alias('QS_crm_source');
	$category_trustworthiness=get_crm_category_alias('QS_crm_trustworthiness');
	$smarty->assign('category_status',$category_status);
	$smarty->assign('category_type',$category_type);
	$smarty->assign('category_grade',$category_grade);
	$smarty->assign('category_source',$category_source);
	$smarty->assign('category_trustworthiness',$category_trustworthiness);
	$smarty->assign('admin_list',get_admin_list());	
	$smarty->display('myclient/crm_myclient_list_tmp.htm');
}
elseif($act == 'fail_show')
{
	get_token();
	$yid =!empty($_REQUEST['id'])?intval($_REQUEST['id']):crmmsg("你没有选择客户！",1);
	if ($_SESSION['crm_admin_purview']=="all")
	{
	$myclient=get_myclient_one_id($yid);
	}
	else
	{
	$myclient=get_myclient_one_id($yid,$_SESSION['crm_admin_id']);
	}
	$category_status=get_crm_category_alias('QS_crm_status');
	$category_type=get_crm_category_alias('QS_crm_type');
	$category_grade=get_crm_category_alias('QS_crm_grade');
	$category_source=get_crm_category_alias('QS_crm_source');
	$category_trustworthiness=get_crm_category_alias('QS_crm_trustworthiness');
	$smarty->assign('pageheader',"客户管理");
	$smarty->assign('url',$_SERVER["HTTP_REFERER"]);
	$smarty->assign('myclient',$myclient);
	$smarty->assign('category_status',$category_status);
	$smarty->assign('category_type',$category_type);
	$smarty->assign('category_grade',$category_grade);
	$smarty->assign('category_source',$category_source);
	$smarty->assign('category_trustworthiness',$category_trustworthiness);
	$smarty->display('myclient/crm_myclient_edit_fail.htm');
}
elseif($act == 'set_effective')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"set_fail");
	$yid =!empty($_POST['y_id'])?$_POST['y_id']:crmmsg("你没有选择客户！",1);
	$num=set_effective($yid,$_SESSION['crm_admin_id']);
	if ($num>0)
	{
		crmmsg("操作成功！共影响".$num."行",2);
	}
	else
	{
		crmmsg("操作失败！",0);
	}
}
elseif($act == 'del_client')
{
	check_token();
	check_permissions($_SESSION['crm_admin_purview'],"del_fail");
	$yid =!empty($_POST['y_id'])?$_POST['y_id']:crmmsg("你没有选择客户！",1);
	$num=del_client($yid);
	if ($num>0)
	{
		crmmsg("操作成功！共影响".$num."行",2);
	}
	else
	{
		crmmsg("操作失败！",0);
	}
}
elseif($act == 'management')
{	
	$id=intval($_GET['id']);
	$u=get_user($id);
	if (!empty($u))
	{
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
		unset($_SESSION['utype']);
		unset($_SESSION['uqqid']);
		setcookie("QS[uid]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
		setcookie("QS[username]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
		setcookie("QS[password]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
		setcookie("QS[utype]","",time() - 3600,$QS_cookiepath, $QS_cookiedomain);
		unset($_SESSION['activate_username']);
		unset($_SESSION['activate_email']);
		
		$_SESSION['uid']=$u['uid'];
		$_SESSION['username']=$u['username'];
		$_SESSION['utype']=$u['utype'];
		$_SESSION['uqqid']="1";
		setcookie('QS[uid]',$u['uid'],0,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[username]',$u['username'],0,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[password]',$u['password'],0,$QS_cookiepath,$QS_cookiedomain);
		setcookie('QS[utype]',$u['utype'], 0,$QS_cookiepath,$QS_cookiedomain);
		header("Location:".get_member_url($u['utype']));
	}	
} 
elseif($act == "myclient_export"){
	check_permissions($_SESSION['crm_admin_purview'],"myclient_export");
	$yid =!empty($_POST['y_id'])?$_POST['y_id']:crmmsg("你没有选择客户！",1);
	$yid_str = implode(",", $yid);
	$oederbysql=" order BY nexttime asc ";
	$wheresql = empty($wheresql)?" id in ({$yid_str}) ":" and id in ({$yid_str}) ";
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$data = $db->getall("select * from ".table('crm_client').$wheresql);
	if(empty($data)){
		crmmsg("当前没有数据！",1);
	}
	$category = $db->getall("select c_id,c_alias,c_name from ".table('crm_category'));
	foreach ($category as $key => $value) {
		$category_arr[$value['c_alias']][$value['c_id']] = $value['c_name'];
	}
	foreach ($data as $key => $value) {
		$admin = $db->getone("select admin_name from ".table('crm_admin')." where admin_id=".$value['crm_id']);
		$data[$key]['crm_id'] = $admin['admin_name'];
		$data[$key]['addtime'] = date("Y-m-d H:i:s",$value['addtime']);
		$data[$key]['followtime'] = $value['followtime']==0?"未跟进":date("Y-m-d H:i:s",$value['followtime']);
		$data[$key]['nexttime'] = $value['nexttime']==0?"未设置":date("Y-m-d",$value['nexttime']);
		$data[$key]['grade_id'] = $value['grade_id']==0?"未知":$category_arr['QS_crm_grade'][$value['grade_id']];
		$data[$key]['status_id'] = $value['status_id']==0?"未知":$category_arr['QS_crm_status'][$value['status_id']];
		$data[$key]['type_id'] = $value['type_id']==0?"未知":$category_arr['QS_crm_type'][$value['type_id']];
		$data[$key]['source_id'] = $value['source_id']==0?"未知":$category_arr['QS_crm_source'][$value['source_id']];
		$data[$key]['trustworthiness_id'] = $value['trustworthiness_id']==0?"未知":$category_arr['QS_crm_trustworthiness'][$value['trustworthiness_id']];
		$data[$key]['dealtime'] = $value['dealtime']==0?"--":date("Y-m-d H:i:s",$value['dealtime']);
		$data[$key]['edittime'] = $value['edittime']==0?"--":date("Y-m-d H:i:s",$value['edittime']);
	}
	$top_str = "客户编号\t客户经理\t公司id\t客户名称\t行业\t地区\t规模\t地址\t联系人\t联系电话\t邮箱\t网址\tnote\t录入时间\t下次跟进时间\t上次跟进时间\t客户等级\t客户状态\t客户类型\t客户来源\t信用等级\t成交时间\t最后修改时间\t\n";
	create_excel($top_str,$data);
}
?>