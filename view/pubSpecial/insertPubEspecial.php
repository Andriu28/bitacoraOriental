<main>
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">
        <form class="form" id="formPubSpecial" action="index.php?controller=pubEspecial&action=insert" method="POST" enctype="multipart/form-data">
            <div class="btReset">
                <div class="header">
                    <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                    <path d="m6.516 14.323-1.49 6.452a.998.998 0 0 0 1.529 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082a1 1 0 0 0-.59-1.74l-5.701-.454-2.467-5.461a.998.998 0 0 0-1.822 0L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.214 4.107zm2.853-4.326a.998.998 0 0 0 .832-.586L12 5.43l1.799 3.981a.998.998 0 0 0 .832.586l3.972.315-3.271 2.944c-.284.256-.397.65-.293 1.018l1.253 4.385-3.736-2.491a.995.995 0 0 0-1.109 0l-3.904 2.603 1.05-4.546a1 1 0 0 0-.276-.94l-3.038-2.962 4.09-.326z"></path>
                    </svg>
                    <h2>Añadir publicación especial</h2>
                </div>
                <button type="reset" title="Limpiar" class="reset-button"> 
                            <svg xmlns="http://www.w3.org/2000/svg" class="bx " width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3"/><path fill="currentColor" d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814"/></svg>
                </button>
            </div>
        
             <div>
                <label for="title">Título<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese el título de la publicación especial.  &#10;Ejemplo: Oferta de verano"><?php echo HELP_ICON; ?></span></label>
                <div class="errorMessage" id="errorMessagetitle"></div>
                <input class="input-box" type="text" title="Ingrese un título" placeholder="Ingrese un título" id="title" name="title" maxlength="50">

                <label for="description">Descripción<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese una descripción detallada de la publicación especial.  &#10;Ejemplo: 20% de descuento en todas las reservaciones de julio."><?php echo HELP_ICON; ?></span></label>
                <div class="errorMessage" id="errorMessagedescription"></div>
                <input class="input-box" type="text" title="Ingrese una descripción" placeholder="Ingrese una descripción" id="description" name="description" maxlength="300">

                <label>Imagen<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Formato de imagen permitidas: .jfif, .jpeg, .jpg, .png"><?php echo HELP_ICON; ?></span></label></label>
                <label class="custom-file-upload" for="image">Examinar</label>   
                <div class="errorMessage" id="errorMessageimage"></div>
                <input type="file"  accept=".jfif,.jpg,.jpeg,.png" title="Seleccione una imagen" placeholder="Seleccione una imagen" name="image" id="image">                
                <p>Vista previa</p>
                <img src="" alt="" id="imagePreview" width="150px">

                <div class="text-grey">
                    <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                </div>

                <div class="buttom-container">
                    <input class="button-login-register" type="submit" title="Añadir" value="Añadir" name="send">
                    <a class="button-Rev" href="index.php?controller=pubEspecial&action=list" title="Cancelar">Cancelar</a>
                    <div id="errorMessage"><p></p></div>
                </div>
            </div>
        </form>


    
<script src="asset/js/scripts/helpForm.js"></script>
<script src="asset/js/validations/pubSpecialValidation.js"></script>
<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="pubSpecial"></div>
<script src="asset/js/scripts/alert.js"></script>

        </div>
        </div>
    </div>
</main>


