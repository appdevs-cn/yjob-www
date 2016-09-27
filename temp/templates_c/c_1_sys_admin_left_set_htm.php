<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 09:48 CST */ ?>
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
<div class="admin_left_box">
<ul>
<?php if ($this->_vars['QISHI']['subsite_id'] == 0): ?>
<li><a href="admin_set.php"  target="mainFrame"  >网站配置</a></li>
<li><a href="admin_set_com.php"  target="mainFrame"  >企业设置 </a></li>
<li><a href="admin_set_per.php"  target="mainFrame"  >个人设置 </a></li>
<?php if ($this->_vars['_PLUG']['hunter']['p_install'] == 2): ?>
<li><a href="admin_set_hunter.php"  target="mainFrame"  >猎头设置 </a></li>
<?php endif; ?>
<?php if ($this->_vars['_PLUG']['train']['p_install'] == 2): ?>
<li><a href="admin_set_train.php"  target="mainFrame"  >培训设置 </a></li>
<?php endif; ?>
<?php if ($this->_vars['_PLUG']['simple']['p_install'] == 2): ?>
<li><a href="admin_set_simple.php"  target="mainFrame"  >微商圈 </a></li>
<?php endif; ?>
<li><a href="admin_mail.php" target="mainFrame" >邮件设置</a></li>
<li><a href="admin_sms.php" target="mainFrame" >短信设置</a></li>
<li><a href="admin_safety.php" target="mainFrame"  >安全设置</a></li>
<li><a href="admin_set.php?act=search"  target="mainFrame">搜索设置 </a></li>
<li><a href="admin_page.php" target="mainFrame"   >页面管理</a></li>
<li><a href="admin_nav.php" target="mainFrame"  >导航设置</a></li>
<li><a href="admin_category.php" target="mainFrame" >分类管理</a></li>
<li><a href="admin_subsite.php" target="mainFrame" >分站管理</a></li>
<li><a href="admin_hotword.php" target="mainFrame" >热门关键字</a></li>
<li><a href="admin_content_key_link.php" target="mainFrame" >内容聚合</a></li>
<?php endif; ?>
<li><a href="admin_memberslog.php" target="mainFrame" >会员日志</a></li>
<li><a href="admin_users.php" target="mainFrame">网站管理员</a></li>
<li><a href="admin_syslog.php" target="mainFrame">系统错误日志</a></li>
<li><a href="admin_login.php?act=logout"  target="_top"  >退出登录</a></li>
</ul>
</div>
</body>
</html>