<?php require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.default.php'); $this->register_modifier("default", "tpl_modifier_default",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.date_format.php'); $this->register_modifier("date_format", "tpl_modifier_date_format",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_url.php'); $this->register_modifier("qishi_url", "tpl_modifier_qishi_url",false);  require_once('/Users/Kevin/waibao/codes/yjobs/include/template_lite/plugins/modifier.qishi_parse_url.php'); $this->register_modifier("qishi_parse_url", "tpl_modifier_qishi_parse_url",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:49 CST */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<script type="text/javascript">
$(document).ready(function()
{
 //�������ɾ��	
	$("#ButDlete").click(function(){
		if (confirm('��ȷ��Ҫɾ����'))
		{
			$("form[name=form1]").submit()
		}
	});
	//�����б�����
	$(".listod .txt").each(function(i){
	var li=$(this).children(".select");
	var htm="<a href=\""+li.attr("href")+"\" class=\""+li.attr("class")+"\">"+li.text()+"</a>";
	li.detach();
	$(this).prepend(htm);
	});
			
});
</script>
 
<div class="admin_main_nr_dbox">
<div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("campus/admin_set_campus_nav.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  <div class="clear"></div>
</div>
<div class="toptip">
	<h2>��ʾ��</h2>
	<p>
	����ԺУ��У԰��Ƹ����Ҫ��ɲ��� , �ɺ�̨����Ա����� / �༭ / �޸ġ�<br />
	</p>
</div>
<div class="seltpye_x">
	<div class="left">���ʱ��</div>	
	<div class="right">
	<a href="<?php echo $this->_run_modifier("settr:", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == ""): ?>class="select"<?php endif; ?>>����</a>
	<a href="<?php echo $this->_run_modifier("settr:3", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == "3"): ?>class="select"<?php endif; ?>>������</a>
	<a href="<?php echo $this->_run_modifier("settr:7", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == "7"): ?>class="select"<?php endif; ?>>һ����</a>
	<a href="<?php echo $this->_run_modifier("settr:30", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == "30"): ?>class="select"<?php endif; ?>>һ����</a>
	<a href="<?php echo $this->_run_modifier("settr:180", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == "180"): ?>class="select"<?php endif; ?>>������</a>
	<a href="<?php echo $this->_run_modifier("settr:360", 'qishi_parse_url', 'plugin', 1); ?>
" <?php if ($_GET['settr'] == "360"): ?>class="select"<?php endif; ?>>һ����</a>
	<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

 
   <form id="form1" name="form1" method="post" action="?act=del_campus">
    <?php echo $this->_vars['inputtoken']; ?>

    <table width="100%" border="0" cellpadding="0" cellspacing="0"  id="list" class="link_lan">
		<tr>
			<td   class="admin_list_tit admin_list_first">
				<label id="chkAll"><input type="checkbox" name="" title="ȫѡ/��ѡ" id="chk"/>ԺУ����</label>
			</td>
			<td width="27%" align="left"  class="admin_list_tit">ԺУ��ַ</td>	
			<td width="20%"  align="left" class="admin_list_tit">ԺУ��ҳ</td>  
			<td width="7%" align="center"  class="admin_list_tit">У��������</td>
			<td width="9%" align="center"  class="admin_list_tit">���ʱ��</td>
			<td width="10%" align="center"  class="admin_list_tit">����</td>
		</tr>
		<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['li']): ?>
		<tr>
			<td   class="admin_list admin_list_first">
				<input type="checkbox" name="id[]"  value="<?php echo $this->_vars['li']['id']; ?>
"/>
				<a href="<?php echo $this->_run_modifier("QS_campusshow,id:" . $this->_vars['li']['id'] . "", 'qishi_url', 'plugin', 1); ?>
" target="_blank" class="vtip" title='<img src="<?php echo $this->_vars['campus_dir'];  echo $this->_vars['li']['logo']; ?>
" />'><?php echo $this->_vars['li']['campusname']; ?>
</a> 
			</td>
			<td  class="admin_list">
				<?php echo $this->_vars['li']['address']; ?>

			</td>
			<td align="left"  class="admin_list">
				<?php echo $this->_vars['li']['website']; ?>

			</td>
			<td align="center"  class="admin_list">
				<?php if ($this->_vars['li']['graduate']):  echo $this->_vars['li']['graduate'];  else: ?>-  -<?php endif; ?>
			</td>
			<td align="center"  class="admin_list">
				<?php echo $this->_run_modifier($this->_vars['li']['addtime'], 'date_format', 'plugin', 1, "%Y-%m-%d"); ?>

			</td>	  
			<td align="center"  class="admin_list">
				<a href="?act=edit_campus&id=<?php echo $this->_vars['li']['id']; ?>
">�޸�</a>
					&nbsp; &nbsp; 
				<a href="?act=del_campus&id=<?php echo $this->_vars['li']['id']; ?>
&<?php echo $this->_vars['urltoken']; ?>
"  onclick="return confirm('��ȷ��Ҫɾ����')">ɾ��</a>
			</td>
		</tr>
		<?php endforeach; endif; ?>
	</table>
    </form>
	<?php if (! $this->_vars['list']): ?>
	<div class="admin_list_no_info">û���κ���Ϣ��</div>
	<?php endif; ?>
	<table width="100%" border="0" cellspacing="10"  class="admin_list_btm">
		<tr>
			<td>
				<input type="button" name="Submit22" value="���ԺУ" class="admin_submit"    onclick="window.location='?act=campus_add'"/>

				<input type="button" name="delete" value="ɾ��"   id="ButDlete" class="admin_submit"   />
			</td>
			<td width="360" align="right">

				<form id="formseh" name="formseh" method="get" action="?act=campus_list">	
					<div class="seh">
						<div class="keybox"><input name="key" type="text"   value="<?php echo $_GET['key']; ?>
" /></div>
						<div class="selbox">
							<input name="key_type_cn"  id="key_type_cn" type="text" value="<?php echo $this->_run_modifier($_GET['key_type_cn'], 'default', 'plugin', 1, "ԺУ����"); ?>
" readonly="true"/>
							<div>
								<input name="key_type" id="key_type" type="hidden" value="<?php echo $this->_run_modifier($_GET['key_type'], 'default', 'plugin', 1, "1"); ?>
" />
								<div id="sehmenu" class="seh_menu">
									<ul>
										<li id="1" title="ԺУ����">ԺУ����</li>
									</ul>
								</div>
							</div>				
						</div>
						<div class="sbtbox">
							<input name="act" type="hidden" value="campus_list" />
							<input type="submit" name="" class="sbt" id="sbt" value="����"/>
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
</body>
</html>