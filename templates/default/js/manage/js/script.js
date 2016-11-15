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
	/*04BD+组长管理页 选项卡滑动滑动*/
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
	loadCardTabrr();/*导航滑动*/	
})

$(function(){
	/*a_工作卡签到 选项卡滑动滑动*/
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
	loadCardTabr();/*导航滑动*/	
	
	//pie
	if($('.mypie').size()>0){
		$('.mypie').circliful();
	}
	
	/*点击签到*/
	$('.card_dialog .img i').click(function(){
		$(this).parent().fadeOut(function(){
			$(this).remove();
		});
	})
	
	//评论管理
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
				var txt = '很差';
			}
			if(i==1){
				var txt = '差';
			}
			if(i==2){
				var txt = '一般';
			}
			if(i==3){
				var txt = '好';
			}
			if(i==4){
				var txt = '很好';
			}
                        $.post("personal_ajax.php", {"act":"eveluate","eid":obj.data('eid'), "typekey":obj.data('key'), "uid":obj.data('uid'),"score":i+1},
                            function (data,textStatus)
                             {
                                //location.reload();
                             }
                        );
			obj.find('span').html(txt);
		})
	})
	
	//限制字数提示
	$('.comment_list .txtarea').each(function(){
		var max = 100;
		var obj = $(this);
		obj.find('textarea').change(function(){
			var l = $(this).val().length;
			var l2 = max-l > 0 ? max-l :0;
			if(l2==0){
				var num=$(this).val().substr(0,max);
				$(this).val(num); 
			}
			obj.find('h4 i').html(l2);
                        $.post("personal_ajax.php", {"act":"eveluate","eid":$(this).data('eid'),"uid":$(this).data('uid'),"content":$(this).val()},
                            function (data,textStatus)
                             {
                                //location.reload();
                             }
                        );
		})
	})
	
	//签到管理
	$('.sign_mgr_d .body li').each(function(){
		
		var obj = $(this);
		obj.find('.ico').click(function(){
			if($('.layout').hasClass('dojs')) return false;
			if($(this).hasClass('selected')){
                            $.post("personal_ajax.php", {"act":"stood","eid":$(this).attr('data-eid'), "status":100},
                                function (data,textStatus)
                                 {
                                    location.reload();
                                 }
                            );
//                            $(this).removeClass('selected');
//                            obj.find('.ico h4').html('取消标记');
//                            obj.find('.txt h5').html('被标记为放鸽子');
			}
			else{
                            $.post("personal_ajax.php", {"act":"stood","eid":$(this).attr('data-eid'), "status":200},
                                function (data,textStatus)
                                 {
                                    location.reload();
                                 }
                            );
//                            $(this).addClass('selected');
//                            obj.find('.ico h4').html('放鸽子');
//                            obj.find('.txt h5').html('无记录');
			}
		})
	})
	
	$('.sign_mgr_t .body li').each(function(){
		
		var obj = $(this);
		obj.find('.ico').click(function(){
			if($('.layout').hasClass('dojs')) return false;
			
			if($(this).hasClass('selected')){
                            $.post("personal_ajax.php", {"act":"leaveEarly","eid":$(this).attr('data-eid'), "status":200},
                                function (data,textStatus)
                                 {
                                    location.reload();
                                 }
                            );
			}
			else{
                            alert('ss');
                            $.post("personal_ajax.php", {"act":"leaveEarly","eid":$(this).attr('data-eid'), "status":100},
                                function (data,textStatus)
                                 {
                                    location.reload();
                                 }
                            );
			}
		})
	})
	//签到已选择
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
	
	//全选
	$('.sign_mgr #qx').change(function(){
		if($(this).is(':checked')){
			$('.sign_mgr .body input').attr('checked','checked');
		}
		else{
			$('.sign_mgr .body input').removeAttr('checked');
		}
		updateSignMgrSize();
	})
	
	//签到查看方式
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
        $('#work_date').change(function(){
		var obj = $(this);
		var v = $(this).val();
                var url = obj.data('url')+'&work_date='+v;
                window.location.href = url;
		
	})
        
        $('#show_type').change(function(){
		var obj = $(this);
		var v = $(this).val();
                var url = obj.data('url')+'&show_type='+v;
                window.location.href = url;
		
	})
        
        
        
	
	//签到状态
	$('.sign_mgr .body dd').each(function(){
		var obj = $(this);
		
		obj.find('.c3').click(function(){
                    var eids = [];
                    eids.push($(this).attr('data-sid'));
			
			if($('.layout').hasClass('dojs')) return false;
			
			if($(this).hasClass('c3_1')){
                             $.post("personal_ajax.php", {"act":"changeStatus","sids":eids, "status":100},
                                function (data,textStatus)
                                 {
                                    //location.reload();
                                 }
                            );
				var c = 'c3_2';
                                $(this).removeClass().addClass('c3 '+ c);

			}
			else if($(this).hasClass('c3_2')){
                             $.post("personal_ajax.php", {"act":"changeStatus","sids":eids, "status":200},
                                function (data,textStatus)
                                 {
                                    //location.reload();
                                 }
                            );
				var c = 'c3_3';
                                $(this).removeClass().addClass('c3 '+ c);

                            }
			else if($(this).hasClass('c3_3')){
                            $.post("personal_ajax.php", {"act":"changeStatus","sids":eids, "status":100},
                                function (data,textStatus)
                                 {
                                    //location.reload();
                                 }
                            );
                            var c = 'c3_2';
                            $(this).removeClass().addClass('c3 '+ c);

			}
			
			//状态2
			if(c !='c3_1'){
                                obj.find('input').attr('checked','checked');
			}
		})
	})
	//批量操作
	$('#pl').click(function(){
		if($('.layout').hasClass('dojs')){
			$('.layout').removeClass('dojs');
			$(this).html('批量操作');
			$('.sign_mgr input').attr('disabled','disabled');
			 //$('.sign_mgr form').reset();
			window.location.reload();
		}
		else{
			$('.layout').addClass('dojs');
			$(this).html('取消');
			$('.sign_mgr input').removeAttr('disabled');
			
		}
	})
        //批量操作
	$('.pl').click(function(){
            var sids =[];
            $('input[name="sid"]:checked').each(function(){
                sids.push($(this).val());
            });
            if(sids.length != 0) {
                $.post('personal_ajax.php', {'act':'changeStatus','sids':sids,"status":$(this).attr('data-status')}, 
                    function (data,textStatus)
                    {
                       location.reload();
                    }
                );
            } else {
                alert('你还没有选择任何内容');
            }
	})
	
	//组长管理页下拉菜单
	$('.user_head h2').click(function(){
		if($('.user_head .sub').hasClass('selected')){
			$('.user_head .sub').removeClass('selected');
		}
		else{
			$('.user_head .sub').addClass('selected');
			
			
		}
	})
	//签到管理拨号
	$('.sign_info .body .tels').change(function(){
		var v = $(this).val();
		$('.sign_info .body .tele').attr('href', 'tel:'+v);
	})
	
	//签到图片
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
	
	//签到查看图片
	$('.sign_list .body .img').click(function(){
		$('#ifm').attr('src',$(this).attr('href')).show();
		return false;
	})
	
	//工作卡签到查看图片
	$('.card_list .addr').click(function(){
		$('#ifm').attr('src',$(this).attr('href')).show();
		return false;
	})
	
	//评价管理
	$('#zk').click(function(){
		if($(this).hasClass('open')){
			$(this).removeClass('open').html('全部展开');
			$('.comment_list li').removeClass('selected');
		}
		else{
			$(this).addClass('open').html('全部闭合');
			$('.comment_list li').addClass('selected');
			
		}
	})
	
	//评价查看方式
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
	//图片查看器
	if($('.pic_view').size()>0){
		setTimeout(function(){
		var glide = $('.pic_view').glide({

			//autoplay:true,//是否自动播放 默认值 true如果不需要就设置此值

			animationTime:500, //动画过度效果，只有当浏览器支持CSS3的时候生效

			arrows:false, //是否显示左右导航器
			//arrowsWrapperClass: "arrowsWrapper",//滑块箭头导航器外部DIV类名
			//arrowMainClass: "slider-arrow",//滑块箭头公共类名
			//arrowRightClass:"slider-arrow--right",//滑块右箭头类名
			//arrowLeftClass:"slider-arrow--left",//滑块左箭头类名
			arrowRightText:"",//定义左右导航器文字或者符号也可以是类
			arrowLeftText:"",

			nav:false, //主导航器也就是本例中显示的小方块
			navCenter:true, //主导航器位置是否居中
			navClass:"slider-nav",//主导航器外部div类名
			navItemClass:"slider-nav__item", //本例中小方块的样式
			navCurrentItemClass:"slider-nav__item--current" //被选中后的样式
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
	
	//返回
	$('.user_head .ico_prev').not('.nojs').click(function(){
		
		history.back();
	})
})

$(function(){
    $('#signIn').on("click", function () {
        var pics = [];
        $('input[name="pics"]').each(function(){
		var obj = $(this);
                pics.push(obj.val());

	})
        $.post("personal_ajax.php", {"act":"sign","signTime":$("#signInTime").html(),"signAddr":$("#signInAddr").html(),"signDesc":$("#signDesc").val(),"jobInfoId":$("#job_info_id").val(),"jobId":$("#job_id").val(),"type":$(this).attr('data-type'),"enrollId":$("#enroll_id").val(), "pics":pics},
		function (data,textStatus)
		 {
                     alert(data);
                     //location.reload();
		 }
	);
	});
        $('#signOut').on("click", function () {
        var pics = [];
        $('input[name="pics"]').each(function(){
		var obj = $(this);
                pics.push(obj.val());

	})
        $.post("personal_ajax.php", {"act":"sign","signTime":$("#signOutTime").html(),"signAddr":$("#signOutAddr").html(),"signDesc":$("#signOutDesc").val(),"jobInfoId":$("#job_info_id").val(),"jobId":$("#job_id").val(),"type":$(this).attr('data-type'),"enrollId":$("#enroll_id").val(), "pics":pics},
		function (data,textStatus)
		 {
                     alert(data);
                     location.reload();
		 }
	);
	});
        $('#signPic').on("change", function () {
            window.URL = window.URL || window.webkitURL;
                var fileList = $(".imglist");
		var files = this.files,
                img = new Image();
		if(window.URL){
			//File API
			  alert(files[0].name + "," + files[0].size + " bytes");
		      img.src = window.URL.createObjectURL(files[0]); //创建一个object URL，并不是你的本地路径
		      img.width = 200;
		      img.onload = function(e) {
		         window.URL.revokeObjectURL(this.src); //图片加载后，释放object URL
		      }
                      alert(img.src);
		      fileList.appendChild(img);
		}else if(window.FileReader){
			//opera不支持createObjectURL/revokeObjectURL方法。我们用FileReader对象来处理
			var reader = new FileReader();
			reader.readAsDataURL(files[0]);
			reader.onload = function(e){
				alert(files[0].name + "," +e.total + " bytes");
				img.src = this.result;
				img.width = 200;
				fileList.appendChild(img);
			}
		}else{
			//ie
			obj.select();
			obj.blur();
			var nfile = document.selection.createRange().text;
			document.selection.empty();
			img.src = nfile;
			img.width = 200;
			img.onload=function(){
		      alert(nfile+","+img.fileSize + " bytes");
		    }
			fileList.appendChild(img);
		}
        });
	//组长管理页
		$('.ui-select select').change(function(){
			var obj = $(this);
			//alert($(this).val());
			obj.parent().find('span').html($(this).find('option:selected').text());			
		})

	//动态显示时间

		window.setInterval(function () {
			var _now = new Date();
			$(".ui-current-time-show").html(_now.getHours() + ":" + _now.getMinutes() +":" + _now.getSeconds());
		},1000);
	//显示当前地址
	showLocalAddress($(".ui-current-address"));

	//签到管理页滚动的select
	$(".scroll-select").find(".prev").on("click",function (event) {
		var _select = $(this).closest(".scroll-select").find(".ui-show-select");
		var index = _select.prop('selectedIndex');
		if(index>0)
		_select.find("option").eq(index-1).attr("selected",true);
	});

	$(".scroll-select").find(".next").on("click",function (event) {
		var _select = $(this).closest(".scroll-select").find(".ui-show-select");
		var index = _select.prop('selectedIndex');
		if(index<_select.find("option").length)
		_select.find("option").eq(index+1).attr("selected",true);
	});
})
//打开弹窗
function openDiv(id){
	$('#'+ id).show();
	showCurrent($(".ui-current-time-static"));
	showLocalAddress($(".ui-current-address"));
	return false;
}
//关闭弹窗
function closeDiv(id){
	$('#'+ id).hide();
	return false;
}

//当前时间
function showCurrent(ele) {
	var _now = new Date();
	ele.html(_now.getHours() + ":" + _now.getMinutes() +":" + _now.getSeconds());
}


function reenroll(jobid, jobinfo_id, cid) {
    $.post("personal_ajax.php", {"act":"re_enroll","jobid":jobid, "jobinfo_id":jobinfo_id, "cid":cid},
        function (textStatus)
         {
            alert('续约成功');
            location.reload();
         }
    );
}

function showLocalAddress(ele) {
	$.ajax({
		url: "http://api.map.baidu.com/highacciploc/v1?qterm=pc&ak=1wvtkXp4ETKwIy3Byu2Ou3cOYBGuqdYL&coord=bd09ll&callback_type=jsonp",
		dataType: 'jsonp',
		success:function (data) {
			if(data){
				var lat = data.content.location.lat,
					lng = data.content.location.lng;
				$.ajax({
					url: "http://api.map.baidu.com/geocoder/v2/?ak=1wvtkXp4ETKwIy3Byu2Ou3cOYBGuqdYL&&location="+ lat + "," + lng +",&output=json&pois=1",
					dataType: 'jsonp',
					success:function (data) {
						ele.text(data.result.formatted_address);
					}
				});
			}
		}
	});
}

function uploadImg(file) {
	if(!file.files || !file.files[0])
		return;
	if($(".ui-upload-img").children(".img").length >= 4){
		alert("最多可传四张！");
		return;
	}
	var reader = new FileReader();
	reader.onload = function(evt){
            if(evt.target.result.match(/image/)){
                 $.post("personal_ajax.php", {"act":"uplode_img","img":evt.target.result},
                    function(ret){  
                         if(ret!=''){  
                             var file_ele = $('<dd class="img">'
                            +'<img src="'+ret+'"/>'
                            +'<i class="remove"></i>'
                            +'<input type="hidden" value="'+ret + '" name=pics />'
                            + '</dd>');
                            $(".ui-upload-img").children(".file").before(file_ele);
                            file_ele.find(".remove").on("click",function () {
                                    $(this).parent().fadeOut(function(){
                                            $(this).remove();
                                    });
                            });
                             $('#showimg').html('<img src="' + ret + '">');  
                         }else{
                             alert('upload fail');  
                         }  
                     }); 
                    
            }
            else
                alert("请上传正确格式的图片！")
	}
	reader.readAsDataURL(file.files[0]);
}


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
