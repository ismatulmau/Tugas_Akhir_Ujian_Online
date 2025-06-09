<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalUjianController extends Controller
{
    public function index()
    { 
        return view('admin.status-tes.jadwal-ujian.index'); 
    }
}
