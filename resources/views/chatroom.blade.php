<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>嗖嗖电影</title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left ">
@include('common.header')
@include('common.navbar')

<div class="mdui-container">

    <div class="mdui-row" style="margin-top: 10px;">
        <div style="height:80%;overflow-y:auto;word-wrap:break-word" id="content">
        </div>
    </div>
    <div class="mdui-row">
            <div style="position: fixed;left: 0;bottom: 0; width: 100%">
                <div class="mdui-col-xs-1  mdui-col-lg-3 mdui-col-md-3 "></div>
                <div class="mdui-col-xs-10  mdui-col-lg-8 mdui-col-md-8">
                    <div class="mdui-col-xs-10   mdui-col-md-8">
                        <div class="mdui-textfield">
                            <input class="mdui-textfield-input" type="text" id="message" placeholder="聊片儿~"/>
                        </div>
                    </div>
                 <div  class="mdui-col-xs-2   mdui-col-md-4" style="margin-top: 33px">
                     <a href="javascript:void(0);" class="mdui-text-color-pink" id="submit" onclick="sendMessage()">发送</a>
                 </div>
                </div>
            </div>
    </div>
</div>

<script src="js/mdui.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script src="js/common.js"></script>

<script type="text/javascript">
    var  $$ = mdui.JQ;
    if(window.WebSocket){
        var webSocket = new WebSocket("ws://101.201.67.69:9501?name={{Session('user')}}");
        var content = document.getElementById('content');
        webSocket.onopen = function (event) {
        };
        webSocket.onmessage = function (event) {

            var obj=JSON.parse(event.data);
            if(obj.type==0){
                var html="";
                console.log(obj);
                content.innerHTML = content.innerHTML.concat('<p style="margin-left:20px;height:20px;line-height:20px;">'+obj.msg+'</p>');
            }else if(obj.type==1){
                var html="";
                console.log(obj);
                content.innerHTML = content.innerHTML.concat('<p style="margin-left:20px;height:20px;line-height:20px;">'+obj.msg+'</p>');
            } if(obj.type==2){
                console.log(obj);
                content.innerHTML = content.innerHTML.concat('<p style="margin-left:20px;height:20px;line-height:20px;">'+obj.msg+'</p>');
            }
            content.scrollTop = content.scrollHeight;
        }
        var sendMessage = function(){
            var data = document.getElementById('message').value;
            if(data.trim()==""){
                mdui.alert('不能发送空消息','错误');
                return false;
            }
                webSocket.send(data);
                content.scrollTop = content.scrollHeight;
                $$('#message').val('');
        }
    }else{
        console.log("您的浏览器不支持WebSocket");
    }
    $(document).keyup(function(event){
        if(event.keyCode ==13){
            $("#submit").trigger("click");
        }
    });
</script>
</body>
</html>