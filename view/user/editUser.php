<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>

<?php require_once(MODEL_PATH."address.php");  ?>


<div class="contenedor-nuevo">
  <div class="caja-register">
    <div class="formulario-login-registro">
        
        <form id="formRegister" edit="editData" action="index.php?controller=users&action=editUser&id=<?php echo $dataToView['data']['idUser'] ; ?>&userType=publicista&status=1" method="POST">
                <div class="btReset">
                        <div class="header"> 
                        <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor"> 
                            <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path> 
                        </svg>  
                        <h2>Editar usuario</h2>
                       </div>
                       <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                </div>
        
            <div class="form-section active" id="section1">
                <div class="contenedor-formulario">            
                    <div class="columna">
                        <label for="name">Nombre<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su primer nombre si es necesario"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagename"></div>
                        <input class="input-box" type="text" id="name" name="name" title="Nombre" value="<?php echo $dataToView['data']['name'] ?>" placeholder="Ingrese su Nombre">
                    </div>
                    <div class="columna">
                        <label for="lastName">Apellido<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su primer apellido si es necesario"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagelastName"></div>
                        <input class="input-box" type="text" id="lastName" name="lastName" title="Apellido" value="<?php echo $dataToView['data']['lastName'] ?>" placeholder="Ingrese su Apellido">
                    </div>
                </div>
                <div class="contenedor-formulario">
                    <div class="columna">
                        <label for="ci">Cédula <span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su número de cédula si es necesario. Ejemplo: 12345678"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessageci"></div>
                        <input class="input-box" type="text" id="ci" name="ci" title="Cédula" value="<?php echo $dataToView['data']['ci'] ?>" placeholder="Ingrese su cédula">
                    </div>
                    <div class="columna">
                        <label for="birthDate">Fecha de nacimiento <span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su fecha de nacimiento si es necesario. Debe ser mayor de edad"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagebirthDate"></div>
                        <input class="input-box" type="date" id="birthDate" name="birthDate" title="Fecha de cumpleaños" value="<?php echo $dataToView['data']['birthDate'] ?>" placeholder="Ingrese su cumpleaños">
                    </div>
                </div>
                <div class="buttom-container" style="display: flex; justify-content: flex-end;">
                    <button class="button-ant-sig" type="button" onclick="nextSection()">Siguiente</button>
                </div>
            </div>

                    
            <div class="form-section" id="section2">
            <div class="contenedor-formulario">
                <div class="columna">
                    <?php
                    $aux = $address->getDependence($dataToView['data']['id_p']); 
                    if (count($aux) > 0) {
                        foreach ($aux as $row) {
                    ?>
                    <label for="estado">Estado<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione el estado donde reside."><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessageestado"></div>
                    <select class="custom-select" name="estado" id="estado">
                        <option value=""><?php echo $row['estado']; ?></option>
                        <?php
                        $result = $address->addressEdo();
                        if (count($result) > 0) {
                            foreach ($result as $data) {
                                echo '<option value="' . $data['id_e'] . '">' . $data['estado'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="columna">
                    <label for="municipio">Municipio<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione el municipio donde reside."><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessagemunicipio"></div>
                    <select class="custom-select" name="municipio" id="municipio">
                        <option value=""><?php echo $row['municipio']; ?></option>
                    </select>
                </div>
                <div class="columna">
                    <label for="parroquia">Parroquia<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione la parroquia donde reside."><?php echo HELP_ICON; ?></span></label>
                    <div class="errorMessage" id="errorMessageparroquia"></div>
                    <select class="custom-select" name="parroquia" id="parroquia">
                        <option value="<?php echo $dataToView['data']['id_p']; ?>"><?php echo $row['parroquia']; ?></option>
                    </select>
                    <?php
                        }
                    } 
                    ?>
                </div>
                <div class="columna">
                    <label for="phone">Teléfono<span class="grey-text">(opcional) <span class="help-icon" data-tooltip="Modifique su número de teléfono si es necesario. Ejemplo: 04241234567, 04121234567"><?php echo HELP_ICON; ?></span></span></label>
                    <div class="errorMessage" id="errorMessagephone"></div>
                    <input class="input-box" type="text" id="phone" name="phone" title="Teléfono" value="<?php if($dataToView['data']['phone'] !== 'POR ASIGNAR'){ echo $dataToView['data']['phone']; } ?>" placeholder="Ingrese su Teléfono">
                </div>
            </div>      
            <div class="columna" style="width: 100%;">
                <label for="address">Dirección<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su dirección completa si es necesario. Ejemplo: Calle 12, Nº 34, Urbanización Las Rosas"><?php echo HELP_ICON; ?></span></label>
                <div class="errorMessage" id="errorMessageaddress"></div>
                <input class="input-box" type="text" id="address" name="address" title="Dirección" value="<?php echo $dataToView['data']['address'] ?>" placeholder="Ingrese su dirección">
            </div>        
            <div class="boton-sig-ant">
                <button class="button-ant-sig" type="button" onclick="previousSection()">Anterior</button>
            </div>
        </div>


    <div class="buttom-container">
        <input class="button-login-register" type="submit" title="Registrarse" value="Editar datos" name="send">
        <a href="index.php?controller=users&action=list&userType=publicista&status=1" title="Regresar" class="button-Rev">Regresar</a>
    </div>
</form>

        <script src="asset/js/scripts/helpForm.js"></script>
        <script src="asset/js/requests/requestsTrip.js"></script>
        <script src="asset/js/requests/requestsRoute.js"></script>  
        
        <?php if( isset($_GET['userType']) && $_GET['userType'] === 'publicist'){ ?> 
          <p class="mensaje">¿Ya tienes una cuenta? <a href="index.php?controller=users&action=login">Inicia Sesión</a></p>
        <?php } ?>
        <div class="mensaje" id="messageAlert"><p></p></div>
        <a class="mensaje" id="countdown"></a>
        <a class="mensaje" id="sendEmail" email=<?php if(isset($_GET['email'])) echo json_encode($_GET['email']); ?> ></a>
        <script src="asset\js\validations\registerValidationForm.js"></script>
        <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="register"></div>
        <script src="asset\js\scripts\alert.js"></script>

    </div>
  </div>
</div>

