<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-21 14:14 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<title> Powered by 74CMS</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(".admin_top_nav>a").click(function(){
	$(".admin_top_nav>a").removeClass("select");
	$(this).addClass("select");
	$(this).blur();
	window.parent.frames["leftFrame"].location.href =  "admin_left.php?act="+$(this).attr("id");
	})
})
</script>
</head>
<body>
<div class="admin_top_bg">
    <table width="1400" height="70" border="0" cellpadding="0" cellspacing="0">
        <tr><td width="200" rowspan="2" align="right" valign="middle" ><div align="center"><img src="images/logo_in.png" width="160" height="25" /></div>
		</td>
          <td height="39" align="right" valign="middle" class="link_w">
		 <?php if ($this->_vars['QISHI']['subsite_id'] != "0"): ?>
		  <span style="color:#FFFF00">[<?php echo $this->_vars['QISHI']['subsite_districtname']; ?>
站管理平台]</span>&nbsp;&nbsp;&nbsp;&nbsp;  
		  <?php endif; ?>
		  欢迎<?php echo $this->_vars['admin_rank']; ?>
：<strong style="color: #99FF00"><?php echo $this->_vars['admin_name']; ?>
</strong>&nbsp; 登录&nbsp;&nbsp;&nbsp;&nbsp;  <a href="admin_login.php?act=logout" target="_top">[退出]</a>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <a href="../" target="_blank">网站首页</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.74cms.com/bbs/" target="_blank">官方论坛</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.74cms.com/" target="_blank">官方网站</a> </td>
        </tr>
        <tr>
          <td height="31" valign="bottom" class="admin_top_nav">
		  <a href="admin_index.php?act=main" class="select" target="mainFrame" id="index">首页</a>
		  <a href="admin_company.php" target="mainFrame" id="company">企业</a>
		  <a href="admin_personal.php?act=list" target="mainFrame" id="personal">个人</a>
		  <?php if ($this->_vars['_PLUG']['hunter']['p_install'] == 2): ?>
		  <a href="admin_hunter.php" target="mainFrame" id="hunter">猎头</a>
		  <?php endif; ?>
		  <?php if ($this->_vars['_PLUG']['train']['p_install'] == 2): ?>
		  <a href="admin_train.php?act=list" target="mainFrame" id="train">培训</a>
		  <?php endif; ?>
		  <?php if ($this->_vars['_PLUG']['simple']['p_install'] == 2): ?>
		  <a href="admin_simple.php" target="mainFrame" id="simple">微商圈</a>
		  <?php endif; ?>
		  <?php if ($this->_vars['_PLUG']['jobfair']['p_install'] == 2): ?>
		  <a href="admin_jobfair.php" target="mainFrame" id="jobfair">招聘会</a>
		  <?php endif; ?>
		  <?php if ($this->_vars['QISHI']['subsite_id'] == 0): ?>
		  <a href="admin_campus.php" target="mainFrame" id="campus">校园招聘</a>
		  <a href="admin_evaluation.php" target="mainFrame" id="evaluation">人才测评</a>
		  <a href="admin_shop.php" target="mainFrame" id="shop">积分商城</a>
		  <a href="admin_app.php" target="mainFrame" id="mobile">移动端</a>
		  <?php endif; ?>
		  <a href="admin_article.php" target="mainFrame" id="article">内容</a>
		  <a href="admin_ad.php?act=list" target="mainFrame" id="ad">广告</a>
		  <a href="admin_clearcache.php" target="mainFrame" id="tools">工具</a>
		  <a href="<?php if ($this->_vars['QISHI']['subsite_id'] > 0): ?>admin_memberslog.php<?php else: ?>admin_set.php<?php endif; ?>" target="mainFrame" id="set">系统</a>
		  <div class="clear"></div>
		   </td>
        </tr>
      </table>
	  </div>
</body>
</html>
