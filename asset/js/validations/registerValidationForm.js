// Función para eliminar el mensaje de error después de unos segundos
function alertMessageDisappear(msgElement) {
    let count = 5;
    const timer = setInterval(function() {
        count--;
        if (count < 0) {
            clearInterval(timer);
            msgElement.textContent = "";
        }
    }, 1000);
}
let Check = {ok:false}
// Mapas de expresiones regulares y otros parámetros para validación
const regexMap = {
    ci: /^[0-9]+$/,
    name: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+$/,
    lastName: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/,
    phone: /^[0-9]+$/,
    email: /^[a-zA-Z0-9áéíóúÁÉÍÓÚüÜñÑ._%+\-@]+$/,
    address: /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚüÜñÑ._%\-@,°]+$/,
    birthDate: /^\d{4}-\d{2}-\d{2}$/,
    password: /^[a-zA-Z0-9\-_.,$%#!¡?+@]+$/,
    
};

const regexMapMix = {
    ci: /^[0-9]+$/,
    name: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+$/,
    lastName: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/,
    phone: /^[0-9]*$/,
    email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,20}$/,
    address: /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚüÜñÑ._%\-@,°]+$/,
    birthDate: /^\d{4}-\d{2}-\d{2}$/,
    password: /^(?=.*[A-Za-z])(?=.*\d)(?=.*[\-_.,:$%#!¡?+@]).+$/,
   
};

const regexMIN = {
    ci: 7,
    name: 2,
    lastName: 2,
    phone: 11,
    email: 3,
    address: 5,
    password: 8,
    repPassword: 8
};

const regexMAX = {
    ci: 8,
    name: 15,
    lastName: 15,
    phone: 11,
    email: 100,
    address: 100,
    password: 16,
    repPassword: 16
};

const regexError = {
    ci: "Solo debe contener números",
    name: "No debe tener caracteres especiales",
    lastName: "No debe tener caracteres especiales",
    phone: "No debe tener caracteres especiales, ejemplo 04241234567, 04121234567",
    email: "El correo no es adecuado, ejemplo: nombre@gmail.com, nombre@hotmail.com",
    address: "La dirección contiene caracteres no válidos",
    birthDate: "Ingrese una fecha valida",
    password: "Utilice solo caracteres permitidos: - _ . , : $ % # ! ¡ ? + @",
    Bpassword: "La contraseña debe tener al menos un número, una letra y un carácter especial permitido: - _ . , : $ % # ! ¡ ? + @",
    Bphone: "La longitud máxima del teléfono debe ser de 11 dígitos"
};

document.querySelectorAll('input').forEach(input => {
    const allowedCharacters = regexMap[input.name];
    
    input.addEventListener('paste', function(e) {
        if(input.name !== 'repPassword'){            
            e.preventDefault();
            const clipboardData = (e.clipboardData || window.clipboardData).getData('text');
            if (allowedCharacters.test(clipboardData)) {
                document.execCommand('insertText', false, clipboardData);
                document.getElementById('errorMessage' + input.id).textContent = "";
            } else {
                document.getElementById('errorMessage' + input.id).textContent = `El texto pegado contiene caracteres no válidos`;
            }
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        }
    });
    
    input.addEventListener('keypress', function(e) {
        if (input.value.length >= regexMAX[input.name]) {
            e.preventDefault();
                return;
            }
            
        if(input.name !== 'repPassword' && input.name !== 'birthDate' ){    
            if (!regexMap[input.name].test(e.key)) {
                document.getElementById('errorMessage' + input.id).textContent = regexError[input.name];
                e.preventDefault();
            } else {
                document.getElementById('errorMessage' + input.id).textContent = "";
            }
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        }
    });
    input.addEventListener('keydown', function(event) {
        if (event.keyCode === 8 || event.keyCode === 127 || event.keyCode === 46) {
            document.getElementById('errorMessage' + input.id).textContent = "";
            return;
        }
    });
   
});
 // Capitalizar la primera letra y convertir las demás en minúsculas
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input');
    
        inputs.forEach(function(input) {
            if ( input.id !== 'email' && input.id !== 'password' && input.id !== 'repPassword') {
                input.addEventListener('input', function() {
                    let value = input.value;
                    if (value.length > 0) {
                        let firstLetterIndex = [...value].findIndex(char => /[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]/.test(char));
                        if (firstLetterIndex !== -1) {
                            input.value = value.slice(0, firstLetterIndex) +
                                          value.charAt(firstLetterIndex).toUpperCase() +
                                          value.slice(firstLetterIndex + 1);
                        }
                    }
                });
            }
        });
    });

document.addEventListener('DOMContentLoaded', (event) => {
    let birthDateInput = document.getElementById('birthDate');
    let today = new Date().toISOString().split('T')[0]; // Obtener la fecha actual en formato YYYY-MM-DD
    birthDateInput.setAttribute('max', today); // Establecer la fecha máxima
});

// Validación de los campos a través de las etiquetas input en el envío del formulario
document.getElementById("formRegister").addEventListener("submit", function(event) {
    Check = {ok:false}
    const inputs = document.querySelectorAll('input , select');
    let firstInvalidSection = null;
    let password = null;
    let repPassword = null;    

    for (const input of inputs) {
        if (input.name === 'ci' || input.name === 'name' || input.name === 'lastName' || input.name === 'phone' || input.name === 'email' || input.name === 'address' || input.name === 'birthDate' || input.name === 'password' || input.name === 'repPassword' && (input.name !== 'send' && input.name !== '' && input.id !== 'theme-toggle')) {
            
            // Verifica si el campo está vacío (excepto el campo teléfono que puede ser 'POR ASIGNAR')
            if (input.name !== 'phone' && input.value.trim() === '') {
                document.getElementById('errorMessage' + input.id).textContent = "El campo no debe estar vacío";
                alertMessageDisappear(document.getElementById('errorMessage' + input.id));
                input.focus();
                event.preventDefault();
                if (!firstInvalidSection) firstInvalidSection = input.closest('.form-section');
                break;
            }

            let error = regexError[input.name];
            if (input.name === 'password' || input.name === 'repPassword') { error = regexError['Bpassword']; }

            let allowed = regexMapMix[input.name];
            if (input.name !== 'phone' && input.name !== 'repPassword' ){
                // Validación del formato de los datos
                if (!allowed.test(input.value)) {
                    document.getElementById('errorMessage' + input.id).textContent = error;
                    alertMessageDisappear(document.getElementById('errorMessage' + input.id));
                    input.focus();
                    if (!firstInvalidSection) firstInvalidSection = input.closest('.form-section');
                    event.preventDefault();
                    break;
                }
            }
            // Validación del número de teléfono
            if (input.name === 'phone' ) {
                if (input.value === '') { input.value = 'POR ASIGNAR'; }
                const phoneCode = ["0414", "0424", "0412", "0416", "0426", "0294", "POR ASIGNAR"];
                let valid = false;
                for (const code of phoneCode) {
                    if (input.value.startsWith(code)) {
                        valid = true;
                        break;
                    }
                }
                if (!valid) {
                    document.getElementById('errorMessage' + input.id).textContent = 'El número de teléfono debe comenzar con: "0414", "0424", "0412", "0416", "0426", "0294"';
                    alertMessageDisappear(document.getElementById('errorMessage' + input.id));
                    input.focus();
                    if (!firstInvalidSection) firstInvalidSection = input.closest('.form-section');
                    event.preventDefault();
                    break;
                }
            }

            // Validación de la longitud de los datos
            error = `Debe tener entre ${regexMIN[input.name]} y ${regexMAX[input.name]} caracteres`;
            if (input.name === 'phone') { error = regexError['Bphone']; }
            const dataValue = input.value.trim();
            if (dataValue.length < regexMIN[input.name] || dataValue.length > regexMAX[input.name]) {
                document.getElementById('errorMessage' + input.id).textContent = error;
                input.focus();
                if (!firstInvalidSection) firstInvalidSection = input.closest('.form-section');
                event.preventDefault();
                break;
            }

            // Validación especial para la fecha de nacimiento
            if (input.name === 'birthDate') {
                const birthDate = input.value;
                const regex = /^\d{4}-\d{2}-\d{2}$/; // Verificar formato de fecha (YYYY-MM-DD)
                let errorMessage = '';
                let isValid = true;
            
                if (!regex.test(birthDate)) {
                    errorMessage = "Formato de fecha no válido. El formato correcto es YYYY-MM-DD.";
                    isValid = false;
                } else {
                    const birthDateObj = new Date(birthDate);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Normalizar a la medianoche para comparar solo fechas
                    const hundredYearsAgo = new Date();
                    hundredYearsAgo.setFullYear(today.getFullYear() - 100);
            
                    if (birthDateObj < hundredYearsAgo || birthDateObj >= today) {
                        errorMessage = "La fecha de nacimiento no puede ser de hace más de 100 años, ni la fecha del día actual, ni futura.";
                        isValid = false;
                    } else {
                        let diferenciaAnios = today.getFullYear() - birthDateObj.getFullYear();
                        const cumpleAniosEsteAnio = new Date(today.getFullYear(), birthDateObj.getMonth(), birthDateObj.getDate());
                        if (cumpleAniosEsteAnio > today) {
                            diferenciaAnios--;
                        }
                        if (diferenciaAnios < 18) {
                            errorMessage = "Debes tener al menos 18 años.";
                            isValid = false;
                        }
                    }
                }            
                if (!isValid) {
                    document.getElementById('errorMessage' + input.id).textContent = errorMessage;
                    alertMessageDisappear(document.getElementById('errorMessage' + input.id));
                    input.focus();
                    if (!firstInvalidSection) firstInvalidSection = input.closest('.form-section');
                    event.preventDefault();
                    break;
                }
            }
            
            // Validación de la coincidencia de contraseñas
            if (input.name === 'password') {
                password = input;
                repPassword = document.getElementById("repPassword") ? document.getElementById("repPassword").value : null;
                if (password.value !== repPassword && (password.value !== null || repPassword !== null)) {
                    document.getElementById('errorMessagerepPassword').textContent = "La contraseña no coincide";
                    alertMessageDisappear(document.getElementById('errorMessagerepPassword'));
                    input.focus();
                    if (!firstInvalidSection) firstInvalidSection = input.closest('.form-section');
                    event.preventDefault();
                    break;
                }
            }
        }
    }

      

    const cbxParroquia = document.getElementById('parroquia'); // Comprobar que el select no quede vacío al enviar el formulario
    if (cbxParroquia.value === '') {
        document.getElementById('errorMessageparroquia').textContent = "El campo no debe estar vacío";
        alertMessageDisappear(document.getElementById('errorMessageparroquia'));
        if (!firstInvalidSection) firstInvalidSection = cbxParroquia.closest('.form-section');
        event.preventDefault();
    } else {
        document.getElementById('errorMessageparroquia').textContent = ""; // Limpia el mensaje de error
    }
    if (!event.defaultPrevented) {
        Check.ok = true; // Si no se detecta un preventDefault, significa que está validado
    }

    if (firstInvalidSection) { 
        document.querySelector('.form-section.active').classList.remove('active');
        firstInvalidSection.classList.add('active');
        currentSection = Array.from(sections).indexOf(firstInvalidSection); 
    }
        
    
});




