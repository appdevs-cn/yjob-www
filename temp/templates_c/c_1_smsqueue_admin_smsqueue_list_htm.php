<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.default.php'); $this->register_modifier("default", "tpl_modifier_default",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_parse_url.php'); $this->register_modifier("qishi_parse_url", "tpl_modifier_qishi_parse_url",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:50 CST */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<script type="text/javascript">
$(document).ready(function()
{
	$("#ButSend").QSdialog({
	DialogTitle:"请选择",
	DialogContent:"#SendDiv",
	DialogContentType:"id",
	DialogAddObj:"#OpSend",	
	DialogAddType:"html",
	DialogWidth:500	
	});
	$("#ButDel").QSdialog({
	DialogTitle:"您要删除哪些信息?",
	DialogContent:"#DelDiv",
	DialogContentType:"id",
	DialogAddObj:"#OpDel",	
	DialogAddType:"html",
	DialogWidth:300	
	});
	//发送
	$(".submitsend").click(function(){
			$("form[name=form1]").attr("action","?act=totalsend");
			$("form[name=form1]").submit()
	});	
	//删除
	$(".submitdel").click(function(){
			$("form[name=form1]").attr("action","?act=del");
			$("form[name=form1]").submit()
	});
});
</script>
<div class="admin_main_nr_dbox">
<div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("smsqueue/admin_smsqueue_nav.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  <div class="clear"></div>
</div>
<div class="toptip link_g">
	<h2>提示：</h2>
		<p>
		短信模块属收费模块，需申请开通后才能使用，请点击 <a href="http://www.74cms.com/sms.php" target="_blank">这里</a> 申请开通。
		<br />
		资费标准请联系骑士销售获取，更多介绍请进入 <a href="http://www.74cms.com" target="_blank">骑士人才系统官方网站</a></p>
</div>
<div class="seltpye_x">
		<div class="left">筛选类型</div>	
		<div class="right">
		<a href="<?php echo $this->_run_modifier("s_type:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['s_type'] == ""): ?>class="select"<?php endif; ?>>不限</a>
		<a href="<?php echo $this->_run_modifier("s_type:0", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['s_type'] == "0"): ?>class="select"<?php endif; ?>>等待发送</a>
		<a href="<?php echo $this->_run_modifier("s_type:1", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['s_type'] == "1"): ?>class="select"<?php endif; ?>>发送成功</a>
		<a href="<?php echo $this->_run_modifier("s_type:2", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['s_type'] == "2"): ?>class="select"<?php endif; ?>>发送失败</a>
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
</div>
   <form id="form1" name="form1" method="post" action="?act=promotion_del">
  <?php echo $this->_vars['inputtoken']; ?>

    <table width="100%" border="0" cellpadding="0" cellspacing="0"  id="list" class="link_lan">
    <tr>
      <td  width="120" class="admin_list_tit admin_list_first">
     <label id="chkAll"><input type="checkbox" name="" title="全选/反选" id="chk"/>类型</label>	 </td>
	  <td class="admin_list_tit" width="13%">手机号</td>
	  <td  class="admin_list_tit">短信内容</td>
      <td width="110"  align="center"  class="admin_list_tit">添加时间</td>	  
      <td width="110"  align="center"  class="admin_list_tit">发送时间</td>
      <td width="10%" align="center"  class="admin_list_tit">操作</td>
    </tr>
	<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['list']): ?>
	 <tr>
      <td   class="admin_list admin_list_first">
     <input type="checkbox" name="id[]"  value="<?php echo $this->_vars['list']['s_id']; ?>
"/>
	 <?php if ($this->_vars['list']['s_type'] == "0"): ?><span style="color:#FF6600">等待发送</span><?php endif; ?>
	 <?php if ($this->_vars['list']['s_type'] == "1"): ?><span style="color: #009900">发送成功</span><?php endif; ?>
	 <?php if ($this->_vars['list']['s_type'] == "2"): ?><span style="color: #666666">发送失败</span><?php endif; ?>
	  </td>
	  <td  class="admin_list">
	  <?php echo $this->_vars['list']['s_mobile']; ?>

	  </td>
	  <td   class="admin_list vtip" title="<?php echo $this->_run_modifier($this->_vars['list']['s_body'], 'nl2br', 'PHP', 1); ?>
" >
	  <?php echo $this->_vars['list']['s_body_']; ?>

	  </td>
      <td align="center"  class="admin_list">
	  <?php echo $this->_run_modifier($this->_vars['list']['s_addtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>

		</td>	  
      <td align="center"  class="admin_list">
	  
	  <?php if ($this->_vars['list']['s_sendtime'] == "0"): ?>
		----
		<?php else: ?>
	<?php echo $this->_run_modifier($this->_vars['list']['s_sendtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>

		<?php endif; ?>
	  </td>
      <td align="center"  class="admin_list">
	  <a href="?act=smsqueue_edit&id=<?php echo $this->_vars['list']['s_id']; ?>
">修改</a>
	 
	</td>
	</tr>
	<?php endforeach; endif; ?>
  </table>
  
	<?php if (! $this->_vars['list']): ?>
	<div class="admin_list_no_info">没有任何信息！</div>
	<?php endif; ?>
	
	<span id="OpDel">
	</span>
	<span id="OpSend">
	</span>
	
  </form>	
   <table width="100%" border="0" cellspacing="10"  class="admin_list_btm">
	<tr>
      <td>
	  <input type="button" name="Submit22" value="发送" class="admin_submit" id="ButSend"/>
       <input type="button" name="Submit22" value="添加任务" class="admin_submit"    onclick="window.location='?act=smsqueue_add'"/>
	   <input type="button" name="Submit22" value="批量添加" class="admin_submit"    onclick="window.location='?act=smsqueue_batchadd'"/>
	<input type="button" name="ButDel" id="ButDel" value="删除" class="admin_submit" />
	  </td>
      <td width="305">
	  
	   
	   
	      
	   	<form id="formseh" name="formseh" method="get" action="?">	
			<div class="seh">
			    <div class="keybox"><input name="key" type="text"   value="<?php echo $_GET['key']; ?>
" /></div>
			    <div class="selbox">
					<input name="key_type_cn"  id="key_type_cn" type="text" value="<?php echo $this->_run_modifier($_GET['key_type_cn'], 'default', 'plugin', 1, "短信内容"); ?>
" readonly="true"/>
						<div>
								<input name="key_type" id="key_type" type="hidden" value="<?php echo $this->_run_modifier($_GET['key_type'], 'default', 'plugin', 1, "1"); ?>
" />
												<div id="sehmenu" class="seh_menu">
														<ul>
														<li id="1" title="短信内容">短信内容</li>
														<li id="2" title="手机号码">手机号码</li>
														</ul>
												</div>
						</div>				
				</div>
				<div class="sbtbox">
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
<div style="display:none" id="SendDiv">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="6">
 <tr>
      <td  width="100"  align="right">发送选择：</td>
      <td>
      
	  <label><input name="sendtype" type="radio" value="1" checked="checked"  />      
	   已选项目
	   </label>
	   &nbsp;
	   &nbsp;
	   <label><input name="sendtype" type="radio" value="2"  />      
	   所有等待发送的
	   </label>
	   &nbsp;
	   &nbsp;
	   <label><input name="sendtype" type="radio" value="3"   />      
	   所有发送失败的
	   </label>
					  
	    </td>
    </tr>
	<tr>
      <td align="right">发送间隔时间：</td>
      <td>
	  <input name="intervaltime" type="text" class="input_text_150"  value="3" maxlength="3" /> 
	  秒
	  </td>
    </tr>
    <tr>
      <td align="right">最大发送数量：</td>
      <td>
	  <input name="sendmax" type="text" class="input_text_150"  value="100" maxlength="3" /> 
	  0为不限制  
	  </td>
    </tr>
	 <tr>
      <td align="right">发送失败时：</td>
      <td>
                      <label><input type="radio" name="senderr" value="1"  checked="checked" />
                       跳过继续</label>
					   <label><input type="radio" name="senderr" value="2"  />
                       停止发送</label>
					   </td>
    </tr>
    <tr>
      <td height="70">&nbsp;</td>
      <td>
	  <input type="submit" name="submitdel"  value="确定" class="admin_submit submitsend"/>
 </td>
    </tr>
  </table>
</div>









	
	
<div style="display:none" id="DelDiv">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="6">
 <tr>
      <td  width="30">&nbsp;</td>
      <td>
                      <label><input name="deltype" type="radio" value="1" checked="checked"  />
                      已选项目</label></td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td>
                      <label><input type="radio" name="deltype" value="2"  />
                       所有等待发送项目</label></td>
    </tr>
	 <tr>
      <td >&nbsp;</td>
      <td>
                      <label><input type="radio" name="deltype" value="3"  />
                       所有发送成功项目</label></td>
    </tr>
	<tr>
      <td >&nbsp;</td>
      <td>
                      <label><input type="radio" name="deltype" value="4"  />
                       所有发布失败项目</label></td>
    </tr>
	
	<tr>
      <td  >&nbsp;</td>
      <td>
                      <label><input type="radio" name="deltype" value="5"  />
                       清空所有列队</label></td>
    </tr>
    <tr>
      <td height="70">&nbsp;</td>
      <td>
	  <input type="submit" name="submitdel"  value="确定" class="admin_submit submitdel"/>
 </td>
    </tr>
  </table>
</div>
    
	
	
	
	
	
	
	
	
	
	   
</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>