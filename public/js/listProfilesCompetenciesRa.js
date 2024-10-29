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
    function redirect(id) {
        window.location.href = '/view-profiles-competencies-ra/' + id; // Cambia esto a la URL correcta
    }

    function deleteProfile(deleteId) {
        Swal.fire({
            title: 'Advertencia',
            text: '¿Estás seguro de que deseas eliminar el perfil de egreso?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1572E8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Si el usuario confirma la acción
            if (result.isConfirmed) {
                // Realizar la petición AJAX
                $.ajax({
                    url: '/list-profiles/delete-profile',
                    type: 'DELETE',
                    data: {
                        deleteId: deleteId
                    },
                    success: function (response) {
                        console.log(response)
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al obtener:', xhr);
                        console.error('Estado:', status);
                        console.error('Error:', error);
                    }
                });
            } else {
                console.log('Eliminacion cancelada por el usuario'); // Mensaje en consola si el usuario cancela la acción
            }
        });
    }

    function listProfiles(facultyId) {
        // Realizar la petición AJAX
        $.ajax({
            url: '/list-profiles/faculty',
            type: 'POST',
            data: {
                facultyId: facultyId
            },
            success: function (response) {
                // Limpiar el contenedor antes de añadir nuevos elementos
                $('#profileEgressContainer').empty();

                // Verificar si hay perfiles de egreso
                if (response.listProfiles !== 'Perfiles no encontrados') {
                    // Generar y agregar tarjetas al contenedor
                    response.listProfiles.forEach(function (profileEgres) {
                        let cardHTML = `
                            <div class="col-sm-12 col-md-6">
                                <div class="card-body custom-card-border">
                                    <h5 class="card-title mb-3 text-primary">${capitalizeText(profileEgres.name_profile_egres)}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Descripción:</h6>
                                    <p class="card-text">${capitalizeText(profileEgres.description_profile_egres.substring(0, 250))}...</p>
                                    <a href="#" class="card-link info-profile" data-id="${profileEgres.id}">
                                        Seleccionar
                                    </a>
                                    <a href="#" class="card-link link-delete text-danger" data-id="${profileEgres.id}"
                                        data-toggle="modal" data-target="#modalDelete">
                                        Eliminar
                                    </a>
                                </div>
                            </div>
                        `;
                        $('#profileEgressContainer').append(cardHTML);

                        // Agregar el event listener después de agregar el HTML
                        $('.info-profile').on('click', function (e) {
                            e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                            const id = $(this).data('id'); // Obtener el ID desde el atributo data-id
                            redirect(id); // Llamar a la función redirect con el ID
                        });

                        // Agregar el event listener después de agregar el HTML
                        $('.link-delete').on('click', function (e) {
                            e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                            const deleteId = $(this).data('id'); // Obtener el ID desde el atributo data-id
                            console.log(deleteId);
                            deleteProfile(deleteId);
                        });
                    });
                } else {
                    // Mostrar mensaje si no hay perfiles de egreso
                    $('#profileEgressContainer').append('<p class="text-center w-100">No hay perfiles de egresos disponibles.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
            }
        });
    }

    /*
        *
        * Event Listener
        *
    */

    // Asignar evento click a cada enlace con la clase 'nav-link sede-tab' para actualizar el enlace seleccionado y mostrar el ID de la facultad
    document.querySelectorAll('.nav-link.sede-tab').forEach(link => {
        // Agregar un listener de evento 'click' a cada enlace
        link.addEventListener('click', function () {
            // Desactivar la selección de todos los enlaces eliminando 'aria-selected' en cada uno
            document.querySelectorAll('.nav-link.sede-tab').forEach(l => l.setAttribute('aria-selected', 'false'));

            // Marcar el enlace actual como seleccionado asignando 'aria-selected' a 'true'
            this.setAttribute('aria-selected', 'true');

            // Obtener el valor de 'data-value' del enlace seleccionado o mostrar un mensaje en caso de que no haya enlace seleccionado
            facultyId = this.getAttribute('data-value') || 'No hay enlace seleccionado';

            listProfiles(facultyId);
        });
    });

});