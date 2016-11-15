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
	
	
     //页面不足一屏，铺满一屏
	$('.layout').css('min-height',$(window).height());
	
})
	
	//钱包手动添加
	$('.wallet_body li .bd dd a').click(function(){
		
		$('.nshow').toggle();
		
		return false;
	});
	
//	 $('.myresume .item ul li .input a').click(function(){
//				
//		
//		
//	});
	
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
	
	/*$('.myresume .ft_btn').click(function(){
		
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
	})*/
	
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
			
			if($(this).hasClass('c1')){
				
			}
			else{
				openDiv('mixfive',1);	
				return false;
			}
			
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
		var max = 120;
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
	/*$('.nickname').each(function(){
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
	})*/
	
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
	

	
	//取消报名
	$('.all_work .body li').each(function(){
		var f = $(this);
		$(this).find('.btn dd span').click(function(){
			f.hide();
			return false;
		})		
	})
	//取消报名  收缩展开
	$('.all_work .body li em').click(function(){
			
		var f= $(this);	
	
			if(f.hasClass('selected')){
				f.removeClass('selected');
				f.parent().find('.btn').hide();	
				
			}
			else{
				f.addClass('selected');
				f.parent().find('.btn').show();	
				
				
			}
			
			return false;
	});
	//收藏删除
	$('.collect_body li').each(function(){
		var f = $(this);
		$(this).find('.Operation').click(function(){
			f.animate({'margin-left':'100%','opacity':0},'normal',function(){
				f.remove();															 
			});
			//f.hide();
			return false;
		})		
	})
	//编辑
	$('.mycenter .bianji').click(function(){
		
			 var p=$(this);

			if($('.all_work .Operation').hasClass('selected')){
				  
				
				 
				$('.all_work .Operation').removeClass('selected');
				p.html('编辑');	
				
			}
			else{
				
				
				$('.all_work .Operation').addClass('selected');
				p.html('完成');	
				
				
			}
			
			return false;
	})
	
	/*验证码*/
	$('#getcode').live('click',function(event){
		if($(this).hasClass('disabled')){
				return false;	
		}
			
		$(this).addClass('disabled');
							 
		 var ths = $(this);
		 var val = $(event.target)[0].tagName == 'INPUT' ? ths.val() : ths.html();
		 var isinput = $(event.target)[0].tagName == 'INPUT' ? true : false;
		 var time = 60;
		 
		 if(isinput){
				ths.val(time+ '秒后可重发');		 
			}
			else{
				ths.html(time + '秒后可重发');
			}
			
		 _timeRun = setInterval(function(){
			if(time==1){
				ths.css('cursor','pointer');
				if(isinput){
				
					ths.val(val);		 
				}
				else{
				
					ths.html(val);
				}
				clearInterval(_timeRun);
				ths.removeClass('disabled');
			}
			if(time>1){
				time--;
				//console.log(time);
				ths.css('cursor','default');
				
				
				
				 //alert($(event.target)[0].tagName);
				 if(isinput){
					ths.val(time+ '秒后可重发');		 
				}
				else{
					ths.html(time + '秒后可重发');
				}
			}
			
			
		},1000);
								
		
		return false;											
	});
	
	//消息次数选择
//	多选
	$('.more_ch dd').click(function(){
				
	
		var f= $(this);			
		if(f.hasClass('selected')){
			f.removeClass('selected');		
		}
		else{
			f.addClass('selected');
					
		}			
		return false;
    })
	
	//单选
	$('.one_ch dd').click(function(){
		
		$('.one_ch dd').removeClass('selected');
		$(this).addClass('selected');
				
	});	
	$('.one_chg dd').click(function(){
		
		$('.one_chg dd').removeClass('selected');
		$(this).addClass('selected');
				
	});	
	
	
	

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
	$('.mask, .qx,.chg_dialog em,.set_dialog .btn2').click(function(){
		closeDiv('mask'); closeDiv('avatar_al');    		
		return false;
	})
	//清空所有缓存
	$('.set_index li dd.hasjs .label').click(function(){
		openDiv('set_dialog',999999); 
		openDiv('mask',999999);
		return false;
	})
	
    //alert($.cookie);
    
   
    
//  //我的简历-昵称
//  $('#nickname #save_tx').click(function(){
//  	
//  	
////		$('#nickname').hide();
//////		var val = $('#jssave').val();
//////		$('#nicheng').val(val);
//	})
////  //我的简历-姓名
////    $('#myname #save_tx').click(function(){
////		$('#myname').hide();
////		var val = $('#jsname').val();
////		$('#xingming').val(val);
////	})
////    //我的简历-描述
////    $('#describe #save_tx').click(function(){
////		$('#describe').hide();
////		var val = $('#jsdes').val();
////		$('#miaoshu').val(val);
////	})

    $('.save').click(function(){
		
		$('.dialog_n').hide();		
	})
	
	//选择学校
	$('.chg_school li').click(function(){
									   
		if($.cookie != undefined){
			$.cookie('school', $(this).val());		
		}
		history.back();
	})
	
	//console.log($.cookie('school'));
	if($.cookie != undefined){
		$('#schoolName').html($.cookie('school'));
	}
	
	if($.cookie != undefined && $.cookie('school')){
	   $('.hasjs_item').show();	
   }
})


