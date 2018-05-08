<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>最热列表</title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left">
@include('common.header')
@include('common.navbar')
<div class="mdui-container">
    <div class="mdui-row mdui-typo">
        <h2 class="doc-chapter-title">当前排名</h2>
    </div>
    <div class="mdui-row mdui-typo ">

            <div class="mdui-col-xs-12 mdui-col-sm-12 mdui-col-md-9 " style="margin-top: 10px">
                <div class="mdui-table-fluid">
                    <table class="mdui-table">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>来源</th>
                            <th>名称</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($hotList as $key=> $hotLists)

                                    <tr style="cursor: pointer" title="点击直达" onclick="doSubmit({{$key}})">
                                        <form method="post" action="search" id="{{$key}}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="link" value="{{$hotLists->site}}">
                                            <input type="hidden" name="mov_name" value="{{$hotLists->name}}">
                                        </form>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @if($hotLists->site ==1)
                                                爱奇艺
                                                @elseif($hotLists->site ==2)
                                                腾讯视频
                                            @elseif($hotLists->site ==3)
                                                优酷
                                            @endif

                                        </td>
                                        <td>{{$hotLists->name}}</td>
                                    </tr>

                              @empty
                                无资源
                              @endforelse
                        </tbody>
                    </table>
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