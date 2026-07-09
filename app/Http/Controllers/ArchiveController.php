<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function archive(){
        return view('admin.archives.archive');
    }

    public function create(){
        return view('admin.archives.create');
    }
}
