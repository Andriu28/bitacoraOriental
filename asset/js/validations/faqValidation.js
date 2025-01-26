function alertMessageDisappear(mse) {
    // Elimina el mensaje de error después de unos segundos
    let count = 5;
    const timer = setInterval(function() {
        count--;
        if (count < 0) {
            clearInterval(timer);
            mse.textContent = "";
        }
    }, 1000);
}

let Check = { ok: false };

const regexFaq = {
    query: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s _/.,#¿?-]+$/,
    respond: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ0-9\s_#/.,!¡-]+$/,
};

const regexMaxFaq = {
    query: 250,
    respond: 500
};

// Valida que los caracteres para cada campo sean los establecidos y verifica la longitud máxima
document.querySelectorAll('input[type="text"]').forEach(input => {
    const allowedCharacters = regexFaq[input.name]; // Obtiene la expresión regular según el nombre del campo

    input.addEventListener('keypress', function(e) {
        // Validación para el máximo de caracteres permitidos
        if (input.value.length >= regexMaxFaq[input.name]) {
            e.preventDefault();
            document.getElementById('errorMessage' + input.id).textContent = `El campo no debe exceder los ${regexMaxFaq[input.name]} caracteres`;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
            return;
        }

        // Valida que no se ingresen caracteres inválidos
        if (!allowedCharacters.test(e.key)) {
            e.preventDefault(); // Evita que el carácter no válido se añada
            document.getElementById('errorMessage' + input.id).textContent = `Caracter no válido para este campo`;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        } else {
            document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
        }
    });

    // Capitalizar la primera letra y convertir las demás en minúsculas
    input.addEventListener('input', function() {
        // Validación para el máximo de caracteres permitidos

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


    input.addEventListener('input', function() {
        // Validación para el máximo de caracteres permitidos
        if (input.value.length > regexMaxFaq[input.name]) {
            input.value = input.value.substring(0, regexMaxFaq[input.name]);
            document.getElementById('errorMessage' + input.id).textContent = `El campo no debe exceder los ${regexMaxFaq[input.name]} caracteres`;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        }
    });

    if (input.name === 'query') {
        input.addEventListener('input', function() {
            const firstChar = input.value.charAt(0);
            const allowedStart = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ#¿]/;
            if (!allowedStart.test(firstChar)) {
                document.getElementById('errorMessage' + input.id).textContent = "El campo no debe empezar con caracteres especiales";
                input.value = input.value.substring(1); // Elimina el primer carácter no permitido
                alertMessageDisappear(document.getElementById('errorMessage' + input.id));
            } else {
                document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
            }
        });
    }

    if (input.name === 'respond') {
        input.addEventListener('input', function() {
            const firstChar = input.value.charAt(0);
            const allowedStart = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ#¡]/;
            if (!allowedStart.test(firstChar)) {
                document.getElementById('errorMessage' + input.id).textContent = "El campo no debe empezar con caracteres especiales";
                input.value = input.value.substring(1); // Elimina el primer carácter no permitido
                alertMessageDisappear(document.getElementById('errorMessage' + input.id));
            } else {
                document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
            }
        });
    }
});

document.getElementById("faq").addEventListener("submit", function(event) {
    const input = document.querySelectorAll('input'); // Comprueba que los inputs distintos de los mencionados no se envíen vacíos

    for (const data of input) {
        if (data.name !== 'send' && data.name !== '' && data.name !== 'edit') { 
            Check = { ok: false };
            if (data.value.trim() === '') {
                document.getElementById('errorMessage' + data.id).textContent = "El campo no debe estar vacío";
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                data.focus();
                event.preventDefault();
                break;
            } else {
                document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
            }

            if (input.name === 'query' || input.name === 'respond') {
                input.addEventListener('input', function() {
                    const firstChar = input.value.charAt(0);
                    const allowedStart = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]/;
                    if (!allowedStart.test(firstChar)) {
                        document.getElementById('errorMessage' + input.id).textContent = "El campo no debe empezar con caracteres especiales";
                        input.value = input.value.substring(1); // Elimina el primer carácter no permitido
                        alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                    } else {
                        document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
                    }
                });
            }

            // Comprueba que los campos no se envíen con caracteres no válidos
            let allowedCharacters = regexFaq[data.name];
            if (!allowedCharacters.test(data.value)) {
                document.getElementById('errorMessage' + data.id).textContent = `Caracter no válido para este campo`;
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                data.focus();
                event.preventDefault();
                break;
            } else {
                document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
            }

            // Validación para el máximo de caracteres permitidos
            if (data.value.length > regexMaxFaq[data.name]) {
                document.getElementById('errorMessage' + data.id).textContent = `El campo no debe exceder los ${regexMaxFaq[data.name]} caracteres`;
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                data.focus();
                event.preventDefault();
                break;
            }
        }

        if (event.defaultPrevented) {
            // No se ha validado correctamente
        } else {
            Check.ok = true; // Si no se detecta un preventDefault significa que está validado
        }
    }
});
