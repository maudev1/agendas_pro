<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use TheSeer\Tokenizer\Exception;

class ScheduleController extends Controller
{

    public function index()
    {

        $title = 'Agenda';
        $customers = Customer::all();

        return view('admin/schedule')
            ->with('title', $title)
            ->with('customers', $customers);
    }

    public function getAll()
    {

        $schedules = DB::table('schedule')->get();
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $results = [];
        if ($request) {
            $requestJson = $request->json()->all();
            if (empty($this->validation($requestJson))) {
                foreach ($requestJson as $event) {
                    try {

                        $date = new \DateTime;

                        DB::table('schedule')->insert([
                            'title' => $event['title'],
                            'customer_id' => $event['customer_id'],
                            'start' => $event['start'],
                            'end' => $event['start'],
                            'hour' => $event['hour'],
                            'created_at' => $date,
                            'notify' => (isset($event['notify']) ? 1 : 0),
                            'user_id' => '2',
                        ]);

                        return response()->json(['message' => 'Agendamento realizado com sucesso'], 200);

                    } catch (Exception $error) {


                        return response($error->getMessage(), 400)->header('Content-Type', 'text/json');

                    }

                }
            } else {
                $results = array_merge($this->validation($requestJson), $results);

                return response($results, 400)->header('Content-Type', 'text/json');
            }


        }

    }

    public function validation($data)
    {
        $errors = [];


        if (!$data[0]['title']) {

            $errors[] = ['message' => 'Preecha o titulo!', 'code' => 400];

        }

        if(!$data[0]['hour']){
            $errors[] = ['message' => 'Preecha o horário!', 'code' => 400];

        }

        if (!$data[0]['customer_id']) {
            $errors[] = ['message' => 'Escolha um cliente!', 'code' => 400];

        }

        return $errors;


    }

}