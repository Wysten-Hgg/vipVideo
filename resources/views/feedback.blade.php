
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>嗖嗖电影</title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left">
@include('common.header')
@include('common.navbar')
<div class="mdui-container">
    <div class="mdui-row mdui-typo">
        <h2 class="doc-chapter-title" >
           <span style="border-bottom: 1px solid #cccccc">意见反馈</span>
        </h2>
    </div>

    <div class="mdui-col-lg-10 mdui-col-md-10  " style="margin-top: 40px;">
    <div class="mdui-row mdui-typo">
        <div class="mdui-row " style="margin-left: 2px;margin-right: 2px;">
            <div class="mdui-textfield mdui-textfield-floating-label">
                <textarea class="mdui-textfield-input" maxlength="100" placeholder="缺少视频，意见、建议、Bug，请留言。" id="message"></textarea>
            </div>
        </div>
        <div class="mdui-row">
            <div class="mdui-text-center" style="margin-top: 30px">
                <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-teal" id="start">提交</button>
            </div>
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
        var message= document.getElementById("message").value.trim();
        if(message==""){
            mdui.alert('请输入反馈信息!','错误');
            return false;
        }
        $$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            method: 'POST',
            url: 'feedback',
            data: {
                message:message
            },
            success: function (data) {
                //由JSON字符串转换为JSON对象
                var item = JSON.parse(data);
                if(item.status==1){
                    mdui.alert('反馈成功!','恭喜');
                    $$("#message").val('');
                    return false;
                }else if(item.status==0){
                    mdui.alert(item.msg,'错误');
                    return false;
                }
            }
        });
    })

</script>
</body>
</html>