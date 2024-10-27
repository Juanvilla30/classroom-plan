// Configurar el token CSRF para todas las solicitudes AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
        * VARIABLES
        *
    */

    // Variables
    var faculty;
    var program;

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

    /*
        *
        * Event Listener
        *
    */

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirm-button').addEventListener('click', function () {
        // Cambiar a la siguiente card
        showNextCard();

        // Cerrar el modal
        $('#modalConfirmation').modal('hide');
    });

    document.getElementById('pillSelectFaculty').addEventListener('change', function () {
        faculty = this.options[this.selectedIndex].value;
        selectProgram(faculty);
    });

    document.getElementById('pillSelectProgram').addEventListener('change', function () {
        program = this.options[this.selectedIndex].value;
        console.log(program)
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
});
