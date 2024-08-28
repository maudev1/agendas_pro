<?php

namespace App\Http\Controllers;

use App\Http\Constants\Schedule;
use App\Http\Requests\ScheduleRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Schedule as ScheduleModel;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use DatePeriod;
use Exception;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PublicScheduleController extends Controller
{

    public function index($id)
    {
        $encodedUserId = $id;
        $userId = base64_decode($id);
        $user = User::get()->where('id', $userId);

        if ($user) {

            $store    = Store::where('user_id', '1')->first();
            $products = Product::all();

            return view('customer/index', compact("store", "user", "encodedUserId", "products"));
        }
    }


    public function getDate(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $userId  = base64_decode($request->user);
        $user    = User::get()->where('id', $userId);
        $date    = $request->date;

        if ($user) {

            // Falta implementar sistema de funcionarios para escolher a agenda individual do profissional

            $store    = Store::where('user_id', '1')->first();

            // dd($store);

            $officeHourStart  = new DateTime($store->office_hour_start);
            $officeHourEnd    = new DateTime($store->office_hour_end);

            $start_time    = $officeHourStart->format('H:i');
            $end_time      = $officeHourEnd->format('H:i');
            // $start_time    = $officeHourStart->getTimestamp();
            // $end_time      = $officeHourEnd->getTimestamp();

            // $duration      = 60; 
            // $interval      = $duration * 60;

           

            $scheduled = DB::table('schedules')
                ->where('user_id', '=', $userId)
                ->whereDate('start', $date)
                ->where('confirmation', '=', '1')
                ->get()->toArray();

            $scheduledHours = array_map(function ($s) {

                $hours = new DateTime($s->start);

                return $hours->format("H:i");

            }, $scheduled);

            $availableTime = [];
            $office_start_time = new DateTime($start_time);
            $office_end_time   = new DateTime($end_time);
            $duration          = new DateInterval('PT1H');

            for ($time = clone $office_start_time; $time < $office_end_time; $time->add($duration)) {
                $formatted_time = $time->format('H:i');
                if (!in_array($formatted_time, $scheduledHours)) {
                    $availableTime[] = $formatted_time;
                }
            }

            // while ($start_time <= $end_time) 
            // {
                
            //     date_default_timezone_set('America/Sao_Paulo');

            //     $hour = date("h:i", $start_time);
                

            //     if(!in_array($hour, $scheduledHours)){
                    
            //         $availableTime[] = $hour;
                    
            //     }
                
            //     $start_time += $interval;
            // }


            return response()->json([ "data" => ["availableTime" => $availableTime, "date" => $request->date]]);
        }
    }


    public function store(Request $request)
    {

        $date = new \DateTime;

        // try creates a new customer

        $customer = Customer::firstOrCreate(
            ['phone' =>  $request->customerPhone],
            ['name'  =>   $request->customerName, 'user_id' => '1']
        );

        if ($customer) {

          $schedule =  DB::table('schedules')->insertGetId([
                'title'       => $request->customerName,
                'customer_id' => $customer->id,
                'start'       => $request->hour,
                'end'         => $request->hour,
                'status'      => Schedule::PENDING,
                'created_at'  => $date,
                'products'    => json_encode($request->products),
                'notify'      => '1',
                'user_id'     => '1'
            ]);

            $total = 0;

            foreach($request->products as $product){

                $productModel = Product::find($product);

                if($productModel){

                    $total += intval($productModel->price);

                }


            }


            Transaction::create([
                'schedule'    => $schedule,
                'products'    => json_encode($request->products),
                'total_price' => $total,
                'payment_method' => $request->payment_method,
    
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Agendamento realizado com sucesso', 
                'schedule' => $schedule, 
                'customerId' => $customer->id], 200);
        }
    }

    public function getStatus($id)
    {

        $schedule = ScheduleModel::find($id)->toArray();

        return response()->json($schedule);
    }

    public function update(Request $request, $id)
    {

        $requestData = $request->json()->all();

        try {

            DB::table('schedules')->where('id', $id)->update($requestData);

            if($requestData['confirmation'] == '1'){

                $pushSubscribber = DB::table('push_subscriptions')
                ->where('subscribable_type', 'App\Models\Schedule')
                ->where('subscribable_id', $id)
                ->first();

                $notification = [
                    // current PushSubscription format (browsers might change this in the future)
                    // 'payload' => '{"title":"Confirmado!", "options":{"body" : "Agendamento Confirmado com successo"}}',
                    'payload' => json_encode([
                       'title'   => 'Confirmado!',
                        'options' => [
                            'body'    => 'Agendamento Confirmado com successo',
                            'icon'    => '/img/1.jpg',
                            'vibrate' => true,
                        ]
                    ]),
                    'subscription' => Subscription::create([
                        "endpoint" => $pushSubscribber->endpoint,
                        "keys" => [
                            'p256dh' => $pushSubscribber->public_key,
                            'auth' =>   $pushSubscribber->auth_token
                        ],
                    ]),
                ];

                $auth = [
                    'VAPID' => [
                        'subject' => 'mailto:me@website.com', // can be a mailto: or your website address
                        'publicKey' => env('VAPID_PUBLIC_KEY'),
                        'privateKey' => env('VAPID_PRIVATE_KEY')
                    ],
                ];


                $webPush = new WebPush($auth);

                // send multiple notifications with payload
                // foreach ($notifications as $notification) {
                $webPush->queueNotification(
                    $notification['subscription'],
                    $notification['payload'] // optional (defaults null)
                );

                foreach ($webPush->flush() as $report) {
                    $endpoint = $report->getRequest()->getUri()->__toString();
                
                    if ($report->isSuccess()) {
                        echo "[v] Message sent successfully for subscription {$endpoint}.";
                    } else {
                        // echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";

                        dd($report->getReason());
                    }
                }
                // }
            }

            return response()->json(['success' => true], 200);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 400);
        }
    }

    /**
     * 
     * Get products by array list
     * 
     * 
     */

    public function getProducts(Request $request)
    {

        $products = Product::whereIn('id', $request->products)->get()->toArray();

        return response()->json($products);
    }

    /**
     * 
     * Get products by array list
     * 
     * 
     */

    public function notification($id)
     {
 
         $notification = ScheduleModel::where('confirmation','=', '1')->where('id', '=',$id)->get();

         if($notification->count()){

            return response()->json(['success' => true, 'message' => 'Serviço confirmado!', 'data' => $notification]);

         }
 
        return response()->json([ 'success' => false, 'message' => 'Aguardando confirmação...' ]);
    }

    public function cancel($id)
    {

        $schedule = ScheduleModel::find($id);

        if($schedule){

            $schedule->status = Schedule::CANCELED;
            $schedule->save();

            return response()->json(["success" => true]);
        
        }else{
            
            return response()->json(["success" => true]);

        }

    }


}
