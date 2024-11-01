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
let component;

let dataConfirmation;

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
    function resetForm() {

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

    function selectRA(response, cd) {
        const selectElement = document.getElementById('pillSelectLearning');

        // Limpiar el contenido actual del select antes de agregar opciones nuevas
        selectElement.innerHTML = '';

        // Verificar si `learningResult` está presente y contiene un solo resultado
        if (cd == true) {
            const learning = response;  // Solo hay un resultado de aprendizaje
            const option = document.createElement('option');
            option.value = learning.id;
            option.text = learning.name_learning_result;
            option.selected = true; // Configura esta opción como seleccionada
            selectElement.appendChild(option);
            document.getElementById('textareaDescriptionRA').value = learning.description_learning_result;

        }
        // Si `learningResultsId` está presente, iterar sobre cada arreglo de resultados
        else if (cd == false) {
            document.getElementById('textareaDescriptionRA').value = '';

            const defaultOption = document.createElement('option');
            defaultOption.disabled = true;
            defaultOption.selected = true;
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

    function loadResultsSelect(program, learningId) {

        const selectElement = document.getElementById('pillSelectLearning');

        if (learningId == false) {
            if (program === '') {
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
                        bodyCourse.append('<tr><td colspan="6">No se encontraron cursos.</td></tr>');
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

                // Procesar la respuesta del servidor y actualizar la tabla de cursos
                var classroomPlans = response.classroomPlan; // Obtener la lista de cursos de la respuesta

                console.log
                var bodyComponent = $('#bodyComponent');
                bodyComponent.empty();

                // Verificar si se encontraron cursos en la respuesta
                if (classroomPlans.length > 0) {
                    classroomPlans.forEach(function (classroom) {
                        var row = `
                        <tr>                
                            <td>${capitalizeText(classroom.courses.component.study_field.name_study_field)}</td>
                            <td>${capitalizeText(classroom.courses.component.name_component)}</td>
                            <td>${capitalizeText(classroom.courses.name_course)}</td>
                            <td>${capitalizeText(classroom.courses.semester.name_semester)}</td>
                            <td>${classroom.courses.credit}</td>
                            <td>${capitalizeText(classroom.courses.course_type.name_course_type)}</td>
                        </tr>
                    `;
                        bodyComponent.append(row);
                    });
                } else {
                    // Mostrar un mensaje si no se encontraron cursos
                    bodyComponent.append('<tr><td colspan="6">No se encontraron cursos.</td></tr>');
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
        let hasEmptyField = fields.some(field => document.getElementById(field).value.trim() === "");

        if (hasEmptyField) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: alertMessage,
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Mostrar el modal si no hay campos vacíos
            $('#modalConfirmation').modal('show');
        }
    }

    function confirmationSave(dataConfirmation, courseId, learningId) {
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

            // Capturar el contenido del textarea
            var contentObjective = document.getElementById('textAreaObjective').value;

            // Imprimir en consola
            console.log(contentObjective);
        } else if (dataConfirmation == '3') {
            validate(
                ['textAreaSpecificOne', 'textAreaSpecificTwo', 'textAreaSpecificThree'],
                'Los campos de objetivos especificos no pueden estar vacíos.'
            );

            // Capturar el contenido del textarea
            var contentSpecificOne = document.getElementById('textAreaSpecificOne').value;
            var contentSpecificTwo = document.getElementById('textAreaSpecificTwo').value;
            var contentSpecificThree = document.getElementById('textAreaSpecificThree').value;

            // Imprimir en consola
            console.log(contentSpecificOne, contentSpecificTwo, contentSpecificThree);

        } else if (dataConfirmation == '4') {
            validate(
                ['textAreaThemeOne', 'textAreaThemeTwo', 'textAreaThemeThree', 'textAreaThemeFour', 'textAreaThemeFive'],
                'Los campos de temas no pueden estar vacíos.'
            );

            // Capturar el contenido del textarea
            var contentThemeOne = document.getElementById('textAreaThemeOne').value;
            var contentThemeTwo = document.getElementById('textAreaThemeTwo').value;
            var contentThemeThree = document.getElementById('textAreaThemeThree').value;
            var contentThemeFour = document.getElementById('textAreaThemeFour').value;
            var contenthemeFive = document.getElementById('textAreaThemeFive').value;

            // Imprimir en consola
            console.log(contentThemeOne, contentThemeTwo, contentThemeThree, contentThemeFour, contenthemeFive)

        } else if (dataConfirmation == '5') {
            validate(
                ['textAreaThemeSix', 'textAreaThemeSeven', 'textAreaThemeEight', 'textAreaThemeNine', 'textAreaThemeTen'],
                'Los campos de temas no pueden estar vacíos.'
            );

            // Capturar el contenido del textarea
            var contentThemeSix = document.getElementById('textAreaThemeSix').value;
            var contentThemeSeven = document.getElementById('textAreaThemeSeven').value;
            var contentThemeEight = document.getElementById('textAreaThemeEight').value;
            var contentThemeNine = document.getElementById('textAreaThemeNine').value;
            var contenthemeTen = document.getElementById('textAreaThemeTen').value;

            // Imprimir en consola
            console.log(contentThemeSix, contentThemeSeven, contentThemeEight, contentThemeNine, contenthemeTen)

        } else if (dataConfirmation == '6') {
            validate(
                ['textAreaThemeEleven', 'textAreaThemeTwelve', 'textAreaThemeThirteen', 'textAreaThemeFourteen', 'textAreaThemeFifteen', 'textAreaThemeSixteen'],
                'Los campos de temas no pueden estar vacíos.'
            );

            // Capturar el contenido del textarea
            var contentThemeEleven = document.getElementById('textAreaThemeEleven').value;
            var contentThemeTwelve = document.getElementById('textAreaThemeTwelve').value;
            var contentThemeThirteen = document.getElementById('textAreaThemeThirteen').value;
            var contentThemeFourteen = document.getElementById('textAreaThemeFourteen').value;
            var contenthemeFifteen = document.getElementById('textAreaThemeFifteen').value;
            var contenthemeSixteen = document.getElementById('textAreaThemeSixteen').value;

            // Imprimir en consola
            console.log(contentThemeEleven, contentThemeTwelve, contentThemeThirteen, contentThemeFourteen, contenthemeFifteen, contenthemeSixteen)

        } else if (dataConfirmation == '7') {
            $('#modalConfirmation').modal('show');

        } else if (dataConfirmation == '8') {
            $('#modalConfirmation').modal('show');

        }
    }

    // Terminar........
    function validateClassroomPlan(courseId, program) {
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

                    // Seleccionar todos los elementos con la clase 'nextCard' y quitar la clase 'd-none' de cada uno
                    document.querySelectorAll('.confirmationSave').forEach(function (button) {
                        button.classList.remove('d-none');
                    });

                    // Seleccionar todos los elementos con la clase 'nextCard' y añadir la clase 'd-none' a cada uno
                    document.querySelectorAll('.nextCard').forEach(function (button) {
                        button.classList.add('d-none');
                    });

                } else if (response.confirm == true) {
                    var learningId = response.classroomPlanId[0].learning_result;
                    selectRA(learningId, true);

                    // Seleccionar todos los elementos con la clase 'nextCard' y quitar la clase 'd-none' de cada uno
                    document.querySelectorAll('.nextCard').forEach(function (button) {
                        button.classList.remove('d-none');
                    });

                    // Seleccionar todos los elementos con la clase 'nextCard' y añadir la clase 'd-none' a cada uno
                    document.querySelectorAll('.confirmationSave').forEach(function (button) {
                        button.classList.add('d-none');
                    });
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

    function blockAttributes(state) {

        document.querySelectorAll('.readonlyCheck').forEach(function (element) {
            element.setAttribute('readonly', state);
        });

        // Obtener los elementos del formulario por su ID
        const selectFaculty = document.getElementById('pillSelectFaculty');
        const selectProgram = document.getElementById('pillSelectProgram');
        const filterCourseButton = document.getElementById('filterCourse');

        // Activar o desactivar los elementos según el valor de `state`
        selectFaculty.disabled = state;
        selectProgram.disabled = state;
        filterCourseButton.disabled = state;
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

                component = response.course[0].id_component;
                visualizeInfoCourse(response);
                tableComponent(component);
                validateClassroomPlan(courseId, program);
                typeCourseId = response.course[0].id_course_type;
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
        resetForm();
        selectProgram(faculty);
    });

    document.getElementById('pillSelectProgram').addEventListener('change', function () {
        program = this.options[this.selectedIndex].value;
        resetForm();
    });

    document.getElementById('pillSelectLearning').addEventListener('change', function () {
        learningId = this.value;
        console.log('RESULTADO-APRENDIZAJE', learningId);
        console.log('CURSO', courseId);
        console.log('TIPO DE CURSO', typeCourseId);
        selectLearning(learningId);
    });

    document.getElementById('filterCourse').addEventListener('click', function () {
        // Llamar a la función tableFiltersCourse con el programa actual
        tableFiltersCourse(program);
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        // Cambiar a la siguiente card
        showNextCard();

        // Cerrar el modal
        $('#modalConfirmation').modal('hide');
    });

    document.getElementById('saveInstitutional').addEventListener('click', function () {
        // Capturar el valor del input de referencia institucional
        const institutionalReference = document.getElementById('linkInstitutionalReferences').value;

        // Puedes hacer algo con el valor, como mostrar una alerta
        if (institutionalReference.trim() === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: "No has ingresado ninguna referencia institucional",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            console.log("Referencia institucional guardada: " + institutionalReference)
            Swal.fire({
                icon: 'success',
                title: 'Exito',
                text: "Se ha ingresado correctamente la referencia institucional",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
            // Limpiar el campo
            document.getElementById('linkInstitutionalReferences').value = "";
        }
    });

    document.getElementById('saveGeneral').addEventListener('click', function () {
        // Capturar el valor del input de referencia general
        const generalReference = document.getElementById('linkGeneralReferences').value;

        // Puedes hacer algo con el valor, como mostrar una alerta
        if (generalReference.trim() === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: "No has ingresado ninguna referencia general",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            console.log("Referencia general guardada: " + generalReference)
            Swal.fire({
                icon: 'success',
                title: 'Exito',
                text: "Se ha ingresado correctamente la referencia general",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
            // Limpiar el campo
            document.getElementById('linkGeneralReferences').value = "";
        }
    });

    // Seleccionar todos los elementos con la clase 'nextCard' y agregar el evento click
    document.querySelectorAll('.confirmationSave').forEach(function (button) {
        button.addEventListener('click', function () {

            // Captura el valor del atributo data-confirmation
            dataConfirmation = this.getAttribute('data-confirmation');
            console.log('confirmar', dataConfirmation);

            confirmationSave(dataConfirmation, courseId, learningId);
        });
    });

    // Seleccionar todos los elementos con la clase 'nextCard' y agregar el evento click
    document.querySelectorAll('.nextCard').forEach(function (button) {
        button.addEventListener('click', function () {
            blockAttributes(true);
            // Cambiar a la siguiente card
            showNextCard();
        });
    });
});

