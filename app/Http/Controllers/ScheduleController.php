<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{

    public function index()
    {

        $title = 'Agenda';
        $customers = Customer::all();

        $userId = Auth::id();

        return view('admin/schedule')
            ->with('userId', $userId)
            ->with('title', $title)
            ->with('shareurl', $this->urlGenerate())
            ->with('customers', $customers);
    }

    public function getAll($userId)
    {

        $schedules = DB::table('schedule')->where('user_id', $userId)->get();
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $results = [];
        if ($request) {
            $event = $request->json()->all();

            return response()->json($event);
            if (empty($this->validation($event))) {

                
                try {

                    $date = new \DateTime;

                    DB::table('schedule')->insert([
                        'title' => $event['title'],
                        'customer_id' => $event['customer_id'],
                        'start' => $event['start'],
                        'end' => $event['start'],
                        'created_at' => $date,
                        'notify' => (isset($event['notify']) ? 1 : 0),
                        'user_id' => Auth::id()
                    ]);

                    return response()->json(['message' => 'Agendamento realizado com sucesso'], 200);

                } catch (Exception $error) {
                    return response($error->getMessage(), 400)->header('Content-Type', 'text/json');

                }
            } else {
                $results = array_merge($this->validation($event), $results);

                return response()->json($results, 400);

            }


        }

    }

    public function update(Request $request, $id)
    {

        $requestData = $request->json()->all();

        if (empty($this->validation($requestData))) {

            $date = new \DateTime;

            $expected = array_merge($requestData, ['updated_at' => $date]);

            try {

                DB::table('schedule')->where('id', $id)->update($expected);

                return response()->json(['message' => 'Agendamento atualizado com sucesso!'], 200);

            } catch (Exception $error) {
                return response()->json(['message' => $error->getMessage()], 400);

            }

        }

    }

    public function validation($data)
    {
        $errors = [];


        if (array_key_exists('title', $data)) {
            if (!$data['title'] || $data['title'] == "") {

                $errors[] = ['message' => 'Preecha o titulo!', 'code' => 400];
            }
        }

        if (array_key_exists('customer_id', $data)) {
            if (!$data['customer_id']) {
                $errors[] = ['message' => 'Escolha um cliente!', 'code' => 400];
            }
        }

        return $errors;


    }

    public function delete($id)
    {

        $results = DB::table('schedule')->where('id', $id)->delete();

        if ($results) {

            return response()->json(['message' => 'Deletado com sucesso!', 200]);
            
        }


    }

    function urlGenerate()
    {

        if (Auth::check()) {

            $user = Auth::user()->id;
            $host = $_SERVER['HTTP_HOST'];
            $crypt = base64_encode($user);

            $url_encode = urlencode("schedule/{$crypt}");
            
            return "http://{$host}/{$url_encode}";


        }


    }

}