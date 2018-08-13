<?php

namespace App\Http\Controllers;

use App\Repositories\EthereumRepository as Ethereum;

/**
 * 樂透遊戲範例
 */

class LotteryController extends Controller
{
    // 開獎
    public function pick_winner()
    {
        $result = [
            'status' => false,
            'msg'    => '',
        ];

        $result['msg'] = Ethereum::transaction(

            // 呼叫者錢包位址
            '0x234F9fdC73f0642348fbDe346f2239354b8F5169',

            // 被呼叫的合約或錢包位址
            '0xe494b324121c9b141d0995c1e5be37d6ce9287a6',

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
