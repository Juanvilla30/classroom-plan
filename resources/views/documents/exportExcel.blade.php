<table>
    <thead>
        <tr>
            <th>Codigo curso</th>
            <th>Curso</th>
            <th>Campo</th>
            <th>Componete</th>
            <th>Semestre</th>
            <th>Creditos</th>
            <th>Tipo curso</th>
            <th>Resultado de aprendizaje</th>
            <th>Objetivo general</th>
            @for ($i = 1; $i <= 3; $i++)
                <th>Objetivo específico {{ $i }}</th>
                @endfor
            @for ($i = 1; $i <= 16; $i++)
                <th>Tema semana {{ $i }}</th>
            @endfor
            @foreach ($percentages as $percentage)
                <th>{{ $percentage->name_percentage }}</th>
            @endforeach
            <th>Docente</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($classrooms as $classroom)
        <tr>
            <td>{{ $classroom->relations->course->course_code }}</td>
            <td>{{ $classroom->relations->course->name_course }}</td>
            <td>{{ $classroom->relations->course->component->studyField->name_study_field }}</td>
            <td>{{ $classroom->relations->course->component->name_component }}</td>
            <td>{{ $classroom->relations->course->semester->name_semester }}</td>
            <td>{{ $classroom->relations->course->credit }}</td>
            <td>{{ $classroom->relations->course->courseType->name_course_type }}</td>
            <td>{{ $classroom->learningResult->description_learning_result }}</td>
            <td>{{ $classroom->generalObjective->description_general_objective }}</td>
            @foreach ($specifics as $specific)
            <td>{{ $specific['description_specific_objective']}}</td>
            @endforeach
            @foreach ($topics as $topic)
            <td>{{ $topic['description_topic']}}</td>
            @endforeach
            @foreach ([1, 2, 3] as $id)
            <td>
                @foreach ($evaluationss as $evaluations)
                @if ($evaluations['id_percentage'] == $id)
                {{ $evaluations['evaluation']['name_evaluation'] }} - {{ $evaluations['percentage_number']}}% <br>
                @endif
                @endforeach
            </td>
            @endforeach
            <td>{{ $classroom->relations->course->user->name }} {{ $classroom->relations->course->user->last_name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>