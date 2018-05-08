<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>视频列表</title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left ">
@include('common.header')
@include('common.navbar')
<div class="mdui-container">

    <div class="mdui-col-lg-10 mdui-col-md-9">
        <div class="mdui-row mdui-typo">
            <h2 class="doc-chapter-title">
                @foreach($move_list as $move_lists)
                    @if($move_lists->movie_name)
                        {{$move_lists->movie_name}}
                        @break;
                    @endif
                @endforeach
                <span style="font-size: small;">
                    <span class=" mdui-btn-raised mdui-btn-dense mdui-ripple" style="background-color: #009688;color: #ffffff" status="{{$isSubscribe}}" id="isSubscribe" onclick="subscribe()">
                        @if($isSubscribe == 1)
                            已订阅
                            @else
                            订阅
                        @endif
                    </span>
                </span>
            </h2>


            <p>剧集列表</p>
        </div>
         <hr/>
        <div class="mdui-row " id="movieList">
                @forelse($move_list as $move_lists)
                <div  class="mdui-col-md-4 mdui-col-xs-4 mdui-text-center" style="margin-top: 8px;">
                    <a href="http://vip.o11o.cc/play?url={{$move_lists->link}}&title={{$move_lists->movie_name}}&drama={{$move_lists->title}}" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-teal">{{$move_lists -> title}}</a>
                </div>
                @empty
                    无资源
                @endforelse
        </div>

        @if(!empty($move_lists -> albumId) && (!empty($move_list)))
            <div class="mdui-text-center" id="toMovie" style="margin-top:20px;">
                <p onclick="addMovie()">加载更多</p>
            </div>

        @endif
    </div>
    <div class="mdui-col-lg-2 mdui-col-md-2"></div>
</div>
<div class="mdui-row" style="margin-top: 20px;">
    <div class="mdui-text-center" style="border-top:1px solid #cccccc">
        <p>2018©.<a href="https://vip.o11o.cc" class="mdui-text-color-pink">嗖嗖</a></p>
    </div>
</div>
<script src="js/mdui.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script src="js/common.js"></script>
<script type="text/javascript">
    @if(!empty($move_lists -> albumId) && (!empty($move_list)))
    var page={{ $move_lists -> page }};
    var albumId={{$move_lists -> albumId }};
    @endif


    $(function(){
        $("#gotop").click(function() {
            $("html,body").animate({scrollTop:0}, 500);
        });
    });

    $('img').error(function(){
        $(this).attr('src', "http://img.lanrentuku.com/img/allimg/1212/5-121204193R0-50.gif");
    });

        function addMovie(){
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url: "addMovie",
                data: {p:page+1,albumId:albumId},
                dataType: "json",
                success: function(data){
                    if (data.status == 1) {
                        var html="";
                        for(var i in data.data){
                            html+=' <div  class="mdui-col-md-4 mdui-col-xs-4 mdui-text-center" style="margin-top: 8px;">' +
                                    '<a href="http://vip.o11o.cc/play?url='+data.data[i].link+'&title='+data.data[i].movie_name+'&drama='+data.data[i].title+'" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-teal">'+data.data[i].title+'</a>'+
                                  '</div>'
                        }
                        $("#movieList").append(html);
                        page=page+1;
                    } else {
                        $("#toMovie").empty();
                        mdui.snackbar({
                            message: data.errmsg,
                            timeout:2000,
                        });

                    }
                }

            });
        }
    function GetQueryString(name)
    {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null){
            return  decodeURI(r[2]);
        }else{
            return null;
        }


    }


    function subscribe(){
            var url=decodeURIComponent(GetQueryString("url"));
            var name=GetQueryString("name");
            var site=GetQueryString("site");
            var type=GetQueryString("type");
            var status=$("#isSubscribe").attr("status").trim();
            if(status==1){
                status = 0;
            }else{
                status = 1 ;
            }
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            url: "subscribe",
            data: {url:url,name:name,status:status,site:site,type:type},
            dataType: "json",
            success: function(data){
                if (data.status == 1) {
                    if(data.subscribe==1){
                        $("#isSubscribe").text("已订阅");
                        $("#isSubscribe").attr("status",1);
                    }else{
                        $("#isSubscribe").text("订阅");
                        $("#isSubscribe").attr("status",0);
                    }
                } else {
                    mdui.snackbar({
                        message: data.errmsg,
                        timeout:2000,
                    });

                }
            }

        });
        }




</script>

</body>
</html>