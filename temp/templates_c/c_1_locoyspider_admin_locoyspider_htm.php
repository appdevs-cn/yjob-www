<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:50 CST */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class="admin_main_nr_dbox">
 <div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("locoyspider/admin_locoyspider_nav.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  <div class="clear"></div>
</div>
    <div class="toptip">
	<h2>��ʾ��</h2>
	<p>��ͷ�ɼ������뵽��̳���أ�</p>
	</div>
	<div class="toptit">��������</div>
	 <form action="?act=set_save" method="post"  name="form1" id="form1">
	 <?php echo $this->_vars['inputtoken']; ?>

    <table width="700" border="0" cellspacing="5" cellpadding="1" style=" margin-bottom:3px;">
    <tr>
      <td width="180" align="right">�����ɼ��ӿڣ�</td>
      <td ><label for="label">
        <input name="open" type="radio" id="label" value="1"  <?php if ($this->_vars['show']['open'] == "1"): ?>checked="checked"<?php endif; ?>/>
        ����</label>
&nbsp;&nbsp;&nbsp;&nbsp;
<label for="label2">
<input type="radio" name="open" value="0" id="label2"  <?php if ($this->_vars['show']['open'] == "0"): ?>checked="checked"<?php endif; ?>/>
�ر� </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td height="50"><span style="font-size:14px;">
        <input name="submit2" type="submit" class="admin_submit"    value="�����޸�"/>
      </span></td>
    </tr>
  </table>
  </form>
  <div class="toptit">ģ��ƥ�䷧ֵ</div>
	 <form action="?act=set_save" method="post"  name="form1" id="form1">
	 <?php echo $this->_vars['inputtoken']; ?>

    <table width="100%" border="0" cellspacing="5" cellpadding="1" style=" margin-bottom:3px; margin-top:10px;">
    <tr>
      <td width="180" align="right">ģ��ƥ�䷧ֵ��</td>
      <td >
	  <input name="search_threshold" type="text" class="input_text_200" id="search_threshold" value="<?php echo $this->_vars['show']['search_threshold']; ?>
" maxlength="3"/>
	  <span style="color:#666666">(��Χ:1-100��������Ϊ100��Ϊ��ȷƥ�䣬�Ƽ���Ϊ��50-80)</span></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td height="50"><span style="font-size:14px;">
        <input name="submit2" type="submit" class="admin_submit"    value="�����޸�"/>
      </span></td>
    </tr>
  </table>
  </form>
</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>