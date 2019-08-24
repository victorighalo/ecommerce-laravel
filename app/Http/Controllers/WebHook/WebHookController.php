<?php

namespace App\Http\Controllers;


use App\Transactions;
use App\User;
use Illuminate\Http\Request;
use DB;
class WebHookController extends Controller
{
    public function PaystackWebhook(Request $request){
        //Log
        DB:table('logs')->insert(
            ['data' => json_encode($request->all())]
        );
        $signature = (isset($_SERVER['HTTP_X_PAYSTACK_SIGNATURE']) ? $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] : '');
        $body = @file_get_contents("php://input");

        if ((strtoupper($request->getMethod()) != 'POST' ) || $signature == '' ){
            exit();
        }

        if($signature !== hash_hmac('sha512', $body, config('app.ps_key'))){
            $file = fopen(base_path()."/log.txt","w+");
            fwrite($file, "Failed second");
            fclose($file);
            exit();
        }

        http_response_code(200);

        try{
            switch($request->event){
                // charge.success
                case 'charge.success':
                    //Save transaction
                    $trans = Transactions::where('reference', $request->data['reference']);
                    $trans->update(
                        ['status' => $request->data['status'],
                            'message' => $request->data['message'],
                            'reference' => $request->data['reference'],
                            'amount' => $request->data['amount'],
                            'currency' => $request->data['currency'],
                            'authorization' => json_encode($request->data['authorization']),
                            'channel' => $request->data['channel'],
                            'ip_address' => $request->data['ip_address'],
                            'log' => json_encode($request->data['log']),
                            'customer' => json_encode($request->data['customer']),
                            'plan' => json_encode($request->data['plan']),
                            'fees' => $request->data['fees'],
                            'gateway_response' => $request->data['gateway_response'],
                        ]
                    );

                    $user_data = $trans->select('user_id')->first();
                    $user = User::where('id', $user_data->user_id)->first();
                    $user->deposit( ($request->data['amount'] / 100), 'deposit');


                    break;
            }
        }catch (\Exception $e){
//            $file = fopen(base_path()."/log.txt","a");
//            fwrite($file, date('Y/m/d') . " Error Log Payment - \n");
//            fwrite($file,$e->getMessage());
//            fwrite($file,$e->getTraceAsString());
//            fwrite($file,$e->getLine() );
//            fclose($file);

        }
        exit();

    }
}
