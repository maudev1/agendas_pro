<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    public function index(){

        $title = 'Agenda';

        return view('admin/schedule')->with('title', $title);
    }
    //
}
