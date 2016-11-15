////ios
//if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
// //alert(navigator.userAgent); 
// 
// //add a new meta node of viewport in head node
//	head = document.getElementsByTagName('head');
//	viewport = document.createElement('meta');
//	viewport.name = 'viewport';
//	viewport.content = 'target-densitydpi=device-dpi, width=' + 750 + 'px, user-scalable=no';
//	head.length > 0 && head[head.length - 1].appendChild(viewport);    
// 
//}


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
		
	});
	
	//判断银行
	$('#cardid').keydown(function(){
		
		$.ajax({
			type: "POST",
		
			url: "http://www4.qietu.com/html/yjianzhi1/php/bank.php",
			
			data: "cardid="+$('#cardid').val(),
			
			// 加载中状态
			beforeSend: function(){
			},
			// 成功状态
			success: function(msg){
				//console.log(msg);
				$('#bankname').val(msg);
			}
		})
	}); 
	
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
	
	
	//日历切换
	$('.data_time .prve').click(function(){
		
		$('.data_time ul').animate({'marginLeft':-750},function(){
			$(this).css('marginLeft',0).find('li:first').appendTo($(this));
		});
	});
	
	$('.data_time .next').click(function(){
	
		$('.data_time ul').css('marginLeft',-750).find('li:last').prependTo($('.data_time ul'));
		$('.data_time ul').animate({'marginLeft':0});
		return false;
		
	})
	
	
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
	
	
//	// 复选框美化
//	$('.ui-checkbox').each(function(index){
//		
//		var obj = $(this);
//	 
//		
//		var id = $(this).attr('id') == undefined ? 'id'+index :  $(this).attr('id');
//		
//		obj.attr('id',id);
//		obj.wrap('<span class="ui-checkbox-wrap"></span>');
//		obj.parent().append('<label for="'+ id +'"></label>');
//		
//		 
//		obj.change(function(){
//		})
//	})
	

	
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
	
	
	
	//第三期js代码
	//返回效果
	$('#return').click(function(){
		
		history.back();
	})
//	//我的信誉返回效果
//	$('.myreputation  .return').click(function(){
//		
//		history.back();
//	})
	//我的简历  收缩展开
	
	$('.myresume .ft_btn').click(function(){
		
		var f= $(this);			
			if(f.hasClass('selected')){
				f.removeClass('selected');
				f.parent().find('.hasjs_item').show();	
				f.find('span').html('收起更多模板');		
			}
			else{
				f.addClass('selected');
				f.parent().find('.hasjs_item').hide();	
				f.find('span').html('展开更多模板');	
				
			}
			
			return false;
	})
	
	//选择工作时间
	//选择工作时间
	$(' .body_time dd').click(function(){
	
		var f= $(this);			
		if(f.hasClass('c1')){
			f.removeClass('c1');
			f.find('i').removeClass('selected');			
		}
		else{
			f.addClass('c1');
			f.find('i').addClass('selected');			
		}			
		return false;
    })
	// 
	$('.body_job dd').click(function(){
				
		if($('.body_job dd.c1').size()>=5){
			
			$('.mixfive').show();	
			return false;
		}
	
		var f= $(this);			
		if(f.hasClass('c1')){
			f.removeClass('c1');
			f.find('i').removeClass('selected');			
		}
		else{
			f.addClass('c1');
			f.find('i').addClass('selected');			
		}			
		return false;
    })
	
	//
		
	$(' .su').click(function(){		
	var f= $(this);			
		if(f.hasClass('c3')){
			f.removeClass('c3');							
		}
		else{
			f.addClass('c3');					
		}			
		return false;
    })
	  //
	  $(' .sn').click(function(){		
		var f= $(this);			
			if(f.hasClass('c2')){
				f.removeClass('c2');							
			}
			else{
				f.addClass('c2');					
			}			
			return false;
	    })
	  
	  //附加魅力卡   删除图片
	$('.magic_card .item li').each(function(){
		var f = $(this);
		$(this).find('em').click(function(){
			f.hide();
			return false;
		})
		
	})
	
	//所在地区删除
	$('.region_head ul li').each(function(){
		var f = $(this);
		$(this).find('i').click(function(){
			f.hide();
		
		})
		
	})
	
	//限制输入字数
	//自我描述
	$('.nickname').each(function(){
		var max = 40;
		var obj = $(this);
		obj.find('textarea').keyup(function(){
			var l = $(this).val().length;
			var l2 = max-l > 0 ? max-l :0;
			if(l2==0){
				var num=$(this).val().substr(0,max);
				$(this).val(num); 
			}
			obj.find('h5 span').html(l2);
		})
	})
	//修改昵称
	$('.nickname').each(function(){
		var max = 8;
		var obj = $(this);
		obj.find('.nicheng').keyup(function(){
			var l = $(this).val().length;
			var l2 = max-l > 0 ? max-l :0;
			if(l2==0){
				var num=$(this).val().substr(0,max);
				$(this).val(num); 
			}
			obj.find('h5 span').html(l2);
		})
	})
	
	//修改姓名
	$('.nickname').each(function(){
		var max = 4;
		var obj = $(this);
		obj.find('.xingming').keyup(function(){
			var l = $(this).val().length;
			var l2 = max-l > 0 ? max-l :0;
			if(l2==0){
				var num=$(this).val().substr(0,max);
				$(this).val(num); 
			}
			obj.find('h5 span').html(l2);
		})
	})
	
	
	
	
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

/*日历选择时间*/
$(function(){
	$('.data_time table').each(function(){
		
		var a = $(this).index();
		
		
		$(this).find('tr').each(function(){
			var b = $(this).index();	
			
			
			$(this).find('td').each(function(){
					
				var c = $(this).index();
				
				var input = $(this).find('input[type=checkbox]');
				var label = $(this).find('label');
				var i = 'i_'+ a +'_'+ b +'_' + c;
				input.attr('id', i);
				label.attr('for', i);							 
			})
			
		})
		
		
		
		
	})		   
})


$(function(){
//	/*导航滑动*/
//	function loadNavSlide(){
//		var navSelected = $('.all_work .head li.selected');
//		$('.all_work .head .f-line').css({left: navSelected[0].offsetLeft + 'px','width':navSelected.width()});
//		
// 		$('.all_work .head li').hover(function(){
//			$('.all_work .head li').removeClass('selected');
//			$(this).addClass('selected');
//			$('.all_work .head .f-line').stop().animate({left: $(this)[0].offsetLeft + 'px','width':$(this).width()},200);
//		});
//	}	
//	/*load*/
//	loadNavSlide();/*导航滑动*/	


//	个人中心js
	// 选项卡
	$('.all_work .head li').hover(function(){
		
		$('.all_work .head li').removeClass('selected');
		$(this).addClass('selected');
		
		$('.all_work .body').hide().eq($(this).index()).show();
		
		return false;
	});	
	
	//取消工作
	$('.all_work .body li').each(function(){
		var f = $(this);
		$(this).find('span').click(function(){
			f.hide();
			return false;
		})
		
	})
	
	//弹窗消失通用js
	$('.mask, .qx').click(function(){
		closeDiv('mask'); closeDiv('avatar_al'); closeDiv('sex'); closeDiv('graduation');     		
		return false;
	})
	
	
    
    
    
    
})


