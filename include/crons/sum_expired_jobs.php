<?php
 /*
 * 74cms �ƻ����� �������ְλ
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
	global $_CFG;
	$time=time();
	$result1=$db->getone("select lastrun from ".table('crons')." where cronid=15");
	$lasttime=intval($result1['lastrun']);
		$result = $db->query("SELECT * FROM ".table('jobs')." where work_end >= '{$lasttime}' and work_end <'{$time}'");
		
		while($row = $db->fetch_array($result))
		{	
			$row=array_map('addslashes',$row);
			
			$zhuantai=$db->getall("select * from ".table('company_label_resume')." WHERE jobs_id='{$row['id']}' and resume_state in (1,4,8)");
			/*
				ְλ���� �൱�ڹر�
			*/
			foreach($zhuantai as $k => $v){
				$idd=$v['resume_id'];
				$sql="select * from ".table('resume')." where id='{$idd}'";
				$cc=$db->getone($sql);
				if($cc){
					if($v['resume_state']==1){
						$stt['job_number']=$v['job_number']+1;
						$stt['fly_number']=$v['fly_number'];
						$stt['cancel_sign']=$v['cancel_sign'];
					}elseif($v['resume_state']==4){
						$stt['job_number']=$v['job_number'];
						$stt['fly_number']=$v['fly_number']+1;
						$stt['cancel_sign']=$v['cancel_sign'];
					}elseif($v['resume_state']==8){
						$stt['job_number']=$v['job_number'];
						$stt['fly_number']=$v['fly_number'];
						$stt['cancel_sign']=$v['cancel_sign']+1;
					}
					$db->updatetable(table('resume'),$stt," id='".$idd."'");
				}
				
			}
			
			
		}
	$result_guoqi = $db->query("SELECT * FROM ".table('jobs')." WHERE  work_end <'{$time}'");
	while($row_guoqi = $db->fetch_array($result_guoqi))
		{	
			$row=array_map('addslashes',$row_guoqi);
		
			$db->query("Delete from ".table('jobs')." WHERE id='{$row_guoqi['id']}' LIMIT 1");
			/*
				ְλ���� �൱�ڹر�
			*/
			$row['display']=2;
			$db->inserttable(table('jobs_tmp'),$row_guoqi);
			$did=$row['id'];
			
				if (!empty($did))
				{
					
					$db->query("Delete from ".table('jobs')." WHERE id='{$did}' LIMIT 1");
					$db->query("Delete from ".table('jobs_search_hot')." WHERE id='{$did}' LIMIT 1");
					$db->query("Delete from ".table('jobs_search_key')." WHERE id='{$did}' LIMIT 1");
					$db->query("Delete from ".table('jobs_search_rtime')." WHERE id='{$did}' LIMIT 1");
					$db->query("Delete from ".table('jobs_search_scale')." WHERE id='{$did}' LIMIT 1");
					$db->query("Delete from ".table('jobs_search_stickrtime')." WHERE id='{$did}' LIMIT 1");
					$db->query("Delete from ".table('jobs_search_wage')." WHERE id='{$did}' LIMIT 1");
					
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
	$db->updatetable(table('crons'), $setsqlarr," cronid ='".intval($crons['cronid'])."'");
?>