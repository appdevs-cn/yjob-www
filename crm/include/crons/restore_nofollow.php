<?php
 /*
 * 74cms �ƻ����� ÿ������ͳ��
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
ignore_user_abort(true);
set_time_limit(180);
	global $_CFG;
	$user_config = $db->getone("select config_value from ".table('crm_users_config')." where id=2");
	if(intval($user_config['config_value'])!=0){
		$focus_date = strtotime("-{$user_config['config_value']} days");
		$wheresql = " where ((followtime=0 and addtime<{$focus_date}) or (followtime!=0 and followtime<{$focus_date})) and company_id!=0 and status_id!=3";
		$sql1 = "select id,company_id from ".table('crm_client').$wheresql;
		$result1 = $db->getall($sql1);
		$sql2 = "select id,company_id from ".table('crm_client_tmp').$wheresql;
		$result2 = $db->getall($sql2);
		if(!empty($result1)){
			foreach ($result1 as $key => $value) {
				$id_str .= $value['id'].",";
				$company_id_str .= $value['company_id'].",";
			}
			$id_str = rtrim($id_str,",");
			$company_id_str = rtrim($company_id_str,",");
			$db->query("update ".table('company_profile')." set crm_id=0 where id in ($company_id_str)");
			$db->query("delete from ".table('crm_client')." where id in ($id_str)");
		}
		if(!empty($result2)){
			foreach ($result2 as $key => $value) {
				$id_str1 .= $value['id'].",";
				$company_id_str1 .= $value['company_id'].",";
			}
			$id_str1 = rtrim($id_str1,",");
			$company_id_str1 = rtrim($company_id_str1,",");
			$db->query("update ".table('company_profile')." set crm_id=0 where id in ($company_id_str1)");
			$db->query("delete from ".table('crm_client_tmp')." where id in ($id_str1)");
		}
	}
	
	
	//��������ʱ���
	if ($crons['weekday']>=0)
	{
	$weekday=array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$nextrun=strtotime("Next ".$weekday[$crons['weekday']]);
	}
	elseif ($crons['day']>0)
	{
	$nextrun=strtotime('+1 months'); 
	$nextrun=mktime(0,0,0,date("m",$nextrun),$crons['day'],date("Y",$nextrun));
	}
	else
	{
	$nextrun=time();
	}
	if ($crons['hour']>=0)
	{
	$nextrun=strtotime('+1 days',$nextrun); 
	$nextrun=mktime($crons['hour'],0,0,date("m",$nextrun),date("d",$nextrun),date("Y",$nextrun));
	}
	if (intval($crons['minute'])>0)
	{
	$nextrun=strtotime('+1 hours',$nextrun); 
	$nextrun=mktime(date("H",$nextrun),$crons['minute'],0,date("m",$nextrun),date("d",$nextrun),date("Y",$nextrun));
	}
	$setsqlarr['nextrun']=$nextrun;
	$setsqlarr['lastrun']=time();
	updatetable(table('crm_crons'), $setsqlarr," cronid ='".intval($crons['cronid'])."'");
?>