<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function store(Request $request){
        $data = [];
        try {

            $email = $request->input('email');

            $customer = User::firstOrNew(['email'=>$email]);
            $customer->name            = $request->input('name');
            $customer->email           = $request->input('email');
            $customer->is_subscribed    = 1;
            $customer->password        = bcrypt(mt_rand(100000, 999999));
            $customer->remember_token  = md5(uniqid(mt_rand(), true));

            $customer->save();

            $subscription = new Subscription();

            $currntTime= Carbon::now();
            $subscription->user_id                      = $customer->id;
            $subscription->subscription_activation_date = $currntTime;
            $subscription->subscription_end_date        = Carbon::parse($currntTime)->addDays( 365- 1)->endOfDay()->format('Y-m-d H:i:s');;
            $subscription->is_active                    = 0;
            $subscription->save();



            $data['customer'] =   [
                'name'=>$customer->name,
                'email'=>$customer->email,
            ];
            $data['subscription'] =   [
                'subscription_activation_date'=>$subscription->subscription_activation_date,
                'subscription_end_date'=>$subscription->subscription_end_date,
            ];

            $data['status']         =   'success';
            $data['status_code']    =   200;
            $data['message']        =   'This data store successfully';

        } catch (\Exception $e) {
            $data['status_code']    = 400;
            $data['status']         = "error";
            $data['error']          = [
                'message'   => $e->getMessage()
            ];

        } finally {
            return response()->json($data);
        }

    }
}
