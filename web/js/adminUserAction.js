$(document).ready(function(){
    $(".userChangeBtn").click(function (){
        var uid = $(this).attr('value');
        $.ajax({
            url : '/index.php/admin/ajax-get-user-info',
            type: 'POST',
            data: { 'uid' : uid },
            async:false,
            success : function(data) // 服务器成功响应处理函数
            {
                var form_id = $('form').attr('id');
                $('#uid').val(data.UserInfoModel.id);
                $('#username').val(data.UserInfoModel.username);
                $('#nickname').val(data.personalinfo.nickname);
                $('#email').val(data.UserInfoModel.email);
                $('#sex').val(data.personalinfo.sex);
                $("#parent_city").val(11);
                $("#son_city").empty();
                if (data.personalinfo.location != null){
                    var parent_city_id = data.personalinfo.location.substr(0,2);
                    var son_city_id = data.personalinfo.location.substr(3);
                    $.ajax({
                        url: '/index.php/api/get-son-city?parent_id='+parent_city_id,
                        type: "post",
                        success: function (data) {
                           for(var i =0;i<data.son_city.length;i++){
                        	   $("#son_city").append("<option value="+data.son_city[i]['area_id']+">"+data.son_city[i]['city_name']+"</option>");
                           }
                           $('#son_city').val(son_city_id);
                        }
                    });
                    $('#parent_city').val(parent_city_id);
                }

                if (data.personalinfo.date_of_birth != null){
                    $('#date_of_birth').val(data.personalinfo.date_of_birth.substr(0,10));
                }
                $('#relationship_status').val(data.personalinfo.relationship_status);
                $('#education').val(data.personalinfo.education);
                $('#mood').val(data.personalinfo.mood);
                $(".ui.userChange.modal").modal({
                    onDeny : function(){
                        return true;
                    },
                    onApprove : function() {
                        $('#user-change-form').submit();
                    }
                }).modal("setting", "transition", "fade").modal("show");
                console.log(data);
            },
            error : function(data)// 服务器响应失败处理函数
            {
                console.log(data);
            }
        });
    });

    $(".userDelBtn").click(function (){
        var count = 0;
        var username;
        var uid = $(this).attr('value');
        $("td",$(this).parent().parent()).each(function(){
            if (count == 2){
                username = $(this).text();
                return false;
            }
            count++;
        });
        $('#del_username').text(username);
        $(".ui.delCheck.modal").modal({
            onDeny : function(){
                return true;
            },
            onApprove : function() {
                $.ajax({
                    url : '/index.php/admin/user-del',
                    type: 'POST',
                    data: { 'uid' : uid },
                    async:false,
                    success : function(data) // 服务器成功响应处理函数
                    {
                        console.log(data);
                    },
                    error : function(data)// 服务器响应失败处理函数
                    {
                        console.log(data);
                    }
                });
            }
        }).modal("setting", "transition", "fade").modal("show");
    });
});
