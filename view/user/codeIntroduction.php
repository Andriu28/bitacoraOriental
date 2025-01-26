<main>
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">
            <form   id="formRecovery" action="index.php?controller=users&action=codeValidation&opc=<?php if(isset($_POST['action'])) echo $_POST['action'];?>" method="POST" autocomplete="of">
        
        <?php if(isset($_POST['action']) && $_POST['action'] === "validation" ){ ?>
            <div class="btReset">
                        <div class="header">  
                            <h2>Activación de cuenta</h2> 
                       </div>
                       <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                </div>
        <?php }else if(isset($_POST['action']) && $_POST['action'] === "recover" ){ ?>
            <div class="btReset">
                        <div class="header">  
                            <h2>Recuperación de contraseña</h2> 
                       </div>
                       <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                </div> 
        <?php } ?>
        <p class="message" > El código de verificación caducara en <?php if(isset($_POST['action'])) echo DEFAULT_DATE_CODE;?> minutos</p>
       

            <label for="code">Código de verificación</label><span class="obligatorio">*</span> 
            <span class="help-icon" data-tooltip="Ingrese el código de verificacion que fue enviado a su correo electrónico.">
                      <?php echo HELP_ICON; ?>
                  </span><br>
            <div class="errorMessage" id="errorMessagecode"></div>
            <input class="input-box" type="text" id="code" name="code" title="codigo de verifiaccion" placeholder="Ingrese el codigo de verificación"><br>
            
            <input type="hidden" id="idUser" name="idUser" value="<?php echo $_POST['idUser'] ;?>">
            <input type="hidden" id="hash" name="hash" value="<?php echo $_POST['hash'] ;?>">
            <input type="hidden" id="idHash" name="idHash" value="<?php echo $_POST['idHash'] ;?>">
            
            <div class="text-grey">
                <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
            </div>
            <div class="buttom-container">
                <input class="button-login-register" type="submit" title="Enviar codigo" value="Enviar codigo" name="send" >
                <?php if(isset($_SESSION['user'])){ ?>    
                    <a class="button-Rev" title="Regresar" href="index.php?controller=home&action=homeInformation"">Regresar</a>		                
                <?php }else if(isset($_POST['action']) && $_POST['action'] === "validation" ){ ?>
                    <a href="index.php?controller=users&action=login" title="cancelar" class="button-Rev" >Cancelar</a>
                <?php }else if(isset($_POST['action']) && $_POST['action'] === "recover" ){ ?>
                    <a href="index.php?controller=users&action=emailForRecover" title="Regresar" class="button-Rev" >Regresar</a>
                <?php } ?>
            </div>
        
        </form>

        <script src="asset\js\validations\emailCodeValidationForm.js"></script>
        <div class="message-alert" >        
            <div class="message-text-alert" id="messageAlert" ><p></p></div>
            <a  class="countdown-alert-mail" id="countdown"></a>
            <a  class="send-code-alert" id="sendEmail" idUser=<?php if(isset($_GET['idUser'])) echo json_encode($_GET['idUser']); ?>></a>
        </div>
        <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="codeIntroduction" actionModel=<?php if(isset($_POST['action'])) echo json_encode($_POST['action']);?>></div>
        <script src="asset\js\scripts\alert.js"></script>     
    
    
        <script src="asset/js/scripts/helpForm.js"></script>
        </div>
        </div>
    </div>
</main>
