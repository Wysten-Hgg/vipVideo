<?php
/**
 * Created by PhpStorm.
 * User: Hanson
 * Date: 2018/1/5
 * Time: 10:32
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class CommonController extends Controller{


    protected $email;
    protected $subject;
    protected $fromEmail;
    protected $fromName;

    /*
     * 发送邮件
     * email:接收人邮箱地址,content:正文内容，subject:邮件主题,fromEmail,发送人邮件地址,fromName：发送人姓名
     * return boolean;
     */
    public function SendEmail($email,$content,$subject,$fromEmail,$fromName){
        $this->email=$email;
        $this->subject=$subject;
        $this->fromEmail=$fromEmail;
        $this->fromName=$fromName;
        Mail::raw($content,function($message){
            $message->from($this->fromEmail, $this->fromName);
            $message->subject($this->subject);
            $message->to($this->email);
        });
    }
}