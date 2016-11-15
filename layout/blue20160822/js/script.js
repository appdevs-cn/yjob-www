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
		console.info(">>Join us? Email��psd2html@qq.com");
	}		
	
	/*����*/
		$(".slider .inner").bind("swipeleft",function(){
 			
		});
		
		$(".slider .inner").bind("swiperight",function(){
 			
		});
		
		if($('.hslide').size()>0){
			var glide = $('.hslide').glide({
	
				//autoplay:true,//�Ƿ��Զ����� Ĭ��ֵ true�����Ҫ�����ô�ֵ
	
				animationTime:500, //�������Ч��ֻ�е������֧��CSS3��ʱ����Ч
	
				arrows:true, //�Ƿ���ʾ���ҵ�����
				//arrowsWrapperClass: "arrowsWrapper",//�����ͷ�������ⲿDIV����
				//arrowMainClass: "slider-arrow",//�����ͷ��������
				//arrowRightClass:"slider-arrow--right",//�����Ҽ�ͷ����
				//arrowLeftClass:"slider-arrow--left",//�������ͷ����
				arrowRightText:"",//�������ҵ��������ֻ��߷��Ҳ��������
				arrowLeftText:"",
	
				nav:true, //��������Ҳ���Ǳ�������ʾ��С����
				navCenter:true, //��������λ���Ƿ����
				navClass:"slider-nav",//���������ⲿdiv����
				navItemClass:"slider-nav__item", //������С�������ʽ
				navCurrentItemClass:"slider-nav__item--current" //��ѡ�к����ʽ
				
				//
			});
		}
				
		
	// ��ҳѡ�
	//��ʼ��
	$('.job_tah .w_line').stop().animate({left: $('.job_tah li.selected').data('left') + 'px'},500,'easeOutBack');
	
	
	var tabfunc = function(obj){
		
		$('.job_tah li').removeClass('selected');
		obj.addClass('selected');
		
		$('.job_tabb_wrap').stop().animate({'margin-left':-690*obj.index()},500);
		
		//����
	   $('.job_tah .w_line').stop().animate({left: obj.data('left') + 'px'},500,'easeOutBack');
		
		return false;
	}
	$('.job_tah li').not('.nojs').hover(function(){
		tabfunc($(this));
		
	});
	
	/*����*/
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
	
     
	
	//Ǯ���ֶ����
	$('.wallet_body li .bd dd a').click(function(){
		
		$('.nshow').toggle();
		
		return false;
	});
	
	
	//��������
	$('.header .txt').focus(function(){
		
		$('.search_page').show();
		$('.search_page .txt')[0].focus();
		$('.mask').show();
		
	});
	
	$('.return').click(function(){
		
		$('.search_page').fadeOut();
		$('.mask').fadeOut();
	});
	
	
		//ѡ���˻�
	$('.wallet_body li.last dd h6').click(function(){
		
		$('.wallet_body li.last dd h6').removeClass('selected');
		$(this).addClass('selected');
		
		return false;
	});
	
	//�༭��Ŀ
	$('.wallet_body li .bd dd .btn1').click(function(){
		f = $(this).parent().parent().parent();
			f.find('.txt').not('.nojs').removeAttr('readonly').removeClass('readonly');
		
	});
	
	//�ж�����
	$('#cardid').keydown(function(){
		
		$.ajax({
			type: "POST",
		
			url: "http://www4.qietu.com/html/yjianzhi1/php/bank.php",
			
			data: "cardid="+$('#cardid').val(),
			
			// ������״̬
			beforeSend: function(){
			},
			// �ɹ�״̬
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
				$('.job_foot ul li.hasjs h4').html('�ղ�ְλ');
				$('#sc').hide();
			}
			else{
				f.addClass('selected');
				$('.job_foot ul li.hasjs h4').html('���ղ�');
				
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
				$('.job_foot .apply a').html(' �ѱ���');
			}
			
			return false;
	})
	
	
	//����js
//	$('.hasjs').click(function(){
//		
//		$('.job_foot ul li.hasjs').addClass('selected');
//		$('.job_foot ul li.hasjs h4').html('���ղ�');
//
//		return false;
//	});
	
	
	$('alert_last,.fx').click(function(){		
		$('.blur').addClass('selected');
	});		
	
		
//	$('.job_foot .apply a').click(function(){
//		
//		$('.job_foot .apply a').html(' �ѱ���');
//		
//		return false;
//	});	

	
	
	
	
	
	//��������
	var checkWalletRadio = function(){
		$('.wallet_body li input[type=radio]').removeAttr('checked');
		$('.wallet_body li.selected [type=radio]').attr('checked','checked');
	}
	
	
	//��ʼ��
	
//	if($('.wallet_body li.selected').size()>0){
//	}
//	else{
//		$('.wallet_body li:first').addClass('selected');
//	}
	checkWalletRadio();
	
	
	//�¼�
	$('.wallet_body li').each(function(){
		
		var f= $(this);
		$(this).find('.hd').click(function(){
			
			if(f.hasClass('selected')){
				f.removeClass('selected');
				
				//��ѡ��
				checkWalletRadio();
			}
			else{
				$('.wallet_body li').removeClass('selected');
				f.addClass('selected');
			
				//��ѡ��
				checkWalletRadio();
			}
			
			return false;
		})
	})
	
	//��ĸѡ����ϵ��
	$('.letter li').hover(function(){
		
		$('.big_letter').show().find('h4').html($(this).html());
		
		var a = $.trim($(this).html());
		
		if($('#'+a).size()>0){
			$('html,body').stop().animate({'scrollTop': $('#'+a).offset().top});
		}
		
		
		setTimeout(function(){
			$('.big_letter').hide();
		},2000);
		
		//��ֹҳ�����
//		e.preventDefault && e.preventDefault();
//e.returnValue=false;
//e.stopPropagation && e.stopPropagation();
//return false;
		
	},
	function(){
		//$('.big_letter').hide();
	})
	
	//�ж�����
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
	
	
	//�����л�
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
	
	
	//��һ��ѡ����
	$('.new_job .head h2').click(function(){
		var ths = $(this);
		ths.addClass('selected');
		setTimeout(function(){
			ths.removeClass('selected');
		},500)
		
		var i = $('.job_tah li.selected').index();
		
		//ֱ��
		if(i==0){
			var lst = $('.job_tabb ul#db');
		}
		//����
		else if(i==1){
			var lst = $('.job_tabb ul#zz');
		}
		
		lst.find('li:lt(4)').appendTo(lst);
		return false;
	})
	
	
//	// ��ѡ������
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
	

	
//	ְλ����
	/*����������������ط�����ʧ*/
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
	
	
	$('.data_time .head .r').click(function(){
	    $('#form_tj').submit();
		return false;
	})
	
	//��ҳ������ʧ
	setTimeout(function(){
		$('.download').fadeOut();
	},5000)
	
})

//�򿪵���
function openDiv(a,b,c){
	var obj = $('#' + a);
	obj.show();
	
	
	setTimeout(function(){
		obj.fadeOut();
		c;
	},b*1000)
	return false;
}





//�رյ���
function closeDiv(id){
	$('#'+ id).hide();
	return false;
}

/*����ѡ��ʱ��*/
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


