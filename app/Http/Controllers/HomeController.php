<?php

namespace App\Http\Controllers;

use App\Repositories\EthereumRepository as Ethereum;
use Auth;
use Illuminate\Http\Request;

/**
 * 樂透遊戲範例
 */

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
    public function index()
    {
        try {
            $balance = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance(Auth::user()->address), 16, 10));
            $people  = $this->get_players();
            return view('home', compact('balance', 'people'));

        } catch (ErrorException $e) {
            return $e->getMessage();
        }
    }

    // 下注
    public function enter(Request $request)
    {
        $result = [
            'status'  => false,
            'msg'     => '',
            'balance' => 0,
            'people'  => 0,
        ];

        // 解鎖帳號
        try {
            Ethereum::personal_unlockAccount(Auth::user()->address, Auth::user()->phrase);

        } catch (ErrorException $e) {
            $result['msg']     = $e->getMessage();
            $result['balance'] = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance(Auth::user()->address), 16, 10));
            return response()->json($result);
        }

        // 進行下注
        $result['msg'] = Ethereum::transaction(

            // 呼叫者錢包位址
            Auth::user()->address,

            // 被呼叫的合約或錢包位址
            '0xe494b324121c9b141d0995c1e5be37d6ce9287a6',

            // 下注金額 (單位:Wei)
            Ethereum::to_wei($request->input('value', 0)),

            // 呼叫合約方法名稱
            'enter',

            // 呼叫合約方法參數 [型態 => 值, 型態 => 值]
            []
        );

        $result['status']  = true;
        $result['balance'] = Ethereum::from_wei(base_convert(Ethereum::eth_getBalance(Auth::user()->address), 16, 10));
        $result['people']  = $this->get_players();
        return response()->json($result);
    }

    private function get_players()
    {
        $players = Ethereum::call(

            // 呼叫者錢包位址
            Auth::user()->address,

            // 被呼叫的合約或錢包位址
            '0xe494b324121c9b141d0995c1e5be37d6ce9287a6',

            // 要送的錢 (單位:Wei, 合約交易帶0)
            0,

            // 呼叫合約方法名稱
            'getPlayers',

            // 呼叫合約方法參數 [型態 => 值, 型態 => 值]
            []
        );

        return intval(explode('00000000000000000000000', $players)[4]);
    }
}
