<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Store;
use App\Models\Transaction;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{

    public function index()
    {

        $title = 'Agenda';
        $customers = Customer::all();
        $products  = Product::all(); 
        $userId    = Auth::id();
        $shareurl  = $this->urlGenerate();
        $store     = Store::first(); 

        return view('admin/schedule', compact('products', 'userId', 'title', 'shareurl', 'customers', 'store'));

    }

    public function getAll($userId)
    {

        $schedules = DB::table('schedules')->where('user_id', $userId)->get();
        return response()->json($schedules);
    }

    public function getOne($id)
    {

        
        $schedule = Schedule::find($id);
        $services = $schedule->transaction->services;
        $products = $schedule->transaction->products;

        if($services){
            $serviceList = Service::whereIn('id', json_decode($services))->get();
        }

        if($products){
            $productList = Product::whereIn('id', json_decode($products))->get();
        }

        $paymentMethod = [
            '1' => 'PIX', 
            '2' => 'Cartão', 
            '3' => 'Dinheiro', 
            '4' => 'Cortesia', 

        ];
    
        return response()->json([
            'schedule' => $schedule,
            'products' => isset($productList) ? $productList : null,
            'services' => isset($serviceList) ? $serviceList : null,
            'customer' => $schedule->customer,
            'paymentMethod' =>  $paymentMethod[$schedule->transaction->payment_method]
        ]);

    }

    public function store(ScheduleRequest $request)
    {

        $date = new \DateTime;

       $id = DB::table('schedules')->insertGetId([
            'title' => $request->title,
            'customer_id' => $request->customer_id,
            'start' => $request->start,
            'end' => $request->start,
            'products' => json_encode($request->products),
            'status' => '1',
            'confirmation' => '1',
            'created_at' => $date,
            'notify' => (isset($event['notify']) ? 1 : 0),
            'user_id' => Auth::id()
        ]);

        if($id){

            $total = 0;

            foreach($request->products as $product){

                $productModel = Product::find($product);

                if($productModel){

                    $total += intval($productModel->price);

                }


            }

            Transaction::create([
                'schedule'    => $id,
                'products'    => json_encode($request->products),
                'total_price' => $total,
                'payment_method' => $request->payment_method,
    
            ]);

            return response()->json(['message' => 'Agendamento realizado com sucesso'], 200);
        }

    }

    public function update(Request $request, $id)
    {

        $requestData = $request->json()->all();

        if (empty($this->validation($requestData))) {

            $date = new \DateTime;

            $expected = array_merge($requestData, ['updated_at' => $date]);

            try {

                DB::table('schedules')->where('id', $id)->update($expected);

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

        $results = DB::table('schedules')->where('id', $id)->delete();

        if ($results) {

            return response()->json(['message' => 'Deletado com sucesso!', 200]);

        }


    }

    function urlGenerate()
    {

        if (Auth::check()) {
            $store = Auth::user()->store;
            $host = $_SERVER['HTTP_HOST'];
            $crypt = base64_encode($store);

            $url_encode = urlencode("{$crypt}");

            return "http://{$host}/schedule/{$url_encode}";


        }


    }


}