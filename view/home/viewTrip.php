
<?php  
// Verifica si hay datos para mostrar
    // Itera sobre cada elemento en los datos
    foreach ($dataToView["data"]["trip"] as $data) { ?>
        
    <div class="packages_items">
        <div class="pack_card">

        <div class="header">
            <div class="header-content">
         
                <img class="route_logo"width="50" height="50" src="<?php echo $data['imageUrl']; ?>" alt="Logo" />  
            <h2 class="header-title">
                    <?php echo $data['title']; ?>
                </h2>
            </div>
        </div>
    
            <div class="lists">  

                <div class="list">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Ruta:</p><span><?php echo $data['place'] ?></span>
                </div>
                <div class="list">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Estado:</p> 
                         <span > <?php echo ucwords(strtolower($data['estado'] )); ?>   </span>
                </div>

                <div class="list">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Lugar de salida:</p><span><?php echo $data['departureLocation'] ?></span>
                </div>
                <!-- <p style="text-indent: 2em;"></p> -->
                <div class="list">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Fecha y Hora de Salida :</p>
                </div>
                <p style="text-indent: 2em;"><?php echo date("d/m/Y", strtotime($data['departureDate'])) . " " . date("g:i A", strtotime($data['departureTime'])) ?></p>

                <div class="list">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Fecha y Hora de Regreso:</p>
                </div>
                <p style="text-indent: 2em;"><?php echo date("d/m/Y", strtotime($data['returnDate'])) ." ". date("g:i A", strtotime($data['returnTime']))  ?></p>

                <div class="list">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                      <p  >Cupos:</p><span  class="price"><?php echo $data['vacant'] ?></span>
                      
                </div> 
                <?php if( $data['vacant'] == 0) {?> 
                    <div class="bottom_red" title="Ya está Agotado"> <!-- Botón para reservar el paquete --> 
                    Agotado
                    </div>
                <?php } else{ ?>   
                <div class="bottom"> <!-- Botón para reservar el paquete --> 
                    <a class="btn"  href="index.php?controller=reservation&action=requestReservation&idTrip=<?php echo $data['idTrip'] ?>" title="Añadir">Hacer Reservación</a>
                </div>
                <?php } ?>
                </div>    
            
            </div> 
        </div>  
               
    <?php  
    }

?>

