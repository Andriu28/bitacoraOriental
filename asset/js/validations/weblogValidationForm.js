function alertMessageDisappear(mse) {
    let count = 5;
    const timer = setInterval(function() {
        count--;
        if (count < 0) {
            clearInterval(timer);
            mse.textContent = "";
        }
    }, 1000);
}

let Check = { ok: false }

/* Valida cada entrada de datos en el formulario para su llenado correcto en momento real */
const regexLog = {
    description: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ0-9\s,!¡*@#+.\-_,¿?()]+$/, // Permitir saltos de línea
    numberTravel: /^[0-9]+$/,
    images: /\.(jfif|jpeg|jpg|png)$/i
};

const regexMaxLog = {
    description: 250,
    numberTravel: 4
};

// Valida que los caracteres para cada campo sean los que se establecen
document.querySelectorAll('input[type="text"], textarea').forEach(input => {
    const allowedCharacters = regexLog[input.name]; // Obtiene la expresión regular según el nombre del campo

    input.addEventListener('keypress', function(e) {
        // Validación para el máximo de caracteres permitidos
        if (input.value.length >= regexMaxLog[input.name]) {
            e.preventDefault();
            document.getElementById('errorMessage' + input.id).textContent = `El campo no debe exceder los ${regexMaxLog[input.name]} caracteres`;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
            return;
        }

        if (!allowedCharacters.test(e.key)) {
            e.preventDefault(); // Evita que el carácter no válido se añada
            document.getElementById('errorMessage' + input.id).textContent = `Caracter no válido para este campo`;
            //if (!firstInvalidSection) firstInvalidSection = input.closest('.form-section');
        } else {
            document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
        }
        alertMessageDisappear(document.getElementById('errorMessage' + input.id));
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
        if (input.value.length > regexMaxLog[input.name]) {
            input.value = input.value.substring(0, regexMaxLog[input.name]);
            document.getElementById('errorMessage' + input.id).textContent = `El campo no debe exceder los ${regexMaxLog[input.name]} caracteres`;
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
        }
    });

    input.addEventListener('paste', function(e) {
        e.preventDefault(); // Evita que se pegue texto directamente
        // Obtiene el texto del portapapeles
        const clipboardData = (e.clipboardData || window.clipboardData).getData('text');
        // Verifica si todos los caracteres del texto son válidos
        if (allowedCharacters.test(clipboardData) && clipboardData.length <= regexMaxLog[input.name]) {
            // Si son válidos, inserta el texto en el campo
            document.execCommand('insertText', false, clipboardData);
            document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
        } else {
            document.getElementById('errorMessage' + input.id).textContent = `El texto pegado contiene caracteres no válidos o excede la longitud máxima permitida (${regexMaxLog[input.name]} caracteres)`;
           // if (!firstInvalidSection) firstInvalidSection = input.closest('.form-section');
        }
        alertMessageDisappear(document.getElementById('errorMessage' + input.id));
    });
});

document.getElementById('images').addEventListener('change', function(e) {
    const files = e.target.files;
    const allowedCharacters = regexLog['images'];
    for (const file of files) {
        if (!allowedCharacters.test(file.name)) {
            document.getElementById('errorMessageimage').textContent = "Formato de archivo no válido";
            e.target.value = ''; // Limpia el campo de archivos
            Swal.fire({
                confirmButtonColor: "#27a027",
                width: "25em",
                padding: "1em",   
                text: "Comprueba la extensión de tus imágenes. Los formatos aceptados son .jfif, .jpeg, .jpg, .png",
                icon: "info",
            });
            if (!firstInvalidSection) firstInvalidSection = e.target.closest('.form-section');
            break;
        } else {
            document.getElementById('errorMessageimage').textContent = ""; // Limpia el mensaje de error
        }
    }
});

const formWeblog = document.getElementById("formWebLog");

formWeblog.addEventListener("submit", function(event) {
    let firstInvalidSection = null;
    Check = {ok: false}; // Inicializa la variable Check

    const inputs = document.querySelectorAll('input, textarea');
    for (const data of inputs) { 
        if (data.name !== 'send' && data.name !== 'UpdateImage[]' && data.name !== 'images[]' && data.name !== 'idTravelOffer' && data.name !== '' && data.id !== 'theme-toggle' && data.id !== "dt-search-0") {
            if (data.value.trim() === '') {
                document.getElementById('errorMessage' + data.id).textContent = "El campo no debe estar vacío";
                data.focus();
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                event.preventDefault();
                break;  
            } else {           
                document.getElementById('errorMessage' + data.id).textContent = ""; // Limpia el mensaje de error
            }

            // Validar caracteres no permitidos
            const allowedCharacters = regexLog[data.name];
            if (!allowedCharacters.test(data.value)) {
                document.getElementById('errorMessage' + data.id).textContent = "El campo contiene caracteres no válidos";
                data.focus();
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                event.preventDefault();
                break;
            }

            // Validar longitud máxima
            if (data.value.length > regexMaxLog[data.name]) {
                document.getElementById('errorMessage' + data.id).textContent = `El campo no debe exceder los ${regexMaxLog[data.name]} caracteres`;
                data.focus();
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                if (!firstInvalidSection) firstInvalidSection = data.closest('.form-section');
                event.preventDefault();
                break;
            }
        }    
    }

    const aux = formWeblog.getAttribute('edit') ? formWeblog.getAttribute('edit') : null;
    const updateImages = document.querySelectorAll('input[name="UpdateImage[]"]');
    const imageInput = document.getElementById('images') ? document.getElementById('images') : document.getElementById('images');

    if (aux === null) {
        if (imageInput.files.length === 0) {
            document.getElementById('errorMessageimage').textContent = "Debe seleccionar al menos una imagen.";
            alertMessageDisappear(document.getElementById('errorMessageimage'));
            if (!firstInvalidSection) firstInvalidSection = imageInput.closest('.form-section');
            event.preventDefault();
            if (firstInvalidSection) { 
                document.querySelector('.form-section.active').classList.remove('active');
                firstInvalidSection.classList.add('active');
                currentSection = Array.from(sections).indexOf(firstInvalidSection); 
            }
            return;
        } else {
            document.getElementById('errorMessageimage').textContent = "";
        }
    } else if (updateImages.length === 0 && imageInput.files.length === 0) {
        document.getElementById('errorMessageimage').textContent = "Debe mantener al menos una imagen seleccionada.";
        alertMessageDisappear(document.getElementById('errorMessageimage'));
        if (!firstInvalidSection) firstInvalidSection = document.getElementById('currentImages').closest('.form-section');
        event.preventDefault();
        if (firstInvalidSection) { 
            document.querySelector('.form-section.active').classList.remove('active');
            firstInvalidSection.classList.add('active');
            currentSection = Array.from(sections).indexOf(firstInvalidSection); 
        }
        return;
    } else {
        document.getElementById('errorMessageimage').textContent = "";
    }

    const selectedOffer = document.querySelector('input[name="idTravelOffer"]:checked') ? document.querySelector('input[name="idTravelOffer"]:checked') : null;
    if(selectedOffer !== null){
        if (!selectedOffer) {
            document.getElementById('errorMessageidTravelOffer').textContent = "Debe seleccionar una oferta de viaje.";
            alertMessageDisappear(document.getElementById('errorMessageidTravelOffer'));
            if (!firstInvalidSection) firstInvalidSection = document.querySelector('input[name="idTravelOffer"]').closest('.form-section');
            event.preventDefault();
            if (firstInvalidSection) { 
                document.querySelector('.form-section.active').classList.remove('active');
                firstInvalidSection.classList.add('active');
                currentSection = Array.from(sections).indexOf(firstInvalidSection); 
            }
            return;
        } else {
            document.getElementById('errorMessageidTravelOffer').textContent = "";
        }
    }else{

        event.preventDefault();
        document.getElementById('errorMessageidTravelOffer').textContent = "No hay oferta de viaje para seleccionar.";
        if (!firstInvalidSection) firstInvalidSection =  document.getElementById('errorMessageidTravelOffer').closest('.form-section');
        if (firstInvalidSection) { 
            document.querySelector('.form-section.active').classList.remove('active');
            firstInvalidSection.classList.add('active');
            currentSection = Array.from(sections).indexOf(firstInvalidSection); 
        }
        return;
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
// Limpia la vista previa con el botón de limpiar
document.querySelector('.reset-button').addEventListener('click', function() {
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    imagePreviewContainer.style.visibility = 'hidden';
});
