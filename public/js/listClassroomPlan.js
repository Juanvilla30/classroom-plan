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
let classroomTypeId;
let facultyId;
let programId;

document.addEventListener('DOMContentLoaded', function () {
    /*
        *
        * FUNCIONES
        *
    */
    function capitalizeOrDefault(value) {
        if (value && value.trim() !== '') {
            return value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
        }
        return 'Sin asignación';
    }

    // BLOCK ATRTRIBUTES
    function blockCampos(showField, showComponent) {
        // Muestra u oculta la columna de "Campo"
        if (showField) {
            $('#tableClassroom th:nth-child(1), #tableClassroom td:nth-child(1)').css('display', '');
        } else {
            $('#tableClassroom th:nth-child(1), #tableClassroom td:nth-child(1)').css('display', 'none');
        }

        // Muestra u oculta la columna de "Componente"
        if (showComponent) {
            $('#tableClassroom th:nth-child(2), #tableClassroom td:nth-child(2)').css('display', '');
        } else {
            $('#tableClassroom th:nth-child(2), #tableClassroom td:nth-child(2)').css('display', 'none');
        }
    }

    // RESETS
    function resetContent() {
        const facultyField = document.getElementById('selectFacultyInfo');
        facultyField.classList.add('d-none');
        facultyField.value = '';

        const programField = document.getElementById('selectProgramInfo');
        programField.classList.add('d-none');
        programField.value = '';

        document.getElementById('card-1').classList.add('d-none');
    }

    function searchFaculty() {
        $.ajax({
            url: '/list-classroom-plan/search-faculty',
            method: 'GET',
            success: function (response) {
                viewSelectFaculty(response);
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function searchProgram(facultyId, classroomTypeId) {
        let educationId;
        if (classroomTypeId == 2) {
            educationId = 1;
        } else {
            educationId = 2;
        }

        $.ajax({
            url: '/list-classroom-plan/search-program',
            method: 'POST',
            data: {
                facultyId: facultyId,
                educationId: educationId,
            },
            success: function (response) {
                viewSelectProgram(response)
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function searchCampoComun(classroomTypeId) {
        $.ajax({
            url: '/list-classroom-plan/search-campo-comun',
            method: 'POST',
            data: {
                classroomTypeId: classroomTypeId,
            },
            success: function (response) {
                viewClassroomPlan(response);
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function searchClassroomPlan(programId, classroomTypeId) {
        let educationId;
        if (classroomTypeId == 2) {
            educationId = 1;
        } else {
            educationId = 2;
        }
        console.log(educationId)
        $.ajax({
            url: '/list-classroom-plan/search-classroom-plan',
            method: 'POST',
            data: {
                programId: programId,
            },
            success: function (response) {
                if (educationId == 1) {
                    viewClassroomPlan(response);
                } else {
                    viewSpecialization(response);
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

    // VIEWS
    function viewSelectFaculty(response) {
        const facultyField = document.getElementById('selectFacultyInfo');
        facultyField.classList.remove('d-none');

        const selectElement = document.getElementById('selectFaculty');
        selectElement.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.disabled = false;
        defaultOption.selected = true;
        defaultOption.value = '';
        defaultOption.text = 'Seleccione una facultad';
        selectElement.appendChild(defaultOption);

        if (response.facultyInfo && response.facultyInfo.length > 0) {
            response.facultyInfo.forEach(function (facultyArray) {
                const option = document.createElement('option');
                option.value = facultyArray.id;
                option.text = capitalizeOrDefault(facultyArray.name_faculty);
                selectElement.appendChild(option);
            });
            selectElement.removeAttribute('disabled');
        } else {
            selectElement.setAttribute('disabled', true);
        }
    }

    function viewSelectProgram(response) {
        const facultyField = document.getElementById('selectProgramInfo');
        facultyField.classList.remove('d-none');

        const selectElement = document.getElementById('selectProgram');
        selectElement.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.disabled = false;
        defaultOption.selected = true;
        defaultOption.value = '';
        defaultOption.text = 'Seleccione una facultad';
        selectElement.appendChild(defaultOption);

        if (response.programInfo && response.programInfo.length > 0) {
            response.programInfo.forEach(function (programArray) {
                const option = document.createElement('option');
                option.value = programArray.id;
                option.text = capitalizeOrDefault(programArray.name_program);
                selectElement.appendChild(option);
            });
            selectElement.removeAttribute('disabled');
        } else {
            selectElement.setAttribute('disabled', true);
        }
    }

    function viewClassroomPlan(response) {
        document.getElementById("card-1").classList.remove('d-none');
        blockCampos(true, true);
        let bodyContent = $('#bodyTableClassroom');
        bodyContent.empty();

        if (response.classroomInfo && response.classroomInfo.length > 0) {
            response.classroomInfo.forEach(function (classroom) {
                let row = `
                        <tr>                
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.component.study_field.name_study_field)}
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.component.name_component)}
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.course_code)}                        
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.name_course)}                        
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.semester.name_semester)}                                
                                </a>
                            </td>
                            <td align="center">
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${classroom.relations.course.credit}
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.course_type.name_course_type)}
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.state.name_state)}
                                </a>
                            </td>
                        </tr>
                `;
                bodyContent.append(row);
            });
        } else {
            bodyContent.append('<tr><td colspan="6">No se encontraron resultados.</td></tr>');
        }
    }

    function viewSpecialization(response) {
        document.getElementById("card-1").classList.remove('d-none');
        blockCampos(false, false);
        console.log(response);
        let bodyContent = $('#bodyTableClassroom');
        bodyContent.empty();

        if (response.classroomInfo && response.classroomInfo.length > 0) {
            response.classroomInfo.forEach(function (classroom) {
                let row = `
                        <tr>                       
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.course_code)}                        
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.name_course)}                        
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.semester.name_semester)}                                
                                </a>
                            </td>
                            <td align="center">
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${classroom.relations.course.credit}
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.relations.course.course_type.name_course_type)}
                                </a>
                            </td>
                            <td>
                                <a href="/view-classroom-plan/${classroom.id}" class="text-dark">
                                    ${capitalizeOrDefault(classroom.state.name_state)}
                                </a>
                            </td>
                        </tr>
                `;
                bodyContent.append(row);
            });
        } else {
            bodyContent.append('<tr><td colspan="6">No se encontraron resultados.</td></tr>');
        }
    }

    /*
        *
        * Event Listener
        *
    */
    document.getElementById('selectTypeClassroom').addEventListener('change', function () {
        classroomTypeId = this.options[this.selectedIndex].value;
        resetContent();
        if (classroomTypeId !== '1') {
            searchFaculty();
        } else {
            searchCampoComun(classroomTypeId);
        }
    });

    document.getElementById('selectFaculty').addEventListener('change', function () {
        facultyId = this.options[this.selectedIndex].value;
        searchProgram(facultyId, classroomTypeId);
    });

    document.getElementById('selectProgram').addEventListener('change', function () {
        programId = this.options[this.selectedIndex].value;
        searchClassroomPlan(programId, classroomTypeId);
    });
});