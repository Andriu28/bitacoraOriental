<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>  


<link rel="stylesheet" href="asset/css/dashboard.css">

    <div class="content-dashboard">
    
        <main>

            <div class="bottom-dat">
                
                <div class="orders">
                        <div class="header">
                            <div class="titleModule">
                                <svg class='bx green'  xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z"></path>
                                </svg>
                                <h2 >Escritorio de trabajo</h2>
                            </div>
                    
                        </div>

                    <div class="header">
                        <div style="position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="currentColor" d="M15 13h1.5v2.82l2.44 1.41l-.75 1.3L15 16.69zm4-5H5v11h4.67c-.43-.91-.67-1.93-.67-3a7 7 0 0 1 7-7c1.07 0 2.09.24 3 .67zM5 21a2 2 0 0 1-2-2V5c0-1.11.89-2 2-2h1V1h2v2h8V1h2v2h1a2 2 0 0 1 2 2v6.1c1.24 1.26 2 2.99 2 4.9a7 7 0 0 1-7 7c-1.91 0-3.64-.76-4.9-2zm11-9.85A4.85 4.85 0 0 0 11.15 16c0 2.68 2.17 4.85 4.85 4.85A4.85 4.85 0 0 0 20.85 16c0-2.68-2.17-4.85-4.85-4.85"/></svg>
                        </div>                                                    
                        <h3>Viajes más cercanos</h3>                        
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Título del viaje</th>
                                <th>Fecha de ejecución</th>
                                <th>Cupos disponibles</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(!empty($dataToView["data"]["traveloffer"])){
                                foreach($dataToView["data"]["traveloffer"] as $data){ ?>
                                    <tr>
                                        <td>                                    
                                            <p><?php
                                                if (strlen($data['title']) > 18){                                                    
                                                    echo substr($data['title'], 0, 18) . "...";
                                                } else{  
                                                    echo $data['title'];
                                                } 
                                                ?>            
                                            </p>
                                        </td>
                                        <td><?php echo date("d/m/Y", strtotime($data["departureDate"]))?></td>
                                        <td><span class="status 
                                        <?php if ($data['vacant']>19){                                                    
                                                echo 'high';
                                            } else if ($data['vacant']>=10 && $data['vacant'] <=19){  
                                                echo 'medium';
                                            } else if($data['vacant'] < 10){
                                                echo 'low'; 
                                            } ?>">Cupos: <?php echo $data['vacant'] ?></span></td>
                                    </tr>                            
                        <?php                        
                                }
                            }else{
                        ?>
                            <tr>
                                <td></td>
                                <td><b>Sin planificación</b></td>
                                <td></td>
                            </tr>      
                        <?php }?>
                        </tbody>
                    </table>
                </div>

                <!-- Reminders -->
                <div class="reminders">
                    <div class="header">
                        <div style="position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"><path stroke-dasharray="4" stroke-dashoffset="4" d="M12 3v2"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.2s" values="4;0"/></path><path stroke-dasharray="28" stroke-dashoffset="28" d="M12 5c-3.31 0 -6 2.69 -6 6l0 6c-1 0 -2 1 -2 2h8M12 5c3.31 0 6 2.69 6 6l0 6c1 0 2 1 2 2h-8"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.2s" dur="0.4s" values="28;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M10 20c0 1.1 0.9 2 2 2c1.1 0 2 -0.9 2 -2"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="8;0"/></path></g></svg>
                        </div>
                        <h3>Notificaciones</h3>                        
                    </div>
                    <ul class="task-list">

                        <?php if($dataToView["data"]["reservation"]['totalE'] > 0){?>
                            <li class="not-completed">
                                <div class="task-title">                                
                                <p>
                                    Hay <?php echo $dataToView["data"]["reservation"]['totalE'] ;?> Solicitudes de reservación pendientes.
                                    <br>
                                    <a class="link-view-model" href="index.php?controller=reservation&action=listRequestsE">Ver solicitudes de reservación</a>
                                </p>
                                </div>                            
                            </li>                    
                        <?php }else{ ?>
                            <li class="completed">
                                <div class="task-title">                                
                                    <p>No hay reservaciones pendientes</p>
                                </div>                            
                            </li>               
                        <?php } ?>

                        <?php if($dataToView["data"]["comment"]['totalE'] > 0){?>
                            <li class="not-completed">
                                <div class="task-title">                                
                                <p>
                                    Hay <?php echo $dataToView["data"]["comment"]['totalE'] ;?> comentarios pendientes.
                                    <br>
                                    <a class="link-view-model" href="index.php?controller=comment&action=listComment&type=E">Ver comentarios pendientes</a>
                                </p>
                                </div>                            
                            </li>                    
                        <?php }else{ ?>
                            <li class="completed">
                                <div class="task-title">                                
                                    <p>No hay comentarios pendientes</p>
                                </div>
                            </li>               
                        <?php } ?>
                                               
                    </ul>

                </div>

                <!-- End of Reminders-->

            </div>

            <!-- Insights -->
            <ul class="insights">
                <a title="Rutas de viaje" href="index.php?controller=route&action=listRouteEnabled">
                    <li>
                        <div class="box-bx" >
                            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z"></path><path d="M11.42 21.814a.998.998 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819zM12 4c3.309 0 6 2.691 6 6.005.021 4.438-4.388 8.423-6 9.73-1.611-1.308-6.021-5.294-6-9.735 0-3.309 2.691-6 6-6z"></path>
                            </svg> 
                        </div>
                        <span class="info">
                            <h3>Rutas de viaje</h3>
                            <p>Subidas: <?php echo $dataToView["data"]["route"]['routeEnable']; ?></p>
                            <p>Ocultas: <?php echo $dataToView["data"]["route"]['routeDisable']; ?></p>
                            <h3>Total: <?php echo $dataToView["data"]["route"]['route']; ?></h3>                        
                        </span>
                    </li>
                </a>
               
                <a title="Paquetes de viaje" href="index.php?controller=packages&action=list">
                    <li>
                        <div class="box-bx" >
                            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22 8a.76.76 0 0 0 0-.21v-.08a.77.77 0 0 0-.07-.16.35.35 0 0 0-.05-.08l-.1-.13-.08-.06-.12-.09-9-5a1 1 0 0 0-1 0l-9 5-.09.07-.11.08a.41.41 0 0 0-.07.11.39.39 0 0 0-.08.1.59.59 0 0 0-.06.14.3.3 0 0 0 0 .1A.76.76 0 0 0 2 8v8a1 1 0 0 0 .52.87l9 5a.75.75 0 0 0 .13.06h.1a1.06 1.06 0 0 0 .5 0h.1l.14-.06 9-5A1 1 0 0 0 22 16V8zm-10 3.87L5.06 8l2.76-1.52 6.83 3.9zm0-7.72L18.94 8 16.7 9.25 9.87 5.34zM4 9.7l7 3.92v5.68l-7-3.89zm9 9.6v-5.68l3-1.68V15l2-1v-3.18l2-1.11v5.7z"></path>
                            </svg> 
                        </div>
                        <span class="info">
                            <h3>Paquetes de viaje</h3>
                            <p>Subidas: <?php echo $dataToView["data"]["packages"]['packagesEnable']; ?></p>
                            <p>Ocultas: <?php echo $dataToView["data"]["packages"]['packagesDisable']; ?></p>
                            <h3>Total: <?php echo $dataToView["data"]["packages"]['packages']; ?></h3>                        
                        </span>
                    </li>
                </a>
                <a title="Publicaciones Especiales" href="index.php?controller=pubEspecial&action=list">
                    <li>
                        <div class="box-bx" >
                            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="m6.516 14.323-1.49 6.452a.998.998 0 0 0 1.529 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082a1 1 0 0 0-.59-1.74l-5.701-.454-2.467-5.461a.998.998 0 0 0-1.822 0L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.214 4.107zm2.853-4.326a.998.998 0 0 0 .832-.586L12 5.43l1.799 3.981a.998.998 0 0 0 .832.586l3.972.315-3.271 2.944c-.284.256-.397.65-.293 1.018l1.253 4.385-3.736-2.491a.995.995 0 0 0-1.109 0l-3.904 2.603 1.05-4.546a1 1 0 0 0-.276-.94l-3.038-2.962 4.09-.326z"></path>
                            </svg>
                        </div>
                        <span class="info">
                            <h3>Pub. especiales</h3>
                            <p>Subidas: <?php echo $dataToView["data"]["pubSpecials"]['pubSpecialsEnable']; ?></p>
                            <p>Ocultas: <?php echo $dataToView["data"]["pubSpecials"]['pubSpecialsDisable']; ?></p>
                            <h3>Total: <?php echo $dataToView["data"]["pubSpecials"]['pubSpecials']; ?></h3>                        
                        </span>
                    </li>
                </a>
                <a title="Bitácoras de viaje" href="index.php?controller=webLog&action=list">
                    <li>
                    
                        <div class="box-bx" >
                            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2 12h2a7.986 7.986 0 0 1 2.337-5.663 7.91 7.91 0 0 1 2.542-1.71 8.12 8.12 0 0 1 6.13-.041A2.488 2.488 0 0 0 17.5 7C18.886 7 20 5.886 20 4.5S18.886 2 17.5 2c-.689 0-1.312.276-1.763.725-2.431-.973-5.223-.958-7.635.059a9.928 9.928 0 0 0-3.18 2.139 9.92 9.92 0 0 0-2.14 3.179A10.005 10.005 0 0 0 2 12zm17.373 3.122c-.401.952-.977 1.808-1.71 2.541s-1.589 1.309-2.542 1.71a8.12 8.12 0 0 1-6.13.041A2.488 2.488 0 0 0 6.5 17C5.114 17 4 18.114 4 19.5S5.114 22 6.5 22c.689 0 1.312-.276 1.763-.725A9.965 9.965 0 0 0 12 22a9.983 9.983 0 0 0 9.217-6.102A9.992 9.992 0 0 0 22 12h-2a7.993 7.993 0 0 1-.627 3.122z"></path><path d="M12 7.462c-2.502 0-4.538 2.036-4.538 4.538S9.498 16.538 12 16.538s4.538-2.036 4.538-4.538S14.502 7.462 12 7.462zm0 7.076c-1.399 0-2.538-1.139-2.538-2.538S10.601 9.462 12 9.462s2.538 1.139 2.538 2.538-1.139 2.538-2.538 2.538z"></path>
                            </svg>
                        </div>
                    
                        <span class="info">
                            <h3>Bitácoras de viaje</h3>
                            <p>Subidas: <?php echo $dataToView["data"]["weblog"]['weblogEnable']; ?></p>
                            <p>Ocultas: <?php echo $dataToView["data"]["weblog"]['weblogDisable']; ?></p>
                            <h3>Total: <?php echo $dataToView["data"]["weblog"]['weblog']; ?></h3>                        
                        </span>
                    </li>
                </a>                
                <a title="Usuarios Turistas" href="index.php?controller=users&action=list&userType=turista&status=1">
                    <li>
                        <div class="box-bx" >
                            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path>
                            </svg>
                        </div>
                        <span class="info">
                            <h3>Usuarios Turistas</h3>
                            <p>Activos: <?php echo $dataToView["data"]["userTourist"]['userTouristEnable']; ?></p>
                            <p>Baneados: <?php echo $dataToView["data"]["userTourist"]['userTouristDisable']; ?></p>
                            <h3>Total: <?php echo $dataToView["data"]["userTourist"]['userTourist']; ?></h3>                        
                        </span>
                    </li>
                </a>
                <a title="Preguntas frecuentes" href="index.php?controller=faqs&action=listFaq">
                    <li>
                        <div class="box-bx" >
                            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 6a3.939 3.939 0 0 0-3.934 3.934h2C10.066 8.867 10.934 8 12 8s1.934.867 1.934 1.934c0 .598-.481 1.032-1.216 1.626a9.208 9.208 0 0 0-.691.599c-.998.997-1.027 2.056-1.027 2.174V15h2l-.001-.633c.001-.016.033-.386.441-.793.15-.15.339-.3.535-.458.779-.631 1.958-1.584 1.958-3.182A3.937 3.937 0 0 0 12 6zm-1 10h2v2h-2z"></path><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                            </svg>
                        </div>
                        <span class="info">
                            <h3>Preg. Frecuentes</h3>
                            <p>Subidas: <?php echo $dataToView["data"]["faq"]['faqEnable']; ?></p>
                            <p>Ocultas: <?php echo $dataToView["data"]["faq"]['faqDisable']; ?></p>
                            <h3>Total: <?php echo $dataToView["data"]["faq"]['faq']; ?></h3>                        
                        </span>
                    </li>
                </a>
            </ul>
            <!-- End of Insights -->


        </main>

    </div>

    
    
    <!--////////////////////////////////// Switc alert //////////////////////////////////-->
    <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="dashboard"></div>
    <script src="asset\js\scripts\alert.js"></script>
    