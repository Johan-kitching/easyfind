<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class TransporterController extends Controller
{
    public function index()
    {
        return view('transporter.index');
    }

}
