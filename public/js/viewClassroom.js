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

// UPDATE
let selectLearningId;
let contentCompetence;
let learninResult;
let cont = true;

document.addEventListener('DOMContentLoaded', function () {

    /*
        *
        * ARREGLOS
        *
    */
    searchClassroom(classroomId);

    /*
        *
        * FUNCIONES
        *
    */

    // Función para capitalizar el primer carácter de un texto
    function capitalizeText(text) {
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

    function searchClassroom(classroomId) {
        $.ajax({
            url: '/view-classroom-plan/info-classroom-plans', // URL 
            method: 'POST', // Método de la solicitud: POST
            data: {
                classroomId: classroomId,
            },
            // Función que se ejecuta en caso de éxito en la solicitud
            success: function (response) {
                let learningInfo = response.classroomInfo.learning_result;
                let generalInfo = response.classroomInfo.general_objective;
                let specificInfo = response.specificInfo;
                let topicInfo = response.topicInfo;
                let assignInfo = response.assigEvaluationInfo;
                let referenceInfo = response.referencsInfo;
                programId = response.classroomInfo.learning_result.competence.profile_egres.id_program
                viewLearning(learningInfo);
                viewObjetives(generalInfo, specificInfo);
                viewTopics(topicInfo);
                viewPercentage(assignInfo);
                viewReferences(referenceInfo);

            },
            // Función que se ejecuta en caso de error en la solicitud
            error: function (xhr, status, error) {
                // Imprimir mensajes de error en la consola
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function searchClassroom(classroomId) {
        $.ajax({
            url: '/view-classroom-plan/info-classroom-plans', // URL 
            method: 'POST', // Método de la solicitud: POST
            data: {
                classroomId: classroomId,
            },
            // Función que se ejecuta en caso de éxito en la solicitud
            success: function (response) {
                let learningInfo = response.classroomInfo.learning_result;
                let generalInfo = response.classroomInfo.general_objective;
                let specificInfo = response.specificInfo;
                let topicInfo = response.topicInfo;
                let assignInfo = response.assigEvaluationInfo;
                let referenceInfo = response.referencsInfo;
                programId = response.classroomInfo.learning_result.competence.profile_egres.id_program
                viewLearning(learningInfo);
                viewObjetives(generalInfo, specificInfo);
                viewTopics(topicInfo);
                viewPercentage(assignInfo);
                viewReferences(referenceInfo);

            },
            // Función que se ejecuta en caso de error en la solicitud
            error: function (xhr, status, error) {
                // Imprimir mensajes de error en la consola
                console.error('Error al eliminar el grupo:', xhr);
                console.error('Estado:', status);
                console.error('Error:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    }

    function searchData(programId) {
        if (programId !== '') {
            $.ajax({
                url: '/view-classroom-plan/search-data', // URL 
                method: 'POST', // Método de la solicitud: POST
                data: {
                    programId: programId,
                },
                // Función que se ejecuta en caso de éxito en la solicitud
                success: function (response) {
                    console.log(response);
                    learninResult = response.learningResult
                    contentCompetence = response.competences
                    updateLearning(learninResult);
                },
                // Función que se ejecuta en caso de error en la solicitud
                error: function (xhr, status, error) {
                    // Imprimir mensajes de error en la consola
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
        // Convierte selectLearningId a un número si es un string
        const selectedId = Number(selectLearningId);

        // Recorre el arreglo para encontrar y asignar la descripción
        learningResults.forEach((learningResult) => {
            if (selectedId === learningResult.id) {
                document.getElementById('textAreaDescriptionRa').value = capitalizeText(learningResult.description_learning_result);
            }
        });
    }

    // VIEWS
    function viewLearning(learningInfo) {
        let learningContent = `
            <div class="form-group" id="textAreaCompetence">
                <label for="exampleFormControlTextarea1">${capitalizeText(learningInfo.competence.name_competence)}:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>${capitalizeText(learningInfo.competence.description_competence)}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">${capitalizeText(learningInfo.name_learning_result)}:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" disabled>${capitalizeText(learningInfo.description_learning_result)}</textarea>
            </div>
        `;

        document.getElementById("fromProfileInfo").innerHTML = learningContent;

    }

    function viewObjetives(generalInfo, specificInfo) {

        let objetivesContent = `
            <div class="form-group">
                <label for="exampleFormControlTextarea1">${capitalizeText(generalInfo.name_general_objective)}:</label>
                <textarea class="form-control" data-general-id="${generalInfo.id}" id="textAreaGeneral" rows="5" disabled>${capitalizeText(generalInfo.description_general_objective)}</textarea>
            </div>
            <div class="row">
        `;

        // Verificar si se encontraron cursos en la respuesta
        if (specificInfo.length > 0) {
            specificInfo.forEach((specific, index) => {
                const i = index + 1;
                objetivesContent += `
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="textAreaspecific${i}">${capitalizeText(specific.name_specific_objective)}:</label>
                            <textarea class="form-control" data-specific-id="${specific.id}" id="textAreaspecific${i}" rows="8" disabled>${capitalizeText(specific.description_specific_objective)}</textarea>
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
        // Verificar si se encontraron cursos en la respuesta
        if (topicInfo.length > 0) {
            let topicsContent1 = '<div class="row">';

            // Limitamos el bucle a 5 elementos
            topicInfo.slice(0, 5).forEach((topic, index) => {
                const i = index + 1;
                topicsContent1 += `
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="textAreaTopic${i}">Tema semana ${i}:</label>
                            <textarea class="form-control" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeText(topic.description_topic)}</textarea>
                        </div>
                    </div>
                `;
            });

            topicsContent1 += '</div>';
            document.getElementById("fromTopicsOne").innerHTML = topicsContent1;

            let topicsContent2 = '<div class="row">';

            // Limitamos el bucle a 5 elementos
            topicInfo.slice(5, 10).forEach((topic, index) => {
                const i = index + 6;
                topicsContent2 += `
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="textAreaTopic${i}">Tema semana ${i}:</label>
                            <textarea class="form-control" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeText(topic.description_topic)}</textarea>
                        </div>
                    </div>
                `;
            });

            topicsContent2 += '</div>';
            document.getElementById("fromTopicsTwo").innerHTML = topicsContent2;

            let topicsContent3 = '<div class="row">';

            // Limitamos el bucle a 5 elementos
            topicInfo.slice(10, 17).forEach((topic, index) => {
                const i = index + 11;
                topicsContent3 += `
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="textAreaTopic${i}">Tema semana ${i}:</label>
                            <textarea class="form-control" data-topics-id="${topic.id}" id="textAreaTopic${i}" rows="8" disabled>${capitalizeText(topic.description_topic)}</textarea>
                        </div>
                    </div>
                `;
            });

            topicsContent3 += '</div>';
            document.getElementById("fromTopicsThree").innerHTML = topicsContent3;

        } else {

            document.getElementById("fromTopicsOne").innerHTML = '<h3>No se encontraron resultados.</h3>';
            document.getElementById("fromTopicsTwo").innerHTML = '<h3>No se encontraron resultados.</h3>';
            document.getElementById("fromTopicsThree").innerHTML = '<h3>No se encontraron resultados.</h3>';

        }
    }

    function viewPercentage(response) {
        // Inserta la estructura HTML en el elemento with ID "fromEvaluation"
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

        // Inicializa los arreglos para acumular los nombres de evaluación
        let evaluations1 = [];
        let evaluations2 = [];
        let evaluations3 = [];

        // Procesa la respuesta
        if (response.length > 0) {
            response.forEach(function (resp) {
                const idPercentage = resp.id_percentage;
                const evaluationName = resp.evaluation && resp.evaluation.name_evaluation
                    ? capitalizeText(resp.evaluation.name_evaluation)
                    : 'Nombre de evaluación no disponible';

                if (idPercentage === 1) {
                    evaluations1.push(evaluationName);
                } else if (idPercentage === 2) {
                    evaluations2.push(evaluationName);
                } else if (idPercentage === 3) {
                    evaluations3.push(evaluationName);
                }
            });

            // Actualiza el contenido de los elementos con los nombres acumulados de cada evaluación
            document.getElementById('percentage1').textContent = evaluations1.join(', ') || 'Sin evaluaciones';
            document.getElementById('percentage2').textContent = evaluations2.join(', ') || 'Sin evaluaciones';
            document.getElementById('percentage3').textContent = evaluations3.join(', ') || 'Sin evaluaciones';
        } else {
            // Si no hay resultados, muestra un mensaje de "No se encontraron resultados"
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
                        <td>${capitalizeText(reference.name_reference)}</td>
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
    function validate(){
        
    }

    // UPDATE
    function updateLearning(response) {
        let learningContent = `
            <div class="form-group">
                <label for="pillSelect">Selección de resultado de aprendizaje</label>
                    <select class="form-control input-pill" id="selectLearning">
                        <option disabled selected value="">Seleccione un nuevo resultado de aprendizaje</option>
                            
        `;
        // Verificar si se encontraron cursos en la respuesta
        if (response.length > 0) {
            response.forEach((learning, index) => {
                const i = index + 1;
                learningContent += `
                    <option value="${learning.id}">${capitalizeText(learning.name_learning_result)}</option>
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
                console.log('CORRECTO')
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

        //------------------------------------------------------------------------------------------------------------------------------------
        const textAreaGeneral = document.getElementById(`textAreaGeneral`);
        const generalcId = textAreaGeneral.getAttribute('data-general-id');
        const generalValue = textAreaGeneral.value;

        generalData.push({
            id: generalcId,
            description: generalValue
        });

        //------------------------------------------------------------------------------------------------------------------------------------
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

        //------------------------------------------------------------------------------------------------------------------------------------
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

        //------------------------------------------------------------------------------------------------------------------------------------
        console.log(generalData); // Muestra los datos en la consola
        console.log(specificData); // Muestra los datos en la consola
        console.log(topicsData); // Muestra los datos en la consola

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

});
