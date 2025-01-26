<main >
<div class="contenedor-nuevo">
  <div class="caja-register">
    <div class="formulario-login-registro">
        <form class="form" id="formWebLog" action="index.php?controller=webLog&action=insert" method="POST" enctype="multipart/form-data">    
            <div class="btReset">
                        <div class="header">
                            <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2 12h2a7.986 7.986 0 0 1 2.337-5.663 7.91 7.91 0 0 1 2.542-1.71 8.12 8.12 0 0 1 6.13-.041A2.488 2.488 0 0 0 17.5 7C18.886 7 20 5.886 20 4.5S18.886 2 17.5 2c-.689 0-1.312.276-1.763.725-2.431-.973-5.223-.958-7.635.059a9.928 9.928 0 0 0-3.18 2.139 9.92 9.92 0 0 0-2.14 3.179A10.005 10.005 0 0 0 2 12zm17.373 3.122c-.401.952-.977 1.808-1.71 2.541s-1.589 1.309-2.542 1.71a8.12 8.12 0 0 1-6.13.041A2.488 2.488 0 0 0 6.5 17C5.114 17 4 18.114 4 19.5S5.114 22 6.5 22c.689 0 1.312-.276 1.763-.725A9.965 9.965 0 0 0 12 22a9.983 9.983 0 0 0 9.217-6.102A9.992 9.992 0 0 0 22 12h-2a7.993 7.993 0 0 1-.627 3.122z"></path><path d="M12 7.462c-2.502 0-4.538 2.036-4.538 4.538S9.498 16.538 12 16.538s4.538-2.036 4.538-4.538S14.502 7.462 12 7.462zm0 7.076c-1.399 0-2.538-1.139-2.538-2.538S10.601 9.462 12 9.462s2.538 1.139 2.538 2.538-1.139 2.538-2.538 2.538z"></path>
                            </svg>
                            <h2>Añadir bitácora de viaje</h2>
                        </div>
                        <button type="reset" title="Limpiar" class="reset-button"> 
                            <svg xmlns="http://www.w3.org/2000/svg" class="bx " width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3"/><path fill="currentColor" d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814"/></svg>
                        </button>
                    </div> 
        
            <div class="form-section active" id="section1">

                <label for="description">Descripción</label><span class="obligatorio">*</span><span class="help-icon" data-tooltip="Ingrese una descripción detallada de la Bitácora de viaje.  &#10;Ejemplo: Un paseo emocionante por las montañas, con paisajes&#10; impresionantes y aire fresco, perfecto para desconectar&#10; y disfrutar de la naturaleza..."><?php echo HELP_ICON; ?></span>
                <div class="errorMessage" id="errorMessagedescription"></div>
                <textarea class="input-box-bitacora"  title="Ingrese una descripción"
                placeholder="Ingrese una descripción" id="description" name="description" rows="4" style="width: 100%;"></textarea>


                <label for="numberTravel">Número de viajeros</label><span class="obligatorio">*</span><span class="help-icon" data-tooltip="Ingrese la cantidad de personas que estuvieron en el viaje.&#10;"><?php echo HELP_ICON; ?></span>
                <div class="errorMessage" id="errorMessagenumberTravel"></div>
                <input class="input-box" type="text" title="Ingrese un número"
                       placeholder="Ingrese un número" id="numberTravel" name="numberTravel" maxlength="50">

                <label>Imágenes</label><span class="obligatorio">*</span><span class="help-icon" data-tooltip="Formato de imagen permitidas: .jfif, .jpeg, .jpg, .png"><?php echo HELP_ICON; ?></span>
                <label class="custom-file-upload" for="images">Examinar</label>
                <div class="errorMessage" id="errorMessageimage"></div>
                <input type="file" title="Seleccione una Imagen"
                       name="images[]" id="images" multiple accept=".jfif,.jpg,.jpeg,.png">

                <p>Vista previa:</p>
                <div id="imagePreviewContainer">
                    <!-- Las imágenes se mostrarán aquí -->
                </div>

                <div class="text-grey">
                    <p>Todos los campos con<span class="obligatorio">*</span> son obligatorios</p>
                </div>
                <div class="buttom-container" style="display: flex; justify-content: flex-end;">
                    <button class="button-ant-sig" type="button" onclick="nextSection()">Siguiente</button>
                </div>
            </div>   

                <div class="form-section" id="section2">
                    <?php require_once("inserWebLog2.php"); ?>
                    <div class="text-grey">
                        <p>Todos los campos con<span class="obligatorio">*</span> son obligatorios</p>
                    </div>
                    <div class="buttom-container">
                        <button class="button-ant-sig" type="button" onclick="previousSection()">Anterior</button> 
                    </div>
                </div>
               
                <div class="buttom-container">
                    <input class="button-login-register" type="submit" title="Añadir" value="Añadir" name="send">
                    <a class="button-Rev" href="index.php?controller=webLog&action=list" title="Cancelar">Cancelar</a>
                    <div id="errorMessage"><p></p></div>
                </div>
           
            
        </form>
        </div>
  </div>
</div>

</main>

<!-- Script para la vista previa de las imágenes -->
<script src="asset/js/requests/requestsTrip.js"></script>
<script src="asset\js\scripts\weblogImage.js"></script>
<script src="asset/js/scripts/helpForm.js"></script>
<script src="asset/js/validations/weblogValidationForm.js"></script>
<script src="asset/js/scripts/dateTWebLog.js"></script> 

<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="webLog"></div>
<script src="asset/js/scripts/alert.js"></script>