
    
<?php require_once(MODEL_PATH."address.php");?>

<main class="cajaResg">
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">

            <form id="formRegister" action="<?php if (isset($_GET['userType']) && $_GET['userType'] === 'publicist') {
            echo 'index.php?controller=users&action=registerPublicist&userTypeAux=publicista&status=1';
        } else {
            echo 'index.php?controller=users&action=register';
        } ?>" method="POST" novalidate>   


                <?php if(!isset($_SESSION['user'])){ ?> 
                    <div class="btReset">
                        <div class="header">  
                        
                        <h2>Regístrate</h2> 
                       </div>
                       <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                    </div>
                    
                    <?php }else{ ?>
                        <div class="btReset">
                            <div class="header"> 
                                <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor"> 
                                    <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path> 
                                </svg>  
                               <h2>Regístrar usuario publicista</h2> 
                            </div>
                            <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                        </div>
                   
                    <?php } ?>

                <div class="form-section active" id="section1">
                <div class="contenedor-formulario">
                    <div class="columna">
                        <label for="name">Nombre<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese su primer nombre"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagename"></div>
                        <input class="input-box" type="text" id="name" name="name" title="Nombre" placeholder="Ingrese su nombre">
                    </div>
                    <div class="columna">
                        <label for="lastName">Apellido<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese su primer apellido"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagelastName"></div>
                        <input class="input-box" type="text" id="lastName" name="lastName" title="Apellido" placeholder="Ingrese su apellido">
                    </div>
                </div>
                <div class="contenedor-formulario">
                    <div class="columna">
                        <label for="ci">Cédula <span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese su número de cédula. &#10;Ejemplo: 12345678"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessageci"></div>
                        <input class="input-box" type="text" id="ci" name="ci" title="Cédula" placeholder="Ingrese su cédula">
                    </div>            
                    <div class="columna">
                        <label for="birthDate">Fecha de nacimiento <span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione su fecha de nacimiento. &#10;Debe ser mayor de edad"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagebirthDate"></div>
                        <input class="input-box" type="date" id="birthDate" name="birthDate" title="Fecha de cumpleaños" placeholder="Ingrese su cumpleaños" formnovalidate>
                    </div>
                </div>
                <div class="contenedor-formulario">
                    <div class="columna">
                        <label for="phone">Teléfono  <span class="help-icon" data-tooltip="Ingrese su número de teléfono. &#10;Ejemplo: 04241234567, 04121234567 "><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagephone"></div>
                        <input class="input-box" type="text" id="phone" name="phone" title="Teléfono" placeholder="Ingrese su teléfono">                
                    </div>
                    <div class="columna">
                        <label for="email">Correo <span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese su correo electrónico. &#10;Ejemplo: usuario@gmail.com"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessageemail"></div>
                        <input class="input-box" type="text" id="email" name="email" title="Correo" placeholder="Ingrese su correo">
                    </div>
                </div>
                <div class="boton-sig-ant" style="display: flex; justify-content: flex-end;">
                    <button class="button-ant-sig" type="button" onclick="nextSection()">Siguiente</button>
                </div>
            </div>

                <div class="form-section" id="section2">
                    <div class="contenedor-formulario">
                        <div class="columna">
                            <label for="estado">Estado<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione el estado donde reside."><?php echo HELP_ICON; ?></span></label>
                            <div class="errorMessage" id="errorMessageestado"></div>
                            <select class="custom-select" name="estado" id="estado">
                                <option value="">Seleccionar</option>
                                <?php
                                $result = $address->addressEdo();
                                if (count($result) > 0) {
                                    foreach ($result as $row) {
                                        echo '<option value="' . $row['id_e'] . '">' . $row['estado'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="columna">
                            <label for="municipio">Municipio<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione el municipio donde reside.&#10;(Primero selecione el estado)"><?php echo HELP_ICON; ?></span></label>
                            <div class="errorMessage" id="errorMessagemunicipio"></div>
                            <select class="custom-select" name="municipio" id="municipio">
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                    </div>  
                    <div class="contenedor-formulario">                 
                        <div class="columna">
                            <label for="parroquia">Parroquia<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione la parroquia donde reside.&#10;(Primero selecione el municipio)"><?php echo HELP_ICON; ?></span></label>
                            <div class="errorMessage" id="errorMessageparroquia"></div>
                            <select class="custom-select" name="parroquia" id="parroquia">
                                <option value="">Seleccionar</option>
                            </select>
                        </div>

                        <div class="columna">
                            <label for="address">Dirección<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese su dirección completa. Ejemplo: Calle 12, Nº 34, Urbanización Las Rosas"><?php echo HELP_ICON; ?></span></label>
                            <div class="errorMessage" id="errorMessageaddress"></div>
                            <input class="input-box" type="text" id="address" name="address" title="Dirección" placeholder="Ingrese su dirección">
                        </div>
                    </div>

                    <div class="contenedor-formulario">        
                    <div class="columna">
                        <label  for="password">Contraseña<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="La contraseña debe tener al menos un número,&#10; una letra y un carácter especial. &#10;Permitidos: - _ . , : $ % # ! ¡ ? + @"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagepassword"></div>
                        <div class="password-container">
                            <input class="input-box" type="password" id="password" name="password" title="Contraseña" placeholder="Ingrese una contraseña" required>
                            <div title="Mostrar contraseña" class="password-toggle" id="togglePassword">
                                <!-- SVG para ocultar la contraseña inicialmente -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.282 21.782l4.278-4.278M21.782 3.282L17.673 7.39m-3.363 3.363a2.64 2.64 0 0 0-1.063-1.063a2.625 2.625 0 1 0-2.494 4.62m3.557-3.557l-3.557 3.557m3.557-3.557l3.363-3.363m-6.92 6.92L7.56 17.504M17.673 7.39c-.38-.319-.791-.621-1.232-.894C15.2 5.726 13.717 5.19 12 5.19c-4.956 0-7.948 4.459-8.91 6.16c-.11.196-.165.293-.197.446a1.2 1.2 0 0 0 0 .408c.032.152.088.25.198.445c.51.903 1.593 2.582 3.237 3.96c.38.319.791.621 1.232.895m12.18-7.925c.528.694.919 1.328 1.17 1.773c.11.194.165.292.197.444c.023.112.023.296 0 .408c-.032.152-.087.25-.197.444c-.96 1.702-3.95 6.162-8.91 6.162q-.714-.002-1.374-.117"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="columna">
                        <label for="repPassword">Repita la Contraseña<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="La contraseña debe tener al menos un número, &#10;una letra y un carácter especial. &#10;Permitidos: - _ . , : $ % # ! ¡ ? + @"><?php echo HELP_ICON; ?></span></label>
                        <div class="errorMessage" id="errorMessagerepPassword"></div>
                        <div  class="password-container">
                            <input class="input-box" type="password" id="repPassword" name="repPassword" placeholder="Repita la contraseña" title="Repita la contraseña">
                            <div title="Mostrar contraseña" class="password-toggle" id="toggleRepPassword">
                                <!-- SVG para ocultar la contraseña inicialmente -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.282 21.782l4.278-4.278M21.782 3.282L17.673 7.39m-3.363 3.363a2.64 2.64 0 0 0-1.063-1.063a2.625 2.625 0 1 0-2.494 4.62m3.557-3.557l-3.557 3.557m3.557-3.557l3.363-3.363m-6.92 6.92L7.56 17.504M17.673 7.39c-.38-.319-.791-.621-1.232-.894C15.2 5.726 13.717 5.19 12 5.19c-4.956 0-7.948 4.459-8.91 6.16c-.11.196-.165.293-.197.446a1.2 1.2 0 0 0 0 .408c.032.152.088.25.198.445c.51.903 1.593 2.582 3.237 3.96c.38.319.791.621 1.232.895m12.18-7.925c.528.694.919 1.328 1.17 1.773c.11.194.165.292.197.444c.023.112.023.296 0 .408c-.032.152-.087.25-.197.444c-.96 1.702-3.95 6.162-8.91 6.162q-.714-.002-1.374-.117"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="buttom-container">
                    <button class="button-ant-sig" type="button" onclick="previousSection()">Anterior</button>
                </div>
            </div>

                        <div class="text-grey">
                            <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                        </div>

                        <div class="buttom-container">
                        <input class="button-login-register" type="submit" title="Registrarse" value="Registrarse" name="send">
                        <?php if (isset($_GET['userType']) && $_GET['userType'] === 'publicist') { ?>
                        <a href="index.php?controller=users&action=list&userType=publicista&status=1" title"Regresar" class="button-Rev">Regresar</a><?php }else{ ?>
                                <a class="button-Rev" href="index.php?controller=home" title="Regresar">Regresar</a><?php } ?>
                                </div>
                    </form>



                    <script src="asset/js/scripts/helpForm.js"></script>
                    <script src="asset/js/scripts/showPassword.js"></script>
                    <script src="asset/js/requests/requestsTrip.js"></script>
                    <script src="asset/js/requests/requestsRoute.js"></script>  
                    
                    <?php if( !isset($_SESSION['user'])){ ?> 
                    <p class="mensaje">¿Ya tienes una cuenta? <a href="index.php?controller=users&action=loginView">Inicia Sesión</a></p>
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
</main>



               
