<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 09:37 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<meta name="renderer" content="webkit"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge"/> 
<title><?php echo $this->_vars['title']; ?>
</title>
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<meta name="author" content="��ʿCMS" />
<meta name="copyright" content="74cms.com" />
<link rel="stylesheet" href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/user_common.css" />
<link rel="stylesheet" href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/user_company.css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/ui-dialog.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.js"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/dialog-min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.zclip.min.js" type="text/javascript"></script>
</head>
<body <?php if ($this->_vars['QISHI']['body_bgimg']): ?>style="background:url(<?php echo $this->_vars['QISHI']['site_domain'];  echo $this->_vars['QISHI']['site_dir']; ?>
data/<?php echo $this->_vars['QISHI']['updir_images']; ?>
/<?php echo $this->_vars['QISHI']['body_bgimg']; ?>
) repeat-x center 38px;"<?php endif; ?>>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class="page_location link_bk">��ǰλ�ã�<a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
">��ҳ</a> > <a href="<?php echo $this->_vars['userindexurl']; ?>
">��Ա����</a> > ΢����Ƹ</div>
	<div class="usermain">
		<div class="leftmenu com link_bk">
			<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("member_company/left.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
		</div>
		<div class="rightmain">
			<div class="bbox1">
				<div class="mobile-job">
					<h1>΢����Ƹ</h1>
					<div class="mobile-job-block clearfix">
						<div class="code-item f-left">
							<div class="code"><img src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/url_qrcode.php?url=<?php echo $this->_vars['w_url']; ?>
" alt="ɨ���ά��" width="120" height="120" /></div>
							<p class="clearfix"><a href="javascript:;" class="f-left underline showQScodeLink" id="showQScodeLink">�鿴����</a><a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/url_qrcode.php?url=<?php echo $this->_vars['w_url']; ?>
&download=1" class="f-right underline">���ض�ά��</a></p>
						</div>
						<script type="text/javascript">
							$(".showQScodeLink").die().live('click', function() {
								var d = dialog({
								    content: $("#qshowaBox"),
								    quickClose: true,// ����հ״����ٹر�
								    width: '300px'
								});
								d.show(document.getElementById('showQScodeLink'));
								$('.qshowa').zclip({
									path: '<?php echo $this->_vars['QISHI']['site_template']; ?>
flash/ZeroClipboard.swf',
									copy: function(){
										return $('.qshowaBoxD').val();
									},
									afterCopy: function(){
										$('.qshowa').html('���Ƴɹ�!');
									}
								});
							});
						</script>
						<div id="qshowaBox" style="display:none"><div><input class="qshowaBoxD" value="<?php echo $this->_vars['QISHI']['site_domain'];  echo $this->_vars['QISHI']['site_dir']; ?>
plus/url_qrcode.php?url=<?php echo $this->_vars['w_url']; ?>
"></div><a href="javascript:;" class="qshowa">��������</a></div>
						<div class="mj-data f-left">
							<div class="f-left mj-data-item first"><div><?php echo $this->_vars['click']; ?>
</div><p>���շ���</p></div>
							<div class="f-left mj-data-item"><div><?php echo $this->_vars['praise']; ?>
</div><p>���ջ�õ���</p></div>
						</div>
						<a href="?act=data_statistics" class="check-data f-left">�鿴Ч������</a>
					</div>
					<div class="mj-text-block">
						<div class="mj-text">
							<h3>ʲô��΢����Ƹ</h3>
							<p>΢����Ƹ�����ǰ������ɵ��ֻ���Ƹҳ�棬ͨ��ʹ��΢�ŷ������º�����������ȷ�ʽ������óɱ�����ƸЧ����΢����Ƹ�е�ȡ�������µ�ְλ��Ϣ��������ҵ���ϣ��������ü������ɡ�ְλ��ȡ�������ĸ��¶���̬�������Ӷ���ʾ���µ�ְλ��</p>
						</div>
						<div class="mj-text">
							<h3>ʲô�ǵ���</h3>
							<p>������΢����Ƹ��ҳ���һҳ�е��ް�ť��������ͨ����������΢����Ƹ��ҳ�ø������ְ�߷��ʽ�����ø���ĵ��ޡ�</p>
						</div>
						<div class="mj-text">
							<h3>���ʹ��΢����Ƹ</h3>
							<p>
								ͨ��΢������Ȧ���� <br />
								��һ�� ��д��ҵ���Ϸ���ְλ <br />
								�ڶ��� ΢��ɨ���ά�� ��������Ȧ <br />
								������ ���������һ�����
							</p>
						</div>
						<div class="mj-text">
							<h3>���������ø����˿���</h3>
							<p>����΢����Ƹ��ά�룬����ά����������Ƹ�����ϣ��ø�����ͨ��ɨ���ά���������΢����Ƹ��ҳ��</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>