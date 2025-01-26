let navigateImages;
let updateButtons;



document.addEventListener('DOMContentLoaded', function() {

    const loader = Swal.mixin({
        showConfirmButton: false,//quitar boton de confirmacion
        width: "130px",
        backdrop: false, // Desactiva el fondo oscuro
        html: '<svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-dasharray="16" stroke-dashoffset="16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c4.97 0 9 4.03 9 9"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.2s" values="16;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>'
    });
    
    

    const alert = document.getElementById('alert');
    const nameAlert = alert.getAttribute('nameAlert');
    const modelAlert = alert.getAttribute('modelAlert');


    //mapa de alertas con mensajes segun el modulo 
    const mapAlert = {
        // Este mapa de alertas se crea según el nameAlert y el módulo que es específico por módulo creando la alerta única
    
        // Mensajes de paquetes
        packagessave: "¡Paquete de viaje guardado correctamente!",
        packagesupdate: "¡Paquete de viaje actualizado correctamente!",
        packagesduplicate: "El paquete de viaje ingresado ya se encuentra registrado.",
        packagesduplicate_edition: "El paquete de viaje editado coincide con uno ya existente.",
        packagesdisabled_not_allowed: "El paquete de viaje no se puede deshabilitar.",
        packagesedit_not_allowed: "El paquete de viaje no se puede editar porque está siendo usado en una oferta de viaje.",
    
        // Mensajes de rutas
        routesave: "¡Ruta de viaje guardada correctamente!",
        routeupdate: "¡Ruta de viaje actualizada correctamente!",
        routeduplicate: "La ruta de viaje ingresada ya se encuentra registrada.",
        routeduplicate_edition: "La ruta de viaje editada coincide con una ya existente.",
        routedisabled_not_allowed: "La ruta de viaje no se puede deshabilitar.",
        routeedit_not_allowed: "La ruta de viaje no se puede editar porque está siendo usada en una oferta de viaje.",
    
        // Mensajes de viajes
        tripsave: "¡Oferta de viaje guardada correctamente!",
        tripupdate: "¡Oferta de viaje actualizada correctamente!",
        tripduplicate: "La oferta de viaje ingresada ya se encuentra registrada.",
        tripduplicate_edition: "La oferta de viaje editada coincide con una ya existente.",
    
        // Mensajes de preguntas frecuentes
        faqsave: "¡La pregunta frecuente fue guardada correctamente!",
        faqupdate: "¡La pregunta frecuente fue actualizada correctamente!",
        faqduplicate: "La pregunta frecuente ingresada ya se encuentra registrada.",
        faqduplicate_edition: "La pregunta frecuente editada coincide con una ya existente.",
        
        // Mensajes de publicaciones especiales
        pubSpecialsave: "¡Publicación especial guardada correctamente!",
        pubSpecialupdate: "¡Publicación especial actualizada correctamente!",
        pubSpecialduplicate: "La publicación especial ingresada ya se encuentra registrada.",
        pubSpecialduplicate_edition: "La publicación especial editada coincide con una ya existente.",
        
        // Mensajes de reservaciones
        reservationsave: "¡Solucitud de reservación guardada correctamente!",
        reservationupdate: "¡Reservación actualizada correctamente!",
        reservationduplicate: "La reservación ingresada ya se encuentra registrada.",
        reservationduplicate_edition: "La reservación editada coincide con una ya existente.",
    
        // Mensajes de las bitácoras
        webLogsave: "¡Bitácora guardada correctamente!",
        webLogupdate: "¡Bitácora actualizada correctamente!",
        webLogduplicate: "La bitácora ingresada ya se encuentra registrada.",
        webLogduplicate_edition: "La bitácora editada coincide con una ya existente.",
    
        // Mensajes de los comentarios
    
    };
    
    //contante para reducir el codigo de la alerta grandes
    const bigAlert = Swal.mixin({
        confirmButtonColor: "#27a027",// color de boton de confirmacion
        cancelButtonColor: "#808180",// color del boton de cancelar
        denyButtonColor: "#808180",// color del boton para regresar
        timer: 4000,  // tiempo del popup
    });

    //constante para reducir el codigo de las alertas pequeñas
    const Toast = Swal.mixin({
        toast: true,// modo pequeño
        showConfirmButton: false,//quitar boton de confirmacion
        timerProgressBar: true,//barra de tiempo de duracion
        timer : 5000,// tiempo de duracion del popup
        position: "top-end",// posicion de la alerta
        
        didOpen: (toast) => {//animaciones
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        },

    });
    // funcion para manejar los errores de fetch
    function errorFetch(textAlert,iconAlert,err){
        if (err instanceof TypeError) {
            if ( (!navigator.onLine)  && (err.message.includes('NetworkError') || err.message.includes('Failed to fetch'))){               
                textAlert = "No se pudo procesar su solicitud. Por favor, verifique su conexión a internet y vuelva a intentarlo.";
                iconAlert = "info";
            } 
        }
        Swal.fire({
            timer: 3500,
            confirmButtonColor: "#27a027",// color de boton de confirmacion
            icon: iconAlert,
            text : textAlert,
        })        
        console.log(err);
    }

    // tiempos de espera
    const timeSimulation = 500; // tiempo de espera simulado
    const  timePromise = 10000; // tiempo de espera de la promesa 

    // funcion para hacer un tiempo de espera de la promesa
    function createTimeout(controller, time = timePromise) {
        return setTimeout(() => {
            controller.abort();
        }, time);// 10 segunods
    }

    

    //respecion y paseo del JSON para la alerta
    const message = JSON.parse(nameAlert);
/* 
    console.log(modelAlert);
    console.log(message);
    console.log(message.response);
     */

    // ejecucion de la alerta segun el caso
    // cada alerta tiene una breve descripcion de lo que hace
    switch(message.response){
        /*alerta por defevto que se activa se hay reservaciones pendientes */
        /* case "none":
             const controller = new AbortController();// contolador de abortar fetch
            const signalCon = controller.signal;// señal para abortar
            const timeout = createTimeout(controller);//llamada al tiempo de espera del sirvidor


            const url = "index.php?controller=reservation&action=alertRequetsReservation";
            fetch(url,{
                signal:signalCon
            })
            .then(response=>response.text())
                .then( data =>{
                    const text = data.trim();
                    if( text === "pending_reservations"){
                        Toast.fire({
                            timer: 4000,
                            html: "<div style='position: relative;'><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' style='position: absolute; top: 10px; right: 10px; cursor: pointer;' onclick='Swal.close()'><path fill='none' stroke='#d32f2f' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M18 6L6 18M6 6l12 12'/></svg><div style='margin-right: 40px;'><p>Tiene solicitudes de reservaciones pendientes</p><br><a href='index.php?controller=reservation&action=listRequestsE'>Ver solicitudes de reservación</a></div></div>",
                        });                                                                      
                    }
                })
                .catch(err => {                    
                    console.error(err);
                });   
        break; */
        /*alerta para cuando algo de los modulos seguarde */
        case "save" :
            bigAlert.fire({
                text: mapAlert[modelAlert + message.response],
                icon: "success",
          
            });
            break;
        /*alerta para cuando algo de los modulos de modifique correctamente */
        case "update" :
            bigAlert.fire({
                text: mapAlert[modelAlert + message.response],
                icon: "success",
           
                
            });
            break;
        /*alerta para cuando algo que se gaurde de los modulos ya exsita  */
        case "duplicate" :
        bigAlert.fire({
            text: mapAlert[modelAlert + message.response],
            icon: "info",
            confirmButtonColor: "#808180",
                
        });
        break;
        /*alerta para cuando algo que se edita ya existe  */
        case "duplicate_edition" :
            bigAlert.fire({
                html: mapAlert[modelAlert + message.response],
                icon: "info",
                confirmButtonColor: "#808180",
            });
        break;
        /* modulo re solicitu de reservacion */
        
        case "add_requests_tourits":
        Toast.fire({            
            text: "¡Solicitud de resvervación realizada correctamente! \n Contactate con nosotros +58 4122918427", 
            icon: "success"
        });
        break   
        case "add_requests_reservation":
        Toast.fire({            
            text: "Reservación realizada exitosamente \n puede visualizarla en la vista de reservaciones.", 
            icon: "success"
        });
        break;
        case  "exceedsVacant":
            bigAlert.fire({
                timer: 7000,
                text: "No se pudo aceptar la solicitud. Esta excede el número de vacantes del viaje.\n Puede comunicarse con el turista o actualizar los cupos disponibles.",
                icon: "info",
            });
        break;
        case  "acceptRequests":
            Toast.fire({
                text : `La solicitud de viaje fue aceptada correctamente.`,
                icon: "success",
            });
        break;
        case  "deniedRequests":
            Toast.fire({
                text: "La solictud de viaje fue rechazada correctamente.",
                icon: "success",
            });
        break;
        case  "reconcedeRequests":
            Toast.fire({
                text: "Proceso exitoso, Puede volver a reconciderar la solicitud en la lista de Solicitudes de reservación ",
                icon: "success",
            });
        break;
        case "firth_sesion":
            Toast.fire({
                text: "Primero debes iniciar sesión",
                icon: "info",
            });

        break;
        case  "cancelRequests":
            Toast.fire({
                text: "Reservación Cancelada exitosamente",
                icon: "success",
            });
        break;
        case  "borrRequests":
            Toast.fire({
                text: "Su solicitud de reservación fue borrada exitosamente",
                icon: "success",
            });
        break;
         /* -------------------------------------- */
         case "edit_requests_tourits":
            Toast.fire({            
                text: "¡Solicitud de reservación editada correctamente! \n Contáctate con nosotros:+58 4122918427", 
                icon: "success"
            });
        break   
        case "edit_requests_reservation":
        Toast.fire({            
            text: "Reservación editada exitosamente. \n Puede visualizarla en la vista de reservaciones.", 
            icon: "success"
        });
        break;
        /* -------------------------------------- */
        case "notWebLog":
            Toast.fire({
                text: "Actualmente no hay bitácoras",
                icon: "info",
            });
        break;



/* ////////////////////////////comment alert ////////////////////////////////////////*/
        case  "Accept_comment":
            Toast.fire({
                text: "Comentario Acceptado correctamente",
                icon: "success",
            });
        break;
        case  "rejected_comment":
            Toast.fire({
                text: "Comentario rechazado correctamente",
                icon: "success",
            });
        break;
/* --------------------------------------------------------------------------------- */
        
        /*Respuesta para cuando un usuario publicista se a guardo correctamente */
        case "user_insert":
        bigAlert.fire({
            confirmButtonColor: "#27a027",
            text: "¡Usuario registrado correctamente!", 
            icon: "success"
        });
        break;

        /* Alerta para cuando el usuario se edite correctamente */
        case "edited_user":
        bigAlert.fire({
            text: "Datos editados correctamente.", 
            icon: "success"
        });
        break;

        /* Alerta para cuando el usuario edite sus datos y no haya cambios */
        case "user_no_changes":
        Toast.fire({
            timer: 2500,
            text: "No ha realizado cambios en los datos.", 
            icon: "info"
        });
        break;

        /* Alerta para cuando se deshabilite correctamente algo de los módulos */
        case "disabled_allowed":
        Toast.fire({
            timer: 2500,
            text: "Inhabilitado correctamente.", 
            icon: "success"
        });
        break;

        /* Alerta para cuando se habilite algo de los módulos correctamente */
        case "enable_allowed":
        Toast.fire({
            timer: 2500,
            text: "Habilitado correctamente.", 
            icon: "success"
        });
        break;

        /* Alerta para cuando el inhabilitado no es permitido */
        case "disabled_not_allowed":
        Toast.fire({
            timer: 3500,
            text: `${mapAlert[modelAlert + message.response]} no se puede inhabilitar porque está siendo usado en una oferta de viaje.`, 
            icon: "info"
        });
        break;

        /* Alerta para cuando el editado no es permitido */
        case "edit_not_allowed":
        Toast.fire({
            timer: 4500,
            text: `${mapAlert[modelAlert + message.response]}`,
            icon: "info"
        });
        break;

        /* Alerta para cuando se banee a un usuario correctamente */
        case "user_baned":
        Toast.fire({
            timer: 2500,
            text: "Usuario baneado correctamente.", 
            icon: "success"
        });
        break;

        /* Alerta para cuando se desbanee a un usuario correctamente */
        case "user_desbaned":
        Toast.fire({
            timer: 2500,
            text: "Usuario desbaneado correctamente.", 
            icon: "success"
        });
        break;

        /* Caso para cuando la cédula de la persona ya está registrada */
        case "ci_duplicate":
        bigAlert.fire({
            timer: 6500,
            text: "La cédula, el nombre y apellido ingresados ya se encuentran registrados. Si usted es el titular de los datos, por favor, comuníquese con el equipo de Bitácora Oriental.", 
            icon: "info"
        });
        break;       
       /* Alerta para cuando una oferta de viaje se reanude */
        case "trip_restart":
            Toast.fire({           
                timer: 2500,
                text: "Viaje reanudado correctamente.", 
                icon: "success"
            });
            break;

        /* Alerta para cuando una oferta de viaje se cancele */
        case "trip_cancel":
            Toast.fire({           
                timer: 2500,
                text: "El viaje se ha cancelado correctamente.", 
                icon: "success"
            });
            break;

        /* Error para cuando no se pueda iniciar sesión por falta de datos */
        case "error_login":
            bigAlert.fire({           
                timer: 3500,
                text: "¡Oops!... hubo un error al iniciar sesión, inténtelo de nuevo más tarde.", 
                icon: "error"
            });
            break;
        /* Error al insertar datos vacíos enviados por el usuario */
        case "error_insert_data":
            bigAlert.fire({           
                timer: 3500,
                text: "¡Oops!... Ocurrió un error al registrar los datos, inténtelo de nuevo más tarde.", 
                icon: "error"
            });
            break;

        /* Error al editar datos vacíos enviados por el usuario */
        case "error_edit_data":
            bigAlert.fire({           
                timer: 3500,
                text: "¡Oops!... Ocurrió un error al editar los datos, inténtelo de nuevo más tarde.", 
                icon: "error"
            });
            break;

        /* Respuesta para cuando la información no esté disponible */
        case "error_access_data":
            bigAlert.fire({           
                timer: 3500,
                text: "Información no disponible, inténtelo de nuevo más tarde.", 
                icon: "error"
            });
            break;
        // Mensaje de error para cuando el usuario la accion relizada no esta diponible por algun error en el servidor
        case "action_error_available":
            Swal.fire({           
                timer: 3500,
                text: "Acción no disponible, inténtelo de nuevo más tarde.", 
                icon: "error"
            });
            break;

        /* Error para cuando los datos enviados por el usuario están vacíos */
        case "error_try_again":
            bigAlert.fire({           
                timer: 3500,
                text: "¡Oops!... hubo un error inesperado, inténtelo de nuevo más tarde.", 
                icon: "error"
            });
            break;                

        /** Respuesta para cuando se introduzca incorrectamente el usuario y la contraseña */
        case "incorrect_email_pass":
            bigAlert.fire({
                text: "¡Correo o contraseña incorrectos!", 
                icon: "error"
            });
            break;

        /* Respuesta para cuando el usuario ha sido baneado */
        case "user_ban":
            bigAlert.fire({
                text: "¡El usuario ingresado se encuentra baneado!", 
                icon: "error"
            });
            break;

        /* Respuesta para cuando el correo ingresado ya esté registrado */
        case "registered_mail":
            bigAlert.fire({
                text: "El correo electrónico ingresado ya se encuentra registrado, intente usar un correo diferente.", 
                icon: "info"
            });
            break;    

        /* Respuesta para cuando expire la sesión por inactividad */
        case "loguot_time":
            Toast.fire({                
                icon: "info",
                title: "Sesión cerrada por inactividad." 
            });
            break;

        /*Respuesta para cuando el usuario necesite verificarse */
        case "set_verify":
            document.getElementById('messageAlert').textContent = "Introduzca el código de verificación enviado a su correo electrónico."; 
            document.getElementById('sendEmail').textContent = 'Reenviar código'; 
            break;
        /* Respuesta para cuando un usuario no validado intente cambiar su contraseña */
        case "account_verification":
            const idUser = document.getElementById('sendEmail').getAttribute('idUser');
            document.getElementById('messageAlert').innerHTML = "El usuario ingresado no está verificado, por favor verifique su cuenta. <br> <a href='index.php?controller=users&action=userVerification&idUser="+idUser+"'>Verificar Cuenta</a>"; 
            break;

        /* Respuesta para cuando la verificación se realice correctamente */
        case "success_verifivation":
            bigAlert.fire({
                confirmButtonColor: "#27a027",
                text: "Activación de cuenta realizada correctamente. ¡Felicidades! Ya puedes iniciar sesión.", 
                icon: "success",
                timer: 6000,
            });
            break;

        /* Respuesta para cuando el usuario intente validarse otra vez */
        case "valid_verify":
            bigAlert.fire({
                confirmButtonColor: "#27a027",
                title: "Usted ya se encuentra verificado",
                text: "Ingresa a nuestro sitio web y disfruta de las experiencias turísticas que Bitácora Oriental puede ofrecer.", 
                icon: "info"
            });
            break;

        /* Respuesta para cuando haya un error al verificar al usuario (hash o email inválidos) */
        case "error_verifivation":
                bigAlert.fire({
                    confirmButtonColor: "#27a027",
                    text: "Error al verificar la cuenta, intente verificar su cuenta nuevamente o intente más tarde.", 
                    icon: "info",
                    timer: 6000,
                });
            document.getElementById('messageAlert').textContent = '¿No ha recibido el código de verificación?'; 
            document.getElementById('sendEmail').textContent = 'Enviar código'; 
            break;

        /* Respuesta para cuando el correo de recuperación no esté registrado previamente */
        case "mail_not_found":
            bigAlert.fire({
                text: "El correo ingresado no se encuentra registrado.", 
                icon: "error"
            });
            break;

        /* Respuesta para cuando la nueva contraseña sea igual que la anterior */
        case "same_passwords":
            bigAlert.fire({
                text: "No puede ingresar la misma contraseña, por favor ingrese una contraseña diferente.", 
                icon: "info"
            });
            break;

        /* Respuesta para indicar que el cambio de contraseña fue exitoso */
        case "password_found":
            bigAlert.fire({
                text: "La contraseña ha sido restablecida correctamente.", 
                icon: "success"
            });
            break;

        /* Respuesta de cuando se envíe el código para cambiar contraseña */
        case "mail_send":
            document.getElementById('messageAlert').textContent = '¿No ha recibido el código de verificación?'; 
            document.getElementById('sendEmail').textContent = 'Enviar código'; 
            break;

        /* Respuesta para cuando el código de verificación expire */
        case "code_invalid":
            Toast.fire({            
                text: "El código de verificación es inválido, inténtelo de nuevo.", 
                icon: "info"
            });
            document.getElementById('messageAlert').textContent = '¿No ha recibido el código de verificación?'; 
            document.getElementById('sendEmail').textContent = 'Enviar código'; 
            break;

        /* Respuesta para cuando el tiempo del código de verificación expire */
        case "code_date_expire":
            Toast.fire({            
                text: "El tiempo del código de verificación ha expirado, por favor solicite uno nuevo.", 
                icon: "info"
            });
            document.getElementById('messageAlert').textContent = 'El tiempo del código de verificación ha expirado, por favor solicite uno nuevo.'; 
            document.getElementById('sendEmail').textContent = 'Enviar código'; 
            break;

        /* Respuesta para cuando el código de verificación expire */
        case "code_expire":
            Toast.fire({                        
                text: "El código de verificación ha expirado, por favor solicite uno nuevo.", 
                icon: "info"
            });
            document.getElementById('messageAlert').textContent = '¿No ha recibido el código de verificación?'; 
            document.getElementById('sendEmail').textContent = 'Enviar código'; 
            break;

        /* Alerta para cuando el status del hash del cambio de contraseña cambie a 2 y no permita volver a cambiar la contraseña */
        case "hash_discarted":
            bigAlert.fire({   
                text: "Acceso denegado, para cambiar la contraseña debe completar la verificación.", 
                icon: "info",
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
            let count = 5;
            const timer = setInterval(function() {
                count--;

                if (count < 0) {
                    clearInterval(timer);
                    const url = "index.php?controller=home&action=homeInformation";
                    window.location.href = url;
                }
            }, 1000);
            break;

        /* Respuesta para cuando no se mande el correo de verificación de usuario */
        case "error_send_Verify":
            document.getElementById('messageAlert').textContent = "Error al enviar el código de verificación, inténtelo de nuevo."; 
            document.getElementById('sendEmail').textContent = 'Reenviar código'; 
            break;

        /* Respuesta de error para cuando no se envíe el código de verificación para cambio de contraseña */
        case "error_send":
            Toast.fire({            
                text: "Error al enviar el código de verificación, inténtelo de nuevo.", 
                icon: "warning"
            });            
            document.getElementById('messageAlert').textContent = '¿No ha recibido el código de verificación?'; 
            document.getElementById('sendEmail').textContent = 'Reenviar Código'; 
            break;

        /* Respuesta para cuando ocurra un error inesperado en la validación del usuario */
        case "account_verification_error":
            setInterval(function() {
                window.location.href = "index.php?controller=home&action=homeInformation";
            }, 8000);
            bigAlert.fire({
                allowOutsideClick: false, // Restringir el cierre de la alerta haciendo click fuera de ella
                timer: 8000,
                icon: "error",
                title: "Oops!...",
                text: "Ocurrió un error inesperado con la autenticación, por favor, contacte al equipo de Bitácora Oriental. En breve será redirigido al home.", 
            });
            break;            
    }



// funcion para mostrar mensajes de habilitar y deshabilitar (cancelar, banear etc)
function alertActionEnableDisable(text,url){
    bigAlert.fire({
        icon: "info",
        title: text,
        showDenyButton: true,            
        confirmButtonText: "Si",
        denyButtonText: "No",
        timer: undefined,
    }).then((result) => {
        if (result.isConfirmed) {     

            loader.fire();            
            setTimeout(() => {
                if(navigator.onLine){
                    window.location.href = url;
                }else{
                    bigAlert.fire({
                        text: "Solicitud no procesada, por favor verifique su conexión a internet.",
                        icon: "info",                        
                    })
                }
                
            }, timeSimulation); // Redirige después de 2 segundos

        }
    }); 
}

/*alerta para saber si de verdad el usaurio desea cancelar un viaje o no  */
if(modelAlert === "trip"){
    const cancel = document.querySelectorAll('.cancel') ? document.querySelectorAll('.cancel') : null ;
    if(cancel !== null){
        cancel.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const url = this.getAttribute('href');
                const text = "¿Desea cancelar el viaje?";
                alertActionEnableDisable(text,url);       
            });
        });
        
    }
    const rehacer = document.querySelectorAll('.rehacer') ? document.querySelectorAll('.rehacer') : null ;
    if(rehacer !== null){
        rehacer.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const url = this.getAttribute('href');
                const text = "¿Desea reactivar el viaje?";
                alertActionEnableDisable(text,url);       
            });
        });
        
    }
}

/*funcion para craar una alerta la cual indique si se quiere banear o desbanear a un usuario */
if(modelAlert === "users"){
    const ban = document.querySelectorAll('.ban') ? document.querySelectorAll('.ban') : null ;
    if(ban !== null){
        ban.forEach(link => {// evento para banear
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const url = this.getAttribute('href');
                const text = "¿Desea banear al usuario?";
                alertActionEnableDisable(text,url);                           
            });
        });            
    }
    const desban = document.querySelectorAll('.desban') ? document.querySelectorAll('.desban') : null ;
    if(desban !== null){//evento para desbanear
        desban.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const url = this.getAttribute('href');
                const text = "¿Desea desbanear al usuario?";
                alertActionEnableDisable(text,url);                           
            });
        });            
    }         
}
// evento para alerta de confirmacion de deshabilitar
const disable = document.querySelectorAll('.disable') ? document.querySelectorAll('.disable') : null ;
if(disable !== null){        
    disable.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const url = this.getAttribute('href');
            const text = "¿Desea inhabilitar?";
            alertActionEnableDisable(text,url);                           
        });
    });                    
}
// evento para alerta de confirmacion de habilitar
const enable = document.querySelectorAll('.enable') ? document.querySelectorAll('.enable') : null ;
if(enable !== null){        
    enable.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const url = this.getAttribute('href');
            const text = "¿Desea habilitar?";

            alertActionEnableDisable(text,url);                           
        });
    });                    
}

    const helpIcons = document.querySelectorAll('.help-icon');
    const tooltip = document.getElementById('tooltip');

        helpIcons.forEach(icon => {
            icon.addEventListener('mouseenter', () => {
                tooltip.innerText = icon.getAttribute('data-tooltip');
                const rect = icon.getBoundingClientRect();
                tooltip.style.top = `${rect.bottom + window.scrollY + 5}px`;
                tooltip.style.left = `${rect.left + window.scrollX + 5}px`;
                tooltip.style.display = 'block';
            });

            icon.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });
        });

    if(modelAlert === "reservation"){
        const accept = document.querySelectorAll('.accept') ? document.querySelectorAll('.accept') : null ;
        if(accept !== null){
            accept.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea aceptar la solicitud? <br><p class='text-small'> Se tomara en cuenta que ya acordo el pago con el cliente.</p>";
                    alertActionEnableDisable(text,url);       
                });
            });
            
        }

        const decline = document.querySelectorAll('.decline') ? document.querySelectorAll('.decline') : null ;
        if(decline !== null){
            decline.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea rechazar la solicitud?" ;
                    alertActionEnableDisable(text,url);       
                });
            });
            
        }
        const reconcile = document.querySelectorAll('.reconcile') ? document.querySelectorAll('.reconcile') : null ;
        if(reconcile !== null){
            reconcile.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea reconciderar la solicitud?";
                    alertActionEnableDisable(text,url);       
                });
            });
            
        }
        const canceld = document.querySelectorAll('.canceld') ? document.querySelectorAll('.canceld') : null ;
        if(canceld !== null){
            canceld.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea cancelar la reservación? ";

                    alertActionEnableDisable(text,url);       
                });
            });
            
        }
        const reconcileCancel = document.querySelectorAll('.reconcileCancel') ? document.querySelectorAll('.reconcileCancel') : null ;
        if(reconcileCancel !== null){
            reconcileCancel.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea  retomar la reservación? ";

                    alertActionEnableDisable(text,url);       
                });
            });
            
            const text = "¿Desea cancelar la solicitud? <br><p class='text-small'>Esta acción es irreversible.</p>";
        }

        const Cancelar_tourist = document.querySelectorAll('.Cancelar_tourist') ? document.querySelectorAll('.Cancelar_tourist') : null ;
        if(Cancelar_tourist !== null){
            Cancelar_tourist.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea cancelar la solicitud? <br><p class='text-small'>Esta acción es irreversible.</p>";

                    alertActionEnableDisable(text,url);       
                });
            });
            
        }
        const Cancelar_tourist_reservation = document.querySelectorAll('.Cancelar_tourist_reservation') ? document.querySelectorAll('.Cancelar_tourist_reservation') : null ;
        if(Cancelar_tourist_reservation !== null){
            Cancelar_tourist_reservation.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea cancelar la reservación? <br><p class='text-small'>Esta solo puede ser revertida por la agencia.\n Para efectos de rembolso comunicarse con los administradores</p>";

                    alertActionEnableDisable(text,url);       
                });
            });
            
        }
    }

/* ---------------------------------comment option----------------------------------- */

    if(modelAlert === "comment"){
        const acceptComment = document.querySelectorAll('.acceptComment') ? document.querySelectorAll('.acceptComment') : null ;
        if(acceptComment !== null){
            acceptComment.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea aceptar el comentario?";
                    alertActionEnableDisable(text,url);       
                });
            });
            
        }
        const rejectedComment = document.querySelectorAll('.rejectedComment') ? document.querySelectorAll('.rejectedComment') : null ;
        if(rejectedComment !== null){
            rejectedComment.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const text = "¿Desea rechazar el comentario del viaje? <br><p class='text-small'> Esta acción es irreversible.</p>";                    
                    alertActionEnableDisable(text,url);       
                });
            });
            
        }
    }
/* ------------------------------------------------------------------------------ */

    const editForm = document.querySelector('form') ? document.querySelector('form') : null ;
    
    /*alerta para cuando el usuaria no a echo cambios cuando edita un fomulario */
    if(editForm !== null ){
        const edit = editForm.getAttribute('edit');
        if(edit !== null){        
         
                     
            editForm.addEventListener('submit', (event) => {
                event.preventDefault();
                if(Check.ok === true){   
                    bigAlert.fire({
                        title: "¿Desea guardar los cambios?",
                        showDenyButton: true,                                    
                        confirmButtonText: "Guardar",
                        denyButtonText: `Cancelar`,
                        timer: undefined,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            editForm.submit();
                        }
                    });
                }
            });
            
        }
    }
    
    // manejo de cambio de contraseña
    if (modelAlert === "users") {
        const changePass = document.querySelectorAll('.passwordChangeAlert') ? document.querySelectorAll('.passwordChangeAlert') : null;
        if (changePass !== null) {
            changePass.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    bigAlert.fire({
                        title: "¿Desea restablecer la contraseña del usuario?",
                        html: '<div id="countdown">10</div><p id = "textAlertP">Debe esperar unos segundos.</p>',
                        showDenyButton: true,                        
                        confirmButtonText: "Restablecer contraseña",
                        denyButtonText: "Cancelar",
                        icon: "info",
                        didOpen: () => {
                            const confirmButton = bigAlert.getConfirmButton();                                                        
                            confirmButton.disabled = true;                            
                            let timeLeft = 10;
                            const countdownElement = document.getElementById('countdown');
                            const p = document.getElementById('textAlertP');
                            const countdownInterval = setInterval(() => {
                                timeLeft--;
                                countdownElement.textContent = timeLeft;
                                if (timeLeft <= 0) {
                                    clearInterval(countdownInterval);
                                    countdownElement.textContent = " ";
                                    p.textContent = " ";
                                    confirmButton.disabled = false;                                    
                                }
                            }, 1000); // Actualiza cada segundo
                        },
                        timer: undefined,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const url = this.getAttribute('href');
                            loader.fire();// alerta que contiene una ventana de carga 
                            const controller = new AbortController();// contolador de abortar fetch
                            const signalCon = controller.signal;// señal para abortar
                            const timeout = createTimeout(controller, 60000);//llamada al tiempo de espera del sirvidor

                            fetch(url,{
                                signal:signalCon
                            })
                            .then(response => response.json()) 
                            .then(data => {
                                clearTimeout(timeout); 

                                if(data.response === 'password_recovered'){
                                    bigAlert.fire({
                                        timer: 3500,
                                        title: "¡Contraseña restablecida correctamente!",                                        
                                        icon: "success"
                                    });
                                }else if(data.response === 'password_not_change'){
                                    bigAlert.fire({
                                        timer: 5000,
                                        text: "La contraseña no se restableció correctamente, intente de nuevo o más tarde.",                                        
                                        icon: "warning"
                                    });
                                }else if(data.response === 'none'){
                                    bigAlert.fire({
                                        timer: 4000,
                                        text: "Error al restablecer la contraseña del usuario, intente de nuevo o más tarde.",                                        
                                        icon: "error"
                                    });
                                }
                            })
                            .catch(err => {
                                loader.close();                               
                                errorFetch("Acción no disponible, inténtelo de nuevo o más tarde.","error",err)
                            })                     
                        }
                    });
                });
            });
        }
    }

// Función para parsear la información de la ubicación
function parseLocationInfo(text) {
    const lines = text.split('\n');
    const data = {};

    lines.forEach(line => {
        const [key, value] = line.split(':');
        data[key.trim()] = value.trim();
    });

    return data;
}

if (modelAlert === "home") {
    const detailButtons = document.querySelectorAll('.detailHome');
    if (detailButtons !== null) {
        detailButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.stopPropagation(); // Evita que el evento se propague al `card-item` si está presente

                const cardLink = button.closest('.card-link');
                if (cardLink) {
                    const cardImageSrc = cardLink.querySelector('img').src;
                    const cardSpanText = cardLink.querySelector('.card__span').innerText;
                    const cardTitleText = cardLink.querySelector('.card-int__title') ? cardLink.querySelector('.card-int__title').innerText : '';
                    const cardDescriptionText = cardLink.querySelector('.excerpt').innerText;

                    // Extraer datos de la cadena (si existe)
                    let parsedData = {};
                    if (cardTitleText) {
                        parsedData = parseLocationInfo(cardTitleText);
                    }

                    Swal.fire({
                        confirmButtonColor: "#27a027", // color de botón de confirmación                        
                        html: `
                            <div class="card-details-alertHome">
                                <h2 class="card-title">${cardSpanText}</h2>
                                <img src="${cardImageSrc}" alt="Card Image" style="max-width: 100%; height: auto;">
                                <p class="card-description">${cardDescriptionText}</p>
                                ${parsedData.Sector ? `<p class="card-span"><strong>Sector:</strong> ${parsedData.Sector}</p>` : ''}
                                ${parsedData.Parroquia ? `<p class="card-span"><strong>Parroquia:</strong> ${parsedData.Parroquia}</p>` : ''}
                                ${parsedData.Municipio ? `<p class="card-span"><strong>Municipio:</strong> ${parsedData.Municipio}</p>` : ''}
                                ${parsedData.Estado ? `<p class="card-span"><strong>Estado:</strong> ${parsedData.Estado}</p>` : ''}
                            </div>
                        `,
                    });
                }
            });
        });
    }
}

 
  
/* Función para crear una alerta que es capaz de mostrar los detalles de un registro según el módulo */
const details = document.querySelectorAll('.view-details') ? document.querySelectorAll('.view-details') : null;

if (details !== null) {
    details.forEach(detail => {
        detail.addEventListener('click', function() {
            const id = detail.id;
            const model = detail.getAttribute('model');            
            const url = "index.php?controller=" + model + "&action=details&id=" + id;
            let bandImg = false;
            const mapModel = {
                users: ['ci', 'name', 'lastName', 'birthDate', 'email', 'phone', 'privilege', 'address', 'parroquia', 'municipio', 'estado'],
                packages: ['title', 'description', 'transport', 'food', 'lodging', 'price'],
                pubEspecial: ['title', 'description', 'image'],
                traveloffer: ['title', 'departureLocation', 'departureDate', 'departureTime', 'returnDate', 'returnTime', 'numberSlots', 'vacant', 'price', 'amount'],
                faqs: ['query', 'respond'],
                route: ["place", "location", "parroquia", "municipio", "estado", "description", "image"],
                trip: ["title", "place", "departureLocation", "departureDate", "departureTime", "returnDate", "returnTime", "numberSlots", "vacant", "price", "titlePackages", "amount"],
                webLog: ['tripTitle', "departureDate", 'description', 'numberTravel', 'imageUrls'],                
                comment: ['name', 'email', 'titleTrip','message','dataTime']
                
            };

            const mapTitles = {
                users: ['C.I', 'Nombre', 'Apellido', 'Fecha de Nacimiento', 'Correo', 'Teléfono', 'Privilegio', 'Dirección', 'Parroquia', 'Municipio', 'Estado'],
                packages: ['Título', 'Descripción', 'Transporte', 'Comida', 'Hospedaje', 'Precio'],
                pubEspecial: ['Título', 'Descripción', 'Imagen'],
                faqs: ['Pregunta', 'Respuesta'],
                route: ["Lugar", "Dirección", "Parroquia", "Municipio", "Estado", "Descripción", "Imagen"],
                trip: ["Título", "Destino", "Lugar de salida", "Fecha de Salida", "Hora de Salida", "Fecha de Regreso", "Hora de Regreso", "Número de cupos", "Vacantes", "Precio del viaje", "Paquete", "Monto total"],
                webLog: ["Título del Viaje", "Fecha de Salida del viaje", 'Descripción', 'Número de viajeros', "Imágenes"],
                comment: ['Usuario', 'Correo', 'Bitácora','comentario','Fecha y hora']
            };

            const mapIdentify = {
                users: "Datos del usuario",
                packages: "Paquete de viaje",
                pubEspecial: "Publicación especial",
                faqs: "Pregunta frecuente",
                route: "Ruta de viaje",
                trip: "Oferta de viaje",
                webLog: "Bitácora de viaje",
                comment: "Comentario de la bitácora",
            };
            
            loader.fire(); // alerta que contiene una ventana de carga 
            const controller = new AbortController(); // controlador de abortar fetch
            const signalCon = controller.signal; // señal para abortar
            const timeout = createTimeout(controller); // llamada al tiempo de espera del servidor
            // Funciones para navegar por las imágenes
            
            fetch(url, { signal: signalCon })
    .then(response => response.json())
    .then(data => {



        clearTimeout(timeout);
        loader.close();
        if (data == undefined || data == false) {            
            Swal.fire({                
                confirmButtonColor: "#27a027", // color de botón de confirmación
                icon: "error",
                title: "Información no disponible."
            });
            return;
        }                            
        let htmlContent = `<div class='alert-title'>${mapIdentify[model]}</div>`;
        htmlContent += '<div class="alert-container">';

        let isTripHandled = false; // Bandera para controlar la duplicación de información específica de trip

        // Recorrer el mapa y crear el contenido HTML dinámico
        mapModel[model].forEach((key, index) => {
            if (data.hasOwnProperty(key)) {
                let value = data[key];
                if (key === 'image') {
                    htmlContent += `
                    <div class=".alert-image-one" style="width: 100%; height: 300px;">
                        <img src="${value}" alt="Imagen" style="width: 100%; height: 300px;">
                    </div>`;
                } else if (key === 'imageUrls') {
                    if(value !== 'noneImage'){
                        bandImg = true;                        
                        // Separar los valores por el separador `|`
                        const images = value.includes('|') ? value.split('|') : [value];
                        // Crear el contenido HTML para las imágenes
                        htmlContent += `<div class="alert-images-container">`;
                        htmlContent += `
                            <div class="alert-images-wrapper">`;
                        images.forEach((imgUrl, idx) => {
                            htmlContent += `
                                <div class="alert-image-section" id="image-section-${idx}" style="${idx === 0 ? 'display:block;' : 'display:none;'}">
                                    <img src="${imgUrl}" alt="Imagen">
                                </div>`;
                        });
                        htmlContent += `</div>`; // Cerrar el contenedor de imágenes
                        htmlContent += `<div class="button-container" >
                            <button id="prevBtn" onclick="navigateImages(-1)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20 9v6h-8v4.84L4.16 12L12 4.16V9z"/></svg></button>
                            <button id="nextBtn" onclick="navigateImages(1)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4 15V9h8V4.16L19.84 12L12 19.84V15z"/></svg></button>
                            </div>
                        </div>`; // Cerrar el contenedor principal
                    } else {
                        htmlContent += `
                        <div class="svg-container">
                            <div class="alert-svg" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 16 16"><path fill="currentColor" d="m12.309 13.016l1.837 1.838a.5.5 0 0 0 .708-.708l-13-13a.5.5 0 1 0-.708.708L2.414 3.12A2.5 2.5 0 0 0 2 4.5v5A2.5 2.5 0 0 0 4.5 12h5c.51 0 .983-.152 1.379-.414l.717.717A3.5 3.5 0 0 1 9.5 13H5c.456.607 1.182 1 2 1h2.5a4.48 4.48 0 0 0 2.809-.984m-2.162-2.162A1.5 1.5 0 0 1 9.5 11h-5c-.232 0-.45-.053-.647-.146l2.645-2.645a.71.71 0 0 1 1.001-.003l.003.003zM6.402 7.109a1.7 1.7 0 0 0-.611.393l-2.645 2.645A1.5 1.5 0 0 1 3 9.5v-5c0-.232.052-.45.146-.647zM11 4.5v4.379l.975.975Q12 9.68 12 9.5v-5A2.5 2.5 0 0 0 9.5 2h-5q-.18 0-.354.025L5.121 3H9.5A1.5 1.5 0 0 1 11 4.5m1.797 6.176l.764.764A4.5 4.5 0 0 0 14 9.5V6c0-.818-.393-1.544-1-2v5.5c0 .413-.072.809-.203 1.176M10 5a1 1 0 1 1-2 0a1 1 0 0 1 2 0"/></svg>
                            </div>
                        </div>`;                        
                    }
                }else if(model === 'trip' && key === 'price' ){
                    htmlContent += `
                    <div class="alert-section">
                        <span class="alert-label">${mapTitles[model][index]}:</span>
                        <span class="alert-value">${value} ${data.MONETARY_UNIT}</span>
                    </div>`;
                
                } else if (model === 'trip' && !isTripHandled && (key === 'titlePackages' || key === 'amount')) {
                    isTripHandled = true; // Marcar como manejado
                    // Separar los valores por el separador `|`
                    const titlePackages = data.titlePackages.split('|');
                    const amounts = data.amount.split('|');
                    
                    // Crear el contenido HTML para titlePackages y amounts
                    titlePackages.forEach((title, idx) => {
                        htmlContent += `
                            <div class="alert-section">
                                <span class="alert-label">Paquete ${idx + 1}:</span>
                                <span class="alert-value">${title} - ${amounts[idx]}${data.MONETARY_UNIT} = ${data.price + parseFloat(amounts[idx])}${data.MONETARY_UNIT}</span>
                            </div>`;
                    });
                } else if (!(model === 'trip' && (key === 'titlePackages' || key === 'amount'))) {
                    if (key === 'description' || key === 'message') {
                        htmlContent += `
                            <div class="alert-section-version-2 ">
                                <span class="alert-label">${mapTitles[model][index]}:</span>
                                
                            </div>
                            <div class="alert-section ">                                
                                <div class="scrollable-description">
                                    <span class="alert-value">${value}</span>
                                </div>
                            </div>
                            `;
                    
                    }else if(mapTitles[model][index] === 'Usuario'){
                        htmlContent += `
                        <div class="alert-section">
                            <span class="alert-label">${mapTitles[model][index]}:</span>
                            <span class="alert-value">${value} ${data.lastName || ' '}</span>
                        </div>`;
                    } else {

                        if (key.includes("dataTime")) {                            
                            value = convertirFechaHora(value);
                        } else if (key.includes("Date")) {
                            value = invertirFecha(value);
                        } else if (key.includes("Time")) {
                            value = convertirHora(value);
                        }                        
                        
                        // Agregar todas las demás propiedades no específicas de titlePackages o amount cuando model es trip
                        htmlContent += `
                            <div class="alert-section">
                                <span class="alert-label">${mapTitles[model][index]}:</span>
                                <span class="alert-value">${value}</span>
                            </div>`;
                    }
                }
                
                // Función para invertir la fecha
                function invertirFecha(fecha) {
                    var partes = fecha.split('-');
                    return partes[2] + '/' + partes[1] + '/' + partes[0];
                }
                
                // Función para convertir tiempo a formato AM/PM
                function convertirHora(hora) {
                    var [hh, mm, ss] = hora.split(':');
                    var ampm = hh >= 12 ? 'PM' : 'AM';
                    hh = hh % 12 || 12;
                    return `${hh}:${mm} ${ampm}`;
                }
                
                // Función para convertir datetime a formato dd/mm/yy y AM/PM
                function convertirFechaHora(fechaHora) {
                    var [fecha, hora] = fechaHora.split(' ');
                    fecha = invertirFecha(fecha);
                    hora = convertirHora(hora);
                    return `${fecha} ${hora}`;
                }
                
             
            }
        });

        htmlContent += '</div>'; // Cerrar el contenedor principal

        // Mostrar SweetAlert con el contenido dinámico
        Swal.fire({
            confirmButtonColor: "#27a027",                                                            
            html: htmlContent,
            customClass: {
                popup: 'custom-popup' // Clase personalizada para el popup
            },
            didOpen: () => {
                if(bandImg){
                    // Inicializar navegación de imágenes
                    currentImageIndex = 0;
                    updateButtons();
                }
            }
        });
        if(bandImg){            
            // Funciones para navegar por las imágenes
            let currentImageIndex = 0;
            navigateImages = (direction) => {
                const sections = document.querySelectorAll('.alert-image-section');
                sections[currentImageIndex].style.display = 'none'; // Ocultar la sección actual
                currentImageIndex += direction;
                sections[currentImageIndex].style.display = 'block'; // Mostrar la nueva sección
                updateButtons();
            };

            updateButtons = () => {
                const sections = document.querySelectorAll('.alert-image-section');
                document.getElementById('prevBtn').disabled = (currentImageIndex === 0);
                document.getElementById('nextBtn').disabled = (currentImageIndex === sections.length - 1);
            };
        }

    })
    .catch(err => {
        loader.close();
        errorFetch("Información no disponible.", "error", err);
    });
                                                      
        });
    });
}
    

               



    /*envio de mail de verificacion */
    const sendEmail = document.getElementById('sendEmail') ? document.getElementById('sendEmail') : null;
    if( sendEmail !== null){
        sendEmail.addEventListener('click',function(){
            const idUser = sendEmail.getAttribute('idUser');
            /*link para hacer la peticion al servidor */
            let url;
            let action = alert.getAttribute('actionModel') ? alert.getAttribute('actionModel') : null ;
            
            /*condicional para distinguir en que vista se ejecuta el script */
            if(action !== null){
            
            document.getElementById('messageAlert').textContent = '¿No ha recibido el código de verificación?' ;
            url = "index.php?controller=users&action=sendCode&id="+idUser+"&opc="+action;            
            

           // realiza una cuenta regresiva para enviar otro correo
           const countdownElement = document.getElementById('countdown');
           sendEmail.textContent = "";
           let timeLeft = 30;// Aqui se agusta el conteo regresivo
           function countdown() {
               countdownElement.textContent = timeLeft;//aqui se muestra la cuenta regresiva en tiemp real
               timeLeft--;
               if (timeLeft < 0) {//expresion de salida 
                   clearInterval(timer);
                   countdownElement.textContent = '';
                   sendEmail.textContent = 'Reenviar código' ;//menaje final luego del conteo
               }
           }
           const timer = setInterval(countdown, 1000);//aqui se ajusta el tiempo de espera 1000 = 1 Seg

            /*condicion para distenguir que peticion se hara al servidor */
            const idHash = document.getElementById('idHash');
            const hash = document.getElementById('hash');// se extrae el hash
            
            const controller = new AbortController();// contolador de abortar fetch
            const signalCon = controller.signal;// señal para abortar
            const timeout = createTimeout(controller,31000);//llamada al tiempo de espera del sirvidor

                return fetch(url,{
                    signal: signalCon,
                })
                .then(response=>response.text())
                    .then( data =>{     
                        console.log(data);                   
                        clearTimeout(timeout);// detiene el tiempo de cancelacion de la promesa
                        const text = data.trim();// se capta el JSON y se limpia la cadena de espacios
                        const json = JSON.parse(text);
                        if(json.error === "success"){//en caso de que no se resiva el codigo de verificacion
                            // si se resive se imprime en el HTML                                                
                            hash.value = json.idHash;
                            idHash.value = json.hash;   
                        }
                        if(json.error === "error_send"){
                            Toast.fire({            
                                text: "Error al enviar el código de verificación, inténtelo de nuevo o intene mas tarde.", 
                                icon: "warning"
                            });
                        }     
                })
                .catch(err => {
                    clearInterval(timer);                                
                    countdownElement.textContent = '';
                    document.getElementById('messageAlert').textContent = "Error al enviar el código de verificación, inténtelo de nuevo." ;
                    sendEmail.textContent = 'Reenviar Código' ;//menaje final luego del conteo
                    console.log(err);                   
                });
            }
        });
    }

    
    const formComment = document.getElementById('formComment') ? document.getElementById('formComment') : null;    
    if (formComment !== null) {        
        formComment.addEventListener('submit', function(event) {
            event.preventDefault();
    
            const comment = document.getElementById('commentMessage').value;
            if (!validateComment(comment)) {
                 return; 
            }
    
            const formData = new FormData(this);
            const urlEncodedData = new URLSearchParams(formData).toString();
            const url = "index.php?controller=comment&action=insert";
            
            loader.fire(); // Alerta que contiene una ventana de carga 
            const controller = new AbortController(); // Controlador de abortar fetch
            const signalCon = controller.signal; // Señal para abortar
            const timeout = createTimeout(controller); // Llamada al tiempo de espera del servidor
            
            fetch(url, {
                signal: signalCon,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: urlEncodedData
            })
            .then(response => response.json())
            .then(data => {
                clearTimeout(timeout); // Detiene el tiempo de cancelación de la promesa
                loader.close(); // Alerta que contiene una ventana de carga 

                if (data.success === 'success_insert'){
                    Toast.fire({
                        icon: "success",
                        text: "Comentario realizado correctamente. Debe esperar que sea aprobado para que se muestre."
                    });
                    // Limpiar el formulario excepto el textarea                    
                    formComment.reset();                                        
                }
                if (data.success === 'error_insert_data'){
                    Toast.fire({
                        icon: "info",
                        text: "No se pudo enviar el comentario. Inténtelo de nuevo o más tarde."
                    });
                    
                }
                
                // Deshabilitar el botón por un minuto                                        
                const submitButton = formComment.querySelector('[type="submit"]');

                // Añadir clase CSS para cambiar la opacidad
                submitButton.classList.add('disabledComment');
                submitButton.disabled = true;
                
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.classList.remove('disabledComment'); // Remover clase CSS para restaurar la opacidad
                }, 60000); // 60 segundos en milisegundos
                
            })
            .catch(error => {
                loader.close(); // Alerta que contiene una ventana de carga 
                errorFetch("Acción no disponible", "error", error);
            });
        });
    
        let commentErrorTimeout; // Variable para almacenar el timeout
        
        function validateComment(comment) {
            const commentError = document.getElementById('commentMessageError');
            commentError.innerHTML = '';
    
            // Clear any previous timeout
            clearTimeout(commentErrorTimeout);
    
            // Validation
            if (comment.trim() === '') {
                commentError.innerHTML = 'El comentario no puede estar vacío.';
                clearCommentError();
                return false;
            }
            
            const allowedCharacters = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\-()@$.,!¡¿?\s0-9]+$/;
            if (!allowedCharacters.test(comment)) {
                commentError.innerHTML = 'El comentario debe tener solo caracteres especiales permitidos: - () @ $ . , ! ¡ ¿ ?';
                clearCommentError();
                return false;
            }
    
            if (comment.length > 250) {
                commentError.innerHTML = 'El comentario no puede exceder los 250 caracteres.';
                clearCommentError();
                return false;
            }
    
            return true;
        }
    
        function clearCommentError() {
            const commentError = document.getElementById('commentMessageError');
            commentErrorTimeout = setTimeout(() => {
                commentError.innerHTML = '';
            }, 7000); // 7 segundos en milisegundos
        } 
    }
    
    
    



});/////// end script alert//////////




//funcion para el select de listUser para redirigir a los usuarios
function redirigir(select) {
    var url = select.value;
    if (url) {
        window.location.href = url;
    }
}

