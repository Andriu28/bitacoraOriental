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

//depurar con console.log

const regexMAX ={
    email : 50 ,
    password : 16
};

document.querySelectorAll('input').forEach(input => {
   input.addEventListener('keypress', function(e) {
       const inputField = e.target; 
       if (inputField.value.length >= regexMAX[input.name]){
           e.preventDefault();
           alertMessageDisappear(document.getElementById('errorMessage' + input.id));
           return;
       }else{
        document.getElementById('errorMessage' + input.id).textContent = "";
       }
   });
});

document.getElementById('loginForm').addEventListener('submit',function( event){
    const input = document.querySelectorAll('input');
    for (const data of input){
        if (data.value.trim() === '') {
            document.getElementById('errorMessage' + data.id).textContent = `No debe estar vacio`;
            alertMessageDisappear(document.getElementById('errorMessage' + data.id));
            data.focus();
            event.preventDefault();
            return;
        }
    }
});
