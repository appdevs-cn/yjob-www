<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_parse_url.php'); $this->register_modifier("qishi_parse_url", "tpl_modifier_qishi_parse_url",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 17:53 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title><?php echo $this->_vars['title']; ?>
</title>
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<meta name="author" content="��ʿCMS" />
<meta name="copyright" content="74cms.com" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/user_common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/user_company.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/ui-dialog.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/dialog-min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/dialog-min-common.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
$(document).ready(function(){

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
	// ״̬
	$('.state-icon').on('click', function(e){
		$(this).next().toggle();
		$(document).one('click', function(){
			$('.state-list').hide();
		});
		e.stopPropagation();
		$('.state-icon').not($(this)).next().hide();
	});
	$('.state-list .state').on('click', function(e){
		var resume_state= $(this).attr('state');
		var resume_state_cn =$(this).text();
		var resume_id =$(this).attr('resume_id');
		$.post('<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_label_resume.php', {"resume_state":resume_state,"resume_state_cn":resume_state_cn,"resume_id":resume_id}, function(data) 
		{
			if(data=="ok")
			{
				window.location.replace(location);
			}
			else
			{
				$('.state-list').hide();
			}
		});
		e.stopPropagation();
	})
	$("#toword").click(function() {
		$("#form1").attr("action","company_resume_doc.php");
		$("#form1").submit();
	});
	// ɾ������
	delete_dialog('.ctrl-del','#form1');
	// ���͵����䵯��
	companySendToEmail_dialog('.db-btn.btn3','./company_ajax.php');
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
">��Ա����</a> > �����صļ���</div>

<div class="usermain">
  <div class="leftmenu  com link_bk">
  	 <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("member_company/left.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>	
  </div>
  <div class="rightmain">
		<div class="bbox1 my_account">
			<div class="title_h1" style="padding-bottom:10px;">�����صļ���</div>
			<form id="form1" name="form1" method="post" action="?act=down_resume_del">
			<div class="company-data-list">
				<div class="c-data-top company_down_resume clearfix">
					<div class="item f-left check-item"><input type="checkbox" name="chkAll"  id="chk" title="ȫѡ/��ѡ" /></div>
					<div class="item f-left top-item1">
						<div class="data-filter span1">
							<span class="filter-span"><?php if ($_GET['state_cn'] == ''): ?>��ǩ<?php else:  echo $_GET['state_cn'];  endif; ?><i class="filter-icon"></i></span>
							<ul class="filter-down">
								<li><a href="<?php echo $this->_run_modifier("state:,state_cn:ȫ��", 'qishi_parse_url', 'plugin', 1); ?>
">ȫ��</a></li>
								<li><a href="<?php echo $this->_run_modifier("state:1,state_cn:����", 'qishi_parse_url', 'plugin', 1); ?>
">����</a></li>
								<li><a href="<?php echo $this->_run_modifier("state:2,state_cn:������", 'qishi_parse_url', 'plugin', 1); ?>
">������</a></li>
								<li><a href="<?php echo $this->_run_modifier("state:3,state_cn:����", 'qishi_parse_url', 'plugin', 1); ?>
">����</a></li>
								<li><a href="<?php echo $this->_run_modifier("state:4,state_cn:δ��ͨ", 'qishi_parse_url', 'plugin', 1); ?>
">δ��ͨ</a></li>
							</ul>
						</div>
					</div>
					<div class="item f-left top-item2">����</div>
					<div class="item f-left top-item3">������Ϣ</div>
					<div class="item f-left top-item4">����ְλ</div>
					<div class="item f-left top-item5">
						<div class="data-filter span4">
							<span class="filter-span"><?php if ($_GET['settr_cn'] == ''): ?>����ʱ��<?php else:  echo $_GET['settr_cn'];  endif; ?><i class="filter-icon"></i></span>
							<ul class="filter-down">
								<li><a href="<?php echo $this->_run_modifier("settr:,settr_cn:ȫ��", 'qishi_parse_url', 'plugin', 1); ?>
">ȫ��</a></li>
								<li><a href="<?php echo $this->_run_modifier("settr:3,settr_cn:������", 'qishi_parse_url', 'plugin', 1); ?>
">������</a></li>
								<li><a href="<?php echo $this->_run_modifier("settr:7,settr_cn:һ����", 'qishi_parse_url', 'plugin', 1); ?>
">һ����</a></li>
								<li><a href="<?php echo $this->_run_modifier("settr:30,settr_cn:һ����", 'qishi_parse_url', 'plugin', 1); ?>
">һ����</a></li>
							</ul>
						</div>
					</div>
					<div class="item f-left top-item6">����</div>
				</div>
				<?php if ($this->_vars['list']): ?>
				<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['list']): ?>
				<?php if ($this->_vars['list']['sex_cn']): ?>
				<div class="c-data-row">
					<div class="c-data-content company_down_resume clearfix">
						<div class="c-item f-left check-item"><input name="y_id[]" type="checkbox" id="y_id"  value="<?php echo $this->_vars['list']['did']; ?>
"/></div>
						<div class="c-item f-left content1">
							<div class="data-state">
								<span title="<?php echo $this->_vars['list']['resume_state_cn']; ?>
" class="state-icon <?php if ($this->_vars['list']['resume_state'] > 0): ?>s<?php echo $this->_vars['list']['resume_state'];  else: ?>default<?php endif; ?>"></span>
								<div class="state-list">
									<li><a href="javascript:;" class="state s1" state="1" resume_id="<?php echo $this->_vars['list']['resume_id']; ?>
">����</a></li>
									<li><a href="javascript:;" class="state s2" state="2" resume_id="<?php echo $this->_vars['list']['resume_id']; ?>
">������</a></li>
									<li><a href="javascript:;" class="state s3" state="3" resume_id="<?php echo $this->_vars['list']['resume_id']; ?>
">����</a></li>
									<li><a href="javascript:;" class="state s4" state="4" resume_id="<?php echo $this->_vars['list']['resume_id']; ?>
">δ��ͨ</a></li>
								</div>
							</div>
						</div>

						<div class="c-item f-left content2"><a href="javascript:;" class="name-link underline"><?php echo $this->_vars['list']['fullname']; ?>
</a></div>

						<div class="c-item f-left content3"><?php if ($this->_vars['list']['age']):  echo $this->_vars['list']['age']; ?>
��/<?php endif;  echo $this->_vars['list']['education_cn']; ?>
/<?php echo $this->_vars['list']['experience_cn']; ?>
</div>
						<div class="c-item f-left content4"><?php echo $this->_vars['list']['intention_jobs']; ?>
</div>
						<div class="c-item f-left content5"><span class="data-time"><?php echo $this->_run_modifier($this->_vars['list']['down_addtime'], 'date', 'plugin', 1, "Y-m-d"); ?>
</span></div>
						<div class="c-item f-left content6"><a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=down_resume_del&y_id=<?php echo $this->_vars['list']['did']; ?>
">ɾ��</a></div>
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
						[<?php echo $this->_vars['list']['resume_name']; ?>
] �ļ��������ѱ�ɾ����������ɾ��������Ϣ.	
					</div>
				</div>
				<?php endif; ?>
				<?php endforeach; endif; ?>
				<div class="c-data-row last">
					<div class="c-data-content apply_jobs clearfix">
						<div class="c-item f-left check-item"><input type="checkbox" name="chkAll"  id="chk2" title="ȫѡ/��ѡ" /></div>
						<div class="data-last-btn f-left">
							<input type="button" name="delete" value="ɾ��"   class="btn-65-30blue ctrl-del" act="?act=down_resume_del"/>
						</div>
						<div class="data-last-btn f-left">
							<input type="button" value="��������" id="toword" class="btn-65-30blue resume_doc" />
						</div>
					</div>
				</div>
				<?php else: ?>
				<div class="emptytip">û���ҵ���Ӧ����Ϣ��</div>
				<?php endif; ?>
			</div>
			</form>
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