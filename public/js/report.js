// Configurar el token CSRF para todas las solicitudes AJAX
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

/*
 *
 * VARIABLES
 *
 */
let facultyId;
let programId;

document.addEventListener("DOMContentLoaded", function () {
    /*
     *
     * LLAMADOS
     *
     */

    /*
     *
     * FUNCIONES
     *
     */

    function capitalizeOrDefault(value) {
        if (value && value.trim() !== "") {
            return value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
        }
        return "Sin asignación";
    }

    function searchProgram(facultyId) {
        $.ajax({
            url: "/plan-aula/search-program",
            type: "POST",
            data: {
                facultyId: facultyId,
            },
            success: function (response) {
                viewProgram(response);
            },
            error: function (xhr, status, error) {
                console.error("Error al obtener:", xhr);
                console.error("Estado:", status);
                console.error("Error:", error);
            },
        });
    }

    function searchProgram(facultyId) {
        $.ajax({
            url: "/plan-aula/search-program",
            type: "POST",
            data: {
                facultyId: facultyId,
            },
            success: function (response) {
                viewProgram(response);
            },
            error: function (xhr, status, error) {
                console.error("Error al obtener:", xhr);
                console.error("Estado:", status);
                console.error("Error:", error);
            },
        });
    }

    function searchExport(programId) {
        window.location.href = "/plan-aula/donwload?programId=" + programId;
    }

    function viewProgram(response) {
        const selectElement = document.getElementById("selectprogram");
        selectElement.disabled = false;
        selectElement.innerHTML =
            '<option disabled selected value="">Seleccione un programa</option>';

        response.programsInfo.forEach(function (program) {
            const option = document.createElement("option");
            option.value = program.id;
            option.text = capitalizeOrDefault(program.name_program);
            selectElement.appendChild(option);
        });
    }

    /*
     *
     * Event Listener
     *
     */
    document.getElementById("selectfacultie").addEventListener("change", function () {
        facultyId = this.value;
        searchProgram(facultyId);
    });

    document.getElementById("selectprogram").addEventListener("change", function () {
        programId = this.value;
        document.getElementById("btn-excel").classList.remove("d-none");
    });

    document.getElementById("btn-excel").addEventListener("click", function () {
        searchExport(programId);
    });
});
