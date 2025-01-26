
<?php  
// Verifica si hay datos para mostrar
    // Itera sobre cada elemento en los datos
    foreach ($dataToView["data"]["packages"] as $data) { ?>
        
        <div class="packages_items">
            <div class="pack_card_packages">
                
                <div class="pack_name"><?php echo $data['title']; ?></div>
        
                <p class="description" style="text-align: justify;">
                    <?php echo $data['description']; ?>
                </p>
        
                <div class="lists">
                    <!-- Lista de características del paquete -->
                    <div class="list">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Transporte:</p><span><?php echo $data['transport']; ?></span>
                    </div>

                    <div class="list">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Comida:</p><span><?php echo $data['food']; ?></span>
                    </div>

                    <!-- Repetido: Asegúrate de que cada lista tenga un propósito único -->
                    <div class="list">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Logistica:</p><span><?php echo $data['lodging']; ?></span>
                    </div>
                   
                </div>

               
                    <div class="price_container">
                        <span class="devise"><?php echo MONETARY_UNIT ?></span>
                        <span class="price"><?php echo $data['price']; ?></span>
                        <span class="date">/Cupo</span>
                    </div>
                    <!-- Botón para reservar el paquete -->
                   
            
            </div> 
        </div>  
               
    <?php  
    }
