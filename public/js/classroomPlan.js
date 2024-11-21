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
const userData = JSON.parse(document.getElementById('userId').getAttribute('data-id'));
let confirmDataId;

// IDS
let typeClassroomId;
let facultyId;
let programId;
let realtionId;
let componentId;
let learningId;

// INFO
const savesEvaluation1 = [];
const savesEvaluation2 = [];
const savesEvaluation3 = [];
const institutionalLinks = [];
const generalLinks = [];
let sumPercentage1 = 0;
let sumPercentage2 = 0;
let sumPercentage3 = 0;

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
    function resetTypeClassroom() {
        facultyId = '';
        programId = '';

        const fromSelectFaculty = document.getElementById("fromSelectFaculty");
        const fromSelectProgram = document.getElementById("fromSelectProgram");
        const selectFaculty = document.getElementById("selectFaculty");
        const selectProgram = document.getElementById("selectProgram");

        if (fromSelectFaculty) {
            fromSelectFaculty.selectedIndex = 0;
            fromSelectFaculty.disabled = false;
            fromSelectFaculty.classList.add('d-none');
        }

        if (fromSelectProgram) {
            fromSelectProgram.selectedIndex = 0;
            fromSelectProgram.classList.add('d-none');
        }

        if (selectFaculty) {
            selectFaculty.selectedIndex = 0; // Restablece al primer elemento (mensaje de selección)
            selectFaculty.disabled = false;   // Desactiva el campo
        }

        if (selectProgram) {
            selectProgram.selectedIndex = 0; // Restablece al primer elemento (mensaje de selección)
            selectProgram.disabled = true;   // Desactiva el campo
        }

        $('#bodyComponent').empty(); // Elimina todas las filas de datos dentro del tbody
        blockCampos(true, true);
        document.getElementById('buttonSearchCourse').classList.add('d-none');

    }

    function resetContent() {
        $('#nameFaculty, #nameProgram, #nameSemester, #codeCourse, #nameCourse, #educationLevel, #nameField, #nameComponent, #nameCredits, #nameCourseType').text('');
        $('#nameFacultyS, #nameProgramS, #nameSemesterS, #codeCourseS, #nameCourseS, #educationLevelS, #nameCreditsS, #nameCourseTypeS').text('');
        $('#nameFacultyCC, #nameProgramCC, #nameSemesterCC, #codeCourseCC, #nameCourseCC, #educationLevelCC, #nameCreditsCC, #nameFieldCC, #nameComponentCC').text('');

        $('#infoCampoComun, #infoSpecialization').addClass('d-none');
        $('#infoPensum').removeClass('d-none');

        const selectElement = document.getElementById('selectLearning');
        selectElement.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.selected = true;
        defaultOption.value = '';
        defaultOption.text = 'Seleccione un resultado de aprendizaje';
        selectElement.appendChild(defaultOption);
        selectElement.setAttribute('disabled', true);

        document.getElementById('textAreaDescriptionRA').value = '';
        $('#bodyComponent').empty();

        savesEvaluation1.length = 0;
        savesEvaluation2.length = 0;
        savesEvaluation3.length = 0;
    }

    function resetFaculty() {
        const selectProgram = document.getElementById("selectProgram");
        if (selectProgram) {
            selectProgram.selectedIndex = 0; // Restablece al primer elemento (mensaje de selección)
            selectProgram.disabled = true;   // Desactiva el campo
        }
        document.getElementById('buttonSearchCourse').classList.add('d-none');
    }

    function resetForm() {
        document.getElementById('textAreaDescriptionRA').value = '';
        document.querySelectorAll('.readonlyCheck').forEach(function (element) {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.value = '';
            }
        });
        document.querySelectorAll('.percentage').forEach(function (element) {
            element.textContent = '';
        });
        savesEvaluation1.length = 0;
        savesEvaluation2.length = 0;
        savesEvaluation3.length = 0;
    }

    // BLOCK ATRTRIBUTES
    function blockAttributes(confirmDataId) {
        const selects = document.querySelectorAll(".selectsFrom");
        let buttonSearchCourse = document.getElementById('buttonSearchCourse');
        let searchCourseBtn = document.getElementById('searchCourseBtn');

        document.querySelectorAll('.readonlyCheck').forEach(function (element) {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.readOnly = true;
            }
        });

        selects.forEach(select => {
            select.disabled = true;
        });

        if (confirmDataId == 1) {
            buttonSearchCourse.disabled = true;
        } else {
            searchCourseBtn.disabled = true;
        }
    }

    function blockCampos(showField, showComponent) {
        // Muestra u oculta la columna de "Campo"
        if (showField) {
            $('#tableFieldStudy th:nth-child(1), #tableFieldStudy td:nth-child(1)').css('display', '');
        } else {
            $('#tableFieldStudy th:nth-child(1), #tableFieldStudy td:nth-child(1)').css('display', 'none');
        }

        // Muestra u oculta la columna de "Componente"
        if (showComponent) {
            $('#tableFieldStudy th:nth-child(2), #tableFieldStudy td:nth-child(2)').css('display', '');
        } else {
            $('#tableFieldStudy th:nth-child(2), #tableFieldStudy td:nth-child(2)').css('display', 'none');
        }
    }

    function unlockAttributes(confirmDataId) {
        const selects = document.querySelectorAll(".selectsFrom");
        let buttonSearchCourse = document.getElementById('buttonSearchCourse');
        let searchCourseBtn = document.getElementById('searchCourseBtn');

        document.querySelectorAll('.readonlyCheck').forEach(function (element) {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.readOnly = false;
            }
        });

        selects.forEach(select => {
            select.disabled = true;
        });

        if (confirmDataId == 1) {
            buttonSearchCourse.disabled = true;
        } else {
            searchCourseBtn.disabled = true;
        }
    }

    // VALIDATIONS
    validateUser(userData).then(response => {
        confirmDataId = response;
    }).catch(error => {
        console.error("Error en la solicitud AJAX:", error);
    });

    function validateUser(response) {
        return new Promise((resolve) => {

            if (response.id_role == 1 || response.id_role == 2) {
                document.getElementById('selectTypeClassroom').addEventListener('change', function () {
                    typeClassroomId = this.options[this.selectedIndex].value;
                    resetTypeClassroom();
                    resetContent()
                    if (typeClassroomId == 1) {
                        document.getElementById('buttonSearchCourse').classList.remove('d-none');
                    } else {
                        document.getElementById('fromSelectFaculty').classList.remove('d-none');
                        document.getElementById('fromSelectProgram').classList.remove('d-none');
                        document.getElementById("selectFaculty").disabled = false;
                    }
                });

                document.getElementById('selectFaculty').addEventListener('change', function () {
                    facultyId = this.options[this.selectedIndex].value;
                    resetFaculty();
                    resetContent()
                    searchProgram(facultyId, typeClassroomId);
                });

                document.getElementById('selectProgram').addEventListener('change', function () {
                    programId = this.options[this.selectedIndex].value;
                    resetContent()
                    document.getElementById('buttonSearchCourse').classList.remove('d-none');
                });

                document.getElementById('buttonSearchCourse').addEventListener('click', function () {
                    if (typeClassroomId == 1) {
                        searchCourses(null, null);
                    } else {
                        searchCourses(programId, typeClassroomId)
                    }
                });
                resolve(1)
            } else if (response.id_role == 3 || response.id_role == 4) {
                document.getElementById('searchCourseBtn').addEventListener('click', function () {
                    if (response.id_role == 3) {
                        let programId = response.id_program
                        searchCoursesRole(programId, null)
                    } else if (response.id_role == 4) {
                        let programId = response.id_program
                        let userId = response.id
                        searchCoursesRole(programId, userId);
                    }
                });
                resolve(2)
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
            return;
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
            document.getElementById('viewSelectEvaluation').classList.remove('d-none');
            document.getElementById('createReferent').classList.remove('d-none');
            document.getElementById('tableReferent').classList.add('d-none');
            $('#bodyReferences').empty();
        } else {
            document.querySelectorAll('.nextCard').forEach(function (button) {
                button.classList.remove('d-none');
            });
            document.querySelectorAll('.confirmationSave').forEach(function (button) {
                button.classList.add('d-none');
            });
            document.getElementById('viewSelectEvaluation').classList.add('d-none');
            document.getElementById('createReferent').classList.add('d-none');
            document.getElementById('tableReferent').classList.remove('d-none');
        }
    }

    function validateEvaluation(data) {
        const percentageField = document.getElementById(`inputPercentage${data}`);
        const evaluationField = document.getElementById(`selectEvaluation${data}`);
        const buttonField = document.getElementById(`savePercentage${data}`);
        const percentageContent = parseFloat(percentageField.value);
        const evaluationContent = evaluationField.value;
        const selectedOption = evaluationField.options[evaluationField.selectedIndex];
        const nameEvaluation = selectedOption.getAttribute('data-name');

        const maxPercentage = data === '3' ? 40 : 30;

        if (percentageContent !== '' && evaluationContent !== '') {
            if (data == 1) {
                if (savesEvaluation1.some(evaluation => evaluation.evaluationId == evaluationContent)) {
                    Swal.fire({
                        title: 'Advertencia',
                        icon: 'warning',
                        text: 'La evaluación ya ha sido registrada.',
                        confirmButtonColor: '#1572E8',
                        confirmButtonText: 'Aceptar',
                    });
                    return;
                }

                if (sumPercentage1 + percentageContent <= maxPercentage) {
                    savesEvaluation1.push({
                        data: data,
                        evaluationId: evaluationContent,
                        nameEvaluation: nameEvaluation,
                        percentageValue: percentageContent,
                    });
                    sumPercentage1 += percentageContent;
                    if (sumPercentage1 === maxPercentage) {
                        percentageField.disabled = true;
                        evaluationField.disabled = true;
                        buttonField.disabled = true;
                    }
                } else {
                    Swal.fire({
                        title: 'Advertencia',
                        icon: 'warning',
                        text: `La suma de los porcentajes no puede superar los ${maxPercentage}`,
                        confirmButtonColor: '#1572E8',
                        confirmButtonText: 'Aceptar',
                    });
                    return;
                }
            } else if (data == 2) {
                if (savesEvaluation2.some(evaluation => evaluation.evaluationId == evaluationContent)) {
                    Swal.fire({
                        title: 'Advertencia',
                        icon: 'warning',
                        text: 'La evaluación ya ha sido registrada.',
                        confirmButtonColor: '#1572E8',
                        confirmButtonText: 'Aceptar',
                    });
                    return;
                }

                if (sumPercentage2 + percentageContent <= maxPercentage) {
                    savesEvaluation2.push({
                        data: data,
                        evaluationId: evaluationContent,
                        nameEvaluation: nameEvaluation,
                        percentageValue: percentageContent,
                    });
                    sumPercentage2 += percentageContent;

                    if (sumPercentage2 === maxPercentage) {
                        percentageField.disabled = true;
                        evaluationField.disabled = true;
                    }
                } else {
                    Swal.fire({
                        title: 'Advertencia',
                        icon: 'warning',
                        text: `La suma de los porcentajes no puede superar los ${maxPercentage}`,
                        confirmButtonColor: '#1572E8',
                        confirmButtonText: 'Aceptar',
                    });
                    return;
                }
            } else if (data == 3) {
                if (savesEvaluation3.some(evaluation => evaluation.evaluationId == evaluationContent)) {
                    Swal.fire({
                        title: 'Advertencia',
                        icon: 'warning',
                        text: 'La evaluación ya ha sido registrada.',
                        confirmButtonColor: '#1572E8',
                        confirmButtonText: 'Aceptar',
                    });
                    return;
                }

                if (sumPercentage3 + percentageContent <= maxPercentage) {
                    savesEvaluation3.push({
                        data: data,
                        evaluationId: evaluationContent,
                        nameEvaluation: nameEvaluation,
                        percentageValue: percentageContent,
                    });
                    sumPercentage3 += percentageContent; // Actualizar la suma
                    // Deshabilitar los campos si la suma llega al máximo
                    if (sumPercentage3 === maxPercentage) {
                        percentageField.disabled = true;
                        evaluationField.disabled = true;
                    }
                } else {
                    Swal.fire({
                        title: 'Advertencia',
                        icon: 'warning',
                        text: `La suma de los porcentajes no puede superar los ${maxPercentage}`,
                        confirmButtonColor: '#1572E8',
                        confirmButtonText: 'Aceptar',
                    });
                    return;
                }
            }

            // Limpiar los campos de input y select después de agregar una evaluación
            percentageField.value = '';  // Limpiar el campo de porcentaje
            evaluationField.value = '';  // Limpiar el select de evaluación
        } else {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'Los campos no pueden estar vacíos',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar',
            });
            return;
        }
    }

    function validateReferences(institutionalLinks, generalLinks) {

        if (institutionalLinks !== '' && generalLinks !== '') {
            $('#modalConfirmation').modal('show');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor, ingresa al menos un link de referencias',
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
            return;
        }

    }

    function validatePercentageSum(evaluations, evaluations2, evaluations3) {
        const totalPercentage = evaluations.reduce((sum, evaluation) => sum + evaluation.percentageValue, 0);
        const totalPercentage2 = evaluations2.reduce((sum, evaluation) => sum + evaluation.percentageValue, 0);
        const totalPercentage3 = evaluations3.reduce((sum, evaluation) => sum + evaluation.percentageValue, 0);

        if (totalPercentage !== 30) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: `La suma de los valores de porcentaje en la Evaluación 1 es ${totalPercentage}, debe ser igual a 30.`,
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        if (totalPercentage2 !== 30) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: `La suma de los valores de porcentaje en la Evaluación 2 es ${totalPercentage2}, debe ser igual a 30.`,
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        if (totalPercentage3 !== 40) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: `La suma de los valores de porcentaje en la Evaluación 3 es ${totalPercentage3}, debe ser igual a 40.`,
                confirmButtonColor: '#1269DB',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        return true;
    }

    // SEARCH
    function searchProgram(facultyId, typeClassroomId) {
        const selectElement = document.getElementById('selectProgram');
        if (typeClassroomId == 2) {
            educationId = 1;
        } else {
            educationId = 2;
        }

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

    function searchCoursesRole(programIds, userId) {
        $('#modalCourse').modal('show');
        $.ajax({
            url: '/classroom-plan/search-course-role',
            method: 'POST',
            data: {
                programId: programIds,
                userId: userId,
            },
            success: function (response) {
                if (programIds == null) {
                    viewSelectCampoComun(response)
                } else {
                    if (response.educationId == 1) {
                        viewSelectPensum(response)
                        typeClassroomId = 2
                    } else {
                        viewSelectSpecialization(response);
                        typeClassroomId = 3
                    }
                }

                programId = programIds;
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function searchCourses(programId, typeClassroomId) {
        if (typeClassroomId == 2) {
            educationId = 1;
        } else {
            educationId = 2;
        }

        if (programId !== '') {
            $('#modalCourse').modal('show');

            $.ajax({
                url: '/classroom-plan/search-course',
                method: 'POST',
                data: {
                    programId: programId,
                    educationId: educationId,
                },
                success: function (response) {
                    if (programId == null) {
                        viewSelectCampoComun(response)
                    } else if (educationId == 1) {
                        viewSelectPensum(response)
                    } else {
                        viewSelectSpecialization(response);
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

    function searchInfoCourse(realtionId, typeClassroomId) {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/classroom-plan/search-info-course',
                type: 'POST',
                data: {
                    realtionId: realtionId,
                },
                success: function (response) {
                    if (typeClassroomId == null) {
                        viewInfoCampoComun(response);
                        componentId = response.relationInfo[0].course.id_component;
                    } else if (typeClassroomId == 2) {
                        viewInfoPensum(response);
                        componentId = response.relationInfo[0].course.id_component;
                    } else {
                        viewInfoSpecialization(response);
                        componentId = null;
                    }
                    resolve(componentId);
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    reject(error);
                }
            });
        });
    }

    function searchComponent(checkin, componentId, programId) {
        $.ajax({
            url: '/classroom-plan/search-list-courses',
            type: 'POST',
            data: {
                componentId: componentId,
                programId: programId,
            },
            success: function (response) {
                if (checkin == '1') {
                    viewListComponent(response)
                } else if (checkin == '2') {
                    viewListComponent(response)
                } else if (checkin == '3') {
                    viewListSpecialization(response)
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
            }
        });
    }

    function searchClassroomPlan(realtionId, programId) {
        $.ajax({
            url: '/classroom-plan/search-classroom-plans',
            method: 'POST',
            data: {
                realtionId: realtionId,
            },
            success: function (response) {
                let check = response.check;
                if (check == false) {
                    searchLearning(programId, check);
                    viewSelectEvaluation(response);
                    validateResfresh(false);
                } else {
                    viewSelectLearningResult(response, check);
                    viewClassroom(response);
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

    function searchLearning(programId, check) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/classroom-plan/search-learning',
                method: 'POST',
                data: {
                    programId: programId,
                },
                success: function (response) {
                    resolve(response);
                    viewSelectLearningResult(response, check);
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

    function searchDescriptionLearning(learningId) {

        $.ajax({
            url: '/classroom-plan/search-description-Learning',
            method: 'POST',
            data: {
                learningId: learningId,
            },
            success: function (response) {
                document.getElementById('textAreaDescriptionRA').value = response.learningResult[0].description_learning_result;
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });

    }

    function searchData(classroomId) {
        $.ajax({
            url: '/classroom-plan/search-data',
            method: 'POST',
            data: {
                classroomId: classroomId,
            },
            success: function (response) {
                console.log(response)
                viewAllInfo(response)
            },
            error: function (xhr, status, error) {
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function viewAllInfo(response) {
        // Competencias y resultados de aprendizaje
        const descriptionLearning = response.classroomInfo[0].learning_result.description_learning_result;

        document.getElementById('textAreaDescriptionLearning').value = descriptionLearning; // TEXTAREA

        // Objetivos generales y específicos
        const descriptionGeneral = response.classroomInfo[0].general_objective.description_general_objective;
        const specificContent = response.specificInfo;

        const generalTextArea = document.getElementById('textAreaDescriptionGeneral');
        generalTextArea.value = capitalizeOrDefault(descriptionGeneral); // TEXTAREA

        specificContent.forEach((specific, index) => {
            const i = index + 1;
            const specificTextArea = document.getElementById(`textAreaDescriptionSpecific${i}`);
            specificTextArea.value = capitalizeOrDefault(specific.description_specific_objective); // TEXTAREA
        });

        const topicInfo = response.topicInfo;

        const sections = [
            { id: "fromWeeks1", start: 0, end: 5 },  // Semanas 1-5
            { id: "fromWeeks2", start: 5, end: 10 }, // Semanas 6-10
            { id: "fromWeeks3", start: 10, end: 17 } // Semanas 11-16
        ];

        sections.forEach((section, index) => {
            // Inicia el contenido de cada sección
            let topicsContent = '<div class="row">';

            // Genera las tarjetas de temas dentro del rango especificado
            const topics = topicInfo.slice(section.start, section.end).map((topic, i) => `
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="textAreaTopic${section.start + i + 1}">Tema semana ${section.start + i + 1}:</label>
                        <textarea class="form-control unlockFields" data-topics-id="${topic.id}" id="textAreaTopic${section.start + i + 1}" rows="5" disabled>${capitalizeOrDefault(topic.description_topic)}</textarea>
                    </div>
                </div>
            `).join('');

            // Cierra el contenido y lo inyecta en el DOM
            topicsContent += topics + '</div>';
            document.getElementById(section.id).innerHTML = topicsContent || '<h3>No se encontraron resultados.</h3>';
        });

        // Evaluaciones
        const evaluationInfo = response.assigEvaluationInfo;
        const bodyEvaluation = $('#bodyEvaluation2');
        bodyEvaluation.empty();

        if (evaluationInfo.length > 0) {
            evaluationInfo.forEach(evaluation => {
                bodyEvaluation.append(`
                    <tr>
                        <td>${capitalizeOrDefault(evaluation.evaluation.name_evaluation)}</td>
                        <td>${evaluation.percentage_number}%</td>
                        <td>${capitalizeOrDefault(evaluation.percentage.name_percentage)}</td>
                    </tr>
                `);
            });
        } else {
            bodyEvaluation.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }

        // Referencias
        const referencesId = response.referencsInfo;
        const bodyReferences = $('#bodyReferences2');
        bodyReferences.empty();

        if (referencesId.length > 0) {
            referencesId.forEach((reference, index) => {
                bodyReferences.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${capitalizeOrDefault(reference.name_reference)}</td>
                        <td>${reference.link_reference}</td>
                    </tr>
                `);
            });
        } else {
            bodyReferences.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }

        $('#modalListCourses').modal('show');
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

    function viewSelectCampoComun(response) {
        document.getElementById('specializationContainer').classList.add('d-none');
        document.getElementById('pensumContainer').classList.add('d-none');
        document.getElementById('campoComunContainer').classList.remove('d-none');

        let bodyCampoComun = $('#bodyCampoComun');
        bodyCampoComun.empty();

        let arrayContent = response.relationInfo;

        if (arrayContent.length > 0) {
            arrayContent.forEach(function (array) {
                let row = `
                    <tr>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm campoComunSelect" 
                                data-id="${array.id}">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </td>
                        <td>${capitalizeOrDefault(array.course.component?.study_field?.name_study_field)}</td>
                        <td>${capitalizeOrDefault(array.course.component?.name_component)}</td>
                        <td>${capitalizeOrDefault(array.course.name_course)}</td>
                        <td>${capitalizeOrDefault(array.course.semester?.name_semester)}</td>
                        <td align="center">${array.course.credit || 'sin asignación'}</td>
                        <td>${capitalizeOrDefault(array.course.course_type?.name_course_type)}</td>
                    </tr>
                `;
                bodyCampoComun.append(row);
            });

        } else {
            // Mostrar un mensaje si no se encontraron cursos
            bodyCampoComun.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    function viewSelectPensum(response) {
        document.getElementById('specializationContainer').classList.add('d-none');
        document.getElementById('pensumContainer').classList.remove('d-none');
        document.getElementById('campoComunContainer').classList.add('d-none');

        let bodyPensum = $('#bodyPensum');
        bodyPensum.empty();

        let arrayContent = response.relationInfo;

        if (arrayContent.length > 0) {
            arrayContent.forEach(function (array) {
                let row = `
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm pensumSelect" 
                                    data-id="${array.id}">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </td>
                            <td>${capitalizeOrDefault(array.program?.faculty?.name_faculty)}</td>
                            <td>${capitalizeOrDefault(array.program?.name_program)}</td>
                            <td>${capitalizeOrDefault(array.course?.component?.study_field?.name_study_field)}</td>
                            <td>${capitalizeOrDefault(array.course?.component?.name_component)}</td>
                            <td>${capitalizeOrDefault(array.course?.name_course)}</td>
                            <td>${capitalizeOrDefault(array.course?.semester?.name_semester)}</td>
                            <td align="center">${array.course?.credit || 'sin asignación'}</td>
                            <td>${capitalizeOrDefault(array.course?.course_type?.name_course_type)}</td>
                        </tr>
                    `;
                bodyPensum.append(row);
            });

        } else {
            // Mostrar un mensaje si no se encontraron cursos
            bodyPensum.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }

    }

    function viewSelectSpecialization(response) {
        document.getElementById('specializationContainer').classList.remove('d-none');
        document.getElementById('pensumContainer').classList.add('d-none');
        document.getElementById('campoComunContainer').classList.add('d-none');

        let bodySpecialization = $('#bodySpecialization');
        bodySpecialization.empty();

        let arrayContent = response.relationInfo;

        if (arrayContent && arrayContent.length > 0) {
            arrayContent.forEach(function (array) {
                let row = `
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm specializationSelect" 
                                    data-id="${array.id}">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </td>
                            <td>${capitalizeOrDefault(array.program?.faculty?.name_faculty)}</td>
                            <td>${capitalizeOrDefault(array.program?.name_program)}</td>
                            <td>${capitalizeOrDefault(array.course?.name_course)}</td>
                            <td>${capitalizeOrDefault(array.course?.semester?.name_semester)}</td>
                            <td align="center">${array.course?.credit || 'sin asignación'}</td>
                            <td>${capitalizeOrDefault(array.course?.course_type?.name_course_type)}</td>
                        </tr>
                    `;
                bodySpecialization.append(row);
            });

        } else {
            bodySpecialization.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }

    }

    function viewInfoCampoComun(response) {
        // CERRRA MODAL
        $('#modalCourse').modal('hide');

        document.getElementById('infoSpecialization').classList.add('d-none');
        document.getElementById('infoPensum').classList.add('d-none');
        document.getElementById('infoCampoComun').classList.remove('d-none');

        let arrayContent = response.relationInfo;

        let relation;

        if (arrayContent.length > 0) {
            relation = arrayContent[0];
        } else {
            console.error('No se encontraron.');
            return;
        }

        $('#nameSemesterCC').text(capitalizeOrDefault(relation.course.semester.name_semester));
        $('#codeCourseCC').text(relation.course.course_code || 'sin asignación');
        $('#nameCourseCC').text(capitalizeOrDefault(relation.course.name_course));
        $('#educationLevelCC').text('Pregrado');
        $('#nameFieldCC').text(capitalizeOrDefault(relation.course.component.study_field.name_study_field));
        $('#nameComponentCC').text(capitalizeOrDefault(relation.course.component.name_component));
        $('#nameCreditsCC').text(relation.course.credit || 'sin asignación');
        $('#nameCourseTypeCC').text(capitalizeOrDefault(relation.course.course_type?.name_course_type));

    }

    function viewInfoPensum(response) {
        // CERRAR MODAL
        $('#modalCourse').modal('hide');

        document.getElementById('infoSpecialization').classList.add('d-none');
        document.getElementById('infoPensum').classList.remove('d-none');
        document.getElementById('infoCampoComun').classList.add('d-none');

        let arrayContent = response.relationInfo;

        let relation;

        if (arrayContent.length > 0) {
            relation = arrayContent[0];
        } else {
            console.error('No se encontraron.');
            return;
        }

        $('#nameFaculty').text(capitalizeOrDefault(relation.program.faculty.name_faculty));
        $('#nameProgram').text(capitalizeOrDefault(relation.program.name_program));
        $('#nameSemester').text(capitalizeOrDefault(relation.course.semester.name_semester));
        $('#codeCourse').text(relation.course.course_code || 'sin asignación');
        $('#nameCourse').text(capitalizeOrDefault(relation.course.name_course));
        $('#educationLevel').text(capitalizeOrDefault(relation.program.education_level.name_education_level));
        $('#nameField').text(capitalizeOrDefault(relation.course.component.study_field.name_study_field));
        $('#nameComponent').text(capitalizeOrDefault(relation.course.component.name_component));
        $('#nameCredits').text(relation.course.credit || 'sin asignación');
        $('#nameCourseType').text(capitalizeOrDefault(relation.course?.course_type.name_course_type));

    }

    function viewInfoSpecialization(response) {
        // CERRAR MODAL
        $('#modalCourse').modal('hide');

        document.getElementById('infoSpecialization').classList.remove('d-none');
        document.getElementById('infoPensum').classList.add('d-none');
        document.getElementById('infoCampoComun').classList.add('d-none');

        let arrayContent = response.relationInfo;

        let relation;

        if (arrayContent.length > 0) {
            relation = arrayContent[0];
        } else {
            console.error('No se encontraron.');
            return;
        }

        $('#nameFacultyS').text(capitalizeOrDefault(relation.program?.faculty?.name_faculty));
        $('#nameProgramS').text(capitalizeOrDefault(relation.program?.name_program));
        $('#nameSemesterS').text(capitalizeOrDefault(relation.course?.semester?.name_semester));
        $('#codeCourseS').text(relation.course?.course_code || 'sin asignación');
        $('#nameCourseS').text(capitalizeOrDefault(relation.course?.name_course));
        $('#educationLevelS').text(capitalizeOrDefault(relation.program?.education_level.name_education_level));
        $('#nameCreditsS').text(relation.course?.credit || 'sin asignación');
        $('#nameCourseTypeS').text(capitalizeOrDefault(relation.course?.course_type?.name_course_type));

    }

    function viewSelectLearningResult(response, check) {
        const selectElement = document.getElementById('selectLearning');
        selectElement.innerHTML = '';

        if (check == true) {
            const learning = response.classroomPlanId[0].learning_result;
            const option = document.createElement('option');
            option.value = learning.id;
            option.text = learning.name_learning_result;
            option.selected = true;
            selectElement.appendChild(option);

            document.getElementById('selectLearning').disabled = true;
            document.getElementById('textAreaDescriptionRA').value = learning.description_learning_result;
        } else {
            const defaultOption = document.createElement('option');
            defaultOption.disabled = false;
            defaultOption.selected = true;
            defaultOption.value = '';
            defaultOption.text = 'Seleccione un resultado de aprendizaje';
            selectElement.appendChild(defaultOption);

            if (response.learningResultsId && response.learningResultsId.length > 0) {
                response.learningResultsId.forEach(function (learningArray) {
                    learningArray.forEach(function (learning) {
                        const option = document.createElement('option');
                        option.value = learning.id;
                        option.text = learning.name_learning_result;
                        selectElement.appendChild(option);
                    });
                });
                selectElement.removeAttribute('disabled');
            } else {
                selectElement.setAttribute('disabled', true);
            }
        }

    }

    function viewListComponent(response) {

        blockCampos(true, true);

        let arrayContent = response.classroomPlanInfo;
        let bodyComponent = $('#bodyComponent');
        bodyComponent.empty();

        if (arrayContent.length > 0) {
            arrayContent.forEach(function (array) {
                let row = `
                        <tr class="highlight-row">                
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.component.study_field.name_study_field)}
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.component.name_component)}
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.course_code)}                        
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.name_course)}                        
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.semester.name_semester)}                                
                                </a>
                            </td>
                            <td align="center" >
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${array.relations.course.credit}
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.course_type.name_course_type)}
                                </a>
                            </td>
                        </tr>
                `;
                bodyComponent.append(row);
            });
            document.querySelectorAll('.viewInfoCp').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    const classroomId = this.getAttribute('data-id');
                    searchData(classroomId);
                });
            });
        } else {
            bodyComponent.append('<tr><td colspan="6">No se encontraron resultados.</td></tr>');
        }
    }

    function viewListSpecialization(response) {

        blockCampos(false, false);

        let arrayContent = response.classroomPlanInfo;
        let bodyComponent = $('#bodyComponent');
        bodyComponent.empty();

        if (arrayContent.length > 0) {
            arrayContent.forEach(function (array) {
                let row = `
                        <tr class="highlight-row">                            
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.course_code)}                        
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.name_course)}                        
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.semester.name_semester)}                                
                                </a>
                            </td>
                            <td align="center">
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${array.relations.course.credit}
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-dark viewInfoCp" data-id="${array.id}">
                                    ${capitalizeOrDefault(array.relations.course.course_type.name_course_type)}
                                </a>
                            </td>
                        </tr>
                `;
                bodyComponent.append(row);
            });
            document.querySelectorAll('.viewInfoCp').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    const classroomId = this.getAttribute('data-id');
                    searchData(classroomId);
                });
            });
        } else {
            bodyComponent.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    function viewInfoEvaluation(response) {

        let evaluations1 = [];
        let evaluations2 = [];
        let evaluations3 = [];

        // Verificar si se encontraron cursos en la respuesta
        if (response.length > 0) {
            response.forEach(function (resp) {
                var percentageId = resp.id_percentage;

                if (percentageId === 1) {
                    var evaluationInfo = (resp.evaluation && resp.evaluation.name_evaluation)
                        ? capitalizeOrDefault(resp.evaluation.name_evaluation) + '-' + resp.percentage_number + '%' // Capitalizar
                        : 'Nombre de evaluación no disponible'; // Valor alternativo si no existe
                    evaluations1.push(evaluationInfo); // Agregar al arreglo de evaluaciones 1
                } else if (percentageId === 2) {
                    var evaluationInfo = (resp.evaluation && resp.evaluation.name_evaluation)
                        ? capitalizeOrDefault(resp.evaluation.name_evaluation) + '-' + resp.percentage_number + '%' // Capitalizar
                        : 'Nombre de evaluación no disponible'; // Valor alternativo
                    evaluations2.push(evaluationInfo); // Agregar al arreglo de evaluaciones 2
                } else if (percentageId === 3) {
                    var evaluationInfo = (resp.evaluation && resp.evaluation.name_evaluation)
                        ? capitalizeOrDefault(resp.evaluation.name_evaluation) + '-' + resp.percentage_number + '%' // Capitalizar
                        : 'Nombre de evaluación no disponible'; // Valor alternativo
                    evaluations3.push(evaluationInfo); // Agregar al arreglo de evaluaciones 3
                }
            });

            // Mostrar todos los nombres de evaluación en los elementos correspondientes, separados por salto de línea
            document.getElementById('percentage1').innerText = evaluations1.join('\n') || 'Sin evaluaciones';
            document.getElementById('percentage2').innerText = evaluations2.join('\n') || 'Sin evaluaciones';
            document.getElementById('percentage3').innerText = evaluations3.join('\n') || 'Sin evaluaciones';
        } else {
            document.getElementById('percentage1').innerText = 'Sin evaluaciones';
            document.getElementById('percentage2').innerText = 'Sin evaluaciones';
            document.getElementById('percentage3').innerText = 'Sin evaluaciones';
        }

    }

    function viewClassroom(response) {

        let general = response.classroomPlanId[0].general_objective.description_general_objective;
        let specifics = response.specificsId;
        let topics = response.topicsId;
        let evaluation = response.evaluationsId;
        let reference = response.referencesId;

        document.getElementById('textAreaObjective').value = general;

        specifics.forEach((specific, index) => {
            let description = specific.description_specific_objective;
            let specificTextArea = document.getElementById(`textAreaSpecific${index + 1}`);
            if (specificTextArea) {
                specificTextArea.value = description;
            }

            let collapseCardBody = document.querySelector(`#collapse${index + 1} .card-body`);
            if (collapseCardBody) {
                collapseCardBody.innerText = description;
            }
        });

        topics.forEach((topic, index) => {
            let description = topic.description_topic;
            let topicsTextArea = document.getElementById(`textAreaTheme${index + 1}`);
            if (topicsTextArea) {
                topicsTextArea.value = description;
            }
        });

        viewInfoEvaluation(evaluation);
        ViewtableReferences(reference)
    }

    function viewSelectEvaluation(response) {
        document.getElementById('viewSelectEvaluation').classList.remove('d-none');
        const selectElements = document.querySelectorAll('.selectEvaluation');

        selectElements.forEach(selectElement => {
            selectElement.innerHTML = '';

            const defaultOption = document.createElement('option');
            defaultOption.disabled = false;
            defaultOption.selected = true;
            defaultOption.value = '';
            defaultOption.text = 'Seleccione una evaluación';
            selectElement.appendChild(defaultOption);

            if (response.courseTypeInfo && response.courseTypeInfo.length > 0) {
                response.courseTypeInfo.forEach(function (courseTypeArray) {
                    const option = document.createElement('option');
                    option.value = courseTypeArray.id;
                    option.setAttribute('data-name', courseTypeArray.name_evaluation);
                    option.text = capitalizeOrDefault(courseTypeArray.name_evaluation);
                    selectElement.appendChild(option);
                });
                selectElement.removeAttribute('disabled');
            } else {
                selectElement.setAttribute('disabled', true);
            }
        });
    }

    function viewDataEvaluation(savesEvaluation1, savesEvaluation2, savesEvaluation3) {
        const formatEvaluations = (evaluations) => {
            return evaluations.map(evaluation =>
                `Evaluación: ${capitalizeOrDefault(evaluation.nameEvaluation)}, Porcentaje: ${evaluation.percentageValue}%`
            ).join('\n') || 'Sin evaluaciones';
        };

        document.getElementById('percentage1').innerText = formatEvaluations(savesEvaluation1);
        document.getElementById('percentage2').innerText = formatEvaluations(savesEvaluation2);
        document.getElementById('percentage3').innerText = formatEvaluations(savesEvaluation3);
    }

    function ViewtableReferences(response) {

        var referencesId = response;

        var bodyReferences = $('#bodyReferences');
        bodyReferences.empty();

        if (referencesId.length > 0) {
            let cont = 1;
            referencesId.forEach(function (reference) {

                var row = `
                <tr>
                    <td>
                        ${cont++}
                    </td>                               
                    <td>
                        ${capitalizeOrDefault(reference.name_reference)}
                    </td>
                    <td>
                        ${reference.link_reference}
                    </td>                                      
                </tr>
            `;
                bodyReferences.append(row);
            });
        } else {
            bodyReferences.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    function viewReferences(dataLinks, linkReference) {
        // Inicializar arreglos para acumular los nombres de evaluación
        let references1 = [];
        let references2 = [];

        if (dataLinks == 1) {
            if (Array.isArray(linkReference) && linkReference.length > 0) {
                linkReference.forEach(function (resp) {
                    references1.push(resp);
                });

                document.getElementById('institutionalView').innerHTML = references1.join('<br>');

            } else {
                document.getElementById('institutionalView').textContent = 'Sin referencias institucionales';
            }
        } else {
            if (Array.isArray(linkReference) && linkReference.length > 0) {
                linkReference.forEach(function (resp) {
                    references2.push(resp);
                });

                document.getElementById('generalView').innerHTML = references2.join('<br>');
            } else {
                document.getElementById('generalView').textContent = 'Sin referencias generales';
            }
        }
    }

    // DATA
    function dataReference(dataLinks) {
        if (dataLinks == 1) {
            let institutionalLink = document.getElementById('linkInstitutionalReferences').value;
            institutionalLinks.push(institutionalLink);
            viewReferences(dataLinks, institutionalLinks);
            document.getElementById('linkInstitutionalReferences').value = '';
        } else {
            let generalLink = document.getElementById('linkGeneralReferences').value;
            generalLinks.push(generalLink);
            viewReferences(dataLinks, generalLinks);
            document.getElementById('linkGeneralReferences').value = '';
        }
    }

    // COMFIRMATIONS
    function confirmationSave(dataConfirmation, savesEvaluation1, savesEvaluation2, savesEvaluation3) {
        if (dataConfirmation == '1') {
            validate(
                ['selectLearning'],
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
            const isValid = validatePercentageSum(savesEvaluation1, savesEvaluation2, savesEvaluation3);
            if (isValid) {
                $('#modalConfirmation').modal('show');
            }
        } else if (dataConfirmation == '8') {
            validateReferences();
        }
    }

    function confirmButton(dataConfirmation, learningId, realtionId, savesEvaluation1, savesEvaluation2, savesEvaluation3) {
        // Cambiar a la siguiente card
        showNextCard();

        // Cerrar el modal
        $('#modalConfirmation').modal('hide');

        if (dataConfirmation == 1) {
            if (learningId !== '' && realtionId !== '') {
                saveClassroomPlan(realtionId, learningId).then(response => {
                    classroomId = response.createClassroom.id;
                    assigEvaId = response.assignmentEvaluations;
                    referencesId = response.references;
                    specificId = response.specificObjectives;
                    learningId = '';
                    realtionId = '';
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 2) {
            let generalObjective = document.getElementById('textAreaObjective').value;

            if (generalObjective !== '') {
                saveObjGeneral(classroomId, generalObjective).then(response => {
                    generalObjective = '';
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 3) {
            let specificObjectives = [];

            for (let i = 1; i <= 3; i++) {
                let objectiveValue = document.getElementById(`textAreaSpecific${i}`).value;
                if (objectiveValue !== '') {
                    specificObjectives.push(objectiveValue);
                    document.querySelector(`#collapse${i} .card-body`).innerText = objectiveValue;
                }
            }

            // Verificar si todos los objetivos específicos tienen valor antes de guardar
            if (specificObjectives.length === 3) {
                saveObjSpecific(classroomId, specificId, specificObjectives).then(response => {
                    specificId = response;
                    // Reiniciar los valores después de guardar
                    specificObjectives.forEach((_, index) => {
                        document.getElementById(`textAreaSpecific${index + 1}`).value = '';
                    });
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 4) {
            let topics = [];

            for (let i = 1; i <= 5; i++) {
                let TopicValue = document.getElementById(`textAreaTheme${i}`).value;
                if (TopicValue !== '') {
                    topics.push(TopicValue);
                }
            }

            // Verificar si todos los objetivos específicos tienen valor antes de guardar
            if (topics.length === 5) {
                saveTopic(specificId[0], topics).then(response => {

                    // Reiniciar los valores después de guardar
                    topics.forEach((_, index) => {
                        document.getElementById(`textAreaTheme${index + 1}`).value = '';
                    });
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 5) {
            let topics2 = [];

            for (let i = 6; i <= 10; i++) {
                let TopicValue2 = document.getElementById(`textAreaTheme${i}`).value;
                if (TopicValue2 !== '') {
                    topics2.push(TopicValue2);
                }
            }

            // Verificar si todos los objetivos específicos tienen valor antes de guardar
            if (topics2.length === 5) {
                saveTopic(specificId[1], topics2).then(response => {

                    // Reiniciar los valores después de guardar
                    topics2.forEach((_, index) => {
                        document.getElementById(`textAreaTheme${index + 1}`).value = '';
                    });
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 6) {
            let topics3 = [];

            for (let i = 11; i <= 16; i++) {
                let TopicValue3 = document.getElementById(`textAreaTheme${i}`).value;
                if (TopicValue3 !== '') {
                    topics3.push(TopicValue3);
                }
            }

            // Verificar si todos los objetivos específicos tienen valor antes de guardar
            if (topics3.length === 6) {
                saveTopic(specificId[2], topics3).then(response => {

                    // Reiniciar los valores después de guardar
                    topics3.forEach((_, index) => {
                        document.getElementById(`textAreaTheme${index + 1}`).value = '';
                    });
                }).catch(error => {
                    console.error("Error en la solicitud AJAX:", error);
                });
            }
        } else if (dataConfirmation == 7) {
            if (savesEvaluation1 !== '' && savesEvaluation2 !== '' && savesEvaluation3 !== '') {
                saveAsEvaluation(classroomId, assigEvaId, savesEvaluation1, savesEvaluation2, savesEvaluation3);
            }
        } else if (dataConfirmation == 8) {
            saveReference(classroomId, referencesId, institutionalLinks, generalLinks);
        }
    }

    // CREATE
    function saveClassroomPlan(realtionId, learningId) {

        const nameGeneral = 'Objetivo general';

        const nameSpecific = [
            'Objetivo especifico #1',
            'Objetivo especifico #2',
            'Objetivo especifico #3'
        ];

        const nameReference = [
            'Referencia institucional',
            'Referencia general',
        ];

        const content = 'No se registro contenido';

        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/classroom-plan/create-classroom-plans',
                method: 'POST',
                data: {
                    realtionId: realtionId,
                    learningId: learningId,
                    nameGeneral: nameGeneral,
                    nameSpecificOne: nameSpecific[0],
                    nameSpecificTwo: nameSpecific[1],
                    nameSpecificThree: nameSpecific[2],
                    nameReferenceOne: nameReference[0],
                    nameReferenceTwo: nameReference[1],
                    content: content,
                },
                success: function (response) {

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

    function saveObjGeneral(classroomId, generalObjective) {
        return new Promise((resolve, reject) => {
            // Realizar la petición AJAX
            $.ajax({
                url: '/classroom-plan/save-general-objective',
                type: 'PUT',
                data: {
                    classroomId: classroomId,
                    generalObjective: generalObjective,
                },
                success: function (response) {
                    resolve(response);

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    reject(error);

                }
            });
        });

    }

    function saveObjSpecific(classroomId, specificId, specificObjectives) {
        return new Promise((resolve, reject) => {
            // Realizar la petición AJAX
            $.ajax({
                url: '/classroom-plan/save-specific-objective',
                type: 'PUT',
                data: {
                    specificId: specificId,
                    classroomId: classroomId,
                    specificObjectiveOne: specificObjectives[0],
                    specificObjectiveTwo: specificObjectives[1],
                    specificObjectiveThree: specificObjectives[2],
                },
                success: function (response) {
                    resolve(response.specificId);

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    reject(error);

                }
            });
        });
    }

    function saveTopic(specificId, topics) {
        return new Promise((resolve, reject) => {
            // Realizar la petición AJAX
            $.ajax({
                url: '/classroom-plan/save-topic',
                type: 'PUT',
                data: {
                    specificId: specificId,
                    topics: topics,
                },
                success: function (response) {
                    resolve(response);

                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
                    console.error('Error al obtener:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    reject(error);

                }
            });
        });
    }

    function saveAsEvaluation(classroomId, assigEvaId, savesEvaluation1, savesEvaluation2, savesEvaluation3) {
        $.ajax({
            url: '/classroom-plan/save-evaluations',
            type: 'PUT',
            data: {
                classroomId: classroomId,
                assigEvaId: assigEvaId,
                savesEvaluation1: savesEvaluation1,
                savesEvaluation2: savesEvaluation2,
                savesEvaluation3: savesEvaluation3,
            },
            success: function (response) {
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                reject(error);
            }
        });
    }

    function saveReference(classroomId, referencesId, institutionalLinks, generalLinks) {

        const nameReferences = [
            'Referencia institucional',
            'Referencia general',
        ];

        $.ajax({
            url: '/classroom-plan/save-references',
            type: 'PUT',
            data: {
                classroomId: classroomId,
                referencesId: referencesId,
                nameReferences: nameReferences,
                institutionalLinks: institutionalLinks,
                generalLinks: generalLinks,
            },
            success: function (response) {
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener:', xhr);
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

    document.getElementById('tableCampoComun').addEventListener('click', async function (event) {
        if (event.target.classList.contains('campoComunSelect')) {
            realtionId = event.target.dataset.id;
            await resetForm();
            await searchInfoCourse(realtionId, null).then(response => {
                componentId = response;
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });
            await searchComponent(1, componentId, null);
            await searchClassroomPlan(realtionId, null);
        }
    });

    document.getElementById('tablePensum').addEventListener('click', async function (event) {
        if (event.target.classList.contains('pensumSelect')) {
            realtionId = event.target.dataset.id;
            await resetForm();
            await searchInfoCourse(realtionId, typeClassroomId).then(response => {
                componentId = response;
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });
            await searchComponent(2, componentId, programId);
            await searchClassroomPlan(realtionId, programId);
        }
    });

    document.getElementById('tableSpecialization').addEventListener('click', async function (event) {
        if (event.target.classList.contains('specializationSelect')) {
            realtionId = event.target.dataset.id;
            await resetForm();
            await searchInfoCourse(realtionId, typeClassroomId).then(response => {
                componentId = response;
            }).catch(error => {
                console.error("Error en la solicitud AJAX:", error);
            });
            await searchComponent(3, componentId, programId);
            await searchClassroomPlan(realtionId, programId);
        }
    });

    document.getElementById('selectLearning').addEventListener('change', function () {
        learningId = this.value;
        searchDescriptionLearning(learningId);
    });

    document.querySelectorAll('.saveEvaluation').forEach(function (button) {
        button.addEventListener('click', function () {
            let data = this.getAttribute('data-evaluation');
            validateEvaluation(data);
            viewDataEvaluation(savesEvaluation1, savesEvaluation2, savesEvaluation3);
        });
    });

    document.querySelectorAll('.referenceLinks').forEach(function (button) {
        button.addEventListener('click', function () {
            const dataLinks = this.getAttribute('data-links');
            dataReference(dataLinks);
        });
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        confirmButton(dataConfirmation, learningId, realtionId, savesEvaluation1, savesEvaluation2, savesEvaluation3);
        unlockAttributes(confirmDataId);
    });

    document.querySelectorAll('.confirmationSave').forEach(function (button) {
        button.addEventListener('click', function () {
            dataConfirmation = this.getAttribute('data-confirmation');
            confirmationSave(dataConfirmation, savesEvaluation1, savesEvaluation2, savesEvaluation3);
        });
    });

    document.querySelectorAll('.nextCard').forEach(function (button) {
        button.addEventListener('click', function () {
            blockAttributes(confirmDataId);
            showNextCard();
        });
    });

});
