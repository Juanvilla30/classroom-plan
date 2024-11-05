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
let programId;
let originalClassroomList = []; // Para almacenar la lista original de cursos
let itemsPerPage = 6; // Número de elementos por página
let currentPage = 1; // Página actual

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
        window.location.href = '/view-classroom-plan/' + id; // Cambia esto a la URL correcta
    }

    function deleteClassroom(deleteId) {
        Swal.fire({
            title: 'Advertencia',
            text: '¿Estás seguro de que deseas eliminar el plan de aula?',
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
                    url: '/list-classroom-plan/delete-classroom-plan',
                    type: 'DELETE',
                    data: {
                        deleteId: deleteId
                    },
                    success: function (response) {
                        console.log(response)
                        if (response.check == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Exito',
                                text: response.message,
                                confirmButtonColor: '#1269DB',
                                confirmButtonText: 'Entendido'
                            }).then((result) => {
                                // Si el usuario confirma la acción
                                if (result.isConfirmed) {
                                    // Recargar la página cuando llegues a la última card
                                    location.reload();
                                } else {
                                    location.reload();
                                    console.log('Eliminacion cancelada por el usuario'); // Mensaje en consola si el usuario cancela la acción
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Error',
                                text: response.error,
                                confirmButtonColor: '#1269DB',
                                confirmButtonText: 'Entendido'
                            })
                        }
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

    function viewClassroom(programId) {
        document.getElementById('card-1').classList.remove('d-none');

        $.ajax({
            url: '/list-classroom-plan/select-classroom',
            type: 'POST',
            data: {
                programId: programId
            },
            success: function (response) {
                $('#viewClassroomPlan').empty();

                if (response.check) {
                    originalClassroomList = response.listClassroom; // Guardar la lista original
                    paginateClassrooms(originalClassroomList, programId); // Paginar la lista original

                    // Configurar el evento de búsqueda
                    $('#searchCourse').off('input').on('input', function () {
                        searchCourses(programId);
                    });
                } else {
                    $('#viewClassroomPlan').append('<p class="text-center w-100">No hay Planes de aula disponibles.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener programas:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
            }
        });
    }

    function paginateClassrooms(classroomList, programId) {
        const totalItems = classroomList.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        // Filtrar los elementos para la página actual
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const classroomToShow = classroomList.slice(startIndex, endIndex);

        // Llamar a la función displayClassrooms para mostrar los elementos filtrados
        displayClassrooms(classroomToShow);

        // Generar paginador
        generatePagination(totalPages);
    }

    function displayClassrooms(classroomToShow) {
        $('#viewClassroomPlan').empty(); // Limpiar el contenedor antes de añadir nuevos elementos

        if (classroomToShow.length > 0) {
            classroomToShow.forEach(function (classroom) {
                let cardHTML = `
                    <div class="col-sm-12 col-md-6">
                        <div class="card-body custom-card-border">
                            <h5 class="card-title mb-3 text-primary">Plan de aula de ${capitalizeText(classroom.courses.name_course)}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">${capitalizeText(classroom.learning_result.name_learning_result)}:</h6>
                            <p class="card-text">${capitalizeText(classroom.learning_result.description_learning_result.substring(0, 250))}...</p>
                            <h6 class="card-subtitle mb-2 text-muted">Objetivo general descripción:</h6>
                            <p class="card-text">${capitalizeText(classroom.general_objective.description_general_objective.substring(0, 250))}...</p>
                            <a href="#" class="card-link info-profile-plan" data-id="${classroom.id}">Seleccionar</a>
                            <a href="#" class="card-link link-delete text-danger" data-id="${classroom.id}">Eliminar</a>
                        </div>
                    </div>
                `;
                $('#viewClassroomPlan').append(cardHTML);
            });

            // Agregar los event listeners a los enlaces de las tarjetas
            $('.info-profile-plan').on('click', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                redirect(id);
            });

            $('.link-delete').on('click', function (e) {
                e.preventDefault();
                const deleteId = $(this).data('id');
                deleteClassroom(deleteId);
            });

        } else {
            $('#viewClassroomPlan').append('<p class="text-center w-100">No se encontraron resultados.</p>');
        }
    }

    function generatePagination(totalPages) {
        $('#pagination').empty(); // Limpiar el contenedor de paginación

        // Botón "Previous"
        const prevButton = $('<li>')
            .addClass('page-item ' + (currentPage === 1 ? 'disabled' : ''))
            .append($('<a>')
                .addClass('page-link')
                .attr('href', '#')
                .text('Previous')
                .on('click', function (e) {
                    e.preventDefault();
                    if (currentPage > 1) {
                        currentPage--;
                        paginateClassrooms(originalClassroomList, programId);
                    }
                })
            );
        $('#pagination').append(prevButton);

        // Botones de páginas
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = $('<li>')
                .addClass('page-item ' + (i === currentPage ? 'active' : ''))
                .append($('<a>')
                    .addClass('page-link')
                    .attr('href', '#')
                    .text(i)
                    .on('click', function (e) {
                        e.preventDefault();
                        currentPage = i;
                        paginateClassrooms(originalClassroomList, programId);
                    })
                );
            $('#pagination').append(pageButton);
        }

        // Botón "Next"
        const nextButton = $('<li>')
            .addClass('page-item ' + (currentPage === totalPages ? 'disabled' : ''))
            .append($('<a>')
                .addClass('page-link')
                .attr('href', '#')
                .text('Next')
                .on('click', function (e) {
                    e.preventDefault();
                    if (currentPage < totalPages) {
                        currentPage++;
                        paginateClassrooms(originalClassroomList, programId);
                    }
                })
            );
        $('#pagination').append(nextButton);
    }

    function searchCourses(programId) {
        const searchTerm = $('#searchCourse').val().toLowerCase(); // Obtén el término de búsqueda
        const filteredCourses = originalClassroomList.filter(course =>
            course.courses.name_course.toLowerCase().includes(searchTerm) // Filtra por nombre del curso
        );

        // Actualiza la visualización con los cursos filtrados
        paginateClassrooms(filteredCourses, programId); // Usar la lista filtrada para la paginación
    }

    function selectProgram(facultyId) {
        $.ajax({
            url: '/list-classroom-plan/select-program',
            type: 'POST',
            data: {
                facultyId: facultyId
            },
            success: function (response) {
                // Limpiar el contenedor antes de añadir nuevos elementos
                $('#cardProgram').empty();

                // Verificar si la respuesta contiene programas
                if (response.check) {
                    // Generar y agregar tarjetas al contenedor
                    response.listPrograms.forEach(function (program) {
                        let cardHTML = `
                            <div class="col-sm-6 col-lg-3">
                                <div class="card p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="stamp stamp-md bg-primary mr-3">
                                            <i class="far fa-building"></i>
                                        </span>
                                        <div>    
                                            <h5 class="mb-1">
                                                <a href="#" class="card-link info-classroom" data-id="${program.id}>
                                                    <small class="text-muted">
                                                        Programa ${program.name_program}
                                                    </small>
                                                </a>
                                            </h5>
                                        </div>  
                                    </div>
                                </div>
                            </div>  
                        `;
                        $('#cardProgram').append(cardHTML);

                        // Asegúrate de que el evento se asigne a los elementos existentes y futuros con un delegado
                        $(document).on('click', '.info-classroom', function (e) {
                            e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                            const id = $(this).data('id'); // Obtener el ID desde el atributo data-id
                            viewClassroom(id);
                        });

                    });
                } else {
                    // Mostrar mensaje si no hay programas
                    $('#cardProgram').append('<p class="text-center w-100">No hay programas disponibles.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener programas:', xhr);
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
            selectProgram(facultyId);
        });
    });


});