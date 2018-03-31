<?php

namespace Advert\Http\Controllers;
use Advert\Advert;
use Advert\Comment;
use Advert\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function userHome($id)
    {
        return view('accounts.user.home',['adverts' => Advert::where('user_id', $id)->get(),'comments'=>Comment::get()]);
    }

    public function settingsAccounts($id)
    {
        return view('accounts.user.settings',['user'=>User::find($id)]);
    }

    public function updateAccounts(Request $request)
    {
        $res = $request->all();
        if($res['password']){
            $res['password'] = bcrypt($res['password']);
            unset($res['_token'],$res['password_confirmation'],$res['role']);
            User::where('id',$request->id)->update($res);
        }else{
            User::where('id',$request->id)->update($request->except('_token','password','password_confirmation','role'));
        }
        if(isset($request->role)){
            return redirect()->route('accounts.admin.users');
        }else{
            return redirect()->route('accounts.user.settings',$request->id);
        }
        
    }

    public function edit($id,$userId)
    {
        return view('accounts.admin.edit',['user'=>User::where('id',$id)->first()]);
    }

    public function users()
    {
        return view('accounts.admin.users',['users'=>User::where('role','user')->where('blocked',false)->get()]);
    }

    public function adminHome()
    {
        return view('accounts.admin.home',['adverts' => Advert::where('active', false)->get(),'comments'=>Comment::get()]);
    }

    public function deleteUser($id)
    {
        User::where('id',$id)->delete();
        return redirect()->route('accounts.admin.users');
    }
    public function createUser(Request $request)
    {
        if ($request->isMethod('post')) {
            User::create([
                'name'=>$request->name,
                'surname'=>$request->surname,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'password'=>bcrypt($request->password)
            ]);
            return view('accounts.admin.create');
        }else{
            return view('accounts.admin.create');
        } 
    }

    public function blocked($id)
    {
        User::where('id', $id)->update(['blocked' => true]);
        return redirect()->route('accounts.admin.users');
    }

    public function blokedList()
    {
        return view('accounts.admin.blockedList',['list'=>User::where('blocked',true)->get()]);
    }

    public function unBloked($id)
    {
        User::where('id', $id)->update(['blocked' => false]);
        return redirect()->route('accounts.admin.blokedList');
    }
}