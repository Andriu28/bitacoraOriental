
<?php if(isset($_GET['barco']) && !empty($_GET['barco'])): 
  $data = $_GET['barco'];
  $tourist =   $_GET['barco']['tourist'];
  $minior = $_GET['barco']['minior'];
?>
    <!-- Caja que se sobrepone a toda la pantalla -->
    <div id="overlay-box">
        <div class="overlay-content">
            <div class="alert-title "><?php echo $_GET['status'] === 'A' ||  $_GET['status'] === 'C' ? 'Reservación de viaje': 'Solicitud reservación' ?></div>

        <!-- seccion1 -->
    
        <div class="form-section active" id="section1">
            <div class="custom-alert-container">
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Usuario:</span>
                    <span class="custom-alert-value"><?php echo $data['name']." ".$data['lastName']; ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Correo:</span>
                    <span class="custom-alert-value"><?php echo $data['email'] ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Teléfono:</span>
                    <span class="custom-alert-value"><?php echo $data['phone'] ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Fecha de reservación:</span>
                    <span class="custom-alert-value"><?php $fecha = date("d/m/Y", strtotime($data['departureDate']));
                                                            echo $fecha ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Fecha del viaje:</span>
                    <span class="custom-alert-value"><?php  $fecha = date("d/m/Y", strtotime($data['reservationDate']));
                                                     echo $fecha ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Viaje:</span>
                    <span class="custom-alert-value"><?php echo $data['title_trip']." - ".$data['price_trip']." Bs.S" ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Paquete:</span>
                    <span class="custom-alert-value"><?php echo $data['title_travel']." - ".$data['price_travel']." Bs.S" ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Precio por persona:</span>
                    <span class="custom-alert-value"><?php echo $data['price_person']." Bs.S"?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Cant de cupos:</span>
                    <span class="custom-alert-value"><?php echo $data['numberSlots'] ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Adultos:</span>
                    <span class="custom-alert-value"><?php echo $data['cantTourist'] ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Menor de edad:</span>
                    <span class="custom-alert-value"><?php echo $data['cantMinor'] ?></span>
                </div>
                <div class="custom-alert-section">
                    <span class="custom-alert-label">Monto total:</span>
                    <span class="custom-alert-value"><?php echo $data['amount']." Bs.S" ?></span>
                </div>
            </div>
        </div> 
        <?php for ($i = 1; $i <= count($tourist); $i++) { ?>
            
            <!-- seccion touriste-->
            <div class="form-section" > 
            <div class="header"><b>Pasajero <?php echo $i ?>:</b></div>
                <div class="custom-alert-container">
            
                    <div class="custom-alert-section">
                        <span class="custom-alert-label">Nombre:</span>
                        <span class="custom-alert-value"><?php echo $tourist[$i-1]['name']." ".$tourist[$i-1]['lastName']?></span>
                    </div>
                    <div class="custom-alert-section">
                        <span class="custom-alert-label">Cédula:</span>
                        <span class="custom-alert-value"><?php echo number_format($tourist[$i-1]['ci'], 0, '', '.'); ?></span>
                    </div>
                    <div class="custom-alert-section">
                        <span class="custom-alert-label">Teléfono:</span>
                        <span class="custom-alert-value"><?php echo $tourist[$i-1]['phone']?></span>
                    </div>
                    <div class="custom-alert-section">
                        <span class="custom-alert-label">Estado:</span>
                        <span class="custom-alert-value"><?php echo $tourist[$i-1]['estado']?></span>
                    </div>
                    <div class="custom-alert-section">
                        <span class="custom-alert-label">Municipio:</span>
                        <span class="custom-alert-value"><?php echo $tourist[$i-1]['municipio']?></span>
                    </div>
                    <div class="custom-alert-section">
                        <span class="custom-alert-label">Parroquia:</span>
                        <span class="custom-alert-value"><?php echo $tourist[$i-1]['parroquia']?></span>
                    </div>
                    <div class="custom-alert-section">
                        <span class="custom-alert-label">Dirección:</span>
                        <span class="custom-alert-value"><?php echo $tourist[$i-1]['address']?></span>
                    </div>
            
                </div>

            </div>
        
        <?php  } ?>  
       
        <?php if( count($minior) > 0 ){ ?>

            <?php for ($i = 0; $i < count($minior); ) { ?>
                <div class="form-section">
                    <?php for ($j = 0; $j < 3; $j++) { ?>
                        <?php if (isset($minior[$i])) { ?>
                        <br>  
                        <div class="header"><b> Menor de edad  <?php echo $i+1 ?></b> </div>
                        <div class="custom-alert-container">
            
                            <div class="custom-alert-section">
                                <span class="custom-alert-label">Edad:</span>
                                <span class="custom-alert-value"><?php echo$minior[$i]['age']." años";?></span>
                            </div>
                            <div class="custom-alert-section">
                                <span class="custom-alert-label">Género:</span>
                                <span class="custom-alert-value"><?php echo $minior[$i]['sex']==='f'? 'Femenino': 'Masculino';?></span>
                            </div>
                            <div class="custom-alert-section">
                                <span class="custom-alert-label">Responsable:</span>
                                <span class="custom-alert-value"><?php echo $minior[$i]['name']." ".$minior[$i]['lastName']?></span>
                            </div>
                        </div> 
                             
                           
                        
                     <?php   }
                             $i++; ?>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php } else { ?>

            <div class="form-section">
            <p class="no-minors-message">No hay Menores de edad</p>

            </div>

         <?php } ?>

        <!-- seccion de botones -->
        <div class="button-container" >
            <button id="prevBtn" title="Anterior" onclick="previousSection()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20 9v6h-8v4.84L4.16 12L12 4.16V9z"/>
                </svg>
            </button>
            <button id="nextBtn" title="Siguiente" onclick="nextSection()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4 15V9h8V4.16L19.84 12L12 19.84V15z"/>
                </svg>
            </button>
        </div>
            <button onclick="hideOverlay()">OK</button>
        </div>
    </div>


<?php endif; ?>

<script>
// Función para mostrar la caja
function visible() {
    document.getElementById('overlay-box').style.display = 'block';
}

// Función para ocultar la caja
function hideOverlay() {
    document.getElementById('overlay-box').style.display = 'none';
}

// Detectar el clic en el enlace y mostrar la caja si 'barco' está lleno
document.addEventListener('DOMContentLoaded', (event) => {
    const barco = <?php echo isset($_GET['barco']) ? json_encode($_GET['barco']) : 'null'; ?>;
    const overlayBox = document.getElementById('overlay-box');

    // Verificar que el elemento overlay-box existe
    if (overlayBox) {
        if (barco) {
            visible(); // Llamar a la función para mostrar la caja
        }

        // Añadir un event listener para detectar clics fuera de la caja
        overlayBox.addEventListener('click', function(e) {
            if (e.target === this) {
                hideOverlay(); // Ocultar la caja si se hace clic fuera del contenido
            }
        });
    } 
});
</script>
