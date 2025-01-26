<?php //if(!isset($_POST['email']) || !isset($_POST['hash']) || !isset($_POST['idHash']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>  
<main>
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">
        <form id="formRecovery" action="index.php?controller=users&action=changePassword" method="POST" autocomplete="off"> 
                <div class="btReset">
                        <div class="header">  
                            <h2>Cambio de contraseña</h2> 
                       </div>
                       <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                </div>
            <label for="password">Contraseña</label><span class="obligatorio">*</span> 
            <span class="help-icon" data-tooltip="Ingrese una nueva contraseña &#10;La contraseña debe tener al menos un número una letra y un caracter especial. &#10;Permitidos: - _ . , ; : $ % # ! ¡ ? + * @">
                      <?php echo HELP_ICON; ?>
                </span><br>
            <div class="errorMessage" id="errorMessagepassword"></div>
            
            <div class="password-container">
            <input class="input-box" type="password" id="password" name="password" placeholder="Ingrese una Contraseña" title="Contraseña"><br>
                <div title="Mostrar contraseña" class="password-toggle" id="togglePassword">
                    <!-- SVG para ocultar la contraseña inicialmente -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.282 21.782l4.278-4.278M21.782 3.282L17.673 7.39m-3.363 3.363a2.64 2.64 0 0 0-1.063-1.063a2.625 2.625 0 1 0-2.494 4.62m3.557-3.557l-3.557 3.557m3.557-3.557l3.363-3.363m-6.92 6.92L7.56 17.504M17.673 7.39c-.38-.319-.791-.621-1.232-.894C15.2 5.726 13.717 5.19 12 5.19c-4.956 0-7.948 4.459-8.91 6.16c-.11.196-.165.293-.197.446a1.2 1.2 0 0 0 0 .408c.032.152.088.25.198.445c.51.903 1.593 2.582 3.237 3.96c.38.319.791.621 1.232.895m12.18-7.925c.528.694.919 1.328 1.17 1.773c.11.194.165.292.197.444c.023.112.023.296 0 .408c-.032.152-.087.25-.197.444c-.96 1.702-3.95 6.162-8.91 6.162q-.714-.002-1.374-.117"/>
                    </svg>
                </div>
            </div>
        

            <label for="password">Repita la Contraseña</label><span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Repita la contaseña que acaba de ingresar">
                      <?php echo HELP_ICON; ?>
                  </span><br>
            <div class="errorMessage" id="errorMessagerepPassword"></div>
            
            <div  class="password-container">
            <input class="input-box" type="password" id="repPassword" name="repPassword" placeholder="Repita la contraseña"  title="Repcontraseña"><br>
                <div title="Mostrar contraseña" class="password-toggle" id="toggleRepPassword">
                    <!-- SVG para ocultar la contraseña inicialmente -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.282 21.782l4.278-4.278M21.782 3.282L17.673 7.39m-3.363 3.363a2.64 2.64 0 0 0-1.063-1.063a2.625 2.625 0 1 0-2.494 4.62m3.557-3.557l-3.557 3.557m3.557-3.557l3.363-3.363m-6.92 6.92L7.56 17.504M17.673 7.39c-.38-.319-.791-.621-1.232-.894C15.2 5.726 13.717 5.19 12 5.19c-4.956 0-7.948 4.459-8.91 6.16c-.11.196-.165.293-.197.446a1.2 1.2 0 0 0 0 .408c.032.152.088.25.198.445c.51.903 1.593 2.582 3.237 3.96c.38.319.791.621 1.232.895m12.18-7.925c.528.694.919 1.328 1.17 1.773c.11.194.165.292.197.444c.023.112.023.296 0 .408c-.032.152-.087.25-.197.444c-.96 1.702-3.95 6.162-8.91 6.162q-.714-.002-1.374-.117"/>
                    </svg>
                </div>
            </div>

            <input type="hidden"  id="idUser" name="idUser" value=<?php echo $_POST['idUser'] ?>>
            <?php if(isset($_GET['changeAdmin']) && $_GET['changeAdmin'] === '1'){ ?> <input type="hidden" id="changeAdmin" name="changeAdmin" value="1"> <?php  } ?>
            <?php if(isset($_POST['hash'])){ ?> <input type="hidden" id="hash" name="hash" value="<?php echo $_POST['hash'] ;?>"> <?php  } ?>
            <?php if(isset($_POST['idHash'])){ ?><input type="hidden" id="idHash" name="idHash" value="<?php echo $_POST['idHash'] ;?>"> <?php  } ?>
            <div class="text-grey">
                <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
            </div>
            <div class="buttom-container">
                <input class="button-login-register" type="submit" title="Cambiar Contraseña" value="Cambiar Contraseña" name="send">
                <?php if(isset($_GET['changeAdmin']) && $_GET['changeAdmin'] === '1'){ ?>        
                    <a class="button-Rev" title="Cancelar" href="index.php?controller=users&action=list&userType=publicista&status=1">Cancelar</a>		                
                <?php }else if(isset($_SESSION['user'])){ ?>    
                    <a class="button-Rev" title="Cancelar" href="index.php?controller=users&action=userPanel">Cancelar</a>		
                <?php }else{ ?>
                    <a class="button-Rev" title="Cancelar"  href="index.php?controller=home&action=homeInformation" >Cancelar</a>		
                <?php } ?>
            </div>
                    
        </form>

        
        <script src="asset/js/scripts/showPassword.js"></script>
        <div class="message" id="messageAlert" ></div>
        <script src="asset\js\validations\emailCodeValidationForm.js"></script>

        <div class="message" id="errorMessage" ><p></p></div>
    
        <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="codeIntroduction"></div>
        <script src="asset\js\scripts\alert.js"></script>  
        <script src="asset/js/scripts/helpForm.js"></script>
        </div>
        </div>
    </div>
</main>
