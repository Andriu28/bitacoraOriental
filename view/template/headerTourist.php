
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////
//          Inicio Seccion | Header y Navbar
////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<header>
    <nav class="navbar_portal">
        <div class="nav_logo">
            <a href="index.php">
                <img src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                <h2>Bitácora Oriental</h2>
            </a>
        </div>

        <!-- Checkbox para el menú móvil -->
        <input type="checkbox" id="click" />
        <label for="click" >
            <svg  class="menu_btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path>
            </svg> 
            
            <svg class="close_btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
            </svg>
        </label>
        <?php if(!isset($_GET['menuWeb'])){ ?>
        <!-- Navegación principal -->
        <ul>              
         
        <li><a href="index.php?controller=home&action=homeInformation#rutes">Rutas</a></li>
        <li><a href="index.php?controller=home&action=homeInformation#trip">Viajes</a></li>
        <li><a href="index.php?controller=home&action=homeInformation#packages">Paquetes</a></li>
        <li><a href="index.php?controller=home&action=homeInformation#pubSpecial">Publicaciones</a></li>
        <li><a href="index.php?controller=home&action=homeInformation#faquestion">Preguntas</a></li>

            <li><a href="index.php?controller=webLog&action=getBitacora" title="Bitácora">Bitácoras</a></li>
            <?php if (!isset($_SESSION['user'])) { ?><li><a href="index.php?controller=users&action=loginView" title="Iniciar Sesión">Iniciar sesión</a></li><?php } ?>
            <?php if(isset($_SESSION['user']) && isset($_SESSION['privilege']) && $_SESSION['privilege'] === "turista"){  
                $sessionData['user'] = $objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
            ?>                           


            <?php } ?>
        <?php }else{  ?>
        <ul>
            <li><a href="index.php?controller=home&action=homeInformation">Inicio</a></li>
        
        </ul>
        <?php } ?>


        <?php if(isset($_SESSION['user']) && isset($_SESSION['privilege']) && $_SESSION['privilege'] === "turista"){  
                $sessionData['user'] = $objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
            ?>                           


           

           <!-- ------------------------datos del usaurio--------------- -->
            <div class="profilel">
                    <div class="info">
                      <?php 
                      $sessionData['user'] = $objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
                      if(isset($sessionData['user'])):?>
                          <p><b><?php echo $sessionData['user']['email'];?></b></p>
                          <small class="text-muted"><?php echo ucfirst($_SESSION['privilege']); ?></small>
                      <?php endif; ?>
                    </div>
                </div>
            <!-- ---------------------------------------------------------- -->


            <!-- ----------codifo para el menu desplegable ------------------>
            <div class="menuProfileTourist">
                <div class="action">
                    <div class="profile" id="profileMenuItem">
                                             
                    <img src="asset/IconoBitacoraO/logo.jpg">
                       
                    </div>
                    <div class="menuProfile">
                        <div class="user-info">
                            <img src="asset/IconoBitacoraO/logo.jpg">
                            <h3><?php echo $sessionData['user']['name'];?><br><?php echo $sessionData['user']['lastName'];?></h3>
                        </div>
                        <hr>
                        <ul>
                            <a href="index.php?controller=users&action=userPanel">
                                <li>
                                    <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"/>
                                    </svg>                                
                                    Mi perfil
                                </li>
                            </a>
                            <a href="index.php?controller=reservation&action=listRequestsTouristE">
                                <li>
                                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 2H6c-1.103 0-2 .897-2 2v18l8-4.572L20 22V4c0-1.103-.897-2-2-2zm0 16.553-6-3.428-6 3.428V4h12v14.553z"></path>
                                </svg>
                                    Mis solicitudes de reservación
                                </li>
                            </a>
                            <a href="index.php?controller=reservation&action=listRequestsTouristA">
                                <li>
                                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
                                </svg>
                                    Mis reservaciones
                                </li>
                            </a>
                            <a href="index.php?controller=users&action=changePasswordFromSystem">
                                <li> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                        <path fill="currentColor" d="M2 10.5A4.5 4.5 0 0 1 6.5 6h19a4.5 4.5 0 0 1 4.5 4.5v11a4.5 4.5 0 0 1-4.5 4.5h-19A4.5 4.5 0 0 1 2 21.5zm5.707 2.793a1 1 0 0 0-1.414 1.414L7.586 16l-1.293 1.293a1 1 0 1 0 1.414 1.414L9 17.414l1.293 1.293a1 1 0 0 0 1.414-1.414L10.414 16l1.293-1.293a1 1 0 0 0-1.414-1.414L9 14.586zm6.086 0a1 1 0 0 0 0 1.414L15.086 16l-1.293 1.293a1 1 0 0 0 1.414 1.414l1.293-1.293l1.293 1.293a1 1 0 0 0 1.414-1.414L17.914 16l1.293-1.293a1 1 0 0 0-1.414-1.414L16.5 14.586l-1.293-1.293a1 1 0 0 0-1.414 0M22 17a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2z"/>
                                    </svg>
                                    Cambiar contraseña
                                </li>    
                            </a>
                            <a href="index.php?controller=users&action=logout">
                                <li class="logoutMenu"> 
                                    <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="28.6" viewBox="0 0 24 24" fill="currentColor" >
                                        <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                                        <path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path>
                                    </svg>
                                    Salir
                                </li>
                            </a>                                                    
                        </ul>
                    </div>
                </div>                
            </div>

        <!-- ------------------------fin del menu--------------------- -->   

        <?php } ?>


        <script src="asset/js/scripts/menuProfile.js"></script>

    </nav>

        

</header>

