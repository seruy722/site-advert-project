<?php

namespace Advert\Http\Controllers;
use Advert\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index($id){
        dd($id);
        return view('accounts.user.settings',['user'=>User::find($id)]);
    }
}
