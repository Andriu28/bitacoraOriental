<main>
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">

        
        <form   id="formRecovery" action="index.php?controller=users&action=emailForRecover" method="POST" autocomplete="on">
                <div class="btReset">
                        <div class="header">  
                            <h2>Cambio de contraseña</h2> 
                       </div>
                       <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                </div>
            <label for="email">Correo</label><span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese su correo electrónico. &#10;Ejemplo: usuario@gmail.com">
                      <?php echo HELP_ICON; ?>
                  </span><br>
            <div class="errorMessage" id="errorMessageemail"></div>
            <input class="input-box" type="text" id="email" name="email" title="Email" placeholder="Ingrese un Correo"><br>
            
            <div class="text-grey">
                <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
            </div>
            <div class="buttom-container">
                <input class="button-login-register" type="submit" title="Enviar Correo" value="Enviar Correo" name="send" >
                <a class="button-Rev" href="index.php?controller=users&action=login">Regresar</a>		
            </div>
        </form>

        <div class="message" id="messageAlert"></div>
        <a  class="message" id="sendEmail" idUser=<?php if(isset($_GET['idUser'])) echo json_encode($_GET['idUser']); ?>></a>
        
        <script src="asset\js\validations\emailCodeValidationForm.js"></script>
            
        <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="user"></div>
        <script src="asset\js\scripts\alert.js"></script> 
        <script src="asset/js/scripts/helpForm.js"></script>
        </div>
        </div>
    </div>
</main>
