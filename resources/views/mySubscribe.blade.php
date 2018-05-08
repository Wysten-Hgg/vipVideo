<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>我的订阅</title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
    <style>
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
    </style>
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left">
@include('common.header')
@include('common.navbar')
<div class="mdui-container">
    <div class="mdui-row mdui-typo">
        <h2 class="doc-chapter-title">我的订阅</h2>
    </div>
    <div class="mdui-row mdui-typo ">

        <div class="mdui-col-xs-12 mdui-col-sm-12 mdui-col-md-9 " style="margin-top: 10px">
            <div class="mdui-table-fluid">
                <table class="mdui-table">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>名称</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($list as $key=> $Lists)

                        <tr style="cursor: pointer" title="点击直达" onclick="doSubmit({{$key}})">
                            <form method="get" action="detail" id="{{$key}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="url" value="{{$Lists->url}}">
                                <input type="hidden" name="name" value="{{$Lists->name}}">
                                <input type="hidden" name="aid" value="{{$key}}">
                                <input type="hidden" name="site" value="{{$Lists->site}}">
                                <input type="hidden" name="type" value="{{$Lists->type}}">
                            </form>
                            <td>{{$key+1}}</td>
                            <td>
                                {{$Lists->name}}
                            </td>
                        </tr>

                    @empty
                        无资源
                    @endforelse
                    </tbody>
                </table>

            </div>
        <div style="float: right">
            {{ $list->links() }}
        </div>
        </div>


    </div>


</div>


<button id="gotop" class="mdui-fab mdui-fab-fixed mdui-ripple mdui-color-teal"><i class="mdui-icon material-icons">&#xe55d;</i></button>

<script src="js/mdui.min.js"></script>

<script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script src="js/common.js"></script>
<script type="text/javascript">


    $(function(){
        $("#gotop").click(function() {
            $("html,body").animate({scrollTop:0}, 500);
        });
    });
    function doSubmit(n) {
        if(!checkLogin()) return;
        document.getElementById(n).submit();
    }

</script>

</body>
</html>