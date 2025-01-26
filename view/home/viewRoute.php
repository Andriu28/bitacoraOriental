
<?php  
// Verifica si hay datos para mostrar
    // Itera sobre cada elemento en los datos
    foreach ($dataToView["data"]["route"] as $data) { ?>
        
        <li class="card-item swiper-slide">
            <div  class="card-link">
                <div class="card__img">
                    <!-- Muestra la imagen del lugar -->
                    <img src="<?php echo $data['image']; ?>" alt="Card Image" class="card-image">
                    <span class="card__span"><?php echo $data['place']; ?></span>
                </div>
                <div class="card-int">
                    <h2 class="card-int__title" style="opacity: 0; position: absolute; z-index: -1;">
                        Sector: <?php echo $data['location']  ?>
                        <br>Parroquia: <?php echo ucwords(strtolower($data['parroquia'])); ?>
                        <br>Municipio: <?php echo ucwords(strtolower($data['municipio'])); ?> 
                        <br>Estado: <?php echo ucwords(strtolower($data['estado'])); ?> 
                    </h2>
                    <p class="excerpt"><?php echo $data['description']; ?></p>
                    <button class="button-Rev2 detailHome">Ver más</button>                    
                </div>

            </div>
        </li>
               
    <?php  } ?>


   


