<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>

<main >
<div class="contenedor-nuevo">
  <div class="caja-register">
    <div class="formulario-login-registro">
        
        <form id="trip" action="index.php?controller=trip&action=addTrip" method="POST">
        <div class="btReset">
            <div class="header">
            <svg class='green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                 <path d="M21.259 11.948A.986.986 0 0 0 22 11V8a.999.999 0 0 0-.996-.999V6H21c0-2.206-1.794-4-4-4H7C4.794 2 3 3.794 3 6v1a1 1 0 0 0-1 1v3c0 .461.317.832.742.948a3.953 3.953 0 0 0-.741 2.298l.004 3.757c.001.733.404 1.369.995 1.716V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h12v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1.274a2.02 2.02 0 0 0 .421-.313c.377-.378.585-.881.584-1.415l-.004-3.759a3.966 3.966 0 0 0-.742-2.291zM5 18h-.995l-.004-3.757c-.001-.459.161-.89.443-1.243h15.111c.283.353.445.783.446 1.242L20.006 18H5zm6.004-10v3H5V8h6.004zM19 11h-5.996V8H19v3zM7 4h10c1.103 0 2 .897 2 2h-4V5H9v1H5c0-1.103.897-2 2-2z"></path><circle cx="6.5" cy="15.5" r="1.5"></circle><circle cx="17.5" cy="15.5" r="1.5"></circle>
            </svg>
            <h2>Añadir ofertas de viaje</h2>
            </div>
            
            <button type="reset" title="Limpiar" class="reset-button"> 
                            <svg xmlns="http://www.w3.org/2000/svg" class="bx " width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3"/><path fill="currentColor" d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814"/></svg>
            </button>
        </div>    
        <div class="form-section active" id="section1">
            <div class="contenedor-formulario">
                <div class="columna">
                    <label for="title">Título<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese el título del viaje.  &#10;Ejemplo: Aventura en la Montaña"><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessagetitle"></div>
                    <input class="input-box" type="text" id="title" name="title" title="Ingrese un título" maxlength="50" placeholder="Ingrese un título"> 
                </div>            
                <div class="columna">
                    <label for="departureLocation">Lugar de salida<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese el lugar de salida. &#10; Ejemplo: Terminal de Autobuses Central"><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessagedepartureLocation"></div>
                    <input class="input-box" type="text" id="departureLocation" name="departureLocation" title="Ingrese el lugar de salida" maxlength="100" placeholder="Ingrese el lugar de salida">                        
                </div>            
            </div>
            <div class="contenedor-formulario">
                <div class="columna">
                    <label for="departureDate">Fecha de salida<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione la fecha de salida. &#10;(La fecha debe ser superior al día actual)  &#10;Ejemplo: 01-01-2030"><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessagedepartureDate"></div>
                    <input class="input-box" type="date" id="departureDate" name="departureDate" title="Selecciona la fecha de salida">
                </div>            
                <div class="columna">
                    <label for="departureTime">Hora de salida<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione la hora de salida.  &#10;Ejemplo: 08:00 AM"><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessagedepartureTime"></div>
                    <input class="input-box" type="time" id="departureTime" name="departureTime" title="Selecciona la hora de salida">
                </div>            
            </div> 
            <div class="contenedor-formulario">
                <div class="columna">                         
                    <label for="returnDate">Fecha de regreso<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione la fecha de regreso. &#10;(La fecha debe ser igual o superior a la fecha de salida) &#10; Ejemplo: 01-05-2030"><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessagereturnDate"></div>
                    <input class="input-box" type="date" id="returnDate" name="returnDate" title="Selecciona la fecha de regreso">
                </div>            
                <div class="columna">
                    <label for="returnTime">Hora de regreso<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione la hora de regreso. &#10; Ejemplo: 06:00 PM"><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessagereturnTime"></div>
                    <input class="input-box" type="time" id="returnTime" name="returnTime" title="Selecciona la hora de regreso">                                                
                </div>            
            </div> 
            <div class="contenedor-formulario">
                <div class="columna">
                    <label for="numberSlots">Cantidad de cupos<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese la cantidad de cupos disponibles. &#10;Corresponde a la cantidad máxima disponible &#10; para viajar. Ejemplo: 20"><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessagenumberSlots"></div>
                    <input class="input-box" type="text" id="numberSlots" name="numberSlots" title="Ingrese la cantidad de cupos" maxlength="11" placeholder="Ingrese la cantidad de cupos">
                </div>            
                <div class="columna">
                    <label for="price">Precio del viaje (<?php echo MONETARY_UNIT; ?>)<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese el costo del viaje en <?php echo MONETARY_UNIT; ?>. &#10;Corresponde al precio propio del viaje segun su ruta. Tome en cuanta que se sumara con el precio  del paquete seleccionado por el usuario.  &#10;Ejemplo: 150.00"><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessageprice"></div>
                    <input class="input-box" type="text" id="price" name="price" title="Ingrese el costo del viaje" maxlength="11" placeholder="Ingrese el costo del viaje">
                </div> 
                <div class="text-grey">
                    <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                </div>           
            </div>                                             
            <div class="columna">                                            
                <div class="buttom-container" style="display: flex; justify-content: flex-end;">
                    <button class="button-ant-sig" type="button" onclick="nextSection()">Siguiente</button>
                </div>
            </div>                 
        </div>

            <div class="form-section" id="section2">
                <?php require_once("view/trip/add2Trip.php"); ?>
               <div class="text-grey">
                  <p>Todos los campos con<span class="obligatorio">*</span> son obligatorios</p>
                </div>
                <div class="buttom-container">
                    <button class="button-ant-sig" type="button" onclick="previousSection()">Anterior</button>
                    <button class="button-ant-sig" type="button" onclick="nextSection()">Siguiente</button>
                </div>
            </div>
            <div class="form-section" id="section3">
                <?php require_once("view/trip/add3Trip.php"); ?>
                <div class="contenedor-formulario">          
                    <div class="columna">   
                        <div class="buttom-container">
                            <button class="button-ant-sig" type="button" onclick="previousSection()">Anterior</button>
                        </div>
                    </div>
                    <div class="columna">   
                        <div class="text-grey">
                            <p>Todos los campos con<span class="obligatorio">*</span> son obligatorios</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttom-container">
                <input class="button-login-register" type="submit" title="Añadir" value="Añadir" name="send">
                <a class="button-Rev" href="index.php?controller=trip&action=listTripEnabled" title="Cancelar ">Cancelar</a>
            </div>
           
        </form>
        </div>
  </div>
</div>

</main>
        <script src="asset/js/scripts/helpForm.js"></script>
        <script src="asset/js/requests/requestsTrip.js"></script>
        <script  src="asset/js/validations/tripValidation.js"></script>    
        <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="trip"></div>
        <script src="asset/js/scripts/alert.js"></script>
        <script src="asset/js/scripts/dateTTrip.js"></script> 

