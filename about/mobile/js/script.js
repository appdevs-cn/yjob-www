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


//移动端pc端  代码切换
//if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent) /*ios*/ || /(Android)/i.test(navigator.userAgent) /*android*/) {
	   
	//   window.location.href ="http://www.html5.cn/pc1.html";
	//} else {
	    // window.location.href ="http://www.html5.cn/pc2.html";
	//};
//


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
			
	
	//选择城市
	$('.gh,.home_page .img1').click(function(){
		var h = $(document).height();
		if($('.naver').hasClass('selected')){
			$('.naver, .header').removeClass('selected');
			
			$('.naver').animate({'height':0},'normal');
		}										
		else{
			$('.naver, .header').addClass('selected');
			$('.naver').animate({'height':h},'normal');
		}					
	})
	
	
	
})


$(function(){
   if($('#masonry').size()>0){
	var $container = $('#masonry');
    $container.imagesLoaded(function() {
        $container.masonry({
                itemSelector: '.box',
                gutter: 10,
                isAnimated: true,
           });
     });
    }
      

     /**/
    $('.recommends .ico').click(function(){
    	if($(this).hasClass('selected')){
    		$(this).removeClass('selected');
    	}
    	else{
    		$(this).addClass('selected');
    	}
    	return false;
    })
    
    /*商品详情页幻灯片*/
   if($('.glide').size()>0){
   		var glide = $('.glide').glide({

			//autoplay:true,//是否自动播放 默认值 true如果不需要就设置此值

			animationTime:500, //动画过度效果，只有当浏览器支持CSS3的时候生效

			arrows:false, //是否显示左右导航器
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
		});
   }
   
})

$(function(){
	
	
	//页面不足一屏，铺满一屏
	$('.layout').css('min-height',$(window).height());
})