<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{

    public function index()
    {

        $title = 'Agenda';

        return view('admin/schedule')->with('title', $title);
    }

    public function getAll()
    {

        $schedules = DB::table('schedule')->get();
        return response()->json($schedules);
    }

    public function store(Request $request)
    {

        foreach ($request->json()->all() as $event) {

            $errors = $this->validation($event);

            if (empty($errors)) {

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

                return response()->json(['message'=>'Agendamento realizado com sucesso'], 200);

            }else{

                return response()->json($errors, 401);

            }

        }

    }

    public function validation($data)
    {

        $errors = [];

        if (!$data['title']) {
            $errors[] = ['error' => 'Preecha o titulo!'];
        }

        if (!$data['hour']) {
            $errors[] = ['error' => 'Preecha o horário!'];

        }

        return $errors;


    }

}