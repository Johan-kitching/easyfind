<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index()
    {
        return view('mechanic.index');
    }

//    public function store(Request $request)
//    {
//        $data = $request->validate([
//            'name' => ['required'],
//            'user_id' => ['required', 'exists:users'],
//            'description' => ['required'],
//        ]);
//
//        return Mechanic::create($data);
//    }
//
//    public function show(Mechanic $mechanic)
//    {
//        return $mechanic;
//    }
//
//    public function update(Request $request, Mechanic $mechanic)
//    {
//        $data = $request->validate([
//            'name' => ['required'],
//            'user_id' => ['required', 'exists:users'],
//            'description' => ['required'],
//        ]);
//
//        $mechanic->update($data);
//
//        return $mechanic;
//    }
//
//    public function destroy(Mechanic $mechanic)
//    {
//        $mechanic->delete();
//
//        return response()->json();
//    }
}
