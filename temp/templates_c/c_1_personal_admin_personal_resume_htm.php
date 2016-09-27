<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.default.php'); $this->register_modifier("default", "tpl_modifier_default",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_parse_url.php'); $this->register_modifier("qishi_parse_url", "tpl_modifier_qishi_parse_url",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:49 CST */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<script type="text/javascript" src="js/jquery.userinfotip-min.js"></script>
<script type="text/javascript" src="js/jquery.entrustinfotip-min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#ButAudit").QSdialog({
	DialogTitle:"请选择",
	DialogContent:"#AuditSet",
	DialogContentType:"id",
	DialogAddObj:"#OpAudit",	
	DialogAddType:"html"	
	});
	$("#ButTalent").QSdialog({
	DialogTitle:"请选择",
	DialogContent:"#TalentSet",
	DialogContentType:"id",
	DialogAddObj:"#OpTalent",	
	DialogAddType:"html"	
	});	
	$("#ButPhotoresume").QSdialog({
	DialogTitle:"请选择",
	DialogContent:"#PhotoresumeSet",
	DialogContentType:"id",
	DialogAddObj:"#OpPhotoresume",	
	DialogAddType:"html"	
	});
	$("#ButImportresume").QSdialog({
	DialogTitle:"请选择",
	DialogContent:"#ImportSet",
	DialogContentType:"id",
	DialogAddObj:"#OpImportresume",	
	DialogAddType:"html"	
	});
	//点击批量删除	
	$("#ButDel").click(function(){
		if (confirm('你确定要删除吗？'))
		{
			$("form[name=form1]").attr("action",$("form[name=form1]").attr("action")+"&delete=true");
			$("form[name=form1]").submit()
		}
	});
	$("#Butrefresh").click(function(){
			$("form[name=form1]").attr("action",$("form[name=form1]").attr("action")+"&refresh=ok");
			$("form[name=form1]").submit()
	});
	$("#ButExport").click(function(){
			$("form[name=form1]").attr("action",$("form[name=form1]").attr("action")+"&export=true");
			$("form[name=form1]").submit()
	});
	//导入简历
	$("#set_import").click(function(){
			$("form[name=form1]").attr("action","?act=import");
			$("form[name=form1]").submit()
	});
	//纵向列表排序
	$(".listod .txt").each(function(i){
	var li=$(this).children(".select");
	var htm="<a href=\""+li.attr("href")+"\" class=\""+li.attr("class")+"\">"+li.text()+"</a>";
	li.detach();
	$(this).prepend(htm);
	});
			
	$("#fail").click(function(){
		$("#reason").show();
	});
	$("#success").click(function(){
		$("#reason").hide();
	});

	$("#not_audit").click(function(){
		$("#is_del_img").show();
	});
	$("#yes_audit").click(function(){
		$("#is_del_img").hide();
	});
	
	
		
});
</script>
<div class="admin_main_nr_dbox">
 <div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
  <div class="clear"></div>
</div>

<div class="toptip">
	<h2>提示：</h2>
	<p>
可见简历是指：审核通过,全公开的简历。反之为非可见简历<br />
</p>
</div>


<div class="seltpye_y">

	<div class="tit link_lan">
	<strong>简历列表</strong><span>(共找到<?php echo $this->_vars['total_val']; ?>
条)</span>
	<a href="?act=list">[恢复默认]</a>
	<div class="pli link_bk"><u>每页显示：</u>
	<a href="<?php echo $this->_run_modifier("perpage:10", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['perpage'] == "10"): ?>class="select"<?php endif; ?>>10</a>
	<a href="<?php echo $this->_run_modifier("perpage:20", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['perpage'] == "20"): ?>class="select"<?php endif; ?>>20</a>
	<a href="<?php echo $this->_run_modifier("perpage:30", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['perpage'] == "30"): ?>class="select"<?php endif; ?>>30</a>
	<a href="<?php echo $this->_run_modifier("perpage:60", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['perpage'] == "60"): ?>class="select"<?php endif; ?>>60</a>
	<div class="clear"></div>
	</div>
	</div>	
    <div class="list">
	  <div class="t">可见状态</div>	  
	  <div class="txt link_lan">
	 	<a href="<?php echo $this->_run_modifier("tabletype:1", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['tabletype'] == "1"): ?>class="select"<?php endif; ?>>可见简历<span>(<?php echo $this->_vars['total']['0']; ?>
)</span></a>
		<a href="<?php echo $this->_run_modifier("tabletype:2", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['tabletype'] == "2"): ?>class="select"<?php endif; ?>>非可见简历<span>(<?php echo $this->_vars['total']['1']; ?>
)</span></a>
	  </div>
    </div>
	<?php if ($_GET['tabletype'] == "2"): ?>
	<div class="list">
	  <div class="t">审核状态</div>	  
	  <div class="txt link_lan">
	 	<a href="<?php echo $this->_run_modifier("audit:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['audit'] == ""): ?>class="select"<?php endif; ?>>不限</a>
		<a href="<?php echo $this->_run_modifier("audit:1", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['audit'] == "1"): ?>class="select"<?php endif; ?>>审核通过<span>(<?php echo $this->_vars['total']['2']; ?>
)</span></a>
		<a href="<?php echo $this->_run_modifier("audit:2", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['audit'] == "2"): ?>class="select"<?php endif; ?>>等待审核<span>(<?php echo $this->_vars['total']['3']; ?>
)</span></a>
		<a href="<?php echo $this->_run_modifier("audit:3", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['audit'] == "3"): ?>class="select"<?php endif; ?>>审核未通过<span>(<?php echo $this->_vars['total']['4']; ?>
)</span></a>
	  </div>
    </div>
	  <?php endif; ?>
	
	

	<div class="list" >
	  <div class="t">简历等级</div>	  
	  <div class="txt link_lan">
	 	<a href="<?php echo $this->_run_modifier("talent:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['talent'] == ""): ?>class="select"<?php endif; ?>>不限</a>
		<a href="<?php echo $this->_run_modifier("talent:1", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['talent'] == "1"): ?>class="select"<?php endif; ?>>普通人才</a>
		<a href="<?php echo $this->_run_modifier("talent:2", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['talent'] == "2"): ?>class="select"<?php endif; ?>>高级人才</a>
		<a href="<?php echo $this->_run_modifier("talent:3", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['talent'] == "3"): ?>class="select"<?php endif; ?>>待开通高级人才</a>
	  </div>
    </div>
	
	
	<div class="list" >
	  <div class="t">照片可见</div>	  
	  <div class="txt link_lan">
	 	<a href="<?php echo $this->_run_modifier("photo_display:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['photo_display'] == ""): ?>class="select"<?php endif; ?>>不限</a>
		<a href="<?php echo $this->_run_modifier("photo_display:1", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['photo_display'] == "1"): ?>class="select"<?php endif; ?>>可见</a>
		<a href="<?php echo $this->_run_modifier("photo_display:2", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['photo_display'] == "2"): ?>class="select"<?php endif; ?>>不可见</a>
	  </div>
    </div>
	
	
	
	<div class="list" >
	  <div class="t">照片审核</div>	  
	  <div class="txt link_lan">
	 	<a href="<?php echo $this->_run_modifier("photo_audit:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['photo_audit'] == ""): ?>class="select"<?php endif; ?>>不限</a>
		<a href="<?php echo $this->_run_modifier("photo_audit:1", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['photo_audit'] == "1"): ?>class="select"<?php endif; ?>>照片审核通过</a>
		<a href="<?php echo $this->_run_modifier("photo_audit:2", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['photo_audit'] == "2"): ?>class="select"<?php endif; ?>>照片待审核</a>
		<a href="<?php echo $this->_run_modifier("photo_audit:3", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['photo_audit'] == "3"): ?>class="select"<?php endif; ?>>照片审核未通过</a>
	  </div>
    </div>
	
	 
	
	<div class="list" >
	  <div class="t">添加时间</div>	  
	  <div class="txt link_lan">
	 	<a href="<?php echo $this->_run_modifier("addtimesettr:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['addtimesettr'] == ""): ?>class="select"<?php endif; ?>>不限</a>
		<a href="<?php echo $this->_run_modifier("addtimesettr:3", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['addtimesettr'] == "3"): ?>class="select"<?php endif; ?>>三天内</a>
		<a href="<?php echo $this->_run_modifier("addtimesettr:7", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['addtimesettr'] == "7"): ?>class="select"<?php endif; ?>>一周内</a>
		<a href="<?php echo $this->_run_modifier("addtimesettr:30", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['addtimesettr'] == "30"): ?>class="select"<?php endif; ?>>一月内</a>

	  </div>
    </div>
	
	<div class="list" >
	  <div class="t">刷新时间</div>	  
	  <div class="txt link_lan">
	 	<a href="<?php echo $this->_run_modifier("settr:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == ""): ?>class="select"<?php endif; ?>>不限</a>
		<a href="<?php echo $this->_run_modifier("settr:3", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == "3"): ?>class="select"<?php endif; ?>>三天内</a>
		<a href="<?php echo $this->_run_modifier("settr:7", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == "7"): ?>class="select"<?php endif; ?>>一周内</a>
		<a href="<?php echo $this->_run_modifier("settr:30", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == "30"): ?>class="select"<?php endif; ?>>一月内</a>

		
	  </div>
    </div>


	<div class="list" >
	  <div class="t">是否委托</div>  
	  <div class="txt link_lan">
	 	<a href="<?php echo $this->_run_modifier("entrust:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['entrust'] == ""): ?>class="select"<?php endif; ?>>不限</a>
		<a href="<?php echo $this->_run_modifier("entrust:1", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['entrust'] == "1"): ?>class="select"<?php endif; ?>>一周</a>
		<a href="<?php echo $this->_run_modifier("entrust:2", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['entrust'] == "2"): ?>class="select"<?php endif; ?>>二周</a>
		<a href="<?php echo $this->_run_modifier("entrust:3", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['entrust'] == "3"): ?>class="select"<?php endif; ?>>一个月</a>
	  </div>
    </div>
	
	
	<div class="clear"></div>
</div>
 
  <form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?act=perform">
  <?php echo $this->_vars['inputtoken']; ?>

  <table width="100%" border="0" cellpadding="0" cellspacing="0"   class="link_lan">
    <tr>
      <td    class="admin_list_tit admin_list_first" >
     <label id="chkAll"><input type="checkbox" name=" " title="全选/反选" id="chk"/>姓名</label>	 </td>
     
	   <td   align="center"  width="80" class="admin_list_tit">完整指数 </td>
	  <td  align="center"  width="6%" class="admin_list_tit">等级</td>
       <td  align="center"  width="6%" class="admin_list_tit">上岗数</td>
        <td  align="center"  width="6%" class="admin_list_tit">取消数</td>
         <td  align="center"  width="6%" class="admin_list_tit">放鸽子数</td>
	   <td align="center"  width="7%"  class="admin_list_tit">审核状态</td> 
      <td   align="center" width="8%" class="admin_list_tit">公开</td>
	  <td align="center" width="8%" class="admin_list_tit">照片</td>
      <td align="center" width="10%"  class="admin_list_tit">添加时间</td>
	  <td align="center"  width="12%"  class="admin_list_tit">刷新时间</td>	
	   <td align="center"  width="6%"  class="admin_list_tit">委托状态</td>	
      <td align="center"  width="15%" class="admin_list_tit">操作</td>
    </tr>
	<?php if (count((array)$this->_vars['resumelist'])): foreach ((array)$this->_vars['resumelist'] as $this->_vars['list']): ?>
	<tr>
      <td  class="admin_list admin_list_first" >
	  <input name="id[]" type="checkbox" id="id" value="<?php echo $this->_vars['list']['id']; ?>
"  />
		<a href="<?php echo $this->_vars['list']['resume_url']; ?>
" target="_blank"><?php echo $this->_vars['list']['fullname']; ?>
</a>
		<?php if ($this->_vars['list']['talent'] == "3"): ?>
		<span style="color: #FF0000">[待开通高级人才]</span>
		<?php endif; ?>
		<?php if ($this->_vars['list']['photo_img'] <> ""): ?>
		<span style="color: #009900"  class="vtip" title="<img src=<?php echo $this->_vars['QISHI']['resume_photo_dir'];  echo $this->_vars['list']['photo_img']; ?>
  border=0  align=absmiddle>">[照片]</span>
		<?php endif; ?>	
		<a href="admin_mail.php?act=send&email=<?php echo $this->_vars['list']['email']; ?>
&uid=<?php echo $this->_vars['list']['uid']; ?>
"> <img src="images/email.gif" border="0" title="发送邮件" /></a>	
		 <?php if ($this->_vars['list']['telephone']): ?><a href="admin_sms.php?act=send&mobile=<?php echo $this->_vars['list']['telephone']; ?>
&uid=<?php echo $this->_vars['list']['uid']; ?>
"><img src="images/sms.gif" border="0" title="发送短信" /></a><?php endif; ?>	
		  </td>
	 <td align="center"  class="admin_list">
	 <div style="width:100%; border:1px #CCCCCC solid; padding:1px; text-align:left; position:relative; font-size:0px">
	 	<div style=" background-color: #99CC00; height:10px; color:#990000;width:<?php echo $this->_vars['list']['complete_percent']; ?>
%;font-size:0px"></div>
		<div style="position:absolute; top:0px; left:40%; font-size:10px;"><?php echo $this->_vars['list']['complete_percent']; ?>
%</div>
	 </div>	</td>
	
      <td align="center"  class="admin_list">
	  <?php if ($this->_vars['list']['talent'] == "1"): ?>普通<?php endif; ?>
	  <?php if ($this->_vars['list']['talent'] == "2"): ?><span style="color: #009900">高级</span><?php endif; ?>
	  <?php if ($this->_vars['list']['talent'] == "3"): ?><span style="color: #FF0000">待开通</span><?php endif; ?>	  </td>
        <td align="center"  class="admin_list">
        <?php echo $this->_vars['list']['worknum']; ?>
次
	   </td>
        <td align="center"  class="admin_list">
       <?php echo $this->_vars['list']['cancel_sign']; ?>
次  
	 </td>
        <td align="center"  class="admin_list">
        <?php echo $this->_vars['list']['worknum1']; ?>
次 
	   </td>
	   <td align="center"  class="admin_list">
	   <?php if ($this->_vars['list']['audit'] == "1"): ?>审核通过<?php endif; ?>
	   <?php if ($this->_vars['list']['audit'] == "2"): ?><span style="color: #FF6600">等待审核</span><?php endif; ?>
	   <?php if ($this->_vars['list']['audit'] == "3"): ?><span style="color: #666666">审核未通过</span><?php endif; ?>	   </td>   
      <td align="center"  class="admin_list">
	  <?php if ($this->_vars['list']['display'] == "1"): ?>
	  		公开
	  <?php else: ?>
	  		半公开
	  <?php endif; ?>	  </td>
      <td align="center"  class="admin_list">
	   <?php if ($this->_vars['list']['photo'] == ""): ?>
	  无照片
	  <?php else: ?>
	  	 <?php if ($this->_vars['list']['photo_audit'] == "1"): ?>
		 审核通过<?php if ($this->_vars['list']['photo_display'] <> "1"): ?>[不可见]<?php endif; ?>
		 <?php endif; ?>
		 <?php if ($this->_vars['list']['photo_audit'] == "2"): ?><span style="color:#FF0000">等待审核</span><?php endif; ?>
		 <?php if ($this->_vars['list']['photo_audit'] == "3"): ?>
		 审核未通过 
		 <?php endif; ?>
	  <?php endif; ?>	  </td>
      <td align="center"  class="admin_list"><?php echo $this->_run_modifier($this->_vars['list']['addtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</td>
	  <td align="center"  class="admin_list"><?php echo $this->_run_modifier($this->_vars['list']['refreshtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>
</td>
	    <?php if ($this->_vars['list']['entrust'] == 0): ?>
	  <td align="center"  class="admin_list">- -</td>
	  <?php elseif ($this->_vars['list']['entrust'] == 1): ?>
	  <td align="center"  class="admin_list"><span class="entrustinfo" uid="<?php echo $this->_vars['list']['uid']; ?>
" rid="<?php echo $this->_vars['list']['id']; ?>
">一周</span></td>
	  <?php elseif ($this->_vars['list']['entrust'] == 2): ?>
	<td align="center"  class="admin_list"><span class="entrustinfo" uid="<?php echo $this->_vars['list']['uid']; ?>
" rid="<?php echo $this->_vars['list']['id']; ?>
">二周</span></td>
	<?php else: ?>
	<td align="center"  class="admin_list"><span class="entrustinfo" uid="<?php echo $this->_vars['list']['uid']; ?>
" rid="<?php echo $this->_vars['list']['id']; ?>
">一个月</span></td>
	<?php endif; ?>
      <td align="center"  class="admin_list">
		<a href="admin_memberslog.php?uid=<?php echo $this->_vars['list']['uid']; ?>
">日志</a>
		&nbsp;
		<a href="?act=resume_show&id=<?php echo $this->_vars['list']['id']; ?>
&uid=<?php echo $this->_vars['list']['uid']; ?>
" >查看</a>
		&nbsp;
		<a href="?act=management&id=<?php echo $this->_vars['list']['uid']; ?>
"  target="_blank" class="userinfo"  id="<?php echo $this->_vars['list']['uid']; ?>
">管理</a>	 
	&nbsp;
		<?php if ($this->_vars['list']['entrust'] != 0): ?>
		<a href="?act=matching&id=<?php echo $this->_vars['list']['id']; ?>
&uid=<?php echo $this->_vars['list']['uid']; ?>
">匹配</a>  
		<?php else: ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php endif; ?>
	  </td>
    </tr>
	 <?php endforeach; endif; ?>
  </table>
  <span id="OpAudit"></span>
  <span id="OpTalent"></span>
  <span id="OpPhotoresume"></span>
  <span id="OpImportresume"></span>
 </form>
<?php if (! $this->_vars['resumelist']): ?>
<div class="admin_list_no_info">没有任何信息！</div>
<?php endif; ?>
<table width="100%" border="0" cellspacing="10" cellpadding="0" class="admin_list_btm">
      <tr>
        <td>
<input type="button" class="admin_submit" id="ButAudit" value="审核简历" />
<input type="button" class="admin_submit" id="ButTalent" value="人才等级" />  
<input type="button" class="admin_submit" id="ButPhotoresume" value="审核照片" />
<input type="button" class="admin_submit" id="Butrefresh" value="刷新"/>
<input type="button" class="admin_submit" id="ButDel" value="删除"/>
<input type="button" name="ButExport"  id="ButExport" value="导出" class="admin_submit"/>
<input type="button" name="ButImportresume"  id="ButImportresume" value="导入" class="admin_submit"/>
<input type="button" name="excelmodel"  id="excelmodel" value="下载简历模板" class="admin_submit" onclick="javascript:location.href='./excelmodel.xls'"/>
		</td>
        <td width="305" align="right">
		<form id="formseh" name="formseh" method="get" action="?">	
			<div class="seh">
			    <div class="keybox"><input name="key" type="text"   value="<?php echo $_GET['key']; ?>
" /></div>
			    <div class="selbox">
					<input name="key_type_cn"  id="key_type_cn" type="text" value="<?php echo $this->_run_modifier($_GET['key_type_cn'], 'default', 'plugin', 1, "姓名"); ?>
" readonly="true"/>
						<div>
								<input name="key_type" id="key_type" type="hidden" value="<?php echo $this->_run_modifier($_GET['key_type'], 'default', 'plugin', 1, "1"); ?>
" />
												<div id="sehmenu" class="seh_menu">
														<ul>
														<li id="1" title="姓名">姓名</li>
														<li id="2" title="ID">ID</li>
														<li id="3" title="UID">UID</li>
														<li id="4" title="电话">电话</li>
														<li id="6" title="地址">地址</li>
														</ul>
												</div>
						</div>				
				</div>
				<div class="sbtbox">
				<input name="act" type="hidden" value="list" />
				<input type="submit" name="" class="sbt" id="sbt" value="搜索"/>
				</div>
				<div class="clear"></div>
		  </div>
		  </form>
		  <script type="text/javascript">$(document).ready(function(){showmenu("#key_type_cn","#sehmenu","#key_type");});	</script>
	    </td>
      </tr>
  </table>
<div class="page link_bk"><?php echo $this->_vars['page']; ?>
</div>
</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div id="AuditSet" style="display: none" >
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="6" >
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30"><strong  style="color:#0066CC; font-size:14px;">将所选简历设置为：</strong></td>
    </tr>
	      <tr>
      <td width="40" height="25">&nbsp;</td>
      <td>
	  <label >
                      <input name="audit" type="radio" value="1" checked="checked" id="success" />
                      审核通过 </label>	  </td>
    </tr>
    <tr>
      <td width="40" height="25">&nbsp;</td>
      <td width="400"><label >
                      <input type="radio" name="audit" value="3"  id="fail"/>
                       审核未通过</label></td>
    </tr>
    <tr>
      <td width="50" height="25">&nbsp;</td>
      <td>
                      <label><input type="checkbox" name="pms_notice" value="1"  checked="checked"/>
					  站内信通知
                       </label></td>
    </tr>
	<tr style="display:none" id="reason">
      <td width="40" height="25" >理由：</td>
      <td>
         <textarea name="reason" id="reason" cols="40" style="font-size:12px"></textarea>            
      </td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
      <td><span style="border-top: 1px #A3C7DA solid;">
        <input type="submit" name="set_audit" value="确定" class="admin_submit">
      </span></td>
    </tr>		  
  </table>
  </div>
  <div id="ImportSet" style="display: none" >
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="6" >
    <tr>
    <input type="file" name="file"  style="height:21px; width:210px; border:1px #999999 solid" />
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
      <td><span style="border-top: 1px #A3C7DA solid;">
        <input type="button" name="set_import" id="set_import" value="确定" class="admin_submit">
      </span></td>
    </tr>		  
  </table>
  </div>
<div id="TalentSet" style="display:none" >
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="6" >
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30"><strong  style="color:#0066CC; font-size:14px;">将所选简历设置为：</strong></td>
    </tr>
	      <tr>
      <td width="27" height="25">&nbsp;</td>
      <td>
	  <label >
                      <input name="talent" type="radio" value="1" checked="checked"  />
                      普通人才 </label>	  </td>
    </tr>
    <tr>
      <td width="27" height="25">&nbsp;</td>
      <td width="425"><label ><input type="radio" name="talent" value="2"  />高级人才</label>	  </td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
      <td><span style="border-top: 1px #A3C7DA solid;">
        <input type="submit" name="set_talent" value="确定" class="admin_submit">
      </span></td>
    </tr>
  </table>
</div>
<div id="PhotoresumeSet" style="display: none" >
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="6" >
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30"><strong  style="color:#0066CC; font-size:14px;">将所选简历设置为：</strong></td>
    </tr>
	      <tr>
      <td width="27" height="25">&nbsp;</td>
      <td>
	  <label >
                      <input name="photoaudit" type="radio" value="1" checked="checked" id="yes_audit"/>
                      照片审核通过 </label>	  </td>
    </tr>
    <tr>
      <td width="27" height="25">&nbsp;</td>
      <td width="425"><label >
                      <input type="radio" name="photoaudit" value="3" id="not_audit"/>
                       照片审核未通过</label></td>
    </tr>
    <tr style="display:none" id="is_del_img">
      <td width="27" height="25">&nbsp;</td>
      <td>
                      <label><input type="checkbox" name="is_del_img" value="1"/>
					  是否删除相应照片
                       </label></td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
      <td><span style="border-top: 1px #A3C7DA solid;">
        <input type="submit" name="set_photoaudit" value="确定" class="admin_submit">
      </span></td>
    </tr>		  
  </table>
</div>
</body>
</html>