<?php
 /*
 * 74cms 管理中心共用函数
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
function admin_addslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('admin_addslashes_deep', $value) : addslashes($value);
    }
}
function deep_stripslashes($str)
 {
 	if(is_array($str)){
 		foreach($str as $key => $val){
 			$str[$key] = deep_stripslashes($val);
 		}
 	} else {
 		$str = stripslashes($str);
 	}
 	return $str;
 }
function crmmsg($msg_detail, $msg_type = 0, $links = array(), $auto_redirect = true,$seconds=3)
{
	global $smarty;
    if (count($links) == 0)
    {
        $links[0]['text'] = '返回上一页';
        $links[0]['href'] = 'javascript:history.go(-1)';
    }
   $smarty->assign('ur_here',     '系统提示');
   $smarty->assign('msg_detail',  $msg_detail);
   $smarty->assign('msg_type',    $msg_type);
   $smarty->assign('links',       $links);
   $smarty->assign('default_url', $links[0]['href']);
   $smarty->assign('auto_redirect', $auto_redirect);
   $smarty->assign('seconds', $seconds);
   $smarty->display('sys/crm_showmsg.htm');
	exit();
}

function get_token()
{
	global $_CFG;
	if ($_CFG["open_csrf"]=="1")
	{
		global $smarty;
		if (!empty($_SESSION['token']))
		{
		unset($_SESSION['token']);
		}
		$hash = md5(uniqid(rand(), true));
		$n = mt_rand(1, 24);
		$token = substr($hash, $n, 8);
		$page=!empty($_SERVER['PHP_SELF'])?md5($_SERVER['PHP_SELF']):'token';
		$_SESSION['token'][$page] = $token;
		$smarty->assign('inputtoken', "<input type=\"hidden\"  name=\"hiddentoken\" value=\"{$_SESSION['token'][$page]}\" />");
		$smarty->assign('urltoken', "hiddentoken={$_SESSION['token'][$page]}");
	}
}
function check_token()
{
	global $_CFG;
	if ($_CFG["open_csrf"]=="1")
	{
		if (empty($_SESSION['token']))
		{
		unset($_SESSION['token']);
		global $smarty;
		$smarty->display('sys/crm_csrf.htm');
		exit();
		}
		else
		{
			$page=!empty($_SERVER['PHP_SELF'])?md5($_SERVER['PHP_SELF']):'token';
			$hiddentoken=!empty($_POST['hiddentoken'])?$_POST['hiddentoken']:$_GET['hiddentoken'];
			if ($_SESSION['token'][$page]!=$hiddentoken)
			{
			unset($_SESSION['token'],$hiddentoken);
			global $smarty;
			$smarty->display('sys/crm_csrf.htm');
			exit();
			}
		}
	unset($_SESSION['token'],$hiddentoken);
	}
}
function refresh_cache($cachename)
{
	global $db;
	$config_arr = array();
	$cache_file_path =QISHI_ROOT_PATH. "data/cache_".$cachename.".php";
	$sql = "SELECT * FROM ".table($cachename);
	$arr = $db->getall($sql);
		foreach($arr as $key=> $val)
		{
		$config_arr[$val['name']] = $val['value'];
		}
	write_static_cache($cache_file_path,$config_arr);
}
function refresh_points_rule_cache()
{
	global $db;
	$cache_file_path =QISHI_ROOT_PATH. "data/cache_points_rule.php";
		$sql = "SELECT * FROM ".table('members_points_rule');
		$arr = $db->getall($sql);
			foreach($arr as $key=> $val)
			{
			$config_arr[$val['name']] =array("type"=>$val['operation'],"value"=>$val['value']);
			}
		write_static_cache($cache_file_path,$config_arr);
}

function write_static_cache($cache_file_path, $config_arr)
{
	$content = "<?php\r\n";
	$content .= "\$data = " . var_export($config_arr, true) . ";\r\n";
	$content .= "?>";
	if (!file_put_contents($cache_file_path, $content, LOCK_EX))
	{
		$fp = @fopen($cache_file_path, 'wb+');
		if (!$fp)
		{
			exit('生成缓存文件失败');
		}
		if (!@fwrite($fp, trim($content)))
		{
			exit('生成缓存文件失败');
		}
		@fclose($fp);
	}
}
function refresh_crm_category_cache()
{
	global $db;
	$cache_file_path =QISHI_ROOT_PATH. "data/cache_crm_category.php";
	$sql = "SELECT * FROM ".table('crm_category')."  ORDER BY c_order DESC,c_id ASC";
	$result = $db->query($sql);
		while($row = $db->fetch_array($result))
		{
			$catarr[$row['c_id']] =array("id"=>$row['c_id'],"parentid"=>$row['c_parentid'],"categoryname"=>$row['c_name']);
		}
		write_static_cache($cache_file_path,$catarr);
}
function write_log($str, $user,$log_type=1)
{
 	global $db, $timestamp,$online_ip;
 	$sql = "INSERT INTO ".table('crm_admin_log')." (log_id, admin_name, add_time, log_value,log_ip,log_type) VALUES ('', '$user', '$timestamp', '$str','$online_ip','".intval($log_type)."')"; 
	return $db->query($sql);
}
function check_admin($name,$pwd)
{
 	global $db,$QS_pwdhash;
	$admin=get_admin_one($name);
	$md5_pwd=md5($pwd.$admin['pwd_hash'].$QS_pwdhash);
 	$row = $db->getone("SELECT COUNT(*) AS num FROM ".table('crm_admin')." WHERE admin_name='{$name}' and pwd ='".$md5_pwd."' ");
 	if($row['num'] > 0){
 		return true;
 	}else{
 		return false;
 	}
}
function update_admin_info($admin_name,$refresh = true)
{
 	global $timestamp, $online_ip, $db;
	$admin = $db->getone("SELECT admin_id, admin_name, purview FROM ".table('crm_admin')." WHERE admin_name = '$admin_name'");
 	$_SESSION['crm_admin_id'] = $admin['admin_id'];
 	$_SESSION['crm_admin_name'] = $admin['admin_name'];
 	$_SESSION['crm_admin_purview'] = $admin['purview'];
	if ($refresh == true)
	{
		$last_login_time = $timestamp;
		$last_login_ip = $online_ip;
		$sql = "UPDATE ".table('crm_admin')." SET last_login_time = '".$last_login_time."', last_login_ip = '".$last_login_ip."' WHERE admin_id='".$_SESSION['crm_admin_id']."'";
		$db->query($sql);
		del_log($admin['admin_name'],90);
	}
 }
function check_cookie($user_name, $pwd)
 {
 	global $db,$QS_pwdhash;
 	$sql = "SELECT * FROM ".table('crm_admin')." WHERE admin_name='".$user_name."' ";
 	$user = $db->getone($sql);
 	if(md5($user['admin_name'].$user['pwd'].$user['pwd_hash'].$QS_pwdhash) == $pwd)
	{
	return true;
	}
	return false;
 }
function get_admin_one($username){
	global $db;
	$sql = "select * from ".table('crm_admin')." where admin_name = '".$username."' LIMIT 1";
	return $db->getone($sql);
}

function del_log($admin_name,$settr=30)
{
global $db;
$settr_val=strtotime("-".$settr." day");
if (!$db->query("Delete from ".table('crm_admin_log')." WHERE admin_name='".$admin_name."' AND  add_time<".$settr_val." ")) return false;
return true;
}
function check_permissions($purview,$str)
{
	 if ($purview=="all")
	 {
	 return true;
	 }
	 else
	 {
	 $purview_arr=explode(',',$purview);
	 }
	 	if (in_array($str,$purview_arr))
		{
		return true;
		}
		else
		{
		permissions_insufficient();
		}
}
function permissions_insufficient()
{
	global $smarty;
    $smarty->display('sys/crm_sotp.htm');
	exit();
}
function html2text($str){
	$str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
	$alltext = "";
	$start = 1;
	for($i=0;$i<strlen($str);$i++)
	{
		if($start==0 && $str[$i]==">")
		{
			$start = 1;
		}
		else if($start==1)
		{
			if($str[$i]=="<")
			{
				$start = 0;
				$alltext .= " ";
			}
			else if(ord($str[$i])>31)
			{
				$alltext .= $str[$i];
			}
		}
	}
	$alltext = str_replace("　"," ",$alltext);
	$alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
	$alltext = preg_replace("/[ ]+/s"," ",$alltext);
	return $alltext;
}
function getsubdirs($dir) {
        $subdirs = array();
        if(!$dh = opendir($dir)) return $subdirs;
        while ($f = readdir($dh)) {
                if($f =='.' || $f =='..') continue;
                $path = $dir.'/'.$f;  //如果只要子目录名, path = $f;
				$subdir=$f;
                if(is_dir($path)) {
                        $subdirs[] = $subdir;
                }
        }
		closedir($dh);
        return $subdirs;
}
function execution_crm_crons()
{
	global $db;
	$crons=$db->getone("select * from ".table('crm_crons')." WHERE (nextrun<".time()." OR nextrun=0) AND available=1 LIMIT 1  ");
	if (!empty($crons))
	{
		require_once(CRM_ROOT_PATH."include/crons/".$crons['filename']);
	}
}

function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
	global $db;
	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$state = $db->query($method." INTO $tablename ($insertkeysql) VALUES ($insertvaluesql)", $silent?'SILENT':'');
	if($returnid && !$replace) {
		return $db->insert_id();
	}else {
	    return $state;
	} 
}
function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) {
	global $db;
	$setsql = $comma = '';
	foreach ($setsqlarr as $set_key => $set_value) {
		if(is_array($set_value)) {
			$setsql .= $comma.'`'.$set_key.'`'.'='.$set_value[0];
		} else {
			$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		}
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)) {
		$where = '1';
	} elseif(is_array($wheresqlarr)) {
		foreach ($wheresqlarr as $key => $value) {
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	} else {
		$where = $wheresqlarr;
	}
	return $db->query("UPDATE ".($tablename)." SET ".$setsql." WHERE ".$where, $silent?"SILENT":"");
}
function create_excel($top_str,$data){
	header("Content-Type: application/vnd.ms-execl");
	header("Content-Disposition: attachment; filename=myExcel.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $top_str;
	foreach ($data as $k => $v) {
		foreach ($v as $k1 => $v1) {
			echo $v1;
			echo ($k1+1)<count($v)?"\t":"";
		}
		echo "\t\n";
	}
}
?>