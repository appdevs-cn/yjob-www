//ios
if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
	//alert(navigator.userAgent);

	//add a new meta node of viewport in head node
	head = document.getElementsByTagName('head');
	viewport = document.createElement('meta');
	viewport.name = 'viewport';
	viewport.content = 'target-densitydpi=device-dpi, width=' + 750 + 'px, user-scalable=no';
	head.length > 0 && head[head.length - 1].appendChild(viewport);

}


$(function(){
	if (window.console) {
		console.info(">>Join us? Email：psd2html@qq.com");
	}

	/*触屏*/
	$(".slider .inner").bind("swipeleft",function(){

	});

	$(".slider .inner").bind("swiperight",function(){

	});

	if($('.hslide').size()>0){
		var glide = $('.hslide').glide({

			//autoplay:true,//是否自动播放 默认值 true如果不需要就设置此值

			animationTime:500, //动画过度效果，只有当浏览器支持CSS3的时候生效

			arrows:true, //是否显示左右导航器
			//arrowsWrapperClass: "arrowsWrapper",//滑块箭头导航器外部DIV类名
			//arrowMainClass: "slider-arrow",//滑块箭头公共类名
			//arrowRightClass:"slider-arrow--right",//滑块右箭头类名
			//arrowLeftClass:"slider-arrow--left",//滑块左箭头类名
			arrowRightText:"",//定义左右导航器文字或者符号也可以是类
			arrowLeftText:"",

			nav:true, //主导航器也就是本例中显示的小方块
			navCenter:true, //主导航器位置是否居中
			navClass:"slider-nav",//主导航器外部div类名
			navItemClass:"slider-nav__item", //本例中小方块的样式
			navCurrentItemClass:"slider-nav__item--current" //被选中后的样式

			//
		});
	}


	// 首页选项卡
	//初始化
	$('.job_tah .w_line').stop().animate({left: $('.job_tah li.selected').data('left') + 'px'},500,'easeOutBack');


	var tabfunc = function(obj){

		$('.job_tah li').removeClass('selected');
		obj.addClass('selected');

		$('.job_tabb_wrap').stop().animate({'margin-left':-690*obj.index()},500);

		//动画
		$('.job_tah .w_line').stop().animate({left: obj.data('left') + 'px'},500,'easeOutBack');

		return false;
	}
	$('.job_tah li').not('.nojs').hover(function(){
		tabfunc($(this));

	});

	/*触屏*/
	$(".job_tabb").bind("swipeleft",function(){
		var curr = $('.job_tah li.selected');
		if(curr.next().not('.nojs').size()>0){
			var next = curr.next().not('.nojs');
			tabfunc(next);
		}
		else{
			//var next = $('.job_tah li:not(.nojs):first');
		}


	});

	$(".job_tabb").bind("swiperight",function(){
		var curr = $('.job_tah li.selected');

		//console.log(curr.prev().not('.nojs').size());
		if(curr.prev().not('.nojs').size()>0){
			var prev = curr.prev().not('.nojs');

			tabfunc(prev);
		}
		else{
			//var prev = $('.job_tah li:not(.nojs):last');
		}


	});



	//钱包手动添加
	$('.wallet_body li .bd dd a').click(function(){

		$('.nshow').toggle();

		return false;
	});


	//搜索弹窗
	$('.header .txt').focus(function(){

		$('.search_page').show();
		$('.search_page .txt')[0].focus();
		$('.mask').show();

	});

	$('.return').click(function(){

		$('.search_page').fadeOut();
		$('.mask').fadeOut();
	});


	//选择账户
	$('.wallet_body li.last dd h6').click(function(){

		$('.wallet_body li.last dd h6').removeClass('selected');
		$(this).addClass('selected');

		return false;
	});

	//编辑栏目
	$('.wallet_body li .bd dd .btn1').click(function(){
		f = $(this).parent().parent().parent();
		f.find('.txt').not('.nojs').removeAttr('readonly').removeClass('readonly');
		// $('#bank-username').val('');
		// $('#cardid').val('');
		// $('#bankname').val('');
		// $('#hand-add').val('');
	});

	/*
	 根据〖中华人民共和国国家标准 GB 11643-1999〗中有关公民身份号码的规定，公民身份号码是特征组合码，由十七位数字本体码和一位数字校验码组成。排列顺序从左至右依次为：六位数字地址码，八位数字出生日期码，三位数字顺序码和一位数字校验码。
	 地址码表示编码对象常住户口所在县(市、旗、区)的行政区划代码。
	 出生日期码表示编码对象出生的年、月、日，其中年份用四位数字表示，年、月、日之间不用分隔符。
	 顺序码表示同一地址码所标识的区域范围内，对同年、月、日出生的人员编定的顺序号。顺序码的奇数分给男性，偶数分给女性。
	 校验码是根据前面十七位数字码，按照ISO 7064:1983.MOD 11-2校验码计算出来的检验码。

	 出生日期计算方法。
	 15位的身份证编码首先把出生年扩展为4位，简单的就是增加一个19或18,这样就包含了所有1800-1999年出生的人;
	 2000年后出生的肯定都是18位的了没有这个烦恼，至于1800年前出生的,那啥那时应该还没身份证号这个东东，⊙﹏⊙b汗...
	 下面是正则表达式:
	 出生日期1800-2099  (18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])
	 身份证正则表达式 /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/i
	 15位校验规则 6位地址编码+6位出生日期+3位顺序号
	 18位校验规则 6位地址编码+8位出生日期+3位顺序号+1位校验位

	 校验位规则     公式:∑(ai×Wi)(mod 11)……………………………………(1)
	 公式(1)中：
	 i----表示号码字符从由至左包括校验码在内的位置序号；
	 ai----表示第i位置上的号码字符值；
	 Wi----示第i位置上的加权因子，其数值依据公式Wi=2^(n-1）(mod 11)计算得出。
	 i 18 17 16 15 14 13 12 11 10 9 8 7 6 5 4 3 2 1
	 Wi 7 9 10 5 8 4 2 1 6 3 7 9 10 5 8 4 2 1

	 */
	//身份证号合法性验证
	//支持15位和18位身份证号
	//支持地址编码、出生日期、校验位验证
	function IdentityCodeValid(code) {
		var city={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外 "};
		var tip = "";
		var pass= true;

		if(!code || !/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)?$/i.test(code)){
			tip = "身份证号格式错误";
			pass = false;
		}

		else if(!city[code.substr(0,2)]){
			tip = "地址编码错误";
			pass = false;
		}
		else{
			//18位身份证需要验证最后一位校验位
			if(code.length == 18){
				code = code.split('');
				//∑(ai×Wi)(mod 11)
				//加权因子
				var factor = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ];
				//校验位
				var parity = [ 1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2 ];
				var sum = 0;
				var ai = 0;
				var wi = 0;
				for (var i = 0; i < 17; i++)
				{
					ai = code[i];
					wi = factor[i];
					sum += ai * wi;
				}
				var last = parity[sum % 11];
				if(parity[sum % 11] != code[17]){
					tip = "校验位错误";
					pass =false;
				}
			}
		}
		if(!pass) alert(tip);
		return pass;
	}

	var resMsg = false;
	// 身份证验证
	$('#userid-card').keyup(function () {
		useridCard = $('#userid-card').val().replace(/[ ]/g,"");
		if(!$.isNumeric(useridCard)){
			if(useridCard.length>0 && useridCard.length<18) {
				alert('输入的内容不合法！');
				return resMsg;
			}
		}
		if(useridCard.length<18){
			return resMsg;
		}
		if(useridCard.length == 18){
			maxValc = $('#userid-card').val();
		}
		if(useridCard.length>18){
			alert('您输入的长度有误！');
			$('#userid-card').val(maxValc);
			return resMsg;
		}

		res = IdentityCodeValid(useridCard);

		if(res){
			resMsg = true;
		}else{
			resMsg = false;
		}
		
	})

	$('#userid-card').on('blur',function(){
		var thisVin = $('#userid-card').val().replace(/[ ]/g,"");
		if(thisVin.length == 15){
			res= IdentityCodeValid(thisVin);
			if(res == false){
				alert('身份证号输入有误');
			}
		}
	})

	var bankMsg = false;
	//判断银行
	$('#cardid').keyup(function(){
		sendValue = $('#cardid').val().replace(/[ ]/g,"");
		if(!$.isNumeric(sendValue)){
			if(sendValue.length>0) {
				alert('输入的内容不合法！');
				return bankMsg;
			}
		}
		if(sendValue.length<16){
			return bankMsg;
		}
		if(sendValue.length == 19){
			maxVal = $('#cardid').val();
		}
		if(sendValue.length>19){
			alert('您输入的卡号有误！');
			$('#cardid').val(maxVal);
		}
		bankMsg = false;
		$.ajax({
			type: "POST",

			url: "../personal/BankCard.php",

			data: "card_num=" + sendValue,

			// 加载中状态
			beforeSend: function(){
			},
			// 成功状态
			success: function(msg){
				var msg = JSON.parse(msg);
				if(msg.validated) {
					bankMsg = true;
					$('#bankname').val(msg.bankName);
					$('.wallet_body li .hd h4.n1').removeClass();
					$('.wallet_body li .hd h4').css({"padding-left":0});
					if($('.wallet_body li .hd h4 img')){
						$('.wallet_body li .hd h4 img').remove();
					}
					$('.wallet_body li .hd h4').prepend("<img src='"+ msg.bankImg +"'>");
				}
			}
		})
	});

	// 银行卡数据提交
	$('#banktrue').on('click', function(){
		var sendValue = $('#cardid').val().replace(/[ ]/g,"");
		// 获取银行卡数据
		var userName = $('#bank-username').val();
		var userId = $('#bank-userid').val();
		var userMobile = $('#user-mobile').val();
		var useridCard = $('#userid-card').val();
		var cardId = sendValue;
		var bankName = $('#bankname').val();
		var handAdd = $('#hand-add').val();
		if(userName=='' || useridCard=='' || cardId==''){
			alert('请填写正确数据');
			return false;
		}
		if(useridCard.length == 15 || useridCard.length == 18){
			resMsg = true;
		}else{
			resMsg = false;
		}

		if(typeof(resMsg)!='undefined'){
			if(resMsg==false){
				alert('请填写正确数据');
				return false;
			}
		}
		if(typeof(bankMsg)!='undefined'){
			if(bankMsg==false){
				alert('请填写正确数据');
				return false;
			}
		}
		// 获取银行的logo
		if('.wallet_body li .hd h4 img'){
			var bankLogo = $('.wallet_body li .hd h4 img').prop('src');
		}else{
			var bankLogo = '';
		}
		$.ajax({
			type: 'post',
			url: '../personal/my_bank_card.php',
			data: {
				userName: userName,
				userId: userId,
				userMobile: userMobile,
				useridCard: useridCard,
				cardId: cardId,
				bankName: bankName,
				bankLogo: bankLogo,
				handAdd: handAdd
			},
			// dataType: 'josn',
			success: function(data) {
				// console.log(data);
				if(data == 1){
					$('.wallet_body li.selected').removeClass('selected');
				}
			}
		})
	})
	$('.hasjs').click(function(){

		var f= $(this);
		if(f.hasClass('selected')){
			f.removeClass('selected');
			$('.job_foot ul li.hasjs h4').html('收藏职位');
			$('#sc').hide();
		}
		else{
			f.addClass('selected');
			$('.job_foot ul li.hasjs h4').html('已收藏');

		}

		return false;
	})

	$('.apply a').click(function(){

		var f= $(this);
		if(f.hasClass('selected')){
			$('#bm').hide();
		}
		else{
			f.addClass('selected');
			$('.job_foot .apply a').html(' 已报名');
		}

		return false;
	})


	//弹窗js
//	$('.hasjs').click(function(){
//
//		$('.job_foot ul li.hasjs').addClass('selected');
//		$('.job_foot ul li.hasjs h4').html('已收藏');
//
//		return false;
//	});


	$('alert_last,.fx').click(function(){
		$('.blur').addClass('selected');
	});


//	$('.job_foot .apply a').click(function(){
//
//		$('.job_foot .apply a').html(' 已报名');
//
//		return false;
//	});






	//收缩隐藏
	var checkWalletRadio = function(){
		$('.wallet_body li input[type=radio]').removeAttr('checked');
		$('.wallet_body li.selected [type=radio]').attr('checked','checked');
	}


	//初始化

//	if($('.wallet_body li.selected').size()>0){
//	}
//	else{
//		$('.wallet_body li:first').addClass('selected');
//	}
	checkWalletRadio();


	//事件
	$('.wallet_body li').each(function(){

		var f= $(this);
		$(this).find('.hd').click(function(){

			if(f.hasClass('selected')){
				f.removeClass('selected');

				//单选框
				checkWalletRadio();
			}
			else{
				$('.wallet_body li').removeClass('selected');
				f.addClass('selected');

				//单选框
				checkWalletRadio();
			}

			return false;
		})
	})

	//字母选择联系人
	$('.letter li').hover(function(){

			$('.big_letter').show().find('h4').html($(this).html());

			var a = $.trim($(this).html());

			if($('#'+a).size()>0){
				$('html,body').stop().animate({'scrollTop': $('#'+a).offset().top});
			}


			setTimeout(function(){
				$('.big_letter').hide();
			},2000);

			//阻止页面滚动
//		e.preventDefault && e.preventDefault();
//e.returnValue=false;
//e.stopPropagation && e.stopPropagation();
//return false;

		},
		function(){
			//$('.big_letter').hide();
		})

	//判断下载
	//ios
	if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent) /*ios*/) {
		$('.iPhone').addClass('show');
	}
	else{
		$('.android').addClass('show');
	}
	//android
//	else if (/(Android)/i.test(navigator.userAgent) /*android*/) {
//
//	}


	//换一批精选工作
	$('.new_job .head h2').click(function(){
		var ths = $(this);
		ths.addClass('selected');
		setTimeout(function(){
			ths.removeClass('selected');
		},500)

		var i = $('.job_tah li.selected').index();

		//直招
		if(i==0){
			var lst = $('.job_tabb ul#db');
		}
		//担保
		else if(i==1){
			var lst = $('.job_tabb ul#zz');
		}

		lst.find('li:lt(4)').appendTo(lst);
		return false;
	})


//	职位详情
	/*点击分享以外的任意地方，消失*/
	$(document).bind("click",function(e){

//		if($('.job_mask').is(':visible')){
//
//			alert(3);
//			var target = $(e.target);
//			if(target.closest(".alert li").length == 0){
//
//				$('.job_mask').hide();
//
//			}
//		}
//		else{
//			alert(0);
//		}

	})

	$('.job_mask, .close-alert').click(function(){
		closeDiv('job_mask'); closeDiv('alert'); closeDiv('sc');  closeDiv('bm');
		$('.blur').removeClass('selected');
		return false;
	})


	//首页下载消失
	setTimeout(function(){
		$('.download').fadeOut();
	},5000)

	// var YDB = new YDBOBJ();
	//app中不显示下载提示
	var ua = navigator.userAgent.toLowerCase();
	if(ua.indexOf('ck 2.0')>=0){
		$('.download').hide();
		$('.city_nav>.hd>em>a').bind('click',function(e){
			YDB.GoBack();
		});
		$('.city_nav>.hd>.fx').unbind('click').removeAttr('onclick').bind('click',function(e){
			var title = document.title;
			var url = window.location.href;
			YDB.Share(title,title,'',url);
		});
	}else{
		$('.city_nav>.hd>em>a').bind('click',function(e){
			window.history.go(-1);
		});
	}

})

//打开弹窗
function openDiv(a,b,c){
	var obj = $('#' + a);
	obj.show();


	setTimeout(function(){
		obj.fadeOut();
		c;
	},b*1000)
	return false;
}





//关闭弹窗
function closeDiv(id){
	$('#'+ id).hide();
	return false;
}





