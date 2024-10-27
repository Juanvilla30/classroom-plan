// Configurar el token CSRF para todas las solicitudes AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * VARIABLES
        *
    */

    var program; // DECLARA UNA VARIABLE PARA ALMACENAR EL SELECCIONADO
    var cursoId;
    var component;

    /*
        *
        * ARREGLOS
        *
    */

    // Arreglo con los IDs de las cards
    const cards = ['card-1', 'card-2', 'card-3', 'card-4', 'card-5', 'card-6', 'card-7'];

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

    // Función para visualizar un horario modal
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
                    
                    var tableCourses = $('#tableCourses');
                    tableCourses.empty();
                    console.log(courses.component.studyField)
                    // Verificar si se encontraron cursos en la respuesta
                    if (courses.length > 0) {
                        courses.forEach(function (course) {
                            var program = programs.find(p => p.id === course.id_program);
                            var row = `
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm courseSelect" 
                                        data-id="${course.id}" data-dismiss="modal">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </td>
                                <td>${programs.faculty ? programs.faculty.name_faculty : 'Sin Facultad'}</td>
                                <td>${programs.name_program}</td>
                                <td>${course.component.studyField.name_study_field}</td>
                                <td>${course.component.name_component}</td>
                                <td>${course.name_curse}</td>
                                <td>${course.semester.name_semester}</td>
                                <td>${course.credit}</td>
                                <td>${course.courseType.name_course_type}</td>
                            </tr>
                        `;
                            tableCourses.append(row);
                        });
                    } else {
                        // Mostrar un mensaje si no se encontraron cursos
                        tableCourses.append('<tr><td colspan="6">No se encontraron cursos.</td></tr>');
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
                    $('#cursoTableBody').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                }
            });
        } else {
            // Mostrar un mensaje de error si faltan opciones seleccionadas
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor selecciona el programa para poder seleccionar un curso',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
            event.preventDefault();
        }
    }

    // Función genérica para validar campos vacíos y mostrar alerta o modal
    function validate(fields, alertMessage) {
        let hasEmptyField = fields.some(field => document.getElementById(field).value.trim() === "");

        if (hasEmptyField) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: alertMessage,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Mostrar el modal si no hay campos vacíos
            $('#modalConfirmation').modal('show');
        }
    }

    function tableFieldStudy(component) {

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

                var bodyComponent = $('#bodyComponent');
                bodyComponent.empty();

                // Verificar si se encontraron cursos en la respuesta
                if (classroomPlans.length > 0) {
                    classroomPlans.forEach(function (classroom) {
                        var row = `
                        <tr>                
                            <td>${capitalizeText(classroom.course.name_curse)}</td>
                            <td>${capitalizeText(classroom.course.component.field_study.name_field_study)}</td>
                            <td>${capitalizeText(classroom.course.component.name_component)}</td>
                            <td>${capitalizeText(classroom.course.semester.name_semester)}</td>
                            <td>${classroom.course.credit}</td>
                            <td>${capitalizeText(classroom.course.type_course.name_type_course)}</td>
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

    // Función para mostrar la información del curso
    function visualizeInfoCourse(response) {
        console.log(response);  // Verificar el contenido del objeto

        // Actualizar los campos en el área #course-info
        $('#nameFaculty').text(capitalizeText(response.curse.program.faculti.name_faculty));
        $('#nameProgram').text(capitalizeText(response.curse.program.name_program));
        $('#nameField').text(capitalizeText(response.curse.component.field_study.name_field_study));
        $('#nameComponent').text(capitalizeText(response.curse.component.name_component));
        $('#nameCourse').text(capitalizeText(response.curse.name_curse));
        $('#nameSemester').text(capitalizeText(response.curse.semester.name_semester));
        $('#nameCredits').text(response.curse.credit);
        $('#nameCourseType').text(capitalizeText(response.curse.type_course.name_type_course));

    }

    /*
        *
        * AJAX
        *
    */

    $('#multi-filter-select').on('click', '.courseSelect', function () {
        // OBTIENE EL VALOR DEL SEMESTRE SELECCIONADO
        cursoId = $(this).data('id');
        console.log('course: ', cursoId)

        // Realizar la petición AJAX
        $.ajax({
            url: '/classroom-plan/visualize-info-course',
            type: 'POST',
            data: {
                cursoId: cursoId
            },
            success: function (response) {
                component = response.curse.id_component;
                console.log('componente', component);

                tableFieldStudy(component);
                visualizeInfoCourse(response);

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

    document.getElementById('pillSelectProgram').addEventListener('change', function () {

        // OBTIENE EL VALOR DEL SEMESTRE SELECCIONADO
        program = this.options[this.selectedIndex].value;
        console.log('programa: ', program)

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('filterCourse').addEventListener('click', function () {
        tableFiltersCourse(program);
    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirm-button').addEventListener('click', function () {
        // Cambiar a la siguiente card
        showNextCard();

        // Cerrar el modal
        $('#modalConfirmation').modal('hide');
    });

    // Escuchar el click en los botones y validar los campos correspondientes
    document.getElementById('confirmationEmptyOne').addEventListener('click', function () {
        validate(
            ['textAreaObjective'],
            'El campo objetivo general no puede estar vacío.'
        );

        // Capturar el contenido del textarea
        var contentObjective = document.getElementById('textAreaObjective').value;

        // Imprimir en consola
        console.log(contentObjective)
    });

    document.getElementById('confirmationEmptyTwo').addEventListener('click', function () {
        validate(
            ['textAreaSpecificOne', 'textAreaSpecificTwo', 'textAreaSpecificThree'],
            'Los campos de objetivos especificos no pueden estar vacíos.'
        );

        // Capturar el contenido del textarea
        var contentSpecificOne = document.getElementById('textAreaSpecificOne').value;
        var contentSpecificTwo = document.getElementById('textAreaSpecificTwo').value;
        var contentSpecificThree = document.getElementById('textAreaSpecificThree').value;

        // Imprimir en consola
        console.log(contentSpecificOne, contentSpecificTwo, contentSpecificThree)
    });

    document.getElementById('confirmationEmptyThree').addEventListener('click', function () {
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
    });

    document.getElementById('confirmationEmptyFour').addEventListener('click', function () {
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
    });

    document.getElementById('confirmationEmptyFive').addEventListener('click', function () {
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
    });

    document.getElementById('confirmationEmptySix').addEventListener('click', function () {
        $('#modalConfirmation').modal('show');
    });

    document.getElementById('confirmationEmptySeven').addEventListener('click', function () {
        $('#modalConfirmation').modal('show');
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

});

