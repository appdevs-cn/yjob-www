<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:51 CST */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<link href="css/date_input.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.date_input.js" type='text/javascript' language="javascript"></script>
<script type="text/javascript">
$(document).ready(function()
{
//日期
	$(function() { 
	$(".date_input").date_input(); 
	}); 
}); 
</script>
<script type="text/javascript" >
$(document).ready(function()
{
//验证文字广告
	$("#sub1").click(function()
	{
	 if ($("#title").val()==""){alert ("请填写广告标题"); return false;}
	 if ($("#text_content").val()==""){alert ("请填写文字");return false;}
	 $("#FormData").submit();
	});
	//图片
	$("#sub2").click(function()
	{
	 if ($("#title").val()==""){alert ("请填写广告标题"); return false;}
	 if ($("#img_file").val()=="" && $("#img_path").val()==""){alert ("请上传图片或填写图片路径");return false;}
	 $("#FormData").submit();
	});	
	//代码
	$("#sub3").click(function()
	{
	 if ($("#code_content").val()==""){alert ("请填写输入广告代码"); return false;}
	 $("#FormData").submit();
	});	
	//FLASH
	$("#sub4").click(function()
	{
	  if ($("#title").val()==""){alert ("请填写广告标题"); return false;}
	 if ($("#flash_file").val()=="" && $("#flash_path").val()==""){alert ("请上传FLASH或填写FLASH路径");return false;}
	 if ($("#flash_width").val()=="" || $("#flash_height").val()==""){alert ("请填写宽和高");return false;}
	 $("#FormData").submit();
	});	
	
//浮动
	$("#sub5").click(function()
	{
	  if ($("#title").val()==""){alert ("请填写广告标题"); return false;}
	 if ($("#floating_file").val()=="" && $("#floating_path").val()==""){alert ("请上传或填写路径");return false;}
	 if ($("#floating_width").val()=="" || $("#floating_height").val()==""){alert ("请填写宽和高");return false;}
	  if ($("#floating_left").val()=="" && $("#floating_right").val()==""){alert ("请填写左距或者右距");return false;}
	  if ($("#floating_top").val()==""){alert ("请填写顶距");return false;}
	  if ($("#floating_top").val()>800){alert ("顶距超过了800，多数情况下无法正确显示，推荐设置在300内");return false;}
	 $("#FormData").submit();
	});	
	//视频
	$("#sub6").click(function()
	{
	  if ($("#title").val()==""){alert ("请填写广告标题"); return false;}
	 if ($("#video_file").val()=="" && $("#video_path").val()==""){alert ("请上传或填写路径");return false;}
	 if ($("#video_width").val()=="" || $("#video_height").val()==""){alert ("请填写宽和高");return false;}
	 $("#FormData").submit();
	});	
}); 
</script>
<script type="text/javascript" >
$(document).ready(function()
{
	var add_alias="<?php echo $_GET['alias']; ?>
";
	//判断是不是添加后继续添加 的，如果是，则恢复广告分类
	if (add_alias=="")
	{
	selChange("<?php echo $this->_vars['ad_category']['0']['id']; ?>
,<?php echo $this->_vars['ad_category']['0']['type_id']; ?>
,<?php echo $this->_vars['ad_category']['0']['alias']; ?>
");	
	}
	else
	{
	selChange("<?php echo $_GET['category_id']; ?>
,<?php echo $_GET['type_id']; ?>
,<?php echo $_GET['alias']; ?>
");
	}	
	$("#category").change(function(){
	 selChange($(this).val());
	});
	function selChange(obj)
	{
	var str=obj.split(",");
	$("#category_id").val(str[0]);
	$("#type_id").val(str[1]);
	$("#alias").val(str[2]);
	$(".adshow").hide();
	$("#show"+str[1]).show();
	}
	$(":radio[name=floating_type]").click(function(){
	if ($(":radio[name=floating_type][checked]").val()=="1")
	{
	$("#show_url").show();
	}
	else
	{
	$("#show_url").hide();
	}
	});
	$(".choose_subsite").change(function(){
		$.get('admin_ajax.php?act=ajax_get_ad_categroy_by_subsite&subsite_id='+$(this).val(),function(data){
			$("#category").html(data);
		});
	});
	
}); 
</script>
<div class="admin_main_nr_dbox">
<div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("ads/admin_ad_nav.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  <div class="clear"></div>
</div>
<div class="toptip">
	<h2>提示：</h2>
	<p>
上传大文件建议通过FTP上传
在填写远程地址的时候，建议使用“/”或“http:// ”  开头的绝对路径。
</p>
</div>
<div class="toptit">新增广告</div>
<form action="?act=ad_add_save" method="post" enctype="multipart/form-data"  name="FormData" id="FormData" >
<table width="100%" border="0" cellpadding="3" cellspacing="3">
              <tr>
                <td width="100" align="right">广告标题(必填)：</td>
                <td><input name="title" type="text" class="input_text_400" id="title" maxlength="100"/> <span class="admin_note">广告标题只为识别辨认不同广告条目之用，并不在广告中显示</span></td>
              </tr>
			  <tr>
                <td align="right">显示状态：</td>
                <td>
				<label>
                  <input name="is_display" type="radio" value="1" checked="checked" />
                  正常</label>&nbsp;&nbsp;&nbsp;&nbsp;<label>
                  <input type="radio" name="is_display" value="0" />
停止 </label></td>
              </tr>
               <tr>
			    <td align="right">添加到：</td>
			    <td>
			    	<label ><input name="subsite_id" class="choose_subsite" type="radio" value="0"  <?php if ($this->_vars['QISHI']['subsite_id'] == "0"): ?>checked="checked"<?php endif; ?> />全站</label>
					&nbsp;&nbsp;&nbsp;
					<?php if (count((array)$this->_vars['subsite'])): foreach ((array)$this->_vars['subsite'] as $this->_vars['li']): ?>
					<label ><input name="subsite_id" class="choose_subsite" type="radio" value="<?php echo $this->_vars['li']['s_id']; ?>
" <?php if ($this->_vars['QISHI']['subsite_id'] == $this->_vars['li']['s_id']): ?>checked="checked"<?php endif; ?> /><?php echo $this->_vars['li']['s_sitename']; ?>
</label>
					&nbsp;&nbsp;&nbsp;
					<?php endforeach; endif; ?>
				  
				  </td>
			    </tr>
              <tr>
                <td align="right">选择分类：</td>
                <td><select name="category"   id="category"  >           
  					<?php if (count((array)$this->_vars['ad_category'])): foreach ((array)$this->_vars['ad_category'] as $this->_vars['li']): ?>		
                  <option value="<?php echo $this->_vars['li']['id']; ?>
,<?php echo $this->_vars['li']['type_id']; ?>
,<?php echo $this->_vars['li']['alias']; ?>
" <?php if ($_GET['alias'] == $this->_vars['li']['alias']): ?>selected="selected"<?php endif; ?>><?php echo $this->_vars['li']['categoryname']; ?>
</option>
				 <?php endforeach; endif; ?>
                
                </select>
				<input name="category_id" id="category_id" type="hidden" value="" />
				<input name="type_id" id="type_id" type="hidden" value="" />
				<input name="alias" id="alias" type="hidden" value="" />				</td>
              </tr>
              <tr>
                <td align="right">显示顺序：</td>
                <td><input name="show_order" type="text" class="input_text_200" id="show_order"  value="50" maxlength="3" /> <span class="admin_note">数字越大越靠前</span></td>
              </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td>
      <input name="starttime" type="text" class="input_text_200 date_input"   maxlength="10"  value="<?php echo $this->_vars['datefm']; ?>
"  />  <span class="admin_note">设置广告起始生效的时间，格式 yyyy-mm-dd，留空为不限制起始时间</span></td>
    </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td>
      <input name="deadline" type="text" class="input_text_200 date_input" id="deadline" maxlength="10"  /> <span class="admin_note">设置广告广告结束的时间，格式 yyyy-mm-dd，留空为不限制结束时间</span></td>
    </tr>
   
  <tr>
    <td align="right">备注：</td>
    <td><textarea name="note" id="note" style="width:300px; height:50px; font-size:12px; line-height:180%"></textarea></td>
    </tr>
    </table>
<div class="adshow" id="show1">
 <div class="toptit">文字广告</div>
 <table width="100%" border="0" cellpadding="3" cellspacing="3" >
                <tr>
                  <td width="100" align="right">文字内容(必填)：</td>
                  <td><input name="text_content" type="text" class="input_text_400" id="text_content"  />  <span class="admin_note">文字广告的显示内容</span></td>
                </tr>
                <tr>
                  <td align="right">文字链接：</td>
                  <td><input name="text_url" type="text" class="input_text_400" id="text_url"  />  <span class="admin_note">如:http://www.74cms.com</span></td>
                </tr>
                <tr>
                  <td align="right">文字颜色：</td>
                  <td>
				  
				  <div class="color_layer">	
		<div id="color_box" onclick="color_box_display()" ></div><input type="hidden" name="tit_color" id="tit_color" >
		<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_select_color.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>		</div>				  </td>
                </tr>
      </table>
	  <div style="padding-left:110px; padding-top:10px;">
	  <input type="button"  id="sub1" value="确定提交" class="admin_submit"   />
      <input name="submit22" type="button" class="admin_submit"    value="返 回" onclick="Javascript:window.history.go(-1)"/>
	  </div>
     
	</div>
<div class="adshow" id="show2">			
	 <div class="toptit">图片广告</div>
	
	<table width="100%" border="0" cellpadding="3" cellspacing="3">
	
				<tr>
                  <td width="100" align="right">本地上传：</td>
                  <td >
				 <input name="img_file" type="file"   id="img_file" style="font-size:12px; height:24px; width:273px;" />
			 <span class="admin_note">(允许格式为：gif/jpg/bmp/png，文件大小：1000KB)</span>				  </td>
                </tr>
                <tr>
                  <td width="100" align="right">或图片地址：</td>
                  <td ><input name="img_path" type="text" class="input_text_200" id="img_path" maxlength="250"/> <span class="admin_note">如：/images/logo.gif 或 http://www.baidu.com/img/baidu_logo.gif</span></td>
                </tr>
                <tr>
                  <td align="right">图片链接：</td>
                  <td><input name="img_url" type="text" class="input_text_200" id="img_url" maxlength="250"/>
				  <span class="admin_note">如:http://www.74cms.com</span>
				  </td>
                </tr>
                <tr>
                  <td align="right">图片说明文字：</td>
                  <td><input name="img_explain" type="text" class="input_text_200" id="img_explain" maxlength="250"/></td>
                </tr>
				 <tr>
                  <td align="right">会员UID：</td>
                  <td>
				  
				  <input name="img_uid" type="text" class="input_text_200" id="img_uid" maxlength="10"/>
				  
				  <span class="admin_note">设置会员UID后，当鼠标移动到图片上将会显示相关的职位和企业信息</span>
				  </td>
                </tr>
      </table>
		  <div style="padding-left:110px; padding-top:10px;">
		  <input type="button"  id="sub2" value="确定提交" class="admin_submit"   />
		  <input name="submit22" type="button" class="admin_submit"    value="返 回" onclick="Javascript:window.history.go(-1)"/>
		  </div>
	</div>
	<div class="adshow" id="show3">	
		 <div class="toptit">代码广告</div>
		<table width="100%" border="0" cellpadding="3" cellspacing="3">
                <tr>
                  <td width="100" align="right" valign="top"> 代码(必填):</td>
                  <td><textarea name="code_content" id="code_content" style="width:300px; height:50px; font-size:12px; line-height:180%"></textarea>              <span class="admin_note">请直接输入需要展现的广告代码</span></td>
                </tr>
      </table>
	   	<div style="padding-left:110px; padding-top:10px;">
		  <input type="button"  id="sub3" value="确定提交" class="admin_submit"   />
		  <input name="submit22" type="button" class="admin_submit"    value="返 回" onclick="Javascript:window.history.go(-1)"/>
	  </div>
	</div>
		<div class="adshow" id="show4">
		
		 <div class="toptit">Flash广告</div>
		
		<table width="100%" border="0" cellpadding="3" cellspacing="3">
		<tr>
                  <td width="100" align="right">本地上传：</td>
          <td >
				 <input name="flash_file" type="file"   id="flash_file" style="font-size:12px; height:24px; width:273px;" />
                 <span style="color: #666666">(允许格式为：swf，文件大小：1000KB)</span></td>
          </tr>
                <tr>
                  <td width="100" align="right">或者Flash地址：</td>
                  <td><input name="flash_path" type="text" class="input_text_200" id="flash_path" maxlength="250"/>  <span class="admin_note">如：/images/123.swf 或 http://www.74cms.com/123.swf</span></td>
                </tr>
                <tr>
                  <td align="right">Flash宽度(必填)：</td>
                  <td><input name="flash_width" type="text" class="input_text_200" id="flash_width" maxlength="5" />
                  px</td>
                </tr>
                <tr>
                  <td align="right">Flash高度(必填)：</td>
                  <td><input name="flash_height" type="text" class="input_text_200" id="flash_height" maxlength="5"   />
                  px</td>
                </tr>
          </table>
		  <div style="padding-left:110px; padding-top:10px;">
		  <input type="button"  id="sub4" value="确定提交" class="admin_submit"   />
		  <input name="submit22" type="button" class="admin_submit"    value="返 回" onclick="Javascript:window.history.go(-1)"/>
		  </div>
	</div>
					<div class="adshow" id="show5">
					<div class="toptit">浮动广告</div>
				<table width="100%" border="0" cellpadding="3" cellspacing="3">
                <tr>
                  <td width="100" align="right">类型：</td>
                  <td><label>
                    <input name="floating_type" type="radio" value="1" checked="checked"  />
图片</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                    <input type="radio" name="floating_type" value="2"  />
Flash </label></td>
                  </tr>
				  <tr>
                  <td width="100" align="right">本地上传：</td>
                  <td >
				 <input name="floating_file" type="file" id="floating_file" style="font-size:12px; height:24px; width:273px;" />
			 <span class="admin_note">(允许格式为：gif/jpg/bmp/png/swf，文件大小：1000KB)</span></td>
                </tr>
                <tr>
                  <td align="right">或者路径：</td>
                  <td><input name="floating_path" type="text" class="input_text_200" id="floating_path" maxlength="250"/></td>
                  </tr>
                <tr id="show_url">
                  <td align="right" >链接地址：</td>
                  <td><input name="floating_url" type="text" class="input_text_200" id="floating_url" maxlength="250"/></td>
                  </tr>
                <tr>
                  <td align="right">宽度(必填)：</td>
                  <td><input name="floating_width" type="text" class="input_text_200" id="floating_width" maxlength="5"   />
                  px</td>
                  </tr> 
                <tr>
                  <td align="right">高度(必填)：</td>
                  <td><input name="floating_height" type="text" class="input_text_200" id="floating_height" maxlength="5"   />
                  px</td>
                  </tr>
                   <tr>
                  <td align="right">左距(选填)：</td>
                  <td><input name="floating_left" type="text" class="input_text_200" id="floating_left"    value="" maxlength="5"   />
  px(左距与右距选填一个，如左距设置为0，则此浮动将在左侧浮动，如设置为100，则此浮动将在距离浏览器左侧100像素处浮动。)</td>
                  </tr>
				   <tr>
                  <td align="right">右距(选填)：</td>
                  <td><input name="floating_right" type="text" class="input_text_200" id="floating_right"   value="" maxlength="5"  />
  px(左距与右距选填一个，如右距设置为0，则此浮动将在右侧浮动，如设置为100，则此浮动将在距离浏览器右侧100像素处浮动。)</td>
                  </tr>
				   <tr>
                  <td align="right">顶距(必填)：</td>
                  <td><input name="floating_top" type="text" class="input_text_200" id="floating_top"  value="" maxlength="5"  />
  px(此浮动距离浏览器顶端的距离，如有多个浮动，请设置不同的顶距，以免被遮盖)</td>
                  </tr>
            </table>
				 <div style="padding-left:110px; padding-top:10px;">
		  <input type="button"  id="sub5" value="确定提交" class="admin_submit"   />
		  <input name="submit22" type="button" class="admin_submit"    value="返 回" onclick="Javascript:window.history.go(-1)"/>
		  </div>
				</div>	
				<div class="adshow" id="show6">			
	 <div class="toptit">视频广告</div>
	
	<table width="100%" border="0" cellpadding="3" cellspacing="3">
	
				<tr>
                  <td width="100" align="right">本地上传：</td>
                  <td >
				 <input name="video_file" type="file"   id="video_file" style="font-size:12px; height:24px; width:273px;" />
            <span class="admin_note">(允许格式为：swf/flv/f4v，文件大小：5000KB,大文件请从FTP上传)</span></td>
                </tr>
                <tr>
                  <td width="100" align="right">或填写路径：</td>
                  <td ><input name="video_path" type="text" class="input_text_200" id="video_path" /> <span class="admin_note">如：/images/logo.swf 或 http://www.baidu.com/img/baidu_logo.swf</span></td>
                </tr>
               <tr>
                  <td align="right">视频宽度(必填)：</td>
                  <td><input name="video_width" type="text" class="input_text_200" id="video_width" maxlength="5" />
                  px</td>
                </tr>
                <tr>
                  <td align="right">视频高度(必填)：</td>
                  <td><input name="video_height" type="text" class="input_text_200" id="video_height" maxlength="5"   />
                  px</td>
                </tr>
      </table>
		  <div style="padding-left:110px; padding-top:10px;">
		  <?php echo $this->_vars['inputtoken']; ?>

		  <input type="button"  id="sub6" value="确定提交" class="admin_submit"   />
		  <input name="submit22" type="button" class="admin_submit"    value="返 回" onclick="Javascript:window.history.go(-1)"/>
		  </div>
	</div>
</form>
</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>