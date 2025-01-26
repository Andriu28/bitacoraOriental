<?php
require("support.php");
$sessionData['user'] = $objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
$row = $address->getDependence($sessionData['user']['idParroquia']);

?>

<main id="super_form">
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">
            <!-- aquí empieza el formulario  -->
            <form id="reservation" action="index.php?controller=reservation&action=requestReservation" onsubmit="return validateForm();" method="POST">
             
                <!-- este es el encabezado del formulario -->
                <div class="header">
                    <div class="header-content">
                        <svg class="bx green" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 2H6c-1.103 0-2 .897-2 2v18l8-4.572L20 22V4c0-1.103-.897-2-2-2zm0 16.553-6-3.428-6 3.428V4h12v14.553z"></path>
                        </svg> 
                        <h2 class="header-title"> 
                                <?php  
                                 echo isset($_SESSION['user']) && $_SESSION['privilege'] === 'turista'?
                                  "Solicitud de " : "Añadir ";
                                ?>Reservación
                        </h2>
                        <!-- botón para reiniciar todos los campos del formulario -->
                        <button type="reset" title="Reiniciar" class="reset-button"> 
                            <svg xmlns="http://www.w3.org/2000/svg" class="bx " width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3"/><path fill="currentColor" d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814"/></svg>
                        </button>
                    </div>
                </div>
                
                <!-- sección 1: cant cupos, menores de edad, usuario y paquete -->
                <div class="form-section active" id="section1" >
                    
                    <div class="contenedor-formulario">   
                        <div class="columna"><!-- inicip columna 1 --> 
                        <input type="hidden" id="idUser" name="idUser" value="<?php echo $sessionData['user']['idUser']; ?>">
                        <input type="hidden" id="idTrip" name="idTrip" value="<?php echo isset($_GET['idTrip']) ? $_GET['idTrip'] : $_POST['idTrip']; ?>">
                        <input type="hidden" id="vacant" name="vacant" value="<?php echo $dataTrip['data']['vacant']; ?>">
                        <input type="hidden" id="admin" name="admin" value="<?php echo $_GET['admin']; ?>">
                        <input type="hidden" id="minorMoney" name="minorMoney" value="0"> <!-- Nuevo input oculto para la cantidad de niños menores de 4 años -->
                       

                           <?php
                                $currentDate = date("Y-m-d"); // Obtener la fecha actual en formato YYYY-MM-DD
                            ?>
                            <input type="hidden" id="currentDate" name="currentDate" value="<?php echo $currentDate; ?>">

                            <label for="numTurista">¿Cuántos cupos quiere comprar?</label><span class="obligatorio">*</span>
                            <span class="help-icon" data-tooltip="Ingrese el número de cupos que quiere reservar, &#10;este es la cantidad de personas que iran al viaje."><?php echo HELP_ICON; ?></span>
                            <div class="errorMessage" id="errorMessagenumTurista"></div>
                            <input class="input-box" type="text" id="numTurista" name="numTurista" min="1" max="<?php echo $_GET['trip']['vacant']; ?>" placeholder="Ingrese una cantidad entre [1 ... <?php echo $_GET['trip']['vacant']. "]"; ?>">
                            <input type="hidden" id="trip_vacant" value="<?php echo $_GET['trip']['vacant'] ; ?>">
                           
                           
                            <label for="includeUser">¿Usted va incluido al Viaje?</label><span class="obligatorio">*</span>
                            <?php
                                if ($_SESSION['privilege'] == 'turista') {?>
                                   <span class="help-icon" data-tooltip="Si usted se incluye en el viaje se cargaran sus datos de usuario por defecto. &#10;De lo contareo debera rellenar los datos de las persona que viajaran."><?php echo HELP_ICON; ?></span>   
                                <?php } else if ($_SESSION['privilege'] === 'admin' || $_SESSION['privilege'] === 'publicista') { ?>
                                <span class="help-icon" data-tooltip=" Si forma parte del equipo Bitácora Oriental no se incluya como usuario, a menos que usted esté por costear su pasaje."><?php echo HELP_ICON; ?></span>      
                              <?php  }?>

                            <div class="errorMessage" id="errorMessageincludeUser"></div>
                            <label for="includeUser">SI</label>
                            <input class="radio-input" type="radio" id="user_yes" name="includeUser" value="SI" title="Si" >
                            <label for="includeUser">NO</label>
                            <input class="radio-input" type="radio" id="user_no" name="includeUser" value="NO" title="No" >
                            
                            <section>
                                <label id="lab"for="includeMinor">¿Incluye menores de edad?</label><span class="obligatorio">*</span>
                                <span class="help-icon" data-tooltip="Seleccione si viajara con menores de edad, debe haber un adulto responsable en cuestion. "><?php echo HELP_ICON; ?></span>   
                                <div class="errorMessage" id="errorMessageincludeMinor"><p></p></div>
                                <label for="includeMinor">SI</label>
                                <input class="radio-input" type="radio" id="minor_yes" name="includeMinor" value="SI" title="Si">
                                <label for="includeMinor">NO</label>
                                <input class="radio-input" type="radio" id="minor_no" name="includeMinor" value="NO" title="No">
                            </section>
                            <div id="numChildrenContainer" style="display:none;">                               
                                <label for="numChildren">Número de niños</label><span class="obligatorio">*</span>
                                <span class="help-icon" data-tooltip="Seleccione la cantidad de niños que iran en el viaje&#10;Todo niño debera viajar con un responsable."><?php echo HELP_ICON; ?></span>   
                                <div class="errorMessage" id="errorMessagenumChildren"></div>
                                <input class="input-box" type="text" id="numChildren" name="numChildren" min="1" max="<?php echo $_GET['trip']['vacant']-1 ; ?>" 
                                placeholder="Ingrese una cantidad entre [1 ... <?php echo $_GET['trip']['vacant']-1 . "]"; ?>">
                            </div>

                            <div class="ruta">
                                <h2>Ruta: <?php echo $dataTrip['data']['place']; ?></h2>
                                <?php
                                    $fecha = DateTime::createFromFormat('Y-m-d', $dataTrip['data']['departureDate']);
                                    $fechaFormateada = $fecha->format('d/m/Y');
                                ?>
                                <h2>Fecha de salida: <?php echo $fechaFormateada; ?></h2>

                            </div>
                        </div><!-- fin columna 1 -->

                        <div class="columna"><!-- inicio columna 2 -->
                            <section>
                                
                                <label for="idPackages">Seleccione el Paquete de Viaje</label><span class="obligatorio">*</span>
                                <span class="help-icon" data-tooltip="Seleccione un paquete de entre los existentes que mejor se adapte a sus necesidades. &#10;El precio del mismo se cobra por persona."><?php echo HELP_ICON; ?></span>   
                                <div class="errorMessage" id="errorMessageidPackages"></div>
                                <select class="custom-select" id="idPackages" name="idPackages" onchange="showDetails()">
                                    <option value="">Seleccionar Paquete</option>
                                    <?php if (count($dataToView["data"]) > 0) { ?>
                                        <?php foreach ($dataToView["data"] as $data) { ?>
                                            <option value="<?php echo htmlspecialchars($data['idPackages']); ?>">
                                                <?php echo htmlspecialchars($data['title']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="0">No hay paquetes disponibles</option>
                                    <?php } ?>
                                </select>
                            </section>
                            <section id="packageDetails">
                                <?php if (count($dataToView["data"]) > 0) { ?>
                                    <?php foreach ($dataToView["data"] as $data) { ?>
                                        <div class="packageDetail" id="packageDetail<?php echo htmlspecialchars($data['idPackages']); ?>" style="display:none;">
                                            <h3>Detalles del Paquete</h3>
                                            <p><strong>Título:</strong> <?php echo htmlspecialchars($data['title']); ?></p>
                                            <p><strong>Transporte:</strong> <?php echo htmlspecialchars($data['transport']); ?></p>
                                            <p><strong>Comida:</strong> <?php echo htmlspecialchars($data['food']); ?></p>
                                            <p><strong>Alojamiento:</strong> <?php echo htmlspecialchars($data['lodging']); ?></p>
                                            <strong>Descripción:</strong> <p class="descriptionPasager">
                                                <?php echo htmlspecialchars($data['description']); ?>
                                            </p>

                                            <p><strong>Precio:</strong><span class="price"><?php echo htmlspecialchars($data['amount']); ?></span>Bs.S/P.P</p>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </section>
                        </div><!-- fin columna 2 -->
                        <!-- campos obligatorios -->
                        <div class="text-grey">
                            <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                        </div>
                        <!-- botón de sección 2 -->
                        <div id="sec1" class="buttom-container" style="display: flex; justify-content: flex-end;">
                            <button id="generateFormButton" class="button-ant-sig" type="button" onclick="llama()" disabled style="opacity: 0.5; cursor: not-allowed;">Siguiente</button>
                            <button id="nextSectionButton" class="button-ant-sig" type="button" onclick="nextSection()" style="display: none;">Siguiente</button>
                        </div>


                       
                    </div>
                </div>

                <div class="form-section" id="section2">
           
                <div class="btReset">
                    <div class="header">
                        <div class="header-content">
                        <svg width="30" height="30" viewBox="0 0 16 16">
                            <g fill="none">
                                <path fill="url(#fluentColorPin160)" fill-rule="evenodd" d="m6.53 10.53l-3.25 3.25a.75.75 0 1 1-1.06-1.06l3.25-3.25z" clip-rule="evenodd"/>
                                <path fill="url(#fluentColorPin161)" d="M10.059 2.445a1.5 1.5 0 0 0-2.386.353l-2.02 3.79l-2.811.938a.5.5 0 0 0-.196.828l5 5a.5.5 0 0 0 .828-.196l.937-2.811l3.779-2.023a1.5 1.5 0 0 0 .354-2.38z"/>
                                <path fill="url(#fluentColorPin162)" fill-opacity="0.8" d="M10.059 2.445a1.5 1.5 0 0 0-2.386.353l-2.02 3.79l-2.811.938a.5.5 0 0 0-.196.828l5 5a.5.5 0 0 0 .828-.196l.937-2.811l3.779-2.023a1.5 1.5 0 0 0 .354-2.38z"/>
                                <defs>
                                    <linearGradient id="fluentColorPin160" x1="3.133" x2="8.986" y1="12.867" y2="8.201" gradientUnits="userSpaceOnUse">
                                        <stop offset=".114" stop-color="#7b7bff"/>
                                        <stop offset=".559" stop-color="#102784"/>
                                    </linearGradient>
                                    <linearGradient id="fluentColorPin161" x1="2.91" x2="10.844" y1="4.159" y2="12.392" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#43e5ca"/>
                                        <stop offset="1" stop-color="#1384b1"/>
                                    </linearGradient>
                                    <radialGradient id="fluentColorPin162" cx="0" cy="0" r="1" gradientTransform="rotate(47.615 -7.043 18.496)scale(5.10742 12.8119)" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#e362f8"/>
                                        <stop offset="1" stop-color="#96f" stop-opacity="0"/>
                                    </radialGradient>
                                </defs>
                            </g>
                        </svg>

                            <h2>Pasajero 1 (Usted)</h2>
                            <span class="help-icon" data-tooltip="Estos son sus datos.&#10;No los añada en los demás espacios del formulario."><?php echo HELP_ICON; ?></span>   

                        </div>
                    </div>
                    <div><!-- Añade aquí el contenido adicional --></div>
                </div>

                
                    <div class="contenedor-formulario">
                        <div class="columna">
                            <label for="user_name">Nombre</label>
                            <input class="input-box" type="text" id="user_name" name="user_name" maxlength="50" placeholder="Ingrese su Nombre" value="<?php echo $sessionData['user']['name']; ?>" disabled>
                        </div>
                        <div class="columna">
                            <label for="user_lastName">Apellido</label>
                            <input class="input-box" type="text" id="user_lastName" name="user_lastName" maxlength="50" placeholder="Ingrese su Apellido" value="<?php echo $sessionData['user']['lastName']; ?>" disabled>
                        </div>
                    </div>

                    <div class="contenedor-formulario">
                            <div class="columna">
                                <label for="user_ci">Cédula de Identidad</label>
                                <input class="input-box" type="text" id="user_ci" name="user_ci" maxlength="20" placeholder="Ingrese su Cédula de Identidad" value="<?php echo $sessionData['user']['ci']; ?>" disabled>
                            </div>
                            <div class="columna">
                                <label for="user_birthDate">Fecha de Nacimiento</label>
                                <input class="input-box" type="date" id="user_birthDate" name="user_birthDate" value="<?php echo $sessionData['user']['birthDate']; ?>" disabled>
                            </div>
                        </div>

                        <div class="contenedor-formulario">
                            <div class="columna">
                                <label for="user_phone">Teléfono</label>
                                <input class="input-box" type="tel" id="user_phone" name="user_phone" maxlength="20" placeholder="Ingrese su Teléfono" value="<?php echo $sessionData['user']['phone']; ?>" disabled>
                            </div>
                            <div class="columna">
                                <label for="user_estado">Estado</label>
                                <select class="custom-select" name="user_estado" id="user_estado" disabled>
                                    <option value="<?php echo $row[0]['estado']; ?>"><?php echo $row[0]['estado']; ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="contenedor-formulario">
                            <div class="columna">
                                <label for="user_municipio">Municipio</label>
                                <select class="custom-select" name="user_municipio" id="user_municipio" disabled>
                                    <option value="<?php echo $row[0]['municipio']; ?>"><?php echo $row[0]['municipio']; ?></option>
                                </select>
                            </div>
                            <div class="columna">
                                <label for="user_parroquia">Parroquia</label>
                                <select class="custom-select" name="user_parroquia" id="user_parroquia" disabled>
                                    <option value="<?php echo $row[0]['parroquia']; ?>"><?php echo $row[0]['parroquia']; ?></option>
                                </select>
                            </div>
                        </div>

                        <label for="user_address">Dirección</label>
                        <input class="input-box" type="text" id="user_address" name="user_address" maxlength="100" placeholder="Ingrese su Dirección" value="<?php echo $sessionData['user']['address']; ?>" disabled>
                        
                        <div class="buttom-container">
                            <button class="button-ant-sig" type="button" onclick="previousSection()">Anterior</button>
                            <button class="button-ant-sig"  id="nextButton2" type="button" onclick="nextSection()">Siguiente</button>
                        </div>
                </div>
                 <!--FIN DE LAA SEECION 2  -->
                            


                <!-- sección 3: datos de las personas a viajar -->
                <div class="form-section" id="section3">
                    <div id="passengerForms">
                        <!-- Aquí se generarán los formularios dinámicamente -->
                    </div>
                    <div class="buttom-container">
                        <button class="button-ant-sig" type="button" onclick="previousSection()">Anterior</button>
                    
                        <button class="button-ant-sig" id="nextButton3" type="button" onclick="nextSection()">Siguiente</button>
                    </div>
                </div> <!-- fin sección 3: datos de las personas a viajar -->


                 <!-- sección 4: datos de las personas a viajar -->
                <div class="form-section" id="section4">
                
                <div id="minorFormsContainer">
                    <!-- Aquí se generarán los formularios de los niños dinámicamente -->
                </div>
                <div class="text-grey">
                            <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                        </div>
                    <div class="buttom-container">
                        <button class="button-ant-sig" id="previoButton4" type="button" onclick="previousSection()">Anterior</button>
                    </div>
                </div>

                <!-- botones de enviar y cancelar -->
                <div class="buttom-container">
                    <input class="button-login-register" id="addRequestsReservation" type="submit" title="Añadir" value="Añadir" name="addRequestsReservation">
                    <a class="button-Rev"  href="index.php?controller=home&action=homeInformation"  title="Cancelar">Cancelar</a>
                </div>

            </form>
			</div>
        </div>
    </div>
</main>

<script src="asset\js\requests\dynamicForm1.js"></script>
<script src="asset\js\requests\dynamicForm2.js"></script>
<script src="asset\js\requests\dynamicForm3.js"></script>
<script src="asset\js\validations\reservationValidation.js"></script>
<script src="asset/js/scripts/helpForm.js"></script>

<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="reservation"></div>
<script src="asset/js/scripts/alert.js"></script>
<script> window.onload = function() { if (window.history.replaceState) { window.history.replaceState(null, null, window.location.href); } }; </script>
