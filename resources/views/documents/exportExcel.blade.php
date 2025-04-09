@php
$campoMostrado = false;
$colores = ['#4CAF50', '#2196F3', '#FF9800', '#9C27B0', '#3F51B5', '#009688', '#795548', '#F44336', '#673AB7', '#607D8B'];
$colorIndex = 0;
@endphp

<table style="width: 100%; border-collapse: collapse; word-break: break-word; table-layout: auto;">
    <thead>
        <tr>
            @php $titulos = ['Codigo curso', 'Curso']; @endphp
            @foreach ($titulos as $titulo)
            <th style="width: 200px; background-color: {{ $colores[$colorIndex++] }}; color: white; font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; text-transform: uppercase; border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: middle; white-space: normal; word-break: break-word;">{{ $titulo }}</th>
            @endforeach

            @foreach ($classrooms as $classroom)
            @if($classroom['relations']['course']['component'] !== null && !$campoMostrado)
            @php $campoMostrado = true; @endphp
            <th style="width: 200px; background-color: {{ $colores[$colorIndex++] }}; color: white; font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; text-transform: uppercase; border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: middle; white-space: normal; word-break: break-word;">Campo</th>
            <th style="width: 200px; background-color: {{ $colores[$colorIndex++] }}; color: white; font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; text-transform: uppercase; border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: middle; white-space: normal; word-break: break-word;">Componente</th>
            @endif
            @endforeach

            @php
            $titulosExtras = ['Semestre', 'Creditos', 'Tipo curso', 'Resultado de aprendizaje', 'Objetivo general'];
            $anchoExtras = [200, 80, 120, 250, 250]; // Puedes ajustar estos valores
            @endphp
            @foreach ($titulosExtras as $index => $titulo)
            <th style="width: {{ $anchoExtras[$index] }}px; background-color: {{ $colores[$colorIndex++ % count($colores)] }}; color: white; font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; text-transform: uppercase; border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: middle; white-space: normal; word-break: break-word;">{{ $titulo }}</th>
            @endforeach

            @for ($i = 1; $i <= 3; $i++)
                <th style="width: 250px; background-color: #607D8B; color: white; font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; text-transform: uppercase; border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: middle; white-space: normal; word-break: break-word;">Objetivo específico {{ $i }}</th>
                @endfor

                @for ($i = 1; $i <= 16; $i++)
                    <th style="width: 250px; background-color: #9E9E9E; color: white; font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; text-transform: uppercase; border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: middle; white-space: normal; word-break: break-word;">Tema semana {{ $i }}</th>
                    @endfor

                    @foreach ($percentages as $percentage)
                    <th style="width: 250px; background-color: #607D8B; color: white; font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; text-transform: uppercase; border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: middle; white-space: normal; word-break: break-word;">{{ strtoupper($percentage->name_percentage) }}</th>
                    @endforeach

                    <th style="width: 250px; background-color: #3F51B5; color: white; font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; text-transform: uppercase; border: 1px solid #ccc; padding: 8px; text-align: center; vertical-align: middle; white-space: normal; word-break: break-word;">Docente</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($classrooms as $classroom)
        <tr>
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($classroom['relations']['course']['course_code'])) }}
            </td>
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($classroom['relations']['course']['name_course'])) }}
            </td>

            @if($classroom['relations']['course']['component'] !== null)
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($classroom['relations']['course']['component']['studyField']['name_study_field'] ?? 'No asignado')) }}
            </td>
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($classroom['relations']['course']['component']['name_component'] ?? 'No asignado')) }}
            </td>
            @endif

            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($classroom['relations']['course']['semester']['name_semester'])) }}
            </td>
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ $classroom['relations']['course']['credit'] }}
            </td>
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($classroom['relations']['course']['courseType']['name_course_type'])) }}
            </td>
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($classroom['learningResult']['description_learning_result'])) }}
            </td>
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($classroom['generalObjective']['description_general_objective'])) }}
            </td>

            @php $countSpecific = 0; @endphp
            @foreach ($specifics as $specific)
            @if($classroom['id'] == $specific['id_classroom_plan'])
            @php $countSpecific++; @endphp
            <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                {{ ucfirst(strtolower($specific['description_specific_objective'])) }}
            </td>
            @endif
            @endforeach

            @for ($j = $countSpecific; $j < 3; $j++)
                <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                </td>
                @endfor

                @php $countTopics = 0; @endphp
                @foreach ($specifics as $specific)
                @if ($classroom['id'] == $specific['id_classroom_plan'])
                @foreach ($topics as $topic)
                @if ($specific['id'] == $topic['id_specific_objective'])
                @php $countTopics++; @endphp
                <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                    {{ ucfirst(strtolower($topic['description_topic'])) }}
                </td>
                @endif
                @endforeach
                @endif
                @endforeach

                @for ($j = $countTopics; $j < 16; $j++)
                    <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                    </td>
                    @endfor

                    @foreach ([1, 2, 3] as $id)
                    <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                        @foreach ($evaluationss as $evaluations)
                        @if ($classroom['id'] == $evaluations['id_classroom_plan'] && $evaluations['id_percentage'] == $id)
                        {{ ucfirst(strtolower($evaluations['evaluation']['name_evaluation'])) }} - {{ $evaluations['percentage_number'] }}%<br>
                        @endif
                        @endforeach
                    </td>
                    @endforeach

                    <td style="border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: middle; white-space: normal; word-break: break-word;">
                        {{ ucfirst(strtolower($classroom['relations']['user']['name'] ?? 'No asignado')) }} {{ $classroom['relations']['user']['last_name'] ?? '' }}
                    </td>
        </tr>
        @endforeach
    </tbody>

</table>