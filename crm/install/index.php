<?php
 /*
 * 74cms ��װ��
 * ============================================================================
 * ��Ȩ����: ��ʿ���磬����������Ȩ����
 * ��վ��ַ: http://www.74cms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/
define('IN_QISHI', true);
if(!file_exists(dirname(__FILE__).'/../../data/config.php'))
{
exit('δ�ҵ���ʿ�������ļ�����ȷ�����Ѿ���װ����ʿ�˲�ϵͳ��ҵ���רҵ��');
}
require_once(dirname(__FILE__).'/../../data/config.php');
define('QISHI_PRE','qs_');
require_once(dirname(__FILE__) . '/include/common.inc.php');
require_once(QISHI_ROOT_PATH . 'include/74cms_version.php');
if(file_exists(CRM_ROOT_PATH.'data/install.lock'))
{
exit('���Ѿ���װ����ϵͳ����������°�װ����ɾ��dataĿ¼��install.lock�ļ�');
}
$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : '1';
if($act =="1")
{
	$install_smarty->assign("act", $act);
	$install_smarty->display('step1.htm');
}
if($act =="2")
{
	$system_info = array();
	$system_info['version'] = QISHI_VERSION;
	$system_info['os'] = PHP_OS;
	$system_info['ip'] = $_SERVER['SERVER_ADDR'];
	$system_info['web_server'] = $_SERVER['SERVER_SOFTWARE'];
	$system_info['php_ver'] = PHP_VERSION;
	$system_info['max_filesize'] = ini_get('upload_max_filesize');
	if (PHP_VERSION<5.0) exit("��װʧ�ܣ���ʹ��PHP5.0�����ϰ汾");
	$dir_check = check_dirs($need_check_dirs);
	$install_smarty->assign("dir_check", $dir_check);
	$install_smarty->assign("system_info", $system_info);
	$install_smarty->assign("act", $act);
	$install_smarty->display('step2.htm');
}
if($act =="3")
{
	$install_smarty->assign("act", $act);
	$install_smarty->display('step3.htm');
}
if($act =="4")
{
 	$admin_name = isset($_POST['admin_name']) ? trim($_POST['admin_name']) : '';
    $admin_pwd = isset($_POST['admin_pwd']) ? trim($_POST['admin_pwd']) : '';
    $admin_pwd1 = isset($_POST['admin_pwd1']) ? trim($_POST['admin_pwd1']) : '';
    $admin_email = isset($_POST['admin_email']) ? trim($_POST['admin_email']) : '';
	if( $admin_name == ''|| $admin_pwd == '' || $admin_pwd1 == '' || $admin_email == '')
	{
		install_showmsg('����д����Ϣ����������˶�');
	}
	if($admin_pwd != $admin_pwd1)
	{
		install_showmsg('��������������벻һ��');
	}
	if (!preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$admin_email))
	{
		install_showmsg('���������ʽ����');
	}
  	if(!$fp = @fopen(dirname(__FILE__).'/sql-structure.sql','rb'))
	{
		install_showmsg('���ļ�sql-structure.sql���������ļ��Ƿ����');
	}
	$query = '';
	while(!feof($fp))
    {
		$line = rtrim(fgets($fp,1024)); 
		if(preg_match('/;$/',$line)) 
		{
			$query .= $line."\n";
			$query = str_replace(QISHI_PRE,$pre,$query);

				$sql=str_replace("TYPE=MyISAM", "ENGINE=MyISAM  DEFAULT CHARSET=".QISHI_DBCHARSET,  $query);
				$db->query($sql);
	
			$query='';
		 }
		 else if(!ereg('/^(//|--)/',$line))
		 {
		 	$query .= $line;
		 }
	}
	@fclose($fp);	
	$query = '';
	if(!$fp = @fopen(dirname(__FILE__).'/sql-data.sql','rb'))
	{
		install_showmsg('���ļ�sql-data.sql���������ļ��Ƿ����');
	}
	while(!feof($fp))
	{
		 $line = rtrim(fgets($fp,1024));
		 if(ereg(";$",$line))
		 {
		 	$query .= $line;
			$query = str_replace('qs_',$pre,$query);
			$db->query($query);
			$query='';
		 }
		 else if(!ereg("^(//|--)",$line))
		 {
			$query .= $line;
		 }
	}
	@fclose($fp);
	$Field=$db->getone("SHOW COLUMNS FROM `{$pre}company_profile` WHERE Field = 'crm_id' ");
	if (empty($Field))
	{
	$db->query("ALTER TABLE `{$pre}company_profile` ADD `crm_id` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0'");
	$db->query("ALTER TABLE `{$pre}company_profile` ADD INDEX ( `crm_id` )");
	}	
	$pwd_hash=randstr();
	$admin_md5pwd=md5($admin_pwd.$pwd_hash.$QS_pwdhash);
	$db->query("INSERT INTO `{$pre}crm_admin` (admin_id,admin_name, email, pwd,pwd_hash, purview, rank,add_time, last_login_time, last_login_ip) VALUES (null, '$admin_name', '$admin_email', '$admin_md5pwd', '$pwd_hash', 'all','��������Ա', '$timestamp', '$timestamp', '')");
	//���ɾ�̬����	
	refresh_crm_category_cache();
			;
	if(is_writable(CRM_ROOT_PATH.'data/'))
	{
		$fp = @fopen(CRM_ROOT_PATH.'data/install.lock', 'wb+');
		fwrite($fp, 'OK');
		fclose($fp);
	}
	$install_smarty->assign("act", $act);
	$install_smarty->assign("domain", $site_domain);
	$install_smarty->assign("domaindir", $site_domain.$site_dir);
	$install_smarty->assign("v", QISHI_VERSION);
	$install_smarty->assign("t", 2);
	$install_smarty->assign("email", $admin_email);
	$install_smarty->display('step5.htm');
}
?>