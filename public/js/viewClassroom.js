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

let classroomInfo;

let cont = true;

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * LLAMADOS
        *
    */
    searchClassroom(classroomId).then(response => {
        classroomInfo = response;
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
    function blockCampos(showField) {
        if (showField) {
            $('#tableReferences th:nth-child(4), #tableReferences td:nth-child(4)').css('display', '');
        } else {
            $('#tableReferences th:nth-child(4), #tableReferences td:nth-child(4)').css('display', 'none');
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
                    console.log(response)
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

    // VIEWS
    function viewBtnUpdate(response) {
        let contentState = response.classroomInfo.id_state

        if (contentState == 1) {
            document.getElementById("btnActivateUpdate").classList.remove('d-none')
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
                                <textarea class="form-control" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeOrDefault(topic.description_topic)}</textarea>
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
                                <textarea class="form-control" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeOrDefault(topic.description_topic)}</textarea>
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
                                <textarea class="form-control" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeOrDefault(topic.description_topic)}</textarea>
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

        let evaluations1 = [];
        let evaluations2 = [];
        let evaluations3 = [];

        if (response.assigEvaluationInfo.length > 0) {
            response.assigEvaluationInfo.forEach(function (resp) {
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

    function viewReferences(response) {
        blockCampos(false);
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

    // ACTIVATE
    function activateUpdate() {
        // Cerrar el modal
        $('#modalActivateUpdate').modal('hide');

        document.getElementById('activateUpdate').textContent = 'Desactivar actualización';

        document.getElementById("btnSaveUpdate").classList.remove('d-none');
    }
    // DEACTIVATE
    function deactivateUpdate() {
        // Cerrar el modal
        $('#modalDeactivateUpdate').modal('hide');

        document.getElementById('activateUpdate').textContent = 'Activar actualización';

        document.getElementById("btnSaveUpdate").classList.add('d-none');

        //location.reload();

    }

    // VALIDATIONS
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

    //CONFIRM
    function confirmationValidation() {
        $('#modalConfirmation').modal('show');
    }

    function confirmationSave() {
        $('#modalConfirmation').modal('hide');
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
        activateUpdate();
        cont = false;
    });

    document.getElementById('confirm-desactivate').addEventListener('click', function () {
        deactivateUpdate()
        cont = true;
    });

    document.getElementById('btnSaveUpdate').addEventListener('click', function () {
        confirmationValidation();
    });

    document.getElementById('confirm-save').addEventListener('click', function () {
        confirmationSave();
    });

});
