<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_jobs_list.php'); $this->register_function("qishi_jobs_list", "tpl_function_qishi_jobs_list",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.cat.php'); $this->register_modifier("cat", "tpl_modifier_cat",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_company_show.php'); $this->register_function("qishi_company_show", "tpl_function_qishi_company_show",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 18:21 CST */  echo tpl_function_qishi_company_show(array('set' => "�б���:company,��ҵID:GET[id],��ҵ���ܳ���:150"), $this);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title><?php echo $this->_vars['company']['companyname']; ?>
 - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
<meta name="description" content="<?php echo $this->_vars['company']['contents']; ?>
,��˾���">
<meta name="keywords" content="<?php echo $this->_vars['company']['companyname']; ?>
,��˾���">
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
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $this->_vars['QISHI']['map_ak']; ?>
"></script>
<script>
	$(document).ready(function() {
		if ($('.company-info-wrap div').height() < 187) {
			$('.c-info-more').hide();
		};
		$('.c-info-more').toggle(function(){
			$(this).prev().css({'max-height':'none'});
			$(this).addClass('upup');
		}, function(){
			$(this).prev().css({'max-height':'187px'});
			$(this).removeClass('upup');
		});
		var company_id="<?php echo $this->_vars['company']['id']; ?>
";
		var tsTimeStamp= new Date().getTime();
		$.get("<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/ajax_contact.php", { "id": company_id,"time":tsTimeStamp,"act":"company_contact"},
			function (data,textStatus)
			 {			
				$("#company_contact").html(data);
			 }
		);
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
		// ����鿴��ͼ
		$(".img_big_show").click(function() {
			dialog({
				title: '��ҵ���',
			    content: $("#focus")
			}).showModal();
		});
	});
</script>
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
" class="c-control-item f-left active">��ҵ��ҳ</a>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companyinfo,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left">��˾����</a>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companyjobs,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left">��Ƹְλ</a>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companynews,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left">���Ŷ�̬</a>
						<?php if ($this->_vars['QISHI']['open_commentaudit'] == "1"): ?>
						<a href="<?php echo $this->_run_modifier($this->_run_modifier($this->_run_modifier($this->_run_modifier("QS_companycomment,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'cat', 'plugin', 1, "-style:"), 'cat', 'plugin', 1, $_GET['style']), 'qishi_url', 'plugin', 1); ?>
" class="c-control-item f-left">����</a>
						<?php endif; ?>
					</div>
					<div class="company-info-wrap">
						<div>
						<?php echo $this->_vars['company']['company_profile']; ?>

						</div>
						<a href="javascript:;" class="c-info-more" title="�鿴ȫ��"></a>
					</div>
					<?php echo tpl_function_qishi_jobs_list(array('set' => $this->_run_modifier("�б���:jobs,��ַ�:...,ְλ������:10,��ҳ��ʾ:1,��ʾ��Ŀ:8,�б�ҳ:QS_companyjobs,��������:68,���ģ��:" . $_GET['style'] . ",��ԱUID:", 'cat', 'plugin', 1, $this->_vars['company']['uid'])), $this);?>
					<?php if ($this->_vars['jobs']): ?>
					<div class="com-left-block">
						<h3 class="c-left-title">ְλ�б�</h3>
						<div class="company-jobs-list clearfix">
							<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['list']): ?>
							<div class="c-jobs-item f-left">
								<div class="job-name"><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
" title="<?php echo $this->_vars['list']['jobs_name_']; ?>
"><?php echo $this->_vars['list']['jobs_name']; ?>
</a></div>
								<div class="job-info"><span><?php echo $this->_vars['list']['education_cn']; ?>
</span> | <span><?php echo $this->_vars['list']['experience_cn']; ?>
</span> | <span><?php echo $this->_run_modifier($this->_vars['list']['refreshtime'], 'date', 'plugin', 1, "m-d"); ?>
</span></div>
								<div class="job-pay"><?php echo $this->_vars['list']['wage_cn']; ?>
</div>
								<div class="job-area"><?php echo $this->_vars['list']['district_cn']; ?>
</div>
							</div>
							<?php endforeach; endif; ?>
						</div>
						<div class="job-all clearfix"><a href="<?php echo $this->_run_modifier($this->_run_modifier("QS_companyjobs,id:", 'cat', 'plugin', 1, $this->_vars['company']['id']), 'qishi_url', 'plugin', 1); ?>
" class="f-right">ȫ��ְλ>></a></div>
					</div>
					<?php endif; ?>
					<div class="com-left-block">
						<h3 class="c-left-title">��ϵ��ʽ</h3>
						<div class="com-contact">
							<div id="company_contact"></div>
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
										<a target="_blank" href="http://api.map.baidu.com/marker?location=<?php echo $this->_vars['company']['map_y']; ?>
,<?php echo $this->_vars['company']['map_x']; ?>
&title=<?php echo $this->_vars['company']['companyname']; ?>
&content=<?php echo $this->_vars['company']['address']; ?>
&output=html" class="goToBdMap BMap_noprint anchorTR" style="position: absolute; z-index: 10;margin:10px;background-color: #fff;padding:2px;">�鿴������ͼ����������ѯ��</a>
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