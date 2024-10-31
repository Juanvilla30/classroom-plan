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

let facultyId;
let cursoId;
let component;

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

    // Función de redirección
    function activateTextArea() {
        Swal.fire({
            title: 'Advertencia',
            text: '¿Estás seguro de que deseas activar la actualización del perfil de egreso?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1572E8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Si el usuario confirma la acción
            if (result.isConfirmed) {
                // Mostrar el botón Guardar
                document.getElementById('saveUpdateProfile').classList.remove('d-none');
                document.getElementById('textAreaProfile').removeAttribute('readonly');
                document.getElementById('textAreaCompeOne').removeAttribute('readonly');
                document.getElementById('textAreaRaOne').removeAttribute('readonly');
                document.getElementById('textAreaRaTwo').removeAttribute('readonly');
                document.getElementById('textAreaCompeTwo').removeAttribute('readonly');
                document.getElementById('textAreaRaThree').removeAttribute('readonly');
                document.getElementById('textAreaRaFour').removeAttribute('readonly');
            } else {
                console.log('Eliminacion cancelada por el usuario'); // Mensaje en consola si el usuario cancela la acción
            }
        });
    }

    function saveUpdate() {
        Swal.fire({
            title: 'Advertencia',
            text: '¿Estás seguro de que deseas actualizar el perfil de egreso?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1572E8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Si el usuario confirma la acción
            if (result.isConfirmed) {

                // Captura el elemento que contiene el ID
                const profileId = document.getElementById('profileId').getAttribute('data-id');
                var textAreaProfile = document.getElementById('textAreaProfile').value;
                var textAreaCompeOne = document.getElementById('textAreaCompeOne').value;
                var textAreaCompeTwo = document.getElementById('textAreaCompeTwo').value;
                var textAreaRaOne = document.getElementById('textAreaRaOne').value;
                var textAreaRaTwo = document.getElementById('textAreaRaTwo').value;
                var textAreaRaThree = document.getElementById('textAreaRaThree').value;
                var textAreaRaFour = document.getElementById('textAreaRaFour').value;

                // Realizar la petición AJAX
                $.ajax({
                    url: '/view-profiles/update-profile',
                    type: 'PUT',
                    data: {
                        profileId: profileId,
                        textAreaProfile: textAreaProfile,
                        textAreaCompeOne: textAreaCompeOne,
                        textAreaCompeTwo: textAreaCompeTwo,
                        textAreaRaOne: textAreaRaOne,
                        textAreaRaTwo: textAreaRaTwo,
                        textAreaRaThree: textAreaRaThree,
                        textAreaRaFour: textAreaRaFour,
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Correcto',
                            text: response.message,
                            confirmButtonColor: '#1572E8',
                            confirmButtonText: 'Entendido'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    // Función que se ejecuta en caso de error en la solicitud
                    error: function (xhr, status, error) {
                        // Imprimir mensajes de error en la consola
                        console.error('Error al obtener:', xhr);
                        console.error('Estado:', status);
                        console.error('Error:', error);
                    }
                });

                //location.reload();
            } else {
                console.log('Eliminacion cancelada por el usuario'); // Mensaje en consola si el usuario cancela la acción
            }
        });
    }

    /*
        *
        * Event Listener
        *
    */

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('updateProfile').addEventListener('click', function () {
        activateTextArea()
    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('saveUpdateProfile').addEventListener('click', function () {
        saveUpdate();
    });

});