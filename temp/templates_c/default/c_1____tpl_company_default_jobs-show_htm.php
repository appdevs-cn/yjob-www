<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_jobs_list.php'); $this->register_function("qishi_jobs_list", "tpl_function_qishi_jobs_list",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.cat.php'); $this->register_modifier("cat", "tpl_modifier_cat",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_company_show.php'); $this->register_function("qishi_company_show", "tpl_function_qishi_company_show",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_jobs_show.php'); $this->register_function("qishi_jobs_show", "tpl_function_qishi_jobs_show",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 18:03 CST */  echo tpl_function_qishi_jobs_show(array('set' => "�б���:show,ְλID:GET[id]"), $this); echo tpl_function_qishi_company_show(array('set' => $this->_run_modifier("�б���:company,��ҵID:", 'cat', 'plugin', 1, $this->_vars['show']['company_id'])), $this);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title><?php echo $this->_vars['show']['jobs_name']; ?>
 - <?php echo $this->_vars['show']['companyname']; ?>
 - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
<meta name="description" content="<?php echo $this->_vars['show']['companyname']; ?>
��˾��Ƹ��λ,<?php echo $this->_vars['show']['jobs_name']; ?>
">
<meta name="keywords" content="<?php echo $this->_vars['show']['companyname']; ?>
,<?php echo $this->_vars['show']['jobs_name']; ?>
,<?php echo $this->_vars['show']['nature_cn']; ?>
,<?php echo $this->_vars['show']['category_cn']; ?>
,<?php echo $this->_vars['show']['trade_cn']; ?>
,<?php echo $this->_vars['show']['district_cn']; ?>
">
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
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/dialog-min-common.js"></script>
<script src="<?php echo $this->_vars['user_tpl']; ?>
js/simplefoucs.js" type="text/javascript"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $this->_vars['QISHI']['map_ak']; ?>
"></script>
<SCRIPT TYPE="text/javascript">
$(document).ready(function(){
	$.ajaxSetup ({
		cache: false //�ر�AJAX��Ӧ�Ļ���
	});
	var id="<?php echo $this->_vars['show']['id']; ?>
";
	var company_id="<?php echo $this->_vars['show']['company_id']; ?>
";
	var tsTimeStamp= new Date().getTime();
	$.get("<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/ajax_click.php", { "id": id,"time":tsTimeStamp,"act":"jobs_click"},
		function (data,textStatus)
		 {			
			$(".click").html(data);
		 }
	);
	/* ��ϵ��ʽ */
	$.get("<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/ajax_contact.php", { "id": id,"time":tsTimeStamp,"act":"jobs_contact"},
		function (data,textStatus)
		 {			
			$("#jobs_contact").html(data);
		 }
	);
	$("#tel_show_pic").live('click',function()
	{
		$.get("<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/ajax_contact.php", { "id": id,"time":tsTimeStamp,"hashstr":"<?php echo $this->_vars['hashstr']; ?>
","act":"jobs_contact"},
			function (data,textStatus)
			 {			
				$("#jobs_contact").html(data);
			 	$("#show_detail").show();
			 	$("#tel_show_pic").remove();
			 }
		);
	});
	// ����鿴��ͼ
	$(".img_big_show").click(function() {
		dialog({
			title: '��ҵ���',
		    content: $("#focus")
		}).showModal();
	});
	//�ղ�ְλ
	favoritesJob_dialog('.add_favorites','<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_favorites_job.php?id=<?php echo $this->_vars['show']['id']; ?>
&act=add');
	//����ְλ
	applyJob_dialog(".app_jobs","<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_apply_jobs.php","1");
	//�ٱ���Ϣ
	reportJob_dialog(".report_button","<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_report.php");
	// �û���¼
	$(".ajax_user_login").live('click',function(){
		var myDialog = dialog();// ��ʼ��һ������loadingͼ��ĿնԻ���
		jQuery.ajax({
		    url: '<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_ajax_login.php',
		    success: function (data) {
		    	myDialog.width(475);
		        myDialog.content(data);// ���Ի�������
		        myDialog.title('�û���¼');// ���Ի�������
		    	myDialog.showModal();
		    }
		});
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
" class="c-control-item f-left active">��Ƹְλ</a>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companynews,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left ">���Ŷ�̬</a>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companycomment,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left">����</a>
					</div>
					<!-- ְλ���� -->
					<div class="job-main">
						<div class="job-top">
							<h3 class="job-name"><?php echo $this->_vars['show']['jobs_name']; ?>
</h3>
							<div class="job-company clearfix"><a href="<?php echo $this->_vars['show']['company_url']; ?>
" class="f-left"><?php echo $this->_vars['show']['companyname']; ?>
</a></div>
							<div class="job-watch-info clearfix">
								<div class="add-time f-left">����ʱ�䣺<?php echo $this->_run_modifier($this->_vars['show']['refreshtime'], 'date_format', 'plugin', 1, "%Y-%m-%d %H:%M"); ?>
</div>
								<div class="watch f-left">���<span><em class="times click"></em></span>��</div>
								<div class="resumes-man f-left"><span><?php echo $this->_vars['show']['countresume']; ?>
</span>��Ͷ�ݼ���</div>
							</div>
							<?php if ($this->_vars['show']['tag_cn']): ?>
							<div class="welfare-box clearfix">
								<?php if (count((array)$this->_vars['show']['tag_cn'])): foreach ((array)$this->_vars['show']['tag_cn'] as $this->_vars['tagli']): ?>
								<div class="welfare-block f-left"><?php echo $this->_vars['tagli']; ?>
</div>
								<?php endforeach; endif; ?>
							</div></br>
							<?php endif; ?>
							<?php if ($this->_vars['show']['jobspecial_cn']): ?>
							<div class="welfare-box clearfix">
								<?php if (count((array)$this->_vars['show']['jobspecial_cn'])): foreach ((array)$this->_vars['show']['jobspecial_cn'] as $this->_vars['jobspecial_cnli']): ?>
								<div class="welfare-block f-left"><?php echo $this->_vars['jobspecial_cnli']; ?>
</div>
								<?php endforeach; endif; ?>
							</div>
							<?php endif; ?>
							<!-- ����ͼ��  ���� �ղ�-->
							<div class="app-job-item clearfix">
								<?php if ($this->_vars['show']['jobs_gq'] == 1): ?>
								<img src="<?php echo $this->_vars['QISHI']['site_template']; ?>
images/job_gq.gif" />
								<?php elseif ($this->_vars['show']['jobs_gq'] == 2): ?>
								<img src="<?php echo $this->_vars['QISHI']['site_template']; ?>
images/job_sx.gif" />
								<?php else: ?>
								<div class="apply-btn f-left"><a href="javascript:;" class="app-button app_jobs" style="display: block;line-height:34px;text-align: center;" jobs_id="<?php echo $this->_vars['show']['id']; ?>
">����ְλ</a></div>
								<a href="javascript:;" class="collect <?php if ($this->_vars['show']['check_fav'] == '1'): ?>done<?php endif; ?> f-left add_favorites">�ղ�</a>
								<?php endif; ?>
							</div>
						</div>
						<div class="job-block">
							<h3 class="c-left-title">ְλ��Ϣ</h3>
							<div class="job-info-detail clearfix">
								<div class="job-id-item f-left">���ʴ�����<span><?php echo $this->_vars['show']['wage_cn']; ?>
 <?php if ($this->_vars['show']['negotiable'] == 1): ?>(������)<?php else:  endif; ?></span></div>
								<div class="job-id-item f-left">ְλ���ʣ�<?php echo $this->_vars['show']['nature_cn']; ?>
</div>
								<div class="job-id-item f-left">����Ҫ��<?php if ($this->_vars['show']['age'] == "-"): ?>����<?php else:  echo $this->_vars['show']['age']; ?>
��<?php endif; ?></div>
								<div class="job-id-item f-left">��Ƹ������<?php echo $this->_vars['show']['amount']; ?>
��</div>
								<div class="job-id-item f-left">ְλ���<?php echo $this->_vars['show']['category_cn']; ?>
</div>
								<div class="job-id-item f-left">�Ա�Ҫ��<?php echo $this->_vars['show']['sex_cn']; ?>
</div>
								<div class="job-id-item f-left">�������У�<?php echo $this->_vars['show']['district_ch'];  if ($this->_vars['show']['sdistrict_ch']): ?>-<?php echo $this->_vars['show']['sdistrict_ch'];  endif; ?></div>
								<div class="job-id-item f-left">����������<?php if ($this->_vars['show']['category_cns']):  echo $this->_vars['show']['category_cns'];  endif; ?></div>
								<div class="job-id-item f-left">��ʼ�ϰࣺ<?php if ($this->_vars['show']['work_start']):  echo $this->_run_modifier($this->_vars['show']['work_start'], 'date_format', 'plugin', 1, "%Y-%m-%d %H:%M");  endif; ?></div>
								<div class="job-id-item f-left">�ϰ������<?php if ($this->_vars['show']['work_end']):  echo $this->_run_modifier($this->_vars['show']['work_end'], 'date_format', 'plugin', 1, "%Y-%m-%d %H:%M");  endif; ?></div>
								<div class="job-id-item f-left">ѧ��Ҫ��<?php echo $this->_vars['show']['education_cn']; ?>
</div>
								<div class="job-id-item f-left">�������飺<?php if ($this->_vars['show']['experience_cn']):  echo $this->_vars['show']['experience_cn'];  else: ?>����<?php endif; ?>&nbsp;<?php if ($this->_vars['show']['graduate'] == "1"): ?>(Ӧ�������)<?php endif; ?></div>
							</div>
						</div>
						<div class="job-block">
							<h3 class="c-left-title">ְλ����</h3>
							<div class="job-info-content clearfix">
								<?php echo $this->_vars['show']['contents']; ?>

							</div>
						</div>
						<div class="job-block">
							<h3 class="c-left-title">��ϵ��ʽ</h3>
							<div class="com-contact">
								<div id="jobs_contact"></div>
								<?php if ($this->_vars['company']['map_open'] == "1" && $this->_vars['company']['map_x'] && $this->_vars['company']['map_y']): ?>
								<div class="contact-map">
									<style>
										.map_l{width:726px;float: left;}
										.map_r{width:80px;float: right;padding-left: 20px;}
										.map_r li{margin:5px 0;}
										.map_r li label input {vertical-align:middle;}
										.map_bottom {margin:10px 0;}
										.map_bottom h4{display: inline-block;margin-right: 10px;}
										.map_bottom span {display: inline-block;margin-right: 10px;}
										.map_bottom .addr_inpt{width:180px;}
										.map_bottom span .bus_submit{cursor: pointer;margin-left:5px;}
									</style>
									<div class="company_map">
										<div class="map_l">
											<div style="width:100%;height:300px;border:1px #CCCCCC solid; margin:0 auto;" id="map"></div>
										</div>
										<div class="map_r">
											<b>�ܱ߲�ѯ</b>
											<ul>
												<li>
													<label for="hotel"><input type="checkbox" value="�Ƶ�" id="hotel"  class="serch"/>&nbsp;�Ƶ�</label>
												</li>
												<li>
													<label for="catering"><input type="checkbox" value="����" id="catering"  class="serch"/>&nbsp;����</label>
												</li>
												<li>
													<label for="supermarket"><input type="checkbox" value="����" id="supermarket" class="serch"/>&nbsp;����</label>
												</li>
												<li>
													<label for="bank"><input type="checkbox" value="����" id="bank" class="serch"/>&nbsp;����</label>
												</li>
												<li>
													<label for="hospital"><input type="checkbox" value="ҽԺ" id="hospital" class="serch"/>&nbsp;ҽԺ</label>
												</li>
												<li>
													<label for="scholl"><input type="checkbox" value="ѧУ" id="scholl" class="serch"/>&nbsp;ѧУ</label>
												</li>
												<li>
													<label for="bus"><input type="checkbox" value="����" id="bus" class="serch"/>&nbsp;����</label>
												</li>
											</ul>
										</div>
										<div class="clear"></div>
										<div class="map_bottom">
											<h4>��·��ѯ</h4>
											<span>��㣺<input type="text" name="start" value="" class="addr_inpt"/></span>
											<span>�յ㣺<input type="text" name="end" value="<?php echo $this->_vars['company']['address']; ?>
" class="addr_inpt" readonly/></span>
											<span><input type="button" value="������ѯ" class="bus_submit"/></span>
										</div>
										<div id="r-result" style="margin-bottom: 10px;"></div>
									</div>
									<script type="text/javascript">
										var map = new BMap.Map("map");
										var point = new BMap.Point(<?php echo $this->_vars['company']['map_x']; ?>
, <?php echo $this->_vars['company']['map_y']; ?>
);
										map.centerAndZoom(point, <?php echo $this->_vars['company']['map_zoom']; ?>
);
										map.setZoom(<?php echo $this->_vars['QISHI']['map_zoom']; ?>
);
										var opts = {type: BMAP_NAVIGATION_CONTROL_SMALL,anchor: BMAP_ANCHOR_TOP_RIGHT}
										map.addControl(new BMap.NavigationControl(opts)); //������
										// ������ע
										var qs_marker = new BMap.Marker(point);           
										map.addOverlay(qs_marker);
										// �ؼ��ּ���
										$(".serch").click(function(){
											var search_key = "["+getSelectVal()+"]";
											if(search_key=="[]"){
											map.centerAndZoom(point, <?php echo $this->_vars['company']['map_zoom']; ?>
);
											}else{
											map.centerAndZoom(new BMap.Point(<?php echo $this->_vars['company']['map_x']; ?>
, <?php echo $this->_vars['company']['map_y']; ?>
),11);
											var local = new BMap.LocalSearch(map, {
											renderOptions:{map: map},
											pageCapacity:5
											});
											local.searchInBounds(search_key, map.getBounds());
											}
										});
										// ��ȡ �ؼ��ַ���
										function getSelectVal() {
											var a_cn = new Array();
											$(":checkbox[checked][class='serch']").each(function(index, el) {
											var checkText = $(this).val();
											a_cn[index]='"'+checkText+'"';
											});
											return a_cn.join(",");
										}
										// ������ѯ
										$(".bus_submit").click(function() {
											var start =$("input[name=start]").val();
											var end =$("input[name=end]").val();
											if(start!="" && end!=""){
											var transit = new BMap.TransitRoute(map, {
											renderOptions: {map: map, panel: "r-result"}
											});
											transit.search(""+start+"", ""+end+"");
											}else{
											alert("������㣡");
											}
										});
									</script>
								</div>
								<?php endif; ?>
								<div class="job-warning">��ʾ����ӦƸ���������˵�λ���κ�������ӦƸ����ȡ���ö�����Υ�����ݣ�</div>
								<div class="job-bottom-share clearfix">
									<div class="share-box f-right">
										<div class="jubao"><a class="report_button" href="javascript:void(0);" jobs_id="<?php echo $_GET['id']; ?>
" jobs_name="<?php echo $this->_vars['show']['jobs_name']; ?>
" jobs_addtime="<?php echo $this->_vars['show']['addtime']; ?>
">�ٱ�</a></div>
										<div class="share-item clearfix">
											<span class="f-left">����</span>
											<div class="bdsharebuttonbox f-left">
												<a href="#" class="bds_more" data-cmd="more"></a>
												<a href="#" class="bds_qzone" data-cmd="qzone" title="����QQ�ռ�"></a>
												<a href="#" class="bds_tsina" data-cmd="tsina" title="��������΢��"></a>
												<a href="#" class="bds_tqq" data-cmd="tqq" title="������Ѷ΢��"></a>
												<a href="#" class="bds_renren" data-cmd="renren" title="����������"></a>
												<a href="#" class="bds_weixin" data-cmd="weixin" title="����΢��"></a>
											</div>
											<script>
												window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
											</script>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- н��ͳ�� -->
						<div class="com-left-block">
						<div class="salary">
							<div class="salary_box">
								<h3 class="c-left-title">н��ſ�</h3>
								<div class="s_content">
									<div class="salary_left">
										<div><?php echo $this->_vars['show']['jobs_name']; ?>
</div>
										<p><?php echo $this->_vars['show']['district_ch'];  if ($this->_vars['show']['sdistrict_ch']): ?> - <?php echo $this->_vars['show']['sdistrict_ch'];  endif; ?></p>
										<p>ƽ�����룺Լ <span><?php echo $this->_vars['show']['salary']['value']; ?>
</span> Ԫ</p>
									</div>
									<div class="salary_right">
										<div class="value">
											<div class="blue_bar" style="width: <?php echo $this->_vars['show']['salary']['px']; ?>
;"></div>
											<div class="number"><?php echo $this->_vars['show']['salary']['value']; ?>
</div>
										</div>
									</div>
									<div class="clear"></div>
								</div>
								<div class="salary_bot">
									<div class="tip">������Ϊƽ��ֵ��ȡ�Ա�վ�������������������ο���</div>
									<div class="data">������<?php echo $this->_run_modifier(time(), 'date_format', 'plugin', 1, '%Y-%m-%d'); ?>
</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
						</div>
						<!-- н��ͳ�� ���� -->
						<div class="com-left-block">
						<h3 class="c-left-title">����ְλ</h3>
						<div class="company-jobs-list clearfix">
							<?php echo tpl_function_qishi_jobs_list(array('set' => $this->_run_modifier("�б���:jobs,��ַ�:...,ְλ������:14,��ʾ��Ŀ:8,���ģ��:" . $_GET['style'] . ",��ԱUID:", 'cat', 'plugin', 1, $this->_vars['show']['uid'])), $this);?>
			  				<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['list']): ?>
							<div class="c-jobs-item f-left">
								<div class="job-name"><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
" target="_blank"><?php echo $this->_vars['list']['jobs_name']; ?>
</a></div>
								<div class="job-info"><span><?php echo $this->_vars['list']['education_cn']; ?>
</span> | <span><?php echo $this->_vars['list']['experience_cn']; ?>
</span> | <span><?php if ($this->_vars['list']['age'] == "-"): ?>����<?php else:  echo $this->_vars['list']['age']; ?>
��<?php endif; ?></span></div>
								<div class="job-pay"><?php echo $this->_vars['list']['wage_cn']; ?>
</div>
								<div class="job-area"><?php echo $this->_vars['list']['district_cn']; ?>
</div>
							</div>
							<?php endforeach; endif; ?>
						</div>
						<div class="job-all clearfix"><a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
jobs/jobs-list.php" class="f-right">ȫ��ְλ>></a></div>
					</div>
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
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/login.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
data/cache_classify.js" type='text/javascript' charset="utf-8"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.ajax.personal.selectlayer.js" type='text/javascript' language="javascript"></script>
<script type="text/javascript">
	/*
		���ٴ��� ���� js start
	*/
	$("form[id=creat_form]").submit(function(e) {
	e.preventDefault();
		// ����
		if ($("#fullname").val()=="")
		{			
			$(".quick-error").html("����д������");	
			$(".quick-error").show();
			return false;
		}
		// ���ѧ�� 
		if($("#education").val()=="")
		{	
			$(".quick-error").html("��ѡ�����ѧ����");	
			$(".quick-error").show();
			return false;
		}
		//��������
		if($("#experience").val()=="")
		{
			$(".quick-error").html("��ѡ�������飡");	
			$(".quick-error").show();
			return false;
		}
		// ����ְλ
		if($("#intention_jobs").val()=="")
		{
			$(".quick-error").html("��ѡ������ְλ��");	
			$(".quick-error").show();
			return false;
		}
		// ������ҵ
		if($("#trade").val()=="")
		{
			$(".quick-error").html("��ѡ��������ҵ��");	
			$(".quick-error").show();
			return false;
		}
		// ��������
		if($("#district").val()=="")
		{
			$(".quick-error").html("��ѡ������������");	
			$(".quick-error").show();
			return false;
		}
		// ����н��
		if($("#wage").val()=="")
		{
			$(".quick-error").html("��ѡ������н�ʣ�");	
			$(".quick-error").show();
			return false;
		}
		// �ֻ���
		if($("#telephone").val()=="")
		{
			$(".quick-error").html("����д�ֻ��ţ�");	
			$(".quick-error").show();
			return false;
		}
		$("#telephone").change(function(event) {
			var mobile= $(this).val();
			$.post("<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_apply_jobs_creat_resume.php",{'mobile':mobile,"act":"check_mobile"}, function(data, textStatus, xhr) {
				if(data!="ok")
				{
					$(".quick-error").html(data);	
					$(".quick-error").show();
					return false;
				}
			});
		});
		// �ֻ���֤��
		if($("#telephone_code").val()=="")
		{
			$(".quick-error").html("����д�ֻ���֤�룡");	
			$(".quick-error").show();
			return false;
		}
		$("#telephone_code").change(function(event) {
			var mobile =$("#telephone").val();
			var code = $(this).val();
			$.post("<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_apply_jobs_creat_resume.php",{'mobile':mobile,'code':code,"act":"check_code"}, function(data, textStatus, xhr) {
				if(data!="ok")
				{
					$(".quick-error").html(data);	
					$(".quick-error").show();
					return false;
				}
			});
		});
		//Ŀǰ״̬ 
		if($("#current").val()=="")
		{
			$(".quick-error").html("��ѡ��Ŀǰ״̬��");	
			$(".quick-error").show();
			return false;
		}
		$(".quick-error").hide();
		$(".quick-submit-btn").val("�����ύ");
		var fullname =$("#fullname").val();
		var sex =$("input[name=sex]").val();
		var sex_cn =$("input[name=sex]").attr('data');
		var education =$("#education").val();
		var education_cn =$("#education").attr('data');
		var experience =$("#experience").val();
		var experience_cn =$("#experience").attr('data');
		var intention_jobs =$("#intention_jobs").val();
		var intention_jobs_id =$("#intention_jobs_id").val();
		var district =$("#district").val();
		var district_cn =$("#district_cn").val();
		var wage =$("#wage").val();
		var wage_cn =$("#wage").attr('data');
		var telephone =$("#telephone").val();
		var current =$("#current").val();
		var current_cn =$("#current").attr('data');
		var jobsid= $("#jobsid").val();
		$.post("<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_apply_jobs_creat_resume.php", {'fullname':fullname,'sex':sex,'sex_cn':sex_cn,'education':education,'education_cn':education_cn,'experience':experience,'intention_jobs':intention_jobs,'intention_jobs_id':intention_jobs_id,'district':district,'district_cn':district_cn,'wage':wage,'wage_cn':wage_cn,'telephone':telephone,'current':current,'current_cn':current_cn,'jobsid':jobsid,'act':'create_resume'},
		 	function (data,textStatus)
		 	 {
		 	 	alert(data);
		 	 	window.location.reload();
		 	 })		
	});
	// ���Ͷ���
	$('#codeBtn').on('click', function() {
		// ���Ͷ���
		var mobile =$("#telephone").val();
		$.post("<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_apply_jobs_creat_resume.php",{'mobile':mobile,"act":"send_code"}, function(data, textStatus, xhr) {
			if(data!="ok")
			{
				$(".quick-error").html(data);	
				$(".quick-error").show();
				return false;
			}
			else
			{
				showTime(100);
			}
		});
	});
	// ����ѡ��
	$('.quick-drop').on('click', function(e) {
		$(this).find('.quick-drop-list').slideToggle('fast');
		$(this).toggleClass('has-drop');
		$(document).one('click', function() {
			$('.quick-drop-list').stop().slideUp('fast');
			$('.quick-drop').removeClass('has-drop');
		})
		e.stopPropagation();
		$(".quick-drop").not($(this)).removeClass('has-drop').find('.quick-drop-list').hide();
	});
	$('.quick-drop-list').on('click', function(e) {
		e.stopPropagation();
	})
	$('.quick-drop-list a').on('click', function() {
		$(this).parents('.quick-drop-list').prevUntil().find('span').css('color', '#666').text($(this).html());
		$(this).parents('.quick-drop-list').hide().prev('input').val($(this).attr('id'));
		$(this).parents('.quick-drop-list').hide().prev('input').attr('data', $(this).attr('title'));
		$('.quick-drop').removeClass('has-drop');
	})

  // �û���¼
  $(".quick-login").live('click',function(){

    jQuery.ajax({
        url: '<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_ajax_login.php',
        success: function (data) {
          $(".quick-reg-dialog").html(data);
        }
    });
  });
	function updateP(num, time) {
		if(num == time) {
			$('#codeBtn').val('���·���').prop('disabled', false).removeClass('disabled');
		}else{
			var printnr = time - num;
			$('#codeBtn').val(printnr +"�����·���");
		}
	}
	function showTime(time){
		$('#codeBtn').prop('disabled', true).addClass('disabled');

		for (var i = 0; i <= time; i++) {
			window.setTimeout("updateP("+ i +","+time+")", i*1000);
		};
	};
</script>