

<?php  
// Verifica si hay datos para mostrar
    // Itera sobre cada elemento en los datos
    foreach ($dataToView["data"]["pubSpecial"] as $data) { ?>
        
        <li class="card-item swiper-slide">
            <div class="card-link">   
                <div class="card__img">
                    <img src="<?php echo $data['image']; ?>" alt="Card Image" class="card-image">
                    <span class="card__span"><?php echo $data['title']; ?></span>
                    <!-- Muestra la imagen del lugar -->
                </div>
                <div class="card-int">
                    <p class="excerpt"><?php echo $data['description']; ?></p>
                </div>
                <button class="button-Rev2 detailHome" >Ver más</button>                    
             </div>
        </li>
<?php   } ?>
   

