<!-- resources/views/exportPlanAula.blade.php -->
<table>
    <thead>
        <tr>
            <th>Curso</th>
            <th>Crédito</th>
            <th>Campo de Estudio</th>
            <th>Componente</th>
            <th>Semestre</th>
            <th>Tipo de Curso</th>
            <th>Resultados de Aprendizaje</th>
            <th>Objetivos Generales</th>
            <th>Objetivos Específicos</th>
            <th>Temas</th>
            <th>Evaluaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($courses as $course)
        <tr>
            <td>{{ $course->name_course }}</td>
            <td>{{ $course->credit }}</td>
            <td>{{ $studyfield->firstWhere('id', $course->study_field_id)->name_study_field ?? '' }}</td>
            <td>{{ $component->firstWhere('id', $course->component_id)->name_component ?? '' }}</td>
            <td>{{ $semester->firstWhere('id', $course->semester_id)->name_semester ?? '' }}</td>
            <td>{{ $coursetype->firstWhere('id', $course->course_type_id)->name_course_type ?? '' }}</td>
            <td>{{ $classroom->firstWhere('course_id', $course->id)->id_learning_result ?? '' }}</td>
            <td>{{ $generalobject->firstWhere('course_id', $course->id)->name_general_objective ?? '' }}</td>
            <td>{{ $specificobjetive->firstWhere('course_id', $course->id)->name_specific_objective ?? '' }}</td>
            <td>{{ $topics->firstWhere('course_id', $course->id)->description_topic ?? '' }}</td>
            <td>{{ $evaluations->firstWhere('course_id', $course->id)->name_evaluation ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
