
   <!-- Sidebar -->
<div id="sidebar-employee" class="sidebar" activeOption="<?php echo htmlspecialchars(SIDEBAR_LOCATE::$activeOption); ?>" >
    <a href="#" class="logo">
        <img class="icono" src="asset/IconoBitacoraO/bitacora.jpg">
        <div class="logo-name"><span>B</span>itácora Oriental</div>
    </a>
    
    <ul class="side-menu">
          
        <li id="Escritorio de Trabajo" >
            <a href="index.php?controller=dashboard&action=summary" title="Escritorio de Trabajo">
            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor" >
                <path d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z"></path>
            </svg>    
            Escritorio de Trabajo
            </a>
        </li>

        <li id="Portal" >
            <a href="index.php?controller=home&action=homeInformation" title="Portal">
            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor" >
                <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"></path>  
            </svg>
            Portal
            </a>
        </li>

        <li id="Rutas de Viajes">
            <a href="index.php?controller=route&action=listRouteEnabled" title="Ruta de Viaje">
                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z"></path><path d="M11.42 21.814a.998.998 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819zM12 4c3.309 0 6 2.691 6 6.005.021 4.438-4.388 8.423-6 9.73-1.611-1.308-6.021-5.294-6-9.735 0-3.309 2.691-6 6-6z"></path>
                </svg> 
                Rutas de Viajes
            </a>
        </li>

        <li id="Paquetes de Viaje" >
            <a href="index.php?controller=packages&action=list" title="Paquetes de Viaje">
                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22 8a.76.76 0 0 0 0-.21v-.08a.77.77 0 0 0-.07-.16.35.35 0 0 0-.05-.08l-.1-.13-.08-.06-.12-.09-9-5a1 1 0 0 0-1 0l-9 5-.09.07-.11.08a.41.41 0 0 0-.07.11.39.39 0 0 0-.08.1.59.59 0 0 0-.06.14.3.3 0 0 0 0 .1A.76.76 0 0 0 2 8v8a1 1 0 0 0 .52.87l9 5a.75.75 0 0 0 .13.06h.1a1.06 1.06 0 0 0 .5 0h.1l.14-.06 9-5A1 1 0 0 0 22 16V8zm-10 3.87L5.06 8l2.76-1.52 6.83 3.9zm0-7.72L18.94 8 16.7 9.25 9.87 5.34zM4 9.7l7 3.92v5.68l-7-3.89zm9 9.6v-5.68l3-1.68V15l2-1v-3.18l2-1.11v5.7z"></path>
                </svg> 
                Paquetes de Viaje
            </a>

        </li>
        <li id="Ofertas de Viaje" >
            <a href="index.php?controller=trip&action=listTripEnabled" title="Ofertas de Viaje">
            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                 <path d="M21.259 11.948A.986.986 0 0 0 22 11V8a.999.999 0 0 0-.996-.999V6H21c0-2.206-1.794-4-4-4H7C4.794 2 3 3.794 3 6v1a1 1 0 0 0-1 1v3c0 .461.317.832.742.948a3.953 3.953 0 0 0-.741 2.298l.004 3.757c.001.733.404 1.369.995 1.716V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h12v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1.274a2.02 2.02 0 0 0 .421-.313c.377-.378.585-.881.584-1.415l-.004-3.759a3.966 3.966 0 0 0-.742-2.291zM5 18h-.995l-.004-3.757c-.001-.459.161-.89.443-1.243h15.111c.283.353.445.783.446 1.242L20.006 18H5zm6.004-10v3H5V8h6.004zM19 11h-5.996V8H19v3zM7 4h10c1.103 0 2 .897 2 2h-4V5H9v1H5c0-1.103.897-2 2-2z"></path><circle cx="6.5" cy="15.5" r="1.5"></circle><circle cx="17.5" cy="15.5" r="1.5"></circle>
            </svg>
                Ofertas de Viaje
            </a>
        </li>

        <li id="Solicitudes de Reserva">
            <a href="index.php?controller=reservation&action=listRequestsE" title="Solicitud de Reservaciones">
                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2H6c-1.103 0-2 .897-2 2v18l8-4.572L20 22V4c0-1.103-.897-2-2-2zm0 16.553-6-3.428-6 3.428V4h12v14.553z"></path>
            </svg>
                Solicitudes de Reserva
            </a>
        </li>

        <li id="Reservaciones">
            <a  href="index.php?controller=reservation&action=listRequestsA" title="Reservaciones">
                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
                </svg>
                Reservaciones
            </a>
        </li>
        <li id="Bitacoras de Viaje">
            <a href="index.php?controller=webLog&action=list" title="Bitácoras de Viajes">
            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M2 12h2a7.986 7.986 0 0 1 2.337-5.663 7.91 7.91 0 0 1 2.542-1.71 8.12 8.12 0 0 1 6.13-.041A2.488 2.488 0 0 0 17.5 7C18.886 7 20 5.886 20 4.5S18.886 2 17.5 2c-.689 0-1.312.276-1.763.725-2.431-.973-5.223-.958-7.635.059a9.928 9.928 0 0 0-3.18 2.139 9.92 9.92 0 0 0-2.14 3.179A10.005 10.005 0 0 0 2 12zm17.373 3.122c-.401.952-.977 1.808-1.71 2.541s-1.589 1.309-2.542 1.71a8.12 8.12 0 0 1-6.13.041A2.488 2.488 0 0 0 6.5 17C5.114 17 4 18.114 4 19.5S5.114 22 6.5 22c.689 0 1.312-.276 1.763-.725A9.965 9.965 0 0 0 12 22a9.983 9.983 0 0 0 9.217-6.102A9.992 9.992 0 0 0 22 12h-2a7.993 7.993 0 0 1-.627 3.122z"></path><path d="M12 7.462c-2.502 0-4.538 2.036-4.538 4.538S9.498 16.538 12 16.538s4.538-2.036 4.538-4.538S14.502 7.462 12 7.462zm0 7.076c-1.399 0-2.538-1.139-2.538-2.538S10.601 9.462 12 9.462s2.538 1.139 2.538 2.538-1.139 2.538-2.538 2.538z"></path>
            </svg>
            Bitácoras de Viaje
            </a>
        </li>

        <li id="Comentarios">
            <a href="index.php?controller=comment&action=listComment&type=E" title="Comentarios">
            <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M16 2H8C4.691 2 2 4.691 2 8v12a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 13c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v7z"></path><circle cx="9.5" cy="11.5" r="1.5"></circle><circle cx="14.5" cy="11.5" r="1.5"></circle>
            </svg>
            Comentarios
            </a>
        </li>

        <li id="Publicaciones Especiales">
            <a href="index.php?controller=pubEspecial&action=list" title="Publicaciones Especiales">
                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="m6.516 14.323-1.49 6.452a.998.998 0 0 0 1.529 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082a1 1 0 0 0-.59-1.74l-5.701-.454-2.467-5.461a.998.998 0 0 0-1.822 0L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.214 4.107zm2.853-4.326a.998.998 0 0 0 .832-.586L12 5.43l1.799 3.981a.998.998 0 0 0 .832.586l3.972.315-3.271 2.944c-.284.256-.397.65-.293 1.018l1.253 4.385-3.736-2.491a.995.995 0 0 0-1.109 0l-3.904 2.603 1.05-4.546a1 1 0 0 0-.276-.94l-3.038-2.962 4.09-.326z"></path>
                </svg>
                Publicaciones Especiales
            </a>
        </li>
            
        <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege'] === "admin") { ?>
            <li id="Preguntas Frecuentes">
                <a href="index.php?controller=faqs&action=listFaq" title="Preguntas Frecuentes">
                    <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 6a3.939 3.939 0 0 0-3.934 3.934h2C10.066 8.867 10.934 8 12 8s1.934.867 1.934 1.934c0 .598-.481 1.032-1.216 1.626a9.208 9.208 0 0 0-.691.599c-.998.997-1.027 2.056-1.027 2.174V15h2l-.001-.633c.001-.016.033-.386.441-.793.15-.15.339-.3.535-.458.779-.631 1.958-1.584 1.958-3.182A3.937 3.937 0 0 0 12 6zm-1 10h2v2h-2z"></path><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                    </svg>
                    Preguntas Frecuentes
                </a>
            </li>
            
            <li id="Lista de Usuarios">
            <a href="index.php?controller=users&action=list&userType=publicista&status=1" title="Lista de usuarios">
                    <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path>
                    </svg>
                    Lista de Usuarios
                </a>
            </li>
            <li id="Historial" >
                <a href="index.php?controller=historys&action=listhistory" title="Historial">                    
                    <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.903 8.586a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.952.952 0 0 0-.051-.259c-.01-.032-.019-.063-.033-.093zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z"></path><path d="M8 12h8v2H8zm0 4h8v2H8zm0-8h2v2H8z"></path>
                    </svg>
                    Historial
                </a>
            </li>

            <li id="Reporte">
                <a href="index.php?controller=reports&action=viewReport" title="Generar Reporte">
                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="25.6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 21H3a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1zm7 0h-3a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v17a1 1 0 0 1-1 1zm7 0h-3a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1z"></path>
                 </svg>
                    Reporte
                </a>
            </li>
         

        <?php } ?>  
    </ul>
    
    <ul class="side-menu">
        <li>
            <a href="asset\pdf\manual_usuario_bitacora_oriental.pdf" target="_blank" width="100%" title="Generar Reporte">
            <svg class="bx" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16m1-9.5V15h1v2h-4v-2h1v-2.5h-1v-2zm.5-2.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0"/></svg>
                Ayuda
            </a>
        </li>
        <li>
            <a href="index.php?controller=users&action=logout" title="Salir" class="logout">
                <svg class='bx' xmlns="http://www.w3.org/2000/svg" width="24" height="28.6" viewBox="0 0 24 24" fill="currentColor" >
                    <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                    <path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path>
                </svg>
                Salir
            </a>
        </li>
    </ul>
</div>


      
 
            
           

    