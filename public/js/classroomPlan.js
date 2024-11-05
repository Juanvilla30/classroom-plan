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
// IDS
let educationId;
let facultyId;
let programId;

// INFO
let facultyInfo;

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
            Swal.fire({
                icon: 'success',
                title: 'Exito',
                text: 'Se ha creado correctamente el plan de aula',
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            }).then((result) => {
                // Si el usuario confirma la acción
                if (result.isConfirmed) {
                    // Recargar la página cuando llegues a la última card
                    location.reload();
                } else {
                    location.reload();
                    console.log('Eliminacion cancelada por el usuario'); // Mensaje en consola si el usuario cancela la acción
                }
            });
        }
    }

    // SEARCH
    function searchFaculty(educationId) {
        facultyId = '';
        programId = '';
        $.ajax({
            url: '/classroom-plan/search-faculty',
            method: 'GET',
            success: function (response) {
                facultyInfo = response.facultyInfo
                viewSelectCourse(facultyInfo, educationId);
                console.log(response.facultyInfo);
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function searchCourses(programId) {
        if (programId) {
            $('#modalCourse').modal('show');

            $.ajax({
                url: '/classroom-plan/search-course',
                method: 'POST', 
                data: {
                    programId: programId,
                },
                success: function (response) {
                    console.log(response)
                    let relationInfo = response.relationInfo;
                    console.log(relationInfo)

                    let bodyCourse = $('#bodyCourses');
                    bodyCourse.empty();

                    if (relationInfo.length > 0) {
                        relationInfo.forEach(function (relation) {
                            let row = `
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm courseSelect" 
                                        data-id="${relation.course.id}" data-dismiss="modal">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </td>
                                <td>${capitalizeText(relation.program.faculty.name_faculty)}</td>
                                <td>${capitalizeText(relation.program.name_program)}</td>
                                <td>${capitalizeText(relation.course.component.study_field.name_study_field)}</td>
                                <td>${capitalizeText(relation.course.component.name_component)}</td>
                                <td>${capitalizeText(relation.course.name_course)}</td>
                                <td>${capitalizeText(relation.course.semester.name_semester)}</td>
                                <td>${relation.course.credit}</td>
                                <td>${capitalizeText(relation.course.course_type.name_course_type)}</td>
                            </tr>
                        `;
                            bodyCourse.append(row);
                        });
                    } else {
                        // Mostrar un mensaje si no se encontraron cursos
                        bodyCourse.append('<tr><td colspan="6">No se encontraron.</td></tr>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                    $('#bodyCourses').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                }
            });
        } else {
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

    function searchLearning() {
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

    // VIEW
    function viewSelectCourse(facultyInfo, educationId) {
        document.getElementById('fromSelectCourse').classList.remove('d-none');
        let selectsContent = `
            <div class="form-group">
                    <label for="selectFaculty">Selección facultad</label>
                    <select class="form-control input-pill" id="selectFaculty">
                        <option disabled selected value="">Seleccione una facultad</option>
        `;

        if (facultyInfo.length > 0) {
            facultyInfo.forEach((faculty, index) => {
                const i = index + 1;
                selectsContent += `
                        <option value="${faculty.id}">${capitalizeText(faculty.name_faculty)}</option>
                `;
            });

            selectsContent += `
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectProgram">Selección programa</label>
                    <select class="form-control input-pill" id="selectProgram" disabled>
                        <option disabled selected value="">Seleccione un programa</option>

                    </select>
                </div>

                <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;" id="buttonSearchCourse">
                    Seleccione el curso
                </button>
            `;
            document.getElementById("fromSelectCourse").innerHTML = selectsContent;
            select(educationId);

        } else {

            document.getElementById("fromSelectCourse").innerHTML = '<h3>No se encontraron resultados.</h3>';

        }
    }

    function selectProgram(facultyId, educationId) {
        const selectElement = document.getElementById('selectProgram');

        if (facultyId === '') {
            selectElement.disabled = true;
        } else {
            selectElement.disabled = false;

            $.ajax({
                url: '/classroom-plan/search-program',
                method: 'POST',
                data: {
                    faculty: facultyId,
                    educationId: educationId,
                },
                success: function (response) {
                    selectElement.innerHTML = '<option disabled selected value="">Seleccione un programa</option>';

                    response.programsInfo.forEach(function (program) {
                        const option = document.createElement('option');
                        option.value = program.id;
                        option.text = program.name_program.charAt(0).toUpperCase() + program.name_program.slice(1).toLowerCase(); // Capitalizar
                        selectElement.appendChild(option);
                    });

                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);

                }
            });
        }

    }

    function select(educationId) {
        document.getElementById('selectFaculty').addEventListener('change', function () {
            facultyId = this.options[this.selectedIndex].value;
            selectProgram(facultyId, educationId);
        });

        document.getElementById('selectProgram').addEventListener('change', function () {
            programId = this.options[this.selectedIndex].value;
        });

        document.getElementById('buttonSearchCourse').addEventListener('click', function () {
            searchCourses(programId);
        });
    }

    /*
        *
        * Event Listener
        *
    */
    document.getElementById('selectEducation').addEventListener('change', function () {
        educationId = this.options[this.selectedIndex].value;
        searchFaculty(educationId);

    });
});

