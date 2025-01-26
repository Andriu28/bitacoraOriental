function alertMessageDisappear(mse){ //elimina el mensaje de error despues de unos segundos
    let count = 5;
    const timer =  setInterval(function() {
    count--;

        if (count < 0) {
            clearInterval(timer);
            mse.textContent = "";
        }
    }, 1000);
}


let Check = {ok:false}// variabe para indicar que el formulario esta correctamente validado

// Mapa de expresiones regulares
/*constante para validar caracteres especiales, se utiliza dos veces */
const regexMap ={// de esta manera se pueden validar diferentes expreciones regulares segun sea necesario
    title: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/,
    description: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\-()@$.,!¡¿?\s0-9]+$/,
    price : /^[0-9,.]+$/,
    Bprice : /^[0-9]+([,.][0-9]+)?$/,
    //se pueden agregar mas expreciones regulares
};


const regexMAX ={
    title: 30,
    description: 240,
    price : 8
}

const regexError ={
    title: "El campo no debe empezar con caracteres especiales",    
    description: 'El campo no debe empezar con caracteres especiales',
    price : "El precio no puede poseer letras, símbolos ni ser negativo. Ejemplo: 10 , 10,99 , 10.99"
}
//validacion en tiempo real de caracteres especiales 
document.querySelectorAll('input[type="text"]').forEach(input => {
    const allowedCharacters = regexMap[input.name]; //  Obtiene la expresión regular según el nombre del campo
    input.addEventListener('paste', function(e) {
        e.preventDefault(); // Evita que se pegue texto directamente
        // Obtiene el texto del portapapeles
        const clipboardData = (e.clipboardData || window.clipboardData).getData('text');  
        // Verifica si todos los caracteres del texto son válidos
        if (allowedCharacters.test(clipboardData)) {
            // Si son válidos, inserta el texto en el campo
            document.execCommand('insertText', false, clipboardData);
            document.getElementById('errorMessage' + input.id).textContent = ""; // Limpia el mensaje de error
        } else {
            document.getElementById('errorMessage' + input.id).textContent = `El texto pegado contiene caracteres no válidos`;
        }
        alertMessageDisappear(document.getElementById('errorMessage' + input.id));
    }); 
    input.addEventListener('keypress', function(e) {
        //validacion para el maximo de caracteres permitidos
        const inputField = e.target; 
        if (inputField.value.length >= regexMAX[input.name]){
            e.preventDefault();
            return;
        }
        //validacion de caracteres permitdos en tiempo real
        if (!allowedCharacters.test(e.key)) {
            document.getElementById('errorMessage' + input.id).textContent = regexError[input.name];
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
            e.preventDefault();
            return;
        } else {
            document.getElementById('errorMessage' + input.id).textContent = "";
        }
    });

    input.addEventListener('keydown', function(event) {
        if (event.keyCode === 8 || event.keyCode === 127 || event.keyCode === 46) { // Código ASCII para Backspace
            document.getElementById('errorMessage' + input.id).textContent = "";
            alertMessageDisappear(document.getElementById('errorMessage' + input.id));
            return ;
        }
    });

    input.addEventListener('input', function() {
        let value = input.value;
    
        if (value.length > 0) {
            if (input.name === 'title') {
                // Convierte toda la cadena a minúsculas primero y luego pone la primera letra en mayúscula
                value = value.toLowerCase();
                let firstLetterIndex = [...value].findIndex(char => /[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]/.test(char));
    
                if (firstLetterIndex !== -1) {
                    input.value = value.slice(0, firstLetterIndex) +
                                value.charAt(firstLetterIndex).toUpperCase() +
                                value.slice(firstLetterIndex + 1);
                }
            } else {
                // Para otros casos: primera letra en mayúscula, las demás pueden ser tanto mayúsculas como minúsculas
                let firstLetterIndex = [...value].findIndex(char => /[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]/.test(char));
    
                if (firstLetterIndex !== -1) {
                    input.value = value.slice(0, firstLetterIndex) +
                                value.charAt(firstLetterIndex).toUpperCase() +
                                value.slice(firstLetterIndex + 1);
                }
            }
        }
    });
    
    
});

//evento para limpiar la casulla de check cuando de haga click en ella
document.querySelectorAll('input[type="radio"]').forEach(input => {
    input.addEventListener('click', function(){ 
        document.getElementById('errorMessage' + input.name).textContent = "";
    });
});
/*validacion de los campos a traves de las etiqueta input */
document.getElementById("formPackages").addEventListener("submit",function( event ){
    Check = {ok : false} ;// cuando se envia el formulario se toma como que no esta validado
    

    const input = document.querySelectorAll('input[type="text"]');
    
    for (const data of input) {
        if (data.value.trim() === '') {
            document.getElementById('errorMessage' + data.id).textContent = "El campo no debe estar vacío";
            alertMessageDisappear(document.getElementById('errorMessage' + data.id));
            data.focus();
            event.preventDefault();
            break; 
        }
        let allowedCharacters = regexMap[data.name];
        if(data.name === 'price'){allowedCharacters = regexMap['Bprice'];}// en caso de que se evalue precio, se usa una exprecion regular diferente
        if (!allowedCharacters.test(data.value)) {
            document.getElementById('errorMessage' + data.id).textContent = regexError[data.name];
            alertMessageDisappear(document.getElementById('errorMessage' + data.id));
            data.focus();
            event.preventDefault();
            break;
        }
        
        
         if(data.name === 'description'){
            const valueData = data.value[0];
            const allowed =/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+$/;
            if(! allowed.test(valueData)){
                document.getElementById('errorMessage' + data.id).textContent = "La descripcion no debe comenzar con espacios ni caracteres especiales"
                alertMessageDisappear(document.getElementById('errorMessage' + data.id));
                event.preventDefault();
                break;
            }
          
        } 


    }
    //validacion para que las casillas de check siempre se selecionen
    const radiosTransporte = document.querySelectorAll('input[name="transport"]');
    const radiosComida = document.querySelectorAll('input[name="food"]');
    const radiosHospedaje = document.querySelectorAll('input[name="lodging"]');

    if (!radiosTransporte[0].checked && !radiosTransporte[1].checked) {
        document.getElementById('errorMessagetransport').textContent = "Debe seleccionar una opción";
        alertMessageDisappear(document.getElementById('errorMessagetransport'));
        event.preventDefault();
        return;
    }

    if (!radiosComida[0].checked && !radiosComida[1].checked) {
        document.getElementById('errorMessagefood').textContent = "Debe seleccionar una opción";
        alertMessageDisappear(document.getElementById('errorMessagefood'));

        event.preventDefault();
        return;
    }

    if (!radiosHospedaje[0].checked && !radiosHospedaje[1].checked) {
        document.getElementById('errorMessagelodging').textContent = "Debe seleccionar una opción";
        alertMessageDisappear(document.getElementById('errorMessagelodging'));

        event.preventDefault();
        return;
    }
    
    /*condicional para saber si se activa un preventDefault y saber si esta validado el formulario  */
    if (event.defaultPrevented) {
    } else {
        
        Check.ok = true;//si no se detecta un preventDefault significa que esta validado
    }


    
});

