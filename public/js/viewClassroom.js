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
const classroomId = document.getElementById('classroomId').getAttribute('data-id');

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * ARREGLOS
        *
    */

    /*
        *
        * FUNCIONES
        *
    */

    // Función para capitalizar el primer carácter de un texto
    function capitalizeText(text) {
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

    /*
        *
        * Event Listener
        *
    */

    console.log(classroomId)

});
