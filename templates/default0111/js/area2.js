$(function() {
    var tsTimeStamp= new Date().getTime();

    $.get("company_ajax.php", {"act":"get_cat_qgdistrict","tstime":tsTimeStamp,"pid":0},
        function (data,textStatus)
        {
            if (data)
            {
                var str=data.split("|");
                var i=1;
                var html="";
                for (x in str)
                {
                    var val=str[x].split(",");
                    var valstr=val[0]+'|'+val[3]+'|'+val[4];
                    var option = $("<option>").val(valstr).text(val[1]);
                    $("[name='province']").append(option);
                }
            }
        }
    );

    // //绑定省份
    // for (var i = 0; i < areas.length; i++) {
    //     if (parseInt(areas[i].level) == 1) {
    //         option = $("<option>").val(areas[i].code).text(areas[i].name);
    //         $("[name='province']").append(option);
    //     }
    // }

    //城市联动
    $("[name='province']").bind("change", function() {
        var valstr = $(this).val();
        var strval = valstr.split("|");
        var pid = strval[0];
        var tsTimeStamp= new Date().getTime();
        if(pid > 0) {
            $("[name='city'] option:gt(0)").remove();
            loadPlace(strval[1], strval[2], 12);
            $.get("company_ajax.php", {"act":"get_cat_qgdistrict","tstime":tsTimeStamp,"pid":pid},
                function (data,textStatus)
                {
                    if (data)
                    {
                        var str=data.split("|");
                        var i=1;
                        var html="";
                        for (x in str)
                        {
                            var val=str[x].split(",");
                            var valstr=val[0]+'|'+val[3]+'|'+val[4];
                            var option = $("<option>").val(valstr).text(val[1]);
                            $("[name='city']").append(option);
                        }
                    }
                }
            );
        }
    });

    //城市联动
    $("[name='city']").bind("change", function() {
        var valstr = $(this).val();
        var strval = valstr.split("|");
        var pid = strval[0];
        var tsTimeStamp= new Date().getTime();
        if(pid > 0) {
            $("[name='county'] option:gt(0)").remove();
            loadPlace(strval[1], strval[2], 12);
            $.get("company_ajax.php", {"act":"get_cat_qgdistrict","tstime":tsTimeStamp,"pid":pid},
                function (data,textStatus)
                {
                    if (data)
                    {
                        var str=data.split("|");
                        var i=1;
                        var html="";
                        for (x in str)
                        {
                            var val=str[x].split(",");
                            var valstr=val[0]+'|'+val[3]+'|'+val[4];
                            var option = $("<option>").val(valstr).text(val[1]);
                            $("[name='county']").append(option);
                        }

                    }
                }
            );
        }
    });

    //县区联动
    $("[name='county']").bind("change", function() {
        var valstr = $(this).val();
        var strval = valstr.split("|");
        var pid = strval[0];
        var tsTimeStamp= new Date().getTime();
        if(pid > 0) {
            loadPlace(strval[1], strval[2], 12);
            $("[name='business'] option:gt(0)").remove();
            $.get("company_ajax.php", {"act":"get_cat_qgdistrict","tstime":tsTimeStamp,"pid":pid},
                function (data,textStatus)
                {
                    if (data)
                    {
                        var str=data.split("|");
                        var i=1;
                        var html="";
                        for (x in str)
                        {
                            var val=str[x].split(",");
                            var valstr=val[0]+'|'+val[3]+'|'+val[4];
                            var option = $("<option>").val(valstr).text(val[1]);
                            $("[name='business']").append(option);
                        }
                    }
                }
            );
        }
        //绘制地图
        // if (code > 0) {
        //
        //     for (var i = 0; i < areas.length; i++) {
        //         if (parseInt(areas[i].code) == code) {
        //             var longitude = areas[i].longitude;
        //             var latitude = areas[i].latitude;
        //             loadPlace(longitude, latitude);
        //             break;
        //         }
        //     }
        // }
    });

});

var jstr = '';
function addStations() {
    jstr = '';
    jstr += 'provinceId='+$("[name='province']").val();
    jstr += '&provinceName='+$("[name='province'] option:selected").text();
    jstr += '&cityId='+$("[name='city']").val();
    jstr += '&cityName='+$("[name='city'] option:selected").text();
    jstr += '&countyId='+$("[name='county']").val();
    jstr += '&countyName='+$("[name='county'] option:selected").text();
    jstr += '&businessId='+$("[name='business']").val();
    jstr += '&businessName='+$("[name='business'] option:selected").text();
    jstr += '&fname='+$("[name='fname']").val();
    jstr += '&dd_nums='+$("[name='dd_nums']").val();
    jstr += '&dd_by_nums='+$("[name='dd_by_nums']").val();
    jstr += '&ddxz='+$("[name='ddxz']").val();
    jstr += '&stations_jz_nums='+$("[name='stations_jz_nums']").val();
    jstr += '&stations_jz_by_nums='+$("[name='stations_jz_by_nums']").val();
    jstr += '&jz_xz='+$("[name='jz_xz']").val();
    jstr += '&work_start='+$("[name='work_start']").val();
    jstr += '&work_end='+$("[name='work_end']").val();
    jstr += '&work_start_time='+$("[name='work_start_hour']").val()+':'+$("[name='work_start_minute']").val();
    jstr += '&work_end_time='+$("[name='work_end_hour']").val()+':'+$("[name='work_end_minute']").val();
    jstr += '&work_jh_time='+$("[name='work_jh_hour']").val()+':'+$("[name='work_jh_minute']").val();
    jstr += '&work_jh_dd='+$("[name='work_jh_dd']").val();
    jstr += '&position_lng='+$("#position_lng").val();
    jstr += '&position_lat='+$("#position_lat").val();
    jstr += '&work_xzdw_id='+$('#work_xzdw_id').val();
    jstr += '&work_xzdw='+$('#work_xzdw').val();
    var str1= "<tr><td align=\"right\"></td> <td>"+ $("[name='province'] option:selected").text()+'-'+$("[name='city'] option:selected").text()+'-'+$("[name='county'] option:selected").text()+'-'+$("[name='business'] option:selected").text()+','+$("[name='stations_jz_nums']").val()+'人,'+$("[name='jz_xz']").val()+'元/人,'+ $("[name='work_start']").val()+'-'+ $("[name='work_end']").val() + "<a href=''>删除</a>" + "<a href='javascript:void(0)' onclick='updateJob(this)'> 修改</a>" + "</td></tr>";
    var str= "<tr><td align=\"right\"></td> <td> <input type=\"hidden\" name=\"stations[]\" value='"+encodeURIComponent(jstr)+"' /> </td></tr>";
    $('#configs').append(str1);
    $('#configs').append(str);
    closeSetConfig();
}


function updateJob(curNode)
{
    var otrEle = $(curNode).closest('tr').next('tr').find('input').val();
    var str = decodeURIComponent(otrEle);
    var strs = [];
    strs = str.split('&');
    console.log(str);
    console.log(strs);
    var area = {};
    for(var i in strs){
        var kv = strs[i].split("=");
        area[kv[0]] = kv[1];
    }

    area.work_jh_hour = area.work_jh_time.split(':')[0];
    area.work_jh_minute = area.work_jh_time.split(':')[1];
    area.work_start_hour = area.work_start_time.split(':')[0];
    area.work_start_minute = area.work_start_time.split(':')[1];
    area.work_end_hour = area.work_end_time.split(':')[0];
    area.work_end_minute = area.work_end_time.split(':')[1];


    openSetConfig();

    $('#dd_nums').val(area.dd_nums);
    $('#dd_by_nums').val(area.dd_by_nums);
    $('#ddxz').val(area.ddxz);
    $('#work_xzdw_id').val(area.work_xzdw_id);
    $('#work_xzdw').val(area.work_xzdw);
    $('#stations_jz_nums').val(area.stations_jz_nums);
    $('#stations_jz_by_nums').val(area.stations_jz_by_nums);
    $('#jz_xz').val(area.jz_xz);
    $('#work_start').val(area.work_start);
    $('#work_end').val(area.work_end);
    $('#work_start_hour_id').val(area.work_start_hour_id); //0000
    $('#work_start_hour').val(area.work_start_hour); //0000
    $('#work_start_minute_id').val(area.work_start_minute_id); //0000
    $('#work_start_minute').val(area.work_start_minute); //0000
    $('#work_end_hour_id').val(area.work_end_hour_id);
    $('#work_end_hour').val(area.work_end_hour);
    $('#work_end_minute').val(area.work_end_minute);
    $('#work_end_minute_id').val(area.work_end_minute_id);
    $('#work_jh_hour_id').val(area.work_jh_hour_id);
    $('#work_jh_hour').val(area.work_jh_hour);
    $('#work_jh_minute_id').val(area.work_jh_minute_id);
    $('#work_jh_minute').val(area.work_jh_minute);
    $('#work_jh_dd').val(area.work_jh_dd);

    $("#work_xzdw_menu").html(area.work_xzdw);
    $("#work_start_hour_menu").html(area.work_start_hour);
    $("#work_start_minute_menu").html(area.work_start_minute);
    $("#work_our_menu").html(area.work_end_hour);
    $("#work_minute_menu").html(area.work_end_minute);
    $("#work_jh_hour_menu").html(area.work_jh_hour);
    $("#work_jh_minute_menu").html(area.work_jh_minute);

    //$('#province').children("[value='"+area.provinceId+"']").prop("selected","true");

    //$('#city').children("[value='"+area.cityId+"']").prop("selected","true");

    //$('#county').children("[value='"+area.countyId+"']").prop("selected","true");

    //$('#business').children("[value='"+area.businessId+"']").prop("selected","true");

    // function eachOption(addr, area){
    //     addr.each(function(i, e){
    //         if($(e).val() == area){
    //             $(this).attr('selected', true);
    //         }
    //     });
    // }
    // eachOption($('#province option'), area.provinceId);
    $('#province option').each(function(i, e){
        if($(e).val() == area.provinceId){
            $(this).attr('selected', true);
        }
    });

    // 根据父级id获取子类的地区数据
    function areaOption (areaId, selectId, nextId) {
        var tsTimeStamp= new Date().getTime();
        $.get("company_ajax.php", {"act":"get_cat_qgdistrict","tstime":tsTimeStamp,"pid":areaId},
            function(data) {
                data = data.replace(/,0,,/g, '');
                data = data.split('|');
                selectId.find('option').remove();
                // var result = {};
                for(var i in data){
                    var kv = data[i].split(",");
                    // result[kv[0]] = kv[1];
                    if(kv[0]+'||' == nextId){
                        $("<option selected='selected' value='" + kv[0] + "'>" + kv[1] + "</option>").appendTo(selectId);
                    }else{
                        $("<option value='" + kv[0] + "'>" + kv[1] + "</option>").appendTo(selectId);
                    }
                }
                // console.log(result);
                // console.log(data);
            }
        )
    }
    areaOption(0, $('#province'), area.provinceId);
    areaOption(area.provinceId, $('#city'), area.cityId);
    areaOption(area.cityId, $('#county'), area.countyId);
    areaOption(area.countyId, $('#business'), area.businessId);


    $("#saveBtn").data("method","update");
    console.log($("#saveBtn"));
    var targetInput = $(curNode).closest('tr').next('tr').find('input');
    targetInput.addClass("update");
}