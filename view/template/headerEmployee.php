



<div class="content">
        <!-- Navbar -->
        <nav>            
            <svg class='bx bx-menu' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor" >
                <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path>
            </svg>
            
            
            <div class="right-section"> <!-- Contenedor para agrupar elementos a la derecha -->
                            
                <input type="checkbox" id="theme-toggle" hidden>
                <label for="theme-toggle" class="theme-toggle" title="Modo oscuro" ></label>
                                            
                
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
                <!-- ----------codifo para el menu desplegable ------------------>
                <div class="action">
                    <div class="profile" id="profileMenuItem">
                       <a href="#" class="profile">                            
                            <img src="asset/IconoBitacoraO/logo.jpg">                            
                        </a>
                    </div>
                        <div class="menuProfile">
                            <div class="user-info">
                                <img src="asset/IconoBitacoraO/logo.jpg">
                                <h3><?php echo $sessionData['user']['name'];?><br><?php echo $sessionData['user']['lastName'];?></h2>
                            </div>
                            <hr>
                            <ul>
                                <a href="index.php?controller=users&action=userPanel">
                                    <li>
                                        <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path>
                                        </svg>                                
                                        Mi perfil
                                    </li>
                                </a>
                                <a href="index.php?controller=users&action=changePasswordFromSystem">
                                    <li> 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="currentColor" d="M2 10.5A4.5 4.5 0 0 1 6.5 6h19a4.5 4.5 0 0 1 4.5 4.5v11a4.5 4.5 0 0 1-4.5 4.5h-19A4.5 4.5 0 0 1 2 21.5zm5.707 2.793a1 1 0 0 0-1.414 1.414L7.586 16l-1.293 1.293a1 1 0 1 0 1.414 1.414L9 17.414l1.293 1.293a1 1 0 0 0 1.414-1.414L10.414 16l1.293-1.293a1 1 0 0 0-1.414-1.414L9 14.586zm6.086 0a1 1 0 0 0 0 1.414L15.086 16l-1.293 1.293a1 1 0 0 0 1.414 1.414l1.293-1.293l1.293 1.293a1 1 0 0 0 1.414-1.414L17.914 16l1.293-1.293a1 1 0 0 0-1.414-1.414L16.5 14.586l-1.293-1.293a1 1 0 0 0-1.414 0M22 17a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2z"/></svg>
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
        </nav>

        

<script src="asset/js/scripts/menuProfile.js"></script>