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
let cont = true;

const programId = document.getElementById('programId').getAttribute('data-info');

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * FUNCIONES
        *
    */
    function capitalizeText(text) {
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

    searchProgram(programId);

    function searchProgram(programId) {
        let infoContent

        if (programId == '') {
            infoContent = `
                <div class="col-12 text-center">
                    <h3 class="card-title font-weight-bold text-primary">Perfil de campo comun</h3>
                </div>             
            `;
            document.getElementById("viewInfo").innerHTML = infoContent;
        } else {
            $.ajax({
                url: '/view-profiles-competencies-ra/search-program-faculty',
                type: 'POST',
                data: {
                    programId: programId
                },
                success: function (response) {
                    let info = response.programInfo[0]
                    console.log(info)

                    infoContent = `                
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Facultad:</label>
                                <p>${capitalizeText(info.faculty.name_faculty)}</p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Programa:</label>
                                <p>${capitalizeText(info.name_program)}</p>
                            </div>
                        </div>
                    `;
                    document.getElementById("viewInfo").innerHTML = infoContent;
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                }
            });
        }
    }

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

    function activateUpdate() {
        // Cerrar el modal
        $('#modalActivateUpdate').modal('hide');

        document.getElementById('activateUpdate').textContent = 'Desactivar actualización';
        document.getElementById('saveUpdateProfile').classList.remove('d-none');
        document.getElementById('textAreaProfile').removeAttribute('readonly');
        document.getElementById('textAreaCompeOne').removeAttribute('readonly');
        document.getElementById('textAreaRaOne').removeAttribute('readonly');
        document.getElementById('textAreaRaTwo').removeAttribute('readonly');
        document.getElementById('textAreaCompeTwo').removeAttribute('readonly');
        document.getElementById('textAreaRaThree').removeAttribute('readonly');
        document.getElementById('textAreaRaFour').removeAttribute('readonly');

    }

    function deactivateUpdate() {
        // Cerrar el modal
        $('#modalDeactivateUpdate').modal('hide');

        document.getElementById('activateUpdate').textContent = 'Activar actualización';
        document.getElementById('saveUpdateProfile').classList.add('d-none');
        document.getElementById('textAreaProfile').setAttribute('readonly', true);
        document.getElementById('textAreaCompeOne').setAttribute('readonly', true);
        document.getElementById('textAreaRaOne').setAttribute('readonly', true);
        document.getElementById('textAreaRaTwo').setAttribute('readonly', true);
        document.getElementById('textAreaCompeTwo').setAttribute('readonly', true);
        document.getElementById('textAreaRaThree').setAttribute('readonly', true);
        document.getElementById('textAreaRaFour').setAttribute('readonly', true);
        location.reload();
    }

    /*
        *
        * Event Listener
        *
    */
    document.getElementById('activateUpdate').addEventListener('click', function () {
        if (cont == true) {
            $('#modalActivateUpdate').modal('show');
        } else {
            $('#modalDeactivateUpdate').modal('show');
        }
    });

    document.getElementById('confirm-activate').addEventListener('click', function () {
        activateUpdate(programId);
        cont = false;
    });

    document.getElementById('confirm-desactivate').addEventListener('click', function () {
        deactivateUpdate()
        cont = true;
    });

    document.getElementById('saveUpdateProfile').addEventListener('click', function () {
        saveUpdate();
    });

});