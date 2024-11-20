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
const userElement = document.getElementById('userId');

const userId = userElement.dataset.id;
const userProgramId = userElement.dataset.program;
const userRoleId = userElement.dataset.role;

let classroomTypeId;
let facultyId;
let programId;

document.addEventListener('DOMContentLoaded', function () {
    /*
        *
        * FUNCIONES
        *
    */
    validateRole(userProgramId, userRoleId, userId);

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

    function searchCampoComun(classroomTypeId, userId, userRoleId) {
        $.ajax({
            url: '/list-classroom-plan/search-campo-comun',
            method: 'POST',
            data: {
                classroomTypeId: classroomTypeId,
                userId: userId,
            },
            success: function (response) {
                viewClassroomPlan(response, userRoleId);
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function searchClassroomPlan(programId, educationId, userId, userRoleId) {
        $.ajax({
            url: '/list-classroom-plan/search-classroom-plan',
            method: 'POST',
            data: {
                programId: programId,
                userId: userId,
                userRoleId: userRoleId,
            },
            success: function (response) {
                if (educationId == 1) {
                    viewClassroomPlan(response, userRoleId);
                } else {
                    viewSpecialization(response, userRoleId);
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

    function searchInfoEducation(userProgramId) {
        return new Promise((resolve) => {
            $.ajax({
                url: '/list-classroom-plan/search-info-education',
                method: 'POST',
                data: {
                    userProgramId: userProgramId,
                },
                success: function (response) {
                    resolve(response)
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                }
            });
        });
    }

    function searchData(classroomId, userRoleId) {
        $.ajax({
            url: '/list-classroom-plan/search-data',
            method: 'POST',
            data: {
                classroomId: classroomId,
            },
            success: function (response) {
                viewModalUpdateState(response, classroomId, userRoleId);
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

    function viewClassroomPlan(response, userRoleId) {
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
                                <a href="#" class="text-primary stateUpdate" data-id="${classroom.id}">
                                    ${capitalizeOrDefault(classroom.state.name_state)}
                                </a>
                            </td>
                            <td>
                                <a href="/plan-aula/pdf/${classroom.id}" class="text-warning" target="_blank">
                                    Descargar
                                </a>
                            </td>
                        </tr>
                `;
                bodyContent.append(row);
            });
            document.querySelectorAll('.stateUpdate').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    const classroomId = this.getAttribute('data-id');
                    searchData(classroomId, userRoleId);
                });
            });
        } else {
            bodyContent.append('<tr><td colspan="6">No se encontraron resultados.</td></tr>');
        }
    }

    function viewSpecialization(response, userRoleId) {
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
                                <a href="#" class="text-primary stateUpdate" data-id="${classroom.id}">
                                    ${capitalizeOrDefault(classroom.state.name_state)}
                                </a>
                            </td>
                            <td>
                                <a href="/plan-aula/pdf/${classroom.id}" class="text-warning" target="_blank">
                                    Descargar
                                </a>
                            </td>
                        </tr>
                `;
                bodyContent.append(row);
            });
            document.querySelectorAll('.stateUpdate').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    const classroomId = this.getAttribute('data-id');
                    searchData(classroomId, userRoleId);
                });
            });
        } else {
            bodyContent.append('<tr><td colspan="6">No se encontraron resultados.</td></tr>');
        }
    }

    function viewModalUpdateState(response, classroomId, userRoleId) {

        if (userRoleId == 4) {
            return;
        } else {
            $('#modalUpdateState').modal('show');

            let stateId = response.classroomInfo[0].state.id;

            let stateInfo = response.stateInfo;

            const selectElement = document.getElementById('selectState');
            selectElement.innerHTML = '';

            const selectedContent = stateInfo.find(item => item.id === stateId) || null;
            if (selectedContent) {
                const selectedOption = document.createElement('option');
                selectedOption.value = selectedContent.id;
                selectedOption.text = capitalizeOrDefault(selectedContent.name_state);
                selectedOption.selected = true;
                selectElement.appendChild(selectedOption);
            }

            stateInfo.forEach(function (state) {
                if (state.id !== stateId) {
                    const option = document.createElement('option');
                    option.value = state.id;
                    option.text = capitalizeOrDefault(state.name_state);
                    selectElement.appendChild(option);
                }
            });

            document.getElementById('valueClassroomId').setAttribute('data-id', classroomId);
        }
    }

    // VALIDATIONS
    function validateUpdateState(programId, classroomTypeId) {
        const newSelect = document.getElementById('selectState');
        const dataValueSelec = newSelect.value;

        const classroomId = document.getElementById('valueClassroomId').getAttribute('data-id');

        if (dataValueSelec === '') {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'Asegúrate de llenar completo el registro',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        Swal.fire({
            title: 'Advertencia',
            icon: 'warning',
            text: '¿Estás seguro de que deseas actualizar?',
            showCancelButton: true,
            confirmButtonColor: '#1572E8',
            cancelButtonColor: '#F25961',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                saveUpdateState(dataValueSelec, classroomId, programId, classroomTypeId)
            }
        });
    }

    function validateRole(userProgramId, userRoleId, userId) {
        if (userRoleId == 1 || userRoleId == 2) {
            document.getElementById('selectTypeClassroom').addEventListener('change', function () {
                classroomTypeId = this.options[this.selectedIndex].value;
                resetContent();
                if (classroomTypeId !== '1') {
                    searchFaculty();
                } else {
                    searchCampoComun(classroomTypeId, null);
                }
            });

            document.getElementById('selectFaculty').addEventListener('change', function () {
                facultyId = this.options[this.selectedIndex].value;
                searchProgram(facultyId, classroomTypeId);
            });

            document.getElementById('selectProgram').addEventListener('change', function () {
                programId = this.options[this.selectedIndex].value;
                let educationId;
                if (classroomTypeId == 2) {
                    educationId = 1;
                } else {
                    educationId = 2;
                }
                searchClassroomPlan(programId, educationId, null, userRoleId);
            });
        } else if (userRoleId == 3) {
            document.getElementById('card-1').classList.remove('d-none');
            let educationId
            searchInfoEducation(userProgramId).then(response => {
                educationId = response.educationId[0];
                searchClassroomPlan(userProgramId, educationId, null, userRoleId);
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });;
        } else if (userRoleId == 4) {
            document.getElementById('card-1').classList.remove('d-none');
            if (userProgramId == '') {
                searchCampoComun(0, userId, userRoleId);
            } else {
                let educationId
                searchInfoEducation(userProgramId).then(response => {
                    educationId = response.educationId[0];
                    searchClassroomPlan(userProgramId, educationId, userId, userRoleId);
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });;
            }
        }
    }

    function saveUpdateState(dataValueSelec, classroomId, programId, classroomTypeId) {
        $.ajax({
            url: '/list-classroom-plan/update-state',
            method: 'PUT',
            data: {
                classroomId: classroomId,
                dataValueSelec: dataValueSelec,
            },
            success: function (response) {
                if (response.check == true) {
                    $('#modalUpdateState').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Exito',
                        text: 'Se ha registrado correctamente',
                        confirmButtonColor: '#1572E8',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (classroomTypeId == 1) {
                                searchCampoComun(classroomTypeId)
                            } else {
                                let educationId;
                                if (classroomTypeId == 2) {
                                    educationId = 1;
                                } else {
                                    educationId = 2;
                                }
                                searchClassroomPlan(programId, educationId)
                            }
                        }
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

    document.getElementById('confirm-update').addEventListener('click', function () {
        validateUpdateState(programId, classroomTypeId)
    });
});