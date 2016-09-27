<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 17:53 CST */ ?>
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
js/dialog-min-common.js" type="text/javascript" language="javascript"></script>
<script>
	$(document).ready(function() {
		$('.name-link').toggle(function(){
			$(this).parents('.c-data-content').next().show();
			$(this).parents('.c-data-row').css({'border-color':'#fff'});
		}, function(){
			$(this).parents('.c-data-content').next().hide();
			$(this).parents('.c-data-row').css({'border-color':'#ccc'});
		});
		// ����ɸѡ
		$('.data-filter').on('click', function(e){
			$(this).find('.filter-down').toggle();
			// ��̬���������б���
			var fWidth = $(this).find('.filter-span').outerWidth(true) - 2;
			$(this).find(".filter-down").width(fWidth);
			// �������λ����������
			$(document).one("click",function(){
				$('.filter-down').hide();
			});
			e.stopPropagation();
			//�������ʱ������������
			$(".data-filter").not($(this)).find('.filter-down').hide();
		})
		// ɾ������
		delete_dialog('.ctrl-del','#form1');
		// ���͵����䵯��
		companySendToEmail_dialog('.db-btn.btn3','./company_ajax.php');
		//�鿴����
		$('.check-detail').on('click', function(){
			var did =  $(this).attr('did');
			var url = "company_ajax.php?act=interview_detail&did="+did;
			var myDialog = dialog();
			myDialog.content("������...");
			myDialog.title('��������');
		 	myDialog.width('300');
			myDialog.showModal();
			$.get(url, function(data){
				myDialog.content(data);
				/* �ر� */
				$(".DialogClose").live('click',function() {
					myDialog.close().remove();
				});
			});
		});
	});
</script>
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
">��Ա����</a> > ���ٱ���</div>
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
				<div class="topnav get_resume">
					<div class="titleH1"><div class="h1-title">���ٱ���</div></div>
				</div>
				<form id="form1" name="form1" method="post" action="?act=fastapply">
				
				<div class="clear" style="margin-top:10px;">
					<div style="height:30px;width:300px;float:right;border:none;margin-right:10px;">
						<input type="text" style="height:26px;width:120px;margin-right:6px;" name="zhi" />
						<select name="tiaojian" style="width:60px;height:28px;" id="">
							<option value="1" selected="selected">����</option>
							<option value="2">�ֻ���</option>
						</select>
						<input type="submit" style="height:26px;width:80px;margin-left:10px;color:#fff;font-size:18px;line-height:24px;border:none;text-align:center;background-color:green;" value="�� ��" />
					</div>
				</div>
				</form>
				<div class="company-data-list clear" style="margin-top:20px;">
					<div class="c-data-top interview clearfix">
						<div class="item f-left top-item1">����</div>
						<div class="item f-left top-item2">�ֻ���</div>
						<div class="item f-left top-item3">
							��������
						</div>
						<div class="item f-left top-item7">����</div>
					</div>
					<?php if ($this->_vars['resume']): ?>
						<?php if (count((array)$this->_vars['resume'])): foreach ((array)$this->_vars['resume'] as $this->_vars['list']): ?>
						<div class="c-data-row">
							<div class="c-data-content interview clearfix">
								
								<div class="c-item f-left content1" style="width:100px;text-indent:-10px;"><a href="javascript:;" class="name-link underline">&nbsp;<?php echo $this->_vars['list']['fullname']; ?>
</a></div>
								<div class="c-item f-left content2" style="width:200px;">&nbsp;<?php echo $this->_vars['list']['telephone']; ?>
</div>
								<div class="c-item f-left content3" style="width:200px;"><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
" class="jobs-name-link underline" target="_blank">&nbsp;<?php echo $this->_vars['list']['title']; ?>
</a></div>
								
								<div class="c-item f-left content7" style="width:180px;">
									<form action="?act=ksbm_bm" method="post" style="width:300px;">
									<?php if ($this->_vars['jobs']): ?>
									<input type="submit" value="���ٱ���" style="width:80px;color:red;line-height:20px;text-align:center;">
									
									<input type="hidden" name="id" value="<?php echo $this->_vars['list']['id']; ?>
"/>
									<select name="zhiwei" id="" style="width:100px;">
										<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['zwlist']): ?>
										<?php if ($this->_vars['list']['bmid'] != $this->_vars['zwlist']['id']): ?>
										<option value="<?php echo $this->_vars['zwlist']['id']; ?>
"><?php echo $this->_vars['zwlist']['jobs_name']; ?>
</option>
										<?php endif; ?>
										<?php endforeach; endif; ?>
									</select>
									<?php else: ?>
										<a href="javascript:;" style="width:80px;color:red;line-height:20px;text-align:center;">��û����ְλ��ְλ����</a>
									<?php endif; ?>
									</form>
								</div>
							</div>
						</div>
						<?php endforeach; endif; ?>
					<?php else: ?>
					<div style="margin-top:20px;font-size:30px;height:50px;line-height:50px;">���������Ϣ����</div>
					<?php endif; ?>
				</div>
				<!-- ����ӷ�ҳ -->
				<?php if ($this->_vars['page']): ?>
				<div class="clearfix"></div>
				<table border="0" align="center" cellpadding="0" cellspacing="0">
		          	<tr>
		          		<td height="50" align="center"> <div class="page link_bk"><?php echo $this->_vars['page']; ?>
</div></td>
		          	</tr>
		      	</table>
				<?php endif; ?>
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