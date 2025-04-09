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

// IDS
let rolId;
let programId;
let userId;

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * FUNCIONES
        *
    */

    function validation(programId) {
        const name = document.getElementById("addName").value.trim();
        const last_name = document.getElementById("addLastName").value.trim();
        const email = document.getElementById("addEmail").value.trim();
        const password = document.getElementById("addPassword").value.trim();
        const phone = document.getElementById("addPhone").value.trim();
        const idRol = document.getElementById("addRole").value.trim();
        programId = document.getElementById("selectProgram").value.trim();

        // Validación de campos vacíos
        let missingFields = [];
        if (!name) missingFields.push("Nombre");
        if (!last_name) missingFields.push("Apellido");
        if (!email) missingFields.push("Correo Electrónico");
        if (!password) missingFields.push("Contraseña");
        if (!phone) missingFields.push("Teléfono");
        if (!idRol) missingFields.push("Rol");
        
        if (missingFields.length > 0) {
            Swal.fire({
                icon: "error",
                title: "Campos requeridos",
                text: "Faltan los siguientes campos por llenar: " + missingFields.join(", "),
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Entendido",
            });
            return; // Detener ejecución si faltan campos
        }

        if (idRol == 2) {
            programId = null;
        }

        create(name, last_name, email, password, phone, idRol, programId);
    }

    function read(userId) {
        $.ajax({
            url: '/user/show',
            method: 'GET',
            data: {
                userId: userId,
            },
            success: function (response) {
                let user = response.userInfo
                // Asignación de valores de los campos
                document.getElementById("updateName").value = user.name;
                document.getElementById("updateLastName").value = user.last_name;
                document.getElementById("updateEmail").value = user.email;
                document.getElementById("updatePassword").value = user.password;
                document.getElementById("updatePhone").value = user.phone;
                document.getElementById("updateRole").value = user.id_role;
                document.getElementById("updateProgram").value = user.id_program;

                if (user.id_program != null) {
                    updateProgram.value = user.id_program;
                } else {
                    updateProgram.value = ""; // Restablecer a la opción por defecto si existe
                }

                if (user.id_role == 3 || user.id_role == 4) {
                    document.getElementById('programShowUpdate').classList.remove('d-none');
                } else {
                    document.getElementById('programShowUpdate').classList.add('d-none');
                    programId = null;
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

    function create(name, last_name, email, password, phone, idRol, programId) {
        $.ajax({
            url: '/user/create',
            method: 'POST',
            data: {
                name: name,
                last_name: last_name,
                email: email,
                password: password,
                phone: phone.toString(),
                idRol: idRol,
                programId: programId,
            },
            success: function (response) {
                if (response.check == true) {
                    Swal.fire({
                        icon: "success",
                        title: "Actualización exitosa",
                        text: "El usuario ha sido actualizado correctamente.",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entendido",
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se ha podido crear el usuario. " + (response.errors ? Object.values(response.errors).join(", ") : ""),
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entendido",
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

    function update(userId) {
        let updateName = document.getElementById("updateName").value;
        let updateLastName = document.getElementById("updateLastName").value;
        let updatePhone = document.getElementById("updatePhone").value;
        let updateEmail = document.getElementById("updateEmail").value;
        let updatePassword = document.getElementById("updatePassword").value;
        let updateRole = document.getElementById("updateRole").value;
        let updateProgram = document.getElementById("updateProgram").value;

        if (updateName && updateLastName && updatePhone && updateEmail && updatePassword && updateRole) {
            if (updatePhone > 0) {
                if (updateRole == 1 || updateRole == 2) {
                    updateProgram = null;
                }
                $.ajax({
                    url: '/user/update',
                    method: 'PUT',
                    data: {
                        userId: userId,
                        updateName: updateName,
                        updateLastName: updateLastName,
                        updatePhone: updatePhone,
                        updateEmail: updateEmail,
                        updatePassword: updatePassword,
                        updateRole: updateRole,
                        updateProgram: updateProgram,
                    },
                    success: function (response) {
                        if (response.check === true) {
                            Swal.fire({
                                icon: "success",
                                title: "Actualización exitosa",
                                text: "El usuario ha sido actualizado correctamente.",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Entendido",
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "warning",
                                title: "Advertencia",
                                text: response.message, // Se usa el mensaje del backend
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Entendido",
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al actualizar el usuario:', xhr);
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Hubo un problema al actualizar el usuario. Inténtelo nuevamente.",
                            confirmButtonColor: "#d33",
                            confirmButtonText: "Cerrar",
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Advertencia",
                    text: "El número de teléfono ingresado no es válido. Verifique el formato e intente nuevamente.",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Entendido",
                });
            }
        } else {
            Swal.fire({
                icon: "warning",
                title: "Advertencia",
                text: "Todos los campos son obligatorios. Por favor, complete la información requerida.",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Entendido",
            });
        }
    }

    function destroy(userId) {
        $.ajax({
            url: '/user/destroy',
            method: 'DELETE',
            data: {
                userId: userId,
            },
            success: function (response) {
                if (response.check == true) {
                    Swal.fire({
                        icon: "success",
                        title: "Actualización exitosa",
                        text: "El usuario ha sido eliminado correctamente.",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entendido",
                    }).then(() => {
                        location.reload();
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

    /*
        *
        * Event Listener
        *
    */

    document.getElementById('addRowButton').addEventListener('click', function () {
        validation(programId)
    });

    document.getElementById('addRole').addEventListener('change', function () {
        rolId = this.value;
        if (rolId == 3 || rolId == 4) {
            document.getElementById('programShow').classList.remove('d-none');
        } else {
            document.getElementById('programShow').classList.add('d-none');
            programId = null;
        }
    });

    document.querySelectorAll('[id="btn_update"]').forEach(button => {
        button.addEventListener('click', function () {
            userId = this.getAttribute('data-user-id');
            programId = null;
            read(userId);
        });
    });

    document.getElementById('btnUpdate').addEventListener('click', function () {
        update(userId)
    });

    document.getElementById('updateRole').addEventListener('change', function () {
        rolId = this.value;
        if (rolId == 3 || rolId == 4) {
            document.getElementById('programShowUpdate').classList.remove('d-none');
        } else {
            document.getElementById('programShowUpdate').classList.add('d-none');
            programId = null;
        }
    });

    document.querySelectorAll('[id="btn_delete"]').forEach(button => {
        button.addEventListener('click', function () {
            userId = this.getAttribute('data-user-id');
        });
    });

    document.getElementById('btnDelete').addEventListener('click', function () {
        destroy(userId);
    });
});