<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_jobs_list.php'); $this->register_function("qishi_jobs_list", "tpl_function_qishi_jobs_list",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_get_classify.php'); $this->register_function("qishi_get_classify", "tpl_function_qishi_get_classify",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_pageinfo.php'); $this->register_function("qishi_pageinfo", "tpl_function_qishi_pageinfo",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 17:32 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" /><?php echo tpl_function_qishi_pageinfo(array('set' => "�б���:page,����:QS_jobs"), $this);?>
<title><?php echo $this->_vars['page']['title']; ?>
 - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
<meta name="description" content="<?php echo $this->_vars['page']['description']; ?>
">
<meta name="keywords" content="<?php echo $this->_vars['page']['keywords']; ?>
">
<meta name="author" content="��ʿCMS" />
<meta name="copyright" content="74cms.com" />
<meta name="renderer" content="webkit"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/jobs.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.js" type='text/javascript'></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.jobs-search.js" type='text/javascript'></script>
<script src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
data/cache_classify.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.autocomplete.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		allaround("<?php echo $this->_vars['QISHI']['site_dir']; ?>
");
	    // ְλ���������� 
		job_filldata("#job_list", QS_jobs_parent, QS_jobs, "#result-list-job", "#aui_outer_job", "#job_result_show", "#jobcategory", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");
		 // ������ҵ�������
		trade_filldata("#trad_list", QS_trade, "#aui_outer", "#result-list-trade", "#trade_result_show", "#trade", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");
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
<div class="page_location link_bk">
��ǰλ�ã�<a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
">��ҳ</a>&nbsp;>&nbsp;<a href="<?php echo $this->_run_modifier("QS_jobs", 'qishi_url', 'plugin', 1); ?>
">��Ƹ��Ϣ</a>
</div>
<div class="container">
	<div id="filterSearch">
		<div class="search-tab clearfix">
			<a href="<?php echo $this->_run_modifier("QS_jobslist", 'qishi_url', 'plugin', 1); ?>
" class="s-tab-item f-left active">�߼�����</a>
			<a href="<?php echo $this->_run_modifier("QS_street", 'qishi_url', 'plugin', 1); ?>
" class="s-tab-item f-left">��·����</a>
			<a href="<?php echo $this->_run_modifier("QS_map,id:1", 'qishi_url', 'plugin', 1); ?>
" class="s-tab-item f-left">��ͼ����</a>
			<a href="<?php echo $this->_run_modifier("QS_view_jobs", 'qishi_url', 'plugin', 1); ?>
" class="s-tab-item f-left">�������ְλ</a>
		</div>
		<div class="top-search clearfix">
			<div class="t-search-box f-left">
				<div class="type-input-box f-left">
					<div class="key">������ؼ���</div>
					<input type="text" name="key" id="key" style="display:none;"/>
					<input name="jobcategory" id="jobcategory" type="hidden" value="" />
					<input name="qgdistrict" id="qgdistrict" type="hidden" value="" />
					<input name="trade" id="trade" type="hidden" value="" />
					<input name="citycategory" id="citycategory" type="hidden" value="" data-code="<?php echo $this->_vars['QISHI']['districtid']; ?>
" />
					<input type="hidden" name="wage" id="wage" value="">
					<input type="hidden" name="jobtag" id="jobtag" value="">
					<input type="hidden" name="education" id="education" value="">
					<input type="hidden" name="experience" id="experience" value="">
					<input type="hidden" name="settr" id="settr" value="">
					<input type="hidden" name="nature" id="nature" value="">
					<input type="hidden" name="scale" id="scale" value="">
					<input type="hidden" name="sort" id="sort" value="">
					<input type="hidden" name="page" id="page" value="">
				</div>
			</div>
			<div class="t-search-btn f-left"><input type="button" detype="QS_jobslist" id="searcnbtn" value="��&nbsp;��" /></div>
		</div>
		<div class="fliter-wrap fwnob">
			<div class="filter-drop clearfix">
				<div class="filter-item f-left">
					<div class="choose-item">
						<div class="choose-control">
							<span class="cc-default" id="job_result_show">ѡ��ְλ���</span><i class="choose-icon"></i>
							<!-- ְλ��𵯳��� -->
							<div class="aui_outer" id="aui_outer_job">
								<table class="aui_border">
									<tbody>
										<tr>
											<td class="aui_c">
												<div class="aui_inner">
													<table class="aui_dialog">
														<tbody>
															<tr>
																<td class="aui_main">
																	<div class="aui_content" style="padding: 0px;">
																		<div class="LocalDataMultiC">
																			<div class="selector-header"><span class="selector-title">ְλѡ��</span><div></div><span id="jb-selector-save" class="selector-save">ȷ��</span><span class="selector-close">X</span><div class="clear"></div></div>

																			<div class="data-row-head"><div class="data-row"><div class="data-row-side">���ѡ <strong class="text-warning">3</strong> ��&nbsp;&nbsp;��ѡ <strong id="ars" class="text-warning">0</strong> ��</div><div id="result-list-job" class="result-list data-row-side-ra"></div><div class="clear"></div></div><div class="cla"></div></div>
																			<div class="data-row-list data-row-main" id="job_list">
																				<!-- �б����� -->
																			</div>
																		</div>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- ְλ��𵯳��� End-->
						</div>
					</div>
				</div>
				
				<div class="filter-item f-left">
					<div class="choose-item">
						<div class="choose-control">
							<span class="cc-default" id="trade_result_show">ѡ����ҵ���</span><i class="choose-icon"></i>
							<!-- ������ҵ������ -->
							<div class="aui_outer" id="aui_outer">
								<table class="aui_border">
									<tbody>
										<tr>
											<td class="aui_c">
												<div class="aui_inner">
													<table class="aui_dialog">
														<tbody>
															<tr>
																<td class="aui_main">
																	<div class="aui_content">
																		<div class="items jquery-localdata">
																			<div class="selector-header"><span class="selector-title">��ҵѡ��</span><div></div><span id="tr-selector-save" class="selector-save">ȷ��</span><span class="selector-close">X</span><div class="clear"></div></div>

																			<div class="data-row-head"><div class="data-row"><div class="data-row-side">���ѡ <strong class="text-warning">3</strong> ��&nbsp;&nbsp;��ѡ <strong id="arstrade" class="text-warning">0</strong> ��</div><div id="result-list-trade" class="result-list data-row-side-ra"></div></div><div class="cla"></div></div>
																			<div class="item-table">
																				<table class="options-table options-table-7">
																					<tbody class="item-list"><tr><td class="bno"><table><tbody id="trad_list">
																						<!-- �б����� -->
																					</tbody></table></td></tr>
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- ������ҵ������ End-->
						</div>
					</div>
				</div>
			</div>
			<div id="subsiteBox" data-txt="��������,<?php if ($this->_vars['QISHI']['districtid']): ?>��������<?php else: ?>��������<?php endif; ?>"></div>
			<div class="filter-list-wrap clearfix">
				<div class="fl-type f-left">ְλ��н��</div>
				<div class="fl-content r-choice f-left">
					<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:wage,����:QS_wage,��ʾ��Ŀ:100"), $this);?>
					<?php if (count((array)$this->_vars['wage'])): foreach ((array)$this->_vars['wage'] as $this->_vars['list']): ?>
					<div class="fl-content-li" type="wage" code="<?php echo $this->_vars['list']['id']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</div>
					<?php endforeach; endif; ?>
				</div>
			</div>
			<div class="filter-list-wrap clearfix">
				<div class="fl-type f-left">�������㣺</div>
				<div class="fl-content f-left forShowMore" id="fliterMore">
					<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:jobtag,����:QS_jobtag,��ʾ��Ŀ:100"), $this);?>
					<?php if (count((array)$this->_vars['jobtag'])): foreach ((array)$this->_vars['jobtag'] as $this->_vars['list']): ?>
					<div class="fl-content-li" type="jobtag" code="<?php echo $this->_vars['list']['id']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</div>
					<?php endforeach; endif; ?>
					<a href="javascript:;" class="show-more">չ��</a>
				</div>
			</div>
			<div class="filter-list-wrap clearfix">
				<div class="fl-type f-left">����ɸѡ��</div>
				<div class="fl-content f-left">
					<div class="saixuan">
						<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:c_education,����:QS_education"), $this);?>
						<div class="saixuans">
							<div class="line"></div>
							<?php if (count((array)$this->_vars['c_education'])): foreach ((array)$this->_vars['c_education'] as $this->_vars['list']): ?>
							<a defvalue="<?php echo $this->_vars['list']['id']; ?>
" type="education" href="javascript:;"><?php echo $this->_vars['list']['categoryname']; ?>
</a>
							<?php endforeach; endif; ?>
						</div>
						ѧ��Ҫ��
					</div>
					<div class="saixuan">
						<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:c_experience,����:QS_experience"), $this);?>
						<div class="saixuans">
							<div class="line"></div>
							<?php if (count((array)$this->_vars['c_experience'])): foreach ((array)$this->_vars['c_experience'] as $this->_vars['list']): ?>
							<a defvalue="<?php echo $this->_vars['list']['id']; ?>
" type="experience" href="javascript:;"><?php echo $this->_vars['list']['categoryname']; ?>
</a>
							<?php endforeach; endif; ?>
						</div>
						��������
					</div>
					<div class="saixuan">
						<div class="saixuans">
							<div class="line"></div>
							<a defvalue="3" type="settr" href="javascript:;">3����</a>
							<a defvalue="7" type="settr" href="javascript:;">7����</a>
							<a defvalue="15" type="settr" href="javascript:;">15����</a>
							<a defvalue="30" type="settr" href="javascript:;">30����</a>
						</div>
						����ʱ��
					</div>
					<div class="saixuan">
						<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:c_jobsnature,����:QS_jobs_nature"), $this);?>
						<div class="saixuans">
							<div class="line"></div>
							<?php if (count((array)$this->_vars['c_jobsnature'])): foreach ((array)$this->_vars['c_jobsnature'] as $this->_vars['list']): ?>
							<a defvalue="<?php echo $this->_vars['list']['id']; ?>
" type="nature" href="javascript:;"><?php echo $this->_vars['list']['categoryname']; ?>
</a>
							<?php endforeach; endif; ?>
						</div>
						��������
					</div>
					<div class="saixuan">
						<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:c_scale,����:QS_scale"), $this);?>
						<div class="saixuans">
							<div class="line"></div>
							<?php if (count((array)$this->_vars['c_scale'])): foreach ((array)$this->_vars['c_scale'] as $this->_vars['list']): ?>
							<a defvalue="<?php echo $this->_vars['list']['id']; ?>
" type="scale" href="javascript:;"><?php echo $this->_vars['list']['categoryname']; ?>
</a>
							<?php endforeach; endif; ?>
						</div>
						��ҵ��ģ
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="data-box">
		<div class="data-title">
			<h3>�Ƽ�ְλ</h3>
			<a href="<?php echo $this->_run_modifier("QS_helplist,id:10", 'qishi_url', 'plugin', 1); ?>
"  target="_blank" class="right-link">������Ƹ��λ���������������</a>
		</div>
		<div class="job-normal-list clearfix">
			<?php echo tpl_function_qishi_jobs_list(array('set' => "�б���:jobslist,��ʾ��Ŀ:30,��ַ�:...,ְλ������:6,��ҵ������:16,�Ƽ�:1,����:rtime>desc"), $this);?>
			<?php if (count((array)$this->_vars['jobslist'])): foreach ((array)$this->_vars['jobslist'] as $this->_vars['list']): ?>
			<div class="job-normal-item f-left">
				<div class="job-info"><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
" target="_blank"><?php echo $this->_vars['list']['jobs_name']; ?>
</a><span class="small-info"><?php echo $this->_vars['list']['district_cn']; ?>
</span><span class="small-info"><?php echo $this->_run_modifier($this->_vars['list']['refreshtime'], 'date_format', 'plugin', 1, '%m-%d'); ?>
</span></div>
				<div class="job-com-pay"><a href="<?php echo $this->_vars['list']['company_url']; ?>
"  target="_blank" class="j-com"><?php echo $this->_vars['list']['companyname']; ?>
</a>|<span class="j-pay"><?php echo $this->_vars['list']['wage_cn']; ?>
</span></div>
			</div>
			<?php endforeach; endif; ?>
		</div>
	</div>
	<div class="data-box">
		<div class="data-title">
			<h3>������Ƹ</h3>
			<a href="<?php echo $this->_run_modifier("QS_helplist,id:10", 'qishi_url', 'plugin', 1); ?>
"  target="_blank" class="right-link">������Ƹ��λ���������������</a>
		</div>
		<div class="job-normal-list clearfix">
			<?php echo tpl_function_qishi_jobs_list(array('set' => "�б���:jobslist,��ʾ��Ŀ:30,��ַ�:...,ְλ������:6,��ҵ������:16,������Ƹ:1,����:rtime>desc"), $this);?>
			<?php if (count((array)$this->_vars['jobslist'])): foreach ((array)$this->_vars['jobslist'] as $this->_vars['list']): ?>
			<div class="job-normal-item f-left">
				<div class="job-info"><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
" target="_blank"><?php echo $this->_vars['list']['jobs_name']; ?>
</a><span class="small-info"><?php echo $this->_vars['list']['district_cn']; ?>
</span><span class="small-info"><?php echo $this->_run_modifier($this->_vars['list']['refreshtime'], 'date_format', 'plugin', 1, '%m-%d'); ?>
</span></div>
				<div class="job-com-pay"><a href="<?php echo $this->_vars['list']['company_url']; ?>
"  target="_blank" class="j-com"><?php echo $this->_vars['list']['companyname']; ?>
</a>|<span class="j-pay"><?php echo $this->_vars['list']['wage_cn']; ?>
</span></div>
			</div>
			<?php endforeach; endif; ?>
		</div>
	</div>
	<div class="data-box">
		<div class="data-title">
			<h3>����ְλ</h3>
			<a href="<?php echo $this->_run_modifier("QS_jobslist", 'qishi_url', 'plugin', 1); ?>
" target="_blank" class="right-link">����>></a>
		</div>
		<div class="job-normal-list clearfix">
			<?php echo tpl_function_qishi_jobs_list(array('set' => "�б���:jobslist,��ʾ��Ŀ:30,��ַ�:...,ְλ������:6,��ҵ������:16,����:rtime>desc"), $this);?>
			<?php if (count((array)$this->_vars['jobslist'])): foreach ((array)$this->_vars['jobslist'] as $this->_vars['list']): ?>
			<div class="job-normal-item f-left">
				<div class="job-info"><a href="<?php echo $this->_vars['list']['jobs_url']; ?>
" target="_blank"><?php echo $this->_vars['list']['jobs_name']; ?>
</a><span class="small-info"><?php echo $this->_vars['list']['district_cn']; ?>
</span><span class="small-info"><?php echo $this->_run_modifier($this->_vars['list']['refreshtime'], 'date_format', 'plugin', 1, '%m-%d'); ?>
</span></div>
				<div class="job-com-pay"><a href="<?php echo $this->_vars['list']['company_url']; ?>
" target="_blank" class="j-com"><?php echo $this->_vars['list']['companyname']; ?>
</a>|<span class="j-pay"><?php echo $this->_vars['list']['wage_cn']; ?>
</span></div>
			</div>
			<?php endforeach; endif; ?>
		</div>
	</div>
</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>
