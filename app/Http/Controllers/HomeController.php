<?php

namespace App\Http\Controllers;

use App\Repositories\EthereumRepository as Ethereum;
use App\User;
use Auth;
use Illuminate\Http\Request;

/**
 * 樂透遊戲範例
 */

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // 莊家
        $this->owner = User::where('is_owner', '1')->first();
    }

    /**
     * 樂透頁面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('home')->with([
                'balance'       => Ethereum::from_wei(base_convert(Ethereum::eth_getBalance(Auth::user()->ethereum_address), 16, 10)),
                'total_balance' => Ethereum::from_wei(base_convert(Ethereum::eth_getBalance($this->owner->contract['ethereum_address']), 16, 10)),
                'people'        => $this->count_players(),
            ]);

        } catch (ErrorException $e) {
            return $e->getMessage();
        }
    }

    // 下注
    public function enter(Request $request)
    {
        $result = [
            'status'        => false,
            'msg'           => '',
            'balance'       => 0,
            'people'        => 0,
            'total_balance' => 0,
        ];

        // 先解鎖帳號
        try {
            Ethereum::personal_unlockAccount(Auth::user()->ethereum_address, Auth::user()->ethereum_keycode);

        } catch (ErrorException $e) {
            $result['msg']           = $e->getMessage();
            $result['balance']       = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance(Auth::user()->ethereum_address), 16, 10));
            $result['people']        = $this->count_players();
            $result['total_balance'] = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance($this->owner->contract['ethereum_address']), 16, 10));
            return response()->json($result);
        }

        // 進行下注
        $result['msg'] = Ethereum::transaction(

            // 呼叫者錢包位址
            Auth::user()->ethereum_address,

            // 被呼叫的合約或錢包位址
            $this->owner->contract['ethereum_address'],

            // 下注金額 (單位:Wei)
            Ethereum::to_wei($request->input('value', 0)),

            // 呼叫合約方法名稱
            'enter',

            // 呼叫合約方法參數 [型態 => 值, 型態 => 值]
            []
        );

        $result['status']        = true;
        $result['balance']       = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance(Auth::user()->ethereum_address), 16, 10));
        $result['total_balance'] = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance($this->owner->contract['ethereum_address']), 16, 10));
        $result['people']        = $this->count_players();

        return response()->json($result);
    }

    // 取得玩家人數
    private function count_players()
    {
        $players = Ethereum::call(

            // 呼叫者錢包位址
            Auth::user()->ethereum_address,

            // 被呼叫的合約或錢包位址
            $this->owner->contract['ethereum_address'],

            // 要送的錢 (單位:Wei, 合約交易帶0)
            0,

            // 呼叫合約方法名稱
            'getPlayers',

            // 呼叫合約方法參數 [型態 => 值, 型態 => 值]
            []
        );

        return intval(explode('00000000000000000000000', $players)[4]);
    }

    // 莊家開獎
    public function pick_winner()
    {
        $result = [
            'status'        => false,
            'msg'           => '',
            'balance'       => 0,
            'people'        => 0,
            'total_balance' => 0,
        ];

        if (Auth::user()->is_owner == '1' && $this->count_players() > 0) {

            $result['msg'] = Ethereum::transaction(

                // 莊家錢包位址
                Auth::user()->ethereum_address,

                // 被呼叫的合約或錢包位址
                Auth::user()->contract['ethereum_address'],

                // 下注金額 (單位:Wei)
                0,

                // 呼叫合約方法名稱
                'pickWinner',

                // 呼叫合約方法參數 [型態 => 值, 型態 => 值]
                []
            );

            $result['status'] = true;
        }

        $result['balance']       = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance(Auth::user()->ethereum_address), 16, 10));
        $result['total_balance'] = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance(Auth::user()->contract['ethereum_address']), 16, 10));
        $result['people']        = $this->count_players();

        return response()->json($result);
    }
}
