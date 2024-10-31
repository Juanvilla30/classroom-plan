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
let profileId;
let competitionsOne;
let competitionsTwo;

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
            // Recargar la página cuando llegues a la última card
            location.reload();
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

        return new Promise((resolve, reject) => {
            // Realizar una solicitud AJAX para obtener los cursos según los parámetros proporcionados
            $.ajax({
                url: '/profiles-competencies-ra/save-profile', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
                    nameProfile: nameProfile,
                    profile: profile,
                    program: program,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {

                    var profileId = response.profileCreate.id;

                    resolve(profileId);
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

    function saveCompetition(competitionOne, competitionTwo, profileId) {

        var nameCompetitionOne = 'Competencias #1';
        var nameCompetitionTwo = 'Competencias #2';

        return new Promise((resolve, reject) => {
            // Realizar una solicitud AJAX para obtener los cursos según los parámetros proporcionados
            $.ajax({
                url: '/profiles-competencies-ra/save-competition', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
                    nameCompetitionOne: nameCompetitionOne,
                    nameCompetitionTwo: nameCompetitionTwo,
                    competitionOne: competitionOne,
                    competitionTwo: competitionTwo,
                    profileId: profileId,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {
                    if (Array.isArray(response.competitionCreate) && response.competitionCreate.length > 0) {
                        // Extrae los IDs de cada competencia creada
                        const competitionIds = response.competitionCreate.map(competition => competition);
                        resolve(competitionIds);
                    } else {
                        reject('Competencias no fueron creadas correctamente.');
                    }
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

    function saveRA(nameRaOne, nameRaTwo, contentRaOne, contentRaTwo, competitions) {

        console.log(contentRaOne, contentRaTwo)
        return new Promise((resolve, reject) => {
            // Realizar una solicitud AJAX para obtener los cursos según los parámetros proporcionados
            $.ajax({
                url: '/profiles-competencies-ra/save-ra', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
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
        getNameProgram(program).then(response => {
            nameProfile = response;
        })
            .catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyOne').addEventListener('click', function () {

        // Capturar el contenido del textarea
        var contentProfile = document.getElementById('textAreaProfile').value;

        if (contentProfile.trim() === "" || faculty.trim() === "" || program.trim() === "") {
            // Mostrar alerta si está vacío
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Hay campos que no pueden estar vacío. por favor completa para continuar',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Si no está vacío, mostrar el modal
            $('#modalConfirmation').modal('show');
        }

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyTwo').addEventListener('click', function () {

        //Competencias
        var contentCompetitionOne = document.getElementById('textAreaCompetitionOne').value;
        var contentCompetitionTwo = document.getElementById('textAreaCompetitionTwo').value;

        if (contentCompetitionOne.trim() === "" || contentCompetitionTwo.trim() === "") {
            // Mostrar alerta si está vacío
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Los campos de competencias no pueden estar vacíos.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Si no está vacío, mostrar el modal
            $('#modalConfirmation').modal('show');
            // Establecer el contenido en el acordeón
        }

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyThree').addEventListener('click', function () {

        //Resultados de aprendizaje
        var contentRaOne = document.getElementById('textAreaRaOne').value;
        var contentRaTwo = document.getElementById('textAreaRaTwo').value;

        if (contentRaOne.trim() === "" || contentRaTwo.trim() === "") {
            // Mostrar alerta si está vacío
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Los campo de resultados de aprendizaje no pueden estar vacíos.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Si no está vacío, mostrar el modal
            $('#modalConfirmation').modal('show');
        }

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyFour').addEventListener('click', function () {

        var contentRaThree = document.getElementById('textAreaRaThree').value;
        var contentRaFour = document.getElementById('textAreaRaFour').value;

        if (contentRaThree.trim() === "" || contentRaFour.trim() === "") {
            // Mostrar alerta si está vacío
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Los campo de resultados de aprendizaje no pueden estar vacíos.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Si no está vacío, mostrar el modal
            $('#modalConfirmation').modal('show');
        }

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirm-button').addEventListener('click', function () {
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
            saveProfile(nameProfile, contentProfile, program).then(response => {
                profileId = response; // Suponiendo que 'response' es el ID del perfil guardado
                contentProfile = ''; // Limpiar el contenido después de guardarlo

                // Reiniciar el formulario después de guardar
                resetForm();
            })
                .catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
        }

        // Guardar competencias si no están vacías
        if (contentCompetitionOne.trim() !== '' && contentCompetitionTwo.trim() !== '') {
            saveCompetition(contentCompetitionOne, contentCompetitionTwo, profileId).then(response => {
                competitionsOne = response[0].id; // Asegúrate de que response sea un array
                competitionsTwo = response[1].id; // También debe ser un array
                contentCompetitionOne = ''; // Limpiar después de guardar
                contentCompetitionTwo = '';

                // Reiniciar el formulario después de guardar
                resetForm();
            })
                .catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
        }

        // Guardar resultados de aprendizaje #1
        if (contentRaOne.trim() !== '' && contentRaTwo.trim() !== '') {
            var nameRaOne = 'Resultados de aprendizaje #1';
            var nameRaTwo = 'Resultados de aprendizaje #2';
            saveRA(nameRaOne, nameRaTwo, contentRaOne, contentRaTwo, competitionsOne).then(() => {
                contentRaOne = ''; // Limpiar después de guardar
                contentRaTwo = '';
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });

            // Reiniciar el formulario después de guardar
            resetForm();
        }

        // Guardar resultados de aprendizaje #2
        if (contentRaThree.trim() !== '' && contentRaFour.trim() !== '') {
            var nameRaThree = 'Resultados de aprendizaje #3';
            var nameRaFour = 'Resultados de aprendizaje #4';
            saveRA(nameRaThree, nameRaFour, contentRaThree, contentRaFour, competitionsTwo).then(() => {
                contentRaThree = ''; // Limpiar después de guardar
                contentRaFour = '';
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });

            // Reiniciar el formulario después de guardar
            resetForm();
        }

    });

}); 
