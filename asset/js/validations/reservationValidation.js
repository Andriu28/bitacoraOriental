
function alertMessageDisappear(mse) {
    let count = 2;
    const timer = setInterval(function() {
        count--;

        if (count < 0) {
            clearInterval(timer);
            mse.textContent = "";
        }
    }, 3000);
}

const regexReservation = {
    numTurista: /^[0-9]+$/,
    numChildren: /^[0-9]+$/
};

// Obtener el valor de vacant
const vacant = parseInt(document.getElementById('vacant').value, 10);

document.querySelectorAll('input[type="text"]').forEach(input => {
    const allowedCharacters = regexReservation[input.name];

    input.addEventListener('keypress', function(e) {
        if (!allowedCharacters.test(e.key)) {
            e.preventDefault();
            const errorMessage = `Carácter no válido para este campo`;
            document.getElementById('errorMessage' + input.id).textContent = errorMessage;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        } else {
            document.getElementById('errorMessage' + input.id).textContent = "";
        }
    });

    input.addEventListener('paste', function(e) {
        e.preventDefault();
        const clipboardData = (e.clipboardData || window.clipboardData).getData('text');
        if (allowedCharacters.test(clipboardData)) {
            document.execCommand('insertText', false, clipboardData);
            document.getElementById('errorMessage' + input.id).textContent = "";
        } else {
            const errorMessage = `El texto pegado contiene caracteres no válidos`;
            document.getElementById('errorMessage' + input.id).textContent = errorMessage;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        }
    });

    input.addEventListener('input', function(e) {
        const value = parseInt(input.value, 10) || 0;

        if (input.name === 'numTurista') {
            const errorMessageElement = document.getElementById('errorMessagenumTurista');
            if (value > vacant) {
                input.value = vacant;
                document.getElementById( 'errorMessagenumTurista' ).textContent = `El número de cupos debe estar entre 1 y ${vacant}`;
            } else {
                document.getElementById( 'errorMessagenumTurista' ).textContent = "";
            }
            alertMessageDisappear(errorMessageElement);
        } else if (input.name === 'numChildren') {
            const errorMessageElement = document.getElementById('errorMessagenumChildren');
            if (value > vacant - 1) {
                input.value = vacant - 1;
                document.getElementById( 'errorMessagenumChildren' ).textContent = 'El número de cupos debe estar entre 1 y ' + (vacant - 1);
               
            } else {
                document.getElementById( 'errorMessagenumChildren' ).textContent = "";
            } 
            alertMessageDisappear(errorMessageElement);
        }
    });
});


// Función para validar la edad de los menores
function validateMinorAge(input, errorMessageElement) {
    const value = parseInt(input.value, 10) || 0;
    if (value < 0 || value > 17) {
        input.value = '';
        errorMessageElement.textContent = 'La edad debe estar entre 0 y 17.';
        alertMessageDisappear(errorMessageElement);
    } else {
        errorMessageElement.textContent = '';
    }
}
/* /////////////////////// */

// Expresiones regulares para validar los diferentes tipos de datos
const regexValidation = {
    name: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]*$/,
    lastName: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/,
    ci: /^[0-9]*$/,
    phone: /^[0-9]*$/,
    address: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\-_\/#.,]*$/,

};


// Función para añadir validaciones a cada input del formulario
function addValidationListeners(index) {
    const nameInput = document.getElementById(`name${index}`);
    const lastNameInput = document.getElementById(`lastName${index}`);
    const ciInput = document.getElementById(`ci${index}`);
    const phoneInput = document.getElementById(`phone${index}`);
    const addressInput = document.getElementById(`address${index}`);
    const birthDateInput = document.getElementById(`birthDate${index}`);

    // Validar que los caracteres para cada campo sean los que se establece
    [nameInput, lastNameInput, ciInput, phoneInput, addressInput].forEach(input => {
        const allowedCharacters = regexValidation[input.name.replace(index, '')]; // Asegúrate de no reasignar allowedCharacters

        input.addEventListener('keypress', function(e) {
            if (!allowedCharacters.test(e.key)) {
                e.preventDefault(); // Evita que el carácter no válido se añada
                document.getElementById('errorMessage' + input.id).textContent = `Carácter no válido para este campo`;
            } else {
                document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
            }
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault(); // Evita que se pegue texto directamente
            const clipboardData = (e.clipboardData || window.clipboardData).getData('text');
            const errorMessageElement = document.getElementById('errorMessage' + input.id);

            if (allowedCharacters.test(clipboardData)) {
                document.execCommand('insertText', false, clipboardData);
                if (errorMessageElement) {
                    errorMessageElement.textContent = ""; // Limpia el mensaje de error
                }
            } else {
                if (errorMessageElement) {
                    errorMessageElement.textContent = `El texto pegado contiene caracteres no válidos`;
                    alertMessageDisappear(errorMessageElement);
                }
            }
        });

        input.addEventListener('input', function() {
            let value = input.value;
            if (value.length > 0) {
                let firstLetterIndex = [...value].findIndex(char => /[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]/.test(char));
                if (firstLetterIndex !== -1) {
                    input.value = value.slice(0, firstLetterIndex) + value.charAt(firstLetterIndex).toUpperCase() + value.slice(firstLetterIndex + 1);
                }
            }
        });
    });

    // Validación para la fecha de nacimiento
    birthDateInput.addEventListener('focus', function() {
        const today = new Date();
        const minAge = 18;
        const maxAge = 110;
        const minDate = new Date(today.getFullYear() - maxAge, today.getMonth(), today.getDate());
        const maxDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());
        birthDateInput.min = minDate.toISOString().split('T')[0];
        birthDateInput.max = maxDate.toISOString().split('T')[0];
    });

    birthDateInput.addEventListener('blur', function() {
        const birthDate = new Date(birthDateInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        const errorMessageElement = document.getElementById('errorMessage' + birthDateInput.id);
        if (!birthDateInput.value) {
            errorMessageElement.textContent = 'La fecha de nacimiento es obligatoria.';
        } else if (age < 18 || age > 110) {
            errorMessageElement.textContent = 'Debe ser mayor de 18 años y menor de 110 años.';
            alertMessageDisappear(errorMessageElement);
        } else {
            errorMessageElement.textContent = '';
        }
    });

    // Establecer el placeholder de la fecha por defecto hace 18 años
    const today = new Date();
    const defaultDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    birthDateInput.placeholder = defaultDate.toISOString().split('T')[0];
}


function validateForm() {
    updateMinorMoney();
    let isValid = true;
    let firstInvalidElement = null;
    let firstInvalidSection = null;

    // Validar sección 1
    const numTuristaInput = document.getElementById('numTurista');
    const includeUserInputs = document.querySelectorAll('input[name="includeUser"]');
    const includeMinorInputs = document.querySelectorAll('input[name="includeMinor"]');
    const numChildrenInput = document.getElementById('numChildren');
    const idPackagesSelect = document.getElementById('idPackages');

    if (!numTuristaInput.value) {
        document.getElementById('errorMessagenumTurista').textContent = 'Este campo es obligatorio.';
        isValid = false;
        firstInvalidElement = firstInvalidElement || numTuristaInput;
        firstInvalidSection = firstInvalidSection || 'main';
    }

    let includeUserChecked = false;
    includeUserInputs.forEach(input => {
        if (input.checked) includeUserChecked = true;
    });
    if (!includeUserChecked) {
        document.getElementById('errorMessageincludeUser').textContent = 'Debe seleccionar una opción.';
        isValid = false;
        firstInvalidSection = firstInvalidSection || 'main';
    }

    let includeMinorChecked = false;
    includeMinorInputs.forEach(input => {
        if (input.checked) includeMinorChecked = true;
    });
    if (!includeMinorChecked) {
        document.getElementById('errorMessageincludeMinor').textContent = 'Debe seleccionar una opción.';
        isValid = false;
        firstInvalidSection = firstInvalidSection || 'main';
    }

    if (document.getElementById('minor_yes').checked && !numChildrenInput.value) {
        document.getElementById('errorMessagenumChildren').textContent = 'Este campo es obligatorio.';
        isValid = false;
        firstInvalidElement = firstInvalidElement || numChildrenInput;
        firstInvalidSection = firstInvalidSection || 'main';
    }

    if (!idPackagesSelect.value) {
        document.getElementById('errorMessageidPackages').textContent = 'Debe seleccionar un paquete de viaje.';
        isValid = false;
        firstInvalidElement = firstInvalidElement || idPackagesSelect;
        firstInvalidSection = firstInvalidSection || 'main';
    }

    // Validar secciones dinámicas (Pasajeros)
    const passengerForms = document.querySelectorAll('.passenger-form');
    passengerForms.forEach((form, index) => {
        const requiredFields = form.querySelectorAll('input, select');
        requiredFields.forEach(field => {
            if (field.name.startsWith('phone') && field.value.trim() !== '') {
                const phoneCode = ["0414", "0424", "0412", "0416", "0426", "0294", "POR ASIGNAR"];
                let valid = false;
                for (const code of phoneCode) {
                    if (field.value.startsWith(code)) {
                        valid = true;
                        break;
                    }
                }
                if (!valid || field.value.length !== 11) {
                    document.getElementById('errorMessage' + field.id).textContent = 'El número de teléfono debe comenzar con: "0414", "0424", "0412", "0416", "0426", "0294" y tener 11 dígitos.';
                    alertMessageDisappear(document.getElementById('errorMessage' + field.id));
                    field.focus();
                    if (!firstInvalidSection) {
                        firstInvalidSection = 'passenger';
                        currentPassengerSection = index + 1;
                    }
                    isValid = false;
                }
            }
            
            if (field.name.startsWith('ci') && field.value.trim() !== '') { 
                if (field.value.length < 7 || field.value.length > 8) { 
                    document.getElementById('errorMessage' + field.id).textContent = 'La cédula debe tener entre 7 y 8 dígitos.'; 
                    alertMessageDisappear(document.getElementById('errorMessage' + field.id)); 
                    field.focus(); 
                    if (!firstInvalidSection) { 
                        firstInvalidSection = 'passenger'; 
                        currentPassengerSection = index + 1; 
                    } isValid = false; 
                } 
            }

            if (field.value.trim() === '' && !field.name.startsWith('phone')) {
                const errorMessageElement = form.querySelector(`#errorMessage${field.id}`);
                if (errorMessageElement) {
                    errorMessageElement.textContent = 'Este campo es obligatorio.';
                    alertMessageDisappear(errorMessageElement); // Llama a la función para hacer desaparecer el mensaje
                }
                isValid = false;
                firstInvalidElement = firstInvalidElement || field;
                if (!firstInvalidSection) {
                    firstInvalidSection = 'passenger';
                    currentPassengerSection = index + 1;
                }
            }
            
        });
    });

  
    // Validar secciones dinámicas (Niños)
    const minorForms = document.querySelectorAll('.minor-info-container');
    minorForms.forEach((form, index) => {
        const requiredFields = form.querySelectorAll('input, select');
        requiredFields.forEach(field => {
            if (field.value.trim() === '') {
                const errorMessageElement = document.getElementById('errorMessage' + field.id);
                if (errorMessageElement) {
                    errorMessageElement.textContent = 'Este campo es obligatorio.';
                    alertMessageDisappear(errorMessageElement); // Llama a la función para hacer desaparecer el mensaje
                }
                isValid = false;
                firstInvalidElement = firstInvalidElement || field;
                if (!firstInvalidSection) {
                    firstInvalidSection = 'minor';
                    currentMinorSection = index;
                }
            }
        });
    });
    
    // Calcular el total de formularios necesarios
    const { totalForms, numChildren, includeUser, tripVacant, numAdults } = calculateTotalForms();

    if (!isValid) {
        if (firstInvalidSection === 'main') {
            currentSection = 0;
            showSection(currentSection);
        } else if (firstInvalidSection === 'passenger') {
            currentSection = 2; // Asume que la sección de pasajeros es la segunda sección principal
            showSection(currentSection);
            showPassengerForm(currentPassengerSection);
        } else if (firstInvalidSection === 'minor') {
            // Evitar que se vaya a la sección de niños si no se ha llenado la sección 1 y si la cantidad de niños es mayor o igual a la cantidad de cupos
            if (numChildren >= totalForms || numChildren < 0) {
                document.getElementById('errorMessagenumChildren').textContent = 'La cantidad de niños debe ser menor a la cantidad de cupos y mayor a 0.';
                currentSection = 0;
                showSection(currentSection);
            } else {
                currentSection = 3; // Asume que la sección de niños es la tercera sección principal
                showSection(currentSection);

                // Hacer que el botón titilee si está presente en el DOM
                const nextMinorButtonS = document.getElementById('ziseMineS');
                if (nextMinorButtonS) {
                    nextMinorButtonS.classList.add('highlight');   
                    setTimeout(() => {
                    nextMinorButtonS.classList.remove('highlight');
                }, 1500);
                }
                
                
            }
        }
        firstInvalidElement.focus();
    }

    // Prevenir envío del formulario si hay errores
    return isValid;
}


document.addEventListener('DOMContentLoaded', function() {
    // Limpiar mensajes de error para radio inputs
    document.querySelectorAll('input[name="includeUser"]').forEach(input => {
        input.addEventListener('click', function() { 
            document.getElementById('errorMessageincludeUser').textContent = "";
        });
    });

    document.querySelectorAll('input[name="includeMinor"]').forEach(input => {
        input.addEventListener('click', function() { 
            document.getElementById('errorMessageincludeMinor').textContent = "";
        });
    });

    // Limpiar mensajes de error para select inputs
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('errorMessage' + this.id).textContent = '';
        });
    });
});

function addBirthDateChangeListener(index) {
    const birthDateInput = document.getElementById(`birthDate${index}`);
    birthDateInput.addEventListener('change', function() {
        document.getElementById(`errorMessagebirthDate${index}`).textContent = '';
    });
}

function addEstadoChangeListener(index) {
    const estadoSelect = document.getElementById(`estado${index}`);
    estadoSelect.addEventListener('change', function() {
        document.getElementById(`errorMessageestado${index}`).textContent = '';
    });
}

function addMunicipioChangeListener(index) {
    const municipioSelect = document.getElementById(`municipio${index}`);
    municipioSelect.addEventListener('change', function() {
        document.getElementById(`errorMessagemunicipio${index}`).textContent = '';
    });
}

function addParroquiaChangeListener(index) {
    const parroquiaSelect = document.getElementById(`parroquia${index}`);
    parroquiaSelect.addEventListener('change', function() {
        document.getElementById(`errorMessageparroquia${index}`).textContent = '';
    });
}

function addDynamicFormListeners(index) {
    addBirthDateChangeListener(index);
    addEstadoChangeListener(index);
    addMunicipioChangeListener(index);
    addParroquiaChangeListener(index);
}


/* reinicia el mensaje de los niños */
function addAgeMinorChangeListener(index) {
    const ageMinorInput = document.getElementById(`ageMinor${index}`);
    ageMinorInput.addEventListener('input', function() {
        document.getElementById(`errorMessageageMinor${index}`).textContent = '';
    });
}
function addSexMinorChangeListener(index) {
    const sexMinorSelect = document.getElementById(`sexMinor${index}`);
    sexMinorSelect.addEventListener('change', function() {
        document.getElementById(`errorMessagesexMinor${index}`).textContent = '';
    });
}
function addResponsibleMinorChangeListener(index) {
    const responsibleMinorSelect = document.getElementById(`responsibleMinor${index}`);
    responsibleMinorSelect.addEventListener('change', function() {
        document.getElementById(`errorMessageresponsibleMinor${index}`).textContent = '';
    });
}


function addDynamicMinorFormListeners(index) {
    addAgeMinorChangeListener(index);
    addSexMinorChangeListener(index);
    addResponsibleMinorChangeListener(index);
}
