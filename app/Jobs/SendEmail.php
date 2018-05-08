<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected  $email;
    protected  $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$content)
    {
        $this->email=$email;
        $this->content=$content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        Mail::raw('duilie test',function($message){
//            $message->to($this->email);
//        });
//        Mail::send('mail',['content'=> $this->content],function($message){
//            $message->to($this->email);
//            $message->subject('用户发表新的反馈，注意查看');
//        });
        Mail::raw($this->content,function($message){
          $message->from('hgg7758521@126.com','反馈信使');
           $message->subject('用户发表新的反馈，注意查看');
           $message->to('646017437@qq.com');
       });


        Log::info('发送'.$this->email);

    }
}
