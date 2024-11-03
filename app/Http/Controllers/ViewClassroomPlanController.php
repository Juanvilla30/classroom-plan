<?php

namespace App\Http\Controllers;

use App\Models\ClassroomPlan;
use App\Models\ProgramCourseRelationship;
use App\Models\Reference;
use App\Models\SpecificObjective;
use App\Models\Topic;
use Illuminate\Http\Request;

class ViewClassroomPlanController extends Controller
{
    public function index($id)
    {
        // Buscar el perfil de egreso por ID y cargar la relación program con su facultad
        $classroomInfo = ClassroomPlan::where("id", $id)
            ->with([
                'courses.component.studyField',
                'learningResult',
                'generalObjective',
                'state',
            ])->find($id);

        $courseId = ClassroomPlan::where('id', $id)
            ->get('id_course');

        $relationsInfo = ProgramCourseRelationship::where('id_course', $courseId)
            ->with([
                'program.faculty',
            ])->get();

        $programId = ProgramCourseRelationship::where('id_course', $courseId)
            ->get('id_program');

        

        $referencsInfo = Reference::where('id_classroom_plan', $id)
            ->orderBy('id')
            ->get();

        $specificInfo = SpecificObjective::where('id_classroom_plan', $id)
            ->orderBy('id')
            ->get();

        $specificId = SpecificObjective::where('id_classroom_plan', $id)
            ->get('id');

        $topicInfo = Topic::whereIn('id_specific_objective', $specificId)
            ->orderBy('id')
            ->get();

        // Pasar los datos a la vista
        return view('classroomPlan.editClassroomPlan', compact(
            'classroomInfo',
            'referencsInfo',
            'specificInfo',
            'topicInfo',
            'relationsInfo',
            'id'
        ));
    }
}
