<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-20 16:51 CST */ ?>
<div id="select_color_box">
<div class="color_title">选择标题颜色：</div>
<div class="color_box_close" onclick="color_box_display()">关闭</div>
<div class="clear"></div>
<a onclick="set_color('');color_box_display()" href="javascript:void(0);" style="background-image:url(images/color_box_bg.gif)"></a>
<a onclick="set_color('#000000');color_box_display()" href="javascript:void(0);" style=" background-color:#000000"></a>
<a onclick="set_color('#333333');color_box_display()" href="javascript:void(0);" style=" background-color:#333333"></a>
<a onclick="set_color('#666666');color_box_display()" href="javascript:void(0);" style=" background-color:#666666"></a>
<a onclick="set_color('#000099');color_box_display()" href="javascript:void(0);" style=" background-color:#000099"></a>
<a onclick="set_color('#0066FF');color_box_display()" href="javascript:void(0);" style=" background-color:#0066FF"></a>
<a onclick="set_color('#9900FF');color_box_display()" href="javascript:void(0);" style=" background-color:#9900FF"></a>
<a onclick="set_color('#990000');color_box_display()" href="javascript:void(0);" style=" background-color:#990000"></a>
<a onclick="set_color('#FF0000');color_box_display()" href="javascript:void(0);" style=" background-color:#FF0000"></a>
<a onclick="set_color('#FF6600');color_box_display()" href="javascript:void(0);" style=" background-color:#FF6600"></a>
<a onclick="set_color('#669900');color_box_display()" href="javascript:void(0);" style=" background-color:#669900"></a>
<a onclick="set_color('#336600');color_box_display()" href="javascript:void(0);" style=" background-color:#336600"></a>
<div class="clear"></div>
</div>
<script type="text/javascript">
function set_color(x)
{
var rgb=x;
if (rgb=="")
{
document.getElementById('color_box').style.background='url(images/color_box_bg.gif)';
}else
{
document.getElementById('color_box').style.background=rgb;
}
//alert(rgb);
document.getElementById('tit_color').value= rgb;
}
function color_box_display()
{
target=document.getElementById('select_color_box');
 if (target.style.display=="block"){
target.style.display="none";
 } else {
target.style.display="block";
 }
//document.bgColor =rgb;
}
</script>