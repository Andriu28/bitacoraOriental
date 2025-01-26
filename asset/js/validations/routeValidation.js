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

const regexRoute = {
    place: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ0-9\s _/.,-]+$/,
    location: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ0-9\s _/.,-]+$/,
    description: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ0-9\s¡!#-/_()@$.,¿?]+$/,
    alfa: /^[a-zA-Z0-9¿!]+$/
};

const regexMaxRoute = {
    place: 80,
    location: 80,
    description: 500
};

// Valida que los caracteres para cada campo sean los establecidos y verifica la longitud máxima
document.querySelectorAll('input[type="text"]').forEach(input => {
    const allowedCharacters = regexRoute[input.name]; // Obtiene la expresión regular según el nombre del campo

    input.addEventListener('keypress', function(e) {
        // Validación para el máximo de caracteres permitidos
        if (input.value.length >= regexMaxRoute[input.name]) {
            e.preventDefault();
            document.getElementById('errorMessage' + input.id).textContent = `El campo no debe exceder los ${regexMaxRoute[input.name]} caracteres`;
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

    if (input.name === 'place' || input.name === 'location') {
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

    // Capitalizar la primera letra y convertir las demás en minúsculas
    input.addEventListener('input', function() {
        // Validación para el máximo de caracteres permitidos
        if (input.value.length > regexMaxRoute[input.name]) {
            input.value = input.value.substring(0, regexMaxRoute[input.name]);
            document.getElementById('errorMessage' + input.id).textContent = `El campo no debe exceder los ${regexMaxRoute[input.name]} caracteres`;
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
        if (allowedCharacters.test(clipboardData) && clipboardData.length <= regexMaxRoute[input.name]) {
            // Si son válidos, inserta el texto en el campo
            document.execCommand('insertText', false, clipboardData);
            document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
        } else {
            document.getElementById('errorMessage' + input.id).textContent = `El texto pegado contiene caracteres no válidos o excede la longitud máxima permitida (${regexMaxRoute[input.name]} caracteres)`;
        }
        alertMessageDisappear(document.getElementById('errorMessage' + input.id));
    });
});

// Valida que la imagen sea del formato que establece y ofrece una vista previa o limpia los campos según el caso
document.querySelector("#image").addEventListener("change", function(event) {
    var file = event.target.files[0];
    var imagePreview = document.getElementById('imagePreview');

    if (!file || !(/\.(jfif|jpeg|jpg|png)$/i.test(file.name))) { // Comprueba si la extensión es válida
        event.preventDefault(); // Cancela la carga del archivo
        document.getElementById("image").value = ""; // Limpia el campo de entrada
        imagePreview.style.display = 'none'; // Oculta la vista previa
        imagePreview.src = ""; // Limpia la fuente de la imagen
        document.getElementById('errorMessageimage').textContent = "Formato de archivo no válido.";
        Swal.fire({
            confirmButtonColor: "#27a027",
            width: "25em",
            padding: "1em",
            text: "Comprueba la extensión de tus imágenes. Los formatos aceptados son .jfif, .jpeg, .jpg, .png",
            icon: "info",
        });
    } else {
        imagePreview.style.display = 'block';
        imagePreview.src = URL.createObjectURL(file);
        document.getElementById('errorMessageimage').textContent = "";
    }
    alertMessageDisappear(document.getElementById('errorMessageimage'));
}, false);

// Limpia la vista previa con el botón de limpiar
document.querySelector('.reset-button').addEventListener('click', function() {
    document.getElementById('imagePreview').src = '';
    document.getElementById('imagePreview').alt = '';
});

// Limpia el mensaje de error de parroquia al ser seleccionado
document.getElementById('parroquia').addEventListener('change', function() {
    document.getElementById('errorMessageparroquia').textContent = ""; // Limpia el mensaje de error
});

//////////////////////////////////////////////////

// Valida que al enviar el formulario no haya campos vacíos al enviar
document.getElementById("route").addEventListener("submit", function(event) {
    Check = { ok: false };
    let firstInvalidSection = null;
    const cbxParroquia = document.getElementById('parroquia'); // Comprobar que el select no quede vacío al enviar el formulario
    if (cbxParroquia.value === '') {
        document.getElementById('errorMessageparroquia').textContent = "El campo no debe estar vacío";
        alertMessageDisappear(document.getElementById('errorMessageparroquia'));
        event.preventDefault();
        if (!firstInvalidSection) firstInvalidSection = cbxParroquia.closest('.form-section');
    } else {
        document.getElementById('errorMessageparroquia').textContent = ""; // Limpia el mensaje de error
    }

    const input = document.querySelectorAll('input'); // Comprueba que los inputs distintos de los mencionados no se envíen vacíos
    for (const data of input) {
        if (data.name !== 'send' && data.name !== '' && data.name !== 'edit' && data.name !== 'estado' && data.name !== 'municipio' && data.name !== 'backup') {
            if (data.value.trim() === '') {
                document.getElementById('errorMessage' + data.id).textContent = "El campo no debe estar vacío";
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                data.focus();
                event.preventDefault();
                if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                break;
            } else {
                document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
            }

            if ((data.name === 'place') || (data.name === 'location')) { // Comprueba que los inputs lugar y calle no empiecen con caracteres especiales
                const valueData = data.value[0];
                const allowedStart = /^[0-9a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]/;
                if (!allowedStart.test(valueData)) {
                    document.getElementById('errorMessage' + data.id).textContent = "El campo no debe empezar con caracteres especiales";
                    data.value = data.value.substring(1);
                    alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                    event.preventDefault();
                    if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                    break;
                } else {
                    document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
                }
            }

            // Comprueba que los campos no se envíen con caracteres no válidos
            let allowedCharacters = regexRoute[data.name];
            if (data.name !== 'send' && data.name !== '' && data.name !== 'edit' && data.name !== 'estado' && data.name !== 'municipio' && data.name !== 'parroquia' && data.name !== 'image' && data.name !== 'backup') {
                if (!allowedCharacters.test(data.value)) {
                    document.getElementById('errorMessage' + data.id).textContent = `Caracter no válido para este campo`;
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

        if (data.name === 'backup') break;
    }

    if (firstInvalidSection) {
        document.querySelector('.form-section.active').classList.remove('active');
        firstInvalidSection.classList.add('active');
        currentSection = Array.from(sections).indexOf(firstInvalidSection);
    }

    if (!event.defaultPrevented) {
        Check.ok = true; // Si no se detecta un preventDefault, significa que está validado
    }
});

