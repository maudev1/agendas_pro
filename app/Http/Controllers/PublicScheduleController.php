<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use DatePeriod;
use Exception;

class PublicScheduleController extends Controller
{

    public function index($id)
    {
        $encodedUserId = $id;
        $userId = base64_decode($id);
        $user = User::get()->where('id', $userId);

        if ($user) {

            $store    = Store::where('user_id', $userId)->first();
            $products = Product::all();

            return view('customer/index', compact("store", "user", "encodedUserId", "products"));
        }
    }


    public function getDate(Request $request)
    {

        $userId  = base64_decode($request->user);
        $user    = User::get()->where('id', $userId);
        $date    = $request->date;

        if ($user) {

            $store    = Store::where('user_id', $userId)->first();

            $officeHourStart  = new DateTime($store->office_hour_start);
            $officeHourEnd    = new DateTime($store->office_hour_end);

            $start_time    = $officeHourStart->getTimestamp();
            $end_time      = $officeHourEnd->getTimestamp();

            $duration      = 60; // Mock duration
            $interval      = $duration * 60;

            $availableHours = [];

            $scheduled = DB::table('schedules')
                ->where('user_id', '=', $userId)
                ->whereDate('start', $date)
                ->where('confirmation', '=', '1')
                ->get()->toArray();

            $scheduledHours = array_map(function ($s) {

                $hours = new DateTime($s->start);

                return $hours->format("H:i");

            }, $scheduled);


            while ($start_time <= $end_time) 
            {
                $hour = date("h:i", $start_time);

                if(!in_array($hour, $scheduledHours)){
                    
                    $availableHours[] = $hour;
                    
                }
                
                $start_time += $interval;
            }


            return response()->json($availableHours);
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
                'created_at'  => $date,
                'products'    => json_encode($request->products),
                'notify'      => '1',
                'user_id'     => '1'
            ]);

            return response()->json(['success' => true, 'message' => 'Agendamento realizado com sucesso', 'schedule' => $schedule], 200);
        }
    }

    public function getStatus($id)
    {

        $schedule = Schedule::find($id)->toArray();

        return response()->json($schedule);
    }

    public function update(Request $request, $id)
    {

        $requestData = $request->json()->all();

        try {

            DB::table('schedules')->where('id', $id)->update($requestData);

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
 
         $notification = Schedule::where('confirmation','=', '1')->where('notification_submitted', '<>', '1')->where('id', '=',$id)->get();

         if($notification->count()){

            $notification->notification_submitted = '1';
            $notification->save();

            return response()->json(['success' => true, 'message' => 'Serviço confirmado!']);

         }
 
        return response()->json([ 'success' => false, 'message' => 'Aguardando confirmação...' ]);
     }


}
