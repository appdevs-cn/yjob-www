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
	/*04BD+�鳤����ҳ ѡ���������*/
	function loadCardTabrr(){
		if($('.bd_view .head ul li.selected').size()<=0){
			return false;
		}
		var navSelected = $('.bd_view .head ul li.selected');
		$('.bd_view .head .f-line').css({left: navSelected[0].offsetLeft + 'px','width':navSelected.width()});
		
 		$('.bd_view .head li').hover(function(){
			$('.bd_view .head li').removeClass('selected');
			$(this).addClass('selected');
			$('.bd_view .body').hide().eq($(this).index()).show();
			$('.bd_view .head .f-line').stop().animate({left: $(this)[0].offsetLeft + 'px','width':$(this).width()},200);
		});
	}	
	/*load*/
	loadCardTabrr();/*��������*/	
})

$(function(){
	/*a_������ǩ�� ѡ���������*/
	function loadCardTabr(){
		if($('.card_tabr .head ul li.selected').size()<=0){
			return false;
		}
		var navSelected = $('.card_tabr .head ul li.selected');
		$('.card_tabr .head .f-line').css({left: navSelected[0].offsetLeft + 'px','width':navSelected.width()});
		
 		$('.card_tabr .head li').hover(function(){
			$('.card_tabr .head li').removeClass('selected');
			$(this).addClass('selected');
			$('.card_tabr .body').hide().eq($(this).index()).show();
			$('.card_tabr .head .f-line').stop().animate({left: $(this)[0].offsetLeft + 'px','width':$(this).width()},200);
		});
	}	
	/*load*/
	loadCardTabr();/*��������*/	
	
	//pie
	if($('.mypie').size()>0){
		$('.mypie').circliful();
	}
	
	/*���ǩ��?*/
	$('.card_dialog .img i').click(function(){
		$(this).parent().fadeOut(function(){
			$(this).remove();
		});
	})
	
	//���۹���
	$('.comment_list li').each(function(){
		var obj = $(this);
		obj.find('.ico').click(function(){
			if(obj.hasClass('selected')){
				obj.removeClass('selected');
			}
			else{
				obj.addClass('selected');
			}
		})
	})
	
	$('.comment_list .bd dd').each(function(){
		var obj = $(this);
		obj.find('i').click(function(){
			var i = $(this).index();
			obj.find('i').removeClass('selected');
			obj.find('i:lt('+ (i+1) +')').addClass('selected');
			
			if(i==0){
				var txt = '�ܲ�';
			}
			if(i==1){
				var txt = '��';
			}
			if(i==2){
				var txt = 'һ��';
			}
			if(i==3){
				var txt = '��';
			}
			if(i==4){
				var txt = '�ܺ�';
			}
			obj.find('span').html(txt);
		})
	})
	
	//����������ʾ
	$('.comment_list .txtarea').each(function(){
		var max = 16;
		var obj = $(this);
		obj.find('textarea').keyup(function(){
			var l = $(this).val().length;
			var l2 = max-l > 0 ? max-l :0;
			if(l2==0){
				var num=$(this).val().substr(0,max);
				$(this).val(num); 
			}
			obj.find('h4 i').html(l2);
		})
	})
	
	//ǩ������
	$('.sign_mgr_d .body li').each(function(){
		
		var obj = $(this);
		obj.find('.ico').click(function(){
			if($('.layout').hasClass('dojs')) return false;
			
			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
				obj.find('.ico h4').html('ȡ����');
				obj.find('.txt h5').html('�����Ϊ�Ÿ���?');
			}
			else{
				$(this).addClass('selected');
				obj.find('.ico h4').html('�Ÿ���');
				obj.find('.txt h5').html('�޼�¼');
			}
		})
	})
	
	$('.sign_mgr_t .body li').each(function(){
		
		var obj = $(this);
		obj.find('.ico').click(function(){
			if($('.layout').hasClass('dojs')) return false;
			
			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
				obj.find('.ico h4').html('ȡ����');
				obj.find('.txt h5').html('�����Ϊ����?');
			}
			else{
				$(this).addClass('selected');
				obj.find('.ico h4').html('����');
				obj.find('.txt h5').html('�޼�¼');
			}
		})
	})
	//ǩ����ѡ��
	var updateSignMgrSize = function(){
		if($('.sign_mgr').size()>0){
			var n = $('.sign_mgr .body input:checked').size();
			$('#yx').html(n);
		}
	}
	updateSignMgrSize();
	$('.sign_mgr .body input').change(function(){
		updateSignMgrSize();
	})
	
	//ȫѡ
	$('.sign_mgr #qx').change(function(){
		if($(this).is(':checked')){
			$('.sign_mgr .body input').attr('checked','checked');
		}
		else{
			$('.sign_mgr .body input').removeAttr('checked');
		}
		updateSignMgrSize();
	})
	
	//ǩ���鿴��ʽ
	$('#qdfs').change(function(){
		var obj = $(this);
		var v = $(this).val();
		
		$('.sign_mgr .body dd').each(function(){
			if(v=='all'){
				$(this).show();
			}
			else if(v=='yes'){
				if($(this).find('input').is(':checked')){
					$(this).show();
				}
				else{
					$(this).hide();
				}
			}
			else if (v=='no'){
				if($(this).find('input').is(':checked')){
					$(this).hide();
				}
				else{
					$(this).show();
				}
			}
			else if (v=='link'){
				window.location.href = obj.data('url');
			}
		})
	})
	
	//ǩ��״̬
	$('.sign_mgr .body dd').each(function(){
		var obj = $(this);
		
		obj.find('.c3').click(function(){
			
			if($('.layout').hasClass('dojs')) return false;
			
			if($(this).hasClass('c3_1')){
				var c = 'c3_2';
			}
			else if($(this).hasClass('c3_2')){
				var c = 'c3_3';
			}
			else if($(this).hasClass('c3_3')){
				var c = 'c3_1';
			}
			$(this).removeClass().addClass('c3 '+ c);
			
			//״̬2
			if(c=='c3_1' || c=='c3_3'){
				obj.find('input').removeAttr('checked');
			}
			else{
				obj.find('input').attr('checked','checked');
			}
		})
	})
	//��������
	$('#pl').click(function(){
		if($('.layout').hasClass('dojs')){
			$('.layout').removeClass('dojs');
			$(this).html('��������');
			$('.sign_mgr input').attr('disabled','disabled');
			 //$('.sign_mgr form').reset();
			window.location.reload();
		}
		else{
			$('.layout').addClass('dojs');
			$(this).html('ȡ��');
			$('.sign_mgr input').removeAttr('disabled');
			
		}
	})
	//ǩ�����??��
	$('.sign_info .body .tels').change(function(){
		var v = $(this).val();
		$('.sign_info .body .tele').attr('href', 'tel:'+v);
	})
	
	//ǩ��ͼƬ
	$('.sign_list .head .ico').click(function(){
		
		if($(this).hasClass('all')){
			var c = 'yes';
		}
		else if($(this).hasClass('yes')){
			var c = 'no';
		}
		else if($(this).hasClass('no')){
			var c = 'all';
		}
		
		$(this).removeClass().addClass('ico '+ c);
		
		$('.sign_mgr .body dd').each(function(){
			var obj = $(this);
			
			obj.show();
			if(c=='yes'){
				
				if(obj.find('input').is(':checked')){
					
				}
				else{
					obj.hide();
				}
			}
			else if(c=='no'){
				if(obj.find('input').is(':checked')){
					obj.hide();
				}
				else{
					
				}
			}
			else if (c=='all'){
				
			}
		})
		return false;
	})
	
	//ǩ���鿴ͼƬ
	$('.sign_list .body .img').click(function(){
		$('#ifm').attr('src',$(this).attr('href')).show();
		return false;
	})
	
	//������ǩ���鿴ͼƬ
	$('.card_list .addr').click(function(){
		$('#ifm').attr('src',$(this).attr('href')).show();
		return false;
	})
	
	//���۹���
	$('#zk').click(function(){
		if($(this).hasClass('open')){
			$(this).removeClass('open').html('ȫ��չ��');
			$('.comment_list li').removeClass('selected');
		}
		else{
			$(this).addClass('open').html('ȫ���պ�');
			$('.comment_list li').addClass('selected');
			
		}
	})
	
	//���۲鿴��ʽ
	$('#pjfs').change(function(){
		var obj = $(this);
		var v = $(this).val();
		if(v=='all'){
			$('.comment_list li').show();
		}
		else if(v=='yes'){
			$('.comment_list li').hide();
			$('.comment_list li.replyed').show();
		}
		else if (v=='no'){
			$('.comment_list li').hide();
			$('.comment_list li').not('.replyed').show();
		}
		else if (v=='link'){
			window.location.href = obj.data('url');
		}
	})
	
	
	$('.pic_view .slides').css('height', parseInt($(window).height())-90);
	//ͼƬ�鿴��
	if($('.pic_view').size()>0){
		setTimeout(function(){
		var glide = $('.pic_view').glide({

			//autoplay:true,//�Ƿ��Զ����� Ĭ��ֵ true�����Ҫ�����ô��?

			animationTime:500, //�������Ч��ֻ�е������֧��CSS3��ʱ����Ч

			arrows:false, //�Ƿ���ʾ���ҵ�����
			//arrowsWrapperClass: "arrowsWrapper",//�����ͷ�������ⲿDIV����
			//arrowMainClass: "slider-arrow",//�����ͷ��������?
			//arrowRightClass:"slider-arrow--right",//�����Ҽ�ͷ����
			//arrowLeftClass:"slider-arrow--left",//�������ͷ����?
			arrowRightText:"",//�������ҵ��������ֻ��߷��Ҳ��������?
			arrowLeftText:"",

			nav:false, //��������Ҳ���Ǳ�������ʾ��С����
			navCenter:true, //��������λ���Ƿ����?
			navClass:"slider-nav",//���������ⲿdiv����
			navItemClass:"slider-nav__item", //������С��������?
			navCurrentItemClass:"slider-nav__item--current" //��ѡ�к�����?
		});
		},10)
	}
	
	$('.pic_view li').click(function(){
		var obj = $(this);
		f = $(this).parent().parent().parent();
		if(obj.hasClass('jshow')){
			obj.removeClass('jshow');
			f.find('.pic_desc').slideDown();
			f.find('.user_head').slideDown();
		}
		else{
			obj.addClass('jshow');
			f.find('.pic_desc').slideUp();
			f.find('.user_head').slideUp();
		}
	})
	
	//����
	$('.user_head .ico_prev').not('.nojs').click(function(){
		
		history.back();
	})
})

//�򿪵���
function openDiv(id){
	$('#'+ id).show();
	return false;
}
//�رյ���
function closeDiv(id){
	$('#'+ id).hide();
	return false;
}





