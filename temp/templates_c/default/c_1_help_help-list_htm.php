<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_help_list.php'); $this->register_function("qishi_help_list", "tpl_function_qishi_help_list",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.escape.php'); $this->register_modifier("escape", "tpl_modifier_escape",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.cat.php'); $this->register_modifier("cat", "tpl_modifier_cat",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_help_category.php'); $this->register_function("qishi_help_category", "tpl_function_qishi_help_category",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 17:33 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php echo tpl_function_qishi_help_category(array('set' => "�б���:cat,���Ƴ���:10,С��:GET[id]"), $this);?>
<title><?php echo $this->_vars['cat']['categoryname']; ?>
- ���� - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
<meta name="description" content="<?php echo $this->_vars['page']['description']; ?>
">
<meta name="keywords" content="<?php echo $this->_vars['page']['keywords']; ?>
">
<meta name="author" content="��ʿCMS" />
<meta name="copyright" content="74cms.com" />
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/help.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.js" type='text/javascript' ></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".nav_son").first().css("display","block");
	$(".help_nav").first().removeClass("t");
	$(".help_nav").first().addClass("s");
	$(".help_nav").click(function(){
		$(".help_nav").removeClass("s");
		$(".help_nav").addClass("t");
		$(".nav_son").slideUp("fast");
		$(this).removeClass("t");
		$(this).addClass("s");
		$(this).next(".nav_son").slideDown("fast");
	});
	$("#help_searcform #search_go").click(function()
	{
		if ($("#help_searcform #key").val()=="" || $("#key").val()=="������ؼ���...")
			{
				alert("������ؼ���");
				return false;
			}
	$("body").append('<div id="pageloadingbox">ҳ�������....</div><div id="pageloadingbg"></div>');
	$("#pageloadingbg").css("opacity", 0.5);
	$.get("<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/ajax_search_location.php", {"act":"QS_helpsearch","key":$("#help_searcform #key").val(),"page":1},
			function (data,textStatus)
			 {
				 window.location.href=data;
			 }
		);
	});
	$("#help_searcform #key").focus(function(){
	if ($("#key").val()=="������ؼ���...")
	{
	$("#help_searcform #key").css('color','').val('');
	}  
	});
});
</script>
</head>
<body <?php if ($this->_vars['QISHI']['body_bgimg']): ?>style="background:url(<?php echo $this->_vars['QISHI']['site_domain'];  echo $this->_vars['QISHI']['site_dir']; ?>
data/<?php echo $this->_vars['QISHI']['updir_images']; ?>
/<?php echo $this->_vars['QISHI']['body_bgimg']; ?>
) repeat-x center 38px;"<?php endif; ?>>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<!-- ��ǰλ�� -->
<div class="page_location link_bk">
	��ǰλ�ã�<a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
">��ҳ</a>&nbsp;>&nbsp;<a href="<?php echo $this->_run_modifier("QS_help", 'qishi_url', 'plugin', 1); ?>
">����</a>&nbsp;>&nbsp;<a href="<?php echo $this->_vars['cat']['url']; ?>
"><?php echo $this->_vars['cat']['categoryname']; ?>
</a>
</div>
	<!-- �������� -->
	<div class="container link_bk">
		<div class="about_left">
			<h2 class="about_tit">��������</h2>
			<ul>
				<?php echo tpl_function_qishi_help_category(array('set' => "�б���:category,����:0"), $this);?>
				<?php if (count((array)$this->_vars['category'])): foreach ((array)$this->_vars['category'] as $this->_vars['list']): ?>
				<li class="help_nav t"><a href="javascript:void(0);"><?php echo $this->_vars['list']['title']; ?>
</a></li>
				<ul class="nav_son" style="display:none;">
					<?php echo tpl_function_qishi_help_category(array('set' => $this->_run_modifier("�б���:sclass,����:", 'cat', 'plugin', 1, $this->_vars['list']['id'])), $this);?>
					<?php if (count((array)$this->_vars['sclass'])): foreach ((array)$this->_vars['sclass'] as $this->_vars['slist']): ?>
					<li><a href="<?php echo $this->_vars['slist']['url']; ?>
"><?php echo $this->_vars['slist']['title']; ?>
</a></li>
					<?php endforeach; endif; ?>
					<!-- <li class="active"><a href="#">ְλ�ƹ�</a></li> -->
				</ul>
				<?php endforeach; endif; ?>
			</ul>
		</div>
		<div class="help_sreach clearfix" id="help_searcform">
			<div class="f-left"><input type="text" class="input_text_300" placeholder="����������ؼ���" name="key" id="key" /></div>
			<div class="f-left"><input type="submit" value="����" class="but70lan" id="search_go" /></div>
			<div class="f-left hot-help">���Źؼ��֣�<a href="<?php echo $this->_run_modifier("QS_helpsearch", 'qishi_url', 'plugin', 1); ?>
?key=<?php echo $this->_run_modifier("�һ�����", 'escape', 'plugin', 1, "url"); ?>
">�һ�����</a><a href="<?php echo $this->_run_modifier("QS_helpsearch", 'qishi_url', 'plugin', 1); ?>
?key=<?php echo $this->_run_modifier("�ö�", 'escape', 'plugin', 1, "url"); ?>
">�ö�</a><a href="<?php echo $this->_run_modifier("QS_helpsearch", 'qishi_url', 'plugin', 1); ?>
?key=<?php echo $this->_run_modifier("�Ƽ�", 'escape', 'plugin', 1, "url"); ?>
">�Ƽ�</a><a href="<?php echo $this->_run_modifier("QS_helpsearch", 'qishi_url', 'plugin', 1); ?>
?key=<?php echo $this->_run_modifier("ģ��", 'escape', 'plugin', 1, "url"); ?>
">ģ��</a><a href="<?php echo $this->_run_modifier("QS_helpsearch", 'qishi_url', 'plugin', 1); ?>
?key=<?php echo $this->_run_modifier("���ӵ�ͼ", 'escape', 'plugin', 1, "url"); ?>
">���ӵ�ͼ</a></div>
		</div>
		<div class="about_right">
			
			<div class="about_r_tit">
				<?php echo $this->_vars['cat']['categoryname']; ?>

			</div>
			<div class="about_r_content">
				<ul>
					<?php echo tpl_function_qishi_help_list(array('set' => "�б���:help,��ʾ��Ŀ:25,���ⳤ��:45,��ַ�:...,С��:GET[id],��ҳ��ʾ:1"), $this);?>
					<?php if (count((array)$this->_vars['help'])): foreach ((array)$this->_vars['help'] as $this->_vars['list']): ?>
					<li><a href="<?php echo $this->_vars['list']['url']; ?>
"  target="_blank"><?php echo $this->_vars['list']['title']; ?>
</a></li>
					<?php endforeach; else: ?>
					<li>û�������Ϣ��</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!-- �������� ���� -->
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>