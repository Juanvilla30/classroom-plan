document.addEventListener("DOMContentLoaded", function () {

    // Variables
    var faculty;
    var program;

    var selectFaculty = document.getElementById("pillSelectFaculty");
    var selectProgram = document.getElementById("pillSelectProgram");

    selectFaculty.addEventListener("change", function () {

        faculty = this.options[this.selectedIndex].value;
        console.log('faculty: ', faculty)
    });

    selectProgram.addEventListener("change", function () {

        program = this.options[this.selectedIndex].value;
        console.log('program: ', program)
    });

});

document.addEventListener('DOMContentLoaded', function () {
    // Arreglo con los IDs de las cards
    const cards = ['card-1', 'card-2', 'card-3'];

    // Inicialmente mostrar la primera card
    let currentCardIndex = 0;
    document.getElementById(cards[currentCardIndex]).style.display = 'block';

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
            // Recargar la página cuando llegues a la última card
            location.reload();
        }
    }

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirm-button').addEventListener('click', function () {
        // Cambiar a la siguiente card
        showNextCard();

        // Capturando el contenido del textarea

        //Perfil de egreso
        var contentProfile = document.getElementById('textAreaProfile').value;

        //Competencias
        var contentCompetitionOne = document.getElementById('textAreaCompetitionOne').value;
        var contentCompetitionTwo = document.getElementById('textAreaCompetitionTwo').value;

        //Resultados de aprendizaje
        var contentRaOne = document.getElementById('textAreaRaOne').value;
        var contentRaTwo = document.getElementById('textAreaRaTwo').value;
        var contentRaThree = document.getElementById('textAreaRaThree').value;
        var contentRaFour = document.getElementById('textAreaRaFour').value;

        // Mostrando solo los que no están vacíos
        if (contentProfile.trim() !== "") {
            console.log("Content Profile:", contentProfile);
        }
        if (contentCompetitionOne.trim() !== "") {
            console.log("Content Competition One:", contentCompetitionOne);
        }
        if (contentCompetitionTwo.trim() !== "") {
            console.log("Content Competition Two:", contentCompetitionTwo);
        }
        if (contentRaOne.trim() !== "") {
            console.log("Content RA One:", contentRaOne);
        }
        if (contentRaTwo.trim() !== "") {
            console.log("Content RA Two:", contentRaTwo);
        }
        if (contentRaThree.trim() !== "") {
            console.log("Content RA Three:", contentRaThree);
        }
        if (contentRaFour.trim() !== "") {
            console.log("Content RA Four:", contentRaFour);
        }

        // Cerrar el modal
        $('#modalConfirmation').modal('hide');
    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyOne').addEventListener('click', function () {

        // Capturar el contenido del textarea
        var contentProfile = document.getElementById('textAreaProfile').value;

        if (contentProfile.trim() === "") {
            // Mostrar alerta si está vacío
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'El campo de perfil de egreso no puede estar vacío.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Si no está vacío, mostrar el modal
            $('#modalConfirmation').modal('show');
        }

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyTwo').addEventListener('click', function () {

        //Competencias
        var contentCompetitionOne = document.getElementById('textAreaCompetitionOne').value;
        var contentCompetitionTwo = document.getElementById('textAreaCompetitionTwo').value;

        if (contentCompetitionOne.trim() === "" || contentCompetitionTwo.trim() === "") {
            // Mostrar alerta si está vacío
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Los campos de competencias no pueden estar vacíos.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Si no está vacío, mostrar el modal
            $('#modalConfirmation').modal('show');
        }

    });

    // Escuchar el click en el botón de confirmación del modal
    document.getElementById('confirmationEmptyThree').addEventListener('click', function () {

        //Resultados de aprendizaje
        var contentRaOne = document.getElementById('textAreaRaOne').value;
        var contentRaTwo = document.getElementById('textAreaRaTwo').value;
        var contentRaThree = document.getElementById('textAreaRaThree').value;
        var contentRaFour = document.getElementById('textAreaRaFour').value;

        if (contentRaOne.trim() === "" || contentRaTwo.trim() === ""
            && contentRaThree.trim() === "" || contentRaFour.trim() === "") {
            // Mostrar alerta si está vacío
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Los campo de resultados de aprendizaje no pueden estar vacíos.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            });
        } else {
            // Si no está vacío, mostrar el modal
            $('#modalConfirmation').modal('show');
        }

    });

});
