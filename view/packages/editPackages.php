
<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>  
<main >
<div class="contenedor-nuevo">
  <div class="caja-register">
    <div class="formulario-login-registro">
        <form id="formPackages" edit="editData" action="index.php?controller=packages&action=edit&id=<?php echo $dataToView['data']['idPackages']; ?>" method="POST">
        <div class="btReset">
                    <div class="header">
                        <div class="header-content">
                        <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                             <path d="M22 8a.76.76 0 0 0 0-.21v-.08a.77.77 0 0 0-.07-.16.35.35 0 0 0-.05-.08l-.1-.13-.08-.06-.12-.09-9-5a1 1 0 0 0-1 0l-9 5-.09.07-.11.08a.41.41 0 0 0-.07.11.39.39 0 0 0-.08.1.59.59 0 0 0-.06.14.3.3 0 0 0 0 .1A.76.76 0 0 0 2 8v8a1 1 0 0 0 .52.87l9 5a.75.75 0 0 0 .13.06h.1a1.06 1.06 0 0 0 .5 0h.1l.14-.06 9-5A1 1 0 0 0 22 16V8zm-10 3.87L5.06 8l2.76-1.52 6.83 3.9zm0-7.72L18.94 8 16.7 9.25 9.87 5.34zM4 9.7l7 3.92v5.68l-7-3.89zm9 9.6v-5.68l3-1.68V15l2-1v-3.18l2-1.11v5.7z"></path>
                            </svg>
                            <h2>Editar paquete de viaje</h2>
                        </div>
                    </div>
                    <div>
                    <button type="reset" title="Restaurar" class="reset-button"> 
                            <svg xmlns="http://www.w3.org/2000/svg" class="bx " width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3s-3 1.331-3 3s1.329 3 3 3"/><path fill="currentColor" d="M20.817 11.186a8.9 8.9 0 0 0-1.355-3.219a9 9 0 0 0-2.43-2.43a9 9 0 0 0-3.219-1.355a9 9 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a7 7 0 0 1 2.502 1.053a7 7 0 0 1 1.892 1.892A6.97 6.97 0 0 1 19 13a7 7 0 0 1-.55 2.725a7 7 0 0 1-.644 1.188a7 7 0 0 1-.858 1.039a7.03 7.03 0 0 1-3.536 1.907a7.1 7.1 0 0 1-2.822 0a7 7 0 0 1-2.503-1.054a7 7 0 0 1-1.89-1.89A7 7 0 0 1 5 13H3a9 9 0 0 0 1.539 5.034a9.1 9.1 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9 9 0 0 0 1.814-.183a9 9 0 0 0 3.218-1.355a9 9 0 0 0 1.331-1.099a9 9 0 0 0 1.1-1.332A8.95 8.95 0 0 0 21 13a9 9 0 0 0-.183-1.814"/></svg>
                    </button>
                    </div>
                </div>
        
        
            
                <label for="title">Título<span class="obligatorio">*</span>  <span class="help-icon" data-tooltip="Ingrese el título del paquete.  &#10; Ejemplo: VIP"><?php echo HELP_ICON; ?></span></label><br>
                <div class="errorMessage" id="errorMessagetitle"><p></p></div>
                <input class="input-box" type="text" id="title" name="title" title="Ingrese un título" placeholder="Ingrese un título" value="<?php echo $dataToView['data']['title']; ?>"><br>               
        
                <label for="price">Precio (<?php echo MONETARY_UNIT; ?>)<span class="obligatorio">*</span> <span class="help-icon" data-tooltip="Ingrese el precio del paquete en <?php echo MONETARY_UNIT; ?>. &#10;(Este seria el precio de los añadidos del viaje). &#10; Ejemplo: 250.00"><?php echo HELP_ICON; ?></span></label><br>
                <div class="errorMessage" id="errorMessageprice"><p></p></div>
                <input class="input-box" type="text" id="price" name="price" title="Ingrese el precio" placeholder="Ingrese el precio" value="<?php echo $dataToView['data']['price']; ?>"><br>

                <label for="description">Descripción<span class="obligatorio">*</span><span class="help-icon" data-tooltip="Ingrese una descripción detallada del paquete.  &#10;Ejemplo: Un emocionante tour de 3 días y 2 noches a de campamento,  &#10;con actividades de senderismo y observación de fauna."><?php echo HELP_ICON; ?></span></label><br>
                <div class="errorMessage" id="errorMessagedescription"><p></p></div>
                <input class="input-box" type="text" id="description" name="description" title="Ingrese una descripción" placeholder="Ingrese una descripción" value="<?php echo $dataToView['data']['description']; ?>"><br>
                

                <div class="section-radiobox">
                    <div class="radio-box-space">
                        <label for="transport">Transporte<span class="obligatorio">*</span></label>
                        <div class="errorMessage" id="errorMessagetransport"><p></p></div>
                        <div class="radio-separation">
                            <label for="transport_yes">SI
                                <input class="radio-input" type="radio" id="transport_yes" name="transport" value="SI" title="Transporte" <?php if($dataToView['data']['transport'] === 'SI'){ echo 'checked';} ?>>
                            </label>
                            <label for="transport_no">NO
                                <input class="radio-input" type="radio" id="transport_no" name="transport" value="NO" title="Transporte" <?php if($dataToView['data']['transport'] === 'NO'){ echo 'checked';} ?>>
                            </label>
                        </div>
                    </div>
                    
                    <div class="radio-box-space">
                        <label for="food">Comida<span class="obligatorio">*</span></label>
                        <div class="errorMessage" id="errorMessagefood"><p></p></div>
                        <div class="radio-separation">
                            <label for="food_yes">SI
                                <input class="radio-input" type="radio" id="food_yes" name="food" value="SI" title="Comida" <?php if($dataToView['data']['food'] === 'SI'){ echo 'checked';} ?>>
                            </label>
                            <label for="food_no">NO
                                <input class="radio-input" type="radio" id="food_no" name="food" value="NO" title="Comida" <?php if($dataToView['data']['food'] === 'NO'){ echo 'checked';} ?>>
                            </label>
                        </div>
                    </div>
                    
                    <div class="radio-box-space">
                        <label for="lodging">Hospedaje<span class="obligatorio">*</span></label>
                        <div class="errorMessage" id="errorMessagelodging"><p></p></div>
                        <div class="radio-separation">
                            <label for="lodging_yes">SI
                                <input class="radio-input" type="radio" id="lodging_yes" name="lodging" value="SI" title="Hospedaje" <?php if($dataToView['data']['lodging'] === 'SI'){ echo 'checked';} ?>>
                            </label>
                            <label for="lodging_no">NO
                                <input class="radio-input" type="radio" id="lodging_no" name="lodging" value="NO" title="Hospedaje" <?php if($dataToView['data']['lodging'] === 'NO'){ echo 'checked';} ?>>
                            </label>
                        </div>
                    </div>    
                </div>

            
                <div class="text-grey">
                    <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                </div>

                <div class="buttom-container">
                    <input class="button-login-register" id="send" type="submit" title="Editar" value="Editar" name="send">
                    <a href="index.php?controller=packages&action=list" title="Cancelar" class="button-Rev">Cancelar</a>
                </div>
        </form>


    <script src="asset/js/scripts/helpForm.js"></script>
    <script src="asset/js/validations/packagesValidationForm.js"></script>
    <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="packages" ></div>
    <script src="asset/js/scripts/alert.js"></script>

    
    </div>
        </div>
    </div>
</main>

