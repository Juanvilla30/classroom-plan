@php
    $campoMostrado = false;
@endphp
<table>
    <thead>
        <tr>
            <th>Codigo curso</th>
            <th>Curso</th>
            @foreach ($classrooms as $classroom)
            @if($classroom['relations']['course']['component'] !== null && !$campoMostrado)
                <th>Campo</th>
                <th>Componente</th>
                @php
                    $campoMostrado = true;
                @endphp
            @endif
            @endforeach
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
                    <th>{{ ucfirst(strtolower($percentage->name_percentage)) }}</th>
                    @endforeach
                    <th>Docente</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($classrooms as $classroom)
        <tr>
            <td>{{ ucfirst(strtolower($classroom['relations']['course']['course_code'] ))}}</td>
            <td>{{ ucfirst(strtolower($classroom['relations']['course']['name_course'] ))}}</td>
            @if($classroom['relations']['course']['component'] !== null)
            <td>{{ ucfirst(strtolower($classroom['relations']['course']['component']['studyField']['name_study_field'] ?? 'No asignado'))}}</td>
            <td>{{ ucfirst(strtolower($classroom['relations']['course']['component']['name_component'] ?? 'No asignado' ))}}</td>
            @endif
            <td>{{ ucfirst(strtolower($classroom['relations']['course']['semester']['name_semester'] ))}}</td>
            <td>{{ $classroom['relations']['course']['credit'] }}</td>
            <td>{{ ucfirst(strtolower($classroom['relations']['course']['courseType']['name_course_type'] ))}}</td>
            <td>{{ ucfirst(strtolower($classroom['learningResult']['description_learning_result'] ))}}</td>
            <td>{{ ucfirst(strtolower($classroom['generalObjective']['description_general_objective'] ))}}</td>
            @foreach ($specifics as $specific)
            @if($classroom['id'] == $specific['id_classroom_plan'])
            <td>{{ ucfirst(strtolower($specific['description_specific_objective'] ))}}</td>
            @endif
            @endforeach
            @foreach ($specifics as $specific)
            @if ($classroom['id'] == $specific['id_classroom_plan'])
            @foreach ($topics as $topic)
            @if ($specific['id'] == $topic['id_specific_objective'])
            <td>{{ucfirst(strtolower( $topic['description_topic'] ))}}</td>
            @endif
            @endforeach
            @endif
            @endforeach
            @foreach ([1, 2, 3] as $id)
            <td>
                @foreach ($evaluationss as $evaluations)
                @if ($classroom['id'] == $evaluations['id_classroom_plan'])
                @if ($evaluations['id_percentage'] == $id)
                {{ ucfirst(strtolower($evaluations['evaluation']['name_evaluation'] ))}} - {{ $evaluations['percentage_number']}}% <br>
                @endif
                @endif
                @endforeach
            </td>
            @endforeach
            <td>
                {{ ucfirst(strtolower($classroom['relations']['user']['name'] ?? 'No asignado' ))}} {{ $classroom['relations']['user']['last_name'] ?? '' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>