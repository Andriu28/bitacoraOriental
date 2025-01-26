//limitar el boton siguiente 
function checkNextButtonInSection2() {
    const numTuristaElem = document.getElementById('numTurista');
    const includeUserElem = document.getElementById('user_yes');
    const nextButtonSection2 = document.querySelector('#section2 .buttom-container .button-ant-sig:last-child');

    if (!numTuristaElem || !includeUserElem || !nextButtonSection2) {
        return; // Salir de la función si alguno de los elementos no está presente
    }

    const numTurista = parseInt(numTuristaElem.value, 10);
    const includeUser = includeUserElem.checked;

    if (numTurista === 1 && includeUser) {
        nextButtonSection2.style.display = 'none'; // Ocultar el botón "Siguiente" en la sección 2
    } else {
        nextButtonSection2.style.display = 'inline-block'; // Mostrar el botón "Siguiente" en la sección 2
    }
}

// Llamar a la función al cargar la página y cada vez que se actualicen los valores
document.addEventListener('DOMContentLoaded', () => {
    checkNextButtonInSection2();
    document.getElementById('numTurista').addEventListener('change', checkNextButtonInSection2);
    document.getElementById('user_yes').addEventListener('change', checkNextButtonInSection2);
    document.getElementById('user_no').addEventListener('change', checkNextButtonInSection2);
});


function checkSeatsAvailable() {
    const { numChildren } = calculateTotalForms(); 
    const nextButton3 = document.getElementById('nextButton3');

    if (numChildren === 0) {
        if (nextButton3) {
            nextButton3.style.display = 'none'; // Ocultar el botón "Siguiente" en la sección 3 si no hay niños
        }
    } else {
        if (nextButton3) {
            nextButton3.style.display = 'inline-block'; // Mostrar el botón "Siguiente" en la sección 3 si hay niños
        }
    }
}

// Llamar a la función al cargar la página y cada vez que se actualicen los valores
document.addEventListener('DOMContentLoaded', () => {
    checkSeatsAvailable();
    document.getElementById('numTurista').addEventListener('change', checkSeatsAvailable);
    document.getElementById('numChildren').addEventListener('change', checkSeatsAvailable);
    document.getElementById('user_yes').addEventListener('change', checkSeatsAvailable);
    document.getElementById('user_no').addEventListener('change', checkSeatsAvailable);
});



let currentSection = 0;
const sections = document.querySelectorAll('.form-section');
function showSection(index) {
    sections.forEach((section, i) => {
        section.classList.toggle('active', i === index);
    });
}

function nextSection() {
    const {  totalForms, numChildren, includeUser} = calculateTotalForms();
   

    if (!includeUser && currentSection === 0) {
        currentSection += 2; // Saltar sección 2 si el usuario no está incluido
    } else if (includeUser && ( totalForms  == (numChildren + 1)) && currentSection === 1) {
        currentSection += 2; // Saltar a la sección 4 si hay niños ocupando casi todos los cupos
        showSection(currentSection);
    } else {
        currentSection++;
     }    
    if (currentSection < sections.length) {
        showSection(currentSection);
    } 
}

function previousSection() {
    const {  totalForms, numChildren, includeUser } = calculateTotalForms();

    if (!includeUser && currentSection === 2) {
        currentSection -= 2; // Saltar sección 2 si el usuario no está incluido
    } else if (includeUser && ( totalForms  == (numChildren + 1)) && currentSection === 3) {
        currentSection -= 2; // Retroceder a la sección anterior si hay niños ocupando casi todos los cupos
    } else {
        currentSection--;
    }

    if (currentSection >= 0) {
        showSection(currentSection);
    }
}

// Función para Mostrar Formularios de Pasajeros
function showPassengerForm(index) {
    const passengerForms = document.querySelectorAll('.passenger-form');
    passengerForms.forEach((form, i) => {
        form.style.display = i === (index - 1) ? 'block' : 'none';
    });
}

// Función para Pasar al Siguiente Formulario
function nextPassengerForm(currentIndex) {
    storePassengerData(); // Almacenar datos actuales
    const nextIndex = currentIndex + 1;
    showPassengerForm(nextIndex);
}

// Función para Pasar al Formulario Anterior
function previousPassengerForm(currentIndex) {
    storePassengerData(); // Almacenar datos actuales
    const previousIndex = currentIndex - 1;
    showPassengerForm(previousIndex);
}

// Calcular el total de formularios necesarios
function calculateTotalForms() {
    const numTuristaElem = document.getElementById('numTurista');
    const numChildrenElem = document.getElementById('numChildren');
    const includeUserElem = document.getElementById('user_yes');
    const tripVacantElem = document.getElementById('trip_vacant');

    if (!numTuristaElem || !numChildrenElem || !includeUserElem || !tripVacantElem) {
        return { totalForms: 0, numChildren: 0, includeUser: false, tripVacant: 0, numAdults: 0 }; // Salir de la función si alguno de los elementos no está presente
    }

    let numTurista = parseInt(numTuristaElem.value, 10);
    let numChildren = parseInt(numChildrenElem.value || 0, 10);
    if (isNaN(numChildren)) numChildren = 0;
    const includeUser = includeUserElem.checked;
    const tripVacant = parseInt(tripVacantElem.value, 10);

    // Calcular el número total de formularios necesarios
    let totalForms = numTurista;

    // Calcular el número total de adultos
    let numAdults = numTurista - numChildren;

    return { totalForms, numChildren, includeUser, tripVacant, numAdults };
}

let passengerData = [];

// Función para almacenar los datos de los formularios de pasajeros
function storePassengerData() {
    const sections = document.querySelectorAll('.passenger-form');
    passengerData = [];

    sections.forEach((section, index) => {
        const ci = section.querySelector(`input[name="ci${index + 1}"]`) ? section.querySelector(`input[name="ci${index + 1}"]`).value : "";
        const name = section.querySelector(`input[name="name${index + 1}"]`) ? section.querySelector(`input[name="name${index + 1}"]`).value : "";
        const lastName = section.querySelector(`input[name="lastName${index + 1}"]`) ? section.querySelector(`input[name="lastName${index + 1}"]`).value : "";
        const birthDate = section.querySelector(`input[name="birthDate${index + 1}"]`) ? section.querySelector(`input[name="birthDate${index + 1}"]`).value : "";
        const phone = section.querySelector(`input[name="phone${index + 1}"]`) ? section.querySelector(`input[name="phone${index + 1}"]`).value : "";
        const address = section.querySelector(`input[name="address${index + 1}"]`) ? section.querySelector(`input[name="address${index + 1}"]`).value : "";

        const estadoSelect = section.querySelector(`select[name="estado${index + 1}"]`);
        const idEstado = estadoSelect ? estadoSelect.value : "";
        const estado = estadoSelect ? (estadoSelect.options[estadoSelect.selectedIndex] ? estadoSelect.options[estadoSelect.selectedIndex].text : "") : "";

        const municipioSelect = section.querySelector(`select[name="municipio${index + 1}"]`);
        const idMunicipio = municipioSelect ? municipioSelect.value : "";
        const municipio = municipioSelect ? (municipioSelect.options[municipioSelect.selectedIndex] ? municipioSelect.options[municipioSelect.selectedIndex].text : "") : "";

        const parroquiaSelect = section.querySelector(`select[name="parroquia${index + 1}"]`);
        const idParroquia = parroquiaSelect ? parroquiaSelect.value : "";
        const parroquia = parroquiaSelect ? (parroquiaSelect.options[parroquiaSelect.selectedIndex] ? parroquiaSelect.options[parroquiaSelect.selectedIndex].text : "") : "";

        // Guardar los datos del formulario incluso si están vacíos
        passengerData.push({ ci, name, lastName, birthDate, phone, address, estado, municipio, parroquia, idEstado, idMunicipio, idParroquia });
    });
    verifyFormsFilled(); // Verificar formularios sin el evento
    updateResponsibleSelects(); // Actualizar la lista de responsables

}


// Función para verificar si todos los formularios están llenos (sin evento)
let intervalId; // Variable para almacenar el ID del intervalo

// Función para verificar si todos los formularios están llenos (sin evento)
function verifyFormsFilled() {
    const { numAdults, includeUser } = calculateTotalForms();
    let allFilled = true;
    let filledFormsCount = 0;

    if (passengerData.length === 0) {
        allFilled = false;
    } else {
        passengerData.forEach((data, index) => {
            const { ci, name, lastName, birthDate, address, estado, municipio, parroquia } = data; // Excluir el campo phone
            if (!ci || !name || !lastName || !birthDate || !address || !estado || !municipio || !parroquia) {
                allFilled = false;
            } else {
                filledFormsCount++;
            }
        });
    }

    let totalNeededForms = numAdults;
    if (includeUser) {
        totalNeededForms -= 1; // Restar 1 si el usuario está incluido
    }

    if (!allFilled) {
    } else { 
        // Detener el intervalo cuando todos los formularios estén completos
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        }
    }

    // Habilitar o deshabilitar el botón "Next Section"
    const nextButton3 = document.getElementById('nextButton3');
    if (nextButton3) {
        nextButton3.disabled = !allFilled;
        nextButton3.style.opacity = allFilled ? '1' : '0.5';
        nextButton3.style.cursor = allFilled ? 'pointer' : 'not-allowed';
    }
}

// Función para verificar si todos los formularios están llenos (con evento)
function checkFormsFilled(event) {
    verifyFormsFilled();

    if (!allFilled) {
        event.preventDefault(); // Prevenir el envío del formulario
    }
}

// Llamar a la función al cargar la página y cada vez que se actualicen los valores
document.addEventListener('DOMContentLoaded', () => {
    verifyFormsFilled();

    // Agregar event listeners a los formularios
    document.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('input', storePassengerData);
        element.addEventListener('change', storePassengerData);
    });

    // Verificar formularios cada vez que se actualicen
    document.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('input', verifyFormsFilled);
        element.addEventListener('change', verifyFormsFilled);
    });

    // Establecer un intervalo para verificar los formularios cada 5 segundos
    
});

setInterval(() => {
    storePassengerData();
}, 1000);

function clearUserData() {
    const userFields = [
        'ci1', 'name1', 'lastName1', 'birthDate1', 'phone1', 'address1', 'estado1', 'municipio1', 'parroquia1', 'idParroquia1'
    ];
    userFields.forEach(field => {
        const element = document.getElementById(field);
        if (element) {
            element.value = '';
        }
    });
    // Volver a almacenar los datos para excluir los datos del usuario
    storePassengerData();
}
function llama(){
    generateDynamicForms()
    generateMinorForms()
}
function generateDynamicForms() {
    const numTurista = parseInt(document.getElementById('numTurista').value, 10);
    let numChildren = parseInt(document.getElementById('numChildren').value || 0, 10);
    if (isNaN(numChildren)) numChildren = 0;
    const includeUser = document.getElementById('user_yes').checked;

    // Calcular el número total de formularios necesarios
    let totalForms = numTurista - numChildren;
    if (includeUser) {
        totalForms -= 1; // Restar 1 si el usuario está incluido
    }

    // Contenedor donde se generarán los inputs dinámicamente
    const passengerFormsContainer = document.getElementById('passengerForms');
    passengerFormsContainer.innerHTML = ''; // Limpiar contenido anterior

    // Generar los formularios adicionales
    generateAdditionalForms(totalForms, passengerData, includeUser);

    // Mostrar solo el primer formulario de pasajeros
    showPassengerForm(1);

    // Actualizar listeners para manejar la selección de estado y municipio
    updateAddressListeners();

    // Después de generar los formularios, ocultar el botón de generar y mostrar el botón de siguiente sección
    document.getElementById('generateFormButton').style.display = 'none';
    document.getElementById('nextSectionButton').style.display = 'inline-block';
}
function generateAdditionalForms(numForms, data, includeUser) {

 
    const passengerFormsContainer = document.getElementById('passengerForms');
    for (let i = 1; i <= numForms; i++) {
        let prevButton = `<button class="button-prev-passenger" type="button" title="Formulario anterior" onclick="previousPassengerForm(${i})">
        <svg  width="36" height="36" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1)">
            <path d="M13.939 4.939 6.879 12l7.06 7.061 2.122-2.122L11.121 12l4.94-4.939z"></path>
        </svg>
        </button>`;
        
        let nextButton = (i < numForms) ? `
        <button class="button-next-passenger" type="button" title="Siguiente formulario" onclick="nextPassengerForm(${i})">
            <svg  width="36" height="36" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1)">
                <path d="M10.061 19.061 17.121 12l-7.06-7.061-2.122 2.122L12.879 12l-4.94 4.939z"></path>
            </svg>
        </button>` : '';
        
        let deleteButton = numForms > 1 ? `<button class="button-delete-passenger" title="Eliminar" type="button" onclick="deletePassengerForm(${i})">
        <svg class="icon-focus-options" xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24'>
        <path fill='none' stroke='#d32f2f' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M18 6L6 18M6 6l12 12'/>
      </svg>
        </button>` : '';

        let clearButton = `<button class="button-clear-passenger" type="button" title="Limpiar" onclick="clearPassengerForm(${i})">
        <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
            <g fill="#a65f3e">
                <path d="M56.31 74.64c-.88 0-1.71-.34-2.34-.97a3.3 3.3 0 0 1-.97-2.34c0-.88.34-1.71.97-2.34l64.56-64.56a3.307 3.307 0 0 1 4.68 0a3.314 3.314 0 0 1 0 4.68L58.65 73.67c-.63.63-1.46.97-2.34.97" />
                <path d="M120.87 4c.71 0 1.42.27 1.96.81a2.79 2.79 0 0 1 0 3.93L58.27 73.3c-.54.54-1.25.81-1.96.81s-1.42-.27-1.96-.81a2.79 2.79 0 0 1 0-3.93l64.56-64.56c.54-.54 1.25-.81 1.96-.81m0-1.06c-1.03 0-1.99.4-2.71 1.12L53.6 68.62a3.78 3.78 0 0 0-1.12 2.71a3.82 3.82 0 0 0 3.83 3.83c1.03 0 1.99-.4 2.71-1.12l64.56-64.56c1.5-1.5 1.5-3.93 0-5.43a3.85 3.85 0 0 0-2.71-1.11" />
            </g>
            <path fill="#ffe082" d="m5.61 91.49l31.11 31.11c6.99-7.7 12.97-16.45 16.19-26.5c.23-.73.27-1.92 1.02-2.87c3.61-4.53 14.92-16.06 5.65-25.33c-8.85-8.85-19.5 1.81-23.95 5.48c-1.36 1.13-3.07 1.83-4.85 2.21C18.84 78.2 6.51 90.54 5.61 91.49" />
            <path fill="#ffe082" d="M59.07 60.61c.77-.4 1.87-.9 3.15-.68c.78.14 1.89 1.08 3.04 2.23s2.23 2.44 2.55 3.27c.33.83-.03 1.94-.03 1.94c-.93 1.84-3.07 5.52-4.8 4.99c-1.93-.59-3.86-2.44-5.29-3.83c-.81-.78-1.65-1.64-2.2-2.63c-.77-1.41.06-2.59 1.03-3.57c.69-.66 1.86-1.36 2.55-1.72" />
            <path fill="#f9c248" d="M58.61 63.79c.93.88 1.68 1.95 2.71 2.71c2.02 1.48 3.64.77 4.96-.42c.39-.35.98-.8 1.36-.44c.11.11.16.26.2.41c.16.73-.06 1.49-.36 2.18c-.74 1.69-1.95 3.17-3.46 4.23c-.26.18-.57.36-.88.26c-.19-.06-.33-.21-.45-.36c-1.66-1.95-2.96-4.26-5.01-5.79c-.82-.61-2.91-1.06-2.38-2.43c.79-2.09 2.53-1.09 3.31-.35" />
            <path fill="#f9c248" d="M52.91 96.1c.23-.73.27-1.92 1.02-2.87c4.12-5.16 9.78-11.04 9.16-18.2c-.08-.98-1.35-6-2.74-4.11c-.31.42-.19 2.52-.23 3.03c-.8 9.38-8.16 14.57-9.52 16.19c-1.36 1.63-1.32 3.15-2.49 5.56c-1.31 2.71-2.99 5.24-4.88 7.58c-3.03 3.75-6.6 7.03-10.29 10.15c-.61.51-1.24 1.04-1.62 1.74c-1.05 1.93 1.22 3.25 2.44 4.46l2.95 2.95c6.99-7.69 12.97-16.44 16.2-26.48" />
            <path fill="#a65f3e" d="M62.67 73.4s-3.5-6.6-8.13-8.59c0 0-.17-.43.16-.8c.41-.46.96-.56 1.25-.37c3.42 2.12 6.5 4.95 8.06 8.82c.31.74-1.05 1.83-1.34.94" />
            <path fill="#e2a610" d="M36.3 118.46c-.8-1.25-1.94-2.4-2.54-3.66c-.14-.31-.27-.64-.23-.98c.07-.64 1.04-1.21 1.49-1.59c.68-.58 1.37-1.15 2.03-1.76c1.3-1.19 2.51-2.51 3.35-4.07c.14-.25.26-.56.13-.82c-.28-.52-1.9 1.22-2.2 1.49c-.84.74-1.66 1.5-2.54 2.18c-1.17.9-3.38 2.43-4.95 1.7c-.8-.37-1.52-1.35-2.1-1.99c-.67-.75-1.31-1.53-2.02-2.26c-1.02-1.06-2.06-2.1-3.11-3.12c-.53-.52-1.07-1.04-1.62-1.54c-.41-.37-.49-.53-.03-.98c1.52-1.48 2.98-3.03 4.37-4.63c.18-.21.35-.54.14-.72c-.15-.13-.39-.04-.56.05c-2.08 1.1-3.74 2.83-5.54 4.35c-.44.37-1.71-1.04-1.99-1.26c-.74-.59-1.23-.82-.37-1.69c3.87-3.92 7.78-7.56 12.43-10.58c.86-.55 1.76-1.12 2.25-2.02c-.09-.24-.44-.21-.69-.12c-6.45 2.32-15.12 10.33-15.86 11.04c-1.3 1.26-3.63-1.65-7.08-3.85c-1.18-.75 0-1.88.3-2.23c2.08-2.46 4.83-5.14 4.83-5.14c-1.02.11-7.65 6.09-8.44 6.99c-.67.77-1.35 1.47-1.4 2.54c-.05.93.32 1.86.86 2.6c6.16 8.4 20.69 22.35 25.84 26.03c3.07 2.19 4.02 1.79 5.27.54c.65-.65.96-1.48.84-2.4c-.1-.74-.43-1.44-.86-2.1" />
            <path fill="#f44336" d="M53.11 95.03c-4.22-6.54-13.04-15.49-19.68-20.19c-.52-.37 1.64-1.63 2.18-1.25c6.9 4.91 14.03 12.4 18.48 19.19c.36.53-.73 2.63-.98 2.25m4.43-6.41c-4.05-5.69-12.17-13.91-17.9-18.5c-.5-.4 1.45-1.76 1.85-1.45c6.04 4.82 13.35 11.99 17.44 18.11c.3.45-1.1 2.25-1.39 1.84" />
        </svg>
        </button>`;
          let info ='<svg class="bx green" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M11.95 18q.525 0 .888-.363t.362-.887t-.362-.888t-.888-.362t-.887.363t-.363.887t.363.888t.887.362m-.9-3.85h1.85q0-.825.188-1.3t1.062-1.3q.65-.65 1.025-1.238T15.55 8.9q0-1.4-1.025-2.15T12.1 6q-1.425 0-2.312.75T8.55 8.55l1.65.65q.125-.45.563-.975T12.1 7.7q.8 0 1.2.438t.4.962q0 .5-.3.938t-.75.812q-1.1.975-1.35 1.475t-.25 1.825M12 22q-2.075 0-3.9-.787t-3.175-2.138T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>';

            if (i === 1) {
                prevButton = ''; // No mostrar el botón anterior si es el primer formulario
            }
    
            const passengerNumber = includeUser ? i + 1 : i;
            const previousData = data[i - 1] || {};
    
            const passengerForm = `
                <div class="passenger-form" id="passengerForm${i}">
                    <div class="btReset">
                        <div class="header">
                            <h2>Pasajero ${passengerNumber}</h2><span class="help-icon" title="Debe rellenar los datos de los pasajeros para continuar">${info}</span>
                        </div>
                        <div>
                            ${clearButton}
                            ${deleteButton}
                        </div>
                    </div>
                    <div class="contenedor-formulario">
                        <div class="columna">
                            <label for="name${i}">Nombre</label><span class="obligatorio">*</span>
                            <span class="help-icon" title="Inngrese el primer nombre del pasajero">${info}</span>
                            <div class="errorMessage" id="errorMessagename${i}"></div>
                            <input class="input-box" type="text" id="name${i}" name="name${i}" maxlength="50" placeholder="Ingrese su Nombre" value="${previousData.name || ''}" >
                        </div>
                        <div class="columna">
                            <label for="lastName${i}">Apellido</label><span class="obligatorio">*</span>
                            <span class="help-icon" title="Ingrese el primer apellido del pasajero">${info}</span>
                            <div class="errorMessage" id="errorMessagelastName${i}"></div>
                            <input class="input-box" type="text" id="lastName${i}" name="lastName${i}" maxlength="50" placeholder="Ingrese su Apellido" value="${previousData.lastName || ''}" >
                        </div>
                    </div>
                    <div class="contenedor-formulario">
                        <div class="columna">
                            <label for="ci${i}">Cédula de Identidad</label><span class="obligatorio">*</span>
                             <span class="help-icon" title="Ingrese la cédula del pasajero &#10;Ejemplo: 12345678">${info}</span>
                            <div class="errorMessage" id="errorMessageci${i}"></div>
                            <input class="input-box" type="text" id="ci${i}" name="ci${i}" maxlength="20" placeholder="Ingrese su Cédula de Identidad" value="${previousData.ci || ''}" >
                        </div>
                        <div class="columna">
                            <label for="birthDate${i}">Fecha de Nacimiento</label><span class="obligatorio">*</span>
                            <span class="help-icon" title="Seleccione la fecha de nacimiento del pasajero. &#10;Debe ser mayor de edad">${info}</span>
                            <div class="errorMessage" id="errorMessagebirthDate${i}"></div>
                            <input class="input-box" type="date" id="birthDate${i}" name="birthDate${i}" value="${previousData.birthDate || ''}">
                        </div>
                     </div>
                    <div class="contenedor-formulario">
                        <div class="columna">
                            <label for="phone${i}">Teléfono</label><span class="grey-text">(Opcional)</span>
                              <span class="help-icon" title="Ingrese el número de teléfono del pasajero. &#10;Ejemplo: 04241234567, 04121234567 ">${info}</span>
                            <div class="errorMessage" id="errorMessagephone${i}"></div>
                            <input class="input-box" type="tel" id="phone${i}" name="phone${i}" maxlength="20" placeholder="Ingrese su Teléfono" value="${previousData.phone || ''}" >
                        </div>
                        <div class="columna">
                            <label for="estado${i}">Estado</label><span class="obligatorio">*</span>
                            <span class="help-icon" title="Seleccione el estado donde reside el pasajero.">${info}</span>
                            <div class="errorMessage" id="errorMessageestado${i}"></div>
                            <select class="custom-select" name="estado${i}" id="estado${i}"  onchange="clearMunicipioYParroquia(${i}); storePassengerData(); getMunicipios(${i});">
                                <option value="${previousData.idEstado || ''}">${previousData.estado || 'Seleccionar'}</option>
                                ${getStatesOptions(previousData.estado || '')}
                            </select>
                        </div>

                    </div>
                    <div class="contenedor-formulario">
                        <div class="columna">
                            <label for="municipio${i}">Municipio</label><span class="obligatorio">*</span>
                           <span class="help-icon" title="Seleccione el municipio donde reside el pasajero.&#10;(Primero selecione el estado)">${info}</span>
                            <div class="errorMessage" id="errorMessagemunicipio${i}"></div>
                            <select class="custom-select" name="municipio${i}" id="municipio${i}"  onchange="storePassengerData(); getParroquias(${i});">
                                <option value="${previousData.idMunicipio || ''}">${previousData.municipio || 'Seleccionar'}</option>
                                ${previousData.municipio ? getMunicipiosOptions(previousData.estado, previousData.municipio) : ''}
                            </select>
                        </div>
                        <div class="columna">
                            <label for="parroquia${i}">Parroquia</label><span class="obligatorio">*</span>
                            <span class="help-icon" title="Seleccione la parroquia donde reside el pasajero.&#10;(Primero selecione el estado)">${info}</span>
                            <div class="errorMessage" id="errorMessageparroquia${i}"></div>
                            <select class="custom-select" name="parroquia${i}" id="parroquia${i}"  onchange="storePassengerData(); returnParroquia(${i});">
                                <option value="${previousData.idParroquia || ''}">${previousData.parroquia || 'Seleccionar'}</option>
                                ${previousData.parroquia ? getParroquiasOptions(previousData.municipio, previousData.parroquia) : ''}
                            </select>
                        </div>
                    </div>
                    
                    <label for="address${i}">Dirección</label><span class="obligatorio">*</span>
                    <span class="help-icon" title="Ingrese la dirección completa del pasajerp. Ejemplo: Calle 12, Nº 34, Urbanización Las Rosas.&#10;Estos datos suelen ser usados para trazar el recorrido del autobus">${info}</span>
                    <div class="errorMessage" id="errorMessageaddress${i}"></div>
                    <input class="input-box" type="text" id="address${i}" name="address${i}" maxlength="100" placeholder="Ingrese su Dirección" value="${previousData.address || ''}" >
                    <div class="text-grey">
                            <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                        </div>
                    <div class="boton-sig-ant" style="display: flex; justify-content: ${i === 1 ? 'flex-end' : 'space-between'};">
                        ${prevButton} 
                        ${nextButton} 
                    </div>
                </div>`;
                passengerFormsContainer.insertAdjacentHTML('beforeend', passengerForm);
                // Añadir validaciones para cada input del formulario 
                addValidationListeners(i); 
                addDynamicFormListeners(i);
            } 
        }
       
//aqui hay un cambio prudentte
function clearPassengerForm(index) {
    const form = document.getElementById(`passengerForm${index}`);
    form.querySelectorAll('input').forEach(input => input.value = '');
    form.querySelectorAll('select').forEach(select => select.value = '');
    storePassengerData();
}

// Función para vaciar los campos de municipio y parroquia cuando se selecciona un nuevo estado
function clearMunicipioYParroquia(index) {
    const municipioSelect = document.getElementById(`municipio${index}`);
    const parroquiaSelect = document.getElementById(`parroquia${index}`);
    
    if (municipioSelect) {
        municipioSelect.innerHTML = '<option value="">Seleccionar</option>';
    }
    if (parroquiaSelect) {
        parroquiaSelect.innerHTML = '<option value="">Seleccionar</option>';
    }
}

function deletePassengerForm(index) {
    // Guardar los datos actuales de los formularios
    storePassengerData();

    // Eliminar el formulario del DOM
    const formToDelete = document.getElementById(`passengerForm${index}`);
    formToDelete.remove();

    // Decrementar el número de formularios
    const numTurista = parseInt(document.getElementById('numTurista').value, 10);
    document.getElementById('numTurista').value = numTurista - 1;

    // Actualizar los datos de los formularios restantes
    passengerData.splice(index - 1, 1);

    // Recalcular y regenerar los formularios
    generateDynamicForms();
}





// Event listeners para cambios en los inputs que generen los formularios dinámicos
// Event listeners para cambios en los inputs que generen los formularios dinámicos
document.getElementById('user_yes').addEventListener('change', function() {
    storePassengerData();
    generateDynamicForms();
});

document.getElementById('user_no').addEventListener('change', function() {
    storePassengerData();
    generateDynamicForms();
});

document.getElementById('minor_yes').addEventListener('change', function() {
    storePassengerData();
    document.getElementById('numChildrenContainer').style.display = 'block';
    generateDynamicForms();
});

document.getElementById('numTurista').addEventListener('change', function() {
    storePassengerData();
    generateDynamicForms();
});

document.getElementById('minor_no').addEventListener('change', function() {
    storePassengerData();
    document.getElementById('numChildren').value = 0;
    document.getElementById('numChildrenContainer').style.display = 'none';
    generateDynamicForms();
});

document.getElementById('numChildren').addEventListener('change', function() {
    storePassengerData();
    generateDynamicForms();
});


function returnParroquia(i){ 
    const parroquiaElement = document.getElementById(`parroquia${i}`); 
    const idParroquiaElement = document.getElementById(`idParroquia${i}`);
    if (parroquiaElement && idParroquiaElement) {
        idParroquiaElement.value = parroquiaElement.value;
        storePassengerData(); // Guardar los datos al cambiar la selección
    }
}

function updateAddressListeners() {
    const numTurista = parseInt(document.getElementById('numTurista').value, 10);
    for (let i = 1; i <= numTurista; i++) {
        const cbxEstado = document.getElementById(`estado${i}`);
        const cbxMunicipio = document.getElementById(`municipio${i}`);
        const cbxParroquia = document.getElementById(`parroquia${i}`);

        if (cbxEstado) {
            cbxEstado.addEventListener('change', function() {
                getMunicipios(i);
            });
        }

        if (cbxMunicipio) {
            cbxMunicipio.addEventListener('change', function() {
                getParroquias(i);
            });
        }
    }
}

// Función para obtener y establecer datos desde el servidor utilizando fetch
function fetchAdnSetData(url, formData, targetElement) {
    return fetch(url, {
        method: "POST",
        body: formData,
        mode: 'cors'
    })
    .then(response => response.json())
    .then(data => {
        targetElement.innerHTML = data;
    })
    .catch(err => console.log(err));
}

// Función para obtener los municipios según el estado seleccionado
function getMunicipios(index) {
    const estadoId = document.getElementById(`estado${index}`).value;
    if (estadoId) {
        fetch('model/address.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ id_e: estadoId }),
        })
        .then(response => response.json())
        .then(options => {
            document.getElementById(`municipio${index}`).innerHTML = options;
            storePassengerData(); // Guardar los datos al cambiar la selección
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

// Función para obtener las parroquias según el municipio seleccionado
function getParroquias(index) {
    const municipioId = document.getElementById(`municipio${index}`).value;
    if (municipioId) {
        fetch('model/address.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ id_m: municipioId }),
        })
        .then(response => response.json())
        .then(options => {
            document.getElementById(`parroquia${index}`).innerHTML = options;
            storePassengerData(); // Guardar los datos al cambiar la selección
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

// Función para obtener las opciones de estado y cargarlas en el selector
function getStatesOptions(selectedEstado = '') {
    let options = "";
    statesOptions.forEach(state => {
        options += `<option value="${state.id_e}" ${state.id_e === selectedEstado ? 'selected' : ''}>${state.estado}</option>`;
    });
    return options;
}

// Función para obtener las opciones de municipios y cargarlas en el selector
function getMunicipiosOptions(estado, selectedMunicipio = '') {
    let options = "<option value=''>Seleccionar</option>";
    municipiosOptions.filter(m => m.estado_id === estado).forEach(municipio => {
        options += `<option value="${municipio.id_m}" ${municipio.id_m === selectedMunicipio ? 'selected' : ''}>${municipio.municipio}</option>`;
    });
    return options;
}

// Función para obtener las opciones de parroquias y cargarlas en el selector
function getParroquiasOptions(municipio, selectedParroquia = '') {
    let options = "<option value=''>Seleccionar</option>"
    parroquiasOptions.filter(p => p.municipio_id === municipio).forEach(parroquia => {
        options += `<option value="${parroquia.id_p}" ${parroquia.id_p === selectedParroquia ? 'selected' : ''}>${parroquia.parroquia}</option>`;
    });

    return options;
}



// Asignar la función para generar los formularios dinámicos al evento de click del botón "Siguiente"
document.querySelector('.button-ant-sig').addEventListener('click', generateDynamicForms);



