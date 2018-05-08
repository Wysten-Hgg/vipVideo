<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>
       正在播放
    </title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left ">
@include('common.header')
@include('common.navbar')
<div class="mdui-col-lg-1 mdui-col-md-1 mdui-col-sm-1"></div>
<div class="mdui-col-lg-8 mdui-col-md-8 mdui-col-sm-8">
    <iframe id="frame" width="100%" height="400px"  allowTransparency="true" frameborder="0" scrolling="no" src="http://api.nepian.com/ckparse/?url={{$videourl}}"></iframe>




</div>


<div class="mdui-col-xs-1 mdui-col-sm-2 mdui-col-md-2 mdui-col-lg-2"></div>
<div class="mdui-col-xs-10  mdui-col-sm-10 mdui-col-md-10 mdui-col-lg-10">
    <div class="mdui-text-center">
        <p>2018©.<a href="https://vip.o11o.cc" class="mdui-text-color-pink">嗖嗖</a></p>
        <a href="feedback" class="mdui-text-color-pink">意见反馈</a> |

        <a href="about" class="mdui-text-color-pink">关于本站</a>
    </div>
</div>


<script src="js/mdui.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script src="js/common.js"></script>

</body>
</html>
