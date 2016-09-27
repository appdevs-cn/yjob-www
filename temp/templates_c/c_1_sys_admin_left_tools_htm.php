<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:49 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<title>Powered by 74CMS</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$("li").first().addClass("hover");
$("li>a").click(function(){
	$("li").removeClass("hover");
	$(this).parent().addClass("hover");
	$(this).blur();
	})
})
</script>
</head>
<body>
<div  class="admin_left_box">
<ul>
		
<li ><a href="admin_clearcache.php"  target="mainFrame" >更新缓存</a></li>
<?php if ($this->_vars['QISHI']['subsite_id'] == 0): ?>
<li ><a href="admin_templates.php"  target="mainFrame" >风格模板</a></li>
<li ><a href="admin_database.php"  target="mainFrame" >数据库</a></li>
<li ><a href="admin_check_database.php"  target="mainFrame" >校验数据库</a></li>
<li ><a href="admin_check_file.php"  target="mainFrame" >校验文件</a></li>
<li ><a href="admin_locoyspider.php"  target="mainFrame"  >火车头采集</a></li>
<li ><a href="admin_pay.php"  target="mainFrame"  >支付方式</a></li>
<li ><a href="admin_crons.php"  target="mainFrame"  >计划任务</a></li>
<li ><a href="admin_mailqueue.php"  target="mainFrame"  >邮件营销</a></li>
<li ><a href="admin_smsqueue.php"  target="mainFrame" >短信营销</a></li>
<li ><a href="admin_openconnect.php"  target="mainFrame"  >第三方帐号登录 </a></li>
<li ><a href="admin_gifts.php"  target="mainFrame"  >礼品卡</a></li>
<li ><a href="admin_pms.php"  target="mainFrame"  >消息</a></li>
<li ><a href="admin_baiduxml.php"  target="mainFrame" >百度开放平台</a></li>
<li ><a href="admin_plug.php"  target="mainFrame" >模块管理</a></li>
<?php if ($this->_vars['_PLUG']['subscribe']['p_install'] == 2): ?>
<li ><a href="admin_subscribe.php"  target="mainFrame" >职位订阅</a></li>
<?php endif; ?>
<li ><a href="admin_uc.php"  target="mainFrame" >uc整合</a></li>
<li ><a href="admin_baidu_submiturl.php"  target="mainFrame" >百度链接提交</a></li>
<?php endif; ?>
</ul>
</div>
</body>
</html>