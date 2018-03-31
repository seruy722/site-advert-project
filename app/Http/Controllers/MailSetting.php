<?php

namespace Advert\Http\Controllers;
use Advert\Mail\MailClass;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Mail;

class MailSetting extends Controller
{
    public function sendMessage(Request $request){
        $name = $request->user_name;
        $message = $request->message;
        Mail::to('seruy722@gmail.com')->send(new MailClass($name,$message));
    }
}
