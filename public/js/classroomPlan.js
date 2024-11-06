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
let studyFieldId;
let componentId;
let courseId;
let learningId;

// INFO
let facultyInfo;
let programInfo;
let relationInfo;
let studyFieldInfo;
let pensumInfo;
let specializationInfo;

document.addEventListener('DOMContentLoaded', function () {
    /*
        *
        * ARREGLOS
        *
    */

    const cards = ['card-1', 'card-2', 'card-3', 'card-4', 'card-5', 'card-6', 'card-7', 'card-8'];

    let currentCardIndex = 0;
    document.getElementById(cards[currentCardIndex]).style.display = 'block';

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

    // RESET
    function resetContent() {
        // Limpiar los textos dentro de cada <p>
        $('#nameFaculty, #nameProgram, #nameSemester, #codeCourse, #nameCourse, #educationLevel, #nameField, #nameComponent, #nameCredits, #nameCourseType').text('');
        $('#nameFacultyS, #nameProgramS, #nameSemesterS, #codeCourseS, #nameCourseS, #educationLevelS, #nameCreditsS, #nameCourseTypeS').text('');
        $('#nameFacultyCC, #nameProgramCC, #nameSemesterCC, #codeCourseCC, #nameCourseCC, #educationLevelCC, #nameCreditsCC, #nameFieldCC, #nameComponentCC').text('');

        // Ocultar todos los divs de información
        $('#infoCampoComun, #infoSpecialization').addClass('d-none');
        $('#infoPensum').removeClass('d-none');
    }

    function reset() {
        facultyId = '';
        programId = '';
        studyFieldId = '';

        const selectFaculty = document.getElementById("selectFaculty");
        const selectProgram = document.getElementById("selectProgram");
        const selectStudyField = document.getElementById("selectStudyField");

        if (selectFaculty) {
            selectFaculty.selectedIndex = 0; // Restablece al primer elemento (mensaje de selección)
            selectFaculty.disabled = false;   // Desactiva el campo
        }

        if (selectStudyField && selectProgram) {
            selectStudyField.selectedIndex = 0; // Restablece al primer elemento (mensaje de selección)
            selectStudyField.disabled = true;   // Desactiva el campo
        }

        if (selectProgram) {
            selectProgram.selectedIndex = 0; // Restablece al primer elemento (mensaje de selección)
            selectProgram.disabled = true;   // Desactiva el campo
        }

        $('#bodyComponent').empty(); // Elimina todas las filas de datos dentro del tbody
        blockCampos(true, true);
        document.getElementById('fromButtonSearch').classList.add('d-none');

    }

    // BLOCK ATRTRIBUTES
    function blockAttributes() {
        const selects = document.querySelectorAll(".selectsFrom");

        selects.forEach(select => {
            select.disabled = true;    // Desactiva el campo
        });
    }

    function blockCampos(showField, showComponent) {
        // Muestra u oculta la columna de "Campo"
        if (showField) {
            $('#tableFieldStudy th:nth-child(1), #tableFieldStudy td:nth-child(1)').show();
        } else {
            $('#tableFieldStudy th:nth-child(1), #tableFieldStudy td:nth-child(1)').hide();
        }

        // Muestra u oculta la columna de "Componente"
        if (showComponent) {
            $('#tableFieldStudy th:nth-child(2), #tableFieldStudy td:nth-child(2)').show();
        } else {
            $('#tableFieldStudy th:nth-child(2), #tableFieldStudy td:nth-child(2)').hide();
        }
    }

    // SEARCH
    function searchProgram(facultyId) {
        const selectElement = document.getElementById('selectProgram');

        if (facultyId === '') {
            selectElement.disabled = true;
        } else {
            selectElement.disabled = false;
            $.ajax({
                url: '/classroom-plan/search-program',
                method: 'POST',
                data: {
                    faculty: facultyId,
                    educationId: educationId,
                },
                success: function (response) {
                    programInfo = response.programsInfo;
                    viewSelectProgram(programInfo, selectElement);
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

    function searchStudyFields() {
        $.ajax({
            url: '/classroom-plan/search-study-field',
            method: 'GET',
            success: function (response) {
                studyFieldInfo = response.studyFieldInfo;
                viewSelectStudyFields(studyFieldInfo);
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });

    }

    function searchCourses(programId, studyFieldId) {
        if (programId !== '') {
            $('#modalCourse').modal('show');

            $.ajax({
                url: '/classroom-plan/search-course',
                method: 'POST',
                data: {
                    programId: programId,
                    studyFieldId: studyFieldId,
                },
                success: function (response) {
                    if (response.check == '1' && response.specializationInfo) {
                        viewSelectSpecialization(response)
                    } else if (response.check == true) {
                        viewSelectPensum(response)
                    } else if (response.check == false) {
                        viewSelectCampoComun(response)
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor selecciona el programa para poder seleccionar un curso',
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
            event.preventDefault();
        }
    }

    function searchInfoCourse(courseId, programId) {
        $.ajax({
            url: '/classroom-plan/search-info-course',
            type: 'POST',
            data: {
                courseId: courseId,
                programId: programId,
            },
            success: function (response) {
                if (response.check == true) {
                    if (componentId = response.relationInfo[0].course.id_component !== null) {
                        componentId = response.relationInfo[0].course.id_component;
                        viewInfoPensum(response);
                    } else {
                        viewInfoSpecialization(response)
                    }

                } else if (response.check == false) {
                    componentId = response.courseInfo[0].id_component;
                    viewInfoCampoComun(response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
            }
        });
    }

    //TERMINAR...................
    function searchComponent(componentId, programId) {
        $.ajax({
            url: '/classroom-plan/search-list-courses',
            type: 'POST',
            data: {
                componentId: componentId,
                programId: programId,
            },
            success: function (response) {
                console.log(response);
                if (response.check == true) {
                    viewListComponent(response);
                    console.log(response)
                } else if (response.check == false) {
                    viewListSpecialization(response);
                    console.log(response)
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
            }
        });
    }

    function searchLearning(programId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/classroom-plan/search-learning', 
                method: 'POST',
                data: {
                    programId: programId,
                },
                success: function (response) {
                    console.log(response);
                    resolve(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                    reject(error);
                }
            });
        });
    }

    // VALIDATIONS
    function validateClassroomPlan(courseId, program, typeCourseId) {
        $.ajax({
            url: '/classroom-plan/validate-classroom-plans',
            method: 'POST',
            data: {
                courseId: courseId,
            },
            success: function (response) {
                if (response.confirm == false) {
                    //loadResultsSelect(program, false);
                    //validateEvaluation(typeCourseId, false);
                    validateResfresh(false);
                } else {
                    let learningId = response.classroomPlanId[0].learning_result;
                    //selectRA(learningId, true);
                    //viewClassroom(response);
                    validateResfresh(true);
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

    function validate(fields, alertMessage) {
        let hasEmptyField = fields.some(field => {
            const element = document.getElementById(field);
            return element === null || element.value.trim() === "";
        });

        if (hasEmptyField) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: alertMessage,
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
        } else {
            $('#modalConfirmation').modal('show');
        }
    }

    function validateResfresh(check) {
        if (check == false) {
            document.querySelectorAll('.confirmationSave').forEach(function (button) {
                button.classList.remove('d-none');
            });
            document.querySelectorAll('.nextCard').forEach(function (button) {
                button.classList.add('d-none');
            });
        } else {
            document.querySelectorAll('.nextCard').forEach(function (button) {
                button.classList.remove('d-none');
            });
            document.querySelectorAll('.confirmationSave').forEach(function (button) {
                button.classList.add('d-none');
            });
        }
    }

    // VIEW
    function viewSelectProgram(programInfo, selectElement) {
        // Limpiar el contenido actual del select antes de agregar opciones nuevas
        selectElement.innerHTML = '<option disabled selected value="">Seleccione un programa</option>';

        // Iterar sobre los programas recibidos y agregarlos como opciones
        programInfo.forEach(function (program) {
            const option = document.createElement('option');
            option.value = program.id;
            option.text = program.name_program.charAt(0).toUpperCase() + program.name_program.slice(1).toLowerCase(); // Capitalizar
            selectElement.appendChild(option);
        });
    }

    function viewSelectStudyFields(studyFieldInfo) {
        document.getElementById('fromSelectStudyFields').classList.remove('d-none');
        let selectsContent = `
            <div class="form-group">
                    <label for="selectStudyField">Selección campo de estudio</label>
                    <select class="form-control input-pill selectsFrom" id="selectStudyField" disabled>
                        <option disabled selected value="">Seleccione un campo de estudio</option>
        `;

        if (studyFieldInfo.length > 0) {
            studyFieldInfo.forEach((studyField, index) => {
                const i = index + 1;
                selectsContent += `
                        <option value="${studyField.id}">${capitalizeOrDefault(studyField.name_study_field)}</option>
                `;
            });

            selectsContent += `
                    </select>
                </div>                
            `;

            document.getElementById("fromSelectStudyFields").innerHTML = selectsContent;

            // EVENT LISTENER
            document.getElementById('selectStudyField').addEventListener('change', function () {
                studyFieldId = this.options[this.selectedIndex].value;
                viewButtonSearch(programId, studyFieldId);
                resetContent();
            });

        } else {

            document.getElementById("fromSelectStudyFields").innerHTML = '<h3>No se encontraron resultados.</h3>';

        }
    }

    function viewButtonSearch(programId, studyFieldId) {
        document.getElementById('fromButtonSearch').classList.remove('d-none');
        let selectsContent = `
            <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;" id="buttonSearchCourse">
                Seleccione el curso
            </button>
        `;

        document.getElementById("fromButtonSearch").innerHTML = selectsContent;

        // EVENT LISTENER
        document.getElementById('buttonSearchCourse').addEventListener('click', function () {
            searchCourses(programId, studyFieldId);
        });

    }

    function viewSelectSpecialization(response) {
        document.getElementById('specializationContainer').classList.remove('d-none');
        document.getElementById('pensumContainer').classList.add('d-none');
        document.getElementById('campoComunContainer').classList.add('d-none');

        let bodySpecialization = $('#bodySpecialization');
        bodySpecialization.empty();

        relationInfo = response.specializationInfo;

        if (relationInfo && relationInfo.length > 0) {
            relationInfo.forEach(function (relation) {
                let row = `
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm specializationSelect" 
                                    data-id="${relation.course.id}">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </td>
                            <td>${capitalizeOrDefault(relation.program?.faculty?.name_faculty)}</td>
                            <td>${capitalizeOrDefault(relation.program?.name_program)}</td>
                            <td>${capitalizeOrDefault(relation.course?.name_course)}</td>
                            <td>${capitalizeOrDefault(relation.course?.semester?.name_semester)}</td>
                            <td>${relation.course?.credit || 'sin asignación'}</td>
                            <td>${capitalizeOrDefault(relation.course?.course_type?.name_course_type)}</td>
                        </tr>
                    `;
                bodySpecialization.append(row);
            });

        } else {
            bodySpecialization.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }

    }

    function viewSelectPensum(response) {
        document.getElementById('specializationContainer').classList.add('d-none');
        document.getElementById('pensumContainer').classList.remove('d-none');
        document.getElementById('campoComunContainer').classList.add('d-none');

        let bodyPensum = $('#bodyPensum');
        bodyPensum.empty();

        pensumInfo = response.relationInfo;

        if (pensumInfo.length > 0) {
            pensumInfo.forEach(function (pensum) {
                let row = `
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm pensumSelect" 
                                    data-id="${pensum.course.id}">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </td>
                            <td>${capitalizeOrDefault(pensum.program?.faculty?.name_faculty)}</td>
                            <td>${capitalizeOrDefault(pensum.program?.name_program)}</td>
                            <td>${capitalizeOrDefault(pensum.course?.component?.study_field?.name_study_field)}</td>
                            <td>${capitalizeOrDefault(pensum.course?.component?.name_component)}</td>
                            <td>${capitalizeOrDefault(pensum.course?.name_course)}</td>
                            <td>${capitalizeOrDefault(pensum.course?.semester?.name_semester)}</td>
                            <td>${pensum.course?.credit || 'sin asignación'}</td>
                            <td>${capitalizeOrDefault(pensum.course?.course_type?.name_course_type)}</td>
                        </tr>
                    `;
                bodyPensum.append(row);
            });

        } else {
            // Mostrar un mensaje si no se encontraron cursos
            bodyPensum.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }

    }

    function viewSelectCampoComun(response) {
        document.getElementById('specializationContainer').classList.add('d-none');
        document.getElementById('pensumContainer').classList.add('d-none');
        document.getElementById('campoComunContainer').classList.remove('d-none');

        let bodyCampoComun = $('#bodyCampoComun');
        bodyCampoComun.empty();

        courseInfo = response.coursesInfo;

        if (courseInfo.length > 0) {
            courseInfo.forEach(function (course) {
                let row = `
                    <tr>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm campoComunSelect" 
                                data-id="${course.id}">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </td>
                        <td>${capitalizeOrDefault(course.component?.study_field?.name_study_field)}</td>
                        <td>${capitalizeOrDefault(course.component?.name_component)}</td>
                        <td>${capitalizeOrDefault(course.name_course)}</td>
                        <td>${capitalizeOrDefault(course.semester?.name_semester)}</td>
                        <td>${course.credit || 'sin asignación'}</td>
                        <td>${capitalizeOrDefault(course.course_type?.name_course_type)}</td>
                    </tr>
                `;
                bodyCampoComun.append(row);
            });

        } else {
            // Mostrar un mensaje si no se encontraron cursos
            bodyCampoComun.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    function viewInfoSpecialization(response) {
        // CERRAR MODAL
        $('#modalCourse').modal('hide');

        document.getElementById('infoSpecialization').classList.remove('d-none');
        document.getElementById('infoPensum').classList.add('d-none');
        document.getElementById('infoCampoComun').classList.add('d-none');

        specializationInfo = response.relationInfo;

        let relation;

        if (specializationInfo.length > 0) {
            relation = specializationInfo[0];
        } else {
            console.error('No se encontraron.');
            return;
        }

        // Actualizar los campos en el área #course-info
        $('#nameFacultyS').text(capitalizeOrDefault(relation.program?.faculty?.name_faculty));
        $('#nameProgramS').text(capitalizeOrDefault(relation.program?.name_program));
        $('#nameSemesterS').text(capitalizeOrDefault(relation.course?.semester?.name_semester));
        $('#codeCourseS').text(relation.course?.course_code || 'sin asignación');
        $('#nameCourseS').text(capitalizeOrDefault(relation.course?.name_course));
        $('#educationLevelS').text(capitalizeOrDefault(relation.program?.education_level.name_education_level));
        $('#nameCreditsS').text(relation.course?.credit || 'sin asignación');
        $('#nameCourseTypeS').text(capitalizeOrDefault(relation.course?.course_type?.name_course_type));

    }

    function viewInfoPensum(response) {
        // CERRAR MODAL
        $('#modalCourse').modal('hide');

        document.getElementById('infoSpecialization').classList.add('d-none');
        document.getElementById('infoPensum').classList.remove('d-none');
        document.getElementById('infoCampoComun').classList.add('d-none');

        pensumInfo = response.relationInfo;

        let relation;
        // Verifica si programas están definidos antes de usarlos
        if (pensumInfo.length > 0) {
            relation = pensumInfo[0];
        } else {
            console.error('No se encontraron.');
            return; // Sal de la función si no hay programas
        }

        // Actualizar los campos en el área #course-info
        $('#nameFaculty').text(capitalizeOrDefault(relation.program?.faculty?.name_faculty));
        $('#nameProgram').text(capitalizeOrDefault(relation.program?.name_program));
        $('#nameSemester').text(capitalizeOrDefault(relation.course?.semester?.name_semester));
        $('#codeCourse').text(relation.course?.course_code || 'sin asignación');
        $('#nameCourse').text(capitalizeOrDefault(relation.course?.name_course));
        $('#educationLevel').text(capitalizeOrDefault(relation.program?.education_level.name_education_level));
        $('#nameField').text(capitalizeOrDefault(relation.course?.component?.study_field?.name_study_field));
        $('#nameComponent').text(capitalizeOrDefault(relation.course?.component?.name_component));
        $('#nameCredits').text(relation.course?.credit || 'sin asignación');
        $('#nameCourseType').text(capitalizeOrDefault(relation.course?.course_type?.name_course_type));

    }

    function viewInfoCampoComun(response) {
        // CERRRA MODAL
        $('#modalCourse').modal('hide');

        document.getElementById('infoSpecialization').classList.add('d-none');
        document.getElementById('infoPensum').classList.add('d-none');
        document.getElementById('infoCampoComun').classList.remove('d-none');

        campoComunInfo = response.courseInfo;

        let relation;
        // Verifica si programas están definidos antes de usarlos
        if (campoComunInfo.length > 0) {
            relation = campoComunInfo[0];
        } else {
            console.error('No se encontraron.');
            return; // Sal de la función si no hay programas
        }

        $('#nameSemesterCC').text(capitalizeOrDefault(relation.semester?.name_semester));
        $('#codeCourseCC').text(relation.course_code || 'sin asignación');
        $('#nameCourseCC').text(capitalizeOrDefault(relation.name_course));
        $('#educationLevelCC').text('Pregrado');
        $('#nameFieldCC').text(capitalizeOrDefault(relation.component?.study_field?.name_study_field));
        $('#nameComponentCC').text(capitalizeOrDefault(relation.component?.name_component));
        $('#nameCreditsCC').text(relation.credit || 'sin asignación');
        $('#nameCourseTypeCC').text(capitalizeOrDefault(relation.course_type?.name_course_type));

    }

    function viewListComponent(response) {

        blockCampos(true, true);

        let coursesInfo = response.classroomPlanInfo;

        let bodyComponent = $('#bodyComponent');
        bodyComponent.empty();

        if (coursesInfo.length > 0) {
            coursesInfo.forEach(function (course) {
                let row = `
                        <tr class="highlight-row">                
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.component.study_field.name_study_field)}
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.component.name_component)}
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.course_code)}                        
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.name_course)}                        
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.semester.name_semester)}                                
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${course.credit}
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.course_type.name_course_type)}
                                </a>
                            </td>
                        </tr>
                `;
                bodyComponent.append(row);
            });
        } else {
            bodyComponent.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    function viewListSpecialization(response) {

        blockCampos(false, false);

        let coursesInfo = response.classroomPlanInfo;

        let bodyComponent = $('#bodyComponent');
        bodyComponent.empty();

        if (coursesInfo.length > 0) {
            coursesInfo.forEach(function (course) {
                let row = `
                        <tr class="highlight-row">                            
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.course_code)}                        
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.name_course)}                        
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.semester.name_semester)}                                
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${course.credit}
                                </a>
                            </td>
                            <td class="detalle-user" class="detalle-courses" data-course-id="${course.id}"
                                data-toggle="modal" data-target="#modalListCourses">
                                <a href="#" class="text-dark">
                                    ${capitalizeOrDefault(course.course_type.name_course_type)}
                                </a>
                            </td>
                        </tr>
                `;
                bodyComponent.append(row);
            });
        } else {
            bodyComponent.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    // COMFIRMATIONS
    function confirmationSave(dataConfirmation) {
        if (dataConfirmation == '1') {
            validate(
                ['pillSelectLearning'],
                'Por favor, selecciona un resultado de aprendizaje.'
            );
        } else if (dataConfirmation == '2') {
            validate(
                ['textAreaObjective'],
                'El campo objetivo general no puede estar vacío.'
            );
        } else if (dataConfirmation == '3') {
            validate(
                ['textAreaSpecific1', 'textAreaSpecific2', 'textAreaSpecific3'],
                'Los campos de objetivos especificos no pueden estar vacíos.'
            );
        } else if (dataConfirmation == '4') {
            validate(
                ['textAreaTheme1', 'textAreaTheme2', 'textAreaTheme3', 'textAreaTheme4', 'textAreaTheme5'],
                'Los campos de temas no pueden estar vacíos.',
            );
        } else if (dataConfirmation == '5') {
            validate(
                ['textAreaTheme6', 'textAreaTheme7', 'textAreaTheme8', 'textAreaTheme9', 'textAreaTheme10'],
                'Los campos de temas no pueden estar vacíos.'
            );
        } else if (dataConfirmation == '6') {
            validate(
                ['textAreaTheme11', 'textAreaTheme12', 'textAreaTheme13', 'textAreaTheme14', 'textAreaTheme15', 'textAreaTheme16'],
                'Los campos de temas no pueden estar vacíos.'
            );
        } else if (dataConfirmation == '7') {
            validateCheckbox();
        } else if (dataConfirmation == '8') {
            validateReferences();
        }
    }

    /*
        *
        * Event Listener
        *
    */
    document.getElementById('selectEducation').addEventListener('change', function () {

        educationId = this.options[this.selectedIndex].value;
        if (educationId == 1) {
            reset();
            searchStudyFields();
        } else {
            reset();
            document.getElementById('selectFaculty').disabled = false;
            document.getElementById('fromSelectStudyFields').classList.add('d-none');
        }
        resetContent();
    });

    document.getElementById('selectFaculty').addEventListener('change', function () {
        facultyId = this.options[this.selectedIndex].value;
        searchProgram(facultyId);
        resetContent();
    });

    document.getElementById('selectProgram').addEventListener('change', function () {
        programId = this.options[this.selectedIndex].value;
        if (educationId == 1) {
            document.getElementById('selectStudyField').disabled = false;
        } else {
            viewButtonSearch(programId, null);
        }
        resetContent();
    });

    document.getElementById('tableCampoComun').addEventListener('click', async function (event) {
        if (event.target.classList.contains('campoComunSelect')) {
            const campoComunId = event.target.dataset.id;
            await searchInfoCourse(campoComunId, null);
            await searchComponent(componentId, null);
            await searchLearning(programId);
        }
    });

    document.getElementById('tablePensum').addEventListener('click', async function (event) {
        if (event.target.classList.contains('pensumSelect')) {
            const pensumId = event.target.dataset.id;
            await searchInfoCourse(pensumId, programId);
            await searchComponent(componentId, null);
            await searchLearning(programId);
        }
    });

    document.getElementById('tableSpecialization').addEventListener('click', async function (event) {
        if (event.target.classList.contains('specializationSelect')) {
            const specializationId = event.target.dataset.id;
            await searchInfoCourse(specializationId, programId);
            await searchComponent(null, programId);
            await searchLearning(programId);
        }
    });

    document.querySelectorAll('.confirmationSave').forEach(function (button) {
        button.addEventListener('click', function () {
            dataConfirmation = this.getAttribute('data-confirmation');
            //confirmationSave(dataConfirmation, courseId, learningId);
        });
    });

    document.querySelectorAll('.nextCard').forEach(function (button) {
        button.addEventListener('click', function () {
            //blockAttributes(true, true);
            showNextCard();
        });
    });

});

