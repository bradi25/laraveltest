<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class CheckBalanceController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //check balance
        $balance = DB::table('accounts')->where('user_id', $request->input('user_id'))->value('balance');

        //check log_transaction
        $log_transaction = DB::table('log_transaction')->where('user_id', $request->input('user_id'))->get();
        return response()->json([
            'balance' => $balance,
            'log_transaction' => $log_transaction,
        ]);
    }
}
