<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 17:32 CST */ ?>
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
">��Ա����</a> > ��������</div>
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
					<div class="titleH1"><div class="h1-title">��������</div></div>
					<div class="navs link_bk">
						<a href="?act=<?php echo $this->_vars['act']; ?>
&look=" <?php if ($_GET['look'] == ""): ?>class="se"<?php endif; ?>>���м���<span class="check">(<?php echo $this->_vars['count']; ?>
)</span></a>
						<a href="?act=<?php echo $this->_vars['act']; ?>
&look=1" <?php if ($_GET['look'] == "1"): ?>class="se"<?php endif; ?>>�Է�δ�鿴<span class="no_check">(<?php echo $this->_vars['count1']; ?>
)</span></a>
						<a href="?act=<?php echo $this->_vars['act']; ?>
&look=2" <?php if ($_GET['look'] == "2"): ?>class="se"<?php endif; ?>>�Է��Ѳ鿴<span class="check">(<?php echo $this->_vars['count2']; ?>
)</span></a>
						<div class="clear"></div>
					</div>
				</div>
				<form id="form1" name="form1" method="post" action="?act=interview_del">
				<div class="company-data-list">
					<div class="c-data-top interview clearfix">
						<div class="item f-left check-item"><input type="checkbox" name="chkAll" id="chk" class="checkbox" /></div>
						<div class="item f-left top-item1">����</div>
						<div class="item f-left top-item2">������Ϣ</div>
						<div class="item f-left top-item3">
							<div class="data-filter span2">
								<span class="filter-span"><?php if ($_GET['jname']):  echo $_GET['jname'];  else: ?>����ְλ<?php endif; ?><i class="filter-icon"></i></span>
								<ul class="filter-down">
									<li><a href="?act=<?php echo $this->_vars['act']; ?>
&jobsid=&jname=&look=<?php echo $_GET['look']; ?>
">ȫ��ְλ</a></li>
									<?php if (count((array)$this->_vars['filter_jobs'])): foreach ((array)$this->_vars['filter_jobs'] as $this->_vars['list']): ?>
									<li><a href="?act=<?php echo $this->_vars['act']; ?>
&jobsid=<?php echo $this->_vars['list']['jobs_id']; ?>
&jname=<?php echo $this->_vars['list']['jobs_name']; ?>
&look=<?php echo $_GET['look']; ?>
"><?php echo $this->_vars['list']['jobs_name']; ?>
</a></li>
									<?php endforeach; endif; ?>
								</ul>
							</div>
						</div>
						<div class="item f-left top-item5">
							<div class="data-filter span4">
								<span class="filter-span"><?php if ($_GET['look'] == '1'): ?>�Է�δ�鿴<?php elseif ($_GET['look'] == '2'): ?>�Է��Ѳ鿴<?php else: ?>�鿴״̬<?php endif; ?><i class="filter-icon"></i></span>
								<ul class="filter-down">
									<li><a href="?act=<?php echo $this->_vars['act']; ?>
&jobsid=<?php echo $_GET['jobsid']; ?>
&jname=<?php echo $_GET['jname']; ?>
&look=">ȫ��</a></li>
									<li><a href="?act=<?php echo $this->_vars['act']; ?>
&jobsid=<?php echo $_GET['jobsid']; ?>
&jname=<?php echo $_GET['jname']; ?>
&look=2">�Է��Ѳ鿴</a></li>
									<li><a href="?act=<?php echo $this->_vars['act']; ?>
&jobsid=<?php echo $_GET['jobsid']; ?>
&jname=<?php echo $_GET['jname']; ?>
&look=1">�Է�δ�鿴</a></li>
								</ul>
							</div>
						</div> 
						<div class="item f-left top-item6">����ʱ��</div>
						<div class="item f-left top-item7">����</div>
					</div>
					<?php if ($this->_vars['resume']): ?>
					<?php if (count((array)$this->_vars['resume'])): foreach ((array)$this->_vars['resume'] as $this->_vars['list']): ?>
					<?php if ($this->_vars['list']['sex_cn']): ?>
					<div class="c-data-row">
						<div class="c-data-content interview clearfix">
							<div class="c-item f-left check-item"><input type="checkbox" name="y_id[]" id="y_id" value="<?php echo $this->_vars['list']['did']; ?>
" class="checkbox" /></div>
							<div class="c-item f-left content1"><a href="javascript:;" class="name-link underline"><?php echo $this->_vars['list']['resume_name']; ?>
</a></div>
							<div class="c-item f-left content2"><?php if ($this->_vars['list']['age']):  echo $this->_vars['list']['age']; ?>
��/<?php endif;  echo $this->_vars['list']['education_cn']; ?>
/<?php echo $this->_vars['list']['experience_cn']; ?>
</div>
							<div class="c-item f-left content3"><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
" class="jobs-name-link underline" target="_blank"><?php echo $this->_vars['list']['jobs_name_']; ?>
</a></div>
							<div class="c-item f-left content5">
								<?php if ($this->_vars['list']['personal_look'] == "1"): ?>
					   			�Է�δ�鿴
					   			<?php elseif ($this->_vars['list']['personal_look'] == "2"): ?>
					   			�Է��Ѳ鿴
					   			<?php endif; ?>
							</div>
							<div class="c-item f-left content6"><span class="data-time"><?php echo $this->_run_modifier($this->_vars['list']['interview_addtime'], 'date', 'plugin', 1, "Y-m-d"); ?>
</span></div>
							<div class="c-item f-left content7">
								<a href="javascript:;" did="<?php echo $this->_vars['list']['did']; ?>
" class="data-ctrl underline check-detail">����</a>
								&nbsp;
								<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=interview_del&y_id=<?php echo $this->_vars['list']['did']; ?>
">ɾ��</a>
							</div>
						</div>
						<div class="data-detail">
							<i class="arrow"></i>
							<?php if ($this->_vars['list']['resume_education_list']): ?>
							<div class="detail-block clearfix">
								<div class="db-type f-left">����������</div>
								<div class="db-content f-left">
									<?php if (count((array)$this->_vars['list']['resume_education_list'])): foreach ((array)$this->_vars['list']['resume_education_list'] as $this->_vars['edu_list']): ?>
									<p class="db-info"><span><?php echo $this->_vars['edu_list']['startyear']; ?>
��<?php echo $this->_vars['edu_list']['startmonth']; ?>
��-<?php echo $this->_vars['edu_list']['endyear']; ?>
��<?php echo $this->_vars['edu_list']['endmonth']; ?>
��</span><span><?php echo $this->_vars['edu_list']['school']; ?>
</span><span><?php echo $this->_vars['edu_list']['speciality']; ?>
</span><span><?php echo $this->_vars['edu_list']['education_cn']; ?>
</span></p>
									<?php endforeach; endif; ?>
								</div>
							</div>
							<?php endif; ?>
							<?php if ($this->_vars['list']['resume_work_list']): ?>
							<div class="detail-block clearfix">
								<div class="db-type f-left">����������</div>
								<div class="db-content f-left">
									<?php if (count((array)$this->_vars['list']['resume_work_list'])): foreach ((array)$this->_vars['list']['resume_work_list'] as $this->_vars['w_list']): ?>
									<p class="db-info"><span><?php echo $this->_vars['w_list']['startyear']; ?>
��<?php echo $this->_vars['w_list']['startmonth']; ?>
��-<?php echo $this->_vars['w_list']['endyear']; ?>
��<?php echo $this->_vars['w_list']['endmonth']; ?>
��</span><span><?php echo $this->_vars['w_list']['companyname']; ?>
</span><span><?php echo $this->_vars['w_list']['jobs']; ?>
</span></p>
									<?php endforeach; endif; ?>
								</div>
							</div>
							<?php endif; ?>
							<div class="detail-block clearfix">
								<div class="db-type f-left">��ְ����</div>
								<div class="db-content f-left">
									<div class="job-flow"><span>������������ <?php echo $this->_vars['list']['nature_cn']; ?>
</span> | <span>������������ <?php echo $this->_vars['list']['district_cn']; ?>
</span> | <span>����н�� <em><?php echo $this->_vars['list']['wage_cn']; ?>
</em></span> | <span>����ְλ <?php echo $this->_vars['list']['intention_jobs']; ?>
</span> | <span>������ҵ <?php echo $this->_vars['list']['trade_cn']; ?>
</span></div>
								</div>
							</div>
							<div class="detail-block clearfix">
								<div class="db-type f-left">&nbsp;</div>
								<div class="db-btn-group f-left">
									<a href="<?php echo $this->_vars['list']['resume_url']; ?>
" class="db-btn btn1 f-left" target="_blank"></a>
									<a href="company_resume_doc.php?y_id=<?php echo $this->_vars['list']['resume_id']; ?>
" class="db-btn btn2 f-left"></a>
									<a href="javascript:;" class="db-btn btn3 f-left" resume_id="<?php echo $this->_vars['list']['resume_id']; ?>
" uid="<?php echo $this->_vars['list']['personal_uid']; ?>
" ></a>
								</div>
							</div>
						</div>
					</div>
					<?php else: ?>
					<div class="c-data-row">
						<div class="c-data-content interview clearfix">
							<div class="c-item f-left check-item"><input type="checkbox" name="y_id[]" id="y_id" value="<?php echo $this->_vars['list']['did']; ?>
" class="checkbox" /></div>
							��������[<?php echo $this->_vars['list']['resume_name']; ?>
] �ļ��������ѱ�ɾ����������ɾ��������Ϣ.	
						</div>
					</div>
					<?php endif; ?>
					<?php endforeach; endif; ?>
					<div class="c-data-row last">
						<div class="c-data-content apply_jobs clearfix">
							<div class="c-item f-left check-item"><input type="checkbox" name="chkAll" id="chk2" class="checkbox" /></div>
							<div class="data-last-btn f-left">
								<input type="button" value="ɾ��" class="btn-65-30blue ctrl-del" act="?act=interview_del" />
							</div>
						</div>
					</div>
					<?php else: ?>
					<div class="emptytip">����û�з�����������룡</div>
					<?php endif; ?>
				</div>
				</form>
				<!-- ����ӷ�ҳ -->
				<?php if ($this->_vars['page']): ?>
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