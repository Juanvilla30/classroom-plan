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

let classroomInfo;

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * LLAMADOS
        *
    */
    searchClassroom(classroomId).then(response => {
        classroomInfo = response;
    }).catch(error => {
        console.error("Error en la solicitud AJAX:", error);
    });;

    /*
        *
        * FUNCIONES
        *
    */

    // Función para capitalizar el primer carácter de un texto
    function capitalizeOrDefault(value) {
        if (value && value.trim() !== '') {
            return value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
        }
        return 'Sin asignación';
    }

    // SEARCH
    function searchClassroom(classroomId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/view-classroom-plan/info-classroom-plans',
                method: 'POST',
                data: {
                    classroomId: classroomId,
                },
                success: function (response) {
                    console.log(response)
                    viewBtnUpdate(response);
                    resolve(response)
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                    reject(error)
                }
            });
        });
    }

    function viewBtnUpdate(response) {
        let contentState = response.classroomInfo.id_state

        if (contentState == 1) {
            let learningContent = `
                <button class="btn btn-primary btn-round" id="activateUpdate">
                    Activar actualización
                </button>
            `;
            document.getElementById("btnActivateUpdate").innerHTML = learningContent;
        }
    }

    /*
        *
        * Event Listener
        *
    */

});
