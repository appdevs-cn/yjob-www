<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_parse_url.php'); $this->register_modifier("qishi_parse_url", "tpl_modifier_qishi_parse_url",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-25 14:32 CST */ ?>
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

<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.vtip-min.js" type="text/javascript" language="javascript"></script>

<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.reasontip-min.js" type='text/javascript' language="javascript"></script>

<script type="text/javascript">

$(document).ready(function(){

	// ����ְλ �ɹ���ʾ����
	var addjobs_save_succeed="<?php echo $this->_vars['jobs_one']['id']; ?>
";
	if(addjobs_save_succeed>0)

	{
		var d=dialog({

	        title: 'ϵͳ��ʾ',

	        content: $(".addjob-success-dialog"),

	        cancelDisplay: false,

	        cancel: function () {

	        	window.location.href="?act=jobs";

	        }

	    }).showModal();

	}

	// �����ر�

	$(".ctrl-close").click(function(event) {

		var mycoDialog=dialog(),

		url = $(this).attr("url");

		mycoDialog.title('ϵͳ��ʾ');

		mycoDialog.content('<div class="del-dialog"><div class="tip-block"><span class="del-tips-text close-tips-text">�رպ󽫲�����չʾ��Ƹ��Ϣ����ȷ��Ҫ�ر���</span></div></div><div class="center-btn-wrap"><input type="button" value="ȷ��" class="btn-65-30blue btn-big-font DialogSubmit" /><input type="button" value="ȡ��" class="btn-65-30grey btn-big-font DialogClose" /></div>');

	    mycoDialog.width('300');

	    mycoDialog.showModal();

	    /* �ر� */

	    $(".DialogClose").live('click',function() {

	      mycoDialog.close().remove();

	    });

	    // ȷ��

	    $(".DialogSubmit").click(function() {

	    	if (url) {window.location.href=url};

	    });

	});

	/*

		����ɸѡ 36 

	*/

	$('.data-filter').on('click', function(e){

		$(this).find('.filter-down').toggle();

		// ��̬���������б�����

		var fWidth = $(this).find('.filter-span').outerWidth(true) - 2;

		$(this).find(".filter-down").width(fWidth);

		// �������λ����������

		$(document).one("click",function(){

			$('.filter-down').hide();

		});

		e.stopPropagation();

		//�������ʱ������������

		$(".data-filter").not($(this)).find('.filter-down').hide();

	});

	vtip_reason("<?php echo $this->_vars['QISHI']['site_dir']; ?>
","jobs_reason");

	// ����ˢ��

	$('.refresh').on('click', function()

	{

		var jobsid = $(this).attr("jobsid"),
                
		ajax_url = "company_ajax.php?act=jobs_refresh_ajax&jobsid="+jobsid,

		msg = '';

		var myDialog = dialog();

		myDialog.title('ˢ����ʾ');

		myDialog.content("������...");

		myDialog.width('300');

		myDialog.showModal();

		jQuery.ajax({

			url: ajax_url,

			success: function (data) {

				myDialog.content(data);

				/* �ر� */

				$(".DialogClose").live('click',function() {

				myDialog.close().remove();

				});

				/* ȷ������ */

				$(".DialogSubmit").click(function() 

				{

					window.location.href="company_jobs.php?act=jobs_perform&y_id="+jobsid+"&refresh=1";

				});

			}

		});

	});

	// ����ˢ��

	$("#refresh_all").on('click', function(){

		var length=$("#form1 :checkbox[name='y_id[]'][checked]").length;

		$.get("company_ajax.php?act=jobs_all_refresh_ajax",{length:length},

		function(result)

		{

			var myDialog=dialog();

				myDialog.title('ˢ����ʾ');

				myDialog.content(result);

				myDialog.width('300');

				myDialog.showModal();

				/* �ر� */

				$(".DialogClose").live('click',function() {

					myDialog.close().remove();

					return false;

				});

				// ȷ��

				$(".DialogSubmit").click(function() 

				{

					$("#form1").submit();

				});

		});

	});

	/*���� �ر�ְλ */

	$("#display2").click(function(){

		var length=$("#form1 .check-control :checkbox[checked]").length;

		if(length>0)

		{

			var cof = confirm("���Ƿ�Ҫ�ر���ѡ�е�ְλ������ѡ��"+length+"��ְλ,ȷ���ر���");

			if(cof) {

				return true;

			} else {

				return false;

			}

		} else {
			alert("��û��ѡ��ְλ��");

			return false;

		}
	});

	// ɾ������

	delete_dialog('.ctrl-del','#form1');
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
">��Ա����</a> > ְλ����</div>

<div class="usermain">

  <div class="leftmenu  com link_bk">
  	 <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("member_company/left.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  </div>

  <div class="rightmain">

 	<div class="bbox1 link_bk my_account">

		<div class="topnav">

			<div class="topnav get_resume">

                            <div class="titleH1"><div class="h1-title">����ְλ</div></div>

                            <div class="navs link_bk">

                                <a href="?act=<?php echo $this->_vars['act']; ?>
&status=100" <?php if ($_GET['status'] == "100"): ?>class="se"<?php endif; ?>>

                                ������ְλ<span >(<?php echo $this->_vars['jobs_total'][1]; ?>
)</span></a>

                                <a href="?act=<?php echo $this->_vars['act']; ?>
&status=200" <?php if ($_GET['status'] == "200"): ?>class="se"<?php endif; ?>>

                                �����ְλ<span >(<?php echo $this->_vars['jobs_total'][2]; ?>
)</span></a>

                                <a href="?act=<?php echo $this->_vars['act']; ?>
&status=300" <?php if ($_GET['status'] == "300"): ?>class="se"<?php endif; ?>>δ��ʾְλ<span class="check">(<?php echo $this->_vars['jobs_total'][3]; ?>
)</span></a>

                                <a href="?act=<?php echo $this->_vars['act']; ?>
" <?php if ($_GET['status'] == ""): ?>class="se"<?php endif; ?>>

                                ȫ��ְλ<span >(<?php echo $this->_vars['jobs_total'][0]; ?>
)</span></a>

                                <div class="clear"></div>

                            </div>
			</div>
		</div>

<form id="form1" name="form1" method="post" action="?act=jobs_perform">
		<!-- �µķ�����ְλ -->
    <?php if ($_GET['jobtype'] == ""): ?>
        
    <style>
    .c-data-top.com-job-ma .top-item1, .c-data-content.com-job-ma .content1{
            width:350px;
    }
    .content1-1,
    .top-item1-1{
            width:200px;
    }
    .content1-1 a,
    .top-item1-1 a{
            color:#0180cf;
    }
    </style>

    <div class="company-data-list">

            <div class="c-data-top com-job-ma clearfix">

                    <div class="item f-left check-item"><input type="checkbox" name="chkAll"   id="chk" title="ȫѡ/��ѡ" /></div>

                    <div class="item f-left top-item1">ְλ����</div>
                    <div class="item f-left top-item1-1">&nbsp;</div>

                    <div class="item f-left top-item2">
                        <span class="filter-span">���ˢ��ʱ��<i class="filter-icon"></i></span>
                    </div>

                    <div class="item f-left top-item3">
                        <span class="filter-span">&nbsp;&nbsp;��&nbsp;&nbsp;��<i class="filter-icon"></i></span>
                    </div>

            </div>

            <style>
            select.bdr1{ border:#ccc solid 1px; background:#fff;}
            </style>
            <?php if ($this->_vars['jobs']): ?>

            <?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['li']): ?>

            <div class="c-data-row check-control">

                    <div class="c-data-content com-job-ma clearfix">

                        <div class="c-item f-left check-item"><input name="y_id[]" type="checkbox" id="y_id"  value="<?php echo $this->_vars['li']['id']; ?>
"/></div>

                <div class="c-item f-left content1">
                        <div class="job-ma-block">
<!--							<div><a href="/jobs/jobs-show.php?id=<?php echo $this->_vars['li']['id']; ?>
" target="_blank" class="name-link underline" title="<?php echo $this->_vars['li']['jobs_name_']; ?>
"><?php echo $this->_vars['li']['job_name']; ?>
</a></div>-->
<div><a href="#" target="_blank" class="name-link underline" title="<?php echo $this->_vars['li']['jobs_name_']; ?>
"><?php echo $this->_vars['li']['job_name']; ?>
</a></div>
                                <p>ӦƸ������<a href="company_recruitment.php?act=apply_jobs&jobsid=<?php echo $this->_vars['li']['id']; ?>
&jobname=<?php echo $this->_vars['li']['jobs_name_']; ?>
" class="data-ctrl underline"><?php echo $this->_vars['li']['countresume']; ?>
</a></p>
                        </div>
                </div>
        <div class="c-item f-left content1-1">
            &nbsp;
        </div>
            <div class="c-item f-left content2"><span class="hasyuyue"><?php echo $this->_run_modifier($this->_vars['li']['refurbish_time'], 'date_format', 'plugin', 1, "%Y-%m-%d %H:%M:%S"); ?>
</span></div>
            <div class="c-item f-left content3">
                <div class="job-ma-ctrl">
                    <?php if ($this->_vars['li']['status'] == 100): ?>
                    <a href="?act=editjobs&id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�޸�</a>&nbsp;<a url="?act=jobs_perform&display2=1&y_id=<?php echo $this->_vars['li']['id']; ?>
" href="javascript:;" class="data-ctrl underline ctrl-close">�ر�</a>&nbsp;<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a><br>
                    <a  href="javascript:;" jobsid="<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline refresh">ˢ��</a>
                    <?php else: ?>
                     <a href="?act=editjobs&id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�޸�</a>&nbsp;<a href="?act=jobs_perform&display1=1&y_id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�ָ�</a>&nbsp;<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a><br>
                    <?php endif; ?>
                </div>
            </div>

            </div>

            </div>

            <?php endforeach; endif; ?>

            <script type="text/javascript">

                    /*�鿴ԤԼ*/

                    $(".appointmentShow").live('click', function()

                    {

                            var id =$(this).attr('data');

                            var myDialog = dialog();

                        jQuery.ajax({

                            url: 'company_ajax.php?act=auto_refresh&id='+id,

                            success: function (data) {

                                myDialog.content(data);

                                myDialog.title('ԤԼ����');

                                myDialog.width('500');

                                myDialog.showModal();

                            }

                        });

                    });

                    $(".appointmentSee").die().live('click', function(event) {

                            var appointDia =  dialog({

                                    title: 'ԤԼˢ��',

                                    content: $('.yuyue-dialog'),

                                    width: '420px'

                            });

                            appointDia.showModal();

                            $(".DialogClose").live('click',function() {

                          appointDia.close().remove();

                        });

                            var jobNameIdArray = $(this).attr('data').split(",");

                            $("#appointJobName").html(jobNameIdArray[0]).attr("jobid",jobNameIdArray[1]);

                            $("#aloneIntegralDays").keyup(function() {

                                    var dayCount = parseInt($(this).val()), thepointAll = parseInt($("#consumptionPoint").html()), thepointEvery = parseInt($("#everyDayConsumptionPoint").html());

                                    dayCount ? dayCount = dayCount : dayCount = 0;

                                    $("#aloneIntegral").html(dayCount*thepointEvery);

                                    $("#theConsumptionPoint").html(dayCount*thepointEvery);

                                    if (thepointAll < dayCount*thepointEvery) { // �������Ļ��ִ����ܻ��ֲ���ԤԼ

                                            $('input[name=toMakeAppointment]').removeClass('toMakeAppointment');

                                            $("#theNoEnouPoint").show();

                                    } else {

                                            $('input[name=toMakeAppointment]').addClass('toMakeAppointment');

                                            $("#theNoEnouPoint").hide();

                                    }

                            });

                            $(".toMakeAppointment").die().live('click', function(event) {

                                    if (!$("#aloneIntegralDays").val()) {

                                            alert("��дԤԼ������");

                                            $("#aloneIntegralDays").focus();

                                            return false;

                                    }

                                    var dataCode = $("#appointJobName").attr('jobid')+","+$("#aloneIntegralDays").val()+","+$("#theConsumptionPoint").html();

                                    $.get('company_recruitment.php?act=refresh_appointment', {data_arr:dataCode}, function(data){

                                            appointDia.content(data);

                                    });

                            });

                            $(".batchAppoint").click(function(e) {

                                    appointDia.content($('.yuyue-all-dialog'));

                                    appointDia.width("540px");

                                    var oldDataPool = new Array(), oldListHtmArray = $(".yue-left-block .yue-item");

                                    $.each(oldListHtmArray, function(index, val) {

                                            var oldHtmId = $(this).attr('reid'), oldHtmCn = $(this).find(".appoint").attr('data');

                                            oldDataPool.push(oldHtmId+','+oldHtmCn);

                                    });

                                    $(".appoint").die().live('click', function() {

                                            var yitObj = $(this).closest('.yue-item'), jobName = $(this).attr('data'), jobId = yitObj.attr('reid'), rightListHtm = '';

                                            oldDataPool.splice(jQuery.inArray(jobId+','+jobName,oldDataPool),1);

                                            yitObj.remove();

                                            rightListHtm += '<div class="hasyue-item clearfix" reid="'+jobId+'"><div class="hasyue-job f-left">'+jobName+'</div><a href="javascript:;" class="notyue-btn f-left cancelAppoint" data="'+jobName+'">ȡ��</a><div class="yue-time f-right"><input class="batchAppDays" type="text" /> ��</div></div>';

                                            $(".yue-right-block").append(rightListHtm);

                                            // ����ԤԼʱ�������Ļ���

                                            $(".batchAppDays").die().live('keyup', function(event) {

                                                    var pvdysa= parseInt($("#bacMoreTime").html()), evallPointVal = 0;

                                                    $(".yue-right-block .batchAppDays").each(function(index, el) {

                                                            var evdysa = parseInt($(this).val());

                                                            evdysa ? evdysa = evdysa : evdysa = 0;

                                                            evallPointVal += pvdysa*evdysa;

                                                    });

                                                    $("#bAlPiont").html(evallPointVal);

                                                    if (parseInt($("#bAlPiontLast").html()) < evallPointVal) {

                                                            $("#noEnouPoint").show();

                                                            $('input[name=aKeyAppoint]').removeClass('aKeyAppoint');

                                                    } else {

                                                            $("#noEnouPoint").hide();

                                                            $('input[name=aKeyAppoint]').addClass('aKeyAppoint');

                                                    }

                                            });

                                            // һ��ԤԼ

                                            $(".aKeyAppoint").die().live('click', function(event) {

                                                    if (!$(".yue-right-block .hasyue-item").length > 0) {

                                                            alert("����ԤԼְλ��");return false;

                                                    };

                                                    var isalertPoi = 0;

                                                    $(".yue-right-block .batchAppDays").each(function(index, el) {

                                                            isalertPoi += parseInt($(this).val());

                                                    });

                                                    if (!isalertPoi > 0) {

                                                            alert("����дԤԼ������");return false;

                                                    };

                                                    var aPArray = new Array();

                                                    $(".yue-right-block .hasyue-item").each(function(ind, eldd) {

                                                            var ajid = $(this).attr('reid'), ajname = $(this).find(".batchAppDays").val(),

                                                                    ajpoint = parseInt($(this).find('.batchAppDays').val());

                                                            ajpoint ? ajpoint = ajpoint : ajpoint = 0;

                                                            var ajpointAll = ajpoint*parseInt($("#bacMoreTime").html())

                                                            aPArray[ind] = ajid+","+ajname+","+ajpointAll;

                                                    });

                                                    $.get('company_recruitment.php?act=refresh_appointment', {data_arr:aPArray}, function(data) {

                                                            appointDia.content(data);

                                                    });

                                            });

                                            $(".cancelAppoint").die().live('click', function() {

                                                    var oldYitObj = $(this).closest('.hasyue-item'), oldJobName = $(this).attr('data'), oldJobId = oldYitObj.attr('reid'), leftListHtm = '<div class="yue-title clearfix"><span class="f-left">��ԤԼְλ</span></div>';

                                                    oldDataPool.push(oldJobId+','+oldJobName);

                                                    oldYitObj.remove();

                                                    $.each(oldDataPool, function(index, val) {

                                                            var leftHtmArray = val.split(",");

                                                            leftListHtm += '<div class="yue-item clearfix" reid="'+leftHtmArray[0]+'"><p class="yue-job f-left">'+leftHtmArray[1]+'</p><a href="javascript:;" class="yue-btn f-right appoint" data="'+leftHtmArray[1]+'">ԤԼ</a></div>';

                                                    })

                                                    $(".yue-left-block").html(leftListHtm);

                                            });

                                    });

                            })

                    });

            </script>
            <div class="c-data-row last">

                    <div class="c-data-content apply_jobs clearfix">

                            <div class="c-item f-left check-item"><input type="checkbox" name="chkAll"   id="chk2" title="ȫѡ/��ѡ" /></div>

                            <div class="data-last-btn f-left">

                                    <?php if ($this->_vars['QISHI']['operation_mode'] == "3"): ?>

                                    <input type="hidden" name="refresh" id="refresh" value="1" />

                                    <input type="button" name="refresh" class="btn-65-30blue"  value="ˢ��ְλ"  id="refresh_all"/>

                                    <?php else: ?>

                                    <input type="hidden" name="refresh" id="refresh" value="1" />

                                    <input type="button" name="refresh" class="btn-65-30blue"  value="ˢ��ְλ"  id="refresh_all"/>

                                    <?php endif; ?>

                                    <input type="submit" value="�ر�" name="display2" class="btn-65-30blue" id="display2"/>

                                    <input type="button" name="delete" class="btn-65-30blue ctrl-del" value="ɾ��" id="delete" act="?act=jobs_perform&delete=1"/>

                            </div>

                    </div>

            </div>

            <?php else: ?>

            <div class="c-data-row emptytip">û���ҵ���Ӧ��ְλ��Ϣ</div>

            <?php endif; ?>

    </div>

		<?php endif; ?>

		<!-- ����е� ְλ -->

		<?php if ($_GET['jobtype'] == "2"): ?>

		<div class="company-data-list">

			<div class="c-data-top com-job-ma clearfix">

				<div class="item f-left check-item"><input type="checkbox" name="chkAll"   id="chk"/></div>

				<div class="item f-left top-item1">ְλ����</div>

				<div class="item f-left top-item2">��������</div>

				<div class="item f-left top-item3" style="text-align: center;">����</div>

			</div>

			<?php if ($this->_vars['jobs']): ?>

			<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['li']): ?>

			<div class="c-data-row">

				<div class="c-data-content com-job-ma3 clearfix">

					<div class="c-item f-left check-item"><input type="checkbox" name="y_id[]" id="y_id"  value="<?php echo $this->_vars['li']['id']; ?>
" class="checkbox" /></div>

					<div class="c-item f-left content1" style="width:535px;">

						<div class="job-ma-block">

							<div><a href="<?php echo $this->_vars['li']['jobs_url']; ?>
" target="_blank" class="name-link underline" title="<?php echo $this->_vars['li']['jobs_name_']; ?>
"><?php echo $this->_vars['li']['jobs_name']; ?>
</a></div>

							<p>ӦƸ������<?php echo $this->_vars['li']['countresume']; ?>
 | ����ʱ�䣺<?php echo $this->_run_modifier($this->_vars['li']['refreshtime'], 'date_format', 'plugin', 1, "%Y-%m-%d %H:%M"); ?>
</p>

						</div>

					</div>

					<div class="c-item f-left content2" style="width:218px;"><?php echo $this->_vars['li']['district_cn']; ?>
</div>

					<div class="c-item f-left content3">

						<a href="?act=editjobs&id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�޸�</a>&nbsp;<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a>

					</div>

				</div>

			</div>

			<?php endforeach; endif; ?>

			<div class="c-data-row last">

				<div class="c-data-content apply_jobs clearfix">

					<div class="c-item f-left check-item"><input type="checkbox" name="chkAll"   id="chk2"/></div>

					<div class="data-last-btn f-left">

						<input type="button" name="delete" class="btn-65-30blue ctrl-del" value="ɾ��" id="delete" act="?act=jobs_perform&delete=1"/>

					</div>

				</div>

			</div>

			<?php else: ?>

			<div class="c-data-row emptytip">û���ҵ���Ӧ��ְλ��Ϣ</div>

			<?php endif; ?>

		</div>

		<?php endif; ?>

		<!-- δ��ʾ ְλ -->

		<?php if ($_GET['jobtype'] == "3"): ?>

		<div class="company-data-list">

			<div class="c-data-top com-job-ma clearfix">

				<div class="item f-left check-item"><input type="checkbox" name="chkAll"   id="chk"/></div>

				<div class="item f-left top-item1">ְλ����</div>

				<div class="item f-left top-item2">

					<div class="data-filter span4">

						<span class="filter-span">ְλ״̬<i class="filter-icon"></i></span>

						<ul class="filter-down">

							<li><a href="<?php echo $this->_run_modifier("state:0", 'qishi_parse_url', 'plugin', 1); ?>
">ȫ��</a></li>

							<li><a href="<?php echo $this->_run_modifier("state:1", 'qishi_parse_url', 'plugin', 1); ?>
">δͨ��</a></li>

							<li><a href="<?php echo $this->_run_modifier("state:2", 'qishi_parse_url', 'plugin', 1); ?>
">�ѹر�</a></li>

						</ul>

					</div>

				</div>

				<div class="item f-left top-item3" style="text-align: center;">����</div>

			</div>

			<?php if ($this->_vars['jobs']): ?>

			<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['li']): ?>

			<div class="c-data-row">

				<div class="c-data-content com-job-ma3 clearfix">

					<div class="c-item f-left check-item"><input type="checkbox" name="y_id[]" id="y_id"  value="<?php echo $this->_vars['li']['id']; ?>
" class="checkbox" /></div>

					<div class="c-item f-left content1" style="width:535px;">

						<div class="job-ma-block">

							<div><a href="<?php echo $this->_vars['li']['jobs_url']; ?>
" target="_blank" class="name-link underline" title="<?php echo $this->_vars['li']['jobs_name_']; ?>
"><?php echo $this->_vars['li']['jobs_name']; ?>
</a></div>

							<p>ӦƸ������<?php echo $this->_vars['li']['countresume']; ?>
 | ����ʱ�䣺<?php echo $this->_run_modifier($this->_vars['li']['refreshtime'], 'date_format', 'plugin', 1, "%Y-%m-%d %H:%M"); ?>
</p>

						</div>

					</div>

					<div class="c-item f-left content2" style="width:218px;"><?php echo $this->_vars['li']['status_cn']; ?>
</div>

					<div class="c-item f-left content3">

						<?php if ($this->_vars['li']['status'] == 2): ?>

						<a href="?act=editjobs&id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�޸�</a>&nbsp;<a href="?act=jobs_perform&display1=1&y_id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�ָ�</a>&nbsp;<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a>

						<?php else: ?>

						<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a>

						<?php endif; ?>

					</div>

				</div>

			</div>

			<?php endforeach; endif; ?>

			<div class="c-data-row last">

				<div class="c-data-content apply_jobs clearfix">

					<div class="c-item f-left check-item"><input type="checkbox" name="chkAll"   id="chk2"/></div>

					<div class="data-last-btn f-left">

						<input type="button" name="delete" class="btn-65-30blue ctrl-del" value="ɾ��" id="delete" act="?act=jobs_perform&delete=1"/>

					</div>

				</div>

			</div>

			<?php else: ?>

			<div class="c-data-row emptytip">û���ҵ���Ӧ��ְλ��Ϣ</div>

			<?php endif; ?>

		</div>

		<?php endif; ?>

		<!-- ȫ��ְλ ְλ -->

		<?php if ($_GET['jobtype'] == "1"): ?>

		<div class="company-data-list">

			<div class="c-data-top com-job-ma clearfix">

				<div class="item f-left check-item"><input type="checkbox" id="chk" name="chkAll"></div>

				<div class="item f-left top-item1">ְλ����</div>

				<div class="item f-left top-item2">

					<div class="data-filter span4">

						<span class="filter-span">ְλ״̬<i class="filter-icon"></i></span>

						<ul class="filter-down">

							<li><a href="<?php echo $this->_run_modifier("state:0", 'qishi_parse_url', 'plugin', 1); ?>
">ȫ��</a></li>

							<li><a href="<?php echo $this->_run_modifier("state:1", 'qishi_parse_url', 'plugin', 1); ?>
">������</a></li>

							<li><a href="<?php echo $this->_run_modifier("state:2", 'qishi_parse_url', 'plugin', 1); ?>
">�����</a></li>

							<li><a href="<?php echo $this->_run_modifier("state:3", 'qishi_parse_url', 'plugin', 1); ?>
">δͨ��</a></li>

							<li><a href="<?php echo $this->_run_modifier("state:4", 'qishi_parse_url', 'plugin', 1); ?>
">�ѹر�</a></li>

						</ul>

					</div>

				</div>

				<div class="item f-left top-item3" style="text-align: center;">����</div>

			</div>

			<?php if ($this->_vars['jobs']): ?>

			<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['li']): ?>

			<div class="c-data-row">

				<div class="c-data-content com-job-ma3 clearfix">

					<div class="c-item f-left check-item"><input type="checkbox" name="y_id[]" id="y_id"  value="<?php echo $this->_vars['li']['id']; ?>
" class="checkbox" /></div>

					<div class="c-item f-left content1" style="width:535px;">

						<div class="job-ma-block">

							<div><a href="<?php echo $this->_vars['li']['jobs_url']; ?>
" target="_blank" class="name-link underline" title="<?php echo $this->_vars['li']['jobs_name_']; ?>
"><?php echo $this->_vars['li']['jobs_name']; ?>
</a></div>

							<p>ӦƸ������<?php echo $this->_vars['li']['countresume']; ?>
 | ����ʱ�䣺<?php echo $this->_run_modifier($this->_vars['li']['refreshtime'], 'date_format', 'plugin', 1, "%Y-%m-%d %H:%M");  if ($this->_vars['li']['status'] == 1): ?>  <a  href="javascript:;" jobsid="<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline refresh">[ˢ��]</a><?php endif; ?></p>

						</div>

					</div>

					<div class="c-item f-left content2" style="width:218px;"><span style="<?php if ($this->_vars['li']['status'] == 2 || $this->_vars['li']['status'] == 4): ?>color:red;<?php elseif ($this->_vars['li']['status'] == 3): ?>color:#FFB443;<?php else:  endif; ?>"><?php echo $this->_vars['li']['status_cn']; ?>
</span></div>

					<div class="c-item f-left content3">

						<?php if ($this->_vars['li']['status'] == 100): ?>

						<a href="?act=editjobs&id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�޸�</a>&nbsp;<a href="?act=jobs_perform&display2=1&y_id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�ر�</a>&nbsp;<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a>

						<?php elseif ($this->_vars['li']['status'] == 301 || $this->_vars['li']['status'] == 302): ?>

						<a href="?act=editjobs&id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�޸�</a>&nbsp;<a href="?act=jobs_perform&display1=1&y_id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�ָ�</a>&nbsp;<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a>

						<?php elseif ($this->_vars['li']['status'] == 3): ?>

						<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a>

						<?php else: ?>

						<a href="?act=editjobs&id=<?php echo $this->_vars['li']['id']; ?>
" class="data-ctrl underline">�޸�</a>&nbsp;<a href="javascript:;" class="data-ctrl underline ctrl-del" url="?act=jobs_perform&delete=1&y_id=<?php echo $this->_vars['li']['id']; ?>
">ɾ��</a>

						<?php endif; ?>

					</div>

				</div>

			</div>

			<?php endforeach; endif; ?>

			<div class="c-data-row last">

				<div class="c-data-content apply_jobs clearfix">

					<div class="c-item f-left check-item"><input type="checkbox" name="chkAll"   id="chk2" title="ȫѡ/��ѡ" /></div>

					<div class="data-last-btn f-left">

						<input type="button" name="delete" class="btn-65-30blue ctrl-del" value="ɾ��" id="delete" act="?act=jobs_perform&delete=1"/>

					</div>

				</div>

			</div>

			<?php else: ?>

			<div class="c-data-row emptytip">û���ҵ���Ӧ��ְλ��Ϣ</div>

			<?php endif; ?>

		</div>

		<?php endif; ?>



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

<!-- ����ְλ�ɹ����� -->

<div class="addjob-success-dialog" style="display:none">

	<div class="success-tip">ְ λ �� �� �� ��<a href="?act=addjobs" class="underline">��������ְλ</a></div>
</div>

</body>

</html>