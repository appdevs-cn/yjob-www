<?php
 /*
 * 74cms FLASH报表
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
function checkStr($str,$target)
{
   $tmpArr = explode($str,$target);
   //print_r($tmpArr);
   if(count($tmpArr)>1)return true;
   else return false;
}
    
function client30day()
{
	global $db;
	$xml="client30day.xml";
	if(checkStr("chart_add_all",$_SESSION['crm_admin_purview'])||$_SESSION['crm_admin_purview']=="all"){
		$wheresql = "";
	}else{
		$wheresql = " and crm_id=".$_SESSION['crm_admin_id'];
	}
	

		$datelist=array();
		for ($i = 30; $i>=1; $i--)
		{
		$day=date("m/d",strtotime("-{$i} day"));
		$datelist[$day]=0;
		}
		$result = $db->query("SELECT * FROM ".table('crm_client')." WHERE addtime>".strtotime("-30 day").$wheresql);
		while($row = $db->fetch_array($result))
		{
			$day=date("m/d",$row['addtime']);
			$datelist[$day]++;
		}
		write_xmlclient30day($xml,$datelist);	 
}
function deal30day()
{
	global $db;
	$xml="deal30day.xml";
	if(checkStr("chart_deal_all",$_SESSION['crm_admin_purview'])||$_SESSION['crm_admin_purview']=="all"){
		$wheresql = "";
	}else{
		$wheresql = " and crm_id=".$_SESSION['crm_admin_id'];
	}
		$datelist=array();
		for ($i = 30; $i>=1; $i--)
		{
		$day=date("m/d",strtotime("-{$i} day"));
		$datelist[$day]=0;
		}
		$result = $db->query("SELECT * FROM ".table('crm_client')." WHERE dealtime>".strtotime("-30 day")." and status_id=3".$wheresql);
		while($row = $db->fetch_array($result))
		{
			$day=date("m/d",$row['dealtime']);
			$datelist[$day]++;
		}
		write_xmlclient30day($xml,$datelist);	 
}
function lastyear_client30day($start,$end)
{
	global $db;
	$xml="lastyear_client30day.xml";
	if(checkStr("chart_lastyear_add_all",$_SESSION['crm_admin_purview'])||$_SESSION['crm_admin_purview']=="all"){
		$wheresql = "";
	}else{
		$wheresql = " and crm_id=".$_SESSION['crm_admin_id'];
	}
		$datelist=array();
		$datelist1=array();
		for ($i = 30; $i>=1; $i--)
		{
		$day=date("m/d",strtotime("-{$i} day"));
		$datelist[$day]=0;
		}
		$result = $db->query("SELECT * FROM ".table('crm_client')." WHERE addtime>".strtotime("-30 day").$wheresql);
		while($row = $db->fetch_array($result))
		{
			$day=date("m/d",$row['addtime']);
			$datelist[$day]++;
		}
		for ($i = 30; $i>=1; $i--)
		{
		$day=date("m/d",strtotime("-{$i} day"));
		$datelist1[$day]=0;
		}
		$result1 = $db->query("SELECT * FROM ".table('crm_client')." WHERE addtime>".$start." and addtime<".$end);
		while($row = $db->fetch_array($result1))
		{
			$day=date("m/d",$row['addtime']);
			$datelist1[$day]++;
		}
		write_lastyear_xmlclient30day($xml,$datelist,$datelist1);	 
}
function lastyear_deal30day($start,$end)
{
	global $db;
	$xml="lastyear_deal30day.xml";
	if(checkStr("chart_lastyear_deal_all",$_SESSION['crm_admin_purview'])||$_SESSION['crm_admin_purview']=="all"){
		$wheresql = "";
	}else{
		$wheresql = " and crm_id=".$_SESSION['crm_admin_id'];
	}
		$datelist=array();
		$datelist1=array();
		for ($i = 30; $i>=1; $i--)
		{
		$day=date("m/d",strtotime("-{$i} day"));
		$datelist[$day]=0;
		}
		$result = $db->query("SELECT * FROM ".table('crm_client')." WHERE dealtime>".strtotime("-30 day")." and status_id=3".$wheresql);
		while($row = $db->fetch_array($result))
		{
			$day=date("m/d",$row['dealtime']);
			$datelist[$day]++;
		}
		for ($i = 30; $i>=1; $i--)
		{
		$day=date("m/d",strtotime("-{$i} day"));
		$datelist1[$day]=0;
		}
		$result1 = $db->query("SELECT * FROM ".table('crm_client')." WHERE dealtime>".$start." and status_id=3 and dealtime<".$end.$wheresql);
		while($row = $db->fetch_array($result1))
		{
			$day=date("m/d",$row['dealtime']);
			$datelist1[$day]++;
		}
		write_lastyear_xmlclient30day($xml,$datelist,$datelist1);	 
}
function clientstatistical()
{
	global $db;
	$xml="clientstatistical.xml";
	if(checkStr("allclientstatistical",$_SESSION['crm_admin_purview'])||$_SESSION['crm_admin_purview']=="all"){
		$wheresql = "";
	}else{
		$wheresql = " where crm_id=".$_SESSION['crm_admin_id'];
	}
	$total1=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." {$wheresql}");
	$total2=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client_tmp')." {$wheresql}");
	$datelist=array('有效客户'=>$total1,'无效客户'=>$total2);
	write_client($xml,$datelist);	 
}
function client_status()
{
	global $db;
	$xml="client_status.xml";
	if(checkStr("allclient_status",$_SESSION['crm_admin_purview'])||$_SESSION['crm_admin_purview']=="all"){
		$wheresql = "";
	}else{
		$wheresql = " and crm_id=".$_SESSION['crm_admin_id'];
	}
	
	$sql = "select * from ".table('crm_category')." WHERE c_alias='QS_crm_status'  ORDER BY c_order DESC,c_id ASC";
	$result = $db->query($sql);
	while($row = $db->fetch_array($result))
	{
	$datelist[$row['c_name']]=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." WHERE status_id='{$row['c_id']}' {$wheresql}");
	}
	$datelist['未知']=$db->get_total("SELECT COUNT(*) AS num FROM ".table('crm_client')." WHERE status_id='0' {$wheresql}");
	write_client($xml,$datelist);	 
}
function write_client($xml,$array)
{
	$content = '<chart ShowAboutMenuItem="0"  numberPrefix=" "  exportEnabled="1" exportShowMenuItem="1" exportAtClient="1" exportHandler="fcExporter1" baseFont="宋体"  baseFontSize="14" bgColor="#FFFFFF" shadowAlpha="100" canvasBgColor="#FFFFFF"  >\n';
	foreach($array as $key => $value)
	{
	$content .= "<set name='{$key}' value='{$value}' /> \n";
	}
	$content .= "</chart>\n";
	$xmlname=CRM_ROOT_PATH."data/statement/{$xml}";
	xml_put_contents($xmlname,$content);
}
function  write_xmlclient30day($xml,$array)
{
	$content = "<graph divlinecolor='FEDD69' numdivlines='4' showAreaBorder='1' areaBorderColor='cccccc' numberPrefix='' showNames='1' numVDivLines='29' vDivLineAlpha='30' formatNumberScale='0' rotateNames='1'  decimalPrecision='0' bgColor='' yAxisName=''  showAlternateVGridColor='0' canvasBorderThickness='0' decimalPrecision='0' areaBorderColor='cccccc'>
>\n";
	$content .= "<categories fontSize='9'>\n";
	foreach($array as $key => $value)
	{
	$content .= "<category name='{$key}'/>\n";
	}
	$content .= "</categories>\n";
	$content .= "<dataset  color='00CC00' showValues='0' areaAlpha='30' showAreaBorder='1' areaBorderThickness='1' areaBorderColor='006600'>\n";
	foreach($array as $key => $value)
	{
	$content .= "<set value='{$value}' />\n";
	}
	$content .= "</dataset>\n";
	$content .= "</graph>\n";
	$xmlname=CRM_ROOT_PATH."data/statement/{$xml}";
	xml_put_contents($xmlname, $content);	
}
function  write_lastyear_xmlclient30day($xml,$array,$array1)
{
	$content = "<graph divlinecolor='FEDD69' numdivlines='4' showAreaBorder='1' areaBorderColor='cccccc' numberPrefix='' showNames='1' numVDivLines='29' vDivLineAlpha='30' formatNumberScale='0' rotateNames='1'  decimalPrecision='0' bgColor='' yAxisName=''  showAlternateVGridColor='0' canvasBorderThickness='0' decimalPrecision='0' areaBorderColor='cccccc'>
>\n";
	$content .= "<categories fontSize='9'>\n";
	foreach($array as $key => $value)
	{
	$content .= "<category name='{$key}'/>\n";
	}
	$content .= "</categories>\n";
	$content .= "<dataset  color='00CC00' showValues='0' areaAlpha='30' showAreaBorder='1' areaBorderThickness='1' areaBorderColor='006600'>\n";
	foreach($array as $key => $value)
	{
	$content .= "<set value='{$value}' />\n";
	}
	$content .= "</dataset>\n";

	$content .= "<dataset  color='CC0000' showValues='0' areaAlpha='30' showAreaBorder='1' areaBorderThickness='1' areaBorderColor='006600'>\n";
	foreach($array1 as $key => $value)
	{
	$content .= "<set value='{$value}' />\n";
	}
	$content .= "</dataset>\n";

	$content .= "</graph>\n";
	$xmlname=CRM_ROOT_PATH."data/statement/{$xml}";
	xml_put_contents($xmlname, $content);	
}
function xml_put_contents($xmlname, $content)
{
	if (!file_put_contents($xmlname, $content, LOCK_EX))
	{
		$fp = @fopen($xmlname, 'wb+');
		if (!$fp)
		{
			exit('生xml文件失败，请设置目录“data/statement”的读写权限');
		}
		if (!@fwrite($fp, trim($content)))
		{
			exit('生xml文件失败，请设置目录“data/statement”的读写权限');
		}
		@fclose($fp);
	}
}
?>