<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
// use App\Models\Account;

class CreditBalanceController extends Controller
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

        //update or insert
        DB::table('accounts')
            ->updateOrInsert(
                ['user_id' => $request->input('user_id')],
                ['balance' => $balance + $request->input('amount')],
            );

        //insert to log_transaction
        DB::table('log_transaction')->insert([
            'name_transaction' => 'credit',
            'user_id' => $request->input('user_id'),
            'amount' => $request->input('amount'),
        ]);

        return response()->json([
            'message' => 'Transaction successful.',
            'status' => '200',
        ]);
    }
}
