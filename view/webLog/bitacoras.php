<section class="hero_section">
    <div class="section_container">
        <div class="text_section">
            <div class="body">
                <div role="main" class="main">        
                    <div class="containerBitacora py-4">
                        <div class="header"><div class="titleModule">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 36 36"><ellipse cx="18" cy="30.54" fill="#3b88c3" rx="18" ry="5.36"/><path fill="#88c9f9" d="M33.812 28.538c0 1.616-2.5 2.587-14.482 2.587c-10.925 0-13.612-.971-13.612-2.587s5.683-2.926 13.612-2.926s14.482 1.31 14.482 2.926"/><path fill="#f4900c" d="M7 28.25c0-1 1-5 11-5c12 0 15 4 15 5s0 2-14 2c-12 0-12-1-12-2"/><circle cx="7" cy="6.25" r="5" fill="#ffcc4d"/><circle cx="7" cy="6.25" r="4" fill="#ffac33"/><path fill="#c1694f" d="M26.949 14.467a21 21 0 0 0-.524-3.459a22 22 0 0 0-1.001-3.158c-.377-.929-.674-1.46-.674-1.46l-2.583.333s.298.622.621 1.841c.131.495.265 1.09.386 1.784a26 26 0 0 1 .343 2.948q.036.555.053 1.158c.004.146.011.287.013.437c.007.469-.026.946-.084 1.422q-.081.644-.223 1.279a19 19 0 0 1-.479 1.77c-.149.46-.308.901-.468 1.316a35 35 0 0 1-.707 1.687c-.358.798-.622 1.33-.622 1.441c0 .351.25 1.007 2 1.444c2.736.684 3-.444 3-.444s.174-.528.376-1.567c.1-.513.206-1.147.303-1.915q.088-.689.158-1.513a44 44 0 0 0 .157-3.478c.002-.176.006-.346.006-.527c0-.459-.021-.903-.051-1.339"/><path fill="#d99e82" d="M24.324 21.362c-1.003-.175-1.643-.467-1.994-.686a35 35 0 0 1-.707 1.687c.655.356 1.487.64 2.389.796a9 9 0 0 0 1.523.136c.296 0 .574-.023.841-.057c.1-.513.206-1.147.303-1.915c-.318.113-1.107.257-2.355.039m.758-3.342c-.782-.077-1.383-.249-1.805-.43a19 19 0 0 1-.479 1.77a8.4 8.4 0 0 0 2.106.476q.462.045.908.045c.359 0 .7-.028 1.026-.071q.074-.857.118-1.863c-.45.098-1.08.152-1.874.073m.221-1.524c.588 0 1.165-.059 1.692-.163c.001-.176.005-.346.005-.527c0-.458-.021-.902-.051-1.339c-.378.099-.919.194-1.682.205c-.775-.003-1.32-.111-1.698-.219c.004.146.011.287.013.437c.007.469-.026.946-.084 1.422a9 9 0 0 0 1.76.184zm-.178-3.273a8.7 8.7 0 0 0 1.648-.418a22 22 0 0 0-.347-1.797a6.4 6.4 0 0 1-1.56.409a6.5 6.5 0 0 1-1.522.055q.109.838.173 1.823c.109.004.207.021.319.021c.42 0 .857-.031 1.289-.093m.909-3.658a22 22 0 0 0-.61-1.715a6.7 6.7 0 0 1-1.242.471a6.6 6.6 0 0 1-1.395.243c.131.495.265 1.09.386 1.784a9 9 0 0 0 1.497-.269a9 9 0 0 0 1.364-.514"/><path fill="#3e721d" d="M34.549 2.943c-.032-.042-3.202-4.283-7.313-2.423c-1.847.835-3.038 2.2-3.469 3.963c-.804-1.125-2.026-1.839-3.644-2.127c-4.421-.788-7.092 4.123-7.118 4.172a.174.174 0 0 0 .256.224c.02-.015 2.037-1.427 5.396-.828a97 97 0 0 1 5.864 1.217a.18.18 0 0 0 .172-.051c.022-.024 2.303-2.475 4.4-3.423c3.104-1.404 5.221-.472 5.24-.462a.176.176 0 0 0 .216-.262"/><path fill="#5c913b" d="M31.129 5.401c-3.134-1.655-5.57-.831-7.083.174c-1.813-.351-5.201-.357-8.072 3.324c-3.525 4.518-.433 10.152-.402 10.209c.031.056.09.089.153.089l.021-.001a.18.18 0 0 0 .147-.128c.011-.039 1.097-3.967 3.843-7.27c1.501-1.805 3.293-3.474 4.554-4.573c1.27.211 3.136.678 4.969 1.702c3.573 1.998 5.212 5.379 5.228 5.413c.032.066.101.112.177.099a.17.17 0 0 0 .151-.134c.014-.063 1.392-6.222-3.686-8.904"/></svg>
                        &nbsp<h2>Bitácoras</h2>  
                        </div>
                        <div class="back-button-container">
                            <a  title="Regresar" href="index.php?controller=home&action=homeInformation" >
                                <?php echo portalReturn ?><!-- SVG -->
                            </a>
                        </div>
                     </div>
                        <div class="row">
                            <div class="col">
                                <div class="blog-posts">
                                    <section class="timeline">
                                        <div class="timeline-body">
                                            <?php  
                                                $cont = 0;
                                                if (count($dataToView["data"]) > 0) { 
                                                    foreach ($dataToView["data"] as $data) { 
                                                        $cont++;
                                                        // Determinar la dirección del artículo
                                                        $canb = ($cont % 2 == 0) ? "right" : "left";
                                            ?>
                                            <article class="timeline-box <?php echo $canb; ?> post post-medium">
                                                <div class="timeline-box-arrow"></div>
                                                <div class="p-2">
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="post-image">
                                                                <!-- Carrusel -->
                                                                <div class="carousel" id="carousel-<?php echo $cont; ?>">
                                                                    <div class="carousel-inner">
                                                                        <?php 
                                                                            $imageUrls = explode(',', $data['imageUrls']); 
                                                                            $contImg = 0;
                                                                            foreach ($imageUrls as $image) { 
                                                                                $contImg++; 
                                                                        ?>
                                                                                <div class="carousel-item <?php echo $contImg === 1 ? 'active' : ''; ?>">
                                                                                    <img src="<?php echo $image; ?>" alt="Imagen <?php echo $contImg; ?>" data-index="<?php echo $contImg; ?>" style="width:100%; border-radius: 4px;">
                                                                                </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <button class="carousel-control prev" onclick="moveSlide(-1, <?php echo $cont; ?>)">&#10094;</button>
                                                                    <button class="carousel-control next" onclick="moveSlide(1, <?php echo $cont; ?>)">&#10095;</button>
                                                                    <div class="carousel-indicator" id="indicator-<?php echo $cont; ?>">1 / <?php echo count($imageUrls); ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="post-content">
                                                                <span class="font-weight-semibold text-5 line-height-4 mt-2 mb-2">
                                                                    <p class="bitaTitle" href="blog-post.html"><?php echo $data['tripTitle']; ?></p>
                                                                            </span>
                                                                <p class="comentBita"><?php echo $data['description']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="post-meta">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(72, 71, 71, 1);">
                                                                        <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path>
                                                                        <path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
                                                                    </svg>
                                                                    Fecha: 
                                                                    <?php
                                                                        $dateTime = new DateTime($data["departureDate"]);
                                                                        echo $dateTime->format('d/m/Y h:i A');
                                                                    ?>
                                                                </span><br><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="post-meta">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(72, 71, 71, 1)">
                                                                        <path d="M20.29 8.29 16 12.58l-1.3-1.29-1.41 1.42 2.7 2.7 5.72-5.7zM4 8a3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4 3.91 3.91 0 0 0-4-4 3.91 3.91 0 0 0-4 4zm6 0a1.91 1.91 0 0 1-2 2 1.91 1.91 0 0 1-2-2 1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z"></path>
                                                                    </svg>
                                                                    Número de viajeros: <span><?php echo $data['numberTravel']; ?></span>
                                                                </span><br><br>
                                                                <?php if(isset($_SESSION['user']) && isset($_SESSION['privilege'])){ ?>   
                                                                <span >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(72, 71, 71, 1)">
                                                                        <path d="M16 2H8C4.691 2 2 4.691 2 8v12a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 13c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v7z"></path>
                                                                        <circle cx="9.5" cy="11.5" r="1.5"></circle>
                                                                        <circle cx="14.5" cy="11.5" r="1.5"></circle>
                                                                    </svg> 
                                                                    <a href="index.php?controller=comment&action=getBitacoraComent&id=<?php echo $data['idWebLog']; ?>" title="Comentarios"><span class="span_com">Comentarios
                                                                    <span class="help-icon" data-tooltip="Puedes hacer comentarios una vez iniciado sesión.&#10;Recuerde siempre mantener el respeto y la buena moral.&#10;Los comentraios seran revisados previamente por el administrador antes de ser publicaod"><?php echo HELP_ICON; ?></span> 
                                                                    </span></a>
                                                                </span>
                                                                
                                                                    <?php    }else {?>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(72, 71, 71, 1)">
                                                                        <path d="M16 2H8C4.691 2 2 4.691 2 8v12a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 13c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v7z"></path>
                                                                        <circle cx="9.5" cy="11.5" r="1.5"></circle>
                                                                        <circle cx="14.5" cy="11.5" r="1.5"></circle>
                                                                    </svg> 
                                                                        <span class="span_com">Comentarios  <span class="help-icon" data-tooltip="Debes iniciar sesión para dirigirte a la caja de comentarios"><?php echo HELP_ICON; ?></span>    </span>
                                                                     <?php }?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div title="Leer más..." class="view-details" model='webLog' id="<?php echo $data['idWebLog'] ?>">
                                                                <a class="btn btn-xs btn-light text-1 text-uppercase">Leer más</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                            <?php
                                                    } // foreach
                                                } // if
                                            ?>  
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="asset/js/scripts/helpForm.js"></script>

<script>
function showSlide(index, carouselId) {
    const items = document.querySelectorAll(`#carousel-${carouselId} .carousel-item`);
    const indicator = document.getElementById(`indicator-${carouselId}`);
    
    // Oculta la imagen actual
    items.forEach(item => item.classList.remove('active'));
    
    // Asegura que el índice esté dentro del rango
    index = (index + items.length) % items.length; 
    
    // Muestra la nueva imagen con un efecto de desvanecimiento
    items[index].classList.add('active');
    
    // Actualiza el indicador
    indicator.textContent = `${index + 1} / ${items.length}`;
}


function moveSlide(direction, carouselId) {
    const currentIndex = Array.from(document.querySelectorAll(`#carousel-${carouselId} .carousel-item`)).findIndex(item => item.classList.contains('active'));
    showSlide(currentIndex + direction, carouselId);
}

</script>

<style>
.carousel {
    position: relative;
}

.carousel img{
    position: relative;
    height: 200px;
  
    border-radius: 4px;
    object-fit: cover;
}

.carousel-inner {
    display: flex;
}
.carousel-item {
    display: none; /* Oculta todas las imágenes por defecto */
}
.carousel-item.active {
    display: block; /* Muestra solo la imagen activa */
    width: 534px;
    border-radius: 4px;
    object-fit: cover;
}

.carousel-control {
    position: absolute;
    top: 50%;
    background-color: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
}
.prev {
    left: 10px;
}
.next {
    right: 10px;
}

.carousel-control {
    position: absolute;
    top: 42%;
    transform: translateY(-7%);
    background-color: transparent;
    border: 3px solid #ffffffb0;
    color: white;
    padding: 6px 13px;
    border-radius: 30%;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    font-size: 2.1rem;

}

.carousel-control:hover {
    background-color: rgba(32, 118, 2,  0.9); /* Fondo más oscuro al pasar el ratón */
    transform: scale(1.1); /* Aumentar tamaño al pasar el ratón */
}

.carousel-control:active {
    background-color: rgba(32, 108, 2,  0.6); /* Fondo más oscuro al pasar el ratón */
    border: 3px solid #ffffff00;
    transform: scale(1); /* Aumentar tamaño al pasar el ratón */
}
.carousel-control.prev {
    left: 10px; /* Posición del botón anterior */
}

.carousel-control.next {
    right: 10px; /* Posición del botón siguiente */
}

/* Opcional: Estilo para los iconos dentro de los botones */
.carousel-control::before {
    
    font-weight: 900; /* Peso del icono */
}


.carousel-indicator {
    position: absolute;
    bottom: 10px; /* Ajusta la posición vertical */
    left: 50%;
    transform: translateX(-50%); /* Centra horizontalmente */
    background-color: rgba(0, 0, 0, 0.29); /* Fondo oscuro con transparencia */
    color: white; /* Color del texto */
    padding: 5px 10px; /* Espaciado interno */
    border-radius: 5px; /* Bordes redondeados */
    font-size: 14px; /* Tamaño de fuente */
}

.carousel-item {
    display: none; /* Oculta todas las imágenes por defecto */
    opacity: 0; /* Inicialmente, las imágenes son completamente transparentes */
    transition: opacity 0.5s ease-in-out; /* Transición suave de opacidad */
}

.carousel-item.active {
    display: block; /* Muestra solo la imagen activa */
    opacity: 1; /* La imagen activa es completamente visible */
}


</style>
   <!--////////////////////////////////// Switc alert //////////////////////////////////-->
<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="webLog"></div>
<script src="asset/js/scripts/alert.js"></script>
  