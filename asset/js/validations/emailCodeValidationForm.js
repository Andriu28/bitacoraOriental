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
/* 
email : /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,20}$/,
code :  /^[0-9\s]+$/,
password : /^(?=.*[a-zA-Z])(?=.*[\-_.,;:$%#!¡?+*@])(?=.*[0-9]).+$/,
repPassword : /^(?=.*[a-zA-Z])(?=.*[\-_.,;:$%#!¡?+*@])(?=.*[0-9]).+$/
*/

const regexMap ={
    code : /^[0-9\s]+$/,
    email:  /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,5}$/,
    password : /^(?=.*[a-zA-Z])(?=.*[\-_.,:$%#!¡?+*@])(?=.*[0-9]).+$/,
    repPassword : /^(?=.*[a-zA-Z])(?=.*[\-_.,:$%#!¡?+*@])(?=.*[0-9]).+$/
};

const regexMIN ={
    email : 3,
    code : 2,
    password : 8,
    repPassword : 8
};
const regexMAX ={
    email : 100,
    code : 6,
    password : 16,
    repPassword : 16
};

const regexError ={
    email : "El correo no es adecuado, ejemplo: nombre@gmail.com, nombre@hotmail.com",
    code : "El codigo solo debe contener numeros",
    password : "La contraseña debe tener al menos un número una letra y un caracter especial permitido  - _ . , ; : $ % # ! ¡ ? + * @",
    repPassword : "La contraseña debe tener al menos un número una letra y un caracter especial permitido  - _ . , ; : $ % # ! ¡ ? + * @"
}

document.querySelectorAll('input').forEach(input => {
    
    input.addEventListener('keypress', function(e) {
        const inputField = e.target; 
        if (inputField.value.length >= regexMAX[input.name]){
            e.preventDefault();
            return;
        }else{
            document.getElementById('errorMessage' + input.id).textContent = "";
            return ;
        }

    });  
    input.addEventListener('keydown', function(event) {
        if (event.keyCode === 8 || event.keyCode === 127 || event.keyCode === 46) { // Código ASCII para Backspace
            document.getElementById('errorMessage' + input.id).textContent = "";
            return ;
        }
    });  
});

document.getElementById("formRecovery").addEventListener("submit", function(event){

    const input = document.querySelectorAll('input');
    
    for (const data of input) {
        if(data.name !== 'send' && data.name !== '' && data.name !== 'hash' && data.title !== '' ){

        
        if (data.value.trim() === '') {
            document.getElementById('errorMessage' + data.id).textContent = "El campo no debe estar vacío";
            alertMessageDisappear(document.getElementById('errorMessage' + data.id));
            data.focus();
            event.preventDefault();
            break; 
        }
        const dataValue = data.value.trim();
        if (dataValue.length < regexMIN[data.name] || dataValue.length > regexMAX[data.name]) {
            document.getElementById('errorMessage' + data.id).textContent = `El campo debe tener entre ${regexMIN[data.name]} y ${regexMAX[data.name]} caracteres`;
            alertMessageDisappear(document.getElementById('errorMessage' + data.id));
            data.focus();
            event.preventDefault();
            break;
        }
        let allowed = regexMap[data.name];
        if(!allowed.test(data.value)) {
            document.getElementById('errorMessage' + data.id).textContent = regexError[data.name];
            alertMessageDisappear(document.getElementById('errorMessage' + data.id));
            data.focus();
            event.preventDefault();
            break;
        } 
        const password = document.getElementById("password") ? document.getElementById("password").value : null;
        const repPassword = document.getElementById("repPassword") ? document.getElementById("repPassword").value : null;
        
        if (password !== repPassword && (password !== null || repPassword !== null)) {
                
            document.getElementById('errorMessagerepPassword').textContent = "La contraseña no coincide";
            alertMessageDisappear(document.getElementById('errorMessage' + data.id));
           
            event.preventDefault();
            return;
        }
        }

    }


    
    /*validar los campos dinamicamente */
});