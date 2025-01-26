

<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT); 
$sessionData['user'] = $objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
?>

<link rel="stylesheet" href="asset/css/userPanel.css">


<?php require_once(MODEL_PATH."address.php"); ?>

    <div class="container-userPanel">
    <div class="header"> <div class="titleModulos"> 
        <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor"> 
            <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path> 
        </svg> 
        <h2>Panel de Usuario</h2> </div> 
        <div class="back-button-container">
        <a  title="Regresar" href="index.php?controller=home&action=homeInformation" >
            <?php echo portalReturn ?><!-- SVG -->
        </a>
    </div> 
    </div>
        <div class="profile-summary">
            <label>Email</label>
            <div class="email-box">
                <span class="email"><?php echo $sessionData['user']['email']; ?></span>
            </div>
            <div class="button-container">                
            </div>
        </div>
        <form class="profile-form" id="formRegister" action="index.php?controller=users&action=editData" method="POST">
            <input type="hidden" id="idPerson" name="idPerson" value="<?php echo $sessionData['user']['idPerson']; ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nombre<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su primer nombre si es necesario."><?php echo HELP_ICON; ?></span></label>
                    <input type="text" id="name" name="name" title="Nombre" value="<?php echo $sessionData['user']['name']; ?>" disabled>
                    <div class="errorMessage" id="errorMessagename"></div>
                </div>
                <div class="form-group">
                    <label for="lastName">Apellido<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su primer apellido si es necesario."><?php echo HELP_ICON; ?></span></label>
                    <input type="text" id="lastName" name="lastName" title="Apellido" value="<?php echo $sessionData['user']['lastName']; ?>" disabled>
                    <div class="errorMessage" id="errorMessagelastName"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="ci">Cédula<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su número de cédula si es necesario. Ejemplo: 12345678"><?php echo HELP_ICON; ?></span></label>
                    <input type="text" id="ci" name="ci" title="Cédula" value="<?php echo $sessionData['user']['ci']; ?>" disabled>
                    <div class="errorMessage" id="errorMessageci"></div>
                </div>
                <div class="form-group">
                    <label for="birthDate">Fecha de nacimiento<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su fecha de nacimiento si es necesario. Debe ser mayor de edad."><?php echo HELP_ICON; ?></span></label>
                    <input type="date" id="birthDate" name="birthDate" title="Fecha de cumpleaños" value="<?php echo $sessionData['user']['birthDate']; ?>" disabled>
                    <div class="errorMessage" id="errorMessagebirthDate"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Teléfono<span class="grey-text">(opcional) <span class="help-icon" data-tooltip="Modifique su número de teléfono si es necesario. Ejemplo: 04241234567, 04121234567"><?php echo HELP_ICON; ?></span></span></label>
                    <input type="text" id="phone" name="phone" title="Teléfono" value="<?php if($sessionData['user']['phone'] !== 'POR ASIGNAR'){ echo $sessionData['user']['phone']; } ?>" placeholder="<?php echo $sessionData['user']['phone']; ?>" disabled>
                    <div class="errorMessage" id="errorMessagephone"></div>
                </div>
                <div class="form-group">
                    <label for="address">Dirección<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Modifique su dirección completa si es necesario. Ejemplo: Calle 12, Nº 34, Urbanización Las Rosas"><?php echo HELP_ICON; ?></span></label>
                    <input type="text" id="address" name="address" title="Dirección" value="<?php echo $sessionData['user']['address']; ?>" disabled>
                    <div class="errorMessage" id="errorMessageaddress"></div>
                </div>
            </div>

            <?php
            $aux = $address->getDependence($sessionData['user']['idParroquia']);
            if (count($aux) > 0) {
                foreach ($aux as $row) {
            ?>

            <label for="estado">Estado<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione el estado donde reside."><?php echo HELP_ICON; ?></span></label>
            <select name="estado" id="estado" disabled>
                <option value=""><?php echo $row['estado']; ?></option>
                <?php
                $result = $address->addressEdo();
                if (count($result) > 0) {
                    foreach ($result as $data) {
                        echo '<option value="' . $data['id_e'] . '">' . $data['estado'] . '</option>';
                    }
                }
                ?>
            </select><br>

            <label for="municipio">Municipio<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione el municipio donde reside."><?php echo HELP_ICON; ?></span></label>
            <select name="municipio" id="municipio" disabled>
                <option value=""><?php echo $row['municipio']; ?></option>
            </select>

            <label for="parroquia">Parroquia<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Seleccione la parroquia donde reside."><?php echo HELP_ICON; ?></span></label>
            <select name="parroquia" id="parroquia" disabled>
                <option value="<?php echo $sessionData['user']['idParroquia']; ?>"><?php echo $row['parroquia']; ?></option>
            </select>
            <?php
                }
            }
            ?>
            <div class="errorMessage" id="errorMessageparroquia"></div> 

            <div class="button-container" id="formButtons" style="display: none;">
                <button type="submit">Guardar</button>
                <button type="reset" id="cancelBtn">Cancelar</button>
            </div>
            <div class="button-container">
                <button type="button" id="editBtn">Editar</button>
            </div>
        </form>


    
    <script src="asset/js/scripts/helpForm.js"></script>
<script src="asset/js/requests/requestsRoute.js"></script> 
<script src="asset/js/scripts/userPanelEdit.js"></script>
<script src="asset/js/validations/registerValidationForm.js"></script>
<!--////////////////////////////////// Switc alert //////////////////////////////////-->
<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="userPanel"></div>
<script src="asset\js\scripts\alert.js"></script>
<!--////////////////////////////////// Data Table //////////////////////////////////-->
