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

function addStations() {
    var jstr = '';
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
    var str1= "<tr><td align=\"right\"></td> <td>"+ $("[name='province'] option:selected").text()+'-'+$("[name='city'] option:selected").text()+'-'+$("[name='county'] option:selected").text()+'-'+$("[name='business'] option:selected").text()+','+$("[name='stations_jz_nums']").val()+'人,'+$("[name='jz_xz']").val()+'元/人,'+ $("[name='work_start']").val()+'-'+ $("[name='work_end']").val() + "<a href=\"#\">删除</a></td></tr>";
    var str= "<tr><td align=\"right\"></td> <td> <input type=\"hidden\" name=\"stations[]\" value='"+encodeURIComponent(jstr)+"' /> </td></tr>";
    $('#configs').append(str1);
    $('#configs').append(str);
    closeSetConfig();
}