 /*
 * 74cms 编辑简历
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
$(function(){
    editCv.initMb();
    if(window.location.href.indexOf("page=changePhone")!=-1){
        var formParam = storage.get("formParam");
        var formParamJson = eval("(" + formParam + ")");
        for(var key in formParamJson){
            if(key=="brithdayTxt" || key=="startDateTxt" || key=="endDateTxt"|| key=="beginworkTxt"){
                $("#"+key).text(formParamJson[key]);
            }else{
                $("#"+key).val(formParamJson[key]);
                if(key=="sex_dummy"){
                    $("#"+key).siblings(".sex[data-val='"+formParamJson[key]+"']").trigger("click");
                }else if(key=="marry_dummy"){
                    $("#"+key).siblings(".marry[data-val='"+formParamJson[key]+"']").trigger("click");
                }else if(key=="abroad_dummy"){
                    $("#"+key).siblings(".abroad[data-val='"+formParamJson[key]+"']").trigger("click");
                }
            }
        }
        storage.del("formParam");
        storage.del("prevUrl");
    }
    if(window.location.href.indexOf("page=changeEmail")!=-1){
        var formEmail = storage.get("formEmail");
        var formEmailJson = eval("(" + formEmail + ")");
        for(var key in formEmailJson){
            if(key=="brithdayTxt" || key=="startDateTxt" || key=="endDateTxt"|| key=="beginworkTxt"){
                $("#"+key).text(formEmailJson[key]);
            }else{
                $("#"+key).val(formEmailJson[key]);
                if(key=="sex_dummy"){
                    $("#"+key).siblings(".sex[data-val='"+formEmailJson[key]+"']").trigger("click");
                }else if(key=="marry_dummy"){
                    $("#"+key).siblings(".marry[data-val='"+formEmailJson[key]+"']").trigger("click");
                }else if(key=="abroad_dummy"){
                    $("#"+key).siblings(".abroad[data-val='"+formEmailJson[key]+"']").trigger("click");
                }
            }
        }
        storage.del("formEmail");
        storage.del("prevUrl");
    }
})
var editCv = {
	initMb : function(){
        var curr = new Date().getFullYear(),
            cumm = new Date().getMonth(),
            that = this,
            opt = {
            'swdate': {
                theme: 'mct light',
                preset: 'date',
                dateOrder: 'yym月',
                display: 'bottom',
                headerText: false,
                startYear: curr - 50,
                endYear: curr,
                dateFormat: 'yy.m',
            },
            'ewdate': {
                theme: 'mct light',
                preset: 'date',
                dateOrder: 'yym月',
                display: 'bottom',
                headerText: false,
                startYear: curr - 50,
                endYear: curr,
                dateFormat: 'yy.m',
            },
            'birth': {
                theme: 'mct light',
                preset: 'date',
                dateOrder: 'yym月',
                display: 'bottom',
                headerText: false,
                defaultValue: new Date(new Date().setFullYear(curr-23)),
                maxDate: new Date(),
                minDate: new Date(new Date().setFullYear(1945)),
                dateFormat: 'yy.m',
            },
            'year': {
                theme: 'mct light',
                preset: 'date',
                dateOrder: 'yym月',
                display: 'bottom',
                startYear: curr - 50,
                endYear: curr,
                buttons: false,
                dateFormat: 'yy.m',
            },
            'yearStart': {
                theme: 'mct light',
                preset: 'date',
                dateOrder: 'yym月',
                display: 'bottom',
                defaultValue: new Date(new Date().setFullYear(curr-2)),
                maxDate: new Date(),
                minDate: new Date(new Date().setFullYear(curr - 60)),
                buttons: false,
                dateFormat: 'yy.m',
            },
            'yearEnd': {
                theme: 'mct light',
                preset: 'date',
                dateOrder: 'yym月',
                display: 'bottom',
                defaultValue: new Date(new Date().setFullYear(curr)),
                maxDate: new Date(),
                minDate: new Date(new Date().setFullYear(curr - 60)),
                buttons: false,
                dateFormat: 'yy.m',
            },
            'select': {
                theme: 'mct light',
                preset: 'select',
                rows: 7,
                inputClass: 'hide',
                display: 'bottom',
            }
        }
        $(".mbs").each(function(e,i){
            var type = $(this).data("type");
            var head = ($(this).data("text"))? $(this).data("text"):"";
            var thisid = ($(this).attr("id"))? $(this).attr("id"):"";
            switch(type){
                case "select":
                    $(this).scroller('destroy').scroller($.extend(opt['select'], {
                        buttons: false,
                        headerText: "选择学历",
                        onValueTap: function (item, inst) {
                            var text = item.find('.dw-i').text();
                            if(text){
                                $('#degreeTxt').text(text)
                                var majorDom = $("input[name$='major']");
                                if(text == "高中" ||text == "初中"){
                                    majorDom.attr("readonly","readonly").val("");
                                    majorDom.addClass("empty")
                                    majorDom.hide();
                                    majorDom.parent().prev().css("color",'#cfcfcf');
                                }else{
                                    majorDom.removeAttr("readonly").show()
                                    majorDom.removeClass("empty")
                                    majorDom.show();
                                    majorDom.parent().prev().removeAttr('style');
                                }
                                $('#degree').mobiscroll('select')
                            }
                        },
                        onSelect:function(v,i){
                            setTimeout(function(){
                                
                            },300)
                        }
                    }))
                    break;
                case "year":
                    that.formatDate($(this).next().val(),$(this))
                    if(head){
                        var self = $(this);
                        if(thisid == "beginworkTxt"){
                            $(this).scroller('destroy').scroller($.extend(opt['year'], {
                                headerText: head,
                                buttons: ["cancel","set",{text:"至今",handler:function(e,i){
                                    $('#beginworkTxt').text("至今");
                                    $('#beginwork_dummy').val(0);
                                    self.mobiscroll('cancel')
                                }}],
                                onSelect: function (v, i) {
                                    $('#beginworkTxt').text(i.values[0]+"年"+(parseInt(i.values[1])+1)+"月");
                                    $('#beginworkTxt').next().val(v);
                                }
                            }))
                        }else if(thisid == "graduateTxt"){
                            $(this).scroller('destroy').scroller($.extend(opt['yearEnd'], {
                                headerText: head,
                                onSelect: function (v, inst) {
                                    $('#graduate_dummy').val(inst.values[0]);
                                },
                                onValueTap: function (item, inst) {
                                    var text = item.find('.dw-i').text();
                                    if(text){
                                        $('#graduateTxt').text(text);
                                        $('#graduateTxt').mobiscroll('select');
                                    }
                                }
                            }))
                        }
                    }else{

                    }
                    break;
                case "yearStart":
                    var sTxt = $(this);
                    that.formatDate($(this).next().val(),$(this))
                    sTxt.scroller('destroy').scroller($.extend(opt['yearStart'], {
                        headerText: head,
                        buttons: ["cancel","set"],
                        onSelect: function (v, i) {
                            sTxt.next().val(v);
                            sTxt.text(i.values[0]+"年"+(parseInt(i.values[1])+1)+"月");
                        }
                    }))
                    break;
                case "yearEnd":
                    var eTxt = $(this);
                    that.formatDate($(this).next().val(),$(this))
                    eTxt.scroller('destroy').scroller($.extend(opt['yearEnd'], {
                        headerText: head,
                        buttons: ["cancel","set",{text:"至今",handler:function(e,i){
                            eTxt.next().val(-1);
                            eTxt.text("至今");
                            
                            eTxt.scroller("cancel")
                        }}],
                        onSelect: function (v, i) {
                            eTxt.next().val(v);
                            eTxt.text(i.values[0]+"年"+(parseInt(i.values[1])+1)+"月");
                            
                        }
                    }))
                    break;
                case "date":
                    that.formatDate($(this).next().val(),$(this))
                    if(head){
                        var thisdom = $(this);
                        $(this).scroller('destroy').scroller($.extend(opt['ewdate'], {
                            buttons: ["cancel","set",{text:"至今",handler:function(e,i){
                                $('#endWork_dummy').val(-1);
                                $('#endWorkTxt').text("至今");
                                thisdom.scroller("cancel")
                            }}],
                            onSelect: function (v, i) {
                                $('#endWork_dummy').val(i.val);
                                $('#endWorkTxt').text(i.values[0]+"年"+(parseInt(i.values[1])+1)+"月");
                            }
                        }))
                    }else{
                        $(this).scroller('destroy').scroller($.extend(opt['swdate'], {
                            buttons: ["cancel","set"],
                            onSelect: function (v, i) {
                                $('#startWork_dummy').val(i.val);
                                $('#startWorkTxt').text(i.values[0]+"年"+(parseInt(i.values[1])+1)+"月");
                            }
                        }))
                    }
                    break;
                case "birthday" :
                    that.formatDate($(this).next().val(),$(this))
                    $(this).scroller('destroy').scroller($.extend(opt['birth'], {
                        headerText: head,
                        buttons: ["cancel","set"],
                        onSelect: function (v, i) {
                            $('#birthdate').val(i.val);
                            $('#brithdayTxt').text(i.values[0]+"年"+(parseInt(i.values[1])+1)+"月");
                        }
                    }))
                    break;
                default:
                    break;
            }
        })
    },
    formatDate:function(date,$this){
        var dArr = date.split("."),
            str = "";
        if(!dArr[0]) return false;
        dArr[0] += "";
        switch(dArr[0]){
            case "0":
                str += "至今"
                break;
            case "-1":
                str += "至今"
                break;
            default:
                str += dArr[0]+"年";
                if(dArr[1]) str += dArr[1]+"月";
                break;
        }
        if($this && $this.length){
            $this.text(str)
        }
        return str;
    }
}
$(document).ready(function() {
	/* 点击div跳转 */
	$('.thisurl').click( function () {window.location.href =  $(this).attr('url');});

	/* 定义大背景 */
 	var lockWin = {
		on: function(a) {
			switch (a) {
				case 1:
					if ($(".hide_win").length < 1) {
						$("body").append('<div class="hide_win"></div>')
					}
					$(".hide_win").show();
					break;
				default:
					if ($(".lock_win").length < 1) {
						$("body").append('<div class="lock_win"></div>')
					}
					$(".lock_win").show();
					break
			}
		},
		off: function(a) {
			switch (a) {
				case 1:
					$(".hide_win").hide();
					break;
				default:
					$(".lock_win").hide();
					break
			}
		}
	};

	
	/* 点击修改简历名称 */
	$("#resumenameEdit").on('click', function(event) {
		layer.open({
			title: [
		        '修改简历名称',
		        'color:#333333;'
		    ],
		    content: '<span class="input input--minoru"><input class="input__field input__field--minoru" type="text" id="modfiyResumenameInputbox" placeholder="'+$("#resumenameEdit").text()+'" /><label class="input__label input__label--minoru" for="modfiyResumebameInputbox"></label></span>',
		    btn: ['确认', '取消'],
		    shadeClose: false,
		    yes: function(){ 
		    	var modifyresvalue = $("#modfiyResumenameInputbox").val();
				var resume_id = $("#resume_id").val();
		        $.post('?act=resume_name_save', {"resume_id": resume_id,"title":modifyresvalue}, function(data) {
		        	layer.open({
					    content: '正在提交数据！',
					    style: 'background-color:#FFFFFF; color:#666666; border:none;'
					});
		        	if (data == "ok") {
		        		$("#resumenameEdit .txt").text(modifyresvalue);
		        		layer.open({
						    content: '修改成功！',
						    style: 'background-color:#FFFFFF; color:#666666; border:none;',
						    time: 1
						});
                        $("#resumenameEdit").css("background-position-x",($("#resumenameEdit").text().length*16+10)+"px");
		        	} else if(data == "err") {
						layer.open({
						    content: '修改失败！',
						    style: 'background-color:#FFFFFF; color:#666666; border:none;',
						    time: 1
						});
						window.location.reload();
					} else {
						layer.open({
						    content: data,
						    style: 'background-color:#FFFFFF; color:#666666; border:none;',
						    time: 1
						});
						window.location.reload();
					}
		        });
		    }, no: function(){
		        layer.closeAll();
		    }
		});
	});

    /* 隐私设置 */
    $(".setPrivacy").on('click', function(event) {
        var QS_privacy = new Array("1,公开","2,保密","3,关闭"),
            pid = $(this).data("pid");
        layer.open({
            title: '请选择简历公开程度',
            content: getOptionsContent(QS_privacy, ''),
            btn: ['确认', '取消'],
            shadeClose: true,
            yes: function(){
                yesPrivacyOptionsClick(pid);
            }, no: function(){
                layer.closeAll();
            },
            success: function(elem){
                privacyOptionsClick();
            }   
        });
    });

 	/* 最高学历 */
 	$("#educationTxt").on('click', function(event) {
 		layer.open({
            title: '请选择最高学历',
 			content: getOptionsContent(QS_education, ''),
		    btn: ['取消'],
		    shadeClose: true,
		    yes: function(){
				layer.closeAll();
		    }, no: function(){
		        layer.closeAll();
		    },
		    success: function(elem){
			    optionsClick("#education", "#education_cn", "#educationTxt");
			}   
		});
 	});

 	/* 工作经验 */
 	$("#experienceTxt").on('click', function(event) {
 		layer.open({
            title: '请选择工作经验',
 			content: getOptionsContent(QS_experience, ''),
		    btn: ['取消'],
		    shadeClose: true,
		    yes: function(){
				layer.closeAll();
		    }, no: function(){
		        layer.closeAll();
		    },
		    success: function(elem){
			    optionsClick("#experience", "#experience_cn", "#experienceTxt");
			}   
		});
 	});

 	/* 目前状态 */
 	$("#currentTxt").on('click', function(event) {
 		layer.open({
            title: '请选择目前状态',
 			content: getOptionsContent(QS_current, ''),
		    btn: ['取消'],
		    shadeClose: true,
		    yes: function(){
				layer.closeAll();
		    }, no: function(){
		        layer.closeAll();
		    },
		    success: function(elem){
			    optionsClick("#current", "#current_cn", "#currentTxt");
			}   
		});
 	});

 	/* 工作性质 */
 	$("#natureTxt").on('click', function(event) {
 		layer.open({
            title: '请选择工作性质',
 			content: getOptionsContent(QS_jobsnature, ''),
		    btn: ['确认', '取消'],
		    shadeClose: true,
		    yes: function(){
				layer.closeAll();
		    }, no: function(){
		        layer.closeAll();
		    },
		    success: function(elem){
			    optionsClick("#nature", "#nature_cn", "#natureTxt");
			}   
		});
 	});

 	/* 期望薪资 */
 	$("#wageTxt").on('click', function(event) {
 		layer.open({
            title: '请选择期望薪资',
 			content: getOptionsContent(QS_wage, ''),
		    btn: ['取消'],
		    shadeClose: true,
		    yes: function(){
				layer.closeAll();
		    }, no: function(){
		        layer.closeAll();
		    },
		    success: function(elem){
			    optionsClick("#wage", "#wage_cn", "#wageTxt");
			}   
		});
 	});

 	/* 期望行业 */
 	$("#tradeTxt").on('click', function(event) {
 		layer.open({
 			title: [
		        '请选择期望行业'
		    ],
 			content: getOptionsContent(QS_trade, ''),
		    btn: ['取消'],
		    shadeClose: true,
		    yes: function(){
				layer.closeAll();
		    }, no: function(){
		        layer.closeAll();
		    },
		    success: function(elem){
			    optionsClick("#trade", "#trade_cn", "#tradeTxt");
			}   
		});
 	});

 	/* 婚姻状况 */
 	$("#marriageTxt").on('click', function(event) {
 		layer.open({
            title: '请选择婚姻状况',
		    content: '<div class="formDiv formDivlayer"><div class="formChild option" data-val="2" data-content="已婚"><div class="lt">已婚</div></div><div class="formChild option" data-val="1" data-content="未婚"><div class="lt">未婚</div></div></div>',
		    btn: ['确认', '取消'],
		    shadeClose: true,
		    yes: function(){
				layer.closeAll();
		    }, no: function(){
		        layer.closeAll();
		    },
		    success: function(elem){
			    optionsClick("#marriage", "#marriage_cn", "#marriageTxt");
			}   
		});
 	});
 	
    /* 工作职责 */
    var subTemp = '<div class="cline"></div><div class="formDiv">'+
                        '<textarea id="subTxtArea" rows="10" placeholder="请编辑"></textarea>'+
                    '</div>'+
                    '<div class="btn_bar">'+
                        '<div id="saveSub" class="blue_btn">保存</div>'+
                    '</div>';
    $("#achievementTxt").click(function(){
        var $this = $(this),
            baseTxt = $this.text();
        popWin.init({
            title:"编辑工作职责",
            from:"right",
            html:subTemp,
            handle:function(){
                $("#subTxtArea").val(baseTxt);
                $("#saveSub").click(function(){
                    $this.text($("#subTxtArea").val());
                    $this.next().val($("#subTxtArea").val());
                    popWin.close("right");
                })
            }
        })
    })

    /* 培训内容 */
    $("#descriptionTxt").click(function(){
        var $this = $(this),
            baseTxt = $this.text();
        popWin.init({
            title:"编辑培训内容",
            from:"right",
            html:subTemp,
            handle:function(){
                $("#subTxtArea").val(baseTxt);
                $("#saveSub").click(function(){
                    $this.text($("#subTxtArea").val());
                    $this.next().val($("#subTxtArea").val());
                    popWin.close("right");
                })
            }
        })
    })

 	var m_selector = {
	jobsArr: "",
	jobs: function(a, i, d) {
		var h = $("#" + a);
		var e = "",
			f = this;
		if (!h) {
			clog("nodiv");
			return
		}
		e += '<div id="loc_level1_' + a + '" class="sl_level1"><div><ul>';
		$.each(QS_jobs_parent, function(indexParent, valParent) {
			var i = valParent.split(",")[0],
				cArrParent = QS_jobs[i].split("|");
			$.each(cArrParent, function(index, val) {
				var cArr = val.split(",");
				e += '<li data-key="' + cArr[1] + '" data-val="' + i + ',' + cArr[0] + '">' + cArr[1] + "</li>";
			});
		});
		e += '		</ul></div></div><div id="loc_level2_' + a + '" class="sl_level2"><div><ul>';
		e += "		</ul></div></div>";
		this.set(h, e);
		/* 恢复选中 */
		if (!$("#intention_jobs_id").val()) {
			var restoreId = $("#category").val(),
                topId = $("#topclass").val(),
                restoreArr = $("#loc_level1_" + a + " li"),
                firstKey = '';
            $.each(restoreArr, function(index, val) {
                if ($(this).data("val").split(",")[1] == restoreId) {
                    $(this).addClass('on');
                    firstKey = $(this).data("key");
                };
            });
            var gArr = QS_jobs[restoreId].split("|"),
                g = this.getFistJob(gArr, topId, restoreId, firstKey);
			$("#loc_level2_" + a + " ul").empty().html(g);
		} else {
			$("#loc_level1_" + a + " li").first().addClass("on");
            var gidp = $("#loc_level1_" + a + " li").first().data("val").split(",")[0],
                gid = $("#loc_level1_" + a + " li").first().data("val").split(",")[1];
            if (QS_jobs[gid]) {
                var gArr = QS_jobs[gid].split("|"),
                    firstKey = $("#loc_level1_" + a + " li").first().data("key"),
                    g = this.getFistJob(gArr, gidp, gid, firstKey);
            } else {
                var gArr = new Array(),
                    firstKey = $("#loc_level1_" + a + " li").first().data("key"),
                    g = this.getFistJob(gArr, gidp, gid, firstKey);
            };
            $("#loc_level2_" + a + " ul").empty().html(g);
		};
		if (document.documentElement.scrollTop + document.body.scrollTop > 108) {
			$(".sl_level1,.sl_level2").css("height", window.innerHeight - 45 - 108)
		} else {
			$(".sl_level1,.sl_level2").css("height", window.innerHeight - h.offset().top)
		}
		if (!i) {
			$("#loc_level2_" + a).delegate("li:not(.fail)", "click", function() {
				storage.setJson("search", "soCity", $(this).data("val"));
				if ($(this).hasClass("locCity")) {
					storage.setJson("search", "soCity_cn", $(this).data("txt"))
				} else {
					storage.setJson("search", "soCity_cn", $(this).text())
				}
			});
		}
		$("#loc_level1_" + a + " li").on("click", function() {
			$(this).parent().find("li").removeClass("on");
            $(this).addClass("on");
            var mp = $(this).data("val").split(",")[0],
                m = $(this).data("val").split(",")[1],
                n = '<li data-val="' + mp + ',' + m + ',0" data-txt="' + $(this).data("key") + '">不限</li>';
            if (QS_jobs[m]) {
                var mArr = QS_jobs[m].split("|");
                $.each(mArr, function(indexlevel2, vallevel2) {
                    var mArrLeval2 = vallevel2.split(",");
                    n += '<li data-val="' + mp + "," + m + "," + mArrLeval2[0] + '" data-txt="' + mArrLeval2[1] + '">' + mArrLeval2[1] + '</li>';
                });
            };
            $("#loc_level2_" + a + " ul").empty().html(n);
            j.refresh();
		});
		var b = new iScroll("loc_level1_" + a);
		var j = new iScroll("loc_level2_" + a);
		return b
	},
	nearCityCatch: "",
	loadingNear: false,
	soCity: function(a, i, d) {
		var h = $("#" + a);
		var e = "",
			f = this;
		if (!h) {
			clog("nodiv");
			return
		}
		e += '<div id="loc_level1_' + a + '" class="sl_level1"><div><ul>';
		$.each(QS_city_parent, function(index, val) {
			 var cArr = val.split(",");
			e += '<li data-key="' + cArr[1] + '" data-val="' + cArr[0] + '">' + cArr[1] + "</li>"
		});
		e += '		</ul></div></div><div id="loc_level2_' + a + '" class="sl_level2"><div><ul>';
		e += "		</ul></div></div>";
		this.set(h, e);
		/* 恢复选中 */
		if ($("#district").val()) {
			var restoreId = $("#district").val();
            var restoreArr = $("#loc_level1_" + a + " li");
            $.each(restoreArr, function(index, val) {
                if ($(this).data("val") == restoreId) {
                    $(this).addClass('on');
                };
            });
            if (QS_city[restoreId]) {
                var gArr = QS_city[restoreId].split("|"),
                    firstKey = $("#district_cn").val(),
                g = this.getFistCity(gArr, restoreId, firstKey);
            } else {
                var gArr = new Array(),
                    firstKey = $("#loc_level1_" + a + " li").first().data("key"),
                g = this.getFistCity(gArr, restoreId, firstKey);
            };
            $("#loc_level2_" + a + " ul").empty().html(g);
		} else {
			$("#loc_level1_" + a + " li").first().addClass("on");
            var gid = $("#loc_level1_" + a + " li").first().data("val");
            if (QS_city[gid]) {
                var gArr = QS_city[gid].split("|"),
                    firstKey = $("#loc_level1_" + a + " li").first().data("key"),
                g = this.getFistCity(gArr, gid, firstKey);
            } else {
                var gArr = new Array(),
                    firstKey = $("#loc_level1_" + a + " li").first().data("key"),
                g = this.getFistCity(gArr, gid, firstKey);
            };
            $("#loc_level2_" + a + " ul").empty().html(g);
		};
		if (document.documentElement.scrollTop + document.body.scrollTop > 108) {
			$(".sl_level1,.sl_level2").css("height", window.innerHeight - 45 - 108)
		} else {
			$(".sl_level1,.sl_level2").css("height", window.innerHeight - h.offset().top)
		}
		if (!i) {
			$("#loc_level2_" + a).delegate("li:not(.fail)", "click", function() {
				storage.setJson("search", "soCity", $(this).data("val"));
				if ($(this).hasClass("locCity")) {
					storage.setJson("search", "soCity_cn", $(this).data("txt"))
				} else {
					storage.setJson("search", "soCity_cn", $(this).text())
				}
			});
		}
		$("#loc_level1_" + a + " li").on("click", function() {
			$(this).parent().find("li").removeClass("on");
            $(this).addClass("on");
            var m = $(this).data("val"),
                n = '<li data-val="' + m + ',0" data-txt="' + $(this).data("key") + '">不限</li>';
            if (QS_city[m]) {
                var mArr = QS_city[m].split("|");
                $.each(mArr, function(indexlevel2, vallevel2) {
                    var mArrLeval2 = vallevel2.split(",");
                    n += '<li data-val="' + m + "," + mArrLeval2[0] + '" data-txt="' + mArrLeval2[1] + '">' + mArrLeval2[1] + "</li>";
                });
            };
            $("#loc_level2_" + a + " ul").empty().html(n);
            j.refresh();
		});
		var b = new iScroll("loc_level1_" + a);
		var j = new iScroll("loc_level2_" + a);
		return b
	},
    majors: function(a, i, d) {
        var h = $("#" + a);
        var e = "",
            f = this;
        if (!h) {
            clog("nodiv");
            return
        }
        e += '<div id="loc_level1_' + a + '" class="sl_level1"><div><ul>';
        $.each(QS_major_parent, function(index, val) {
             var cArr = val.split(",");
            e += '<li data-key="' + cArr[1] + '" data-val="' + cArr[0] + '">' + cArr[1] + "</li>"
        });
        e += '      </ul></div></div><div id="loc_level2_' + a + '" class="sl_level2"><div><ul>';
        e += "      </ul></div></div>";
        this.set(h, e);
        /* 恢复选中 */
        if ($("#major_cn").val().length > 0) {
            var restoreArr = $("#loc_level1_" + a + " li"),
                restoreId = this.getMajorRestoreId(a),
                firstKey = '';
            $.each(restoreArr, function(index, val) {
                if ($(this).data("val") == restoreId) {
                    $(this).addClass('on');
                    firstKey = $(this).data("key");
                };
            });
            var gArr = QS_major[restoreId].split("|"),
                g = this.getFistCity(gArr, restoreId, firstKey);
            $("#loc_level2_" + a + " ul").empty().html(g);
        } else {
            $("#loc_level1_" + a + " li").first().addClass("on");
            var gid = this.getMajorRestoreId(a),
                gArr = QS_major[gid].split("|"),
                firstKey = $("#loc_level1_" + a + " li").first().data("key"),
                g = this.getFistCity(gArr, gid, firstKey);
            $("#loc_level2_" + a + " ul").empty().html(g);
        };
        if (document.documentElement.scrollTop + document.body.scrollTop > 108) {
            $(".sl_level1,.sl_level2").css("height", window.innerHeight - 45 - 108)
        } else {
            $(".sl_level1,.sl_level2").css("height", window.innerHeight - h.offset().top)
        }
        if (!i) {
            $("#loc_level2_" + a).delegate("li:not(.fail)", "click", function() {
                storage.setJson("search", "soCity", $(this).data("val"));
                if ($(this).hasClass("locCity")) {
                    storage.setJson("search", "soCity_cn", $(this).data("txt"))
                } else {
                    storage.setJson("search", "soCity_cn", $(this).text())
                }
            });
        }
        $("#loc_level1_" + a + " li").on("click", function() {
            $(this).parent().find("li").removeClass("on");
            $(this).addClass("on");
            var m = $(this).data("val"),
                n = '<li data-val="' + m + ',0" data-txt="' + $(this).data("key") + '">不限</li>',
                mArr = QS_major[m].split("|");
            $.each(mArr, function(indexlevel2, vallevel2) {
                var mArrLeval2 = vallevel2.split(",");
                n += '<li data-val="' + m + "," + mArrLeval2[0] + '" data-txt="' + mArrLeval2[1] + '">' + mArrLeval2[1] + "</li>";
            });
            $("#loc_level2_" + a + " ul").empty().html(n);
            j.refresh();
        });
        var b = new iScroll("loc_level1_" + a);
        var j = new iScroll("loc_level2_" + a);
        return b
    },
	getFistCity: function(arr, pid, firstKey) {
        var b = '<li data-val="' + pid + ',0" data-txt="' + firstKey + '">不限</li>';
        $.each(arr, function(index, val) {
            var sArr = val.split(",");
            b += '<li data-val="' + pid + "," + sArr[0] + '" data-txt="' + sArr[1] + '">' + sArr[1] + "</li>";
        });
        return b;
    },
	getFistJob: function(arr, pid, sid, firstKey) {
		var b = '<li data-val="' + pid + ',' + sid + ',0" data-txt="' + firstKey + '">不限</li>';
        $.each(arr, function(index, val) {
            var sArr = val.split(",");
            b += '<li data-val="' + pid + "," + sid + "," + sArr[0] + '" data-txt="' + sArr[1] + '">' + sArr[1] + "</li>";
        });
        return b;
	},
    getMajorRestoreId: function(a) {
        var restoreCn = $("#major_cn").val(),
            restoreArr = $("#loc_level1_" + a + " li"),
            restoreId = '';
        if ($("#major_cn").val().length > 0) {
            $.each(QS_major_parent, function(index, val) {
                var confirmLevel1Arr = QS_major[index+1].split("|");
                $.each(confirmLevel1Arr, function(indexLenvl1, valLenvl1) {
                    var confirmLevel1Cn = valLenvl1.split(",")[1];
                    if (restoreCn === confirmLevel1Cn) {
                        restoreId = index + 1;
                    };
                });
            });
        } else {
            restoreId = 1;
        }
        return restoreId;
    },
	set: function(b, a, c) {
		if (b.find(".sl_list>div").length) {
			b.find(".sl_list>div").empty().html(a)
		} else {
			if (b.find(".sl-main>div").length) {
				b.find(".sl-main>div").empty().html(a)
			} else {
				b.empty().html(a);
			}
		}
		if (c) {
			$("#more_level").css("height", window.innerHeight - 50)
		} else {
			if (document.documentElement.scrollTop + document.body.scrollTop > 108) {
				b.css("height", window.innerHeight - 45 - 108)
			} else {
				b.css("height", window.innerHeight - b.offset().top)
			}
		}
	}
};
 	/* 期望地区 */
 	$("#cityTxt").on("click",function(){
 		var elem = $(".select_bar_div"),
            that = this;
        elem.show().css("height",300)
        lockWin.on();
        if($("#loc_level1_cityList").length){
            elem.show().addClass("on");
        }else{
            elem.empty();
            elem.append('<div class="select_bar_head">城市</div><div id="cityList" class="sl_list"><div><ul></ul></div></div>');
            elem.addClass("on");
            var select_city = m_selector.soCity($(this).data("go")+"List",true,true)
            setTimeout(function(){
                $(".sl_level1,.sl_level2").css("height",255)
                select_city.refresh();
            },500)
        }
        elem.find(".sl_level2").off("click.checkcity").delegate("li:not(.fail)","click.checkcity",function(){
            if($(this).hasClass('locCity')){
                $("#cityTxt").text($(this).data("txt"));
            }else{
                $("#cityTxt").text($(this).data("txt"));
            }
            var thisValArr = $(this).data("val").split(",");
            $("#district").val(thisValArr[0]);
            $("#sdistrict").val(thisValArr[1]);
            $("#district_cn").val($(this).data("txt"));
            hideBar(elem);
        })
        $(".lock_win").on("click",function(){
            hideBar(elem);
        })
    });

 	/* 期望职位 */
 	$("#jobTxt").on("click",function(){
 		var elem = $(".select_bar_div"),
            that = this;
        elem.show().css("height",300)
        lockWin.on();
        if($("#loc_level1_jobList").length){
            elem.show().addClass("on");
        }else{
            elem.empty();
            elem.append('<div class="select_bar_head">职位</div><div id="jobList" class="sl_list"><div><ul></ul></div></div>');
            elem.addClass("on");
            var select_city = m_selector.jobs($(this).data("go")+"List",true,true)
            setTimeout(function(){
                $(".sl_level1,.sl_level2").css("height",255)
                select_city.refresh();
            },500)
        }
        elem.find(".sl_level2").off("click.checkcity").delegate("li:not(.fail)","click.checkcity",function(){
            if($(this).hasClass('locCity')){
                $("#jobTxt").text($(this).data("txt"));
            }else{
                $("#jobTxt").text($(this).data("txt"));
            }
            $("#intention_jobs_id").val($(this).data("val"));
            $("#intention_jobs").val($(this).data("txt"));
            hideBar(elem);
        })
        $(".lock_win").on("click",function(){
            hideBar(elem);
        })
    });

    /* 简历列表更多按钮 */
    $(".setMore").on("click",function(){
        var elem = $(".select_bar_div"),
            that = this,
            pid = $(this).data("pid");
        elem.show();
        lockWin.on();
        if($("#loc_level1_cityList").length){
            elem.show().addClass("on");
        }else{
            elem.empty();
            elem.append('<div class="select_bar_head updateresume center">升级简历</div><div class="select_bar_head delresume center"><span class="del">删除</span></div><div class="select_bar_head cancle center">取消</div>');
            elem.addClass("on");
        }
        $(".lock_win,.cancle").on("click",function(){
            hideBar(elem);
        });
        /* 升级简历 */
        $(".updateresume").on('click', function(event) {
            layer.confirm('确定要升级该简历吗？', {
                btn: ['确认'], //按钮
                title: '升级简历'
            }, function(){
                $.get("?act=resume_talent&pid="+pid+"", function(data){
                    if(data=="ok"){
                        layer.msg('申请高级简历,请等待管理员审核！');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }else if(data="err"){
                        layer.msg('申请失败！', {icon: 2});
                    }
                });
            }, function(){
                layer.closeAll();
                hideBar(elem);
            });
        });
        /* 删除简历 */
        $(".delresume").on('click', function(event) {
            layer.confirm('确定要删除该简历吗？', {
                btn: ['确认','取消'], //按钮
                title: '删除简历'
            }, function(){
                $.get("?act=resume_del&pid="+pid+"", function(data){
                    if(data=="ok"){
                        layer.msg('删除简历成功！', {icon: 1});
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }else if(data="err"){
                        layer.msg('删除简历失败！', {icon: 2});
                    }else{
                        layer.msg(data);
                    }
                });
            }, function(){
                layer.closeAll();
                hideBar(elem);
            });
        });
    });

 	/* 专业 */
 	$("#majorTxt").on("click",function(){
 		var elem = $(".select_bar_div"),
            that = this;
        elem.show().css("height",300)
        lockWin.on();
        if($("#loc_level1_cityList").length){
            elem.show().addClass("on");
        }else{
            elem.empty();
            elem.append('<div class="select_bar_head">专业</div><div id="majorList" class="sl_list"><div><ul></ul></div></div>');
            elem.addClass("on");
            var select_city = m_selector.majors($(this).data("go")+"List",true,true);
            setTimeout(function(){
                $(".sl_level1,.sl_level2").css("height",255)
                select_city.refresh();
            },500);
        }
        elem.find(".sl_level2").off("click.checkcity").delegate("li:not(.fail)","click.checkcity",function(){
            if($(this).hasClass('locCity')){
                $("#majorTxt").text($(this).data("txt"));
            }else{
                $("#majorTxt").text($(this).data("txt"));
            }
            $("#major").val($(this).data("val").split(",")[1]);
            $("#major_cn").val($(this).data("txt"));
            hideBar(elem);
        })
        $(".lock_win").on("click",function(){
            hideBar(elem);
        })
    });

 	/* 选中之后隐藏大背景 */
    function hideBar(elem) {
        lockWin.off();
        elem.removeClass("on")
    }

    function clog(a) {
		console.log(a)
	}

	function checkVals(val){
        var mark = true;
        $(".sValDiv>div>div").each(function(){
            if($(this).data("val") == val){
                mark = false;
                return;
            }
        })
        return mark;
    }

    function setVal($this,fun,length,lenFail){
        var addFlag = true,
            editDom = "",
            txt = ($this.data("key"))?$this.data("key"):$this.data("val");
        $("#sValDiv>div>div").each(function(){
            var a = $(this).data("val");
            var b = txt;
            a = a.toString();
            b = b.toString();
            var aArr = a.split(",");
            var bArr = b.split(",");
            if(a == b){
                return false;
            }
            if(aArr.length == 1 && bArr.length == 2){
                if(aArr[0] == bArr[0]){
                    editDom = $(this);
                    addFlag = false;
                }
            }
            if(aArr.length == 2 && bArr.length == 3){
                if(aArr[0] == bArr[0] && aArr[1] == bArr[1]){
                    editDom = $(this);
                    addFlag = false;
                }
            }
        })
        if(addFlag){
            if($("#sValDiv>div>div").length>=length){
                return lenFail()
            }
            $("#sValDiv>div").append('<div data-val="'+txt+'">'+$this.text()+'<em class="close"></em></div>')
            fun();
        }else{
            editDom.data("val",txt)
            editDom.html($this.text()+'<em class="close"></em>')
            fun();
        }
    }
 	/* 展开收起选填项 */
 	$(".notRformChild").hide();
 	$("#showNotrequired").on('click', function(event) {
        $(this).hide();
 		$(".notRformChild").toggle();
 	});
});

/* 获取弹出框里的内容 */
function getOptionsContent(dataSource, title) {
	var content = '<div class="formDiv formDivlayer">';
	if (title.length > 0) {
		content += '<div class="formChild"><div class="lt">' + title + '</div></div>';
	};
	$.each(dataSource, function(index, val) {
		var dataSourceContentArr = val.split(","), id = dataSourceContentArr[0], text = dataSourceContentArr[1];
		content += '<div class="formChild option" data-val="' + id + '" data-content="' + text + '"><div class="lt">' + text + '</div></div>';
	});
	content += '</div>';
	return content;
}

/* 弹出框选择列表点击绑定事件 */
function optionsClick(optionId, optionCn, showcontentId) {
	$(".formDivlayer .option").on('click', function(event) {
		$(optionId).val($(this).data('val'));
		$(optionCn).val($(this).data('content'));
		$(showcontentId).text($(this).data('content'));
 		layer.closeAll();
 	});
}
/* 设置隐私点击事件 */
function privacyOptionsClick() {
    $(".formDivlayer .option").on('click', function(event) {
        $(".formDivlayer .option").each(function(index, el) {
            $(this).removeClass('on');
        });
        $(this).addClass('on');
    });
}
/* 设置隐私确定事件 */
function yesPrivacyOptionsClick(pid) {
    var optionId = $(".formDivlayer .on").data('val');
    $.post('?act=resume_privacy_save', {pid: pid,display: optionId}, function(data) {
        if(data=="ok"){
            layer.msg('隐私设置成功！', {icon: 1});
            setTimeout(function () {
                window.location.reload();
            }, 2000);
        }else if(data=="err"){
            layer.msg('隐私设置失败！', {icon: 2});
        }
    });
    layer.closeAll();
}