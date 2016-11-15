//移动端pc端 代码切换
//if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent) /*ios*/ || /(Android)/i.test(navigator.userAgent) /*android*/) {
	   
	//   window.location.href ="http://www.html5.cn/pc.html";
	//} else {
	    // window.location.href ="http://www.html5.cn/pc.html";
//	};
//

$(function(){
	if (window.console) {
		console.info(">>Join us? Email：developer@qietu.com");
	}		
	
	/*触屏*/
		$(".slider .inner").bind("swipeleft",function(){
 			
		});
		
		$(".slider .inner").bind("swiperight",function(){
 			
		});
		
		
		
		$.extend({
			autoChange:function(){
				$('#logos ul').animate({'marginLeft':-1100},function(){
					$(this).css('marginLeft',0).find('li:first').appendTo($(this));
				});
			}
		})
		setInterval("$.autoChange()",3000);

     $('#logos .prev').click(function(){
		
			$('#logos ul').animate({'marginLeft':-1100},function(){
				$(this).css('marginLeft',0).find('li:first').appendTo($(this));
			});
		});
		
		$('#logos .next').click(function(){
		
			// 同上
			$('#logos ul').css('marginLeft',-1100).find('li:last').prependTo($('#logos ul'));
			$('#logos ul').animate({'marginLeft':0});
		})
		
//		if($('#slider').size()>0){
//			$('#slider').movingBoxes({
//				startPanel   : 4,  
//				wrap         : false,  
//				buildNav     : true,   
//				navFormatter : function(){ return "&#9679;"; }
//			});
//		}
		
		if($.browser.msie && $.browser.version < 10){
			$('body').addClass('ltie10');
		}
		
		
		
		
		/*导航滑动*/
		var navSelected = $('.header .nav li.selected');
		$('.header .nav .w_line').css({left: navSelected[0].offsetLeft + 'px','width':navSelected.width()});
		
 		$('.header .nav li').hover(function(){
			$('.header .nav li').removeClass('selected');
			$(this).addClass('selected');
			$('.header .nav .w_line').stop().animate({left: $(this)[0].offsetLeft + 'px','width':$(this).width()},500,'easeOutBack');
		});
		
})


$(function(){
			$('.page3 .nav dd').hover(function(){
				var obj = $(this);
				var i = obj.index();
				
//				$('.page3 .nav dd').hide().eq(i).show();
				$('.page3 .txt2 li').hide().eq(i).show();
				$('.page3 .quan2 li').hide().eq(i).show();
				$('.page3 .imgs .quan2').addClass('selected');
			})
			
})








$(function(){
	if($("#timeline").size()>0){
		$("#timeline").timelinr();
	}
	
})

$(document).ready(function() {
	if($('#particles').size()>0){
		
		setTimeout(function(){
			$('#particles').particleground({
			    dotColor: '#26aeec',
			    lineColor: '#26aeec'
			});
		},100)
	}
});