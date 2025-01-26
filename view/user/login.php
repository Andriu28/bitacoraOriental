<main>
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">
                <form id="loginForm" action="index.php?controller=users&action=login" method="POST" autocomplete="on">
                <div class="btReset">
                        <div class="header">  
                            <h2>Inicia sesión</h2> 
                       </div>
                       <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                </div>
                <label for="email">Correo
                  <span class="help-icon" data-tooltip="Ingrese su correo electrónico. &#10;Ejemplo: usuario@gmail.com">
                      <?php echo HELP_ICON; ?>
                  </span>
                </label>
                <div class="errorMessage" id="errorMessageemail"></div>
                <input class="input-box" type="text" id="email" name="email" title="Email"  placeholder="Ingrese un Correo" require>
                
                
                <label for="password">Contraseña</label>
                <div class="errorMessage" id="errorMessagepassword"></div>
                <div class="password-container">
                  <input class="input-box" type="password" id="password" name="password" title="Contraseña" placeholder="Ingrese una Contraseña" required>
                  <div  title="Mostrar contraseña" class="password-toggle" id="togglePassword">            
                      <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.282 21.782l4.278-4.278M21.782 3.282L17.673 7.39m-3.363 3.363a2.64 2.64 0 0 0-1.063-1.063a2.625 2.625 0 1 0-2.494 4.62m3.557-3.557l-3.557 3.557m3.557-3.557l3.363-3.363m-6.92 6.92L7.56 17.504M17.673 7.39c-.38-.319-.791-.621-1.232-.894C15.2 5.726 13.717 5.19 12 5.19c-4.956 0-7.948 4.459-8.91 6.16c-.11.196-.165.293-.197.446a1.2 1.2 0 0 0 0 .408c.032.152.088.25.198.445c.51.903 1.593 2.582 3.237 3.96c.38.319.791.621 1.232.895m12.18-7.925c.528.694.919 1.328 1.17 1.773c.11.194.165.292.197.444c.023.112.023.296 0 .408c-.032.152-.087.25-.197.444c-.96 1.702-3.95 6.162-8.91 6.162q-.714-.002-1.374-.117"/>
                      </svg>
                  </div>
              </div>
              <?php if(isset($_GET['idTrip']) && !empty($_GET['idTrip'])){?>
                <input type="hidden" id="idTrip" name="idTrip" value="<?php echo $_GET['idTrip'] ;?>">
              <?php  } ?>
                <div class="buttom-container">
                  <input class="button-login-register" type="submit" title="Ingresar" value="Ingresar" name="send" >
                  <a class="button-Rev" href="index.php?controller=home" title="Regresar" >Regresar</a>
                </div>
                </form>
                <p class="mensaje">¿No estas Registrado? <a href="index.php?controller=users&action=register">Crear Cuenta</a></p>
                <p class="mensaje">¿Olvidaste tu contraseña? <a href="index.php?controller=users&action=emailForRecover">Recuperar Contraseña</a></p>
                <div class="mensaje" id="messageAlert"><p></p></div>
                <a class="mensaje" id="countdown"></a>
                <a class="mensaje" id="sendEmail" email=<?php if(isset($_GET['email'])) echo json_encode($_GET['email']); ?>></a>
        
            <script src="asset/js/scripts/helpForm.js"></script>
            <script src="asset/js/scripts/showPassword.js"></script>
            <script src="asset/js/validations/loginValidationForm.js"></script>
            <div id="alert" nameAlert=<?php echo htmlspecialchars(json_encode($controller->response), ENT_QUOTES, 'UTF-8'); ?> modelAlert="login"></div>
            <script src="asset/js/scripts/alert.js"></script>
                
                

            </div>
        </div>
    </div>
</main>


