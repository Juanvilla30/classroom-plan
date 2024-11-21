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
const userElement = document.getElementById('userId');

const userId = userElement.dataset.id;
const userProgramId = userElement.dataset.program;
const userRoleId = userElement.dataset.role;

let profilInfoId;
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
    if (userRoleId == 3) {
        validareUser(userId, userProgramId, userRoleId).then(response => {
            nameProfile = response;
            program = userProgramId;
        }).catch(error => {
            console.error("Error capturado en la validación del usuario:", error);
        });
    }

    function validareUser(userId, userProgramId, userRoleId) {
        return new Promise((resolve, reject) => {

            validateProfile(userProgramId, userRoleId);
            getNameProgram(userProgramId).then(response => {
                resolve(response);
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });

        });
    }

    // Función de redirección
    function redirect(id) {
        window.location.href = '/view-profiles-competencies-ra/' + id; // Cambia esto a la URL correcta
    }

    function capitalizeText(text) {
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

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

    function selectProgram(faculty) {

        const selectElement = document.getElementById('pillSelectProgram');

        if (faculty.trim() === '') {
            selectElement.disabled = true;
        } else {
            selectElement.disabled = false;
            $.ajax({
                url: '/profiles-competencies-ra/faculty-program',
                method: 'POST',
                data: {
                    faculty: faculty,
                },
                success: function (response) {
                    selectElement.innerHTML = '<option disabled selected value="">Seleccione un programa</option>';

                    response.listPrograms.forEach(function (program) {
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
                    $('#cursoTableBody').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                }
            });
        }

    }

    function getNameProgram(program) {
        return new Promise((resolve, reject) => {
            if (program !== null) {
                $.ajax({
                    url: '/profiles-competencies-ra/name-program',
                    method: 'POST',
                    data: { program: program },
                    success: function (response) {
                        const nameProgram = 'perfil de egreso de ' + response.listPrograms[0].name_program;
                        resolve(nameProgram);
                    },
                    error: function (xhr) {
                        console.error('Error en la solicitud:', xhr);
                        $('#cursoTableBody').html('<tr><td colspan="6">Ocurrió un error al buscar los cursos. Inténtalo de nuevo.</td></tr>');
                        reject(xhr.responseText || 'Error desconocido');
                    }
                });
            } else {
                resolve('perfil de egreso de campo común');
            }
        });
    }

    function resetForm(userRoleId) {
        if (userRoleId == '1' || userRoleId == '1') {
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
        } else {
            // Limpiar el textarea
            document.getElementById('textAreaProfile').value = '';
            document.getElementById('textAreaCompetitionOne').value = '';
            document.getElementById('textAreaCompetitionTwo').value = '';
            document.getElementById('textAreaRaOne').value = '';
            document.getElementById('textAreaRaTwo').value = '';
            document.getElementById('textAreaRaThree').value = '';
            document.getElementById('textAreaRaFour').value = '';
        }
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
                    var profileId = response.profileCreate.id;
                    var competitionIds = response.createdCompetitions.map(comp => comp.id);
                    var rAIds = response.createdResults.map(result => result.id);

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

    function confirmationSave(dataConfirmation) {
        if (dataConfirmation == '1') {
            validate(
                ['textAreaProfile'],
                'El campo de perfil de egreso no pueden estar vacíos.'
            );
        } else if (dataConfirmation == '2') {
            validate(
                ['textAreaCompetitionOne', 'textAreaCompetitionTwo'],
                'Los campo de competencias no pueden estar vacíos.'
            );
        } else if (dataConfirmation == '3') {
            validate(
                ['textAreaRaOne', 'textAreaRaTwo'],
                'Los campo de resultados de aprendizaje no pueden estar vacíos.'
            );
        } else if (dataConfirmation == '4') {
            validate(
                ['textAreaRaThree', 'textAreaRaFour'],
                'Los campo de resultados de aprendizaje no pueden estar vacíos.'
            );
        }
    }

    function confirmButton(dataConfirmation, userRoleId) {
        // Cambiar a la siguiente card
        showNextCard();

        // Cerrar el modal
        $('#modalConfirmation').modal('hide');

        var contentProfile = document.getElementById('textAreaProfile').value;
        var contentCompetitionOne = document.getElementById('textAreaCompetitionOne').value;
        var contentCompetitionTwo = document.getElementById('textAreaCompetitionTwo').value;

        var contentRaOne = document.getElementById('textAreaRaOne').value;
        var contentRaTwo = document.getElementById('textAreaRaTwo').value;
        var contentRaThree = document.getElementById('textAreaRaThree').value;
        var contentRaFour = document.getElementById('textAreaRaFour').value;

        if (contentCompetitionOne.trim() !== '') {
            document.querySelector('#contCompeOne .card-body').innerText = contentCompetitionOne;
        }
        if (contentCompetitionTwo.trim() !== '') {
            document.querySelector('#contCompeTwo .card-body').innerText = contentCompetitionTwo;
        }

        if (dataConfirmation == '1') {
            if (contentProfile.trim() !== '') {
                saveProfile(nameProfile, contentProfile, program)
                    .then(({ profileId, competitionIds, rAIds }) => {
                        competenceId0 = competitionIds[0];
                        competenceId1 = competitionIds[1];
                        profileIds = profileId;
                        rAIdsOne = rAIds[0];
                        rAIdsTwo = rAIds[1];
                        rAIdsThree = rAIds[2];
                        rAIdsFour = rAIds[3];
                    })
                    .catch(error => {
                        console.error("Error en la solicitud AJAX:", error);
                    });
                resetForm(userRoleId);
            }
        } else if (dataConfirmation == '2') {
            if (contentCompetitionOne.trim() !== '' && contentCompetitionTwo.trim() !== '') {
                saveCompetition(competenceId0, competenceId1, contentCompetitionOne, contentCompetitionTwo, profileIds).then(response => {
                    contentCompetitionOne = '';
                    contentCompetitionTwo = '';
                })
                    .catch(error => {
                        console.error("Error en la solicitud AJAX:", error);
                    });
                resetForm(userRoleId);
            }
        } else if (dataConfirmation == '3') {
            if (contentRaOne.trim() !== '' && contentRaTwo.trim() !== '') {
                var nameRaOne = 'Resultados de aprendizaje #1';
                var nameRaTwo = 'Resultados de aprendizaje #2';
                saveRA(rAIdsOne, rAIdsTwo, nameRaOne, nameRaTwo, contentRaOne, contentRaTwo, competenceId0).then(() => {
                    contentRaOne = '';
                    contentRaTwo = '';
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
                resetForm(userRoleId);
            }
        } else if (dataConfirmation == '4') {
            if (contentRaThree.trim() !== '' && contentRaFour.trim() !== '') {
                var nameRaThree = 'Resultados de aprendizaje #3';
                var nameRaFour = 'Resultados de aprendizaje #4';
                saveRA(rAIdsThree, rAIdsFour, nameRaThree, nameRaFour, contentRaThree, contentRaFour, competenceId1).then(() => {
                    contentRaThree = '';
                    contentRaFour = '';
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
                resetForm(userRoleId);
            }
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

    function validateProfile(programId, userRoleId) {
        $.ajax({
            url: '/profiles-competencies-ra/validate-profile',
            method: 'POST',
            data: {
                programId: programId,
            },
            success: function (response) {

                if (response.confirm == 'perfil no encontrado') {

                    document.querySelectorAll('.readonlyField').forEach(function (textarea) {
                        textarea.value = '';
                    });

                    document.querySelectorAll('.confirmationSave').forEach(function (button) {
                        button.classList.remove('d-none');
                    });

                    document.querySelectorAll('.readonlyField').forEach(function (element) {
                        element.removeAttribute('readonly');
                    });

                    document.querySelectorAll('.nextCard').forEach(function (button) {
                        button.classList.add('d-none');
                    });

                } else {

                    var profileCont = response.profileId[0].description_profile_egres;
                    var competenceCont = response.competencesId;
                    var learningCont = response.learningResultsId;
                    let id = response.profileId[0].id

                    if (userRoleId == 3) {
                        document.getElementById('btnActivateUpdate').classList.remove('d-none')
                        document.getElementById('activateUpdate').addEventListener('click', function () {
                            redirect(id);
                        });
                    }

                    document.querySelectorAll('.readonlyField').forEach(function (textarea) {
                        textarea.value = '';
                    });

                    document.querySelectorAll('.nextCard').forEach(function (button) {
                        button.classList.remove('d-none');
                    });

                    document.querySelectorAll('.readonlyField').forEach(function (element) {
                        element.setAttribute('readonly', true);
                    });

                    document.querySelectorAll('.confirmationSave').forEach(function (button) {
                        button.classList.add('d-none');
                    });

                    document.getElementById('textAreaProfile').value = profileCont;

                    competenceCont.forEach(function (competence) {
                        if (competence.name_competence === 'Competencias #1') {
                            document.getElementById('textAreaCompetitionOne').value = competence.description_competence;
                            document.querySelector('#contCompeOne .card-body').innerText = competence.description_competence;
                        } else if (competence.name_competence === 'Competencias #2') { // Asegúrate de tener Competencias #2
                            document.getElementById('textAreaCompetitionTwo').value = competence.description_competence;
                            document.querySelector('#contCompeTwo .card-body').innerText = competence.description_competence;
                        }
                    });

                    Object.keys(learningCont).forEach(function (competenceId) {
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
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function validateProfileInformation(profilInfoId) {
        if (profilInfoId == 'true') {
            document.querySelectorAll('.confirmationSave').forEach(function (button) {
                button.classList.add('d-none');
            });

            document.querySelectorAll('.nextCard').forEach(function (button) {
                button.classList.add('d-none');
            });

            document.getElementById('showFaculty').classList.remove('d-none');
            document.getElementById('showProgram').classList.remove('d-none');
            const pillSelectFaculty = document.getElementById("pillSelectFaculty");
            const pillSelectProgram = document.getElementById("pillSelectProgram");
            const textAreaProfile = document.getElementById("textAreaProfile");

            if (pillSelectFaculty) {
                pillSelectFaculty.selectedIndex = 0;
            }
            if (pillSelectProgram) {
                pillSelectProgram.selectedIndex = 0;
                pillSelectProgram.disabled = true;
            }
            if (textAreaProfile) {
                textAreaProfile.value = '';
            }

        } else if (profilInfoId == 'false') {
            document.querySelectorAll('.confirmationSave').forEach(function (button) {
                button.classList.add('d-none');
            });

            document.querySelectorAll('.nextCard').forEach(function (button) {
                button.classList.add('d-none');
            });

            document.getElementById('showFaculty').classList.add('d-none');
            document.getElementById('showProgram').classList.add('d-none');
            const textAreaProfile = document.getElementById("textAreaProfile");

            if (textAreaProfile) {
                textAreaProfile.value = '';
            }

            validateProfile(null);
            getNameProgram(null).then(response => {
                nameProfile = response;
            })
                .catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
        }
    }

    /*
        *
        * Event Listener
        *
    */
    if (userRoleId == 1 || userRoleId == 2) {

        document.getElementById('selectProfileInformation').addEventListener('change', function () {
            profilInfoId = this.value;
            validateProfileInformation(profilInfoId);
        });

        document.getElementById('pillSelectFaculty').addEventListener('change', function () {
            faculty = this.value;
            selectProgram(faculty);
        });

        document.getElementById('pillSelectProgram').addEventListener('change', function () {
            program = this.value;
            validateProfile(program, userRoleId);
            getNameProgram(program).then(response => {
                nameProfile = response;
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });
        });
    }

    document.querySelectorAll('.confirmationSave').forEach(function (button) {
        button.addEventListener('click', function () {
            dataConfirmation = this.getAttribute('data-confirmation');
            confirmationSave(dataConfirmation);
        });
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        confirmButton(dataConfirmation, userRoleId);
    });

    document.querySelectorAll('.nextCard').forEach(function (button) {
        button.addEventListener('click', function () {
            showNextCard();
        });
    });

}); 
