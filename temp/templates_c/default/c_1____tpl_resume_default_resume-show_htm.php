<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/function.qishi_resume_show.php'); $this->register_function("qishi_resume_show", "tpl_function_qishi_resume_show",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 17:54 CST */  echo tpl_function_qishi_resume_show(array('set' => "�б���:show,����ID:GET[id]"), $this);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<meta name="renderer" content="webkit"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge"/> 
<title><?php echo $this->_vars['show']['fullname']; ?>
�ĸ��˼��� - <?php echo $this->_vars['QISHI']['site_name']; ?>
</title>
<link rel="shortcut icon" href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
favicon.ico" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['user_tpl']; ?>
css/css.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/ui-dialog.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->_vars['QISHI']['site_template']; ?>
css/datepicker.css" />
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.js" type='text/javascript' ></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/dialog-min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/dialog-min-common.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo $this->_vars['QISHI']['site_template']; ?>
js/jquery.datepicker.js"></script>
<!--[if lte IE 7]>
<style type="text/css">
.resume-block-detail .folder-item{
    position:relative;
    overflow:hidden;
}
.resume-block-detail .folder-item span{
    position:absolute;
    left:50%;top:50%;
}
.resume-block-detail .folder-item img{
    position:relative;
    left:-50%;top:-50%;
}
</style>
<![endif]-->
<script type="text/javascript">
$(document).ready(function()
{
	var id="<?php echo $this->_vars['show']['id']; ?>
";
	var tsTimeStamp= new Date().getTime();
	$.get("<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/ajax_click.php", { "id": id,"time":tsTimeStamp,"act":"resume_click"},
		function (data,textStatus)
		{			
			$(".click").html(data);
		}
	);
	<?php if ($this->_vars['show']['isminesee'] != '1'): ?>
	$.get("<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/ajax_contact.php", { "id": id,"time":tsTimeStamp,"act":"resume_contact"},
	function (data,textStatus)
	{      
		$("#resume_contact").html(data);
		var user_utype = "<?php echo $_SESSION['utype']; ?>
";
		if(user_utype=='3')
		{
			//���ؼ���
			downResume_dialog(".download","<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_hunter_download_resume.php","<?php echo $this->_vars['show']['id']; ?>
");
			//��������
			inviteJob_dialog("#invited","<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_hunter_invited.php",user_utype);
		}
		else 
		{
			//���ؼ���
			downResume_dialog(".download","<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_download_resume.php","<?php echo $this->_vars['show']['id']; ?>
");
			//��������
			inviteJob_dialog("#invited","<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_invited.php",user_utype);
		}
		//�������
		$(".interview-state").live('click',function() {
			var resume_state= $(this).attr('state');
			var resume_state_cn =$(this).val();
			var resume_id =$(this).attr('resume_id');
			var myDialog=dialog();
			$.post('<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_label_resume.php', {"resume_state":resume_state,"resume_state_cn":resume_state_cn,"resume_id":resume_id}, function(data) 
			{
				if(data=="ok")
				{
					window.location.reload();
				}
				else
				{
					myDialog.title('ϵͳ��ʾ');
					myDialog.content(data); 
					myDialog.width('350'); 
					myDialog.showModal();
				}
			});
		});
    });
    //��ӵ��˲ſ�
    favoritesResume_dialog(".add_resume_pool","<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_favorites_resume.php?id="+id+"&act=add&t="+tsTimeStamp);
    //�ٱ���Ϣ
    reportResume_dialog(".report_button","<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/user_report_resume.php");
    <?php else: ?>
    // ����ģ��
    $(".tpl").live("click",function(){
		var pid = $(this).attr("pid");
		var url = "<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/personal/personal_ajax.php?act=tpl&pid="+pid;
		var myDialog = dialog();
		myDialog.content("������...");
	    myDialog.title('����ģ��');
	    myDialog.showModal();
	    $.get(url, function(data){
		    myDialog.content(data);
		    /* �ر� */
		    $(".DialogClose").live('click',function() {
		      myDialog.close().remove();
		    });
		});
	});
	// ��˽����
	$(".resume_privacy").live("click",function(){
		var pid = $(this).attr("pid");
		var url = "<?php echo $this->_vars['QISHI']['site_dir']; ?>
user/personal/personal_ajax.php?act=privacy&pid="+pid;
		var myDialog = dialog();
		myDialog.content("������...");
	    myDialog.title('��˽����');
	    myDialog.width('550');
	    myDialog.showModal();
	    $.get(url, function(data){
	        myDialog.content(data);
	        /* �ر� */
	        $(".DialogClose").live('click',function() {
	          myDialog.close().remove();
	        });
	    });
	});
    <?php endif; ?>
});
$(function(){
	$("input[type='button']").hover(function(){
		$(this).addClass("hover");
	},function(){
		$(this).removeClass("hover");
	})
})
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
</script>
</head>
<body class="default">
	<div id="header">
		<div class="header-wrap"><a href="<?php echo $this->_vars['QISHI']['site_dir']; ?>
"><img src="<?php echo $this->_vars['QISHI']['upfiles_dir'];  echo $this->_vars['QISHI']['web_logo']; ?>
" alt="<?php echo $this->_vars['QISHI']['site_name']; ?>
" height="70" /></a></div>
	</div>
	<div id="wrap" class="clearfix">
		<div class="left-main f-left">
			<?php if ($this->_vars['show']['message']): ?>
			<div class="top-streamer"><i class="streamer-angle"></i><?php echo $this->_vars['show']['message']; ?>
</div>
			<?php endif; ?>
			<?php if ($this->_vars['show']['isminesee'] == '1'): ?>
			<div class="top-streamer"><i class="streamer-angle"></i>�������ƣ�<font style="font-weight:bold"><?php echo $this->_vars['show']['title']; ?>
</font>   &nbsp;����״̬��<font style="font-weight:bold"><span id="showDisplayName"><?php if ($this->_vars['show']['display'] == '1'): ?>����<?php else: ?>����<?php endif; ?></span></font></div>
			<?php endif; ?>
			<div class="personal-info clearfix">
				<div class="personal-pic f-left"><img src="<?php echo $this->_vars['show']['photosrc']; ?>
" alt="" width="160" height="178" /></div>
				<div class="info-text f-left">
					<h2><?php echo $this->_vars['show']['fullname']; ?>
 <span>��<?php echo $this->_vars['show']['sex_cn'];  if ($this->_vars['show']['age'] < 80): ?>��<?php echo $this->_vars['show']['age']; ?>
��<?php endif; ?>��</span></h2>
					<div class="resume-time">����ʱ�䣺<?php echo $this->_run_modifier($this->_vars['show']['refreshtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</div>
					<div class="resonal-auth clearfix">
						<?php if ($this->_vars['show']['is_audit_mobile'] == 1): ?><div class="auth-item phone f-left">�ֻ�����֤</div><?php endif; ?>
						<?php if ($this->_vars['show']['is_audit_weixin']): ?><div class="auth-item weichat f-left">΢������֤</div><?php endif; ?>
						<?php if ($this->_vars['show']['is_audit_email'] == 1): ?><div class="auth-item email f-left">��������֤</div><?php endif; ?>
						<?php if ($this->_vars['show']['resume_from_pc'] == '4'): ?>
						<span class="f-left">���ü������Կ���ע�ᣩ</span>
						<?php elseif ($this->_vars['show']['resume_from_pc'] != '1' && $this->_vars['show']['resume_from_pc'] != '0'): ?>
						<span class="f-left">���ü������ֻ�������</span>
						<?php endif; ?>
					</div>
					<div class="info-detail">
						<p><?php if ($this->_vars['show']['education_cn']): ?><span>���ѧ����<?php echo $this->_vars['show']['education_cn']; ?>
</span><?php endif;  if ($this->_vars['show']['experience_cn']): ?>&nbsp;|&nbsp;<span>�������飺<?php echo $this->_vars['show']['experience_cn']; ?>
</span><?php endif;  if ($this->_vars['show']['major_cn']): ?>&nbsp;|&nbsp;<span>רҵ��<?php echo $this->_vars['show']['major_cn']; ?>
</span><?php endif; ?></p>
						<p><?php if ($this->_vars['show']['marriage_cn']): ?><span>����״����<?php echo $this->_vars['show']['marriage_cn']; ?>
</span><?php endif;  if ($this->_vars['show']['height']): ?>&nbsp;|&nbsp;<span>��&nbsp;&nbsp;�ߣ�<?php echo $this->_vars['show']['height']; ?>
 cm</span><?php endif; ?></p>
						<p><?php if ($this->_vars['show']['householdaddress']): ?><span>��&nbsp;&nbsp;�᣺<?php echo $this->_vars['show']['householdaddress']; ?>
</span>&nbsp;|&nbsp;<?php endif;  if ($this->_vars['show']['residence']): ?><span>�־�ס�أ�<?php echo $this->_vars['show']['residence']; ?>
</span><?php endif; ?></p>
						<?php if ($this->_vars['show']['current_cn']): ?><p><span>��ְ״̬��<?php echo $this->_vars['show']['current_cn']; ?>
</span></p><?php endif; ?>
					</div>
					<?php if ($this->_vars['show']['tag_cn']): ?>
					<div class="personal-tag clearfix">
						<?php if (count((array)$this->_vars['show']['tag_cn'])): foreach ((array)$this->_vars['show']['tag_cn'] as $this->_vars['t_li']): ?>
						<div class="tag-item f-left"><?php echo $this->_vars['t_li']; ?>
<i class="tag-angle"></i></div>
						<?php endforeach; endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="job-item">
				<h3>��������ְ���</h3>
				<div class="percent clearfix">
					<i class="right-top-angle"></i>
					<div class="percent-block f-left">
						<div class="percent-star f-left star-<?php echo $this->_vars['show']['vitality']; ?>
">��Ծ�ȣ�</div>
						<div class="star-state f-left">
							<p><span><?php echo $this->_vars['show']['refreshtime_cn']; ?>
</span>����</p>
							<p>�������� <span><?php echo $this->_vars['show']['apply_jobs']; ?>
</span> ��ְλ</p>
							<p>����� <span><?php echo $this->_vars['show']['view_jobs']; ?>
</span> ��ְλ</p>
						</div>
					</div>
					<div class="percent-block last f-left">
						<div class="percent-star f-left star-<?php echo $this->_vars['show']['attention']; ?>
">��ҵ��ע�ȣ�</div>
						<div class="star-state f-left">
							<p>��������� <span><?php echo $this->_vars['show']['com_view']; ?>
</span> ��</p>
							<p>���������� <span><?php echo $this->_vars['show']['com_down']; ?>
</span> ��</p>
							<p>�յ��������� <span><?php echo $this->_vars['show']['com_invite']; ?>
</span> ��</p>
						</div>
					</div>
					
					<div class="percent-block last f-left" style="width:330px;">
						<div class="percent-star f-left star-<?php echo $this->_vars['show']['attention']; ?>
">�û����Ŷȣ�</div>
						<div class="star-state f-left">
							<p>�ϸ��� <span><?php echo $this->_vars['sgshu']; ?>
</span> ��</p>
							<p>ȡ���� <span><?php echo $this->_vars['qxshu']; ?>
</span> ��</p>
							<p>�Ÿ����� <span><?php echo $this->_vars['fgzshu']; ?>
</span> ��</p>
						</div>
					</div>
					
					<!-- <div class="percent-block last f-left" style="width:330px;">
						<div class="percent-star f-left star-<?php echo $this->_vars['show']['attention']; ?>
" >���ۣ�</div>
						<div class="star-state f-left">
							<p>���� <span><?php echo $this->_vars['haop']; ?>
</span> ��</p>
							<p>���� <span><?php echo $this->_vars['zhongp']; ?>
</span> ��</p>
							<p>���� <span><?php echo $this->_vars['chap']; ?>
</span> ��</p>
						</div>
					</div> -->
					
				</div>
			</div>
			<?php if ($this->_vars['show']['isminesee'] != '1'): ?>
			
			<?php else: ?>
			
			<?php endif; ?>
			<div class="resume-title">��ְ����</div>
			<div class="resume-block-detail">
				<div class="rb-content"><?php if ($this->_vars['show']['wage_cn']): ?>������н��<?php echo $this->_vars['show']['wage_cn'];  endif;  if ($this->_vars['show']['nature_cn']): ?><span>|</span>�������ʣ�<?php echo $this->_vars['show']['nature_cn'];  endif; ?></div>
				<div class="rb-content"><?php if ($this->_vars['show']['district_cn']): ?>����������<?php echo $this->_vars['show']['district_cn'];  endif;  if ($this->_vars['show']['trade_cn']): ?><span>|</span>������ҵ��<?php echo $this->_vars['show']['trade_cn'];  endif; ?></div>
				<?php if ($this->_vars['show']['intention_jobs']): ?><div class="rb-content">������λ��<?php echo $this->_vars['show']['intention_jobs']; ?>
</div><?php endif; ?>
			</div>
			<?php if ($this->_vars['show']['specialty']): ?>
			<div class="resume-title">��������</div>
			<div class="resume-block-detail">
				<div class="rb-content-more"><?php echo $this->_run_modifier($this->_vars['show']['specialty'], 'nl2br', 'PHP', 1); ?>
</div>
			</div>
			<?php endif; ?>
			<?php if ($this->_vars['show']['education_list']): ?>
			<div class="resume-title">��������</div>
			<div class="resume-block-detail">
				<?php if (count((array)$this->_vars['show']['education_list'])): foreach ((array)$this->_vars['show']['education_list'] as $this->_vars['list']): ?>
				<div class="rb-content"><?php echo $this->_vars['list']['startyear']; ?>
��<?php echo $this->_vars['list']['startmonth']; ?>
��-<?php if ($this->_vars['list']['todate'] != '1'):  echo $this->_vars['list']['endyear']; ?>
��<?php echo $this->_vars['list']['endmonth']; ?>
��<?php else: ?>����<?php endif; ?><span>|</span><?php echo $this->_vars['list']['school']; ?>
<span>|</span><?php echo $this->_vars['list']['speciality']; ?>
<span>|</span><?php echo $this->_vars['list']['education_cn']; ?>
</div>
				<?php endforeach; endif; ?>
			</div>
			<?php endif; ?>
			<?php if ($this->_vars['show']['work_list']): ?>
			<div class="resume-title">��������</div>
			<div class="resume-block-detail">
				<?php if (count((array)$this->_vars['show']['work_list'])): foreach ((array)$this->_vars['show']['work_list'] as $this->_vars['list']): ?>
				<div class="work-item">
					<div class="rb-content"><?php echo $this->_vars['list']['startyear']; ?>
��<?php echo $this->_vars['list']['startmonth']; ?>
��-<?php if ($this->_vars['list']['todate'] != '1'):  echo $this->_vars['list']['endyear']; ?>
��<?php echo $this->_vars['list']['endmonth']; ?>
��<?php else: ?>����<?php endif; ?><span>|</span><?php echo $this->_vars['list']['jobs']; ?>
<span>|</span><?php echo $this->_vars['list']['companyname']; ?>
</div>
					<p><?php echo $this->_run_modifier($this->_vars['list']['achievements'], 'nl2br', 'PHP', 1); ?>
</p>
				</div>
				<?php endforeach; endif; ?>
			</div>
			<?php endif; ?>
			<?php if ($this->_vars['show']['training_list']): ?>
			<div class="resume-title">��ѵ����</div>
			<div class="resume-block-detail">
				<?php if (count((array)$this->_vars['show']['training_list'])): foreach ((array)$this->_vars['show']['training_list'] as $this->_vars['list']): ?>
				<div class="rb-content"><?php echo $this->_vars['list']['startyear']; ?>
��<?php echo $this->_vars['list']['startmonth']; ?>
��-<?php if ($this->_vars['list']['todate'] != '1'):  echo $this->_vars['list']['endyear']; ?>
��<?php echo $this->_vars['list']['endmonth']; ?>
��<?php else: ?>����<?php endif; ?><span>|</span><?php echo $this->_vars['list']['agency']; ?>
<span>|</span><?php echo $this->_vars['list']['course']; ?>
</div>
				<?php endforeach; endif; ?>
			</div>
			<?php endif; ?>
			<?php if ($this->_vars['show']['language_list']): ?>
			<div class="resume-title">��������</div>
			<div class="resume-block-detail">
				<?php if (count((array)$this->_vars['show']['language_list'])): foreach ((array)$this->_vars['show']['language_list'] as $this->_vars['list']): ?>
				<div class="rb-content"><?php echo $this->_vars['list']['language_cn']; ?>
<span>|</span><?php echo $this->_vars['list']['level_cn']; ?>
</div>
				<?php endforeach; endif; ?>
			</div>
			<?php endif; ?>
			<?php if ($this->_vars['show']['credent_list']): ?>
			<div class="resume-title">���֤��</div>
			<div class="resume-block-detail">
				<?php if (count((array)$this->_vars['show']['credent_list'])): foreach ((array)$this->_vars['show']['credent_list'] as $this->_vars['list']): ?>
				<div class="rb-content"><?php echo $this->_vars['list']['name']; ?>
<span>|</span><?php echo $this->_vars['list']['year']; ?>
��<?php echo $this->_vars['list']['month']; ?>
��</div>
				<?php endforeach; endif; ?>
			</div>
			<?php endif; ?>
			<?php if ($this->_vars['show']['img_list']): ?>
			<div class="resume-title">����</div>
			<div class="resume-block-detail clearfix">
				<?php if (count((array)$this->_vars['show']['img_list'])): foreach ((array)$this->_vars['show']['img_list'] as $this->_vars['list']): ?>
				<div class="folder-item f-left"><span><img src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
data/photo/<?php echo $this->_vars['list']['img']; ?>
" alt="<?php echo $this->_vars['list']['title']; ?>
" /></span></div>
				<?php endforeach; endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="fix-control">
			<div class="fix-wrap">
				<div class="code-box"><img src="<?php echo $this->_vars['QISHI']['site_dir']; ?>
plus/url_qrcode.php?url=<?php echo $this->_vars['QISHI']['wap_domain']; ?>
/resume-show.php?id=<?php echo $this->_vars['show']['id']; ?>
" alt="��ά��" width="74" height="74" /></div>
				<div class="download"><?php if ($this->_vars['show']['isminesee'] != '1'):  if ($this->_vars['value'] == 2): ?><a href="javascript:;" class="download-btn">���ؼ���</a><?php endif;  else: ?><a href="javascript:;" pid="<?php echo $this->_vars['show']['id']; ?>
" class="download-btn tpl">����ģ��</a><?php endif; ?></div>
				<div class="ctrl-text"></div>
				<div class="ctrl-bar">
					<?php if ($this->_vars['show']['isminesee'] != '1'): ?><a href="javascript:;" class="resume-ctrl add_resume_pool">�����˲ſ�</a><?php endif; ?>
					<a href="javascript:window.print();" class="resume-ctrl">������ӡ</a>
					
					<?php if ($this->_vars['show']['isminesee'] != '1'): ?><a href="javascript:;" class="resume-ctrl report_button" resume_id="<?php echo $_GET['id']; ?>
" fullname="<?php echo $this->_vars['show']['fullname']; ?>
" resume_addtime="<?php echo $this->_vars['show']['addtime']; ?>
">Ͷ�߼���</a><?php endif; ?>
					<?php if ($this->_vars['show']['isminesee'] == '1'): ?><a href="javascript:;" pid="<?php echo $this->_vars['show']['id']; ?>
" class="resume-ctrl resume_privacy">��˽����</a><?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		��ϵ��ַ��<?php echo $this->_vars['QISHI']['address']; ?>
 ��ϵ�绰��<?php echo $this->_vars['QISHI']['bootom_tel']; ?>
 ��վ������<?php echo $this->_vars['QISHI']['icp'];  echo $this->_vars['QISHI']['statistics']; ?>
 <br />
		<?php echo $this->_vars['QISHI']['bottom_other']; ?>
 <br />
		
	</div>
<div class="resume_foot">
<script type="text/javascript">
	$('.work-item:first').css({'margin-top':-10});
	$('.work-item:last').css({'border-bottom':0, 'padding-bottom':0});
	$('.folder-item:nth-child(2n)').css({'margin-right':0});
</script>
</body>
</html>