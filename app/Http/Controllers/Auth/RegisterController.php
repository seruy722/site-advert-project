<?php

namespace Advert\Http\Controllers\Auth;

use Advert\Http\Controllers\Controller;
use Advert\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    // protected function redirectTo()
    // {
    //     return view('accounts.user.home');
    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:2|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'surname' => 'required|min:2|string|max:255',
            'phone' => 'digits:10|unique:users',
        ], [
            'phone.unique' => 'Такой телефон уже существует',
            'phone.digits' => 'Телефон должен состоять из 10 цифр',
            'name.required' => 'Поле Имя обязательное для заполнения',
            'name.min' => 'Поле Имя должно содержать более 2 символов',
            'name.max' => 'Поле Имя не может быть больше 255 символов',
            'email.required' => 'Поле Email обязательное для заполнения',
            'email.email' => 'Некорректный email адрес',
            'email.max' => 'Поле Email не может быть больше 255 символов',
            'email.unique' => 'Такой Email уже зарегестрирован',
            'password.required' => 'Поле Password обязательное для заполнения',
            'password.min' => 'Пароль должен составлять более 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'surname.required' => 'Поле Фамилия обязательное для заполнения',
            'surname.min' => 'Поле Фамилия должно содержать более 2 символов',
            'surname.max' => 'Поле Фамилия не может быть больше 255 символов',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Advert\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'surname' => $data['surname'],
        ]);
    }
}
