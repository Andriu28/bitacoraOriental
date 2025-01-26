<?php 
if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);
?>
<main>
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">
                  <form class="form" id="faq" action="index.php?controller=faqs&action=addFaq" method="POST">

                        <div class="btReset">
                              <div class="header">
                              <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M12 6a3.939 3.939 0 0 0-3.934 3.934h2C10.066 8.867 10.934 8 12 8s1.934.867 1.934 1.934c0 .598-.481 1.032-1.216 1.626a9.208 9.208 0 0 0-.691.599c-.998.997-1.027 2.056-1.027 2.174V15h2l-.001-.633c.001-.016.033-.386.441-.793.15-.15.339-.3.535-.458.779-.631 1.958-1.584 1.958-3.182A3.937 3.937 0 0 0 12 6zm-1 10h2v2h-2z"></path><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                              </svg>
                              <h2>Añadir pregunta frecuente</h2>
                              </div>
                              <button type="reset" title="Limpiar" class="reset-button"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bx " width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3"/><path fill="currentColor" d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814"/></svg>
                               </button>
                        </div>
                        <!-- group: query -->
                        <label for="query">Pregunta<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese una pregunta frecuente. &#10;Ejemplo: ¿Cómo puedo restablecer mi contraseña?"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagequery"></div>
                        <input class="input-box" type="text" name="query" id="query" maxlengt="100"
                              title="Ingrese una pregunta frecuente" placeholder="Ingrese una pregunta frecuente">
                        <!-- group: respond -->
                        <label for="respond">Respuesta<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese la respuesta a la pregunta frecuente.  &#10;Ejemplo: Para restablecer su contraseña, haga clic en 'Olvidé mi contraseña' &#10; y siga las instrucciones."><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagerespond"></div>
                        <input class="input-box" type="text" name="respond" id="respond" maxlengt="250"
                              title="Ingrese la respuesta" placeholder="Ingrese la respuesta">

                        <div class="text-grey">
                              <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                        </div>

                        <div class="buttom-container">
                              <button class="button-login-register" type="submit" title="Añadir">Añadir</button>
                              <a class="button-Rev" href="index.php?controller=faqs&action=listFaq" title="Cancelar">Cancelar</a>
                        </div>
                  </form>

      <script src="asset/js/scripts/helpForm.js"></script>
      <script src="asset/js/validations/faqValidation.js"></script>
      <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="faq"></div>
      <script src="asset/js/scripts/alert.js"></script>

             </div>
        </div>
    </div>
</main>
