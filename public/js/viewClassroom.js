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
const classroomId = document.getElementById('classroomId').getAttribute('data-id');

let educationId;
let programId;
let learningId;
let courseTypeId;

let learningInfo;
let responseInfo;
let percentageInfo;

// EVALUATION
let assigEvaInfo;

// CONT ACTIVATE
let cont = true;

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * LLAMADOS
        *
    */
    searchClassroom(classroomId).then(response => {
        programId = response.classroomInfo.relations.id_program;
        courseTypeId = response.classroomInfo.relations.course.id_course_type;
        responseInfo = response;
    }).catch(error => {
        console.error("Error en la solicitud AJAX:", error);
    });;

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
    function blockCampos(showField, showEvaluation) {
        if (showField) {
            $('#tableReferences th:nth-child(4), #tableReferences td:nth-child(4)').css('display', '');
        } else {
            $('#tableReferences th:nth-child(4), #tableReferences td:nth-child(4)').css('display', 'none');
        }

        if (showEvaluation) {
            $('#tableEvaluation th:nth-child(4), #tableEvaluation td:nth-child(4)').css('display', '');
        } else {
            $('#tableEvaluation th:nth-child(4), #tableEvaluation td:nth-child(4)').css('display', 'none');
        }
    }

    // SEARCH
    function searchClassroom(classroomId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/view-classroom-plan/info-classroom-plans',
                method: 'POST',
                data: {
                    classroomId: classroomId,
                },
                success: function (response) {
                    viewBtnUpdate(response);
                    educationId = response.classroomInfo.relations.program?.id_education_level || null;
                    if (educationId == null) {
                        viewInfoCampoComun(response);
                    } else if (educationId == 1) {
                        viewInfoPensum(response);
                    } else if (educationId == 2) {
                        viewInfoSpecializations(response);
                    }
                    viewLearning(response);
                    viewObjectives(response);
                    viewTopics(response);
                    viewInfoEvaluation(response);
                    viewReferences(response);
                    resolve(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                    reject(error)
                }
            });
        });
    }

    // SEARCH UPDATE
    function searchData(programId, courseTypeId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/view-classroom-plan/search-learning-result',
                method: 'POST',
                data: {
                    programId: programId,
                    courseTypeId: courseTypeId,
                },
                success: function (response) {
                    viewLarningUpdate(response)
                    resolve(response)
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                    reject(error)
                }
            });
        });
    }

    // VIEWS
    function viewBtnUpdate(response) {
        let contentState = response.classroomInfo.id_state

        if (contentState == 1) {
            document.getElementById("btnActivateUpdate").classList.remove('d-none')
            document.getElementById("card-send").classList.remove('d-none')
        }

    }

    function viewInfoCampoComun(response) {
        let infoClassroom = response.classroomInfo;

        let infoContent;
        infoContent = `                
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Codigo de curso:</label>
                        <p>${infoClassroom.relations.course.course_code}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Curso:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.name_course)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Nivel de educación:</label>
                        <p>Pregrado</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Campo:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.component.study_field.name_study_field)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Componente:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.component.name_component)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Creditos:</label>
                        <p>${infoClassroom.relations.course.credit}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Semestre:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.semester.name_semester)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Tipo de curso:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.course_type.name_course_type)}</p>
                    </div>
                </div>
        `;
        document.getElementById("viewInfoCampoComun").innerHTML = infoContent;

    }

    function viewInfoPensum(response) {
        let infoClassroom = response.classroomInfo;
        let infoProgram = response.classroomInfo.learning_result.competence.profile_egres.program

        let infoContent;
        infoContent = ` 
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Facultad:</label>
                        <p>${capitalizeOrDefault(infoProgram.faculty.name_faculty)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Programa:</label>
                        <p>${capitalizeOrDefault(infoProgram.name_program)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Semestre:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.semester.name_semester)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Codigo de curso:</label>
                        <p>${infoClassroom.relations.course.course_code}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Curso:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.name_course)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Nivel de educación:</label>
                        <p>${capitalizeOrDefault(infoProgram.education_level.name_education_level)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Campo:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.component.study_field.name_study_field)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Componente:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.component.name_component)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Creditos:</label>
                        <p>${infoClassroom.relations.course.credit}</p>
                    </div>
                </div>                
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Tipo de curso:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.course_type.name_course_type)}</p>
                    </div>
                </div>
        `;
        document.getElementById("viewInfoPensum").innerHTML = infoContent;
    }

    function viewInfoSpecializations(response) {
        let infoClassroom = response.classroomInfo;
        let infoProgram = response.classroomInfo.learning_result.competence.profile_egres.program;

        let infoContent;
        infoContent = ` 
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Facultad:</label>
                        <p>${capitalizeOrDefault(infoProgram.faculty.name_faculty)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Programa:</label>
                        <p>${capitalizeOrDefault(infoProgram.name_program)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Semestre:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.semester.name_semester)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Codigo de curso:</label>
                        <p>${infoClassroom.relations.course.course_code}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Curso:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.name_course)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Nivel de educación:</label>
                        <p>${capitalizeOrDefault(infoProgram.education_level.name_education_level)}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Creditos:</label>
                        <p>${infoClassroom.relations.course.credit}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Tipo de curso:</label>
                        <p>${capitalizeOrDefault(infoClassroom.relations.course.course_type.name_course_type)}</p>
                    </div>
                </div>
        `;
        document.getElementById("viewInfoSpecializations").innerHTML = infoContent;
    }

    function viewLearning(response) {
        let nameCompetence = response.classroomInfo.learning_result.competence.name_competence;
        let nameLearning = response.classroomInfo.learning_result.name_learning_result;
        let descriptionCompetence = response.classroomInfo.learning_result.competence.description_competence;
        let descriptionLearning = response.classroomInfo.learning_result.description_learning_result;

        document.getElementById('labelNameCompetence').innerText = nameCompetence; // LABEL
        document.getElementById('textAreaDescriptionCompetence').value = descriptionCompetence; // TEXTAREA

        document.getElementById('labelNameLearning').innerText = nameLearning; // LABEL
        document.getElementById('textAreaDescriptionLearning').value = descriptionLearning; // TEXTAREA

    }

    function viewObjectives(response) {
        let generalId = response.classroomInfo.general_objective.id;
        let nameGeneral = response.classroomInfo.general_objective.name_general_objective;
        let descriptionGeneral = response.classroomInfo.general_objective.description_general_objective;

        let specificContent = response.specificInfo;

        document.getElementById('labelNameGeneral').innerText = capitalizeOrDefault(nameGeneral); // LABEL
        const textAreaElement = document.getElementById('textAreaDescriptionGeneral')
        textAreaElement.value = capitalizeOrDefault(descriptionGeneral); // TEXTAREA
        textAreaElement.setAttribute('data-id', generalId);

        specificContent.forEach((specific, index) => {
            const i = index + 1;
            const labelElement = document.getElementById(`labelSpecific${i}`);
            const textAreaElement = document.getElementById(`textAreaDescriptionSpecific${i}`);

            labelElement.innerText = capitalizeOrDefault(specific.name_specific_objective); // LABEL
            textAreaElement.value = capitalizeOrDefault(specific.description_specific_objective); // TEXTAREA

            textAreaElement.setAttribute('data-id', specific.id);
        });
    }

    function viewTopics(response) {
        let topicInfo = response.topicInfo;
        if (topicInfo.length > 0) {
            let topicsContent1 = '<div class="row">';
            topicInfo.slice(0, 5).forEach((topic, index) => {
                const i = index + 1;
                topicsContent1 += `
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="textAreaTopic${i}">Tema semana ${i}:</label>
                                <textarea class="form-control unlockFields" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeOrDefault(topic.description_topic)}</textarea>
                            </div>
                        </div>
                    `;
            });
            topicsContent1 += '</div>';
            document.getElementById("fromWeeks1").innerHTML = topicsContent1;

            let topicsContent2 = '<div class="row">';
            topicInfo.slice(5, 10).forEach((topic, index) => {
                const i = index + 6;
                topicsContent2 += `
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="textAreaTopic${i}">Tema semana ${i}:</label>
                                <textarea class="form-control unlockFields" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeOrDefault(topic.description_topic)}</textarea>
                            </div>
                        </div>
                    `;
            });
            topicsContent2 += '</div>';
            document.getElementById("fromWeeks2").innerHTML = topicsContent2;

            let topicsContent3 = '<div class="row">';
            topicInfo.slice(10, 17).forEach((topic, index) => {
                const i = index + 11;
                topicsContent3 += `
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="textAreaTopic${i}">Tema semana ${i}:</label>
                                <textarea class="form-control unlockFields" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeOrDefault(topic.description_topic)}</textarea>
                            </div>
                        </div>
                    `;
            });
            topicsContent3 += '</div>';
            document.getElementById("fromWeeks3").innerHTML = topicsContent3;

        } else {
            document.getElementById("fromWeeks1").innerHTML = '<h3>No se encontraron resultados.</h3>';
            document.getElementById("fromWeeks2").innerHTML = '<h3>No se encontraron resultados.</h3>';
            document.getElementById("fromWeeks3").innerHTML = '<h3>No se encontraron resultados.</h3>';
        }
    }

    function viewInfoEvaluation(response) {
        blockCampos(false, false);

        let evaluationInfo = response.assigEvaluationInfo;

        let bodyEvaluation = $('#bodyEvaluation');
        bodyEvaluation.empty();

        if (evaluationInfo.length > 0) {
            evaluationInfo.forEach(function (evaluation) {
                var row = `
                    <tr>
                        <td>
                            ${capitalizeOrDefault(evaluation.evaluation.name_evaluation)}
                        </td>                               
                        <td>
                            ${evaluation.percentage_number}%
                        </td>
                        <td>
                            ${capitalizeOrDefault(evaluation.percentage.name_percentage)}
                        </td>                        
                    </tr>
                `;
                bodyEvaluation.append(row);
            });
        } else {
            bodyEvaluation.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }

    }

    function viewReferences(response) {
        blockCampos(false, false);
        let referencesId = response.referencsInfo;

        let bodyReferences = $('#bodyReferences');
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

    // VIEWS UPDATE
    function viewLarningUpdate(response) {
        document.getElementById("viewDataProfile").classList.add('d-none');
        document.getElementById("viewDataUpdate").classList.remove('d-none');

        const selectElement = document.getElementById('selectLearning');

        selectElement.innerHTML = '<option disabled selected value="">Seleccione un resultado de aprendizaje</option>';

        response.learningInfo.forEach(function (learning) {
            const option = document.createElement('option');
            option.value = learning.id;
            option.text = capitalizeOrDefault(learning.name_learning_result); // Capitalizar
            selectElement.appendChild(option);
        });
    }

    function viewEvaluationUpdate(response, assigEvaInfo) {
        blockCampos(true, true);
        let evaluationInfo = response.assigEvaluationInfo;
        let classroomId = response.assigEvaluationInfo[0].id_classroom_plan;
        let bodyEvaluation = $('#bodyEvaluation');
        bodyEvaluation.empty();

        if (evaluationInfo.length > 0) {
            evaluationInfo.forEach(function (evaluation) {
                var row = `
                    <tr>
                        <td>
                            ${capitalizeOrDefault(evaluation.evaluation.name_evaluation)}
                        </td>                               
                        <td>
                            ${evaluation.percentage_number}%
                        </td>
                        <td>
                            ${capitalizeOrDefault(evaluation.percentage.name_percentage)}
                        </td>
                        <td>
							<button type="button" title="" class="btn btn-link btn-simple-primary btn-lg"
                                id="evaluationBtnUpdate" data-id="${evaluation.id}">
								<i class="fa fa-edit"></i>
							</button>								
                            <button type="button" title="" class="btn btn-link btn-simple-danger" 
                                id="evaluationBtnDelete" data-id="${evaluation.id}">
                                <i class="fa fa-times"></i>
                            </button>
						</td>                    
                    </tr>
                `;
                bodyEvaluation.append(row);
            });

            document.querySelectorAll('#evaluationBtnUpdate').forEach(button => {
                button.addEventListener('click', function () {
                    const evaluationId = this.getAttribute('data-id');
                    if (Array.isArray(evaluationInfo)) {
                        const selectedContent = evaluationInfo.find(item => item.id === parseInt(evaluationId));
                        viewModalUpdateEvaluation(selectedContent, assigEvaInfo);
                    }
                });
            });

            document.querySelectorAll('#evaluationBtnDelete').forEach(button => {
                button.addEventListener('click', function () {
                    const evaluationDId = this.getAttribute('data-id');
                    deleteContent(classroomId, 1, evaluationDId, assigEvaInfo)
                });
            });

        } else {
            bodyEvaluation.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    function viewReferencesUpdate(response) {
        blockCampos(true, true);
        let referencesId = response.referencsInfo;
        let classroomId = response.referencsInfo[0].id_classroom_plan;

        let bodyReferences = $('#bodyReferences');
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
                        <td>
							<button type="button" class="btn btn-link btn-simple-primary btn-lg"
                                id="referenceBtnUpdate" data-id="${reference.id}">
								<i class="fa fa-edit"></i>
							</button>								
                            <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-simple-danger" 
                                id="referenceBtnDelete" data-id="${reference.id}">
                                <i class="fa fa-times"></i>
                            </button>
						</td>                     
                    </tr>
                `;
                bodyReferences.append(row);
            });

            document.querySelectorAll('#referenceBtnUpdate').forEach(button => {
                button.addEventListener('click', function () {
                    const referenceUId = this.getAttribute('data-id');
                    if (Array.isArray(referencesId)) {
                        const selectedContent = referencesId.find(item => item.id === parseInt(referenceUId));
                        viewModalUpdateReference(selectedContent);
                    }
                });
            });

            document.querySelectorAll('#referenceBtnDelete').forEach(button => {
                button.addEventListener('click', function () {
                    const referenceDId = this.getAttribute('data-id');
                    deleteContent(classroomId, 2, referenceDId, null)
                });
            });

        } else {
            bodyReferences.append('<tr><td colspan="6">No se encontraron.</td></tr>');
        }
    }

    function viewModalUpdateEvaluation(response, assigEvaInfo) {
        $('#modalUpdateEvaluation').modal('show');

        document.getElementById('namePercentage').innerText = capitalizeOrDefault(response.percentage.name_percentage);

        let evaluationId = response.evaluation.id;

        const selectElement = document.getElementById('selectUpdateEvaluation');
        selectElement.innerHTML = '';

        // Buscar y agregar la opción seleccionada al principio
        const selectedContent = assigEvaInfo.find(item => item.id === evaluationId) || null;
        if (selectedContent) {
            const selectedOption = document.createElement('option');
            selectedOption.value = selectedContent.id;
            selectedOption.text = capitalizeOrDefault(selectedContent.name_evaluation);
            selectedOption.selected = true; // Marcar como seleccionada
            selectElement.appendChild(selectedOption);
        } else {
            const selectedOption = document.createElement('option');
            selectedOption.value = response.evaluation.id;
            selectedOption.text = capitalizeOrDefault(response.evaluation.name_evaluation);
            selectedOption.selected = true; // Marcar como seleccionada
            selectedOption.disabled = true; // Deshabilitar la opción
            selectElement.appendChild(selectedOption);
        }

        // Agregar las demás opciones
        assigEvaInfo.forEach(function (evaluatio) {
            if (evaluatio.id !== evaluationId) { // Evitar duplicar la opción seleccionada
                const option = document.createElement('option');
                option.value = evaluatio.id;
                option.text = capitalizeOrDefault(evaluatio.name_evaluation);
                selectElement.appendChild(option);
            }
        });

        const inputPercentage = document.getElementById('inputPercentage')
        inputPercentage.value = response.percentage_number;
        inputPercentage.setAttribute('data-id', response.percentage.id);
        inputPercentage.setAttribute('data-val-id', response.id);
    }

    function viewModalUpdateReference(response) {
        $('#modalUpdateReferences').modal('show');
        document.getElementById('nameReference').innerText = capitalizeOrDefault(response.name_reference);
        const inputLink = document.getElementById('linksContent')
        inputLink.value = response.link_reference;
        inputLink.setAttribute('data-id', response.id);
    }

    function viewModalNewEvaluation(assigEvaInfo, percentageInfo) {
        const selectElement = document.getElementById('selectNewPercentage');
        selectElement.innerHTML = '<option disabled selected value="">Seleccione un porcentaje</option>';

        percentageInfo.forEach(function (porcentaje) {
            const option = document.createElement('option');
            option.value = porcentaje.id;
            option.text = capitalizeOrDefault(porcentaje.name_percentage);
            selectElement.appendChild(option);
        });

        const selectElement2 = document.getElementById('selectNewEvaluation');
        selectElement2.innerHTML = '<option disabled selected value="">Seleccione una evaluacion</option>';

        assigEvaInfo.forEach(function (evaluation) {
            const option = document.createElement('option');
            option.value = evaluation.id;
            option.text = capitalizeOrDefault(evaluation.name_evaluation);
            selectElement2.appendChild(option);
        });
        document.getElementById('inputNewPercentage').value = "";
    }

    // ACTIVATE
    function activateUpdate(programId, responseInfo) {
        // Cerrar el modal
        $('#modalActivateUpdate').modal('hide');

        document.getElementById('activateUpdate').textContent = 'Desactivar actualización';

        document.getElementById("btnSaveUpdate").classList.remove('d-none');

        searchData(programId, courseTypeId).then(response => {
            learningInfo = response.learningInfo;
            assigEvaInfo = response.evaluationInfo;
            percentageInfo = response.percentageInfo;
            viewEvaluationUpdate(responseInfo, assigEvaInfo)
            viewReferencesUpdate(responseInfo)
            viewModalNewEvaluation(assigEvaInfo, percentageInfo);
        }).catch(error => {
            console.error("Error en la solicitud AJAX:", error);
        });

        const selects = document.querySelectorAll(".unlockFields");

        selects.forEach(select => {
            select.disabled = false;
        });

        document.getElementById("btnNewEvaluation").classList.remove('d-none');
        document.getElementById("btnNewReference").classList.remove('d-none');
    }
    // DEACTIVATE
    function deactivateUpdate() {
        // Cerrar el modal
        $('#modalDeactivateUpdate').modal('hide');

        document.getElementById('activateUpdate').textContent = 'Activar actualización';

        document.getElementById("btnSaveUpdate").classList.add('d-none');

        location.reload();

    }

    // VALIDATIONS
    function ValidationUpdateEvaluation(assigEvaInfo) {
        const updateSelect = document.getElementById('selectUpdateEvaluation')
        const dataValueSelect = updateSelect.value;

        const updateInput = document.getElementById('inputPercentage')
        const dataValueInput = updateInput.value;
        const dataId = updateInput.dataset.id;
        const dataValId = updateInput.dataset.valId;

        if (dataValueSelect == '' || dataValueInput == '') {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'Asegurate de llenar completo el registro',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar',
            })
        } else {
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
                    saveUpdateEvaluation(dataValueSelect, dataValueInput, dataValId, assigEvaInfo)
                }
            });
        }
    }

    function ValidationUpdateReference() {
        const updateInput = document.getElementById('linksContent')
        const dataValue = updateInput.value;
        const dataId = updateInput.dataset.id;

        if (dataValue == '') {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'Asegurate de llenar completo el registro',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar',
            })
        } else {
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
                    saveUpdateReference(dataId, dataValue)
                }
            });
        }
    }

    function ValidationNewEvaluation(classroomId) {
        const newSelect1 = document.getElementById('selectNewPercentage');
        const dataValueSelec1 = newSelect1.value;

        const newSelect = document.getElementById('selectNewEvaluation');
        const dataValueSelec = newSelect.value;

        const newInput = document.getElementById('inputNewPercentage');
        const dataValueInput = newInput.value;

        if (dataValueSelec1 === '' || dataValueSelec === '' || newInput.value === '') {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'Asegúrate de llenar completo el registro',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        if (dataValueInput <= 0) {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'El porcentaje no puede ser menor a 0',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        if ((dataValueSelec1 == 1 || dataValueSelec1 == 2) && dataValueInput > 30) {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'El porcentaje no puede ser mayor a 30',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar'
            });
            return;
        } else if (dataValueSelec1 == 3 && dataValueInput > 40) {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'El porcentaje no puede ser mayor a 40',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        Swal.fire({
            title: 'Advertencia',
            icon: 'warning',
            text: '¿Estás seguro de que deseas crear?',
            showCancelButton: true,
            confirmButtonColor: '#1572E8',
            cancelButtonColor: '#F25961',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                saveCreateEvaluation(classroomId, dataValueSelec1, dataValueSelec, dataValueInput);
            }
        });
    }

    function ValidationNewReference(classroomId) {
        const newSelect = document.getElementById('selectNewReference');
        const dataValueSelec = newSelect.value;

        const newInput = document.getElementById('linksNewContent');
        const dataValueInput = newInput.value;

        if (dataValueSelec === '' || dataValueInput === '') {
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
            text: '¿Estás seguro de que deseas crear?',
            showCancelButton: true,
            confirmButtonColor: '#1572E8',
            cancelButtonColor: '#F25961',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                saveCreateReference(classroomId, dataValueSelec, dataValueInput);
            }
        });
    }

    function validationConfirmation() {

        const selectLearning = document.getElementById('selectLearning');
        const dataValueSelec = selectLearning.value;

        const textAreaDescriptionGeneral = document.getElementById('textAreaDescriptionGeneral');
        const textAreaValue = textAreaDescriptionGeneral.value;

        const textAreaValues = [];
        for (let i = 1; i <= 3; i++) {
            const textArea = document.getElementById(`textAreaDescriptionSpecific${i}`);
            const value = textArea.value;
            textAreaValues.push(value);
        }

        const textAreaValuesTopics = [];
        for (let i = 1; i <= 16; i++) {
            const textArea = document.getElementById(`textAreaTopic${i}`);
            const value = textArea.value;
            textAreaValuesTopics.push(value);
        }

        // Verificar si algún campo está vacío
        const allFields = [dataValueSelec, textAreaValue, ...textAreaValues, ...textAreaValuesTopics];
        const hasEmptyField = allFields.some(value => value.trim() === '');

        if (hasEmptyField) {
            Swal.fire({
                title: 'Advertencia',
                icon: 'warning',
                text: 'Asegúrate de llenar completo el registro',
                confirmButtonColor: '#1572E8',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        $('#modalConfirmation').modal('show');
    }

    // DELETE
    function deleteContent(classroomId, select, deleteId, assigEvaInfo) {
        $('#modalConfirmationDelete').modal('show');
        document.getElementById('confirm-delete').addEventListener('click', function () {
            $.ajax({
                url: '/view-classroom-plan/delet-content',
                method: 'DELETE',
                data: {
                    classroomId: classroomId,
                    select: select,
                    deleteId: deleteId,
                },
                success: function (response) {
                    if (response.check == true) {
                        $('#modalConfirmationDelete').modal('hide');
                        if(select == 1){
                            viewEvaluationUpdate(response, assigEvaInfo)
                        }else{
                            viewReferencesUpdate(response)
                        }
                    }
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

    // SAVE
    function saveContent(classroomId) {
        const selectLearning = document.getElementById('selectLearning');
        const dataValueSelec = selectLearning.value;

        const textAreaDescriptionGeneral = document.getElementById('textAreaDescriptionGeneral');
        const dataGenerlaId = textAreaDescriptionGeneral.getAttribute('data-id');
        const textAreaValue = textAreaDescriptionGeneral.value;

        const textAreaValuesSpecific = [];
        for (let i = 1; i <= 3; i++) {
            const textArea = document.getElementById(`textAreaDescriptionSpecific${i}`);
            const value = textArea.value;
            const dataId = textArea.getAttribute('data-id');
            textAreaValuesSpecific.push({ dataId, value });
        }

        const textAreaValuesTopics = [];
        for (let i = 1; i <= 16; i++) {
            const textArea = document.getElementById(`textAreaTopic${i}`);
            const value = textArea.value;
            const dataId = textArea.getAttribute('data-topics-id');
            textAreaValuesTopics.push({ dataId, value });
        }

        $.ajax({
            url: '/view-classroom-plan/save-content',
            method: 'PUT',
            data: {
                classroomId: classroomId,
                learning: dataValueSelec,
                dataGenerlaId: dataGenerlaId,
                GeneralContent: textAreaValue,
                specificObj: textAreaValuesSpecific,
                topicObj: textAreaValuesTopics,
            },
            success: function (response) {
                if (response.check == true) {
                    $('#modalConfirmation').modal('hide');
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
                            location.reload();
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

    function saveUpdateEvaluation(dataValueSelect, dataValueInput, dataValId, assigEvaInfo) {
        $.ajax({
            url: '/view-classroom-plan/save-evaluation',
            method: 'PUT',
            data: {
                dataValueSelect: dataValueSelect,
                dataValueInput: dataValueInput,
                dataValId: dataValId,
            },
            success: function (response) {
                if (response.check == true) {
                    $('#modalUpdateEvaluation').modal('hide');
                    viewEvaluationUpdate(response, assigEvaInfo)
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

    function saveUpdateReference(dataId, dataValue) {
        $.ajax({
            url: '/view-classroom-plan/save-reference',
            method: 'PUT',
            data: {
                dataId: dataId,
                dataValue: dataValue,
            },
            success: function (response) {
                if (response.check == true) {
                    $('#modalUpdateReferences').modal('hide');
                    viewReferencesUpdate(response);
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

    function saveCreateEvaluation(classroomId, percentageId, evaluationId, valuePercentage) {
        $.ajax({
            url: '/view-classroom-plan/create-evaluation',
            method: 'POST',
            data: {
                classroomId: classroomId,
                percentageId: percentageId,
                evaluationId: evaluationId,
                valuePercentage: valuePercentage,
            },
            success: function (response) {
                if (response.check == true) {
                    $('#modalNewEvaluation').modal('hide');
                    viewEvaluationUpdate(response, assigEvaInfo);
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

    function saveCreateReference(classroomId, nameReference, linkReference) {
        $.ajax({
            url: '/view-classroom-plan/create-reference',
            method: 'POST',
            data: {
                classroomId: classroomId,
                nameReference: nameReference,
                linkReference: linkReference,
            },
            success: function (response) {
                if (response.check == true) {
                    $('#modalNewReferences').modal('hide');
                    viewReferencesUpdate(response);
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

    function sendClassroom(classroomId) {
        $.ajax({
            url: '/view-classroom-plan/send-classroom',
            method: 'PUT',
            data: {
                classroomId: classroomId,
            },
            success: function (response) {
                if (response.check == true) {
                    $('#modalConfirmationSend').modal('hide');
                    document.getElementById('card-send').classList.add('d-none');
                    location.reload();
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

    document.getElementById('activateUpdate').addEventListener('click', function () {
        if (cont == true) {
            $('#modalActivateUpdate').modal('show');
        } else {
            $('#modalDeactivateUpdate').modal('show');
        }
    });

    document.getElementById('confirm-activate').addEventListener('click', function () {
        activateUpdate(programId, responseInfo);
        cont = false;
    });

    document.getElementById('confirm-desactivate').addEventListener('click', function () {
        deactivateUpdate()
        cont = true;
    });

    // SAVE
    document.getElementById('btnSaveUpdate').addEventListener('click', function () {
        validationConfirmation();
    });

    document.getElementById('confirm-save').addEventListener('click', function () {
        saveContent(classroomId);
    });

    // LEARNING
    document.getElementById('selectLearning').addEventListener('change', function () {
        const learningId = parseInt(this.value);

        // Busca en el arreglo learningInfo el objeto que tenga el ID seleccionado
        const selectedLearning = learningInfo.find(item => item.id === learningId);

        if (selectedLearning) {
            // Si encuentra el ID, coloca el valor de description_learning_result en el textarea
            document.getElementById('textAreaSelectLearning').value = selectedLearning.description_learning_result;
        } else {
            // Si no encuentra el ID, limpiar el textarea o hacer algo más
            document.getElementById('textAreaSelectLearning').value = '';
            console.log('Resultado de aprendizaje no encontrado');
        }
    });

    // EVALUATION UPDATE
    document.getElementById('confirm-update-evaluation').addEventListener('click', function () {
        ValidationUpdateEvaluation(assigEvaInfo)
    });

    // EVALUATION NEW
    document.getElementById('btnNewEvaluation').addEventListener('click', function () {
        $('#modalNewEvaluation').modal('show');
        searchData(programId, courseTypeId).then(response => {
            learningInfo = response.learningInfo;
            assigEvaInfo = response.evaluationInfo;
            percentageInfo = response.percentageInfo;
            viewModalNewEvaluation(assigEvaInfo, percentageInfo);
        }).catch(error => {
            console.error("Error en la solicitud AJAX:", error);
        });
    });

    document.getElementById('selectNewPercentage').addEventListener('change', function () {
        document.getElementById('inputNewPercentage').value = "";
    });

    document.getElementById('confirm-new-evaluation').addEventListener('click', function () {
        ValidationNewEvaluation(classroomId);
    });

    // REFERENCE UPDATE
    document.getElementById('confirm-update-reference').addEventListener('click', function () {
        ValidationUpdateReference()
    });

    document.getElementById('btnNewReference').addEventListener('click', function () {
        $('#modalNewReferences').modal('show');
        const selectNewReference = document.getElementById('selectNewReference');
        selectNewReference.selectedIndex = 0;
        document.getElementById('linksNewContent').value = '';
    });

    document.getElementById('confirm-new-reference').addEventListener('click', function () {
        ValidationNewReference(classroomId);
    });

    document.getElementById('btnSendClassroom').addEventListener('click', function () {
        $('#modalConfirmationSend').modal('show');
    });

    document.getElementById('confirm-send').addEventListener('click', function () {
        sendClassroom(classroomId);
    });

});
