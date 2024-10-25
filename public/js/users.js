//Create
document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("addRowButton")
        .addEventListener("click", function () {
            const name = document.getElementById("addName").value;
            const last_name = document.getElementById("addLastName").value;
            const email = document.getElementById("addEmail").value;
            const password = document.getElementById("addPassword").value;
            const phone = document.getElementById("addPhone").value;
            const idRol = document.getElementById("addRole").value;
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            console.log({ name, last_name, email, password, phone, idRol }); //verificacion de valores

            if (name && last_name && phone && email && password && idRol) {
                fetch("/user", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        name: name,
                        last_name: last_name,
                        email: email,
                        password: password,
                        phone: phone,
                        id_rol: idRol,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Advertencia",
                                text: "Se ha creado un nuevo usuario",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Entendido",
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: "error Toast",
                                title: "Advertencia",
                                text:
                                    "No se ha podidio crear el usuario" +
                                    error.message,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Entendido",
                            });
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert(
                            "Error al procesar la solicitud: " + error.message
                        );
                    });
            } else {
                alert("Por favor complete todos los campos");
            }
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

        // Asegúrate de acceder a los datos de 'user'
        const user = data.user;

        // Asignación de valores de los campos
        document.getElementById("updateName").value = user.name;
        document.getElementById("updateLastName").value = user.last_name;
        document.getElementById("updateEmail").value = user.email;
        document.getElementById("updatePassword").value = user.password;
        document.getElementById("updatePhone").value = user.phone;
        document.getElementById("updateRole").value = user.id_rol;

        // Mostrar el modal
        document.getElementById("ModalUpdate").style.display = "block";
    } catch (error) {
        console.error("Error al cargar los datos del usuario:", error);
    }
}

//delete
