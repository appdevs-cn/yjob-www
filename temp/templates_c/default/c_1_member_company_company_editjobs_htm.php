<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.default.php'); $this->register_modifier("default", "tpl_modifier_default",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_get_classify.php'); $this->register_function("qishi_get_classify", "tpl_function_qishi_get_classify",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-26 11:19 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $this->_vars['title']; ?>
</title>
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<meta name="author" content="��ʿCMS" />
<meta name="copyright" content="74cms.com" />
<meta name="renderer" content="webkit"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/user_common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/user_company.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/jobs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/ui-dialog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
admin/css/date_input.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.validate.min.js" type='text/javascript' language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/dialog-min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/dialog-min-common.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
data/cache_classify.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
admin/js/jquery.date_input.js" type='text/javascript' language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/adddate.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.company.selectlayer.js" type='text/javascript' language="javascript"></script>
<link rel="stylesheet" href="<?php echo $this->_vars['QISHI']['site_template']; ?>
kindeditor/themes/default/default.css" />
<script charset="utf-8" src="<?php echo $this->_vars['QISHI']['site_template']; ?>
kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="<?php echo $this->_vars['QISHI']['site_template']; ?>
kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$("#Form1 input, #Form1 textarea, #Form1 select").each(function(index, el) {
	$(this).attr('_value', jQuery(this).val());
});
//����
$(function() { 
	$(".date_input").date_input(); 
	});
//��beforeunload�¼�
function is_form_changed() {
	//���ҳ���Ƿ��б��水ť
	var t_save = $("#submitsave");
	if(t_save.length>0) {
		var is_changed = false;
		$("#Form1 input, #Form1 textarea, #Form1 select").each(function(index, el) {
			var _v = $(this).attr('_value');
			if(typeof(_v) == 'undefined') {
				_v = '';
			}
			if(_v != jQuery(this).val()) {
				is_changed = true;
			}
		});
		return is_changed;
	}
	return false;
}
if ($.browser.msie){
    window.onunload = function(){
        return "�����ڱ༭��������δ���棬ȷ��Ҫ�뿪��ҳ��";
    }
}
else{
    window.onbeforeunload = function(){
        if (is_form_changed()) {
			return '�����ڱ༭��������δ���棬ȷ��Ҫ�뿪��ҳ��';
		}
    }
}
allaround('<?php echo $this->_vars['QISHI']['site_dir']; ?>
');
// ְλ���������� 
job_filldata("#job_list", QS_jobs_parent, QS_jobs, "#result-list-job", "#aui_outer_job", "#job_result_show", "#topclass", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");
// ���������������
tag_filldata("#tag_list", QS_jobtag, "#aui_outer_tag", "#result-list-tag", "#trade_result_show", "#tag", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");
// ���ְλ����Զ���������ְλ����
$("#JobRequInfoTemplate a").unbind().die().live('click', function() {
	var aid = $(this).attr("data");
	$.get("company_jobs.php?act=get_content_by_jobs_cat&id="+aid, function(data) {
		if (data == "-1") {
			editor.html('');
			editor.sync();
		} else {
			editor.html(data);
			editor.sync();
		}
	});
});
// ְλ�ص��������
tag_filldatas("#tag_lists", jobspecial, "#aui_outer_tags", "#result-list-tags", "#trade_result_shows", "#tags", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");
//�������ʵ�ѡ
var nature_obj = $("#nature_radio .input_radio").first();
$("#nature").val(nature_obj.attr("id"));
$("#nature_cn").val(nature_obj.text());
$("#nature_radio .input_radio").click(function(){
		$("#nature").val($(this).attr('id'));
		$("#nature_cn").val($(this).text());
		$("#nature_radio .input_radio").removeClass("select");
		$(this).addClass("select");
});
//�Ա�ѡ
$("#sex_radio .input_radio").click(function(){
		$("#sex").val($(this).attr('id'));
		$("#sex_cn").val($(this).text());
		$("#sex_radio .input_radio").removeClass("select");
		$(this).addClass("select");
});
menuDown("#education_menu","#education","#education_cn","#menu1","218px");
menuDown("#experience_menu","#experience","#experience_cn","#menu2","218px");
menuDown("#wage_menu","#wage","#wage_cn","#menu3","218px");
function menuDown(menuId,input,input_cn,menuList,width){
	$(menuId).click(function(){
		$(menuList).css("width",width);
		$(menuList).slideDown('fast');
		//���ɱ���
		$(menuId).parent("div").before("<div class=\"menu_bg_layer\"></div>");
		$(".menu_bg_layer").height($(document).height());
		$(".menu_bg_layer").css({ width: $(document).width(), position: "absolute", left: "0", top: "0" , "z-index": "0", "background-color": "#ffffff"});
		$(".menu_bg_layer").css("opacity","0");
		$(".menu_bg_layer").click(function(){
		
			$(".menu_bg_layer").remove();
			$(menuList).slideUp("fast");
			$(menuId).parent("div").css("position","");
		});
	});

	$(menuList+" li").click(function(){
		var id = $(this).attr("id");
		var title = $(this).attr("title");
		$(input).val(id);
		$(input_cn).val(title);
		$(menuId).html(title);
		$(input).parent().find('.input_text_200_bg').removeClass('error');
		$(input).parent().next().find('.error').hide();
		$(menuList).slideUp('fast');
		$(".menu_bg_layer").remove();
	});
}
showagebox("#minage_div","#minage");
showagebox("#maxage_div","#maxage");
function showagebox(divname,inputname)
{
	$(divname).click(function(){
		var inputdiv=$(this);
		$(inputdiv).parent("div").before("<div class=\"menu_bg_layer\"></div>");
		$(".menu_bg_layer").height($(document).height());
		$(".menu_bg_layer").css({ width: $(document).width(), position: "absolute", left: "0", top: "0" , "z-index": "0"});
		$(inputdiv).parent("div").css("position","relative");
		
		var y=16;
		var ymax=60;
		htm="<div class=\"showyearbox yearlist\">";		
		htm+="<ul>";
		for (i=y;i<=ymax;i++)
		{
		htm+="<li title=\""+i+"\">"+i+"��</li>";
		}
		htm+="<div class=\"clear\"></div>";
		htm+="</ul>";
		htm+="</div>";
		$(inputdiv).blur();
		if ($(inputdiv).parent("div").find(".showyearbox").html())
		{
			$(inputdiv).parent("div").children(".showyearbox.yearlist").slideToggle("fast");
		}
		else
		{
			$(inputdiv).parent("div").append(htm);
			$(inputdiv).parent("div").children(".showyearbox.yearlist").slideToggle("fast");
		}
		//
		$(inputdiv).parent("div").children(".yearlist").find("li").unbind("click").click(function()
		{
			var tt = $(this).attr("title");
			$(inputname).val(tt);
			$(inputdiv).html(tt);
			if (inputname == "#minage") {
				var maxval = $("#maxage").val();
				if(maxval) {
					tt >= maxval ? $("#ageerr").show() : $("#ageerr").hide();
				}
			}
			if (inputname == "#maxage") {
				var minval = $("#minage").val();
				if(minval) {
					tt <= minval ? $("#ageerr").show() : $("#ageerr").hide();
				}
			}
			$(inputdiv).parent("div").children(".yearlist").hide();
			$(".menu_bg_layer").remove();
		});	
		//
		$(".showyearbox>ul>li").hover(
		function()
		{
		$(this).css("background-color","#DAECF5");
		$(this).css("color","#ff0000");
		},
		function()
		{
		$(this).css("background-color","");
		$(this).css("color","");
		}
		);
		//
		$(".menu_bg_layer").click(function(){
					$(".menu_bg_layer").hide();
					$(inputdiv).parent("div").css("position","");
					$(inputdiv).parent("div").find(".showyearbox").hide();
					
		});
	});
}
// �ֻ�������֤   
var mobile = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}|17[0-9]{9}$/;
var current_tel = "<?php echo $this->_vars['jobs']['contact']['telephone']; ?>
";
if(!mobile.test(current_tel)){
	$("#receiveit").attr('disabled','disabled');
    $("#receiveit").attr('checked',false);
}
// �ֻ�������֤   
jQuery.validator.addMethod("isPhoneNumber", function(value, element) {   
    var mobile = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}|17[0-9]{9}$/;
    if(this.optional(element) || (mobile.test(value))){
    	$("#receiveit").removeAttr('disabled');
    }else{
    	$("#receiveit").attr('disabled','disabled');
    	$("#receiveit").attr('checked',false);
    }
    return this.optional(element) || (mobile.test(value));
}, "����ȷ��д��ϵ�绰");
// ������֤   
jQuery.validator.addMethod("isareacode", function(value, element) {   
    var tel = /^0\d{2,3}$/;
    return this.optional(element) || (tel.test(value));
}, "����ȷ��д�绰����");
// �绰����֤   
jQuery.validator.addMethod("isphone", function(value, element) {   
    var tel = /^\d{6,11}$/;
    return this.optional(element) || (tel.test(value));
}, "����ȷ��д�绰����");
// �ֻ�����֤   
jQuery.validator.addMethod("isextensioncode", function(value, element) {   
    var tel = /^\d{0,6}$/;
    return this.optional(element) || (tel.test(value));
}, "����ȷ��д�绰����");
// �ֻ��ź͹̶��绰��ѡһ   
jQuery.validator.addMethod("isHaveLandlin", function(value, element) {   
    var landval = $.trim($('#telephone').val());
    return value.length > 0 || landval.length > 0;
}, "����д�ֻ���̻�����ѡһ����");
$("#Form1").validate({
 //debug: true,
// onsubmit:false,
//onfocusout :true,
   rules:{
   jobs_name:{
    required: true,
	minlength:2,
    maxlength:30
   },
   amount: {
   	required: true,
	range:[0,9999]
   },
   category: "required",
   subsite_id: "required",
   wage: "required",
   //education: "required",
   //experience: "required",
   contents:{
   required: true,
	minlength:30
   },
   contact:{
   required: true
   },
	 telephone: {
	   isPhoneNumber:true
	},
	landline_tel_first: {
	   isareacode:true
	},
	  landline_tel_next: {
	   isHaveLandlin:true,
	   isphone:true
	},
	  landline_tel_last: {
	   isextensioncode:true
	},
	  address: "required", 
	   email: {
	   required:true,
	   email:true
	   }
	},
    messages: {
    jobs_name: {
    required: "������ְλ����",
    minlength: jQuery.format("ְλ���Ʋ���С��{0}���ַ�"),
	maxlength: jQuery.format("ְλ���Ʋ��ܴ���{0}���ַ�")
   },
   amount: {
   	required: "��������Ƹ����",
    range: jQuery.format("������һ������ {0} �� {1} ֮���ֵ")
   },
    category: {
    required: jQuery.format("��ѡ������ְλ����ȷѡ��ְλ��������Ч�����ƸЧ��")
   },
    subsite_id: {
    required: jQuery.format("��ѡ��������")
   },
   wage: {
    required: jQuery.format("��ѡ����н��Χ")
   },
   /*education: {
    required: jQuery.format("��ѡ��ѧ��Ҫ��")
   },
    experience: {
    required: jQuery.format("��ѡ��������")
   },*/
   contents: {
    required: jQuery.format("����дְλ����"),
	minlength: jQuery.format("ְλ�������ݲ���С��{0}���ַ�")
   },
   contact: {
    required: jQuery.format("����д��ϵ��")
   },
   telephone: {
	isPhoneNumber: jQuery.format("����ȷ��д��ϵ�绰")
   },
   landline_tel_first: {
	isareacode: jQuery.format("����ȷ��д����")
   },
    landline_tel_next: {
    	isHaveLandlin: jQuery.format("����д�ֻ���̻�����ѡһ����"),
	isphone: jQuery.format("����ȷ��д�绰����")
   },
    landline_tel_last: {
	isextensioncode: jQuery.format("����ȷ��д�ֻ���")
   },
   address: {
    required: jQuery.format("����д��ϵ��ַ")
   },
   email: {
    required: jQuery.format("����д��������"),
	email: jQuery.format("����ȷ��д��������")
   } 
  },
  errorPlacement: function(error, element) {
    if ( element.is(":radio") )
        error.appendTo( element.parent().next().next() );
    else if ( element.is(":checkbox") )
        error.appendTo ( element.next());
    else
        error.appendTo(element.parent().next());
    	element.parent().find('.input_text_200_bg').addClass('error');
	},
	success: function (label) {
        label.parent().prev().find('.input_text_200_bg').removeClass('error');
    },
	submitHandler: function(form) {
		window.onbeforeunload = null;
		form.submit();
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
echo $this->_fetch_compile_include("user/header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class="page_location link_bk">��ǰλ�ã�<a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
">��ҳ</a> > <a href="<?php echo $this->_vars['userindexurl']; ?>
">��Ա����</a> > �޸�ְλ</div>
<div class="usermain">
  <div class="leftmenu link_bk">
  <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("member_company/left.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  </div>
  <div class="rightmain">
	<div class="bbox1">	
	  <div class="addjob">
	    <div class="titleH1">
	      <div class="h1-title">�޸�ְλ</div>
        </div>
	    <div class="titleH2"><span>ְλ��Ϣ</span></div>
		<form id="Form1" name="Form1" method="post" action="?act=editjobs_save" >
		<input name="addrand" type="hidden"  id="addrand" value="<?php echo $this->_vars['addrand']; ?>
" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		  <tr>
			<td width="125" align="right"><span class="nec">ְλ����</span>��</td>
			<td width="230"><input name="jobs_name" type="text" class="input_text_200" id="jobs_name" maxlength="80" value="<?php echo $this->_vars['jobs']['job_name']; ?>
"/></td>
			<td>&nbsp;</td>
		  </tr>
 </tr>
		  <tr>
			<td align="right"><span class="nec">ְλ����</span>��</td>
			<td colspan="2">
			<div id="nature_radio">
			<input name="nature" id="nature" type="hidden" value="<?php echo $this->_vars['jobs']['nature']; ?>
" />
			<input name="nature_cn" id="nature_cn" type="hidden" value="<?php echo $this->_vars['jobs']['nature_cn']; ?>
" />
			 <?php echo tpl_function_qishi_get_classify(array('set' => "����:QS_jobs_nature,�б���:c_nature"), $this); if (count((array)$this->_vars['c_nature'])): foreach ((array)$this->_vars['c_nature'] as $this->_vars['list']): ?>
			  <div class="input_radio <?php if ($this->_vars['list']['id'] == $this->_vars['jobs']['job_type']): ?>select<?php endif; ?>" id="<?php echo $this->_vars['list']['id']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</div>
			   <?php endforeach; endif; ?>			  
			  <div class="clear"></div>
			  </div>		    </td>
		  </tr>
		  <tr class="jobmain">
			<td align="right"><span class="nec">ְλ���</span>��</td>
			<td id="jobsSort" style="position:relative;">
             <div id="jobText" class="input_text_200_bg choose_cate ucc-default"><?php echo $this->_run_modifier($this->_vars['jobs']['category_name'], 'default', 'plugin', 1, "��ѡ��"); ?>
</div>	
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
                                                                                <div class="selector-header"><span class="selector-title">ְλѡ��</span><div></div><span class="selector-close">X</span><div class="clear"></div></div>

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
              <input name="topclass" id="topclass" type="hidden" value="<?php echo $this->_vars['jobs']['topclass']; ?>
" />	
              <input name="category" id="category" type="hidden" value="<?php echo $this->_vars['jobs']['category']; ?>
" />		
              <input name="subclass" id="subclass" type="hidden" value="<?php echo $this->_vars['jobs']['subclass']; ?>
" />		
              <input name="category_cn" id="category_cn" type="hidden" value="<?php echo $this->_vars['jobs']['category_cn']; ?>
" />			</td>
			<td>&nbsp;</td>
		  </tr>
	    </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
			<tr>
			<td width="125" align="right">ְλ���㣺</td>
			<td style="position:relative;">
			  <div class="showchecktag"></div>
              <div class="input_checkbox_add ucc-default">���</div>	
              <!-- ְλ���㵯���� -->
				<div class="aui_outer" id="aui_outer_tag">
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
																<div class="selector-header"><span class="selector-title">ְλ����ѡ��</span><div></div><span id="tag-selector-save" class="selector-save">ȷ��</span><span class="selector-close">X</span><div class="clear"></div></div>

																<div class="data-row-head"><div class="data-row"><div class="data-row-side">���ѡ <strong class="text-warning">5</strong> ��&nbsp;&nbsp;��ѡ <strong id="arstrade" class="text-warning">0</strong> ��</div><div id="result-list-tag" class="result-list data-row-side-ra"></div></div><div class="cla"></div></div>
																<div class="item-table">
																	<table class="options-table options-table-7">
																		<tbody class="item-list"><tr><td class="bno"><table><tbody id="tag_list">
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
				<!-- ְλ���㵯���� End-->
              <input name="tag" type="hidden" id="tag" value="<?php echo $this->_vars['jobs']['tag']; ?>
" />
			  <input name="tag_cn" type="hidden" id="tag_cn" value="<?php echo $this->_vars['jobs']['tag_cn']; ?>
" />		
          </td>
		  </tr>
	    </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		  <tr>
			<td width="125" align="right">ְλ�ص㣺</td>
			<td style="position:relative;">
			  <div class="showchecktags"></div>
              <div class="input_checkbox_add ucc-default">���</div>	
              <!-- ְλ���㵯���� -->
				<div class="aui_outer" id="aui_outer_tags">
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
																<div class="selector-header"><span class="selector-title">ְλ�ص�ѡ��</span><div></div><span id="tag-selector-saves" class="selector-save">ȷ��</span><span class="selector-close">X</span><div class="clear"></div></div>

																<div class="data-row-head"><div class="data-row"><div class="data-row-side">���ѡ <strong class="text-warning">3</strong> ��&nbsp;&nbsp;��ѡ <strong id="arstrades" class="text-warning">0</strong> ��</div><div id="result-list-tags" class="result-list data-row-side-ra"></div></div><div class="cla"></div></div>
																<div class="item-table">
																	<table class="options-table options-table-7">
																		<tbody class="item-list"><tr><td class="bno"><table><tbody id="tag_lists">
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
				<!-- ְλ���㵯���� End-->
              <input name="tags" type="hidden" id="tags" value="<?php echo $this->_vars['jobs']['jobspecial']; ?>
" />
			  <input name="tag_cns" type="hidden" id="tag_cns" value="<?php echo $this->_vars['jobs']['jobspecial_cn']; ?>
" />		
          </td>
		  </tr>
	    </table>
		<div class="titleH2"><span>ְλҪ��</span></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		  <tr>
			<td width="125" align="right"><span class="nec">�Ա�Ҫ��</span>��</td>
			<td colspan="2">
			<div id="sex_radio">
			<input name="sex" id="sex" type="hidden" value="<?php echo $this->_vars['jobs']['sex']; ?>
" />
			  <div class="input_radio <?php if ($this->_vars['jobs']['sex'] == '100'): ?>select<?php endif; ?>" id="3">����</div>
			  <div class="input_radio <?php if ($this->_vars['jobs']['sex'] == '200'): ?>select<?php endif; ?>" id="1">��</div>
			  <div class="input_radio <?php if ($this->_vars['jobs']['sex'] == '300'): ?>select<?php endif; ?>" id="2">Ů</div>			  
			  <div class="clear"></div>
			  </div>		    </td>
		  </tr>
		  <tr>
			<td align="right">ѧ��Ҫ��</td>
			<td width="230">
			<div style="position:relateve;">
             	 	<div id="education_menu" class="input_text_200_bg"><?php echo $this->_vars['jobs']['education_cn']; ?>
</div>	
             	 	<div class="menu" id="menu1">
                            <ul>
                                <?php echo tpl_function_qishi_get_classify(array('set' => "����:QS_education,�б���:c_education"), $this);?>
                                <?php if (count((array)$this->_vars['c_education'])): foreach ((array)$this->_vars['c_education'] as $this->_vars['list']): ?>
                                <li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"<?php if ($this->_vars['list']['id'] == $this->_vars['jobs']['education']): ?> class="selected"<?php endif; ?>><?php echo $this->_vars['list']['categoryname']; ?>
</li>
                                <?php endforeach; endif; ?>
                            </ul>
	              	</div>
	            </div>				
             	 <input name="education" type="hidden" id="education" value="<?php echo $this->_vars['jobs']['education']; ?>
" />
             	 <input name="education_cn" type="hidden" id="education_cn" value="<?php echo $this->_vars['jobs']['education_cn']; ?>
" /></td>
			<td><label> ������</label></td>
		  </tr>
		  <tr>
			<td align="right">�������飺</td>
			<td>
				<div style="position:relateve;">
             	 	<div id="experience_menu" class="input_text_200_bg"><?php echo $this->_vars['jobs']['experience_cn']; ?>
</div>	
             	 	<div class="menu" id="menu2">
	              		<ul>
	              			<?php echo tpl_function_qishi_get_classify(array('set' => "����:QS_experience,�б���:c_experience"), $this);?>
	              			<?php if (count((array)$this->_vars['c_experience'])): foreach ((array)$this->_vars['c_experience'] as $this->_vars['list']): ?>
	              			<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
	              			<?php endforeach; endif; ?>
	              		</ul>
	              	</div>
	            </div>				
             	 <input name="experience" type="hidden" id="experience" value="<?php echo $this->_vars['jobs']['experience']; ?>
" />
             	 <input name="experience_cn" type="hidden" id="experience_cn" value="<?php echo $this->_vars['jobs']['experience_cn']; ?>
" /></td>
			<td><label><input name="graduate" type="checkbox" <?php if ($this->_vars['jobs']['graduate'] == "1"): ?>checked="checked"<?php endif; ?> value="1" /> Ӧ�������</label></td>
		  </tr>
		    <tr>
			<td align="right">����Ҫ��</td>
			<td colspan="2">
			  <table border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="80" style="padding:0px">
                            	<div>
                            	<div class="input_text_50_bg date_input wid54" id="minage_div"><?php if ($this->_vars['jobs']['min_age']):  echo $this->_vars['jobs']['min_age'];  else: ?>��ѡ��<?php endif; ?></div>
				             	 <input name="minage" id="minage" type="hidden" value="<?php echo $this->_vars['jobs']['min_age']; ?>
" />
				            	</div>
				        	</td>
                            <td width="20" style="padding:0px">��</td>
                            <td width="80"  style="padding:0px">
                            	<div>
                            	<div class="input_text_50_bg date_input wid54" id="maxage_div"><?php if ($this->_vars['jobs']['max_age']):  echo $this->_vars['jobs']['max_age'];  else: ?>��ѡ��<?php endif; ?></div>
				             	 <input name="maxage" id="maxage" type="hidden" value="<?php echo $this->_vars['jobs']['max_age']; ?>
" />
				            	</div>
                            </td>
                          </tr>
                        </table>
						<label id="ageerr" class="error" style="display:none">��ѡ����ȷ�����䷶Χ</label>
				</td>
		  </tr>
	    </table>
		
		<div class="titleH2"><span>ְλ����</span></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		  <tr>
			<td width="125" align="right" valign="top"><span class="nec">ְλ����</span>��</td>
			<td width="500">
			<?php if ($this->_vars['jobs']['category_cn'] != ''): ?>
			<div style="" id="template">
				<span class="tdTemplateTitle">&nbsp;</span><font style="color:#FF6600">�����ְλģ�����Զ����ְλ������</font>
				<span id="JobRequInfoTemplate"><a data="<?php echo $this->_vars['jobs']['subclass']; ?>
" href="javascript:void(0);"><?php echo $this->_vars['jobs']['category_cn']; ?>
</a></span>
			</div>
			<?php endif; ?>
			<textarea id="contents" name="contents" style="width:700px;height:300px;visibility:hidden;"><?php echo $this->_vars['jobs']['contents']; ?>
</textarea>
			<script type="text/javascript">
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="contents"]', {
						allowFileManager : false,
						width:600,
						height:250,
						afterBlur: function(){this.sync();}
					});
				});
			</script>
			</td>
			<td></td>
		  </tr>
	    </table>
		
	<div class="titleH2"><span>��ϵ��ʽ</span></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		  <tr>
			<td width="125" align="right"><span class="nec">��ϵ��</span>��</td>
			<td width="230"><input name="contact" type="text" class="input_text_200" id="contact" maxlength="20"   value="<?php echo $this->_vars['jobs']['contact_name']; ?>
"/></td>
			<td><label><input name="contact_show" type="checkbox" value="1" <?php if ($this->_vars['jobs']['dispaly_name'] == "100"): ?>checked="checked"<?php endif; ?> /> ���⹫����ϵ��</label></td>
		  </tr>
		  </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
			  <tr>
				<td width="125" align="right"><span class="nec">�̶��绰</span>��</td>
				<td width="280">
					<input type="text" id="landline_tel_first" name="landline_tel_first" class="input_text_33 input_text" id="landline_tel_first" maxlength="4"   value="<?php echo $this->_vars['jobs']['contact']['landline_tel_first']; ?>
"/>&nbsp;-
					<input id="landline_tel_next" name="landline_tel_next" type="text" class="input_text_90 input_text" maxlength="11"   value="<?php echo $this->_vars['jobs']['contact']['landline_tel_next']; ?>
"/>&nbsp;-
					<input id="landline_tel_last" name="landline_tel_last" type="text" class="input_text_49 input_text" maxlength="6"   value="<?php echo $this->_vars['jobs']['contact']['landline_tel_last']; ?>
"/>
				</td>
				<td>&nbsp;</td>
			  </tr>
		  </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
			  <tr>
				<td width="125" align="right"><span>��ϵ�ֻ�</span>��</td>
				<td width="230">
				
	            <input name="telephone" oninput="OnInput (event,'#telephone_two')" onpropertychange="OnPropChanged (event,'#telephone_two')" type="text" class="input_text_200" id="telephone" maxlength="35"   value="<?php echo $this->_vars['jobs']['contact_mobile']; ?>
"/></td>
				<td><label><input name="telephone_show" type="checkbox" value="1" <?php if ($this->_vars['jobs']['dispaly_mobile'] == "100"): ?>checked="checked"<?php endif; ?> /> ���⹫����ϵ�绰</label></td>
			  </tr>
		  </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		  <tr>
			<td width="125" align="right"><span class="nec">��ϵ����</span>��</td>
			<td width="230">
			
             <input name="email" oninput="OnInput (event,'#email_two')" onpropertychange="OnPropChanged (event,'#email_two')" type="text" class="input_text_200" id="email" maxlength="80" value="<?php echo $this->_vars['jobs']['contact_email']; ?>
"/>            	</td>
			<td><label><input name="email_show" type="checkbox" value="1" <?php if ($this->_vars['jobs']['dispaly_email'] == "100"): ?>checked="checked"<?php endif; ?> /> ���⹫����ϵ����</label></td>
		  </tr>
	    </table>
	    <script type="text/javascript">
	    	// Firefox, Google Chrome, Opera, Safari, Internet Explorer from version 9
			function OnInput (event,id) {
				$(id).val(event.target.value);
			    // alert ("The new content: " + event.target.value);
			}
			// Internet Explorer
			function OnPropChanged (event,id) {
			    if (event.propertyName.toLowerCase () == "value") {
			    	$(id).val(event.srcElement.value);
			    }
			}
	    </script>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		   <tr>
			<td width="125" align="right"><span class="nec">��ϵ��ַ</span>��</td>
			<td ><input name="address" id="address" type="text" class="input_text_500" maxlength="100" value="<?php echo $this->_vars['jobs']['contact_address']; ?>
"/>
		     </td>
		  </tr>
	    </table>
	    <div class="titleH2"><span style="background:none;">�߼�����</span></div>
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
			<tr>
			<td width="125" align="right">����ί�м�����</td>
			<td ><label><input name="is_entrust" type="checkbox" value="0" <?php if ($this->_vars['jobs']['is_entrust'] != '1'): ?>checked="checked"<?php endif; ?>/>����</label>
		     </td>
		  </tr>
			<tr>
				<td width="125" align="right"><span class="">������������</span>��</td>
				<td width="230"><input name="email_two" id="email_two" type="text" class="input_text_200" maxlength="80" value="<?php echo $this->_vars['jobs']['receive_email']; ?>
" disabled="disabled"/></td>
				<td><label><input name="notify" type="checkbox" value="1" <?php if ($this->_vars['jobs']['push_email'] == '100'): ?>checked="checked"<?php endif; ?>/>����</label></td>
		  	</tr>
			<tr>
				<td width="125" align="right"><span class="">��������֪ͨ</span>��</td>
				<td width="230"><input name="telephone_two" id="telephone_two" type="text" class="input_text_200" maxlength="80" value="<?php echo $this->_vars['jobs']['receive_mobile']; ?>
" disabled="disabled"/></td>
				<td><label><input name="notify_mobile" type="checkbox" value="1" id="receiveit" <?php if ($this->_vars['jobs']['push_sms'] == '100'): ?>checked="checked"<?php endif; ?> />����</label></td>
		  	</tr>
			<tr height="10" style="display:;">
				<td width="125" align="right" style="padding:0">&nbsp;</td>
				<td width="230" colspan="2" style="padding:0">
					<div class="short-text-tip f-left" style="margin-left:0">���Ŀ��ö�������Ϊ <span style="color:#ff9900;"><?php echo $this->_vars['user']['sms_num']; ?>
</span> ��<?php if ($this->_vars['user']['sms_num'] <= 0): ?>��<a target="_blank" href="company_sms.php?act=sms_order" class="underline">��������</a><?php endif; ?></div>
				</td>
		  	</tr>
		  	<tr>
				<td width="125" align="right"> </td>
				<td ><input type="submit" name="submitsave" id="submitsave" value="����"  class="but220lan" onclick="$(window).unbind('beforeunload');"/>
				</td>
			</tr>
		</table>
	    <input name="add_mode" type="hidden" id="add_mode" value="<?php echo $this->_vars['jobs']['add_mode']; ?>
" />
		<input name="id" type="hidden" value="<?php echo $this->_vars['jobs']['id']; ?>
" />
<?php if ($this->_vars['jobs']['add_mode'] == "1"): ?>
<script type="text/javascript">
$(document).ready(function()
{
	//����Ĭ��
	total();
	//�����ܼƻ���
	function total()
	{
			var points = <?php echo $this->_vars['points_total']; ?>
;
			var jobs_edit = <?php echo $this->_vars['points']['jobs_edit']['value']; ?>
;
			var totals=jobs_edit;	
			<?php if ($this->_vars['points']['jobs_edit']['type'] == "1"): ?>
			var type="����";
			<?php else: ?>
			var type="�۳�";
			<?php endif; ?>				
			$("#total").html("�޸ı�����Ϣ�ܼ�"+type+"&nbsp;<span style=\"font-size:20px; color: #FF0000\" >"+totals+"</span>&nbsp;<?php echo $this->_vars['QISHI']['points_quantifier'];  echo $this->_vars['QISHI']['points_byname']; ?>
����Ŀǰ����<strong style=\"color:#0033FF\"> <?php echo $this->_vars['points_total']; ?>
  </strong><?php echo $this->_vars['QISHI']['points_quantifier'];  echo $this->_vars['QISHI']['points_byname']; ?>
��<a href=\"company_service.php?act=order_add\">[��ֵ����]</a><br />");
			$("#totals").val(<?php echo $this->_vars['points_total']; ?>
-totals);	
	}				
	$("#editsubmit").click(function()
	{
		if ($("#totals").val()<0)
		{
			<?php if ($this->_vars['QISHI']['operation_mode'] == "2"): ?>
			dialog({
			  title: 'ϵͳ��ʾ',
			  content: "���Ļ��ֲ��㣬�������µķ�����߳�ֵ���֣�",
			  width:'300px'
			}).showModal();
			<?php else: ?>
			dialog({
			  title: 'ϵͳ��ʾ',
			  content: "���Ļ��ֲ��㣬���ֵ���ٷ�����",
			  width:'300px'
			}).showModal();
			<?php endif; ?>
		}
		else
		{
		$("form[name=Form1]").submit();
		}
	});				
});
</script>
<div style="position:relative;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">
		<tr>   
          	<td align="left" style="padding-left:29px;">
          		<div id="total"></div>
          	</td>	
	  	<tr>
	</table>
</div>
<?php endif; ?>
	</form>
	
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
