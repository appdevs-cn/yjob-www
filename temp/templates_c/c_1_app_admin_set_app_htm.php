<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:49 CST */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class="admin_main_nr_dbox">
 <div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("app/admin_set_app_nav.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  <div class="clear"></div>
</div>
<div class="toptip">
	<h2>��ʾ��</h2>
	<p>
APP������Ҫ�������ƶ��˵Ĺ������ǻ����ǰ汾�ŵȲ��ֵ���Ϣ��<br />
</p>
</div>
<div class="toptit">��������</div>
  <form action="admin_app.php?act=set_save" method="post" name="form1" id="form1">
 <?php echo $this->_vars['inputtoken']; ?>

    <table width="100%" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td align="right" valign="top" style="padding-left:16px;height:50px;width:90px;">��վ���ܣ�</td>
      <td><textarea name="site_introduce" class="input_text_400" id="site_introduce" style="height:100px;"><?php echo $this->_vars['config']['site_introduce']; ?>
</textarea></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td height="50"> 
        <input name="submit" type="submit" class="admin_submit"    value="�����޸�"/>
      </td>
    </tr>
  </table>
  </form>
  <div class="toptit">ҡһҡ����</div>
  <form action="admin_app.php?act=set_save" method="post" name="form2" id="form2">
 <?php echo $this->_vars['inputtoken']; ?>

    <table width="100%" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td align="right" valign="center" style="padding-left:16px;height:40px;width:90px;">������Χ���룺</td>
      <td><input class="input_text_200" name="shake_range" type="text" id="shake_range" value="<?php echo $this->_vars['config']['shake_range']; ?>
" style="width:50px;"/>
      ǧ�� &nbsp;&nbsp;(��ǧ��Ϊ������λ,��������Ĭ��Ϊ0.5ǧ��)
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td height="50"> 
        <input name="submit" type="submit" class="admin_submit"    value="�����޸�"/>
      </td>
    </tr>
  </table>
  </form>
  <div class="toptit">�汾��Ϣ</div>
  <form action="admin_app.php?act=set_save" method="post" name="form3" id="form3">
    <?php echo $this->_vars['inputtoken']; ?>

    <table width="100%" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td align="right" valign="center" style="padding-left:16px;height:40px;width:90px;">android�汾�ţ�</td>
      <td><input class="input_text_200" name="app_version" type="text" id="app_version" value="<?php echo $this->_vars['config']['app_version']; ?>
"/></td>
    </tr>
    <tr>
      <td align="right" valign="center" style="padding-left:16px;height:40px;width:90px;">ios�汾�ţ�</td>
      <td><input class="input_text_200" name="ios_version" type="text" id="ios_version" value="<?php echo $this->_vars['config']['ios_version']; ?>
"/></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td height="50"> 
        <input name="submit" type="submit" class="admin_submit"    value="�����޸�"/>
      </td>
    </tr>
  </table>
  </form>

  <div class="toptit">��������</div>
  <form action="admin_app.php?act=set_save" method="post" name="form4" id="form4">
    <?php echo $this->_vars['inputtoken']; ?>

    <table width="100%" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td align="right" valign="center" style="padding-left:16px;height:40px;width:90px;">android��</td>
      <td><input class="input_text_200" name="android_download" type="text" id="android_download" value="<?php echo $this->_vars['config']['android_download']; ?>
"/></td>
    </tr>
    <tr>
      <td align="right" valign="center" style="padding-left:16px;height:40px;width:90px;">ios��</td>
      <td><input class="input_text_200" name="ios_download" type="text" id="ios_download" value="<?php echo $this->_vars['config']['ios_download']; ?>
"/></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td height="50"> 
        <input name="submit" type="submit" class="admin_submit"    value="�����޸�"/>
      </td>
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