<?php
 /*
 * 74cms ajax
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../data/config.php');
require_once(dirname(__FILE__).'/include/crm_common.inc.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'total';
if($act == 'total')
{
	if ($_SESSION['crm_admin_purview']<>"all")
	{
	$wheresql="AND crm_id ='{$_SESSION['crm_admin_id']}'";
	$wheresqlw="WHERE crm_id ='{$_SESSION['crm_admin_id']}'";
	}
	else
	{
	$wheresql="";
	$wheresqlw="";
	}
	$total1=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." {$wheresqlw}");
	$total2=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client_tmp')." {$wheresqlw}");
	$settr=strtotime("+3 day");
	$total3=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." WHERE  nexttime <{$settr} {$wheresql}");
	$settr=strtotime("+7 day");
	$total4=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." WHERE  nexttime <{$settr} {$wheresql}");
	$settr=strtotime("-7 day");
	$total5=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." WHERE  addtime >{$settr} {$wheresql}");
	$settr=strtotime("-30 day");
	$total6=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." WHERE  addtime >{$settr} {$wheresql}");
	//��δ�����ͻ�
	$total7=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." WHERE  followtime=0 {$wheresql}");
	//������Ҫ�����Ŀͻ�
	$today = strtotime(date("Y-m-d"));
	$total8=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." WHERE  nexttime={$today} {$wheresql}");



	$total9=0;
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
			$total9 = $db->get_total("select count(*) AS num from ".table('crm_client')." where company_id in ($company_str) ".$wheresql);
		}
	}





	$str="[{$total1}]";
	$str.=",[{$total2}]";
	$str.=",[{$total3}]";
	$str.=",[{$total4}]";	
	$str.=",[{$total5}]";	
	$str.=",[{$total6}]";
	$str.=",[{$total7}]";
	$str.=",[{$total8}]";
	$str.=",[{$total9}]";
	exit($str);
}
?>