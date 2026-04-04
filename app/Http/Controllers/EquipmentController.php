<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {

        $equipments = Equipment::all();


        return view('Equipments.index', compact('equipments'));
    }
}
