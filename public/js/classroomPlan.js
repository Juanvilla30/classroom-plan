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
let educationId;
let facultyId;
let programId;

// INFO
let facultyInfo;

document.addEventListener('DOMContentLoaded', function () {
    /*
        *
        * ARREGLOS
        *
    */

    // Arreglo con los IDs de las cards
    const cards = ['card-1', 'card-2', 'card-3', 'card-4', 'card-5', 'card-6', 'card-7', 'card-8'];

    // Inicialmente mostrar la primera card
    let currentCardIndex = 0;
    document.getElementById(cards[currentCardIndex]).style.display = 'block';

    /*
        *
        * FUNCIONES
        *
    */

    // Función para capitalizar el primer carácter de un texto
    function capitalizeText(text) {
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

    // Función para mostrar la siguiente card
    function showNextCard() {
        // Ocultar la card actual
        document.getElementById(cards[currentCardIndex]).style.display = 'none';

        // Incrementar el índice para pasar a la siguiente card
        currentCardIndex++;

        if (currentCardIndex < cards.length) {
            // Mostrar la siguiente card
            document.getElementById(cards[currentCardIndex]).style.display = 'block';
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Exito',
                text: 'Se ha creado correctamente el plan de aula',
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
        }
    }

    // SEARCH
    function searchFaculty() {
        $.ajax({
            url: '/classroom-plan/search',
            method: 'GET',
            success: function (response) {
                facultyInfo = response.facultyInfo
                viewSelectCourse(facultyInfo);
                console.log(response.facultyInfo);
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    // VIEW
    function viewSelectCourse(facultyInfo) {
        document.getElementById('fromSelectCourse').classList.remove('d-none');
        let selectsContent = `
            <div class="form-group">
                    <label for="selectFaculty">Selección facultad</label>
                    <select class="form-control input-pill" id="selectFaculty">
                        <option disabled selected value="">Seleccione una facultad</option>
        `;

        if (facultyInfo.length > 0) {
            facultyInfo.forEach((faculty, index) => {
                const i = index + 1;
                selectsContent += `
                        <option value="${faculty.id}">${capitalizeText(faculty.name_faculty)}</option>
                `;
            });

            selectsContent += `
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectProgram">Selección programa</label>
                    <select class="form-control input-pill" id="selectProgram" disabled>
                        <option disabled selected value="">Seleccione un programa</option>

                    </select>
                </div>

                <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;" id="filterCourse">
                    Seleccione el curso
                </button>
            `;
            document.getElementById("fromSelectCourse").innerHTML = selectsContent;
            select();

        } else {

            document.getElementById("fromSelectCourse").innerHTML = '<h3>No se encontraron resultados.</h3>';

        }
    }

    function selectProgram(facultyId) {

        const selectElement = document.getElementById('selectProgram');

        if (facultyId === '') {
            selectElement.disabled = true;
        } else {
            selectElement.disabled = false;

            $.ajax({
                url: '/classroom-plan/faculty-program',
                method: 'POST',
                data: {
                    faculty: facultyId,
                },
                success: function (response) {
                    selectElement.innerHTML = '<option disabled selected value="">Seleccione un programa</option>';

                    response.listPrograms.forEach(function (program) {
                        const option = document.createElement('option');
                        option.value = program.id;
                        option.text = program.name_program.charAt(0).toUpperCase() + program.name_program.slice(1).toLowerCase(); // Capitalizar
                        selectElement.appendChild(option);
                    });

                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);

                }
            });
        }

    }

    function select() {
        document.getElementById('selectFaculty').addEventListener('change', function () {
            facultyId = this.options[this.selectedIndex].value;
            selectProgram(facultyId);
        });

        document.getElementById('selectProgram').addEventListener('change', function () {
            programId = this.options[this.selectedIndex].value;
        });
    }

    /*
        *
        * AJAX
        *
    */



    /*
        *
        * Event Listener
        *
    */
    document.getElementById('selectEducation').addEventListener('change', function () {
        educationId = this.options[this.selectedIndex].value;
        if (educationId == 1) {
            searchFaculty();

        } else {
            console.log(educationId);
            document.getElementById('fromSelectCourse').classList.add('d-none');
        }
    });
});

