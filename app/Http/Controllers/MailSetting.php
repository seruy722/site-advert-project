<?php

namespace Advert\Http\Controllers;
use Advert\Mail\MailClass;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Mail;
use Advert\User;
class MailSetting extends Controller
{
    public function sendMessage(Request $request){
        $this->validFields($request);
        $user = User::where('id',$request->user_id)->first();
        $name = $request->user_name;
        $message = $request->message;
        $advertTitle = $request->advert_title;
        Mail::to($user->email)->send(new MailClass($advertTitle,$name,$message));
        return redirect()->route('view',$request->advert_id);
    }

    public function validFields($req, $id = '')
    {
        $this->validate($req, [
            'message' => 'required|min:2|string|max:255',
        ]);
    }
}
