function alertMessageDisappear(mse){
    let count = 5;
    const timer =  setInterval(function() {
    count--;

        if (count < 0) {
            clearInterval(timer);
            mse.textContent = "";
        }
    }, 1000);
 }

let Check = {ok:false}
/* Valida cada entrada de datos en el formulario para su llenado correcto en momento real */
const regexTrip = {
    title: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ0-9\s,!¡/.-]+$/,
    departureLocation: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ0-9\s/.,#-]+$/,
    numberSlots: /^[0-9]+$/,
    price: /^[0-9.,]+$/,
};

const regexMaxTrip = {
    title: 50,
    departureLocation: 100,
};

// Valida que los caracteres para cada campo sean los establecidos y verifica la longitud máxima
document.querySelectorAll('input[type="text"]').forEach(input => { // Valida que no se tecleen ni peguen caracteres no permitidos
    const allowedCharacters = regexTrip[input.name]; // Obtiene la expresión regular según el nombre del campo

    input.addEventListener('keypress', function(e) {
        // Validación para el máximo de caracteres permitidos
        if (input.value.length >= regexMaxTrip[input.name]) {
            e.preventDefault();
            document.getElementById('errorMessage' + input.id).textContent = `El campo no debe exceder los ${regexMaxTrip[input.name]} caracteres`;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
            return;
        }

        if (!allowedCharacters.test(e.key)) {
            e.preventDefault(); // Evita que el carácter no válido se añada
            document.getElementById('errorMessage' + input.id).textContent = `Caracter no válido para este campo`;
        } else {
            document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
        }
        alertMessageDisappear(document.getElementById('errorMessage' + input.id));
    });

    input.addEventListener('input', function() {
        // Validación para el máximo de caracteres permitidos
        if (input.value.length > regexMaxTrip[input.name]) {
            input.value = input.value.substring(0, regexMaxTrip[input.name]);
            document.getElementById('errorMessage' + input.id).textContent = `El campo no debe exceder los ${regexMaxTrip[input.name]} caracteres`;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        }

        let value = input.value;
        if (value.length > 0) {
            // Busca la primera letra válida y la capitaliza
            let firstLetterIndex = [...value].findIndex(char => /[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]/.test(char));
            if (firstLetterIndex !== -1) {
                input.value = value.slice(0, firstLetterIndex) +
                              value.charAt(firstLetterIndex).toUpperCase() +
                              value.slice(firstLetterIndex + 1);
            }
        }
    });

    input.addEventListener('paste', function(e) {
        e.preventDefault(); // Evita que se pegue texto directamente
        // Obtiene el texto del portapapeles
        const clipboardData = (e.clipboardData || window.clipboardData).getData('text');
        // Verifica si todos los caracteres del texto son válidos
        if (allowedCharacters.test(clipboardData) && clipboardData.length <= regexMaxTrip[input.name]) {
            // Si son válidos, inserta el texto en el campo
            document.execCommand('insertText', false, clipboardData);
            document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
        } else {
            document.getElementById('errorMessage' + input.id).textContent = `El texto pegado contiene caracteres no válidos o excede la longitud máxima permitida (${regexMaxTrip[input.name]} caracteres)`;
        }
        alertMessageDisappear(document.getElementById('errorMessage' + input.id));
    });
});

// Comprueba que los inputs title, salida, price y number no empiecen con caracteres especiales
document.querySelectorAll('input[type="text"]').forEach(input => {
    if (input.name === 'title') {
        input.addEventListener('input', function() {
            const firstChar = input.value.charAt(0);
            const allowedStart = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ¡]/;
            if (!allowedStart.test(firstChar)) {
                document.getElementById('errorMessage' + input.id).textContent = "El campo no debe empezar con caracteres especiales";
                input.value = input.value.substring(1); // Elimina el primer carácter no permitido
            } else {
                document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
            }
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        });
    }
    if (input.name === 'departureLocation') {
        input.addEventListener('input', function() {
            const firstChar = input.value.charAt(0);
            const allowedStart = /^[0-9a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]/;
            if (!allowedStart.test(firstChar)) {
                document.getElementById('errorMessage' + input.id).textContent = "El campo no debe empezar con caracteres especiales";
                input.value = input.value.substring(1); // Elimina el primer carácter no permitido
            } else {
                document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
            }
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        });
    }
    if ((input.name === 'price') || (input.name === 'numberSlots')) {
        input.addEventListener('input', function() {
            const firstChar = input.value.charAt(0);
            const allowedStart = /^[0-9]/;
            if (!allowedStart.test(firstChar)) {
                document.getElementById('errorMessage' + input.id).textContent = "El campo no debe empezar con caracteres especiales";
                input.value = input.value.substring(1); // Elimina el primer carácter no permitido
            } else {
                document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
            }
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        });
    }
});

////////////////////////////////validacion de la fecha actual
document.addEventListener('DOMContentLoaded', function() {
    // Obtiene la fecha actual en formato YYYY-MM-DD
    const today = new Date().toISOString().split('T')[0]; 
    const departureDateInput = document.getElementById('departureDate');
    const returnDateInput = document.getElementById('returnDate');

    // Establece la fecha mínima para el campo de fecha de salida
    departureDateInput.setAttribute('min', today);
    // Deshabilita el campo de fecha de retorno inicialmente
    returnDateInput.setAttribute('disabled', true);

    departureDateInput.addEventListener('change', function() {
        if (this.value) {
            // Habilitar el campo de retorno cuando se selecciona la fecha de salida
            returnDateInput.removeAttribute('disabled');
            // Establece la fecha mínima para el campo de fecha de retorno
            returnDateInput.setAttribute('min', this.value);
        } else {
            // Si se elimina la fecha de salida, deshabilitar el campo de retorno
            returnDateInput.setAttribute('disabled', true);
            returnDateInput.value = "";
        }

        // Verifica si la fecha de retorno es válida
        if (returnDateInput.value && returnDateInput.value < this.value) {
            document.getElementById('errorMessagereturnDate').textContent = "La fecha de retorno no puede ser anterior a la fecha de salida.";
            alertMessageDisappear(document.getElementById('errorMessagedepartureDate'));
        } else {
            document.getElementById('errorMessagedepartureDate').textContent = "";
        }
        alertMessageDisappear(document.getElementById('errorMessagedepartureDate'));
    });

    returnDateInput.addEventListener('change', function() {
        // Verifica si la fecha de retorno es anterior a la fecha de salida
        if (this.value < departureDateInput.value) {
            document.getElementById('errorMessagereturnDate').textContent = "La fecha de retorno no puede ser anterior a la fecha de salida.";
            this.value = ""; // Limpia el campo de retorno si la fecha es inválida
        } else {
            document.getElementById('errorMessagereturnDate').textContent = ""; // Limpia el mensaje de error
        }
        alertMessageDisappear(document.getElementById('errorMessagereturnDate'));
    });
});

////////////////////////evento change de tiempo
document.getElementById('departureTime').addEventListener('change', function() {
    document.getElementById('errorMessagedepartureTime').textContent = ""; // Limpia el mensaje de error
});
document.getElementById('returnTime').addEventListener('change', function() {
    document.getElementById('errorMessagereturnTime').textContent = ""; // Limpia el mensaje de error
});
////////////////////////////// para los changes en los check borrar el mensaje
document.querySelectorAll('input[name="idRoute"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('errorMessageidRoute').textContent = ""; // Limpia el mensaje de error al seleccionar una ruta
    });
});
document.querySelectorAll('input[name="idPackages[]"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('errorMessageidPackages').textContent = ""; // Limpia el mensaje de error al seleccionar un paquete
    });
});
///////////////* valida si el formulario esta bien al momento de enviar */
///////////////* valida si el formulario esta bien al momento de enviar */
document.getElementById("trip").addEventListener("submit", function(event) {
    Check = { ok: false }; // Inicializa la variable Check
    let firstInvalidSection = null;

    const inputs = document.querySelectorAll('input');
    for (const data of inputs) {
        if (data.name !== 'send' && data.name !== 'vacant' && data.name !== 'cuposantes' && data.name !== '' && data.name !== 'idRoute' && data.name !== 'edit' && data.name !== 'idPackages[]') {
            if (data.value.trim() === '') {
                document.getElementById('errorMessage' + data.id).textContent = "El campo no debe estar vacío";
                data.focus();
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                event.preventDefault();
                if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                break;  
            } else {
                document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
            }
        }    

        if (data.name === 'title') { // Comprueba que los campos no empiecen con caracteres especiales
            const valueData = data.value[0];
            const allowed = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ¡]+$/;
            if (!allowed.test(valueData)) {
                document.getElementById('errorMessage' + data.id).textContent = "El campo no debe empezar con caracteres especiales";
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                data.focus();
                event.preventDefault();
                if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                break;
            } else {
                document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
            }
        }

        if (data.name === 'price' || data.name === 'numberSlots') { // Comprueba que los campos no empiecen con caracteres especiales
            const valueData = data.value[0];
            const allowed = /^[0-9]+$/;
            if (!allowed.test(valueData)) {
                document.getElementById('errorMessage' + data.id).textContent = "El campo no debe empezar con caracteres especiales";
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                data.focus();
                event.preventDefault();
                if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                break;
            } else {
                document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
            }
        }

        if (data.name === 'numberSlots') { // Comprueba que el campo no se envíe siendo cero o negativo
            if (data.value < 1) {
                document.getElementById('errorMessage' + data.id).textContent = "La cantidad de cupos no puede ser cero";
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                data.focus();
                event.preventDefault();
                if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                break;
            } else {
                document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
            }
        }  
    }

    const selectedRoute = document.querySelector('input[name="idRoute"]:checked');
    if (!selectedRoute) {
        document.getElementById('errorMessageidRoute').textContent = "Debe seleccionar una ruta.";
        alertMessageDisappear(document.getElementById('errorMessageidRoute'));
        event.preventDefault();
        if (!firstInvalidSection) firstInvalidSection = document.querySelector('input[name="idRoute"]').closest('.form-section');
    } else {
        document.getElementById('errorMessageidRoute').textContent = "";
    }

    const selectedPackages = document.querySelectorAll('input[name="idPackages[]"]:checked');
    if (selectedPackages.length === 0) {
        document.getElementById('errorMessageidPackages').textContent = "Debe seleccionar al menos un paquete.";
        alertMessageDisappear(document.getElementById('errorMessageidPackages'));
        event.preventDefault();
        if (!firstInvalidSection) firstInvalidSection = document.querySelector('input[name="idPackages[]"]').closest('.form-section');
    } else {
        document.getElementById('errorMessageidPackages').textContent = "";
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
