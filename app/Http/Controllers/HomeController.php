<?php

namespace Advert\Http\Controllers;

use Advert\Advert;
use Advert\Comment;
use Advert\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ValidatesRequests;
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
        return view('accounts.user.home', ['adverts' => Advert::where('user_id', $id)->paginate(15), 'comments' => Comment::get()]);
    }

    public function settingsAccounts($id)
    {
        return view('accounts.user.settings', ['user' => User::find($id)]);
    }

    public function updateAccounts(Request $request)
    {
        $this->validFields($request, $request->id);
        $res = $request->all();
        if ($res['password']) {
            $res['password'] = bcrypt($res['password']);
            unset($res['_token'], $res['password_confirmation'], $res['role']);
            User::where('id', $request->id)->update($res);
        } else {
            User::where('id', $request->id)->update($request->except('_token', 'password', 'password_confirmation', 'role'));
        }
        if (isset($request->role)) {
            return redirect()->route('accounts.admin.users');
        } else {
            return redirect()->route('accounts.user.settings', $request->id);
        }

    }

    public function edit($id, $userId)
    {
        return view('accounts.admin.edit', ['user' => User::where('id', $id)->first()]);
    }

    public function users()
    {
        return view('accounts.admin.users', ['users' => User::where('role', 'user')->where('blocked', false)->orderBy('id', 'desc')->paginate(15)]);
    }

    public function adminHome()
    {
        return view('accounts.admin.home', ['adverts' => Advert::where('active', false)->orderBy('id', 'desc')->paginate(15), 'comments' => Comment::get()]);
    }

    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('accounts.admin.users');
    }
    public function createUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validFields($request);
            User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return view('accounts.admin.create');
        } else {
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
        return view('accounts.admin.blockedList', ['list' => User::where('blocked', true)->paginate(15)]);
    }

    public function unBloked($id)
    {
        User::where('id', $id)->update(['blocked' => false]);
        return redirect()->route('accounts.admin.blokedList');
    }

    public function validFields($req, $id = '')
    {

        if (!$id) {
            $this->validate($req, [
                'name' => 'required|min:2|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|max:255|confirmed',
                'surname' => 'required|min:2|string|max:255',
                'phone' => 'digits:10|unique:users',
            ]);
        } else {
            $this->validate($req, [
                'name' => 'required|min:2|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'surname' => 'required|min:2|string|max:255',
                'phone' => 'digits:10|unique:users,phone,' . $id,
            ]);
        }

    }
}
