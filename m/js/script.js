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
		$('#cardid').val('');
		$('#bankname').val('');
		$('#hand-add').val('');
	});
	
	//判断银行
	$('#cardid').keyup(function(){
		sendValue = $('#cardid').val().replace(/[ ]/g,"");
		if(!$.isNumeric(sendValue)){
			return false;
		}
		if(sendValue.length<16 || sendValue.length>19){
			return false;
		}

		$.ajax({
			type: "POST",
		
			url: "../personal/bank.php",
			
			data: "cardid=" + sendValue,
			
			// 加载中状态
			beforeSend: function(){
			},
			// 成功状态
			success: function(msg){
				// console.log(msg);
				$('#bankname').val(msg);
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
		var cardId = sendValue;
		var bankName = $('#bankname').val();
		var handAdd = $('#hand-add').val();
		$.ajax({
			type: 'post',
			url: '../personal/my_bank_card.php',
			data: {
				userName: userName,
				userId: userId,
				userMobile: userMobile,
				cardId: cardId,
				bankName: bankName,
				handAdd: handAdd
			},
			// dataType: 'josn',
			success: function(data) {
				console.log(data);
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
	
	var YDB = new YDBOBJ();
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





