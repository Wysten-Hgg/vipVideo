
$("#register").on('click',function(){
    $("#loginCancel").click();
    var inst = new mdui.Dialog('#dialog-register');
    inst.open();
});

$("#login").on('click',function(){
    $("#registerCancel").click();
    var inst = new mdui.Dialog('#dialog-login');
    inst.open();
});

$("#doRegister").on('click',function () {
   var username=$("#rUsername").val().trim();
   var password=$("#rPassword").val().trim();
   var code=$("#code").val().trim();
   if(username ==""){
       mdui.snackbar({
           message: '请输入用户名',
           timeout:2000
       });
       return false;
   }
    if(password ==""){
        mdui.snackbar({
            message: '请输入密码',
            timeout:2000
        });
        return false;
    }
    if(code ==""){
        mdui.snackbar({
            message: '请输入验证码',
            timeout:2000
        });
        return false;
    }
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        url: "register",
        data: {username:username,password:password,code:code},
        dataType: "json",
        success: function(data){

            if (data.status == 1) {
                mdui.snackbar({
                    message: data.errmsg,
                    timeout:2000,
                    onClose: function(){
                        $("#rUsername").val('');
                        $("#rPassword").val('');
                        $("#code").val('');
                        $("#registerCancel").click();
                        var inst = new mdui.Dialog('#dialog-login');
                        inst.open();
                    }
                });
            } else {
                mdui.snackbar({
                    message: data.errmsg,
                    timeout:2000
                });
                $("#img").click();
            }
        }

    });
});


$("#doLogin").on('click',function () {
    var username=$("#username").val().trim();
    var password=$("#password").val().trim();

    if(username ==""){
        mdui.snackbar({
            message: '请输入用户名',
            timeout:2000
        });
        return false;
    }
    if(password ==""){
        mdui.snackbar({
            message: '请输入密码',
            timeout:2000
        });
        return false;
    }
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        url: "login",
        data: {username:username,password:password},
        dataType: "json",
        success: function(data){
            if (data.status == 1) {
                mdui.snackbar({
                    message: data.errmsg,
                    timeout:2000,
                    onClose: function(){
                        window.location.reload();
                    }
                });
            } else {
                mdui.snackbar({
                    message: data.errmsg,
                    timeout:2000,
                });

            }
        }

    });
});

function checkLogin() {
    if(isLogin==""){
        mdui.alert('请先登录!','错误', function(){
            var inst = new mdui.Dialog('#dialog-login');
            inst.open();
        });
        return false;
    }else{
        return true;
    }
}

function goLastWatch(link) {
    if(!checkLogin()) return;
    if(link!=""){
        window.location.href=link;
    }else{
        mdui.alert('无记录!','错误');
        return false;
    }

}





