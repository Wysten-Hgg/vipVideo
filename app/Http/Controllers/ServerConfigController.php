<?php
/**
 * Created by PhpStorm.
 * User: Mugeda
 * Date: 2018/5/9
 * Time: 11:50
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ServerConfigController extends \swoole_websocket_server
{

    public function open(\Redis $redis,$frame)
    {
        $uid = $frame->get['uid'];
        DB::table("watchtimes")->insert(
            [
                "uid" => $uid,
                "start_time" => time()
            ]
        );
        $redis->set($frame->fd,$uid);
        echo "uid".$uid.'开始观看';
    }

    public function send_message($redis,$frame){

    }

    public function user_close(\Redis $redis,$fd)
    {
        $uid = $redis->get($fd);
        DB::table('watchtimes')->where([
            ['uid', '=', $uid],
            ['end_time', '=', 0],
        ])->orderBy("id", "desc")->limit(1)->update(["end_time" => time()]);
        echo $uid.'离开了';
        $this->close($fd);
    }

}