<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=750" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="">
<meta name="format-detection" content="telephone=no">
<title>ȫ������</title>
<link rel="stylesheet" href="http://static.yjob.net/layout/blue/css/glide.css">
<link rel="stylesheet" href="http://static.yjob.net/layout/blue/css/common.css">
<link rel="stylesheet" href="http://static.yjob.net/layout/blue/css/style.css">
<script type="text/javascript" src="./js/jquery-1.11.3.js" ></script>
<script type='text/javascript' src="./js/jquery.common.js" ></script>
<script type="text/javascript" src="./js/iscroll.js" ></script>
<script type="text/javascript" src="http://static.yjob.net/layout/blue/js/filter.js" ></script>
<script type='text/javascript' src="./js/jquery.pinterest.js" ></script>

<script src="{#$QISHI.main_domain#}data/cache_classify.js" type='text/javascript' charset="utf-8"></script>
<script type="text/javascript">
		$(document).ready(function() {
			var key = $("#key").val();
				district = $("#hdistrict").val(),
				sdistrict = $("#hsdistrict").val(),
				district_cn = $("#hdistrict_cn").val(),
				experience = $("#hexperience").val(),
				experience_cn = $("#hexperience_cn").val(),
				education = $("#heducation").val(),
				education_cn = $("#heducation_cn").val(),
				topclass = $("#htopclass").val(),
				category = $("#hcategory").val(),
				subclass = $("#hsubclass").val(),
				category_cn = $("#hcategory_cn").val(),
				settr = $("#hsettr").val(),
				settr_cn = $("#hsettr_cn").val(),
				wage = $("#hwage").val(),
				wage_cn = $("#hwage_cn").val(),
				nature = $("#hnature").val(),
				nature_cn = $("#hnature_cn").val(),
				scale = $("#hscale").val(),
				scale_cn = $("#hscale_cn").val();
			pinterest("{#$QISHI.wap_domain#}/plus/ajax.php?act=ajaxjobslist&key="+key+"&district=" + district + "&sdistrict=" + sdistrict + "&experience=" + experience + "&education=" + education + "&topclass=" + topclass + "&category=" + category + "&subclass=" + subclass + "&settr=" + settr + "&wage=" + wage + "&nature=" + nature + "&scale=" + scale + "&district_cn=" + district_cn + "&category_cn=" + category_cn + "&experience_cn=" + experience_cn + "&settr_cn=" + settr_cn + "&education_cn=" + education_cn + "&wage_cn=" + wage_cn + "&nature_cn=" + nature_cn + "&scale_cn=" + scale_cn + "");
				/*$(".search-block input").on("focus",function(e){
				if($("body").has("#search_div").length){
					searchBar.show();
				}else{
					searchBar.init();
				}
				//$("#search_div .search input").focus();
			});*/
		});
	</script>

</head>
<div class="layout pb100">
	
	<div class="header header_n1">		
			<div class="head">
				<h2>ȫ������</h2>
			<div class="return ">
				<a href="#"></a>
			</div>
			</div>
	</div>
	
		
	
		<div class="mask">
			
		</div>
	<div class="city_filter select_bar">
		<ul>
            <li data-go="cityjob"><h4>{#if $smarty.get.cityjob#}{#$smarty.get.cityjob#}{#else#}����{#/if#}<em></em></h4>
				<div class=" city_filter_nav " id="cityjobList">
					<ul>
						{#foreach from=$subsite item=list key=k#}
						<li data-val="{#$list.s_id#}" data-txt="{#$list.s_districtname#}" ><h2>{#$list.s_districtname#}</h2>
                        	<div class="city_filter_sub" style="display:none;">
								<dl>
                                	{#qishi_get_classify set="�б���:city,����:QS_district,id:$list.s_district,��ʾ��Ŀ:100"#}
									<dd data-val="{#$list.s_district#},0" data-txt="ȫ{#$list.s_districtname#}">ȫ{#$list.s_districtname#}</dd>
                                    {#foreach from=$city item=li#}
									<dd data-val="{#$list.s_district#},{#$li.id#}" data-txt="{#$li.categoryname#}">{#$li.categoryname#}</dd>
                                    {#/foreach#}
								</dl>
							</div>
                        </li>
						{#/foreach#}

					</ul>
				</div>
			</li>
			<li class=" s_job" data-go="jobjob"><h4>{#if $smarty.get.category_cn#}{#$smarty.get.category_cn#}{#else#}ְλ����{#/if#}<em></em></h4>
				<div class="city_filter_nav job_filter_nav " id="jobjobList">
					{#qishi_get_classify set="�б���:jobs_parent,����:QS_jobs,id:1065,��ʾ��Ŀ:100"#}
					<ul>
						<li data-val="" data-txt="����"><h2>����</h2></li>
						{#foreach from=$jobs_parent item=list#}
						<li data-val="1,1065,{#$list.id#}" data-txt="{#$list.categoryname#}"><h2>{#$list.categoryname#}</h2></li>
						{#/foreach#}

					</ul>
				</div>
			</li>
            <li class=" s_job" data-go="naturejob"><h4>{#if $smarty.get.nature_cn#}{#$smarty.get.nature_cn#}{#else#}��������{#/if#}<em></em></h4>
                <div class="city_filter_nav job_filter_nav " id="naturejobList">
                    {#qishi_get_classify set="�б���:nature,����:QS_jobs_nature,��ʾ��Ŀ:100"#}
                    <ul>
                            <li data-val="" data-txt="����"><h2>����</h2></li>
                            {#foreach from=$nature item=list#}
                            <li data-val="1,1065,{#$list.id#}" data-txt="{#$list.categoryname#}"><h2>{#$list.categoryname#}</h2></li>
                            {#/foreach#}
                    </ul>
                </div>
            </li>
            <li data-go="orderjob" class="s_job"><h4>Ĭ������<em></em></h4>
                <div class="city_filter_nav job_filter_nav" id="orderjobList">
                    <ul>
                        <li data-val="0" data-txt="����"><h2>����</h2></li>
                        <li data-val="100" data-txt="Ĭ������" ><h2>Ĭ������</h2></li>
                        <li data-val="200" data-txt="�������"><h2>�������</h2></li>
                        <li data-val="300" data-txt="���·���"><h2>���·���</h2></li>
                        <li data-val="400" data-txt="�������"><h2>�������</h2></li>
                    </ul>
                </div>
            </li>
        </ul>
            <input type="hidden" id="hdistrict" value="{#$smarty.get.district#}">
            <input type="hidden" id="key" value="{#$smarty.get.key#}">
            <input type="hidden" id="hsdistrict" value="{#$smarty.get.sdistrict#}">
            <input type="hidden" id="hdistrict_cn" value="{#$smarty.get.district_cn#}">
            <input type="hidden" id="htopclass" value="{#$smarty.get.topclass#}">
            <input type="hidden" id="hcategory" value="{#$smarty.get.category#}">
            <input type="hidden" id="hsubclass" value="{#$smarty.get.subclass#}">
            <input type="hidden" id="hcategory_cn" value="{#$smarty.get.category_cn#}">
            <input type="hidden" id="hwage" value="{#$smarty.get.wage#}">
            <input type="hidden" id="hwage_cn" value="{#$smarty.get.wage_cn#}">
            <input type="hidden" id="hsettr" value="{#$smarty.get.settr#}">
            <input type="hidden" id="hsettr_cn" value="{#$smarty.get.settr_cn#}">
            <input type="hidden" id="heducation" value="{#$smarty.get.education#}">
            <input type="hidden" id="heducation_cn" value="{#$smarty.get.education_cn#}">
            <input type="hidden" id="hexperience" value="{#$smarty.get.experience#}">
            <input type="hidden" id="hexperience_cn" value="{#$smarty.get.experience_cn#}">
            <input type="hidden" id="hnature" value="{#$smarty.get.nature#}">
            <input type="hidden" id="hnature_cn" value="{#$smarty.get.nature_cn#}">
            <input type="hidden" id="order_type" value="{#$smarty.get.order_type#}">
            <input type="hidden" id="hscale" value="{#$smarty.get.scale#}">
            <input type="hidden" id="hscale_cn" value="{#$smarty.get.scale_cn#}">
	</div>
	
	<div class="new_job new_jobb" style="min-height:1000px; background:#fff;">
	
		<!--ˢ�¿�ʼ-->
			<table>
			<tbody  class="body" id="container">
			{#foreach from=$jobs item=list key=kkk#}	
                            <tr>
                                <td>
                                        <section class="jobs-item thisurl box" url="{#$list.url#}">
                                                {#if $kkk%3==0#}
                                                <div class="ico ico_n1">{#$list.category_name#}</div>
                                                {#elseif $kkk%3==1#}
                                                <div class="ico ico_n2">{#$list.category_name#}</div>											
                                                {#else#}
                                                <div class="ico ico_n3">{#$list.category_name#}</div>
                                                {#/if#}

                                <div class="txt">
                                        <h4>{#$list.job_name#}</h4>
                                        <h5><em class="n1"></em>{#$list.start_date#}-{#$list.start_date#}</h5>
                                        <h5><em class="n2"></em>{#$list.district_cn#}</h5>
                                </div>
                                <div class="sup">

                                        {#if $list.wage_amount>0#}
                                                <span>{#$list.wage_amount#} {#$list.wage_cn#}</span>
                                        {#else#}
                                                <span>{#$list.wage_cn#}</span>
                                        {#/if#}

                                </div>
                                <div class="pic">
                                    <dl>
                                        {#foreach from=$list.jobspecial_cn item=listli key=kkk #}
                                            {#if $kkk%3==0#}
                                            <dd class="pic1">{#$listli#}</dd>
                                            {#elseif $kkk%3==1#}
                                            <dd class="pic2">{#$listli#}</dd>											
                                            {#else#}
                                            <dd class="pic3">{#$listli#}</dd>
                                            {#/if#}
                                        {#/foreach#}
                                    </dl>
                                </div>

                                </section>
                                </td>
                            </tr>
			{#/foreach#}		
			</tbody>
		</table>	
	</div><!--new_job����-->
	<script src="http://static.ydbimg.com/API/YdbOnline.js" type="text/javascript"></script>
<script type="text/javascript">
var YDB = new YDBOBJ();
     YDB.SetStatusBarStyle(1);
</script>
<script type="text/javascript">
var YDB = new YDBOBJ();
    YDB.SetMenuBar(1);
		
</script>
	
	<div class="pull-down pull-downn">
		<span>����ˢ��...</span>
	</div>
	<div class="remindnoinfo">
					<span>û�и���ְλ�ˣ�</span>
				</div>
	<div class="h_hight">
	</div>
{#include file="m/m-footer.htm"#}
	
</div><!--loyout����-->

<body>

<script type="text/javascript" src="http://static.yjob.net/layout/blue/js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="http://static.yjob.net/layout/blue/js/jquery.glide.js"></script>
<script type="text/javascript" src="http://static.yjob.net/layout/blue/js/script.js"></script>
<script>
	$(function(){
		$(window).bind('scroll',function(bb){
			
			 bb.stopPropagation();
			 
			var a = $(document).height() - $(window).height();
			//console.log( Math.abs($(window).scrollTop()) + '-------' +  + '---' + );
			if(Math.abs($(window).scrollTop()) >= a){
				
			
				$('.pull-down').show();
				
				setTimeout(function(){
					$('.pull-down').hide();
				},2000)
			}
			
			
			if(Math.abs($(window).scrollTop()) <= 0){
			
				$('.pull-up').show();
				
				setTimeout(function(){
					$('.pull-up').hide();
				},2000)
			}
		})
		
		//nav
		$('.city_filter li').hover(function(){
			$(this).find('.city_filter_nav').show();
			$(this).addClass('selected');
			$(this).find('li').eq(0).find('.city_filter_sub').show();
			$(this).find('li').eq(0).addClass('selected');
		},
		function(){
			$(this).find('.city_filter_nav').hide();
			$(this).removeClass('selected');
		})
		//subnav
		$('.city_filter li li').hover(function(){
			$(this).find('.city_filter_sub').show();
			$(this).addClass('selected');
		},
		function(){
			$(this).find('.city_filter_sub').hide();
			$(this).removeClass('selected');
		})
		
		
		
	})
	//���ص�ַ��
	addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
      function hideURLbar(){
                window.scrollTo(0,1);
      } 
</script>
</body>
</html>
