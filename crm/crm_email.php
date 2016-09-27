<?php
 /*
 * 74cms �ʼ�����
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
require_once(CRM_ROOT_PATH.'include/crm_email_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
$smarty->assign('pageheader',"�ʼ�Ӫ��");
check_permissions($_SESSION['crm_admin_purview'],"send_email");
if($act == 'list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order by w.id DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql=" AND w.email like '%{$key}%'";
		$oederbysql="";
	}
	if (!empty($_GET['settr']))
	{
		$settr=strtotime("-".intval($_GET['settr'])." day");
		$wheresql.=" AND w.addtime> ".$settr;
	}
	
	if (!empty($wheresql))
	{
	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	}
	$joinsql=" LEFT JOIN ".table('crm_admin')." AS a ON w.admin_id=a.admin_id ";
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_sendemail')." AS w ".$wheresql;
	$page = new page(array('total'=>$db->get_total($total_sql), 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$sendemail = get_sendemail($offset, $perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('sendemail',$sendemail);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('navlabel',"list");
	$smarty->display('mail/crm_sendemail_list.htm');
}
elseif($act == 'send')
{
	get_token();
	//$smarty->assign('navlabel','testing');
	$url=trim($_REQUEST['url']);
	if (empty($url))
	{
	$url="?act=send";
	}
	$mycontacts = $db->getall("select * from ".table('crm_my_contacts')." where crm_id=".$_SESSION['crm_admin_id']);
	$smarty->assign('mycontacts',$mycontacts);
	$smarty->assign('url',$url);
	$smarty->assign('navlabel',"send");
	$smarty->display('mail/crm_mail_send.htm');
}
elseif($act == 'email_send')
{
	$email_arr=trim($_POST['email'])==""?array():explode(";",rtrim($_POST['email'],";"));
	$subject=trim($_POST['subject']);
	$body=trim($_POST['body']);
	$url="?act=list";
	// $url=trim($_REQUEST['url']);
	if (empty($subject) || empty($body))
	{
	crmmsg('��������ݲ���Ϊ�գ�',0);
	}
	if (empty($email_arr))
	{
	crmmsg('�ռ��˲���Ϊ�գ�',0);
	}
	$success=0;
	$fail=0;
	foreach($email_arr as $k=>$v){
		if (!preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/",$v))
		{
			// $link[0]['text'] = "������һҳ";
			// crmmsg("����ʧ�ܣ�<strong>".$v."</strong> ��ʽ����ȷ",1,$link);
			$fail++;
			
		}
		else
		{
				if (smtp_mail($v,$subject,$body))
				{
					$setsqlarr['email'] = $v;
					$setsqlarr['title'] = $subject;
					$setsqlarr['content'] = $body;
					$setsqlarr['addtime'] = time();
					$setsqlarr['admin_id'] = intval($_SESSION['crm_admin_id']);
					inserttable(table("crm_sendemail"),$setsqlarr);
					$success++;
				}
				else
				{
					$fail++;
				}
		}
	}
	$link[0]['text'] = "����";
	$link[0]['href'] = "{$url}";
	crmmsg("������ɣ��ɹ�����{$success}��,ʧ��{$fail}��",2,$link);
}
elseif($act == 'sendemail_del')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_sendemail($id))
	{
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
	}
}
?>