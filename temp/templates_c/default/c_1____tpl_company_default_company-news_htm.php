<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_company_news_list.php'); $this->register_function("qishi_company_news_list", "tpl_function_qishi_company_news_list",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.cat.php'); $this->register_modifier("cat", "tpl_modifier_cat",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_company_show.php'); $this->register_function("qishi_company_show", "tpl_function_qishi_company_show",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 18:21 CST */  echo tpl_function_qishi_company_show(array('set' => "�б���:company,��ҵID:GET[id]"), $this);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title><?php echo $this->_vars['company']['companyname']; ?>
 - ���Ŷ�̬ - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
<meta name="description" content="<?php echo $this->_vars['company']['contents']; ?>
,���Ŷ�̬">
<meta name="keywords" content="<?php echo $this->_vars['company']['companyname']; ?>
,���Ŷ�̬">
<meta name="author" content="��ʿCMS" />
<meta name="copyright" content="74cms.com" />
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['user_tpl']; ?>
css/css.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['user_tpl']; ?>
css/ui-dialog.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo $this->_vars['user_tpl']; ?>
js/jquery.js"></script>
<script src="<?php echo $this->_vars['user_tpl']; ?>
js/dialog-min.js"></script>
<script src="<?php echo $this->_vars['user_tpl']; ?>
js/simplefoucs.js" type="text/javascript"></script>
<SCRIPT TYPE="text/javascript">
$(document).ready(function(){
	// ����鿴��ͼ
	$(".img_big_show").click(function() {
		dialog({
			title: '��ҵ���',
		    content: $("#focus"),
		}).showModal();
	});
});
</SCRIPT>
</head>
<body>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<!-- ��ǰλ�� -->
	<div class="page_location link_bk">
		��ǰλ�ã�<a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
">��ҳ</a>><a href="<?php echo $this->_run_modifier("QS_jobs", 'qishi_url', 'plugin', 1); ?>
">��Ƹ��Ϣ</a>><?php echo $this->_vars['company']['companyname']; ?>

	</div>
	<!-- �������� -->
	<div class="container">
		<div class="company-wrap clearfix">
			<!-- ��� -->
			<div class="com-left">
				<div class="compnay-main">
					<div class="c-top-wrap clearfix">
						<div class="c-logo f-left"><img src="<?php echo $this->_vars['company']['logo']; ?>
" alt="��˾logo" width="198" height="68" /></div>
						<div class="c-name f-left">
							<h2><?php echo $this->_vars['company']['companyname']; ?>

								<?php if ($this->_vars['company']['audit'] == "1"): ?>
									<img title="��ҵ����֤" src="<?php echo $this->_vars['QISHI']['site_template']; ?>
images/yesyan.jpg" border="0" />
								<?php else: ?>
									<img title="��ҵδ��֤" src="<?php echo $this->_vars['QISHI']['site_template']; ?>
images/noyan.jpg" border="0" />
								<?php endif; ?>
								<?php if ($this->_vars['company']['pay_user'] > 1): ?>
									<img title="" src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
data/setmealimg/<?php echo $this->_vars['company']['pay_user']; ?>
.gif" border="0" width='14px' height="17px"/>
								<?php endif; ?>
							</h2>
							<p><?php echo $this->_vars['company']['address']; ?>
</p>
						</div>
					</div>
					<div class="company-control clearfix">
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companyshow,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left">��ҵ��ҳ</a>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companyinfo,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left">��˾����</a>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companyjobs,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left ">��Ƹְλ</a>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companynews,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left active">���Ŷ�̬</a>
						<?php if ($this->_vars['QISHI']['open_commentaudit'] == "1"): ?>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companycomment,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left">����</a>
						<?php endif; ?>
					</div>
					<!-- �����б� -->
					<?php echo tpl_function_qishi_company_news_list(array('set' => "�б���:news,��ҳ��ʾ:1,��ʾ��Ŀ:5,���ⳤ��:35,��ҵID:GET[id],���ⳤ��:35,ժҪ����:50,��ַ�:...,���ģ��:" . $_GET['style'] . ",����:order>desc"), $this);?>
					<?php if ($this->_vars['news']): ?>
					<div class="company-news-list">
						<div class="company-news-caption">����<?php echo $this->_vars['total']; ?>
�����Ŷ�̬</div>
						<?php if (count((array)$this->_vars['news'])): foreach ((array)$this->_vars['news'] as $this->_vars['list']): ?>  
						<div class="news-item">
							<h3><a href="<?php echo $this->_vars['list']['url']; ?>
" target="_blank"><?php echo $this->_vars['list']['title']; ?>
</a></h3>
							<p><span>���������<?php echo $this->_vars['list']['click']; ?>
</span><span>�������ڣ�<?php echo $this->_run_modifier($this->_vars['list']['addtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</span></p>
							<div><?php echo $this->_vars['list']['briefly']; ?>
<a href="<?php echo $this->_vars['list']['url']; ?>
">[�鿴ȫ��]</a></div>
						</div>
						<?php endforeach; endif; ?>
					</div>
					<?php else: ?>
					<div class="company-news-list">
						<div class="emptytip">û�����Ŷ�̬��</div>
					</div>
					<?php endif; ?>
					<div class="page"><?php echo $this->_vars['page']; ?>
</div>
				</div>
			</div>
			<!-- �ұ� -->
			<div class="com-right">
				<div class="ring-group clearfix">
					<div class="ring-item f-left">
						<h4 class="resumes"><?php echo $this->_vars['company']['resume_processing']; ?>
%</h4>
						<p>����������</p>
					</div>
					<div class="ring-item f-left">
						<h4 class="jobs"><?php echo $this->_vars['company']['jobs_num']; ?>
</h4>
						<p>����ְλ</p>
					</div>
					<div class="ring-item f-left">
						<h4 class="interest"><?php echo $this->_vars['company']['resume_num']; ?>
</h4>
						<p>����Ȥ����</p>
					</div>
				</div>
				<div class="c-right-block">
					<h3 class="c-right-title">��˾��Ƭ</h3>
					<ul class="company-info-list">
						<li>���ʣ�<?php echo $this->_vars['company']['nature_cn']; ?>
</li>
						<li>��ҵ��<?php echo $this->_vars['company']['trade_cn']; ?>
</li>
						<li>��ģ��<?php echo $this->_vars['company']['scale_cn']; ?>
</li>
						<li>������<?php echo $this->_vars['company']['district_cn']; ?>
</li>
						<?php if ($this->_vars['company']['website']): ?>
						<li>��ַ��<a target="_blank" href="<?php echo $this->_vars['company']['website']; ?>
" rel="nofollow"><?php echo $this->_vars['company']['website']; ?>
</a></li>
						<?php endif; ?>
					</ul>
				</div>
				<?php if ($this->_vars['company']['company_img_num'] > 0): ?>
				<div class="c-right-block">
					<h3 class="c-right-title">��˾���</h3>
					<div class="company-img">
						<div class="img-show img_big_show"><img src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
data/companyimg/thumb/<?php echo $this->_vars['company']['company_img']; ?>
"  width="140" height="104" /></div>
						<p>��<?php echo $this->_vars['company']['company_img_num']; ?>
��<a href="javascript:void(0)" class="img_big_show">[����鿴��ͼ]</a></p>
					</div>
				</div>
				<?php endif; ?>
				<div class="c-right-block">
					<h3 class="c-right-title">�ֻ����</h3>
					<div class="com-code">
						<!-- ���˰� 
						<img src="<?php echo $this->_vars['QISHI']['site_domain'];  echo $this->_vars['QISHI']['site_dir']; ?>
plus/url_qrcode.php?url=<?php echo $this->_vars['company']['company_url']; ?>
" alt="ɨ���ά��" width="100" height="100" /> -->
						<!-- רҵ�� -->
						<img src="<?php echo $this->_vars['QISHI']['site_domain'];  echo $this->_vars['QISHI']['site_dir']; ?>
plus/url_qrcode.php?url=<?php echo $this->_vars['QISHI']['site_domain'];  echo $this->_vars['QISHI']['site_dir']; ?>
m/m-wzp.php?company_id=<?php echo $this->_vars['company']['id']; ?>
" alt="ɨ���ά��" width="100" height="100" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<div id="focus" style="display: none;">
        <ul>
        	<?php if (count((array)$this->_vars['company']['company_img_big'])): foreach ((array)$this->_vars['company']['company_img_big'] as $this->_vars['val']): ?>
            <li><img src="<?php echo $this->_vars['val']; ?>
" width='600px' height='400px'/></li>
            <?php endforeach; endif; ?>
        </ul>
    </div>
</body>
</html>