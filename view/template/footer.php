</div>
<script src="asset\js\app\index.js"></script>
<!-- <script src="asset\js\app\script.js"></script> -->


<?php 
if (isset($_SESSION['user']) && 
    ($_SESSION['privilege'] === "admin" || $_SESSION['privilege'] === "publicista")) { 
?>

  <?php 
  
} else { ?>

<footer>
    <div class="section_container">
        <div class="footer_section">
            <div class="footer_logo">
                <a href="#">
                 <img class="icono" src="asset/IconoBitacoraO/bitacora.jpg">
                    <h2>Bitácora Oriental</h2>
                </a>
                <div class="contact_us">
                    <h3 class="contact">Contactanos</h3>
                    <ul>
                        <li>
                            <svg class="bx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                                <path d="M12 2C7.589 2 4 5.589 4 9.995 3.971 16.44 11.696 21.784 12 22c0 0 8.029-5.56 8-12 0-4.411-3.589-8-8-8zm0 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"></path>
                            </svg>
                            <span>Sucre, Carúpano, Sector Guayacan, las Cuatro Equinas</span>
                        </li>

                        <li>
                            <svg class="bx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                                <path d="M20 10.999h2C22 5.869 18.127 2 12.99 2v2C17.052 4 20 6.943 20 10.999z"></path><path d="M13 8c2.103 0 3 .897 3 3h2c0-3.225-1.775-5-5-5v2zm3.422 5.443a1.001 1.001 0 0 0-1.391.043l-2.393 2.461c-.576-.11-1.734-.471-2.926-1.66-1.192-1.193-1.553-2.354-1.66-2.926l2.459-2.394a1 1 0 0 0 .043-1.391L6.859 3.513a1 1 0 0 0-1.391-.087l-2.17 1.861a1 1 0 0 0-.29.649c-.015.25-.301 6.172 4.291 10.766C11.305 20.707 16.323 21 17.705 21c.202 0 .326-.006.359-.008a.992.992 0 0 0 .648-.291l1.86-2.171a1 1 0 0 0-.086-1.391l-4.064-3.696z"></path>
                            </svg>
                            <span>+58 4122918427</span>
                        </li>

                        <li>
                            <svg class="bx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                                <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm3.293 14.707L11 12.414V6h2v5.586l3.707 3.707-1.414 1.414z"></path>
                            </svg>
                            <span>Lunes-Sabados : 9:00 AM - 5:00 PM</span>
                        </li>

                    </ul>
                </div>

               

            </div>

            <div class="useful_links">
                <h3>Nuestros Links</h3>
                <ul>
                    <li><a href="index.php?controller=home&action=homeInformation#rutes">Rutas</a></li>
                    <li><a href="index.php?controller=home&action=homeInformation#trip">Viajes</a></li>
                    <li><a href="index.php?controller=home&action=homeInformation#packages">Paquetes</a></li>
                    <li><a href="index.php?controller=home&action=homeInformation#pubSpecial">Publicaciones</a></li>
                    <li><a href="index.php?controller=home&action=homeInformation#faquestion">Preguntas</a></li>

                    <li><a href="index.php?controller=webLog&action=getBitacora" title="Bitácora">Bitácoras</a></li>
                </ul>
            </div>

        

            <div class="follow_us">
            <h3>Siguenos en</h3>
                <a href="https://www.facebook.com/p/Bit%C3%A1cora-oriental-100064032285158/" target="_blank">
                    <svg class="bx bxl-facebook-circle" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                        <path d="M12.001 2.002c-5.522 0-9.999 4.477-9.999 9.999 0 4.99 3.656 9.126 8.437 9.879v-6.988h-2.54v-2.891h2.54V9.798c0-2.508 1.493-3.891 3.776-3.891 1.094 0 2.24.195 2.24.195v2.459h-1.264c-1.24 0-1.628.772-1.628 1.563v1.875h2.771l-.443 2.891h-2.328v6.988C18.344 21.129 22 16.992 22 12.001c0-5.522-4.477-9.999-9.999-9.999z"></path>
                    </svg>

                </a>
                <a href="https://www.tiktok.com/@bitacoraoriental" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"></path>
                    </svg>
                </a>
                <a href="https://www.instagram.com/bitacoraoriental/" target="_blank">
                    <svg class="bx " xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                        <path d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z">

                        </path><circle cx="16.806" cy="7.207" r="1.078"></circle><path d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z"></path>
                    </svg>
                <a>
               
            
            </div>
        </div>
    </div>
    <link rel="icon" type="image/jpeg" href="asset\IconoBitacoraO\bitacora.jpg">
</footer>

<!--  BACK TO TOP BUTTON   -->

<a href="#" class="shadow btn-primary rounded-circle back-to-top" title="Inicio">
        <svg class="fas fa-chevron-up" xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
            <path d="m6.293 13.293 1.414 1.414L12 10.414l4.293 4.293 1.414-1.414L12 7.586z"></path>
        </svg>
    </a> 


<?php } 
?>


    </body>


</html>