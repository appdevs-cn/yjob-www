<?php
 /*
 * 74cms ���ŷ���
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
require_once(CRM_ROOT_PATH.'include/crm_sms_fun.php');
$act = !empty($_GET['act']) ? trim($_GET['act']) : 'list';
check_permissions($_SESSION['crm_admin_purview'],"send_sms");
$smarty->assign('pageheader',"����Ӫ��");
if($act == 'list')
{
	get_token();
	require_once(QISHI_ROOT_PATH.'include/page.class.php');
	$oederbysql=" order by w.id DESC ";
	$key=isset($_GET['key'])?trim($_GET['key']):"";
	$key_type=isset($_GET['key_type'])?intval($_GET['key_type']):"";
	if ($key && $key_type>0)
	{
		
		if     ($key_type===1)$wheresql=" AND w.mobile like '%{$key}%'";
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
	$total_sql="SELECT COUNT(*) AS num FROM ".table('crm_sms')." AS w ".$wheresql;
	$page = new page(array('total'=>$db->get_total($total_sql), 'perpage'=>$perpage));
	$currenpage=$page->nowindex;
	$offset=($currenpage-1)*$perpage;
	$sms = get_smslist($offset, $perpage,$joinsql.$wheresql.$oederbysql);
	$smarty->assign('sms',$sms);
	$smarty->assign('page',$page->show(3));
	$smarty->assign('navlabel',"list");
	$smarty->display('sms/crm_sms_list.htm');
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
	$smarty->display('sms/crm_sms_send.htm');
}
elseif($act == 'sms_send')
{
	$mobile_arr=trim($_POST['mobile'])==""?array():explode(";",rtrim($_POST['mobile'],";"));
	$txt=trim($_POST['txt']);
	$url="?act=list";
	// $url=trim($_REQUEST['url']);
	if (empty($txt))
	{
	crmmsg('�������ݲ���Ϊ�գ�',0);
	}
	if (empty($mobile_arr))
	{
	crmmsg('�ֻ�����Ϊ�գ�',0);
	}
	$success=0;
	$fail=0;
	foreach($mobile_arr as $k=>$v){
		if (!preg_match("/^(13|15|18|14)\d{9}$/",$v))
		{
			// $link[0]['text'] = "������һҳ";
			// $link[0]['href'] = "{$url}";
			// crmmsg("����ʧ�ܣ�<strong>{$mobile}</strong> ���Ǳ�׼���ֻ��Ÿ�ʽ",1,$link);
			$fail++;
			
		}
		else
		{
				$r=send_sms($v,$txt);
				if ($r=="success")
				{
					$setsqlarr['mobile'] = $v;
					$setsqlarr['content'] = $txt;
					$setsqlarr['addtime'] = time();
					$setsqlarr['admin_id'] = intval($_SESSION['crm_admin_id']);
					inserttable(table("crm_sms"),$setsqlarr);
					// $link[0]['text'] = "������һҳ";
					// $link[0]['href'] = "{$url}";
					// crmmsg("���ͳɹ���",2,$link);
					$success++;
				}
				else
				{
					// $link[0]['text'] = "������һҳ";
					// $link[0]['href'] = "{$url}";
					// crmmsg("����ʧ�ܣ�����δ֪��",2,$link);
					$fail++;
				}
		}
	}
	$link[0]['text'] = "����";
	$link[0]['href'] = "{$url}";
	crmmsg("������ɣ��ɹ�����{$success}��,ʧ��{$fail}��",2,$link);
}
elseif($act == 'sms_del')
{
	check_token();
	$id=$_REQUEST['id'];
	if ($num=del_sms($id))
	{
	crmmsg("ɾ���ɹ�����ɾ��".$num."��",2);
	}
	else
	{
	crmmsg("ɾ��ʧ�ܣ�",0);
	}
}
?>