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
                $('#profileEgressContainer').empty();

                if (response.listProfiles !== 'Perfiles no encontrados') {
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

                        $('.info-profile').on('click', function (e) {
                            e.preventDefault(); 
                            const id = $(this).data('id');
                            redirect(id);
                        });

                        $('.link-delete').on('click', function (e) {
                            e.preventDefault(); 
                            const deleteId = $(this).data('id'); 
                            deleteProfile(deleteId);
                        });
                    });
                } else {
                    // Mostrar mensaje si no hay perfiles de egreso
                    $('#profileEgressContainer').append(
                        '<div class="col-12 text-center">' +
                            '<h4>No hay perfiles de egresos disponibles.</h4>' +
                        '</div>'
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
            }
        });
    }

    function validateProfileInfo(profilInfoId){
        if (profilInfoId == 'true') {
            document.getElementById('pills-tab').classList.remove('d-none');
            $('#profileEgressContainer').empty(); // Limpia todos los elementos dentro de facultyList
            $('#profileEgressContainer').append(
                '<div class="col-12 text-center">' +
                    '<h4>Por favor, selecciona una opción para visualizar los perfiles de egreso disponibles.</h4>' +
                '</div>'
            );            
        } else {
            document.getElementById('pills-tab').classList.add('d-none');
            listProfiles(null);
        }
    }

    /*
        *
        * Event Listener
        *
    */
    document.getElementById('selectProfileInformation').addEventListener('change', function () {
        profilInfoId = this.options[this.selectedIndex].value;
        validateProfileInfo(profilInfoId);
    });

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