
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
    <div class="mdui-col-xs-1  mdui-col-lg-1 mdui-col-md-1"></div>
    <div class="mdui-col-xs-10  mdui-col-lg-8 mdui-col-md-8">
    <div class="mdui-row">
        <div class="mdui-text-center" style="margin-top: 110px">
            <h2>嗖嗖</h2>
        </div>
    </div>
    <div class="mdui-row">
        <form action="search" method="post" id="form1">
                {{ csrf_field() }}
            <div class="mdui-col-xs-7   mdui-col-md-8">
                <div class="mdui-textfield mdui-textfield-floating-label">
                    <label class="mdui-textfield-label">输入影片名字</label>
                    <input class="mdui-textfield-input" type="text" id="mov_name" name="mov_name">
                </div>
            </div>
        <div class="mdui-col-xs-5   mdui-col-md-4" style="margin-top: 33px">
            <select class="mdui-select" name="link" mdui-select="{position: 'bottom'}">
                <option value="1">爱奇艺</option>
                <option value="2">腾讯视频</option>
                <option value="3">优酷</option>
            </select>
        </div>
        </form>
    </div>
    <div class="mdui-row">
        <div class="mdui-text-center" style="margin-top: 40px">
            <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-teal" id="start">开始</button>
        </div>
    </div>
    </div>
</div>
@include('common.footer')


<script src="js/mdui.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script src="js/common.js"></script>

<script>
    var $$ = mdui.JQ;
    $$("#start").on('click',function(){
        if(!checkLogin()) return;
        var pic_path= document.getElementById("mov_name").value.trim();
        if(pic_path==""){
            mdui.alert('请输入影片名字!','错误');
            return false;
        }
        document.getElementById("form1").submit();
    })


</script>
</body>
</html>