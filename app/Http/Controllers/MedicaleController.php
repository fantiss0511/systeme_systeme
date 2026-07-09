<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicaleController extends Controller
{
    public function medicale(){
        return view('admin.medicales.medicale');
    }

    public function create(){
        return view('admin.medicales.create');
    }
}
