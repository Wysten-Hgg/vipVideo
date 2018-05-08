<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>视频列表</title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left">
@include('common.header')
@include('common.navbar')
<div class="mdui-container">
    <div class="mdui-row mdui-typo">
        <h2 class="doc-chapter-title">搜索结果</h2>
        @foreach($move_list as $move_lists)
            @if($move_lists->site=='youku')
                <p style="font-size: small"><strong>优酷暂不提供电影检索</strong></p>
                @break;
            @endif
        @endforeach
    </div>
    <div class="mdui-row mdui-typo ">
        @forelse($move_list as $move_lists)
        <div class="mdui-col-xs-6 mdui-col-sm-3 mdui-col-md-2 mdui-shadow-2" style="margin-top: 10px">
            @if( $move_lists->type=='1' )
            <a href="http://vip.o11o.cc/play?url={{ $move_lists->link }}&title={{$move_lists->title}}">
            <div class="mdui-card">
                <div class="mdui-card-media">
                    <img  class="mdui-img-fluid" src="{{ $move_lists->pic }}" onerror="this.src='http://bpic.588ku.com/element_origin_min_pic/01/37/92/40573c69065b76e.jpg'">
                    <div class="mdui-card-media-covered">
                        <div class="mdui-card-primary">
                            <div class="mdui-card-primary-title">
                                <small style="font-size: small">{{ $move_lists->title }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>

            @elseif($move_lists->type=='rosimm')
                <a href="http://vip.o11o.cc/sexy?v_id={{ $move_lists->v_id }}">
                    <div class="mdui-card">
                        <div class="mdui-card-media">
                            <img  class="mdui-img-fluid" src="{{ $move_lists->pic }}" onerror="this.src='http://bpic.588ku.com/element_origin_min_pic/01/37/92/40573c69065b76e.jpg'">
                            <div class="mdui-card-media-covered">
                                <div class="mdui-card-primary">
                                    <div class="mdui-card-primary-title">
                                        <small style="font-size: small">{{ $move_lists->title }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @else
                @if($move_lists->site=='youku')
                    <a href="detail?url={{$move_lists->link }}&aid={{$move_lists -> aid}}&name={{$move_lists->title}}&site={{$move_lists->site}}&v_id={{$move_lists->video_id}}">
                 @else
                    <a href="detail?url={{$move_lists->link }}&aid={{$move_lists -> aid}}&name={{$move_lists->title}}&site={{$move_lists->site}}&type={{$move_lists->type}}">
                 @endif
                   <div class="mdui-card">
                        <div class="mdui-card-media">
                            <img  class="mdui-img-fluid" src="{{ $move_lists->pic }}" onerror="this.src='http://bpic.588ku.com/element_origin_min_pic/01/37/92/40573c69065b76e.jpg'">
                            <div class="mdui-card-media-covered">
                                <div class="mdui-card-primary">
                                    <div class="mdui-card-primary-title">
                                        <small style="font-size: small">{{ $move_lists->title }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endif
        </div>
        @empty
            无资源
        @endforelse

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

    $('img').error(function(){
        $(this).attr('src', "http://img.lanrentuku.com/img/allimg/1212/5-121204193R0-50.gif");
    });
</script>

</body>
</html>