<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:50 CST */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class="admin_main_nr_dbox">
 <div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
  <div class="clear"></div>
</div>
<div class="toptip">
	<h2>��ʾ��</h2>
	<p>
��װ����֧������������Ӧ����֧������˾�ķ����˻���
</p>
</div>
  <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="link_lan" id="list" >
    <tr>
            <td width="15%"  class="admin_list_tit admin_list_first">����</td>
            <td width="34%" class="admin_list_tit">֧����ʽ�������</td>
            <td align="center" class="admin_list_tit">������</td>
            <td align="center" class="admin_list_tit">����</td>
            <td width="15%" align="center" class="admin_list_tit">����</td>
    </tr>
		 <?php if (count((array)$this->_vars['payment'])): foreach ((array)$this->_vars['payment'] as $this->_vars['li']): ?>
          <tr>
      <td class="admin_list admin_list_first" style="color:#3366CC"> <?php echo $this->_vars['li']['byname']; ?>
 </td>
            <td class="admin_list"> <?php echo $this->_vars['li']['p_introduction']; ?>
</td>
            <td align="center" class="admin_list"><?php echo $this->_vars['li']['fee']; ?>
 %</td>
            <td align="center" class="admin_list">
			<?php echo $this->_vars['li']['listorder']; ?>
      </td>
            <td align="center" class="admin_list">
				<?php if ($this->_vars['li']['p_install'] == 2): ?>
				<a href="?act=uninstall_payment&id=<?php echo $this->_vars['li']['id']; ?>
&<?php echo $this->_vars['urltoken']; ?>
" onclick="return confirm('��ȷ��Ҫж����')">ж��</a> &nbsp;&nbsp;&nbsp;&nbsp;
				<a href="?act=action_payment&name=<?php echo $this->_vars['li']['typename']; ?>
" >�༭</a>
				<?php else: ?>
				<a href="?act=action_payment&type=install&name=<?php echo $this->_vars['li']['typename']; ?>
">��װ</a>
				<?php endif; ?>				</td>
          </tr>
         
          <?php endforeach; endif; ?>
  </table>
  <table width="100%" height="100" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>