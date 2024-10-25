<?php

namespace App\Http\Controllers;

use App\Models\ClassroomPlan;
use Illuminate\Http\Request;

class ListClassroomPlanController extends Controller
{
    // Método para manejar solicitudes GET
    public function index()
    {

        $classroom = ClassroomPlan::orderBy('id')->get();

        return view('classroomPlan.listClassroomPlan', compact('classroom'));
    }
}
