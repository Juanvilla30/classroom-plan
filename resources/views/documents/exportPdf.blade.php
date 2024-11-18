<head>
    <meta charset="UTF-8">
    <title>Plan de Aula</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        h2 {
            color: #003366;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        p {
            margin: 5px 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Tablas generales */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            font-size: 12px;
        }

        table th {
            background-color: #f2f2f2;
            color: #003366;
            font-weight: bold;
            text-transform: uppercase;
        }

        .table th.section-title {
            background-color: #003366;
            color: #fff;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        /* Listas */
        ul,
        ol {
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 5px;
        }

        ol li {
            margin-bottom: 10px;
        }

        /* Alineación */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        /* Estilos para encabezado */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header p {
            font-size: 10px;
            margin: 2px 0;
        }

        .header strong {
            color: #003366;
        }

        /* Secciones adicionales */
        .section-title {
            margin: 15px 0 5px;
            font-weight: bold;
            font-size: 14px;
            color: #003366;
        }

        /* Pie de página */
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>FORMATO PLAN DE AULA</h2>
            <p>Campo Profesional: <strong>Formación Académica</strong></p>
            <p>Código: E-FA-004 | Versión: 2 | Fecha: 08-03-2022 | Pág: 1 de 2</p>
        </div>

        <table class="info-table">
            <tr>
                <th>FACULTAD</th>
                <td>{{ucfirst(strtolower($classroom->relations->program->faculty->name_faculty ?? 'No asignado'))}}</td>
            </tr>
            <tr>
                <th>PROGRAMA</th>
                <td>{{ucfirst(strtolower($classroom->relations->program->name_program ?? 'No asignado'))}}</td>
            </tr>
            <tr>
                <th>NOMBRE DEL CURSO</th>
                <td>{{ucfirst(strtolower($classroom->relations->course->name_course ?? 'No asignado'))}}</td>
            </tr>
            <tr>
                <th>SEMESTRE</th>
                <td>{{ucfirst(strtolower($classroom->relations->course->semester->name_semester ?? 'No asignado'))}}
                </td>
            </tr>
            <tr>
                <th>ÁREA</th>
                <td>{{ucfirst(strtolower($classroom->relations->program->degree_type ?? 'No asignado'))}}</td>
            </tr>
            <tr>
                <th>COMPONENTE</th>
                <td>{{ ucfirst(strtolower($classroom->relations->course->component->name_component ?? 'No asignado')) }}
                </td>
            </tr>
            <tr>
                <th>TIPO DE CURSO</th>
                <td>{{ucfirst(strtolower($classroom->relations->course->courseType->name_course_type ?? 'No
                    asignado'))}}</td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th>N° CRÉDITOS</th>
                <th>TIEMPO PRESENCIAL</th>
                <th>TIEMPO INDEPENDIENTE</th>
                <th>TOTAL HORAS SEMESTRE</th>
            </tr>
            <tr>
                <td>{{ $classroom->relations->course->credit ?? 'No asignado' }}</td>
                <td>{{ $classroom->relations->course->pretential_time ?? 'No asignado'}}</td>
                <td>{{ $classroom->relations->course->independent_time ?? 'No asignado'}}</td>
                <td>0</td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th colspan="2" class="section-title">PERFIL DEL DOCENTE GENÉRICO</th>
            </tr>
            <tr>
                <th>PROFESION</th>
                <td>{{ ucfirst(strtolower($atributesUser->profession ?? 'No asignado'))}}</td>
            </tr>
            <tr>
                <th>ESTUDIOS DE POSTGRADO</th>
                <td>{{ ucfirst(strtolower($atributesUser->postgraduate_studies ?? 'No asignado'))}}</td>
            </tr>
            <tr>
                <th>COMPETENCIAS ESPECÍFICAS</th>
                <td>{{ ucfirst(strtolower($atributesUser->specific_competences ?? 'No asignado'))}}</td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th colspan="2" class="section-title">COMPETENCIAS</th>
            </tr>
            <tr>
                <td colspan="2">
                    {{ucfirst(strtolower($classroom->learningResult->competence->description_competence ?? 'No
                    asignado'))}}
                </td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th colspan="2" class="section-title">RESULTADOS DE APRENDIZAJE</th>
            </tr>
            <tr>
                <td colspan="2">
                    {{ucfirst(strtolower($classroom->learningResult->description_learning_result ?? 'No asignado'))}}
                </td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th colspan="2" class="section-title">CONTENIDO TEMÁTICO</th>
            </tr>
            <tr>
                <td colspan="2">
                    <ol>
                        @php $i = 1; @endphp
                        @foreach($topics as $topic)
                        <li>Temas semana {{$i}}:
                            <ul>
                                <li>{{ $topic->description_topic}}</li>
                            </ul>
                        </li>
                        @php $i++; @endphp
                        @endforeach
                    </ol>
                </td>
            </tr>
        </table>

        <!-- Estrategias de Evaluación -->
        <table class="table">
            <tr>
                <th colspan="2" class="section-title">ESTRATEGIAS DE EVALUACIÓN</th>
            </tr>
            <tr>
                <td colspan="2">
                    <ul>
                        <li>Evaluación continua mediante trabajos prácticos y exámenes parciales.</li>
                        <li>Participación en actividades de desarrollo de proyectos.</li>
                        <li>Autoevaluación y coevaluación en equipos de trabajo.</li>
                    </ul>
                </td>
            </tr>
        </table>

        <!-- Bibliografía -->
        <table class="table">
            <tr>
                <th colspan="2" class="section-title">BIBLIOGRAFÍA</th>
            </tr>
            <tr>
                <td colspan="2">
                    <ul>
                        <li>Pressman, R. (2005). Ingeniería de software: Un enfoque práctico.</li>
                        <li>Sommerville, I. (2011). Ingeniería de software.</li>
                        <li>Gamma, E., Helm, R., Johnson, R., & Vlissides, J. (1995). Design Patterns: Elements of
                            Reusable Object-Oriented Software.</li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
</body>