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
let nameProfile;
let profileIds;

let competenceId0;
let competenceId1;

let rAIdsOne;
let rAIdsTwo;
let rAIdsThree;
let rAIdsFour;

let competitionsIdOne;
let competitionsIdTwo;

document.addEventListener("DOMContentLoaded", function () {
    /*
        *
        * ARREGLOS
        *
    */

    // Arreglo con los IDs de las cards
    const cards = ['card-1', 'card-2', 'card-3', 'card-4'];

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
                text: 'Se ha creado correctamente el perfil de egreso',
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

    // Función para habilitar o deshabilitar el select según el valor de 'prueba'
    function selectProgram(faculty) {

        const selectElement = document.getElementById('pillSelectProgram');

        if (faculty.trim() === '') {
            selectElement.disabled = true;
        } else {
            selectElement.disabled = false;
            // Realizar una solicitud AJAX para obtener los cursos según los parámetros proporcionados
            $.ajax({
                url: '/profiles-competencies-ra/faculty-program', // URL 
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

                    // Mostrar un mensaje de error en la tabla en caso de error en la solicitud
                    $('#cursoTableBody').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                }
            });
        }

    }

    function getNameProgram(program) {

        return new Promise((resolve, reject) => {
            // Realizar una solicitud AJAX para obtener los cursos según los parámetros proporcionados
            $.ajax({
                url: '/profiles-competencies-ra/name-program', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
                    program: program,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {
                    // Resolvemos la promesa con la respuesta del servidor
                    var nameProgram = response.listPrograms[0].name_program;

                    nameProgram = 'perfil de grado de ' + nameProgram;

                    resolve(nameProgram);
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

                    // Mostrar un mensaje de error en la tabla en caso de error en la solicitud
                    $('#cursoTableBody').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                }
            });
        });
    }

    // Función para reiniciar el formulario
    function resetForm() {
        // Reiniciar el selector de facultad
        var facultySelect = document.getElementById('pillSelectFaculty');
        facultySelect.selectedIndex = 0; // Seleccionar la opción por defecto

        // Reiniciar el selector de programas y deshabilitarlo
        var programSelect = document.getElementById('pillSelectProgram');
        programSelect.selectedIndex = 0; // Seleccionar la opción por defecto
        programSelect.disabled = true; // Deshabilitar el select

        // Limpiar el textarea
        document.getElementById('textAreaProfile').value = '';
        document.getElementById('textAreaCompetitionOne').value = '';
        document.getElementById('textAreaCompetitionTwo').value = '';
        document.getElementById('textAreaRaOne').value = '';
        document.getElementById('textAreaRaTwo').value = '';
        document.getElementById('textAreaRaThree').value = '';
        document.getElementById('textAreaRaFour').value = '';
        // (Si necesitas reiniciar otros textareas, hazlo aquí)
    }

    function saveProfile(nameProfile, profile, program) {
        const competitions = ['Competencias #1', 'Competencias #2'];
        const competitionContent = 'No se asignó ninguna competencia.';

        const learningResults = [
            'Resultados de aprendizaje #1',
            'Resultados de aprendizaje #2',
            'Resultados de aprendizaje #3',
            'Resultados de aprendizaje #4'
        ];
        const learningResultContent = 'No se asignó ningún resultado de aprendizaje.';

        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/profiles-competencies-ra/save-profile',
                method: 'POST',
                data: {
                    nameProfile,
                    profile,
                    program,
                    nameCompetitionOne: competitions[0],
                    nameCompetitionTwo: competitions[1],
                    competitionOne: competitionContent,
                    competitionTwo: competitionContent,
                    nameRaOne: learningResults[0],
                    nameRaTwo: learningResults[1],
                    nameRaThree: learningResults[2],
                    nameRaFour: learningResults[3],
                    contentRaOne: learningResultContent,
                    contentRaTwo: learningResultContent,
                    contentRaThree: learningResultContent,
                    contentRaFour: learningResultContent,
                },
                success: function (response) {
                    // Asignar los IDs a las variables
                    var profileId = response.profileCreate.id;
                    var competitionIds = response.createdCompetitions.map(comp => comp.id); // Suponiendo que es un array
                    var rAIds = response.createdResults.map(result => result.id); // Suponiendo que es un array

                    // Pasar las variables al resolver
                    resolve({ profileId, competitionIds, rAIds });
                },
                error: function (xhr, status, error) {
                    console.error('Error:', xhr, status, error, xhr.responseText);
                    reject(error);
                    $('#cursoTableBody').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                }
            });
        });
    }

    function saveCompetition(competenceId0, competenceId1, competitionOne, competitionTwo, profileId) {
        var nameCompetitionOne = 'Competencias #1';
        var nameCompetitionTwo = 'Competencias #2';

        return new Promise((resolve, reject) => {
            // Realizar una solicitud AJAX para actualizar las competencias
            $.ajax({
                url: '/profiles-competencies-ra/save-competition',
                method: 'PUT',
                data: {
                    nameCompetitionOne: nameCompetitionOne,
                    nameCompetitionTwo: nameCompetitionTwo,
                    competitionOne: competitionOne,
                    competitionTwo: competitionTwo,
                    profileId: profileId,
                    competenceId0: competenceId0,  // Enviar ID de competencia 1
                    competenceId1: competenceId1,   // Enviar ID de competencia 2
                },
                success: function (response) {
                    if (Array.isArray(response.competitionUpdate) && response.competitionUpdate.length > 0) {
                        const competitionIds = response.competitionUpdate.map(competition => competition.id);
                        resolve(competitionIds);
                    } else {
                        reject('Competencias no fueron actualizadas correctamente.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    reject(error);
                }
            });
        });
    }

    function saveRA(rAIdsOne, rAIdsTwo, nameRaOne, nameRaTwo, contentRaOne, contentRaTwo, competitions) {

        return new Promise((resolve, reject) => {
            // Realizar una solicitud AJAX para obtener los cursos según los parámetros proporcionados
            $.ajax({
                url: '/profiles-competencies-ra/save-ra', // URL 
                method: 'PUT', // Método de la solicitud: POST
                data: {
                    rAIdsOne: rAIdsOne,
                    rAIdsTwo: rAIdsTwo,
                    nameRaOne: nameRaOne,
                    nameRaTwo: nameRaTwo,
                    contentRaOne: contentRaOne,
                    contentRaTwo: contentRaTwo,
                    competitions: competitions,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {

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

                    // Mostrar un mensaje de error en la tabla en caso de error en la solicitud
                    $('#cursoTableBody').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                }
            });
        });

    }

    function confirmButton() {
        // Cambiar a la siguiente card
        showNextCard();

        // Cerrar el modal
        $('#modalConfirmation').modal('hide');

        // Obtener contenido de los campos de texto
        var contentProfile = document.getElementById('textAreaProfile').value;
        var contentCompetitionOne = document.getElementById('textAreaCompetitionOne').value;
        var contentCompetitionTwo = document.getElementById('textAreaCompetitionTwo').value;

        // Resultados de aprendizaje
        var contentRaOne = document.getElementById('textAreaRaOne').value;
        var contentRaTwo = document.getElementById('textAreaRaTwo').value;
        var contentRaThree = document.getElementById('textAreaRaThree').value;
        var contentRaFour = document.getElementById('textAreaRaFour').value;

        if (contentCompetitionOne.trim() !== '') {
            // Establecer el contenido en el acordeón
            document.querySelector('#contCompeOne .card-body').innerText = contentCompetitionOne;
        }
        if (contentCompetitionTwo.trim() !== '') {
            // Establecer el contenido en el acordeón
            document.querySelector('#contCompeTwo .card-body').innerText = contentCompetitionTwo;
        }

        // Guardar el perfil si el contenido no está vacío
        if (contentProfile.trim() !== '') {
            saveProfile(nameProfile, contentProfile, program)
                .then(({ profileId, competitionIds, rAIds }) => { // Desestructuración de la respuesta

                    competenceId0 = competitionIds[0]; // Asegúrate de que response sea un array
                    competenceId1 = competitionIds[1]; // También debe ser un array
                    profileIds = profileId;
                    rAIdsOne = rAIds[0];
                    rAIdsTwo = rAIds[1];
                    rAIdsThree = rAIds[2];
                    rAIdsFour = rAIds[3];

                    // Asignar el ID del perfil guardado
                    contentProfile = ''; // Limpiar el contenido después de guardarlo

                    // Reiniciar el formulario después de guardar
                    resetForm();
                })
                .catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
        }

        if (contentCompetitionOne.trim() !== '' && contentCompetitionTwo.trim() !== '') {
            saveCompetition(competenceId0, competenceId1, contentCompetitionOne, contentCompetitionTwo, profileIds).then(response => {
                contentCompetitionOne = ''; // Limpiar después de guardar
                contentCompetitionTwo = '';

                // Reiniciar el formulario después de guardar
                resetForm();
            })
                .catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
        }

        if (contentRaOne.trim() !== '' && contentRaTwo.trim() !== '') {
            var nameRaOne = 'Resultados de aprendizaje #1';
            var nameRaTwo = 'Resultados de aprendizaje #2';
            saveRA(rAIdsOne, rAIdsTwo, nameRaOne, nameRaTwo, contentRaOne, contentRaTwo, competenceId0).then(() => {
                contentRaOne = ''; // Limpiar después de guardar
                contentRaTwo = '';
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });

            // Reiniciar el formulario después de guardar
            resetForm();
        }

        if (contentRaThree.trim() !== '' && contentRaFour.trim() !== '') {
            var nameRaThree = 'Resultados de aprendizaje #3';
            var nameRaFour = 'Resultados de aprendizaje #4';
            saveRA(rAIdsThree, rAIdsFour, nameRaThree, nameRaFour, contentRaThree, contentRaFour, competenceId1).then(() => {
                contentRaThree = ''; // Limpiar después de guardar
                contentRaFour = '';
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });

            // Reiniciar el formulario después de guardar
            resetForm();

        }
    }

    function validate(fields, alertMessage) {
        let hasEmptyField = fields.some(field => document.getElementById(field).value.trim() === "");

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

    function validateProfile(programId) {
        $.ajax({
            url: '/profiles-competencies-ra/validate-profile', // URL 
            method: 'POST', // Método de la solicitud: POST
            data: {
                programId: programId,
            },
            // Función que se ejecuta en caso de éxito en la solicitud
            success: function (response) {

                if (response.confirm == 'perfil no encontrado') {

                    // Seleccionar todos los elementos con la clase 'readonlyField' y vaciar su contenido
                    document.querySelectorAll('.readonlyField').forEach(function (textarea) {
                        textarea.value = '';
                    });

                    // Seleccionar todos los elementos con la clase 'nextCard' y quitar la clase 'd-none' de cada uno
                    document.querySelectorAll('.savePCRA').forEach(function (button) {
                        button.classList.remove('d-none');
                    });

                    document.querySelectorAll('.readonlyField').forEach(function (element) {
                        element.removeAttribute('readonly');
                    });

                    // Seleccionar todos los elementos con la clase 'nextCard' y añadir la clase 'd-none' a cada uno
                    document.querySelectorAll('.nextCard').forEach(function (button) {
                        button.classList.add('d-none');
                    });

                } else {

                    var profileCont = response.profileId[0].description_profile_egres;
                    var competenceCont = response.competencesId;
                    var learningCont = response.learningResultsId;

                    // Seleccionar todos los elementos con la clase 'readonlyField' y vaciar su contenido
                    document.querySelectorAll('.readonlyField').forEach(function (textarea) {
                        textarea.value = '';
                    });

                    // Seleccionar todos los elementos con la clase 'nextCard' y quitar la clase 'd-none' de cada uno
                    document.querySelectorAll('.nextCard').forEach(function (button) {
                        button.classList.remove('d-none');
                    });

                    document.querySelectorAll('.readonlyField').forEach(function (element) {
                        element.setAttribute('readonly', true);
                    });

                    // Seleccionar todos los elementos con la clase 'nextCard' y añadir la clase 'd-none' a cada uno
                    document.querySelectorAll('.savePCRA').forEach(function (button) {
                        button.classList.add('d-none');
                    });

                    // Seleccionar el textarea por su id y asignar el contenido de 'prueba'
                    document.getElementById('textAreaProfile').value = profileCont;

                    // Llenar los textarea para competencias
                    competenceCont.forEach(function (competence) {
                        if (competence.name_competence === 'Competencias #1') {
                            document.getElementById('textAreaCompetitionOne').value = competence.description_competence;
                            document.querySelector('#contCompeOne .card-body').innerText = competence.description_competence;
                        } else if (competence.name_competence === 'Competencias #2') { // Asegúrate de tener Competencias #2
                            document.getElementById('textAreaCompetitionTwo').value = competence.description_competence;
                            document.querySelector('#contCompeTwo .card-body').innerText = competence.description_competence;
                        }
                    });

                    // Llenar los textarea para resultados de aprendizaje
                    Object.keys(learningCont).forEach(function (competenceId) {
                        // Obtener los resultados de aprendizaje para el ID de competencia actual
                        var results = learningCont[competenceId];

                        results.forEach(function (learningResult) {
                            if (learningResult.name_learning_result === 'Resultados de aprendizaje #1') {
                                document.getElementById('textAreaRaOne').value = learningResult.description_learning_result;
                            } else if (learningResult.name_learning_result === 'Resultados de aprendizaje #2') {
                                document.getElementById('textAreaRaTwo').value = learningResult.description_learning_result;
                            } else if (learningResult.name_learning_result === 'Resultados de aprendizaje #3') {
                                document.getElementById('textAreaRaThree').value = learningResult.description_learning_result;
                            } else if (learningResult.name_learning_result === 'Resultados de aprendizaje #4') {
                                document.getElementById('textAreaRaFour').value = learningResult.description_learning_result;
                            }
                        });
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

    /*
        *
        * Event Listener
        *
    */

    document.getElementById('pillSelectFaculty').addEventListener('change', function () {
        faculty = this.options[this.selectedIndex].value;
        selectProgram(faculty);
    });

    document.getElementById('pillSelectProgram').addEventListener('change', function () {
        program = this.options[this.selectedIndex].value;
        validateProfile(program);
        getNameProgram(program).then(response => {
            nameProfile = response;
        })
            .catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyOne').addEventListener('click', function () {
        validate(
            ['textAreaProfile'],
            'El campo de perfil de egreso no pueden estar vacíos.'
        );
    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyTwo').addEventListener('click', function () {
        validate(
            ['textAreaCompetitionOne', 'textAreaCompetitionTwo'],
            'Los campo de competencias no pueden estar vacíos.'
        );
    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyThree').addEventListener('click', function () {
        validate(
            ['textAreaRaOne', 'textAreaRaTwo'],
            'Los campo de resultados de aprendizaje no pueden estar vacíos.'
        );
    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyFour').addEventListener('click', function () {
        validate(
            ['textAreaRaThree', 'textAreaRaFour'],
            'Los campo de resultados de aprendizaje no pueden estar vacíos.'
        );
    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirm-button').addEventListener('click', function () {
        confirmButton();
    });

    // Seleccionar todos los elementos con la clase 'nextCard' y agregar el evento click
    document.querySelectorAll('.nextCard').forEach(function (button) {
        button.addEventListener('click', function () {
            console.log('confirmar');
            // Cambiar a la siguiente card
            showNextCard();
        });
    });

}); 
