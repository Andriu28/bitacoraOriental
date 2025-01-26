
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
//          Inicio Seccion | Portada
////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<section class="hero_section">
    <div class="section_container">
        <div class="hero_container">
            <div class="text_section">
                <h2>¡Bienvenidos a Bitácora Oriental!</h2>  

                <div class="containerS">
                    <div class="text_sectionS">
                        <h3>Disfruta de tus vacaciones con nosotros</h3> 
                        <p> 
                            En Bitácora Oriental, creemos que viajar es más que simplemente visitar lugares;
                            es una oportunidad para aprender, crecer y crear recuerdos 
                            inolvidables.
                            <br><br>
                            Nuestra misión es inspirar y guiar a los viajeros a 
                            descubrir los destinos más fascinantes, desde las joyas ocultas hasta los 
                            lugares icónicos que todos soñamos visitar. Fieles a Nuestra Pasión
                            
                            
                        </p>
                    </div>
                    <div class="image_sectionS" id="image_container">
                        <!-- Aquí puedes colocar la imagen que desees -->
                        <img src="asset/IconoBitacoraO/imgPortal-removebg.png" width="150px" height="200px" alt="Imagen Descriptiva" id="responsive_image">
                    </div>
                </div>

                <div class="hero_section_button">
                    <?php 
                    // Verifica si el usuario no está autenticado
                    if (!isset($_SESSION['user'])) { 
                    ?>
                        <!-- Botón para iniciar sesión -->     
                        <a href="index.php?controller=users&action=loginView" title="Iniciar Sesion">
                            <button class="button">Inicia sesión</button>
                        </a>

                        <!-- Botón para registrarse -->   
                        <a href="index.php?controller=users&action=register" title="Registrate">
                            <button class="button">Registrate</button>
                        </a>

                    <?php 
                    }
                    ?>
                </div>
            </div> 
            <div id="img"></div>
         
        </div>  
    
    
            <span id="rutes"></span> </div> 
</section>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
//          Inicio Seccion | Rutas
////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php  if (!empty($dataToView["data"]["route"])) {   ?> 
   
<section class="services" >
    <br> <br>
    <h2 class="section_title">Rutas</h2>
    <div class="section_container">
        <div class="service_container">
            <div class="swiper">
                <div class="card-wrapper">
                    <!-- Card slides container -->
                    <ul class="card-list swiper-wrapper">   
                        <?php 
                        // Llama a los datos de las rutas y los incluye en la vista
                        require_once "view/home/viewRoute.php"; 
                        ?> 
                    </ul>
                    <div class="swiper-pagination"></div><!-- Pagination -->
                    <!-- Navigation Buttons -->
                    <div class="swiper-slide-button swiper-button-prev"></div>
                    <div class="swiper-slide-button swiper-button-next"></div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php } ?>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
//          Inicio Seccion | Ofertas de Viaje
////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php  if (!empty($dataToView["data"]["trip"])) {   ?> 
<span id="trip"></span>
<section class="packages" >
    <h2 class="section_title">Ofertas de Viaje</h2>
    <div class="section_container">
        <div class="packages_container">

            <?php 
                // Llama a los datos de los paquetes y los incluye en la vista
                require_once "viewTrip.php"; 
            ?>  
        </div>
    </div>
</section>
<?php } ?> 
 
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
//          Inicio Seccion | Paquetes de Viaje
////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php  if (!empty($dataToView["data"]["packages"])) {   ?> 
    <span id="packages"></span>
<section class="packages">
    <h2 class="section_title">Paquetes de Viaje</h2>
    <div class="section_container">
        <div class="packages_container">
            <?php 
                // Llama a los datos de los paquetes y los incluye en la vista
                require_once "viewPackage.php"; 
            ?>  
        </div>
    </div>
    <span id="pubSpecial"></span>  
</section>

<?php  }   ?> 
    

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
//          Inicio Seccion | Publicaciones Especiales
////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php  if (!empty($dataToView["data"]["pubSpecial"])) {   ?>   
<section class="services"  >
    <h2 class="section_title">Publicaciones Especiales</h2>
    <div class="section_container">
        <div class="service_container">

            <div class="swiper">
                <div class="card-wrapper">

                    <!-- Card slides container -->
                    <ul class="card-list swiper-wrapper">  
                        <?php 
                            // Llama a los datos de las rutas y los incluye en la vista
                             require_once "viewPubSpecial.php"; 
                        ?> 
                    </ul>
                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>

                    <!-- Navigation Buttons -->
                    <div class="swiper-slide-button swiper-button-prev"></div>
                    <div class="swiper-slide-button swiper-button-next"></div>
                </div>
            </div>

        </div>  
    </div>
    <span id="faquestion"></span>
</section>
<?php } ?> 

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
//          Inicio Seccion | Preguntas Frecuentes
////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php  if (!empty($dataToView["data"]["faq"])) {   ?> 
<section class="faq_fre">
    <h2 class="section_title">Preguntas Frecuentes</h2>
    <div class="section_container">

        <div class="faq_accordion">
           <?php 
                // Llama a los datos de las preguntas frecuentes y los incluye en la vista
                require_once "view/home/viewFaq.php"; 
            ?> 
        </div>

    </div>
</section>
<?php  }   ?>



<!-- linking Javascript Pregutnas -->
<script src="asset\js\app\scri.js"></script>

<!-- Linking custom script -->
<script src="asset\js\app\scriptSlider.js"></script>


<!-- ---------------------- manedo de alertas ---------------------- -->
<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="home"></div>
<script src="asset\js\scripts\alert.js"></script>   
<!-- --------------------------------------------------------------- -->





<script> window.onload = function() { if (window.history.replaceState) { window.history.replaceState(null, null, window.location.href); } }; </script>
