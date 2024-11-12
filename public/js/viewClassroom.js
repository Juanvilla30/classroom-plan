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
let programId;
let topicInfo;
// UPDATE
let selectLearningId;
let contentCompetence;
let learninResult;
let cont = true;

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * LLAMADOS
        *
    */
    searchClassroom(classroomId).then(response => {
        topicInfo = response;
    }).catch(error => {
        console.error("Error en la solicitud AJAX:", error);
    });;

    /*
        *
        * FUNCIONES
        *
    */

    // Función para capitalizar el primer carácter de un texto
    function capitalizeOrDefault(value) {
        if (value && value.trim() !== '') {
            return value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
        }
        return 'Sin asignación';
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
                    let learningInfo = response.classroomInfo.learning_result;
                    let generalInfo = response.classroomInfo.general_objective;
                    let specificInfo = response.specificInfo;
                    let topicInfo = response.topicInfo;
                    let assignInfo = response.assigEvaluationInfo;
                    let referenceInfo = response.referencsInfo;
                    programId = response.classroomInfo.learning_result.competence.profile_egres.id_program
                    educationId = response.classroomInfo.relations.program?.id_education_level || null;
                    console.log(programId)
                    if (educationId == null) {
                        viewInfoCampoComun(response);
                    } else if (educationId == 1) {
                        viewInfoPensum(response);
                    } else if (educationId == 2) {
                        viewInfoSpecializations(response);
                    }
                    viewLearning(learningInfo);
                    viewObjetives(generalInfo, specificInfo);
                    viewTopics(topicInfo);
                    resolve(topicInfo);
                    viewPercentage(assignInfo);
                    viewReferences(referenceInfo);
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

    function searchData(programId) {
        if (programId !== '') {
            $.ajax({
                url: '/view-classroom-plan/search-data',
                method: 'POST',
                data: {
                    programId: programId,
                },
                success: function (response) {
                    console.log(response);
                    learninResult = response.learningResult
                    contentCompetence = response.competences
                    updateLearning(learninResult);
                },
                error: function (xhr, status, error) {
                    console.error('Error al eliminar el grupo:', xhr);
                    console.error('Estado:', status);
                    console.error('Error:', error);
                    console.error('Respuesta del servidor:', xhr.responseText);

                }
            });
        } else {
            console.log('PROGRAMA-NO-ENCONTRADO');
        }
    }

    function uploadData(selectLearningId, learningResults) {
        const selectedId = Number(selectLearningId);

        learningResults.forEach((learningResult) => {
            if (selectedId === learningResult.id) {
                document.getElementById('textAreaDescriptionRa').value = capitalizeOrDefault(learningResult.description_learning_result);
            }
        });
    }

    // VIEWS
    function viewInfoCampoComun(response) {
        let infoClassroom = response.classroomInfo;
        console.log(infoClassroom)

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
        console.log(infoProgram)

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
        console.log(infoProgram)
        let infoContent;
        infoContent = ` 
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Facultad:</label>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Programa:</label>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Semestre:</label>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Codigo de curso:</label>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Curso:</label>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Nivel de educación:</label>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Creditos:</label>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Tipo de curso:</label>
                        <p></p>
                    </div>
                </div>
        `;
        document.getElementById("viewInfoSpecializations").innerHTML = infoContent;
    }

    function viewLearning(learningInfo) {
        let learningContent = `
            <div class="form-group" id="textAreaCompetence">
                <label for="exampleFormControlTextarea1">${capitalizeOrDefault(learningInfo.competence.name_competence)}:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>${capitalizeOrDefault(learningInfo.competence.description_competence)}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">${capitalizeOrDefault(learningInfo.name_learning_result)}:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>${capitalizeOrDefault(learningInfo.description_learning_result)}</textarea>
            </div>
        `;

        document.getElementById("fromProfileInfo").innerHTML = learningContent;

    }

    function viewObjetives(generalInfo, specificInfo) {

        let objetivesContent = `
            <div class="form-group">
                <label for="exampleFormControlTextarea1">${capitalizeOrDefault(generalInfo.name_general_objective)}:</label>
                <textarea class="form-control" data-general-id="${generalInfo.id}" id="textAreaGeneral" rows="5" disabled>${capitalizeOrDefault(generalInfo.description_general_objective)}</textarea>
            </div>
            <div class="row">
        `;

        if (specificInfo.length > 0) {
            specificInfo.forEach((specific, index) => {
                const i = index + 1;
                objetivesContent += `
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="textAreaspecific${i}">${capitalizeOrDefault(specific.name_specific_objective)}:</label>
                            <textarea class="form-control" data-specific-id="${specific.id}" id="textAreaspecific${i}" rows="8" disabled>${capitalizeOrDefault(specific.description_specific_objective)}</textarea>
                        </div>
                    </div>
                `;
            });

            objetivesContent += `</div>`;
            document.getElementById("fromObjetives").innerHTML = objetivesContent;

        } else {

            document.getElementById("fromObjetives").innerHTML = '<h3>No se encontraron resultados.</h3>';

        }
    }

    function viewTopics(topicInfo) {
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

    function viewPercentage(response) {
        const htmlContent = `
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group text-center">
                        <label>PORCENTAJE 30%</label>
                        <p id="percentage1"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group text-center">
                        <label>PORCENTAJE 30%</label>
                        <p id="percentage2"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group text-center">
                        <label>PORCENTAJE 40%</label>
                        <p id="percentage3"></p>
                    </div>
                </div>
            </div>
        `;
        document.getElementById("fromEvaluation").innerHTML = htmlContent;

        let evaluations1 = [];
        let evaluations2 = [];
        let evaluations3 = [];

        if (response.length > 0) {
            response.forEach(function (resp) {
                const idPercentage = resp.id_percentage;
                const evaluationName = resp.evaluation && resp.evaluation.name_evaluation
                    ? capitalizeOrDefault(resp.evaluation.name_evaluation)
                    : 'Nombre de evaluación no disponible';

                if (idPercentage === 1) {
                    evaluations1.push(evaluationName);
                } else if (idPercentage === 2) {
                    evaluations2.push(evaluationName);
                } else if (idPercentage === 3) {
                    evaluations3.push(evaluationName);
                }
            });

            document.getElementById('percentage1').textContent = evaluations1.join(', ') || 'Sin evaluaciones';
            document.getElementById('percentage2').textContent = evaluations2.join(', ') || 'Sin evaluaciones';
            document.getElementById('percentage3').textContent = evaluations3.join(', ') || 'Sin evaluaciones';
        } else {
            document.getElementById('percentage1').textContent = 'No se encontraron resultados.';
            document.getElementById('percentage2').textContent = 'No se encontraron resultados.';
            document.getElementById('percentage3').textContent = 'No se encontraron resultados.';
        }
    }

    function viewReferences(referenceInfo) {

        let referenceContent = `
            <div class="table-responsive" id="tableReferent">
                <table class="table table-head-bg-primary">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Referencias</th>
                            <th scope="col">Links</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        if (referenceInfo.length > 0) {
            referenceInfo.forEach((reference, index) => {
                referenceContent += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${capitalizeOrDefault(reference.name_reference)}</td>
                        <td>
                            ${reference.link_reference === "No se registro contenido"
                        ? reference.link_reference
                        : `<a href="${reference.link_reference}" target="_blank">${reference.link_reference}</a>`
                    }
                        </td>
                    </tr>
                `;
            });

            referenceContent += `
                        </tbody>
                    </table>
                </div>
            `;

            document.getElementById("fromReference").innerHTML = referenceContent;

        } else {

            document.getElementById("fromReference").innerHTML = '<h3>No se encontraron resultados.</h3>';

        }
    }

    // VALIDATE
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

    // UPDATE
    function updateLearning(response) {
        let learningContent = `
            <div class="form-group">
                <label for="pillSelect">Selección de resultado de aprendizaje</label>
                    <select class="form-control input-pill" id="selectLearning">
                        <option disabled selected value="">Seleccione un nuevo resultado de aprendizaje</option>
                            
        `;
        if (response.length > 0) {
            response.forEach((learning, index) => {
                const i = index + 1;
                learningContent += `
                    <option value="${learning.id}">${capitalizeOrDefault(learning.name_learning_result)}</option>
                `;
            });

            learningContent += `
                    </select>
                </div>`;

            learningContent += `
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Descripción:</label>
                        <textarea class="form-control" id="textAreaDescriptionRa" rows="5" disabled></textarea>
                    </div>
            `;
            document.getElementById("fromProfileUpdate").innerHTML = learningContent;

            document.getElementById('selectLearning').addEventListener('change', function () {
                selectLearningId = this.value;
                uploadData(selectLearningId, learninResult);
            });

        } else {

            document.getElementById("fromProfileUpdate").innerHTML = '<h3>No se encontraron resultados.</h3>';

        }
    }

    function activateUpdate(programId) {
        // Cerrar el modal
        $('#modalActivateUpdate').modal('hide');

        document.getElementById('activateUpdate').textContent = 'Desactivar actualización';

        searchData(programId);
        document.getElementById("fromProfileUpdate").classList.remove('d-none');


        document.getElementById('textAreaCompetence').classList.add('d-none');

        document.getElementById(`textAreaGeneral`).removeAttribute('disabled');

        for (let i = 1; i <= 3; i++) {
            document.getElementById(`textAreaspecific${i}`).removeAttribute('disabled');
        }

        for (let i = 1; i <= 16; i++) {
            document.getElementById(`textAreaTopic${i}`).removeAttribute('disabled');
        }

        document.querySelector('.saveTemp').classList.remove('d-none');

    }

    function deactivateUpdate() {
        // Cerrar el modal
        $('#modalDeactivateUpdate').modal('hide');

        document.getElementById('activateUpdate').textContent = 'Activar actualización';

        searchClassroom(classroomId);

        document.getElementById("fromProfileUpdate").classList.add('d-none');

        document.getElementById(`textAreaGeneral`).setAttribute('disabled', true);

        for (let i = 1; i <= 3; i++) {
            document.getElementById(`textAreaspecific${i}`).setAttribute('disabled', true);
        }

        for (let i = 1; i <= 16; i++) {
            document.getElementById(`textAreaTopic${i}`).setAttribute('disabled', true);
        }

        document.querySelector('.saveTemp').classList.add('d-none');

    }

    // CAPTURA
    function captureData() {
        const generalData = [];
        const specificData = [];
        const topicsData = [];

        const fieldsToValidate = ['textAreaGeneral']; // Añade el ID del campo general

        for (let i = 1; i <= 3; i++) {
            fieldsToValidate.push(`textAreaspecific${i}`);
        }

        for (let i = 1; i <= 16; i++) {
            fieldsToValidate.push(`textAreaTopic${i}`);
        }

        validate(fieldsToValidate, 'Por favor, completa todos los campos antes de continuar.');

        const textAreaGeneral = document.getElementById(`textAreaGeneral`);
        if (textAreaGeneral) {
            const generalcId = textAreaGeneral.getAttribute('data-general-id');
            const generalValue = textAreaGeneral.value;

            generalData.push({
                id: generalcId,
                description: generalValue
            });
        }

        for (let i = 1; i <= 3; i++) {
            const textAreaSpecific = document.getElementById(`textAreaspecific${i}`);
            if (textAreaSpecific) {
                const specificId = textAreaSpecific.getAttribute('data-specific-id');
                const specificValue = textAreaSpecific.value;

                specificData.push({
                    id: specificId,
                    description: specificValue
                });
            }
        }

        for (let i = 1; i <= 16; i++) {
            const textArea = document.getElementById(`textAreaTopic${i}`);
            if (textArea) {
                const topicId = textArea.getAttribute('data-topics-id');
                const topicValue = textArea.value;

                topicsData.push({
                    id: topicId,
                    description: topicValue
                });
            }
        }

        console.log(generalData); // Muestra los datos en la consola
        console.log(specificData); // Muestra los datos en la consola
        console.log(topicsData); // Muestra los datos en la consola
    }

    function confirmButton() {

        // Cerrar el modal
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
        activateUpdate(programId);
        cont = false;
    });

    document.getElementById('confirm-desactivate').addEventListener('click', function () {
        deactivateUpdate()
        cont = true;
    });

    document.querySelector('.saveTemp').addEventListener('click', function () {
        captureData();
    });

    document.getElementById('confirm-button').addEventListener('click', function () {
        confirmButton();
    });

});
