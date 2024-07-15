<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use CreatePushSubscriptionsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use NotificationChannels\WebPush\PushSubscription;

class PushController extends Controller
{



    public function push(Request $request)
    {

        $clientSidePushSubscriptionJSON = $request->except('customer');

        $subscription = Subscription::create(json_decode(json_encode($clientSidePushSubscriptionJSON), true));

        $notification = [
            // current PushSubscription format (browsers might change this in the future)
            'subscription' => $subscription,
            'payload' => '{"title":"teste", "options":{"body" : "Apenas um teste"}}',
        ];


        $webPush = new WebPush();

        // send multiple notifications with payload
        // foreach ($notifications as $notification) {
        $webPush->queueNotification(
            $notification['subscription'],
            $notification['payload'] // optional (defaults null)
        );
        // }


        foreach ($webPush->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();

            if ($report->isSuccess()) {
                echo "[v] Message sent successfully for subscription {$endpoint}.";
            } else {
                echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
            }
        }

        /**
         * send one notification and flush directly
         */
        $report = $webPush->sendOneNotification(
            $notification['subscription'],
            $notification['payload'], // optional (defaults null)
        );
    }

    public function store(Request $request)
    {
        $schedule = Schedule::find($request->schedule);

        $push =  DB::table('push_subscriptions')->updateOrInsert(
            ['endpoint' => $request->pushSubscription['endpoint']],
            
            [   
                'subscribable_type'  => 'App\Models\Schedule',
                'subscribable_id'    => $schedule->id,
                'endpoint'           => $request->pushSubscription['endpoint'],
                'public_key'         => $request->pushSubscription['keys']['p256dh'],
                'auth_token'         => $request->pushSubscription['keys']['auth']
            
            ]);


    }

    // public function store(Request $request)
    // {

    //     dd($request->all());

    //     $this->validate($request, [
    //         'endpoint'    => 'required',
    //         'keys.auth'   => 'required',
    //         'keys.p256dh' => 'required'
    //     ]);
    //     $endpoint = $request->endpoint;
    //     $token = $request->keys['auth'];
    //     $key = $request->keys['p256dh'];

    //     // $customer = Customer::find($request->customer_id);
    //     // $customer->updatePushSubscription($endpoint, $key, $token);

    //     $user = User::find(1);

    //     $user->updatePushSubscription($endpoint, $key, $token);

    //     return response()->json(['success' => true], 200);
    // }
}
