<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_link.php'); $this->register_function("qishi_link", "tpl_function_qishi_link",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_resume_list.php'); $this->register_function("qishi_resume_list", "tpl_function_qishi_resume_list",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_get_classify.php'); $this->register_function("qishi_get_classify", "tpl_function_qishi_get_classify",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_pageinfo.php'); $this->register_function("qishi_pageinfo", "tpl_function_qishi_pageinfo",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 17:32 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" /><?php echo tpl_function_qishi_pageinfo(array('set' => "�б���:page,����:QS_resume"), $this);?>
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
css/resume.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.js" type='text/javascript' ></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.resume-search.js" type='text/javascript'></script>
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
		// רҵ����������
		major_filldata("#major_list", QS_major_parent, QS_major, "#major_tabnav", "#aui_outer_major", "#result-list-major", "#major_result_show", "#major", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
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
">��ҳ</a>&nbsp;>&nbsp;<a href="<?php echo $this->_run_modifier("QS_resume", 'qishi_url', 'plugin', 1); ?>
">��ְ��Ϣ</a>
</div>
<div class="container">
	<div id="filterSearch">
		<div class="search-tab clearfix">
			<a href="<?php echo $this->_run_modifier("QS_resumelist", 'qishi_url', 'plugin', 1); ?>
" class="s-tab-item f-left active">��������</a>
			<a href="<?php echo $this->_run_modifier("QS_resumewatchedlist", 'qishi_url', 'plugin', 1); ?>
" class="s-tab-item f-left">������ļ���</a>
		</div>
		<div class="top-search clearfix">
			<div class="t-search-box f-left">
				<div class="type-input-box f-left">
					<div class="key">������ؼ���</div>
					<input type="text" name="key" id="key" style="display:none;"/>
					<input name="jobcategory" id="jobcategory" type="hidden" value="" />
					<input name="trade" id="trade" type="hidden" value="" />
					<input name="citycategory" id="citycategory" type="hidden" value="" data-code="<?php echo $this->_vars['QISHI']['districtid']; ?>
" />
					<input name="major" id="major" type="hidden" value="" />
					<input name="experience" id="experience" type="hidden" value=""/>
					<input name="resumetag" id="resumetag" type="hidden" value=""/>
					<input name="education" id="education" type="hidden" value=""/>
					<input name="sex" id="sex" type="hidden" value=""/>
					<input name="photo" id="photo" type="hidden" value=""/>
					<input name="talent" id="talent" type="hidden" value=""/>
					<input name="settr" id="settr" type="hidden" value=""/>
				</div>
			</div>
			<div class="t-search-btn f-left"><input type="button" detype="QS_resumelist" id="searcnbtn" value="��&nbsp;��" /></div>
		</div>
		<div class="fliter-wrap" style="border-bottom:none;">
			<div class="filter-drop clearfix">
				<div class="filter-item f-left">
					<div class="choose-item">
						<div class="choose-control">
							<span class="cc-default" id="job_result_show">ѡ������ְλ</span><i class="choose-icon"></i>
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

																			<div class="data-row-head"><div class="data-row"><div class="data-row-side">���ѡ <strong class="text-warning">3</strong> ��&nbsp;&nbsp;��ѡ <strong id="ars" class="text-warning">0</strong> ��</div><div id="result-list-job" class="result-list data-row-side-ra"></div></div><div class="cla"></div></div>
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
							<span class="cc-default" id="trade_result_show">ѡ��������ҵ</span><i class="choose-icon"></i>
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
				<div class="filter-item f-left">
					<div class="choose-item">
						<div class="choose-control">
							<span class="cc-default" id="major_result_show">ѡ��רҵ���</span><i class="choose-icon"></i>
							<!-- רҵ��𵯳��� -->
							<div class="aui_outer" style="left:-445px;" id="aui_outer_major">
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
																			<div class="selector-header"><span class="selector-title">רҵ���</span><div></div><span id="mj-selector-save" class="selector-save">ȷ��</span><span class="selector-close">X</span><div class="clear"></div></div>

																			<div class="data-row-head"><div class="data-row"><div class="data-row-side">���ѡ <strong class="text-warning">3</strong> ��&nbsp;&nbsp;��ѡ <strong id="arsmajor" class="text-warning">0</strong> ��</div><div id="result-list-major" class="result-list data-row-side-ra"></div></div><div class="cla"></div></div>
																			<ul class="tabnav" id="major_tabnav"></ul>

																			<div class="item-table majorbb">
																				<table class="options-table options-table-7">
																					<tbody class="item-list"><tr><td class="bno"><table id="major_list"></table></td></tr>
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
							<!-- רҵ��𵯳��� End-->
						</div>
					</div>
				</div>
			</div>
			<div id="subsiteBox" data-txt="�������,<?php if ($this->_vars['QISHI']['districtid']): ?>�������<?php else: ?>��������<?php endif; ?>"></div>
			<div class="filter-list-wrap clearfix">
				<div class="fl-type f-left">�������飺</div>
				<div class="fl-content r-choice f-left">
					<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:experience,����:QS_experience,��ʾ��Ŀ:100"), $this);?>
					<?php if (count((array)$this->_vars['experience'])): foreach ((array)$this->_vars['experience'] as $this->_vars['list']): ?>
					<div class="fl-content-li" type="experience" code="<?php echo $this->_vars['list']['id']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</div>
					<?php endforeach; endif; ?>
				</div>
			</div>
			<div class="filter-list-wrap clearfix">
				<div class="fl-type f-left">�س���ǩ��</div>
				<div class="fl-content f-left forShowMore" id="fliterMore">
					<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:resumetag,����:QS_resumetag,��ʾ��Ŀ:100"), $this);?>
					<?php if (count((array)$this->_vars['resumetag'])): foreach ((array)$this->_vars['resumetag'] as $this->_vars['list']): ?>
					<div class="fl-content-li" type="resumetag" code="<?php echo $this->_vars['list']['id']; ?>
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
						���ѧ��
					</div>
					<div class="saixuan">
						<div class="saixuans">
							<div class="line"></div>
							<a defvalue="1" type="sex" href="javascript:;">��</a>
							<a defvalue="2" type="sex" href="javascript:;">Ů</a>
						</div>
						�Ա�Ҫ��
					</div>
					<div class="saixuan">
						<div class="saixuans">
							<div class="line"></div>
							<a defvalue="1" type="photo" href="javascript:;">��</a>
							<a defvalue="0" type="photo" href="javascript:;">��</a>
						</div>
						������Ƭ
					</div>
					<div class="saixuan">
						<div class="saixuans">
							<div class="line"></div>
							<a defvalue="1" type="talent" href="javascript:;">��ͨ</a>
							<a defvalue="2" type="talent" href="javascript:;">�߼�</a>
						</div>
						�����ȼ�
					</div>
					<div class="saixuan">
						<?php echo tpl_function_qishi_get_classify(array('set' => "�б���:c_scale,����:QS_scale"), $this);?>
						<div class="saixuans">
							<div class="line"></div>
							<a defvalue="3" type="settr" href="javascript:;">3����</a>
							<a defvalue="7" type="settr" href="javascript:;">7����</a>
							<a defvalue="15" type="settr" href="javascript:;">15����</a>
							<a defvalue="30" type="settr" href="javascript:;">30����</a>
						</div>
						����ʱ��
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="data-box">
		<div class="data-title">
			<h3>��Ƭ����</h3>
			<a href="<?php echo $this->_run_modifier("QS_resumelist,photo:1", 'qishi_url', 'plugin', 1); ?>
" target="_blank" class="right-link">����>></a>
		</div>
		<div class="photo-resumes-list clearfix">
			<?php echo tpl_function_qishi_resume_list(array('set' => "�б���:resume,��ʾ��Ŀ:14,��Ƭ:1,����ְλ����:18,��ַ�:...,����:rtime>desc"), $this);?>
			<?php if (count((array)$this->_vars['resume'])): foreach ((array)$this->_vars['resume'] as $this->_vars['list']): ?>
			<div class="photo-resume-item f-left" onclick="javascript:window.location.href='<?php echo $this->_vars['list']['resume_url']; ?>
'">
				<div class="photo-box">
					<div class="avater-img"><img src="<?php echo $this->_vars['list']['photosrc']; ?>
" alt="<?php echo $this->_vars['list']['fullname']; ?>
" width="70" height="70" border="0" /></div>
					<p><a href="<?php echo $this->_vars['list']['resume_url']; ?>
&uid=<?php echo $_SESSION['uid']; ?>
"><?php echo $this->_vars['list']['fullname']; ?>
</a></p>
				</div>
				<div class="photo-detail">
					<div class="date-time"><?php echo $this->_vars['list']['refreshtime_cn']; ?>
</div>
					<div class="detail-content"><?php echo $this->_vars['list']['education_cn']; ?>
,<?php echo $this->_vars['list']['experience_cn']; ?>
</div>
					<div class="detail-content"><?php echo $this->_vars['list']['intention_jobs']; ?>
</div>
				</div>
			</div>
			<?php endforeach; endif; ?>
		</div>
	</div>
	<div class="data-box">
		<div class="data-title">
			<h3>���¼���</h3>
			<a href="<?php echo $this->_run_modifier("QS_resumelist", 'qishi_url', 'plugin', 1); ?>
" class="right-link">����>></a>
		</div>
		<div class="newst-resume-list clearfix">
			<?php echo tpl_function_qishi_resume_list(array('set' => "�б���:resume,��ʾ��Ŀ:12,����ְλ����:25,��ַ�:...,����:rtime>desc"), $this);?>
			<?php if (count((array)$this->_vars['resume'])): foreach ((array)$this->_vars['resume'] as $this->_vars['list']): ?>
			<div class="newst-resume-item f-left">
				<div class="name-date"><a href="<?php echo $this->_vars['list']['resume_url']; ?>
&uid=<?php echo $_SESSION['uid']; ?>
"><?php echo $this->_vars['list']['fullname']; ?>
</a><span><?php echo $this->_vars['list']['refreshtime_cn']; ?>
</span></div>
				<div class="resume-detail"><?php echo $this->_vars['list']['education_cn']; ?>
 | <?php echo $this->_vars['list']['experience_cn']; ?>
 | ����<?php echo $this->_vars['list']['intention_jobs']; ?>
</div>
			</div>
			<?php endforeach; endif; ?>
		</div>
	</div>
</div>

	<div class="f_link">
		<div class="job_box">
				<div class="box_tit">
					<div class="tit">��������</div> <div class="more link_bk"><a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
link/add_link.php" target="_blank">����>></a></div>
					<div class="clear"></div>
				</div>
				<div class="box_content">
					<?php echo tpl_function_qishi_link(array('set' => "�б���:link,��ʾ��Ŀ:100,��������:QS_resume,����:1"), $this);?>
					<div class="link_name link_bk">
							<?php if (count((array)$this->_vars['link'])): foreach ((array)$this->_vars['link'] as $this->_vars['list']): ?>
							<a style="word_link" href="<?php echo $this->_vars['list']['link_url']; ?>
" target="_blank"><?php echo $this->_vars['list']['title']; ?>
</a>
							<?php endforeach; endif; ?>
							<?php echo tpl_function_qishi_link(array('set' => "�б���:imglink,��ʾ��Ŀ:14,��������:QS_resume,����:2"), $this);?>
							<?php if ($this->_vars['imglink']): ?>
							<div class="link_img">
								<?php if (count((array)$this->_vars['imglink'])): foreach ((array)$this->_vars['imglink'] as $this->_vars['list']): ?>
								<div class="l_img"><a href="<?php echo $this->_vars['list']['link_url']; ?>
" target="_blank"><img src="<?php echo $this->_vars['list']['link_logo']; ?>
" alt="<?php echo $this->_vars['list']['title']; ?>
" border="0" width="120" height="40" /></a> </div>
								<?php endforeach; endif; ?>
								<div class="clear"></div>
							</div>
							<?php endif; ?>
					</div>
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
