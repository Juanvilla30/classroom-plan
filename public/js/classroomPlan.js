// Configurar el token CSRF para todas las solicitudes AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/*
    *
    * VARIABLES
    *
*/

let faculty;
let program;
let learningId;
let courseId;
let typeCourseId;
let classroomId;
let component;
let specificId;
let dataConfirmation;

const selectedEvaluations = [];
const selectedEvaluations2 = [];
const selectedEvaluations3 = [];

document.addEventListener('DOMContentLoaded', function () {
    /*
        *
        * ARREGLOS
        *
    */

    // Arreglo con los IDs de las cards
    const cards = ['card-1', 'card-2', 'card-3', 'card-4', 'card-5', 'card-6', 'card-7', 'card-8'];

    // Inicialmente mostrar la primera card
    let currentCardIndex = 0;
    document.getElementById(cards[currentCardIndex]).style.display = 'block';

    /*
        *
        * FUNCIONES
        *
    */

    // Función para capitalizar el primer carácter de un texto
    function capitalizeText(text) {
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

    // Función para mostrar la siguiente card
    function showNextCard() {
        // Ocultar la card actual
        document.getElementById(cards[currentCardIndex]).style.display = 'none';

        // Incrementar el índice para pasar a la siguiente card
        currentCardIndex++;

        if (currentCardIndex < cards.length) {
            // Mostrar la siguiente card
            document.getElementById(cards[currentCardIndex]).style.display = 'block';
        } else {
            // Recargar la página cuando llegues a la última card
            location.reload();
        }
    }

    // Función para reiniciar el formulario
    function resetForm(check) {

        if (check == true) {
            // Reiniciar el selector de facultad
            var learningSelect = document.getElementById('pillSelectLearning');
            learningSelect.selectedIndex = 0; // Seleccionar la opción por defecto
            learningSelect.disabled = true; // Deshabilitar el select

            // Obtener el cuerpo de la tabla dentro de la tarjeta
            const bodyComponent = document.getElementById('bodyComponent');
            if (bodyComponent) {
                bodyComponent.innerHTML = ''; // Limpiar el contenido del tbody
            }

            // Limpiar el textarea
            document.getElementById('textareaDescriptionRA').value = '';

            // Limpiar el Info Curso
            document.getElementById('nameFaculty').innerText = '';
            document.getElementById('nameProgram').innerText = '';
            document.getElementById('nameField').innerText = '';
            document.getElementById('nameComponent').innerText = '';
            document.getElementById('nameCourse').innerText = '';
            document.getElementById('nameSemester').innerText = '';
            document.getElementById('nameCredits').innerText = '';
            document.getElementById('nameCourseType').innerText = '';

            document.getElementById('percentage1').textContent = ''; // Reiniciar PORCENTAJE1
            document.getElementById('percentage2').textContent = ''; // Reiniciar PORCENTAJE2
            document.getElementById('percentage3').textContent = ''; // Reiniciar PORCENTAJE3
        } else {

            // Obtener el cuerpo de la tabla dentro de la tarjeta
            const bodyEvaluations = document.getElementById('bodyEvaluations');
            if (bodyEvaluations) {
                bodyEvaluations.innerHTML = ''; // Limpiar el contenido del tbody
            }

            document.getElementById('percentage1').textContent = ''; // Reiniciar PORCENTAJE1
            document.getElementById('percentage2').textContent = ''; // Reiniciar PORCENTAJE2
            document.getElementById('percentage3').textContent = ''; // Reiniciar PORCENTAJE3
        }
    }

    function resetCheckboxes() {

    }

    function resetValite(check) {
        if (check == false) {
            // Seleccionar todos los elementos con la clase 'nextCard' y quitar la clase 'd-none' de cada uno
            document.querySelectorAll('.confirmationSave').forEach(function (button) {
                button.classList.remove('d-none');
            });

            // Seleccionar todos los elementos con la clase 'nextCard' y añadir la clase 'd-none' a cada uno
            document.querySelectorAll('.nextCard').forEach(function (button) {
                button.classList.add('d-none');
            });

            document.getElementById('createEvaluation').classList.remove('d-none');
            document.getElementById('bodyReferences').innerHTML = '';

            document.getElementById('percentageView').classList.add('d-none');
            document.getElementById('percentageContainer').classList.remove('d-none');

        } else {

            // Seleccionar todos los elementos con la clase 'nextCard' y quitar la clase 'd-none' de cada uno
            document.querySelectorAll('.nextCard').forEach(function (button) {
                button.classList.remove('d-none');
            });

            // Seleccionar todos los elementos con la clase 'nextCard' y añadir la clase 'd-none' a cada uno
            document.querySelectorAll('.confirmationSave').forEach(function (button) {
                button.classList.add('d-none');
            });

            document.getElementById('percentageView').classList.remove('d-none');
            document.getElementById('percentageContainer').classList.add('d-none');

            document.getElementById('createEvaluation').classList.add('d-none');

        }
    }

    function selectProgram(faculty) {

        const selectElement = document.getElementById('pillSelectProgram');

        if (faculty === '') {
            selectElement.disabled = true;
        } else {
            selectElement.disabled = false;

            $.ajax({
                url: '/classroom-plan/faculty-program', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
                    faculty: faculty,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {
                    // Limpiar el contenido actual del select antes de agregar opciones nuevas
                    selectElement.innerHTML = '<option disabled selected value="">Seleccione un programa</option>';

                    // Iterar sobre los programas recibidos y agregarlos como opciones
                    response.listPrograms.forEach(function (program) {
                        const option = document.createElement('option');
                        option.value = program.id;
                        option.text = program.name_program.charAt(0).toUpperCase() + program.name_program.slice(1).toLowerCase(); // Capitalizar
                        selectElement.appendChild(option);
                    });

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);

                }
            });
        }

    }

    function selectLearning(learningId) {

        $.ajax({
            url: '/classroom-plan/Learning-result', // URL 
            method: 'POST', // Método de la solicitud: POST
            data: {
                learningId: learningId,
            },
            // Función que se ejecuta en caso de éxito en la solicitud
            success: function (response) {
                document.getElementById('textareaDescriptionRA').value = response.learningResult[0].description_learning_result;
            },
            // Función que se ejecuta en caso de error en la solicitud
            error: function (xhr, status, error) {
                // Imprimir mensajes de error en la consola
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });

    }

    function selectRA(response, cd) {
        const selectElement = document.getElementById('pillSelectLearning');

        // Limpiar el contenido actual del select antes de agregar opciones nuevas
        selectElement.innerHTML = '';

        // Verificar si `learningResult` está presente y contiene un solo resultado
        if (cd === true) {
            const learning = response;  // Solo hay un resultado de aprendizaje
            const option = document.createElement('option');
            option.value = learning.id;  // Asigna el ID del resultado de aprendizaje
            option.text = learning.name_learning_result;  // Asigna el nombre del resultado de aprendizaje
            option.selected = true; // Configura esta opción como seleccionada
            selectElement.appendChild(option);  // Agrega la opción al elemento select

            document.getElementById('pillSelectLearning').disabled = true;
            // Establecer la descripción en el textarea correspondiente
            document.getElementById('textareaDescriptionRA').value = learning.description_learning_result;
        }
        // Si `learningResultsId` está presente, iterar sobre cada arreglo de resultados
        else if (cd == false) {
            document.getElementById('textareaDescriptionRA').value = '';

            const defaultOption = document.createElement('option');
            defaultOption.disabled = true;
            defaultOption.selected = true;
            defaultOption.value = '';
            defaultOption.text = 'Seleccione un resultado de aprendizaje';
            selectElement.appendChild(defaultOption);

            response.learningResultsId.forEach(function (learningArray) {
                learningArray.forEach(function (learning) {
                    const option = document.createElement('option');
                    option.value = learning.id;
                    option.text = learning.name_learning_result;
                    selectElement.appendChild(option);
                });
            });
        } else {
            console.warn('No se encontraron resultados de aprendizaje en la respuesta');
        }
    }

    function ajaxLearning(program, learningId) {
        return new Promise((resolve, reject) => {

            $.ajax({
                url: '/classroom-plan/learning-program', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
                    program: program,
                    learningId: learningId,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {

                    resolve(response);

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);

                    // Rechazamos la promesa en caso de error
                    reject(error);
                }
            });
        });

    }

    function loadResultsSelect(program, learningId) {

        const selectElement = document.getElementById('pillSelectLearning');

        if (learningId == false) {

            if (program == '') {
                selectElement.disabled = true;
            } else {

                selectElement.disabled = false;
                ajaxLearning(program, false).then(response => {
                    selectRA(response, false);
                })
            }
        } else {
            selectElement.disabled = true;
        }

    }

    function tableFiltersCourse(program) {

        // Verificar si se han proporcionado programa, semestre y tipo de curso
        if (program) {
            // Mostrar el modal para seleccionar cursos
            $('#modalCourse').modal('show');

            // Realizar una solicitud AJAX para obtener los cursos según los parámetros proporcionados
            $.ajax({
                url: '/classroom-plan/filters-course', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
                    programs: program,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {

                    // Procesar la respuesta del servidor y actualizar la tabla de cursos
                    var courses = response.listCurse; // Obtener la lista de cursos de la respuesta
                    var programs = response.listPrograms;

                    // Verifica si programas están definidos antes de usarlos
                    if (programs.length > 0) {
                        // Solo tomamos el primer programa para mostrar su facultad y nombre
                        var program = programs[0]; // Aquí obtén el programa que necesitas, dependiendo de tu lógica
                    } else {
                        console.error('No se encontraron programas.');
                        return; // Sal de la función si no hay programas
                    }

                    var bodyCourse = $('#bodyCourses');
                    bodyCourse.empty();

                    // Verificar si se encontraron cursos en la respuesta
                    if (courses.length > 0) {
                        courses.forEach(function (course) {
                            var row = `
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm courseSelect" 
                                        data-id="${course.id}" data-dismiss="modal">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </td>
                                <td>${capitalizeText(program.faculty.name_faculty)}</td>
                                <td>${capitalizeText(program.name_program)}</td>
                                <td>${capitalizeText(course.component.study_field.name_study_field)}</td>
                                <td>${capitalizeText(course.component.name_component)}</td>
                                <td>${capitalizeText(course.name_course)}</td>
                                <td>${capitalizeText(course.semester.name_semester)}</td>
                                <td>${course.credit}</td>
                                <td>${capitalizeText(course.course_type.name_course_type)}</td>
                            </tr>
                        `;
                            bodyCourse.append(row);
                        });
                    } else {
                        // Mostrar un mensaje si no se encontraron cursos
                        bodyCourse.append('<tr><td colspan="6">No se encontraron.</td></tr>');
                    }
                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                    // Mostrar un mensaje de error en la tabla en caso de error en la solicitud
                    $('#bodyCourses').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                }
            });
        } else {
            // Mostrar un mensaje de error si faltan opciones seleccionadas
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor selecciona el programa para poder seleccionar un curso',
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
            event.preventDefault();
        }
    }

    function tableComponent(component) {

        // Realizar la petición AJAX
        $.ajax({
            url: '/classroom-plan/list-courses',
            type: 'POST',
            data: {
                component: component
            },
            success: function (response) {

                // Manejar el caso donde classroomPlan puede estar vacío
                var classroomPlanIds = response.classroomPlan ? response.classroomPlan.map(plan => plan.id_course) : []; // Obtener todos los id_course

                // Procesar la respuesta del servidor y actualizar la tabla de cursos
                var courses = response.courses; // Obtener la lista de cursos de la respuesta

                console.log
                var bodyComponent = $('#bodyComponent');
                bodyComponent.empty();

                // Verificar si se encontraron cursos en la respuesta
                if (courses.length > 0) {
                    courses.forEach(function (course) {
                        // Determinar la clase de fondo
                        var rowClass = '';

                        // Verifica si el ID del curso está en el arreglo classroomPlanIds
                        if (classroomPlanIds.includes(course.id)) {
                            rowClass = 'highlight-row'; // Clase para el fondo del curso correspondiente
                        } else {
                            rowClass = 'normal-row'; // Clase para el fondo normal
                        }

                        var row = `
                        <tr class="${rowClass}">                
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeText(course.component.study_field.name_study_field)}
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeText(course.component.name_component)}
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeText(course.name_course)}                        
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeText(course.semester.name_semester)}                                
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${course.credit}
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeText(course.course_type.name_course_type)}
                                </a>
                            </td>
                        </tr>
                    `;
                        bodyComponent.append(row);
                    });
                } else {
                    // Mostrar un mensaje si no se encontraron cursos
                    bodyComponent.append('<tr><td colspan="6">No se encontraron.</td></tr>');
                }
            },
            // Función que se ejecuta en caso de error en la solicitud
            error: function (xhr, status, error) {
                // Imprimir mensajes de error en la consola
                console.error('Error al obtener:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
            }
        });
    }

    function tableReferences(response) {

        // Procesar la respuesta del servidor y actualizar la tabla de cursos
        var referencesId = response; // Obtener la lista de cursos de la respuesta

        var bodyReferences = $('#bodyReferences');
        bodyReferences.empty();

        // Verificar si se encontraron cursos en la respuesta
        if (referencesId.length > 0) {
            let cont = 1;
            referencesId.forEach(function (reference) {

                var row = `
                <tr>
                    <td>
                        ${cont++}
                    </td>                               
                    <td>
                        ${reference.name_reference}
                    </td>
                    <td>
                        ${reference.link_reference}
                    </td>                                      
                </tr>
            `;
                bodyReferences.append(row);
            });
        } else {
            // Mostrar un mensaje si no se encontraron cursos
            bodyReferences.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    function viewPercentage(response) {
        console.log('ENCUENTRA', response);

        // Inicializar arreglos para acumular los nombres de evaluación
        let evaluations1 = [];
        let evaluations2 = [];
        let evaluations3 = [];

        // Verificar si se encontraron cursos en la respuesta
        if (response.length > 0) {
            response.forEach(function (resp) {
                var lol = resp.id_percentage;

                if (lol === 1) {
                    var po = (resp.evaluation && resp.evaluation.name_evaluation)
                        ? capitalizeText(resp.evaluation.name_evaluation) // Capitalizar
                        : 'Nombre de evaluación no disponible'; // Valor alternativo si no existe
                    evaluations1.push(po); // Agregar al arreglo de evaluaciones 1
                } else if (lol === 2) {
                    var po2 = (resp.evaluation && resp.evaluation.name_evaluation)
                        ? capitalizeText(resp.evaluation.name_evaluation) // Capitalizar
                        : 'Nombre de evaluación no disponible'; // Valor alternativo
                    evaluations2.push(po2); // Agregar al arreglo de evaluaciones 2
                } else if (lol === 3) {
                    var po3 = (resp.evaluation && resp.evaluation.name_evaluation)
                        ? capitalizeText(resp.evaluation.name_evaluation) // Capitalizar
                        : 'Nombre de evaluación no disponible'; // Valor alternativo
                    evaluations3.push(po3); // Agregar al arreglo de evaluaciones 3
                }
            });

            // Mostrar todos los nombres de evaluación en los elementos correspondientes
            document.getElementById('percentage1').textContent = evaluations1.join(', ') || 'Sin evaluaciones'; // Mostrar todos los nombres acumulados
            document.getElementById('percentage2').textContent = evaluations2.join(', ') || 'Sin evaluaciones'; // Mostrar todos los nombres acumulados
            document.getElementById('percentage3').textContent = evaluations3.join(', ') || 'Sin evaluaciones'; // Mostrar todos los nombres acumulados
        } else {
            console.log('No se encontraron evaluaciones.');
        }

    }

    function checkboxSave(selectedEvaluations, selectedEvaluations2, selectedEvaluations3) {
        const checkboxContainers = [
            { containerId: 'evaluationsCheckbox1', selectedArray: selectedEvaluations, dataAttr: 'data-evaluation1' },
            { containerId: 'evaluationsCheckbox2', selectedArray: selectedEvaluations2, dataAttr: 'data-evaluation2' },
            { containerId: 'evaluationsCheckbox3', selectedArray: selectedEvaluations3, dataAttr: 'data-evaluation3' },
        ];

        checkboxContainers.forEach(({ containerId, selectedArray, dataAttr }) => {
            document.querySelectorAll(`#${containerId} input[type="checkbox"]`).forEach((checkbox) => {
                checkbox.addEventListener('change', (event) => {
                    const evaluationId = event.target.getAttribute(dataAttr);
                    if (event.target.checked) {
                        // Agregar el ID de la evaluación al array
                        selectedArray.push(evaluationId);
                        console.log('Evaluación seleccionada:', evaluationId);
                    } else {
                        // Eliminar el ID de la evaluación del array
                        const index = selectedArray.indexOf(evaluationId);
                        if (index !== -1) {
                            selectedArray.splice(index, 1);
                        }
                        console.log('Evaluación deseleccionada:', evaluationId);
                    }
                    console.log('Evaluaciones seleccionadas:', selectedArray);
                });
            });
        });
    }

    function viewEvaluation(response) {
        console.log('Response:', response); // Verifica qué se está recibiendo

        // Verificar si se encontraron cursos en la respuesta
        if (response.length > 0) {
            // Crear contenido HTML acumulado para cada contenedor
            const contentEvaluations1 = [];
            const contentEvaluations2 = [];
            const contentEvaluations3 = [];

            // Array para guardar las evaluaciones seleccionadas
            selectedEvaluations;
            selectedEvaluations2;
            selectedEvaluations3;

            response.forEach((evaluation) => {
                // Crear el contenido HTML para cada evaluación
                const content1 = `
                    <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" class="selectgroup-input" id="checksP1" data-evaluation1='${evaluation.id}'>
                            <span class="selectgroup-button">
                                ${capitalizeText(evaluation.name_evaluation)}
                            </span>
                        </label>
                    </div>  
                `;

                const content2 = `
                    <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" class="selectgroup-input" id="checksP2" data-evaluation2='${evaluation.id}'>
                            <span class="selectgroup-button">
                                ${capitalizeText(evaluation.name_evaluation)}
                            </span>
                        </label>
                    </div>  
                `;

                const content3 = `
                    <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" value="${evaluation.id}" class="selectgroup-input" id="checksP3" data-evaluation3='${evaluation.id}'>
                            <span class="selectgroup-button">
                                ${capitalizeText(evaluation.name_evaluation)}
                            </span>
                        </label>
                    </div>  
                `;

                // Añadir el contenido a cada uno de los contenedores
                contentEvaluations1.push(content1);
                contentEvaluations2.push(content2);
                contentEvaluations3.push(content3);
            });

            document.getElementById('evaluationsCheckbox1').innerHTML = contentEvaluations1.join('');
            document.getElementById('evaluationsCheckbox2').innerHTML = contentEvaluations2.join('');
            document.getElementById('evaluationsCheckbox3').innerHTML = contentEvaluations3.join('');

            checkboxSave(selectedEvaluations, selectedEvaluations2, selectedEvaluations3);

        } else {
            // Insertar los contenidos acumulados en cada contenedor correspondiente utilizando un bucle for
            const containers = ['evaluationsCheckbox1', 'evaluationsCheckbox2', 'evaluationsCheckbox3'];
            for (let i = 0; i < containers.length; i++) {
                document.getElementById(containers[i]).innerHTML = '<tr><td colspan="6">No se encontraron.</td></tr>';
            }
        }
    }

    function viewClassroom(response) {

        console.log('REFERENCIAS', response.referencesId);

        // Establecer variables
        let general = response.classroomPlanId[0].general_objective.description_general_objective;
        let specifics = response.specificsId;
        let topics = response.topicsId;
        let evaluation = response.evaluationsId;
        let reference = response.referencesId;

        // Establecer la descripción en el textarea correspondiente
        document.getElementById('textAreaObjective').value = general;

        // Iterar a través de los objetivos específicos y establecer valores
        specifics.forEach((specific, index) => {
            let description = specific.description_specific_objective;
            let specificTextArea = document.getElementById(`textAreaSpecific${index + 1}`);
            if (specificTextArea) {
                specificTextArea.value = description;
            }

            let collapseCardBody = document.querySelector(`#collapse${index + 1} .card-body`);
            if (collapseCardBody) {
                collapseCardBody.innerText = description;
            }
        });

        // Iterar a través de los objetivos específicos y establecer valores
        topics.forEach((topic, index) => {
            let description = topic.description_topic;
            let topicsTextArea = document.getElementById(`textAreaTheme${index + 1}`);
            if (topicsTextArea) {
                topicsTextArea.value = description;
            }
        });

        validateEvaluation(false, evaluation);
        tableReferences(reference);

    }

    function validateEvaluation(typeCourse, response) {

        if (typeCourse !== false) {
            // Realizar la petición AJAX
            $.ajax({
                url: '/classroom-plan/table-evaluations',
                type: 'POST',
                data: {
                    typeCourse: typeCourse
                },
                success: function (response) {
                    viewEvaluation(response.evaluationsId);
                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                }
            });
        } else {
            viewPercentage(response);
        }
    }

    function visualizeInfoCourse(response) {

        var programs = response.program;
        var courses = response.course; // Obtener la lista de cursos de la respuesta

        // Verifica si programas están definidos antes de usarlos
        if (programs.length > 0 && courses.length > 0) {
            // Solo tomamos el primer programa para mostrar su facultad y nombre
            var program = programs[0]; // Aquí obtén el programa que necesitas, dependiendo de tu lógica
            var course = courses[0]; // Aquí obtén el programa que necesitas, dependiendo de tu lógica
        } else {
            console.error('No se encontraron programas.');
            return; // Sal de la función si no hay programas
        }

        // Actualizar los campos en el área #course-info
        $('#nameFaculty').text(capitalizeText(program.faculty.name_faculty));
        $('#nameProgram').text(capitalizeText(program.name_program));
        $('#nameField').text(capitalizeText(course.component.study_field.name_study_field));
        $('#nameComponent').text(capitalizeText(course.component.name_component));
        $('#nameCourse').text(capitalizeText(course.name_course));
        $('#nameSemester').text(capitalizeText(course.semester.name_semester));
        $('#nameCredits').text(course.credit);
        $('#nameCourseType').text(capitalizeText(course.course_type.name_course_type));

    }

    function validate(fields, alertMessage) {
        // Verificar si hay algún campo vacío
        let hasEmptyField = fields.some(field => {
            const element = document.getElementById(field);
            return element === null || element.value.trim() === "";
        });

        if (hasEmptyField) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: alertMessage,
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Mostrar el modal si no hay campos vacíos
            $('#modalConfirmation').modal('show');
        }
    }

    function validateCheckbox() {
        const checkboxes = document.querySelectorAll('#evaluationsCheckbox1 input[type="checkbox"]');
        const checkboxes1 = document.querySelectorAll('#evaluationsCheckbox2 input[type="checkbox"]');
        const checkboxes2 = document.querySelectorAll('#evaluationsCheckbox3 input[type="checkbox"]');

        let atLeastOneChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        let atLeastOneChecked2 = Array.from(checkboxes1).some(checkbox => checkbox.checked);
        let atLeastOneChecked3 = Array.from(checkboxes2).some(checkbox => checkbox.checked);

        if (!atLeastOneChecked || !atLeastOneChecked2 || !atLeastOneChecked3) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor, selecciona al menos una evaluación en cada grupo.',
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
            return false; // Retorna false si no hay selecciones
        }
        $('#modalConfirmation').modal('show');
        return true; // Retorna true si hay al menos una selección
    }

    function validateClassroomPlan(courseId, program, typeCourseId) {
        $.ajax({
            url: '/classroom-plan/validate-classroom-plans', // URL 
            method: 'POST', // Método de la solicitud: POST
            data: {
                courseId: courseId,
            },
            // Función que se ejecuta en caso de éxito en la solicitud
            success: function (response) {
                if (response.confirm == false) {
                    loadResultsSelect(program, false);
                    validateEvaluation(typeCourseId, false);
                    resetValite(false);

                } else if (response.confirm == true) {
                    var learningId = response.classroomPlanId[0].learning_result;
                    selectRA(learningId, true);
                    viewClassroom(response);
                    resetValite(true);

                }

            },
            // Función que se ejecuta en caso de error en la solicitud
            error: function (xhr, status, error) {
                // Imprimir mensajes de error en la consola
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function confirmationSave(dataConfirmation) {
        if (dataConfirmation == '1') {

            validate(
                ['pillSelectLearning'],
                'Por favor, selecciona un resultado de aprendizaje.'
            );

        } else if (dataConfirmation == '2') {
            validate(
                ['textAreaObjective'],
                'El campo objetivo general no puede estar vacío.'
            );

        } else if (dataConfirmation == '3') {
            validate(
                ['textAreaSpecific1', 'textAreaSpecific2', 'textAreaSpecific3'],
                'Los campos de objetivos especificos no pueden estar vacíos.'
            );

        } else if (dataConfirmation == '4') {
            validate(
                ['textAreaTheme1', 'textAreaTheme2', 'textAreaTheme3', 'textAreaTheme4', 'textAreaTheme5'],
                'Los campos de temas no pueden estar vacíos.'
            );

        } else if (dataConfirmation == '5') {
            validate(
                ['textAreaTheme6', 'textAreaTheme7', 'textAreaTheme8', 'textAreaTheme9', 'textAreaTheme10'],
                'Los campos de temas no pueden estar vacíos.'
            );

        } else if (dataConfirmation == '6') {
            validate(
                ['textAreaTheme11', 'textAreaTheme12', 'textAreaTheme13', 'textAreaTheme14', 'textAreaTheme15', 'textAreaTheme16'],
                'Los campos de temas no pueden estar vacíos.'
            );

        } else if (dataConfirmation == '7') {
            validateCheckbox()

        } else if (dataConfirmation == '8') {
            $('#modalConfirmation').modal('show');

        }
    }

    function blockAttributes(state1, state2) {

        // Bloquear o desbloquear los campos de entrada
        document.querySelectorAll('.readonlyCheck').forEach(function (element) {
            // Verifica si el elemento es un <input> o <textarea>
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.readOnly = state1;  // Usa readOnly directamente
            }
        });

        // Obtener los elementos del formulario por su ID
        let selectFaculty = document.getElementById('pillSelectFaculty');
        let selectProgram = document.getElementById('pillSelectProgram');
        let filterCourseButton = document.getElementById('filterCourse');
        let saveGeneralButton = document.getElementById('saveGeneral');
        let saveInstitutionalButton = document.getElementById('saveInstitutional');

        // Activar o desactivar los elementos según el valor de `state`
        selectFaculty.disabled = state2;
        selectProgram.disabled = state2;
        filterCourseButton.disabled = state2;
        saveGeneralButton.disabled = state2;
        saveInstitutionalButton.disabled = state2;
    }

    function saveClassroomPlan(courseId, learningId) {

        const nameGeneral = 'Objetivo general';

        const nameSpecific = [
            'Objetivo especifico #1',
            'Objetivo especifico #2',
            'Objetivo especifico #3'
        ];

        const nameReference = [
            'Referencia institucional',
            'Referencia general',
        ];

        const content = 'No se registro contenido';

        return new Promise((resolve, reject) => {

            $.ajax({
                url: '/classroom-plan/create-classroom-plans', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
                    courseId: courseId,
                    learningId: learningId,
                    nameGeneral: nameGeneral,
                    nameSpecificOne: nameSpecific[0],
                    nameSpecificTwo: nameSpecific[1],
                    nameSpecificThree: nameSpecific[2],
                    nameReferenceOne: nameReference[0],
                    nameReferenceTwo: nameReference[1],
                    content: content,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {

                    resolve(response);

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);

                    // Rechazamos la promesa en caso de error
                    reject(error);
                }
            });
        });
    }

    function saveObjGeneral(classroomId, generalObjective) {
        return new Promise((resolve, reject) => {
            // Realizar la petición AJAX
            $.ajax({
                url: '/classroom-plan/save-general-objective',
                type: 'PUT',
                data: {
                    classroomId: classroomId,
                    generalObjective: generalObjective,
                },
                success: function (response) {
                    resolve(response);

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    reject(error);

                }
            });
        });

    }

    function saveObjSpecific(classroomId, specificObjectives) {
        return new Promise((resolve, reject) => {
            // Realizar la petición AJAX
            $.ajax({
                url: '/classroom-plan/save-specific-objective',
                type: 'PUT',
                data: {
                    classroomId: classroomId,
                    specificObjectiveOne: specificObjectives[0],
                    specificObjectiveTwo: specificObjectives[1],
                    specificObjectiveThree: specificObjectives[2],
                },
                success: function (response) {
                    resolve(response.specificId);

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    reject(error);

                }
            });
        });
    }

    function saveTopic(specificId, topics) {
        return new Promise((resolve, reject) => {
            // Realizar la petición AJAX
            $.ajax({
                url: '/classroom-plan/save-topic',
                type: 'PUT',
                data: {
                    specificId: specificId,
                    topics: topics,
                },
                success: function (response) {
                    resolve(response);

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    reject(error);

                }
            });
        });
    }

    function saveAsEvaluation(classroomId, selectedEvaluations, selectedEvaluations2, selectedEvaluations3) {
        const percentageId = [1,2,3]
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/classroom-plan/save-evaluations',
                type: 'PUT',
                data: {
                    classroomId: classroomId,
                    percentageId1: percentageId[0],
                    percentageId2: percentageId[1],
                    percentageId3: percentageId[2],
                    selectedEvaluations: selectedEvaluations,
                    selectedEvaluations2: selectedEvaluations2,
                    selectedEvaluations3: selectedEvaluations3,
                },
                success: function (response) {
                    resolve(response);
                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    reject(error);

                }
            });
        });
    }

    function confirmButton(dataConfirmation, learningId, courseId) {
        // Cambiar a la siguiente card
        showNextCard();

        // Cerrar el modal
        $('#modalConfirmation').modal('hide');

        if (dataConfirmation == 1) {
            // Guardar el perfil si el contenido no está vacío
            if (learningId !== '' && courseId !== '') {
                blockAttributes(false, true);
                saveClassroomPlan(courseId, learningId).then(response => {
                    classroomId = response.createClassroom.id;
                    learningId = '';
                    courseId = '';
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 2) {
            let generalObjective = document.getElementById('textAreaObjective').value;

            if (generalObjective !== '') {
                saveObjGeneral(classroomId, generalObjective).then(response => {
                    generalObjective = '';
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 3) {
            let specificObjectives = [];

            for (let i = 1; i <= 3; i++) {
                let objectiveValue = document.getElementById(`textAreaSpecific${i}`).value;
                if (objectiveValue !== '') {
                    specificObjectives.push(objectiveValue);
                    document.querySelector(`#collapse${i} .card-body`).innerText = objectiveValue;
                }
            }

            // Verificar si todos los objetivos específicos tienen valor antes de guardar
            if (specificObjectives.length === 3) {
                saveObjSpecific(classroomId, specificObjectives).then(response => {
                    specificId = response;
                    // Reiniciar los valores después de guardar
                    specificObjectives.forEach((_, index) => {
                        document.getElementById(`textAreaSpecific${index + 1}`).value = '';
                    });
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 4) {
            let topics = [];

            for (let i = 1; i <= 5; i++) {
                let TopicValue = document.getElementById(`textAreaTheme${i}`).value;
                if (TopicValue !== '') {
                    topics.push(TopicValue);
                }
            }

            // Verificar si todos los objetivos específicos tienen valor antes de guardar
            if (topics.length === 5) {
                saveTopic(specificId[0], topics).then(response => {

                    // Reiniciar los valores después de guardar
                    topics.forEach((_, index) => {
                        document.getElementById(`textAreaTheme${index + 1}`).value = '';
                    });
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 5) {
            let topics2 = [];

            for (let i = 6; i <= 10; i++) {
                let TopicValue2 = document.getElementById(`textAreaTheme${i}`).value;
                if (TopicValue2 !== '') {
                    topics2.push(TopicValue2);
                }
            }

            // Verificar si todos los objetivos específicos tienen valor antes de guardar
            if (topics2.length === 5) {
                saveTopic(specificId[1], topics2).then(response => {

                    // Reiniciar los valores después de guardar
                    topics2.forEach((_, index) => {
                        document.getElementById(`textAreaTheme${index + 1}`).value = '';
                    });
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 6) {
            let topics3 = [];

            for (let i = 11; i <= 16; i++) {
                let TopicValue3 = document.getElementById(`textAreaTheme${i}`).value;
                if (TopicValue3 !== '') {
                    topics3.push(TopicValue3);
                }
            }

            // Verificar si todos los objetivos específicos tienen valor antes de guardar
            if (topics3.length === 6) {
                saveTopic(specificId[2], topics3).then(response => {

                    // Reiniciar los valores después de guardar
                    topics3.forEach((_, index) => {
                        document.getElementById(`textAreaTheme${index + 1}`).value = '';
                    });
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 7) {
            console.log(classroomId);
            // CONTINUAR EVALUATIONS
            if (selectedEvaluations !== '' && selectedEvaluations2 !== '' && selectedEvaluations3 !== '') {
                saveAsEvaluation(classroomId, selectedEvaluations, selectedEvaluations2, selectedEvaluations3).then(response => {
                    console.log('ESTAMOS-BIEN',response);
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }

        } else if (dataConfirmation == 8) {
            console.log('hola')
        }
    }

    /*
        *
        * AJAX
        *
    */

    $('#tableCourses').on('click', '.courseSelect', function () {
        // OBTIENE EL VALOR DEL SEMESTRE SELECCIONADO
        courseId = $(this).data('id');

        // Realizar la petición AJAX
        $.ajax({
            url: '/classroom-plan/visualize-info-course',
            type: 'POST',
            data: {
                courseId: courseId
            },
            success: function (response) {
                typeCourseId = response.course[0].id_course_type;
                component = response.course[0].id_component;
                visualizeInfoCourse(response);
                tableComponent(component);
                validateClassroomPlan(courseId, program, typeCourseId);
                resetForm(false);
            },
            // Función que se ejecuta en caso de error en la solicitud
            error: function (xhr, status, error) {
                // Imprimir mensajes de error en la consola
                console.error('Error al obtener:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
            }
        });

    });

    /*
        *
        * Event Listener
        *
    */

    document.getElementById('pillSelectFaculty').addEventListener('change', function () {
        faculty = this.options[this.selectedIndex].value;
        resetForm(true);
        selectProgram(faculty);
    });

    document.getElementById('pillSelectProgram').addEventListener('change', function () {
        program = this.options[this.selectedIndex].value;
        resetForm(true);
    });

    document.getElementById('pillSelectLearning').addEventListener('change', function () {
        learningId = this.value;
        selectLearning(learningId);
    });

    document.getElementById('filterCourse').addEventListener('click', function () {
        tableFiltersCourse(program);
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        confirmButton(dataConfirmation, learningId, courseId);
        learningId = '';
        courseId = '';
    });

    document.getElementById('saveInstitutional').addEventListener('click', function () {
        validate(
            ['linkInstitutionalReferences'],
            'Por favor, ingreasa una referencia institucional.'
        );
    });

    document.getElementById('saveGeneral').addEventListener('click', function () {
        validate(
            ['linkGeneralReferences'],
            'Por favor, ingreasa una referencia general.'
        );

    });

    document.querySelectorAll('.confirmationSave').forEach(function (button) {
        button.addEventListener('click', function () {

            dataConfirmation = this.getAttribute('data-confirmation');
            confirmationSave(dataConfirmation, courseId, learningId);

        });
    });

    document.querySelectorAll('.nextCard').forEach(function (button) {
        button.addEventListener('click', function () {
            blockAttributes(true, true);
            showNextCard();
        });
    });

});

