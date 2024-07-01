<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Schedule;
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

        $userId = base64_decode($request->user);
        $user    = User::get()->where('id', $userId);
        $date    = $request->date;

        if ($user) {

            $store    = Store::where('user_id', $userId)->first();


            // dd($store->office_hour_end);

            $officeHourStart  = new DateTime($store->office_hour_start);
            $officeHourEnd    = new DateTime($store->office_hour_end);
            $officeHourEnd    = $officeHourEnd->sub(new DateInterval('PT1H'));
        
            $interval         = new DateInterval('PT1H');
            $period           = new DatePeriod($officeHourStart, $interval, $officeHourEnd->add($interval));

            $scheduled = DB::table('schedules')
            ->where('user_id', '=', $userId)
            ->where('confirmation', '<>', '1')
            ->whereDate('start', $date)->get()->toArray();


            $scheduledHours = array_map(function ($s) {

                $hours = new DateTime($s->start);

                return $hours->format("H:i");

            }, $scheduled);

            // dd($scheduledHours);

            $availableHours            = [];

            foreach ($period as $p) {

                $hour = $p->format('H:i');

                if (!in_array($hour, $scheduledHours)) {

                    $availableHours[] = $hour;
                }
            }


            return response()->json($availableHours);
        }
    }

    public function store(ScheduleRequest $request)
    {

        // dd($request);    

        $date = new \DateTime;

        DB::table('schedules')->insert([
            // 'title'       => $request->title,
            'title'       => $request->customerName,
            // 'customer_id' => $request->customer_id,
            'customer_id' => '1',
            'start'       => $request->hour,
            'end'         => $request->hour,
            'created_at'  => $date,
            // 'notify'      => (isset($event['notify']) ? 1 : 0),
            'notify'      => '1',
            'user_id'     => '1'
        ]);

        return response()->json(['success' => true, 'message' => 'Agendamento realizado com sucesso'], 200);
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
}
