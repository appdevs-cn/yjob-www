<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_get_classify.php'); $this->register_function("qishi_get_classify", "tpl_function_qishi_get_classify",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 19:31 CST */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />

<title><?php echo $this->_vars['title']; ?>
</title>

<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />

<meta name="author" content="骑士CMS" />

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

<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/lyz.calendar.css" rel="stylesheet" type="text/css" />

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
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.company.selectlayer.js" type='text/javascript' language="javascript"></script>
<link rel="stylesheet" href="<?php echo $this->_vars['QISHI']['site_template']; ?>
kindeditor/themes/default/default.css" />
<script charset="utf-8" src="<?php echo $this->_vars['QISHI']['site_template']; ?>
kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="<?php echo $this->_vars['QISHI']['site_template']; ?>
kindeditor/lang/zh_CN.js"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/lyz.calendar.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
	$(function () {
		$("#work_start").manhuaDate({
			Event: "click", //可选
			Left: 0, //弹出时间停靠的左边位置
			Top: -16, //弹出时间停靠的顶部边位置
			fuhao: "-", //日期连接符默认为-
			isTime: false, //是否开启时间值默认为false
			beginY: 1949, //年份的开始默认为1949
			endY: 2100//年份的结束默认为2049
		});
		$("#work_end").manhuaDate({
			Event: "click", //可选
			Left: 0, //弹出时间停靠的左边位置
			Top: -16, //弹出时间停靠的顶部边位置
			fuhao: "-", //日期连接符默认为-
			isTime: false, //是否开启时间值默认为false
			beginY: 1949, //年份的开始默认为1949
			endY: 2100//年份的结束默认为2049
		});

	});


$(document).ready(function()

{

$("#Form1 input, #Form1 textarea, #Form1 select").each(function(index, el) {

	$(this).attr('_value', jQuery(this).val());

});

//绑定beforeunload事件

function is_form_changed() {

	//检测页面是否有保存按钮

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

        return "您正在编辑的内容尚未保存，确定要离开此页吗？";

    }

}

else{

    window.onbeforeunload = function(){

        if (is_form_changed()) {

			return '您正在编辑的内容尚未保存，确定要离开此页吗？';

		}

    }

}

allaround('<?php echo $this->_vars['QISHI']['site_dir']; ?>
');

// 职位类别填充数据 

job_filldata("#job_list", QS_jobs_parent, QS_jobs, "#result-list-job", "#aui_outer_job", "#job_result_show", "#topclass", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");

// 工作地区填充数据

//city_filldata("#city_list", QS_city_parent, QS_city, "#result-list-city", "#aui_outer_city", "#city_result_show", "#district", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");

// 职位亮点填充数据

tag_filldata("#tag_list", QS_jobtag, "#aui_outer_tag", "#result-list-tag", "#trade_result_show", "#tag", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");

// 职位特点填充数据

tag_filldatas("#tag_lists", jobspecial, "#aui_outer_tags", "#result-list-tags", "#trade_result_shows", "#tags", "<?php echo $this->_vars['QISHI']['site_dir']; ?>
");

//工作性质单选

var nature_obj = $("#nature_radio .input_radio").first();

$("#nature").val(nature_obj.attr("id"));

$("#nature_cn").val(nature_obj.text());

$("#nature_radio .input_radio").click(function(){

		$("#nature").val($(this).attr('id'));

		$("#nature_cn").val($(this).text());

		$("#nature_radio .input_radio").removeClass("select");

		$(this).addClass("select");

});

//性别单选

$("#sex_radio .input_radio").click(function(){

		$("#sex").val($(this).attr('id'));

		$("#sex_cn").val($(this).text());

		$("#sex_radio .input_radio").removeClass("select");

		$(this).addClass("select");

});

menuDown("#education_menu","#education","#education_cn","#menu1","218px");

menuDown("#experience_menu","#experience","#experience_cn","#menu2","218px");

menuDown("#wage_menu","#wage","#wage_cn","#menu3","218px");

menuDown("#subsite_menu","#subsite_id","#subsite_name","#menu_sub","218px");

menuDown("#work_our_menu","#work_end_hour_id","#work_end_hour","#menu_our","78px");

menuDown("#work_minute_menu","#work_end_minute_id","#work_end_minute","#menu_minute","78px");

menuDown("#work_start_hour_menu","#work_start_hour_id","#work_start_hour","#menu_start_hour","78px");

menuDown("#work_start_minute_menu","#work_start_minute_id","#work_start_minute","#menu_start_minute","78px");

menuDown("#work_jh_hour_menu","#work_jh_hour_id","#work_jh_hour","#menu_jh_hour","78px");

menuDown("#work_jh_minute_menu","#work_jh_minute_id","#work_jh_minute","#menu_jh_minute","78px");

menuDown("#work_xzdw_menu","#work_xzdw_id","#work_xzdw","#menu_xzdw","78px");

menuDown("#work_jsfs_menu","#work_jsfs_id","#work_jsfs","#menu_jsfs","78px");




	function menuDown(menuId,input,input_cn,menuList,width){

	$(menuId).click(function(){

		$(menuList).css("width",width);

		$(menuList).slideDown('fast');

		//生成背景

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

		htm+="<li title=\""+i+"\">"+i+"岁</li>";

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

// 手机号码验证   

var mobile = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}|17[0-9]{9}$/;

var current_tel = "<?php echo $this->_vars['company_profile']['telephone']; ?>
";

if(!mobile.test(current_tel)){

	$("#receiveit").attr('disabled','disabled');

    $("#receiveit").attr('checked',false);

}

// 手机号码验证   

jQuery.validator.addMethod("isPhoneNumber", function(value, element) {   

    var mobile = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}|17[0-9]{9}$/;

    if(this.optional(element) || (mobile.test(value))){

    	$("#receiveit").removeAttr('disabled');

    }else{

    	$("#receiveit").attr('disabled','disabled');

    	$("#receiveit").attr('checked',false);

    }

    return this.optional(element) || (mobile.test(value));

}, "请正确填写联系手机");

// 区号验证   

jQuery.validator.addMethod("isareacode", function(value, element) {   

    var tel = /^0\d{2,3}$/;

    return this.optional(element) || (tel.test(value));

}, "请正确填写电话号码");

// 电话号验证   

jQuery.validator.addMethod("isphone", function(value, element) {   

    var tel = /^\d{6,11}$/;

    return this.optional(element) || (tel.test(value));

}, "请正确填写电话号码");

// 分机号验证   

jQuery.validator.addMethod("isextensioncode", function(value, element) {   

    var tel = /^\d{0,6}$/;

    return this.optional(element) || (tel.test(value));

}, "请正确填写电话号码");

// 手机号和固定电话二选一   

jQuery.validator.addMethod("isHaveLandlin", function(value, element) {   

    var landval = $.trim($('#telephone').val());

    return value.length > 0 || landval.length > 0;

}, "请填写手机或固话，二选一即可");

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

   district: "required",

   wage: "required",

  // education: "required",

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

	   <?php if ($this->_vars['verify_addjob'] == "1"): ?>

		postcaptcha:{

		IScaptchastr: true,

		required: true,

		remote:{     

		url:"<?php echo $this->_vars['QISHI']['site_dir']; ?>
include/imagecaptcha.php",     

		type:"post",    

		data:{"postcaptcha":function (){return $("#postcaptcha").val()},"act":"verify","time":function (){return new Date().getTime()}}     

		}

	   },

	   <?php endif; ?>  

	   email: {

	   required:true,

	   email:true

	   }

	},

    messages: {

    jobs_name: {

    required: "请输入职位名称",

    minlength: jQuery.format("职位名称不能小于{0}个字符"),

	maxlength: jQuery.format("职位名称不能大于{0}个字符")

   },


    category: {

    required: jQuery.format("请选择所属职位，精确选择职位类别可以有效提高招聘效果")

   },

   contents: {

	required: jQuery.format("请填写职位描述"),

	minlength: jQuery.format("职位描述内容不能小于{0}个字符")

   },

   contact: {

    required: jQuery.format("请填写联系人")

   },

    telephone: {

	isPhoneNumber: jQuery.format("请正确填写联系手机")

   },

   landline_tel_first: {

	isareacode: jQuery.format("请正确填写区号")

   },

    landline_tel_next: {

    	isHaveLandlin: jQuery.format("请填写手机或固话，二选一即可"),

	isphone: jQuery.format("请正确填写电话号码")

   },

    landline_tel_last: {

	isextensioncode: jQuery.format("请正确填写分机号")

   },

   address: {

    required: jQuery.format("请填写联系地址")

   },

   <?php if ($this->_vars['verify_addjob'] == "1"): ?>

    postcaptcha: {

    required: "请填写验证码",

	remote: jQuery.format("验证码错误")	

   },

    <?php endif; ?>

   email: {

    required: jQuery.format("请填写电子邮箱"),

	email: jQuery.format("请正确填写电子邮箱")

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

    jQuery.validator.addMethod("IScaptchastr", function(value, element) {

	var str="点击获取验证码";

	var flag=true;

	if (str==value)

	{

	flag=false;

	}

	return  flag || this.optional(element) ;

	}, "请填写验证码");

		/////验证码部分

<?php if ($this->_vars['verify_addjob'] == "1"): ?>

function imgcaptcha(inputID,imgdiv)

{

	$(inputID).focus(function(){

		if ($(inputID).val()=="点击获取验证码")

		{

		$(inputID).val("");

		$(inputID).css("color","#333333");

		}

		$(inputID).parent("div").css("position","relative");

		//设置验证码DIV

		$(imgdiv).css({position: "absolute", left:  $(inputID).width(), "bottom": "0px" , "z-index": "10", "background-color": "#FFFFFF", "border": "1px #A3C8DC solid","display": "none","margin-left": "25px"});

		$(imgdiv).show();

		if ($(imgdiv).html()=='')

		{

		$(imgdiv).append("<img src=\"<?php echo $this->_vars['QISHI']['site_dir']; ?>
include/imagecaptcha.php?t=<?php echo $this->_vars['random']; ?>
\" id=\"getcode\" align=\"absmiddle\"  style=\"cursor:pointer; margin:3px; height:28px\" title=\"看不请验证码？点击更换一张\"  border=\"0\"/>");

		}

		$(imgdiv+" img").click(function()

		{

			$(imgdiv+" img").attr("src",$(imgdiv+" img").attr("src")+"1");

			$(inputID).val("");

			$("#Form1").validate().element("#postcaptcha");	

		});

		$(document).click(function(event)

		{

			var clickid=$(event.target).attr("id");

			if (clickid!="getcode" &&  clickid!="postcaptcha")

			{

			$(imgdiv).hide();

			$(inputID).parent("div").css("position","");

			}			

		});

	});

}

imgcaptcha("#postcaptcha","#imgdiv");

//验证码结束

<?php endif; ?>

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

<div class="page_location link_bk">当前位置：<a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
">首页</a> > <a href="<?php echo $this->_vars['userindexurl']; ?>
">会员中心</a> > 添加职位</div>

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

	      <div class="h1-title">发布职位</div>

        </div>

	    <div class="titleH2"><span>职位信息</span></div>

		<form id="Form1" name="Form1" method="post" action="?act=addjobs_save" >

		<input name="addrand" type="hidden"  id="addrand" value="<?php echo $this->_vars['addrand']; ?>
" />

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right"><span class="nec">职位名称</span>：</td>

			<td width="230"><input name="jobs_name" type="text" class="input_text_200" id="jobs_name" maxlength="80" value=""/></td>

			<td></td>

		  </tr>

		  <tr>

			<td align="right"><span class="nec">职位性质</span>：</td>

			<td colspan="2">

			<div id="nature_radio">

			<input name="nature" id="nature" type="hidden" value="1" />

			<input name="nature_cn" id="nature_cn" type="hidden" value="全职" />

			 <?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_jobs_nature,列表名:c_nature"), $this); if (count((array)$this->_vars['c_nature'])): foreach ((array)$this->_vars['c_nature'] as $this->_vars['list']): ?>

			  <div class="input_radio <?php if ($this->_vars['list']['id'] == $this->_vars['c_nature']['0']['id']): ?>select<?php endif; ?>" id="<?php echo $this->_vars['list']['id']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</div>

			   <?php endforeach; endif; ?>			  

			  <div class="clear"></div>

			  </div>		    </td>

		  </tr>

		  <tr class="jobmain">

			<td align="right"><span class="nec">职位类别</span>：</td>

			<td id="jobsSort" style="position:relative;">

            	<div id="jobText" class="input_text_200_bg choose_cate ucc-default">请选择</div>	

				<!-- 职位类别弹出框 -->

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

																<div class="selector-header"><span class="selector-title">职位选择</span><div></div><span class="selector-close">X</span><div class="clear"></div></div>



																<div class="data-row-list data-row-main" id="job_list">

																	<!-- 列表内容 -->

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

				<!-- 职位类别弹出框 End-->

              <input name="topclass" id="topclass" type="hidden" value="" />			

              <input name="category" id="category" type="hidden" value="" />		

              <input name="subclass" id="subclass" type="hidden" value="" />		

              <input name="category_cn" id="category_cn" type="hidden" value="" />

            </td>

			<td>&nbsp;</td>

		  </tr>
	    </table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right">职位亮点：</td>

			<td style="position:relative;">

			  <div class="showchecktag"></div>

              <div class="input_checkbox_add ucc-default">添加</div>	

              <!-- 职位亮点弹出框 -->

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

																<div class="selector-header"><span class="selector-title">职位亮点选择</span><div></div><span id="tag-selector-save" class="selector-save">确定</span><span class="selector-close">X</span><div class="clear"></div></div>



																<div class="data-row-head"><div class="data-row"><div class="data-row-side">最多选 <strong class="text-warning">5</strong> 项&nbsp;&nbsp;已选 <strong id="arstrade" class="text-warning">0</strong> 项</div><div id="result-list-tag" class="result-list data-row-side-ra"></div></div><div class="cla"></div></div>

																<div class="item-table">

																	<table class="options-table options-table-7">

																		<tbody class="item-list"><tr><td class="bno"><table><tbody id="tag_list">

																			<!-- 列表内容 -->

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

				<!-- 职位亮点弹出框 End-->

              <input name="tag" type="hidden" id="tag" value="" />

			  <input name="tag_cn" type="hidden" id="tag_cn" value="" />		

          </td>

		  </tr>

	    </table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right">职位特点：</td>

			<td style="position:relative;">

			  <div class="showchecktags"></div>

              <div class="input_checkbox_add ucc-default">添加</div>	

              <!-- 职位亮点弹出框 -->

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

																<div class="selector-header"><span class="selector-title">职位特点选择</span><div></div><span id="tag-selector-saves" class="selector-save">确定</span><span class="selector-close">X</span><div class="clear"></div></div>



																<div class="data-row-head"><div class="data-row"><div class="data-row-side">最多选 <strong class="text-warning">3</strong> 项&nbsp;&nbsp;已选 <strong id="arstrades" class="text-warning">0</strong> 项</div><div id="result-list-tags" class="result-list data-row-side-ra"></div></div><div class="cla"></div></div>

																<div class="item-table">

																	<table class="options-table options-table-7">

																		<tbody class="item-list"><tr><td class="bno"><table><tbody id="tag_lists">

																			<!-- 列表内容 -->

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

				<!-- 职位亮点弹出框 End-->

              <input name="tags" type="hidden" id="tags" value="" />

			  <input name="tag_cns" type="hidden" id="tag_cns" value="" />		

          </td>

		  </tr>

	    </table>

		<div class="titleH2"><span>职位要求</span></div>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right"><span class="nec">性别要求</span>：</td>

			<td colspan="2">

			<div id="sex_radio">

			<input name="sex" id="sex" type="hidden" value="3" />

			<input name="sex_cn" id="sex_cn" type="hidden" value="不限" />

			  <div class="input_radio select" id="3">不限</div>			

			  <div class="input_radio" id="1">男</div>

			  <div class="input_radio" id="2">女</div>			  

			  <div class="clear"></div>

			  </div>		    </td>

		  </tr>

		  <tr>

			<td align="right">学历要求：</td>

			<td width="230">

			<div style="position:relateve;">

             	 	<div id="education_menu" class="input_text_200_bg">请选择</div>	

             	 	<div class="menu" id="menu1">

	              		<ul>

	              			<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_education,列表名:c_education"), $this);?>

	              			<?php if (count((array)$this->_vars['c_education'])): foreach ((array)$this->_vars['c_education'] as $this->_vars['list']): ?>

	              			<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>

	              			<?php endforeach; endif; ?>

	              		</ul>

	              	</div>

	            </div>				

             	 <input name="education" type="hidden" id="education" value="" />

             	 <input name="education_cn" type="hidden" id="education_cn" value="" /></td>

		<td><label> 及以上</label></td>

		  </tr>

		  <tr>

			<td align="right">工作经验：</td>

			<td>

				<div style="position:relateve;">

             	 	<div id="experience_menu" class="input_text_200_bg">请选择</div>	

             	 	<div class="menu" id="menu2">

	              		<ul>

	              			<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_experience,列表名:c_experience"), $this);?>

	              			<?php if (count((array)$this->_vars['c_experience'])): foreach ((array)$this->_vars['c_experience'] as $this->_vars['list']): ?>

	              			<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>

	              			<?php endforeach; endif; ?>

	              		</ul>

	              	</div>

	            </div>				

             	 <input name="experience" type="hidden" id="experience" value="" />

             	 <input name="experience_cn" type="hidden" id="experience_cn" value="" /></td>

			<td><label><input name="graduate" type="checkbox" value="1" />应届生亦可</label></td>

		  </tr>

		    <tr>

			<td align="right">年龄要求：</td>

			<td colspan="2">

			  <table border="0" cellpadding="0" cellspacing="0" >

                  <tr>

                    <td width="80" style="padding:0px">

                    	<div>

                    	<div class="input_text_50_bg date_input wid54" id="minage_div">请选择</div>

		             	 <input name="minage" id="minage" type="hidden" value="" />

		            	</div>

		        	</td>

                    <td width="20" style="padding:0px">至</td>

                    <td width="80"  style="padding:0px">

                    	<div>

                    	<div class="input_text_50_bg date_input wid54" id="maxage_div">请选择</div>

		             	 <input name="maxage" id="maxage" type="hidden" value="" />

		            	</div>

                    </td>

                  </tr>

                </table>

				<label id="ageerr" class="error" style="display:none">请选择正确的年龄范围</label>

				</td>

		  </tr>

	    </table>
        
        <div class="titleH2"><span>发布城市</span></div>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right">选择城市：</td>
			<td width="230">
                <div style="position:relateve;float: left;margin-right: 5px;" >
                    <div id="subsite_menu" class="input_text_50_bg">请选择</div>
                    <input type="hidden" name="subsite_id" id="subsite_id"/>
                    <input type="hidden" name="subsite_name" id="subsite_name"/>
                    <div class="menu" id="menu_sub" style="border:#ccc solid 1px;margin-top: -1px;padding:10px;min-height:100px">
                        <ul>
                            <?php if (count((array)$this->_vars['subsite'])): foreach ((array)$this->_vars['subsite'] as $this->_vars['list']): ?>
                            <li id="<?php echo $this->_vars['list']['s_id']; ?>
" sid="<?php echo $this->_vars['list']['s_district']; ?>
" title="<?php echo $this->_vars['list']['s_districtname']; ?>
" pid="0" style="float: left;padding: 0 5px;"><?php echo $this->_vars['list']['s_districtname']; ?>
</li>
                            <?php endforeach; endif; ?>
                            <div style="clear: both;"></div>
                        </ul>
                    </div>
                </div>
				
			</td>

		<td></td>
		  </tr>

	    </table>
        
         <div class="titleH2"><span>BD经理配置</span></div>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right" valign="top"><span class="nec">手 机 号：</span></td>

			<td>
					<input name="amount" type="text" value="15512346789" class="bdr1"/>	
                      <a href="#">添加</a>
                <p style="clear:both; color:red; font-size:12px;">请输入正确的手机号</p>
           			  </td>
		</tr>
           <tr>

			<td width="125" align="right">  BD 经 理：</td>

			<td>
						刘德华 15512346789
                        <a href="#">删除</a>			</td>
		</tr>
	    </table>

         <div class="titleH2"><span>工作地点</span></div>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall" id="configs">

		  <tr>
		    <td width="125" align="right"><span class="nec">配 置 一：</span></td>
		    <td>
            <a href="###" onclick="openSetConfig();">添加</a>
            </td>
		    </tr>
		  <tr>
		    <td align="right"></td>
		    <td>
            北京-海淀区-中关村，20人，00元/人，2016年07月01日-2016年08月01日
            <a href="###" onclick="openSetConfig();">修改 </a>
            <a href="###" onclick="copySets();">复制</a>
            <a href="#">删除</a>
            </td>
		    </tr>
		  <tr>
		    <td align="right"></td>
		    <td>
            北京-海淀区-中关村，20人，00元/人，2016年07月01日-2016年08月01日
            <a href="###" onclick="openSetConfig();">修改 </a>
            <a href="###" onclick="copySets();">复制</a>
            <a href="#">删除</a>
            </td>
		    </tr>
	    </table>
        
        <!--弹窗-->
        <style>
		input.bdr1, select.bdr1{ border:#ccc solid 1px; padding:5px 15px 5px 9px; background:#fff;}
		#setconfig{
		border:#999999 solid 5px; width:660px; position:absolute; left:50%; margin-left:-330px; background:#fff; z-index:99; padding-bottom:20px; position:absolute; display:none;
		}
		#setconfig .setH2{
			height:30px; line-height:30px; padding:0 20px; background:#f1f1f1;
		}
		#setconfig .setClose{
			position:absolute; right:0; top:0; padding:5px 10px; cursor:pointer;
		}
		</style>
        <script>
			function openSetConfig(){
				$('#setconfig').show();
				return false;
			}
			function closeSetConfig(){
				$('#setconfig').hide();
				return false;
			}
			function copySets(){
				$('#configs').append('<tr><td align="right">配 置 三：</td><td>北京-海淀区-中关村，20人，00元/人，2016年07月01日-2016年08月01日<a href="###" onclick="openSetConfig();">修改 </a><a href="###" onclick="copySets();">复制</a> <a href="#">删除</a></td></tr>');
			}
			
//			$(function(){
//				loadPlace(116.404, 39.915,12);
//			})
		</script>
        <div id="setconfig" style="">
        	<div class="setH2" style="">
            配 置 一
            </div>
            <div class="setClose" onclick="closeSetConfig();">x</div>
           	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>
		    <td width="125" align="right"><span class="nec">督导人数：</span></td>
		    <td>
            <input id="dd_nums" name="dd_nums" type="text"  value=""  class="bdr1"/>&nbsp;人
            </td>
		    </tr>
		  <tr>
		    <td align="right"> 备用人数：</td>
		    <td>
            <input id="dd_by_nums" name="dd_by_nums" type="text" value="" class="bdr1" />&nbsp;人
            </td>
		    </tr>
		  <tr>
		    <td align="right"><span class="nec">薪      资：</span></td>
		    <td colspan="3">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
					<tr>
						<td>
							<input id="ddxz" name="ddxz" type="text" value="" class="bdr1" style="margin-right: 10px;" />
						</td>
						<td width="80" style="padding:0px">
							<div id="work_xzdw_menu" class="input_text_50_bg" >单位</div>
							<div class="menu" id="menu_xzdw" >
								<ul>

									<?php echo tpl_function_qishi_get_classify(array('set' => "类型:payunit,列表名:c_payunit"), $this);?>

									<?php if (count((array)$this->_vars['c_payunit'])): foreach ((array)$this->_vars['c_payunit'] as $this->_vars['list']): ?>

									<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>

									<?php endforeach; endif; ?>

								</ul>
							</div>
							<input name="work_xzdw_id" type="hidden" id="work_xzdw_id" value="" />
							<input name="work_xzdw" type="hidden" id="work_xzdw" value="" />
						</td>
						<td width="80" style="padding:0px">
							<div id="work_jsfs_menu" class="input_text_50_bg" >结算</div>

							<div class="menu" id="menu_jsfs" >
								<ul>
									<?php echo tpl_function_qishi_get_classify(array('set' => "类型:jsfs,列表名:c_jsfs"), $this);?>
									<?php if (count((array)$this->_vars['c_jsfs'])): foreach ((array)$this->_vars['c_jsfs'] as $this->_vars['list']): ?>

									<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
									<?php endforeach; endif; ?>

								</ul>
							</div>
							<input name="work_jsfs_id" type="hidden" id="work_jsfs_id" value="" />
							<input name="work_jsfs" type="hidden" id="work_jsfs" value="" />
						</td>
					</tr>
					</tbody>
				</table>
            </td>
		    </tr>
			  <tr>
		    <td width="125" align="right"><span class="nec">兼职人数：</span></td>
		    <td>
            <input id="stations_jz_nums" name="stations_jz_nums" type="text"  value=""  class="bdr1"/>&nbsp;人
            </td>
		    </tr>
		  <tr>
		    <td align="right"> 备用人数：</td>
		    <td>
            <input id="stations_jz_by_nums" name="stations_jz_by_nums" type="text" value="" class="bdr1" />&nbsp;人
            </td>
		    </tr>
		  <tr>
		    <td align="right"><span class="nec">薪      资：</span></td>
		    <td>
            <input id="jz_xz" name="jz_xz" type="text" value="" class="bdr1" />

            </td>
		    </tr>
		  <tr>
		    <td align="right"><span class="nec">开始日期：</span></td>
		    <td>
                <input type="text" value="" class="bdr1" id="work_start" name="work_start" />

            </td>
		    </tr>
            <tr>
		    <td align="right"><span class="nec">结束日期：</span></td>
		    <td>
                <input type="text" value="" class="bdr1" id="work_end" name="work_end" />

            </td>
		    </tr>
			<tr>
				<td align="right"><span class="nec">上班时间：</span></td>
				<td colspan="2">
					<table border="0" cellpadding="0" cellspacing="0">
						<tbody>
						<tr>
							<td width="80" style="padding:0px">
								<div id="work_start_hour_menu" class="input_text_50_bg" >请选择</div>

								<div class="menu" id="menu_start_hour" >
									<ul>

										<?php echo tpl_function_qishi_get_classify(array('set' => "类型:workhours,列表名:c_workhours"), $this);?>

										<?php if (count((array)$this->_vars['c_workhours'])): foreach ((array)$this->_vars['c_workhours'] as $this->_vars['list']): ?>

										<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>

										<?php endforeach; endif; ?>

									</ul>
								</div>
								<input name="work_start_hour_id" type="hidden" id="work_start_hour_id" value="" />
								<input name="work_start_hour" type="hidden" id="work_start_hour" value="" />
							</td>
							<td width="20" style="padding:0px">时</td>
							<td width="80" style="padding:0px">
								<div id="work_start_minute_menu" class="input_text_50_bg" >请选择</div>

								<div class="menu" id="menu_start_minute" >
									<ul>
										<?php echo tpl_function_qishi_get_classify(array('set' => "类型:workminute,列表名:c_workminute"), $this);?>
										<?php if (count((array)$this->_vars['c_workminute'])): foreach ((array)$this->_vars['c_workminute'] as $this->_vars['list']): ?>

										<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
										<?php endforeach; endif; ?>

									</ul>
								</div>

								<input name="work_start_minute_id" type="hidden" id="work_start_minute_id" value="" />
								<input name="work_start_minute" type="hidden" id="work_start_minute" value="" />
							</td>
							<td width="20" style="padding:0px">分</td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
			<td align="right"><span class="nec">下班时间：</span></td>
			<td colspan="2">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="80" style="padding:0px">

								<div id="work_our_menu" class="input_text_50_bg">请选择</div>

								<div class="menu" id="menu_our" >
									<ul>

										<?php echo tpl_function_qishi_get_classify(array('set' => "类型:workhours,列表名:c_workhours"), $this);?>

										<?php if (count((array)$this->_vars['c_workhours'])): foreach ((array)$this->_vars['c_workhours'] as $this->_vars['list']): ?>

										<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>

										<?php endforeach; endif; ?>

									</ul>
								</div>
								<input name="work_end_hour_id" type="hidden" id="work_end_hour_id" value="" />
								<input name="work_end_hour" type="hidden" id="work_end_hour" value="" />
							</td>
							<td width="20" style="padding:0px">时</td>
							<td width="80" style="padding:0px">
								<div id="work_minute_menu" class="input_text_50_bg" >请选择</div>

								<div class="menu" id="menu_minute">
									<ul>
										<?php echo tpl_function_qishi_get_classify(array('set' => "类型:workminute,列表名:c_workminute"), $this);?>
										<?php if (count((array)$this->_vars['c_workminute'])): foreach ((array)$this->_vars['c_workminute'] as $this->_vars['list']): ?>

										<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
										<?php endforeach; endif; ?>

									</ul>
								</div>

								<input name="work_end_minute_id" type="hidden" id="work_end_minute_id" value="" />
								<input name="work_end_minute" type="hidden" id="work_end_minute" value="" />
							</td>
							<td width="20" style="padding:0px">分</td>

						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td align="right"><span class="nec">集合时间：</span></td>
			<td colspan="2">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
					<tr>
						<td width="80" style="padding:0px">
							<div id="work_jh_hour_menu" class="input_text_50_bg" >请选择</div>

							<div class="menu" id="menu_jh_hour" >
								<ul>

									<?php echo tpl_function_qishi_get_classify(array('set' => "类型:workhours,列表名:c_workhours"), $this);?>

									<?php if (count((array)$this->_vars['c_workhours'])): foreach ((array)$this->_vars['c_workhours'] as $this->_vars['list']): ?>

									<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>

									<?php endforeach; endif; ?>

								</ul>
							</div>
							<input name="work_jh_hour_id" type="hidden" id="work_jh_hour_id" value="" />
							<input name="work_jh_hour" type="hidden" id="work_jh_hour" value="" />
						</td>
						<td width="20" style="padding:0px">时</td>
						<td width="80" style="padding:0px">
							<div id="work_jh_minute_menu" class="input_text_50_bg" >请选择</div>

							<div class="menu" id="menu_jh_minute" >
								<ul>
									<?php echo tpl_function_qishi_get_classify(array('set' => "类型:workminute,列表名:c_workminute"), $this);?>
									<?php if (count((array)$this->_vars['c_workminute'])): foreach ((array)$this->_vars['c_workminute'] as $this->_vars['list']): ?>

									<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
									<?php endforeach; endif; ?>

								</ul>
							</div>

							<input name="work_jh_minute_id" type="hidden" id="work_jh_minute_id" value="" />
							<input name="work_jh_minute" type="hidden" id="work_jh_minute" value="" />
						</td>
						<td width="20" style="padding:0px">分</td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
            
            <tr>
		    <td align="right"><span class="nec">集合地点：</span></td>
		    <td>
              <input type="text" name="work_jh_dd" id="work_jh_dd" class="bdr1"/>
            </td>
		    </tr>
            
            <tr>
		    <td align="right"><span class="nec">工作地点：</span></td>
		    <td>

                省份：
            <select name="province" class="bdr1">
                <option value="0" >请选择省份</option>
            </select>
            城市：<select name="city" class="bdr1">
                <option value="0" >请选择城市</option>
            </select>
        <br/>
            县区：<select name="county" id="county" class="bdr1">
                <option value="0" >请选择区县</option>
            </select>
                商圈：<select name="business" id="business" class="bdr1">
                <option value="0" >请选择商圈</option>
            </select>

            <input type="text" name="fname" id="suggestId" class="bdr1"/>
	<div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;z-index:auto;"></div>
            <!--<button onclick="setPlace()"/>-->
            </td>
		    </tr>
            <tr>
		    <td align="right"></td>
		    <td>
            	<div style="min-height: 450px; margin-top: 5px; width:500px;" id="l-map"></div>
            </td>
		    </tr>
            <tr>
		    <td align="right"></td>
		    <td>
            	<input name="a" type="button" onclick="addStations()" value="保存"/>
            </td>
		    </tr>
	    </table>
        </div>
        <!--//弹窗-->
        <script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/area.js" type="text/javascript" language="javascript"></script>
        <script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/area2.js" type="text/javascript" language="javascript"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=E4vYNbh4LBcHlmzE9dmE5KVv2NMxvFBY"></script>
        
        <script type="text/javascript">

        var map = new BMap.Map("map"); // 创建Map实例
        var point;
        //根据经纬度显示地区
        function loadPlace(longitude, latitude, level) {
            if (parseFloat(longitude) > 0 || parseFloat(latitude) > 0) {
                level = level || 12;
                //绘制地图

                point = new BMap.Point(longitude, latitude); //地图中心点
                map.centerAndZoom(point, level); // 初始化地图,设置中心点坐标和地图级别。
                map.setCurrentCity("北京");
                map.enableScrollWheelZoom(true); //启用滚轮放大缩小
                //向地图中添加缩放控件
                var ctrlNav = new window.BMap.NavigationControl({
                    anchor: BMAP_ANCHOR_TOP_LEFT,
                    type: BMAP_NAVIGATION_CONTROL_LARGE
                });
                map.addControl(ctrlNav);

                //向地图中添加缩略图控件
                var ctrlOve = new window.BMap.OverviewMapControl({
                    anchor: BMAP_ANCHOR_BOTTOM_RIGHT,
                    isOpen: 1
                });
                map.addControl(ctrlOve);

                //向地图中添加比例尺控件
                var ctrlSca = new window.BMap.ScaleControl({
                    anchor: BMAP_ANCHOR_BOTTOM_LEFT
                });
                map.addControl(ctrlSca);


            }
        }<!--

        function setPlace() {
            map.clearOverlays();    //清除地图上所有覆盖物
            var myGeo = new BMap.Geocoder();// 将地址解析结果显示在地图上,并调整地图视野
            myGeo.getPoint(document.getElementById('suggestId').value, function (p) {
                if (p) {
                    lat = p.lat;
                    lng = p.lng;
                    map.centerAndZoom(p, 12);
//                    map.addOverlay(new BMap.Marker(p));
                    alert("地址："+lat+lng);
                }
                else {

                    alert("您选择地址没有解析到结果!");
                }
            }, document.getElementById('county').value);

        }

    </script>

<script type="text/javascript">
	// 百度地图API功能
	function G(id) {
		return document.getElementById(id);
	}

	var map = new BMap.Map("l-map");
	map.centerAndZoom("北京",12);                   // 初始化地图,设置城市和地图级别。
	var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
		{"input" : "suggestId"
		,"location" : map
	});

	ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
	var str = "";
		var _value = e.fromitem.value;
		var value = "";
		if (e.fromitem.index > -1) {
			value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		}    
		str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
		
		value = "";
		if (e.toitem.index > -1) {
			_value = e.toitem.value;
			value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		}    
		str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
		G("searchResultPanel").innerHTML = str;
	});

	var myValue;
	ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
	var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
        alert('ss');
            setPlace();
	});

	function setPlace(){
		map.clearOverlays();    //清除地图上所有覆盖物
		function myFun(){
			var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
			map.centerAndZoom(pp, 18);
			map.addOverlay(new BMap.Marker(pp));    //添加标注
		}
		var local = new BMap.LocalSearch(map, { //智能搜索
		  onSearchComplete: myFun
		});
		local.search(myValue);
	}
</script>
		<div class="titleH2"><span>职位描述</span></div>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right" valign="top"><span class="nec">职位描述</span>：</td>

			<td width="500">

			<div style="display:none;" id="template">

				<span class="tdTemplateTitle">&nbsp;</span><font style="color:#FF6600">（点击职位模板后会自动填充职位描述）</font>

				<span id="JobRequInfoTemplate"><a href="javascript:void(0);"></a></span>

			</div>

			<textarea id="contents" name="contents" style="width:700px;height:300px;visibility:hidden;"></textarea>

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

	<div class="titleH2"><span>联系方式</span></div>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right"><span class="nec">联系人</span>：</td>

			<td width="230"><input name="contact" type="text" class="input_text_200" id="contact" maxlength="20"   value="<?php echo $this->_vars['company_profile']['contact']; ?>
"/></td>

			<td><label><input name="contact_show" type="checkbox" value="1" checked="checked" />对外公开联系人</label></td>

		  </tr>

		   </table>

		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

			  <tr>

				<td width="125" align="right"><span class="nec">固定电话</span>：</td>

				<td width="280">

					<input type="text" id="landline_tel_first" name="landline_tel_first" class="input_text_33 input_text" id="landline_tel_first" maxlength="4"   value="<?php if ($this->_vars['company_profile']['landline_tel_first']):  echo $this->_vars['company_profile']['landline_tel_first'];  endif; ?>"/>&nbsp;-

					<input id="landline_tel_next" name="landline_tel_next" type="text" class="input_text_90 input_text" maxlength="11"   value="<?php if ($this->_vars['company_profile']['landline_tel_next']):  echo $this->_vars['company_profile']['landline_tel_next'];  endif; ?>"/>&nbsp;-

					<input id="landline_tel_last" name="landline_tel_last" type="text" class="input_text_49 input_text" maxlength="6"   value="<?php if ($this->_vars['company_profile']['landline_tel_last']):  echo $this->_vars['company_profile']['landline_tel_last'];  endif; ?>"/>

				</td>

				<td>&nbsp;</td>

			  </tr>

		  </table>

		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right"><span>联系手机</span>：</td>

			<td width="230">

			

            <input name="telephone" oninput="OnInput (event,'#telephone_two')" onpropertychange="OnPropChanged (event,'#telephone_two')" type="text" class="input_text_200" id="telephone" maxlength="35"   value="<?php echo $this->_vars['company_profile']['telephone']; ?>
"/></td>

			<td><label><input name="telephone_show" type="checkbox" value="1" checked="checked" />对外公开联系手机</label></td>

		  </tr>

		  </table>

		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <tr>

			<td width="125" align="right"><span class="nec">联系邮箱</span>：</td>

			<td width="230">

			

             <input name="email" oninput="OnInput (event,'#email_two')" onpropertychange="OnPropChanged (event,'#email_two')" type="text" class="input_text_200" id="email" maxlength="80" value="<?php echo $this->_vars['company_profile']['email']; ?>
"/>            	</td>

			<td><label><input name="email_show" type="checkbox" value="1" checked="checked" />对外公开联系邮箱</label></td>

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

			<tbody>

				<tr>

					<td width="125" align="right"><span class="nec">联系地址</span>：</td>

					<td ><input name="address" id="address" type="text" class="input_text_500" maxlength="100" value="<?php echo $this->_vars['company_profile']['address']; ?>
"/></td>

				 </tr>

			</tbody>

		</table>

		<div class="titleH2"><span style="background:none;">高级设置</span></div>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

			<tr>

				<td width="125" align="right"><span class="">简历接收邮箱</span>：</td>

				<td width="230"><input name="email_two" id="email_two" type="text" class="input_text_200" maxlength="80" value="<?php echo $this->_vars['company_profile']['email']; ?>
" disabled="disabled"/></td>

				<td><label><input name="notify" type="checkbox" value="1" checked="checked"/>接收</label></td>

		  	</tr>

			<tr>

				<td width="125" align="right"><span class="">简历短信通知</span>：</td>

				<td width="230"><input name="telephone_two" id="telephone_two" type="text" class="input_text_200" maxlength="80" value="<?php echo $this->_vars['company_profile']['telephone']; ?>
" /></td>

				<td><label><input name="notify_mobile" type="checkbox" value="1" id="receiveit"/>接收</label></td>

		  	</tr>

		</table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall">

		  <?php if ($this->_vars['verify_addjob'] == "1"): ?>

		  <tr>

			<td align="right"><span class="nec">验证码</span>：</td>

			<td>

				<div>

				<div id="imgdiv"></div>

				<input  class="input_text_200" name="postcaptcha" id="postcaptcha" type="text" value="点击获取验证码" style="color:#999999"/>

			</div>

			</td>

		  </tr>

		  <?php endif; ?>

		   <tr>

			<td width="125" align="right"> </td>

			<td ><input type="submit" name="submitsave" id="submitsave" value="发布"  class="but180lan" onclick="$(window).unbind('beforeunload');"/>

		     	</td>

		  </tr>

	    </table>

	    <input name="add_mode" type="hidden" id="add_mode" value="<?php echo $this->_vars['add_mode']; ?>
" />

<?php if ($this->_vars['add_mode'] == "1"): ?>

<script type="text/javascript">

$(document).ready(function()

{

	//积分默认

	total();

	//计算总计积分

	function total()

	{

			var points = <?php echo $this->_vars['points_total']; ?>
;

			var jobs_add = <?php echo $this->_vars['points']['jobs_add']['value']; ?>
;

			var totals=jobs_add;

			if (jobs_add>0)

			{		

				<?php if ($this->_vars['points']['jobs_add']['type'] == "1"): ?>

				var type="增加";

				<?php else: ?>

				var type="扣除";

				<?php endif; ?>	

			$("#total").html("发布本条信息总计"+type+"&nbsp;<span style=\"font-size:20px; color: #FF0000\" >"+totals+"</span>&nbsp;<?php echo $this->_vars['QISHI']['points_quantifier'];  echo $this->_vars['QISHI']['points_byname']; ?>
，你目前共有<strong style=\"color:#0033FF\"> <?php echo $this->_vars['points_total']; ?>
  </strong><?php echo $this->_vars['QISHI']['points_quantifier'];  echo $this->_vars['QISHI']['points_byname']; ?>
；<br />");

			$("#totals").val(<?php echo $this->_vars['points_total']; ?>
-totals);	

			}

	}				

	$("#addsubmit").click(function()

	{

		if ($("#totals").val()<0)

		{

			<?php if ($this->_vars['QISHI']['operation_mode'] == "2"): ?>

			dialog({

			  title: '系统提示',

			  content: "您的积分不足，请申请新的服务或者充值积分！",

			  width:'300px'

			}).showModal();

			<?php else: ?>

			dialog({

			  title: '系统提示',

			  content: "您的积分不足，请充值后再发布！",

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

<div style="position:relative;padding-left:125px;">

	  <table width="100%" border="0" cellpadding="20" cellspacing="0" class="link_lan" bgcolor="F9F9F9" >

            <tr>               
              <td align="center" >

              	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableall"  bgcolor="F9F9F9">
		   <tr>

			<td width="360" align="left">

				<div id="total"></div>

			</td>

		  </tr>

	    </table>

              	</td>

            </tr>

      </table>

</div>

<?php endif; ?>

</form> 

	  </div>

	</div>

  </div>

  <div class="clear"></div>

</div>

<!-- 职位亮点选择框 -->

<div id="tagBox" class="alert-window" style="display:none;width: 810px; height: 300px; left: 50%; top: 600px; margin-left: -405px; position: absolute; z-index: 100001;">

	<div style="width: 810px;" class="resume-tc">

        <div class="resume-tc-head">

            <h3><i class="icon-loc"></i> 请选职位两点（最多选择5个）</h3>

            <a class="close wd_close cm_closeMsg" href="javascript:;"></a> 

        </div>

        <div class="sx-yx">

        	<span class="clr-grn fnt-b">已选：</span>

        	<span id="box_checkedTag"></span>

        </div>

        <div id="showTag" style="width:810px; height: 200px; overflow: auto; overflow-x: hidden; overflow-y: auto; position: relative;">

	        

		</div>

        <div class="sx-action">

        	<button id="btn_tagsave" class="grn" type="button">确定</button> 

        </div>

    </div>

</div>

 <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("user/footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>

</body>

</html>

