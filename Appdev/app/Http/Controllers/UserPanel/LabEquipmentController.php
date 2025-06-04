<?php

namespace App\Http\Controllers\UserPanel;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Lab;
use App\Models\Equipment;

class LabEquipmentController extends Controller
{
    public function index()
    {
        $labs = Lab::select('id', 'name', 'description', 'image')->get();
        $equipment = Equipment::select('id', 'name', 'description', 'image')->get();
 
        return Inertia::render('user/LabsAndEquipment', [
            'labs' => $labs,
            'equipment' => $equipment, 
        ]);
    }
}