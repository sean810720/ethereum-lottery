<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\EthereumRepository as Ethereum;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        // 莊家
        $this->owner = User::where('is_owner', '1')->first();
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
            'name'             => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:users',
            'password'         => 'required|string|min:6|confirmed',
            'ethereum_keycode' => 'required|string|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        try {

            // 新玩家錢包地址
            $ethereum_address = Ethereum::personal_newAccount($data['ethereum_keycode']);

            // 新用戶每人送 1 Eth
            Ethereum::transaction(

                // 莊家錢包位址
                $this->owner['ethereum_address'],

                // 目標錢包位址
                $ethereum_address,

                // 要送的錢 (單位:Wei)
                Ethereum::to_wei(1)
            );

            return User::create([
                'name'             => $data['name'],
                'email'            => $data['email'],
                'password'         => Hash::make($data['password']),
                'ethereum_keycode' => $data['ethereum_keycode'],
                'ethereum_address' => $ethereum_address,
            ]);

        } catch (ErrorException $e) {

            return User::create([
                'name'             => $data['name'],
                'email'            => $data['email'],
                'password'         => Hash::make($data['password']),
                'ethereum_keycode' => $data['ethereum_keycode'],
                'ethereum_address' => $ethereum_address,
            ]);
        }
    }
}
