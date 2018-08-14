<?php

namespace App\Http\Controllers;

use App\Repositories\EthereumRepository as Ethereum;

/**
 * 樂透遊戲範例
 */

class LotteryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // 莊家錢包位址
        $this->owner_address = '0x66af7003B2265Da21515BC85336751eaf43c2948';

        // 被呼叫的合約或錢包位址
        $this->contract_address = '0x52084e373189586bc7b3e21a552deffd8a1d9b66';
    }

    // 開獎
    public function pick_winner()
    {
        $result = [
            'status' => false,
            'msg'    => '',
        ];

        $result['msg'] = Ethereum::transaction(

            // 莊家錢包位址
            $this->owner_address,

            // 被呼叫的合約或錢包位址
            $this->contract_address,

            // 下注金額 (單位:Wei)
            0,

            // 呼叫合約方法名稱
            'pickWinner',

            // 呼叫合約方法參數 [型態 => 值, 型態 => 值]
            []
        );

        $result['status'] = true;

        return response()->json($result);
    }
}
