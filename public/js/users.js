//Create
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("addRowButton").addEventListener("click", function () {
        const name = document.getElementById("addName").value.trim();
        const last_name = document.getElementById("addLastName").value.trim();
        const email = document.getElementById("addEmail").value.trim();
        const password = document.getElementById("addPassword").value.trim();
        const phone = document.getElementById("addPhone").value.trim();
        const idRol = document.getElementById("addRole").value.trim();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

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
                text: "Faltan los siguientes campos: " + missingFields.join(", "),
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Entendido",
            });
            return; // Detener ejecución si faltan campos
        }

        fetch("/user/create", {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ name, last_name, email, password, phone, id_role: idRol }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "Se ha creado un nuevo usuario",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entendido",
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se ha podido crear el usuario. " + (data.errors ? Object.values(data.errors).join(", ") : ""),
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entendido",
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error de red",
                    text: "Error al procesar la solicitud: " + error.message,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Entendido",
                });
            });
    });
});


//Capture
$(document).ready(function () {
    // Usar delegación de eventos para capturar los clicks en .detalle-user
    $(document).on("click", ".detalle-user", function () {
        // Capturar el valor del atributo data-user-id
        var userId = $(this).data("user-id");
        console.log("ID del usuario: ", userId);
    });
});

// show data to modal
async function reloadModal(id) {
    try {
        const response = await fetch(`/user/${id}`);

        // Verifica si la respuesta es correcta
        if (!response.ok) {
            throw new Error(`Error en la solicitud: ${response.status}`);
        }

        const data = await response.json();
        console.log("Datos recibidos:", data); // Agregar para depuración

        const user = data.user;

        // Asignación de valores de los campos
        document.getElementById("updateName").value = user.name;
        document.getElementById("updateLastName").value = user.last_name;
        document.getElementById("updateEmail").value = user.email;
        document.getElementById("updatePassword").value = user.password;
        document.getElementById("updatePhone").value = user.phone;
        document.getElementById("updateRole").value = user.id_role;
        console.log("rol", user.id_role);

        // Mostrar el modal
        document.getElementById("ModalUpdate").style.display = "block";
    } catch (error) {
        console.error("Error al cargar los datos del usuario:", error);
    }
}

//delete
let userIdToDelete = null;

// Función para asignar el ID del usuario al hacer clic en el botón de eliminación
function setUserId(id) {
    userIdToDelete = id; // Guardamos el ID del usuario en una variable
}

// Al hacer clic en el botón de confirmación del modal
document.getElementById("btnDelete").addEventListener("click", function () {
    if (userIdToDelete) {
        deleteUser(userIdToDelete); // Llamamos a la función deleteUser con el ID almacenado
        $("#exampleModalCenter").modal("hide"); // Cerramos el modal después de eliminar
    }
});

// Función para eliminar el usuario mediante una solicitud HTTP DELETE
async function deleteUser(id) {
    try {
        const response = await fetch(`/user/${id}`, {
            method: "DELETE", // Método DELETE para eliminar
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });

        // Maneja la respuesta en función del código de estado
        if (response.ok) {
            console.log("Usuario eliminado con éxito");

            Swal.fire({
                icon: "success",
                title: "Eliminación exitosa",
                text: "El usuario ha sido eliminado correctamente.",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Entendido",
            }).then(() => {
                location.reload(); // Recarga la página después de la confirmación
            });
        } else {
            const data = await response.json();
            throw new Error(`Error: ${data.message || "Error desconocido"}`);
        }
    } catch (error) {
        console.error("Error al eliminar el usuario:", error);
        Swal.fire({
            icon: "error",
            title: "Advertencia",
            text: "No se ha podido eliminar el usuario",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Entendido",
        }).then(() => {
            location.reload();
        });
    }
}
//end delete

//update
document;
document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("btn-update")
        ?.addEventListener("click", async function () {
            const id = this.getAttribute("data-user-id");

            if (!id) {
                console.log("El ID no puede ser nulo", id);
                return;
            }

            try {
                const response = await fetch(`/user/${id}`, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        name: document.getElementById("updateName").value,
                        last_name:
                            document.getElementById("updateLastName").value,
                        phone: document.getElementById("updatePhone").value,
                        email: document.getElementById("updateEmail").value,
                        password:
                            document.getElementById("updatePassword").value,
                        id_role: document.getElementById("updateRole").value,
                    }),
                });

                if (!response.ok) {
                    const errorData = await response.json(); // Obtener JSON de errores
                    let errorMessage = "No se ha podido actualizar el usuario.";

                    if (errorData.errors) {
                        // Obtener los mensajes de error detallados
                        errorMessage += "\n" + Object.values(errorData.errors).join("\n");
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Error en la actualización",
                        text: errorMessage,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Entendido",
                    });

                    throw new Error(errorMessage);
                }

                const data = await response.json();
                console.log("Datos actualizados", data);

                Swal.fire({
                    icon: "success",
                    title: "Actualización exitosa",
                    text: "El usuario ha sido actualizado correctamente.",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Entendido",
                }).then(() => {
                    location.reload();
                });

            } catch (error) {
                console.error("Error:", error);
            }
        });
});