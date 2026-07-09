<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function audit(){
        return view('admin.audit.audit');
    }
}
