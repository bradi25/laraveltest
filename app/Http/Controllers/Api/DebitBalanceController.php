<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
// use App\Models\Account;

class DebitBalanceController extends Controller
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

        // check if balance is enough
        if ($balance > 0) {
            // DB::table('accounts')->upsert(['user_id' => $request->input('user_id'), 'balance' => $balance - $request->input('amount')], ['user_id', 'balance']);
            //update or null insert
            DB::table('accounts')
                ->updateOrInsert(
                    ['user_id' => $request->input('user_id')],
                    ['balance' => $balance - $request->input('amount')],
                );
        } else {
            return response()->json([
                'message' => 'Insufficient balance.',
                'status' => '400',
            ]);
        }

        //insert to log_transaction
        DB::table('log_transaction')->insert([
            'name_transaction' => 'debit',
            'user_id' => $request->input('user_id'),
            'amount' => $request->input('amount'),
        ]);

        // return response()->json(['message' => 'Transaction successful.']);
        return response()->json([
            'message' => 'Transaction successful.',
            'status' => '200',
        ]);
    }
}
