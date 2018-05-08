<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\11\6 0006
 * Time: 22:17
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class MovieController extends Controller{

    public function search(Request $request){
        if($request->has('mov_name')){
            $link=$request->input('link');
            $hot=DB::table("searches")->where([
                ['site', '=', $link],
                ['name', '=', $request->input('mov_name')],
            ])->first();
            if($hot==null){
                DB::table("searches")->insert([
                   "site"=>$link,
                   "name"=>$request->input('mov_name'),
                    "time"=>time(),
                    "total"=>1
                ]);
            }else{
                $total=($hot->total)+1;
                DB::table('searches')
                    ->where([
                        ['site', '=', $link],
                        ['name', '=', $request->input('mov_name')]
                    ])->update(['total' => $total]);
            }

            switch ($link){
                case 1:
                    $mov_name=$request->input('mov_name');
                    /*  rose视频   */
                        if($mov_name=="rose"){
                            $rose=DB::table('rosimm')->get();
                            return view('movie_list',['move_list'=>$rose]);
                        }
                    /*  rose end  */
                  //  $iqiyi=DB::table('iqiyi_movie')->where('key',$mov_name)->get();
                    //如果数据库没数据
                   // if($iqiyi->isEmpty()){
                        $file_list=file_get_contents('http://search.video.iqiyi.com/o?channel_name=&if=html5&pageNum=1&pageSize=10&limit=10&category=&timeLength=0&releaseDate=&key='.$mov_name.'&start=1&threeCategory=&u=frtk3zja4ffo2dgnw4csgvk5&qyid=frtk3zja4ffo2dgnw4csgvk5&pu=&video_allow_3rd=1&intent_result_number=10&intent_category_type=1&vfrm=2-3-0-1&_=1509976963029&callback=Zepto1509976962731');
                        $file_list=substr($file_list,23);
                        $file_list=json_decode(substr($file_list,0,-12),true);
                        //查询结果0为正确
                        if($file_list['code']==0){
                            $mov_list=array();
                            foreach ($file_list['docinfos'] as $key => $val){
                                //判断是不是正片 1 为正片
                                if($val['pos']==1){
                                    $aid=$this->create_guid();


                                     if(isset($val['albumDocInfo']['channel']) && $val['albumDocInfo']['channel']!="-1"){
                                        $video_type=explode(',',$val['albumDocInfo']['channel']);
                                    //$video_type 如果是电影 1 电影 2电视剧
                                    //必须是iqiyi站内视频，并且为单作品
                                    if(isset($val['albumDocInfo']['siteId']) && $val['albumDocInfo']['siteId']=="iqiyi"  && $video_type[1]==1){
                                            //插入数据库下次直接查库
//                                            DB::table('iqiyi_movie')->insert(
//                                                [
//                                                    'key' => $mov_name,
//                                                    'title' => $val['albumDocInfo']['albumTitle'],
//                                                    'pic'=>$val['albumDocInfo']['albumHImage'],
//                                                    'link'=>$val['albumDocInfo']['albumLink'],
//                                                    'type'=>1,
//                                                    'aid'=>$aid,
//                                                    'site'=>"iqiyi"
//                                                ]
//                                            );
                                            $mov_list[$key]['title']=$val['albumDocInfo']['albumTitle'];
                                            $mov_list[$key]['pic']=$val['albumDocInfo']['albumHImage'];
                                            $mov_list[$key]['link']=$val['albumDocInfo']['albumLink'];
                                            $mov_list[$key]['type']='1';
                                            $mov_list[$key]['aid']=$aid;
                                            $mov_list[$key]['site']="iqiyi";
                                    }elseif(isset($val['albumDocInfo']['siteId']) && $val['albumDocInfo']['siteId']=="iqiyi" && $video_type[1]==2){
                                        //插入数据库下次直接查库
//                                        DB::table('iqiyi_movie')->insert(
//                                            [
//                                                'key' => $mov_name,
//                                                'title' => $val['albumDocInfo']['albumTitle'],
//                                                'pic'=>$val['albumDocInfo']['albumHImage'],
//                                                'link'=>$val['albumDocInfo']['albumLink'],
//                                                'type'=>2,
//                                                'aid'=>$aid,
//                                                'site'=>"iqiyi"
//                                            ]
//                                        );
                                        $mov_list[$key]['type']='2';
                                        $mov_list[$key]['title']=$val['albumDocInfo']['albumTitle'];
                                        $mov_list[$key]['pic']=$val['albumDocInfo']['albumHImage'];
                                        $mov_list[$key]['link']=$val['albumDocInfo']['albumLink'];
                                        $mov_list[$key]['aid']=$aid;
                                        $mov_list[$key]['site']="iqiyi";

                                        //video_type = 4动漫
                                    }elseif(isset($val['albumDocInfo']['siteId']) && $val['albumDocInfo']['siteId']=="iqiyi"  && $video_type[1]==4){
//                                        DB::table('iqiyi_movie')->insert(
//                                            [
//                                                'key' => $mov_name,
//                                                'title' => $val['albumDocInfo']['albumTitle'],
//                                                'pic'=>$val['albumDocInfo']['albumHImage'],
//                                                'link'=>$val['albumDocInfo']['albumLink'],
//                                                'type'=>4,
//                                                'aid'=>$aid,
//                                                'site'=>"iqiyi"
//                                            ]
//                                        );
                                        if( $val['albumDocInfo']['series']==false){
                                            $mov_list[$key]['type']='1';
                                        }else{
                                            $mov_list[$key]['type']='4';
                                        }

                                        $mov_list[$key]['title']=$val['albumDocInfo']['albumTitle'];
                                        $mov_list[$key]['pic']=$val['albumDocInfo']['albumHImage'];
                                        $mov_list[$key]['link']=$val['albumDocInfo']['albumLink'];
                                        $mov_list[$key]['aid']=$aid;
                                        $mov_list[$key]['site']="iqiyi";
                                    }
                                     }


                                }
                            }

                            //与数据库查出来的数据相对应 转为对象
                            $mov_list=$this->arrayToObject($mov_list);

                            return view('movie_list',['move_list'=>$mov_list]);
                        }
                   // }else{

                        //数据库有数据直接返回
                       // return view('movie_list',['move_list'=>$iqiyi]);
                  //  }

                    break;

                case 2:
                    $mov_name=$request->input('mov_name');
                    $url="https://v.qq.com/x/search/?q=".urlencode($mov_name);
                    $html = new \simple_html_dom();
                    // 从url中加载
                    $html->load_file($url);

                    $item=array();

                    foreach($html->find('.result_item_v ') as $key=> $val){
                        $props=$val->getAttribute('r-props');
                        $aid=$this->create_guid();
                             //正则匹配是腾讯本站的
                            if (preg_match("/curPlaysrc\: \'qq\'/", $props, $matches))
                            {
                                //匹配是电影
                                if(preg_match("/videoType\: \'1\'/", $props, $matches)){
                                   $item[$key]['link']=$val->find('.result_figure',0)->href;
                                   $item[$key]['type']="1";
                                   $item[$key]['pic']=$val->find('.result_figure img',0)->src;
                                   $item[$key]['title']=$val->find('.result_title',0)->plaintext;
                                    $item[$key]['aid']=$aid;
                                    $item[$key]['site']="qq";
                                }elseif(preg_match("/videoType\: \'2\'/", $props, $matches)){
                                    $item[$key]['link']=$val->find('.result_figure',0)->href;
                                    $item[$key]['type']="2";
                                    $item[$key]['pic']=$val->find('.result_figure img',0)->src;
                                    $item[$key]['title']=$val->find('.result_title',0)->plaintext;
                                    $item[$key]['aid']=$aid;
                                    $item[$key]['site']="qq";
                                }
                            }


                    }
                    $mov_list=$this->arrayToObject($item);


                    return view('movie_list',['move_list'=>$mov_list]);
                case 3:
                    $mov_name=$request->input('mov_name');
                    $url="http://www.soku.com/m/y/video?q=".urlencode($mov_name);
                    $file = curl_get($url);
                    $html=str_get_html($file);
                    $item=array();
                    foreach($html->find('.card_bd  ') as $key=> $val){
                        $aid=$this->create_guid();
                        //优酷有多种格式，所以截取前两个字符，若为优酷既是优酷本站视频
                        $site=$val->find('.v_play img',0)->src;
                        $houzhui = substr(strrchr($site, '.'), 1);
                        $site = basename( $site,".".$houzhui);

                        if($site=="youku"){
                            //判断是电影
                            if((trim($val->find('.v_desc span',0)->plaintext))=="电视剧" ){
                                if((trim($val->find('.v_desc span',3)->plaintext))!="花絮" && (trim($val->find('.v_desc span',3)->plaintext))!="预告" && (trim($val->find('.v_desc span',3)->plaintext))!="" ){
                                    $item[$key]['link']=$url;

                                    $item[$key]['type']="2";
                                    $item[$key]['pic']=$val->find('.v_img img',0)->src;
                                    //去掉中间空格，两边空格
                                    $item[$key]['title']=str_replace(' ',"",trim($val->find('.v_title a',0)->plaintext));
                                    $item[$key]['aid']=$aid;
                                    $item[$key]['site']="youku";
                                    //优酷独有，选集时使用的视频ID
                                     $item[$key]['video_id']=$val->find('.v_pe a',0)->getAttribute('data-pe');
                                }

                            }


                        }

                    }

                    $mov_list=$this->arrayToObject($item);

                    return view('movie_list',['move_list'=>$mov_list]);

                    break;
            }
        }

    }

    public function play(Request $request){
        if($request->has('url')){
            $uid=Session('uid');
            if(!$uid){
                echo "请先登录";
            }else{
                $mov_name=$request->input("title");
                $drama=$request->input("drama");
                DB::table('watchhistory')->insert([
                    "uid"=>$uid,
                    "title"=>$mov_name,
                    "drama"=>$drama,
                    "time"=>time(),
                    "link"=>"http://vip.o11o.cc/play?url=".$request->input('url').'&title='.$mov_name.'&drama='.$drama
                ]);
                return view('play',['play_link'=>$request->input('url'),'title'=>$mov_name,'drama'=>$drama]);
            }

        }
    }

    //电视剧详情
    public function detail(Request $request){
        if($request->has('url')){
            $url=$request->input('url');
            $aid=$request->input('aid');
            $name=$request->input('name');
            $site=$request->input('site');
            $type=$request->input('type');
            $uid = Session("uid");

            $subRes=DB::table("subscribe")->where([
                ['uid', '=', $uid],
                ['url', '=', $url],
                ['name', '=', $name],
                ['status', '=', 1],
            ])->first();
            if($subRes){
                $isSubscribe=1;
            }else{
                $isSubscribe=0;
            }

            switch ($site){
                case 'iqiyi':
                   // $movie=DB::table('iqiyi_detail')->where('url',$url)->get();
                  //  if($movie->isEmpty()){

                        //如果是爱奇艺的动漫
                        if($type=='4'){
                            $url=str_replace("www","m",$url);
                            $file = curl_get_mobile($url);
                            $html=str_get_html($file);
                            $item=array();
                            preg_match('/data-aid=\"(.*?)\"/',$html,$match);
                            $apiUrl=file_get_contents("http://mixer.video.iqiyi.com/jp/mixin/videos/avlist?albumId=".$match[1]."&page=1&size=30&_=1520315460827&callback=Zepto1520314209759");
                            $file_list=substr($apiUrl,23);
                            $file_list=substr($file_list,0,-15);
                            $file_list=json_decode($file_list,true);
                            foreach($file_list['mixinVideos'] as $key => $val){
                                $item[$key]['title'] = $val['order'];
                                $item[$key]['link']=$val['url'];
                                $item[$key]['url']=$url;
                                $item[$key]['aid']=$aid;
                                $item[$key]['albumId']=$match[1];
                                $item[$key]['page']="1";
                                $item[$key]['movie_name']=$name;
                            }
                        }else{
                            $html = new \simple_html_dom();
                            // 从url中加载
                            $html->load_file($url);
                            $item=array();
                            foreach($html->find('.site-piclist-12068  li ') as $key=> $val) {
                                $item[$key]['title'] = trim($val->find('.site-piclist_info_title',0)->plaintext);//获取纯文本
                                $item[$key]['link']=$val->find('.site-piclist_info_title a',0)->href;
                                $item[$key]['url']=$url;
                                $item[$key]['aid']=$aid;
                                $item[$key]['albumId']="";
                                $item[$key]['page']="";
                                $item[$key]['movie_name']=$name;

//                            DB::table('iqiyi_detail')->insert(
//                                [
//                                    'title'=>$item[$key]['title'],
//                                    'link'=> $item[$key]['link'],
//                                    'url'=>$url,
//                                    'aid'=>$aid,
//                                    'movie_name'=>$name
//                                ]
//                            );
                            }
                        }

                        $mov_list=$this->arrayToObject($item);

                        return view('album_detail',['move_list'=>$mov_list,"isSubscribe"=>$isSubscribe]);
                   // }else{
                        //数据库有数据直接返回

                       // return view('album_detail',['move_list'=>$movie]);
                    //}
                    break;
                case 'qq':
                    $html= new \simple_html_dom();
                    $html->load_file($url);
                    $item=array();
                    foreach ($html->find('.mod_episode .item') as $key =>$val){
                        if(empty($val->find('.mark_v img'))){
                            $item[$key]['mark']="";
                        }else{
                            $item[$key]['mark']=$val->find('.mark_v img',0)->src;
                        }
                        $houzhui = substr(strrchr($item[$key]['mark'], '.'), 1);
                        $result = basename( $item[$key]['mark'],".".$houzhui);
                        $item[$key]['mark']=$result;
                        switch ($item[$key]['mark']){
                            case 'mark_13':
                                $item[$key]['mark']="(新)";
                                break;
                            case  'mark_12':
                                $item[$key]['mark']="(预)";
                                break;
                            case  'mark_14':
                                $item[$key]['mark']="(vip)";
                                  break;
                        }
                        $item[$key]['url']=$url;
                        $item[$key]['link']=$val->find('a',0)->href;
                        $item[$key]['title']=($val->plaintext).$item[$key]['mark'];
                        $item[$key]['aid']=$aid;
                        $item[$key]['movie_name']=$name;
                    }

                    $mov_list=$this->arrayToObject($item);
                    return view('album_detail',['move_list'=>$mov_list,"isSubscribe"=>$isSubscribe]);

                    break;
                case 'youku':
                    $v_id=$request->input('v_id');
                    $html= new \simple_html_dom();
                    $html->load_file($url);
                    $item=array();
                    foreach ($html->find("#".$v_id." ul li") as $key =>$val){
                        $item[$key]['url']=$url;
                        $item[$key]['link']=$val->find('a',0)->href;
                        $item[$key]['title']=$val->find('a',0)->plaintext;
                        $item[$key]['aid']=$aid;
                        $item[$key]['movie_name']=$name;
                    }
                    $mov_list=$this->arrayToObject($item);
                    return view('album_detail',['move_list'=>$mov_list,"isSubscribe"=>$isSubscribe]);

            }

        }
    }

    //反馈
    public function feedback(Request $request){
        if($request->has('message')){
            $message=$request->input("message");
            $res = DB::table('feedback')->insert(
                [
                    'content'=>$message,
                    'createtime'=>time(),
                    'ip'=>$request->getClientIp()
                ]
            );
            if($res){
                $data=[
                    'status'=>1,
                ];
                //dispatch(new SendEmail('646017437@qq.com',$message));

                $common=new CommonController();
                $common->SendEmail('646017437@qq.com',$message,'有新的反馈，注意查看！','hgg7758521@126.com','反馈信使');
            }else{
                $data=[
                    'status'=>0,
                    'msg'=>'反馈失败'
                ];
            }

        }else{
            $data=[
                'status'=>0,
                'msg'=>'反馈失败'
            ];
        }
        return response()->json($data);
    }

    //iqiyi获取更多视频 动漫
    public function addMovie(Request $request){
        if($request->isMethod('POST')){
            $page=$request->input("p");
            $albumId=$request->input("albumId");
            $apiUrl=file_get_contents("http://mixer.video.iqiyi.com/jp/mixin/videos/avlist?albumId=".$albumId."&page=".$page."&size=30&_=1520315460827&callback=Zepto1520314209759");
            $file_list=substr($apiUrl,23);
            $file_list=substr($file_list,0,-15);
            $file_list=json_decode($file_list,1);

            if(empty($file_list['mixinVideos'])){
                $data=["status"=>0,"errmsg"=>"没有更多了"];
            }else{
                $item=array();
                foreach($file_list['mixinVideos'] as $key => $val){
                    $item[$key]['title'] = $val['order'];
                    $item[$key]['link']=$val['url'];
                    $item[$key]['albumId']=$albumId;
                    $item[$key]['page']=$page;
                    //albumName
                    $item[$key]['movie_name']=$val['albumName'];
                }
                $data=["status"=>1,"data"=>$item,"errmsg"=>"ok"];
            }
            return response()->json($data);
        }
    }

    //最热视频
    public function hot(){
        $hot=DB::table('searches')->where("name","<>","rose")->orderBy("total","desc")->limit(10)->get();
        return view("hot",["hotList"=>$hot]);
    }
    //rosimm播放页
    public function sexy(Request $request){
        $v_id=$request->input("v_id");
        $video=DB::table("rosivideo")->where("v_id",$v_id)->first();
        return view("sexy",["videourl"=>$video->videourl]);
    }




    //数组转对象
    public function arrayToObject($e)
    {

        if (gettype($e) != 'array') return;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object')
                $e[$k] = (object)$this->arrayToObject($v);
        }
        return (object)$e;
    }

    /**
     * 生成Guid码
     */
    function create_guid() {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);// "-"
        $guid =substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $guid;
    }

}
        