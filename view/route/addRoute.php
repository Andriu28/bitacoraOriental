<?php 
if(!isset($_SESSION['user'])) {
    header("location:". DEFAULT_ADDRESS_LOGOUT);
    exit(); // Asegúrate de detener la ejecución después de redirigir
}
require_once("model/address.php"); 
?>
<main>
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">
                <form id="route" action="index.php?controller=route&action=addRoute" method="POST" enctype="multipart/form-data">

                    <div class="btReset">
                        <div class="header">
                            <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z"></path>
                                <path d="M11.42 21.814a.998.998 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819zM12 4c3.309 0 6 2.691 6 6.005.021 4.438-4.388 8.423-6 9.73-1.611-1.308-6.021-5.294-6-9.735 0-3.309 2.691-6 6-6z"></path>
                            </svg>
                            <h2>Añadir ruta de viaje</h2>
                        </div>
                        <button type="reset" title="Limpiar" class="reset-button"> 
                            <svg xmlns="http://www.w3.org/2000/svg" class="bx " width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3"/><path fill="currentColor" d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814"/></svg>
                        </button>
                    </div>

                    <div class="form-section active" id="section1">
                        <label for="place">Lugar<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese el lugar de la ruta de viaje. &#10;Ejemplo: Parque Nacional Los Roques"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessageplace"></div>
                        <input class="input-box" type="text" id="place" name="place" title="Ingrese un Lugar" maxlength="50" placeholder="Ingrese un Lugar">

                        <label for="estado">Estado<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione el estado donde se encuentra la ruta."><?php echo HELP_ICON; ?></span></label>
                        <select class="custom-select" name="estado" id="estado">
                            <option value="">Seleccionar</option>
                            <?php
                            $result = $address->addressEdo();
                            if (count($result) > 0) {
                                foreach ($result as $row) {
                                    echo '<option value="' . htmlspecialchars($row['id_e']) . '">' . htmlspecialchars($row['estado']) . '</option>';
                                }
                            }
                            ?>
                        </select><br>

                        <label for="municipio">Municipio<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione el municipio donde se encuentra la ruta &#10;(Primero debe seleccionar el estado)"><?php echo HELP_ICON; ?></span></label>
                        <select class="custom-select" name="municipio" id="municipio">
                            <option value="">Seleccionar</option>   
                        </select><br>

                        <label for="parroquia">Parroquia<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione la parroquia donde se encuentra la ruta. &#10;(Primero debe seleccionar el municipio)"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessageparroquia"></div>
                        <select class="custom-select" name="parroquia" id="parroquia">
                            <option value="">Seleccionar</option>
                        </select><br>
                        <div class="contenedor-formulario">
                            <div class="columna"> 
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
                        
                    </div>

                    <div class="form-section" id="section2">
                        <label for="location">Comunidad/Calle<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese la comunidad o calle específica de la ruta. &#10;Ejemplo: Calle Principal de Los Roques"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagelocation"></div>
                        <input class="input-box" type="text" id="location" name="location" title="Ingrese una Ubicación" maxlength="70" placeholder="Ingrese una Ubicación">

                        <label for="description">Descripción<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese una descripción detallada de la ruta. &#10;Ejemplo: Ruta de senderismo que atraviesa el Parque Nacional,&#10;ideal para observación de aves y contacto con la naturaleza."><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagedescription"></div>
                        <input class="input-box" type="text" id="description" name="description" title="Ingrese una Descripción" maxlength="250" placeholder="Ingrese una Descripción">

                        <label>Imagen<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Formato de imagen permitidas: .jfif, .jpeg, .jpg, .png"><?php echo HELP_ICON; ?></span></label>
                        <label class="custom-file-upload" for="image">Examinar</label>
                        <div class="errorMessage" id="errorMessageimage"></div>
                        <input type="file"   accept=".jfif,.jpg,.jpeg,.png" title="Seleccione una Imagen" placeholder="Seleccione una Imagen" name="image" id="image">
                        <p>Vista previa</p>
                        <img src="" alt="" id="imagePreview" width="150px">

                        <div class="contenedor-formulario">
                            <div class="columna"> 
                                <div class="buttom-container">
                                    <button class="button-ant-sig" type="button" onclick="previousSection()">Anterior</button>
                                </div>
                            </div>
                            <div class="columna"> 
                                <div class="text-grey">
                                    <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="buttom-container">
                        <input class="button-login-register" type="submit" title="Añadir Rutas" value="Añadir" name="send">
                        <a class="button-Rev" href="index.php?controller=route&action=listRouteEnabled" title="Cancelar">Cancelar</a>
                    </div>
                </form>
                
                
                <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="route"></div>
                <script src="asset/js/scripts/helpForm.js"></script>
                <script src="asset/js/requests/requestsTrip.js"></script>
                <script src="asset/js/requests/requestsRoute.js"></script>  
                <script src="asset/js/validations/routeValidation.js"></script>
                <script src="asset/js/scripts/alert.js"></script>
            </div>
        </div>
    </div>
</main>
