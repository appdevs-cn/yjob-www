<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=750" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="">
<meta name="format-detection" content="telephone=no">
<title>ѡ�����- �Ƽ�ְ</title>
<link rel="stylesheet" href="/layout/blue/css/glide.css">
<link rel="stylesheet" href="/layout/blue/css/common.css">
<link rel="stylesheet" href="/layout/blue/css/style.css">


</head>
<div class="layout">
	<div class="city_nav">
				<div class="hd">
					<h5>ѡ�����</h5>
				<em><a href="#"></a></em>
				</div>				
				<ul>
					<li>
						<h6>��ǰ��λ���� :</h6>
					<div class="hot_city">
						<dl>						
							<dd><a href="#">����</a></dd>
						</dl>
					</div>							
					</li>
					<li>
						<h6>���ų��� :</h6>
					<div class="hot_city">
						<dl>						
							<dd><a href="#">����</a></dd>
							<dd><a href="#">�Ϻ�</a></dd>
							<dd><a href="#">����</a></dd>
							<dd><a href="#">����</a></dd>
							<dd><a href="#">���</a></dd>
							<dd><a href="#">����</a></dd>
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="B">B</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">����</a></dd>
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="C">C</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">��ɳ</a></dd>
							<dd><a href="#">����</a></dd>
							<dd><a href="#">�ɶ�</a></dd>
							<dd><a href="#">����</a></dd>
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="D">D</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">����</a></dd>					
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="G">G</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">����</a></dd>					
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="H">H</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">������</a></dd>	
							<dd><a href="#">����</a></dd>	
							<dd><a href="#">�Ϸ�</a></dd>	
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="J">J</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">����</a></dd>								
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="N">N</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">�ϲ�</a></dd>
							<dd><a href="#">�Ͼ�</a></dd>		
						</dl>
					</div>							
					</li>
					<li>
					<h6 id="Q">Q</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">�ൺ</a></dd>				
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="S">S</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">�Ϻ�</a></dd>
							<dd><a href="#">����</a></dd>
							<dd><a href="#">����</a></dd>
							<dd><a href="#">����</a></dd>
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="T">T</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">̫ԭ</a></dd>
							<dd><a href="#">���</a></dd>
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="W">W</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">�人</a></dd>
						</dl>
					</div>							
					</li>
					<li>
						<h6 id="X">X</h6>
					<div class="city_sub">
						<dl>						
							<dd><a href="#">����</a></dd>
						</dl>
					</div>							
					</li>
				</ul>
			</div>
			
			
			<div class="letter">
				<ul>
					<li>A</li>
					<li>B</li>
					<li>C</li>
					<li>D</li>
					<li>E</li>
					<li>F</li>
					<li>G</li>
					<li>H</li>
					<li>I</li>
					<li>J</li>
					<li>K</li>
					<li>L</li>
					<li>M</li>
					<li>N</li>
					<li>O</li>
					<li>P</li>
					<li>Q</li>
					<li>R</li>
					<li>S</li>
					<li>T</li>
					<li>U</li>
					<li>V</li>
					<li>W</li>
					<li>S</li>
					<li>Y</li>
					<li>Z</li>
				</ul>
			</div>
			<div class="big_letter">
				<h4>C</h4>
			</div>
</div><!--loyout����-->


<?php 
  $getIp=$_SERVER["REMOTE_ADDR"];

  $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=7IZ6fgGEGohCrRKUE9Rj4TSQ&ip={$getIp}&coor=bd09ll");
  $json = json_decode($content);
  //print $json->{'content'}->{'address'};//���㼶��ϵ��ȡaddress����

?>
<body>

<script type="text/javascript" src="/layout/blue/js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="/layout/blue/js/jquery.glide.js"></script>
<script type="text/javascript" src="/layout/blue/js/script.js"></script>
</body>
</html>

