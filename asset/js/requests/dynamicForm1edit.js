/* Función de Validación de la Sección 1 */

function validateSection1() {
    // Selecciona los elementos del DOM necesarios para la validación
    const numTuristaInput = document.getElementById('numTurista');
    const numChildrenInput = document.getElementById('numChildren');
    const includeUserInputs = document.querySelectorAll('input[name="includeUser"]');
    const includeMinorInputs = document.querySelectorAll('input[name="includeMinor"]');
    const packageSelect = document.getElementById('idPackages');
    const vacantInput = document.getElementById('vacant');
    const nextSectionButton = document.getElementById('nextSectionButton');
    const generateFormButton = document.getElementById('generateFormButton');
    const errorMessagenumChildren = document.getElementById('errorMessagenumChildren');

    // Función para realizar la validación de los campos
    const validateInputs = () => {
        const numTurista = parseInt(numTuristaInput.value, 10) || 0; // Convertir a número entero o establecer a cero si es NaN
        const numChildren = parseInt(numChildrenInput.value || 0, 10);
        const vacant = parseInt(vacantInput.value, 10);
        const includeUserYes = document.getElementById('user_yes').checked || document.getElementById('user_no').checked;
        const includeMinorYes = document.getElementById('minor_yes').checked || document.getElementById('minor_no').checked;
        const packageSelected = packageSelect.value !== "";
        
        // Habilitar/deshabilitar el campo de número de niños según si se incluye menores
        if (includeMinorYes) {
            numChildrenInput.disabled = false;
        } else {
            numChildrenInput.disabled = true;
            numChildrenInput.value = 0; // Establecer el valor de niños a 0 si no se incluyen menores
        }
        // Validación adicional cuando hay solo un turista
        if (numTurista == 1) {
            includeMinorInputs.forEach(input => input.disabled = true);
            numChildrenInput.disabled = true;
            numChildrenInput.value = 0; // Establecer el valor de niños a 0 si solo hay un turista
            document.getElementById('minor_yes').checked = false;
            document.getElementById('minor_no').checked = true;
            errorMessagenumChildren.textContent = 'No puede seleccionar llevar niños si hay solo un pasajero.';
            alertMessageDisappear( errorMessagenumChildren);
        } else if (numChildren >= numTurista || numChildren < 0) {
            errorMessagenumChildren.textContent = 'La cantidad de niños debe ser menor a la cantidad de cupos y mayor a 0.';
            alertMessageDisappear( errorMessagenumChildren);
        } else {
            errorMessagenumChildren.textContent = '';
            includeMinorInputs.forEach(input => input.disabled = false);
            numChildrenInput.disabled = false;
        }

        // Verificar si se deben activar los botones
        const allValid = numTurista && includeUserYes && packageSelected && (includeMinorYes) && (numChildren >= 0 && numChildren < numTurista);

        // Activar o desactivar los botones según la validez de los datos
        generateFormButton.disabled = !allValid;
        generateFormButton.style.opacity = allValid ? '1' : '0.5';
        generateFormButton.style.cursor = allValid ? 'pointer' : 'not-allowed';
        generateFormButton.classList.add('highlight'); 
        setTimeout(() => { generateFormButton.classList.remove('highlight'); }, 1500);

        nextSectionButton.disabled = !allValid;
        nextSectionButton.style.opacity = allValid ? '1' : '0.5';
        nextSectionButton.style.cursor = allValid ? 'pointer' : 'not-allowed';
        nextSectionButton.classList.add('highlight'); 
        setTimeout(() => { nextSectionButton.classList.remove('highlight'); }, 1500);
       
        

        // Verificar si no se llevan niños y actualizar las funciones correspondientes
        if (document.getElementById('minor_no').checked) {
            checkSeatsAvailable();
            checkNextButtonInSection2();
        }
    };

    // Agregar event listeners para validar los campos cada vez que cambien
    numTuristaInput.addEventListener('input', validateInputs);
    numChildrenInput.addEventListener('input', validateInputs);
    document.getElementById('user_yes').addEventListener('input', validateInputs);
    document.getElementById('user_no').addEventListener('input', validateInputs);
    document.getElementById('idPackages').addEventListener('input', validateInputs);
    document.getElementById('minor_yes').addEventListener('input', validateInputs);
    document.getElementById('minor_no').addEventListener('input', validateInputs);
}



/* Funciones de Visualización */
function showDetails() {
    // Ocultar todos los detalles del paquete
    const allDetails = document.querySelectorAll('.packageDetail');
    allDetails.forEach(detail => {
        detail.style.display = 'none';
    });

    // Obtener el valor del paquete seleccionado
    const selectedPackageId = document.getElementById('idPackages').value;
    if (selectedPackageId && selectedPackageId !== "0") {
        const selectedDetail = document.getElementById(`packageDetail${selectedPackageId}`);
        if (selectedDetail) {
            selectedDetail.style.display = 'block';
        }
    }
}

function toggleNumChildrenInput() {
    // Verificar si la opción "SI" está seleccionada para incluir menores
    const includeMinorYes = document.getElementById('minor_yes').checked;
    const numChildrenContainer = document.getElementById('numChildrenContainer');

    // Mostrar u ocultar el campo para el número de niños según la opción seleccionada
    if (includeMinorYes) {
        numChildrenContainer.style.display = 'block';

    } else { // en la condicion el check de los niños se pone en minor_no entonces se elimina la caja


        const minorFormsContainer = document.getElementById('minorFormsContainer');
        const numChildrenInput = document.getElementById('numChildren');
        minorFormsContainer.innerHTML = ''; // Eliminar todos los formularios de niños
        
        numChildrenContainer.style.display = 'none';
    }


        

}


function resetForm() {
    // Ocultar detalles del paquete
    const allDetails = document.querySelectorAll('.packageDetail');
    allDetails.forEach(detail => {
        detail.style.display = 'none';
    });

    // Restablecer selección del paquete
    const packageSelect = document.getElementById('idPackages');
    packageSelect.value = '';

    // Limpiar mensaje de error
    const errorMessage = document.getElementById('errorMessageidPackages');
    if (errorMessage) {
        errorMessage.textContent = '';
    }

    // Ocultar contenedor de número de niños y restablecer el valor
    const numChildrenContainer = document.getElementById('numChildrenContainer');
    numChildrenContainer.style.display = 'none';
    const numChildrenInput = document.getElementById('numChildren');
    numChildrenInput.value = 0; // Restablecer el valor de niños a cero
    

    // Desmarcar inputs de incluir menores
    const includeMinorInputs = document.querySelectorAll('input[name="includeMinor"]');
    includeMinorInputs.forEach(input => {
        input.checked = false;
    });

    // Deshabilitar el botón siguiente
    const nextButton = document.querySelector('.button-ant-sig');
    nextButton.disabled = true;
    nextButton.style.opacity = '0.5';
    nextButton.style.cursor = 'not-allowed';

    // Restablecer todos los inputs de la sección 1
    const allInputs = document.querySelectorAll('#section1 input');
    allInputs.forEach(input => {
        if (input.id !== 'vacant') {
            input.value = '';
        }
    });

    // Eliminar formularios dinámicos y ajustar la cantidad de cupos a cero
    const passengerFormsContainer = document.getElementById('passengerForms');
    passengerFormsContainer.innerHTML = ''; // Eliminar todos los formularios dinámicos
    document.getElementById('numTurista').value = 0; // Ajustar la cantidad de cupos a cero

    // Eliminar formularios de niños y ajustar la cantidad de formularios de niños a cero
    /* const minorFormsContainer = document.getElementById('minorFormsContainer');
    minorFormsContainer.innerHTML = ''; // Eliminar todos los formularios de niños
    minorData = []; // Vaciar los datos de los niños */

    // Restablecer los botones de generación y siguiente sección
    document.getElementById('generateFormButton').style.display = 'inline-block';
    document.getElementById('nextSectionButton').style.display = 'none';

    // Volver a la primera sección
    currentMinorSection = 0;
    currentSection = 0;
    storeMinorData();
    showSection(0); 

    // Ejecutar la verificación de asientos disponibles
    checkSeatsAvailable();
    checkNextButtonInSection2();

    storePassengerData();
}


/* Inicialización y Event Listeners */
document.addEventListener('DOMContentLoaded', () => {
    const packageSelect = document.getElementById('idPackages');
    const resetButton = document.querySelector('.reset-button');
    const nextButton = document.querySelector('.button-ant-sig');
    const includeMinorInputs = document.querySelectorAll('input[name="includeMinor"]');
    
    const numChildrenInput = document.getElementById('numChildren');
    //elimina el formualrio de los niños si se coloca cero niños
    numChildrenInput.addEventListener('change',function(){
        
        if(numChildrenInput.value == 0){
            // Asegurarse de que el campo numChildren sea válido antes de modificar su valor
            
            const minorFormsContainer = document.getElementById('minorFormsContainer');
            minorFormsContainer.innerHTML = ''; // Eliminar todos los formularios de niños
            
        }
    });


    //const numChildrenContainer = document.getElementById('numChildrenContainer');
    //numChildrenInput.disabled = true;

    if (packageSelect) {
        packageSelect.addEventListener('change', showDetails);
    }

    if (resetButton) {
        resetButton.addEventListener('click', resetForm);
    }

    includeMinorInputs.forEach(input => {
        input.addEventListener('change', toggleNumChildrenInput);
    });

    

    const allInputs = document.querySelectorAll('#section1 input');
    allInputs.forEach(input => {
        input.addEventListener('input', validateSection1);
        input.addEventListener('input', validateSection1);
    });

    nextButton.addEventListener('click', nextSection);

    showDetails();
    validateSection1();

    //bloque d e codigo para generar el formulario con el submit si no esta generado desde antes 
    //con el boton de siguiente
 /*    let bandGenerateForm = true;
    const generateFormButton = document.getElementById('generateFormButton');
    generateFormButton.addEventListener('click',function(){
        console.log("ya no se genera mas el formulario con el submit");
        bandGenerateForm = false; 
    })
    const sumbitBottom= document.getElementById('editRequestsReservation');
    sumbitBottom.addEventListener('click',function(event){                
        if(bandGenerateForm){
            llama();
        }
        
    }); */
   
});








