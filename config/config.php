<?php


/*Variables globales*/
define("DB_HOST", "localhost");
define("DB", "bitacora_oriental");
define("DB_USER", "root");
define("DB_PASS", "");


//Rutas base para compatibilidad con los sistemas operativos
define('BASE_PATH', __DIR__ . '/../'); // Subir un nivel desde /config/
// ruta de acceso a la carperta controller
define('CONTROLLER_PATH', BASE_PATH . 'controller/');
// ruta de acceso a la carperta model
define('MODEL_PATH', BASE_PATH . 'model/');
// ruta de acceso a la carperta view
define('VIEW_PATH', BASE_PATH . 'view/');
//ruta de acceso para las librerias 
define("LIBRARY_PATH",BASE_PATH."lib/");



define("COST_MVC", "bitacora_oriental");
/*Manejo de sessiones */
define("COST_PASSWORD", ["cost" => 11]);
//llane para desencriptar datos del usuario 
define("KEY_DECRYP","cd chmod 777 /XMAPP.XD");
/**EL DEFAULT_ADDRESS_LOGOUT debe tener el nombre de la carpeta*/
define("DEFAULT_ADDRESS_LOGOUT","index.php");
/**Define la cantidad de dias de antelacion con la que se notifica el viaje mas cercano */
define("TRAVEL_NOTIFICATION_PERIOD",7); //se expresa en dias
/*Duracion de la valides de los mensajes de verificación (Se expresa en minutos)*/
define("DEFAULT_DATE_CODE", 30);
/*Duracion del tiempo de sesion de los usuarios(Se expresa en minutos) */
Define("LOGOUT_TIME",60);
/*Contante para que la unidad monetaria se aplique de manera uniforme en la web*/
define("MONETARY_UNIT","Bs.S");

/*Constante para cambiar el mensaje de los campo obligatorios de manera global board */
define("DETAILS_ICON",'<svg class="bx blue icon-focus-options"  icon-focus-options" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M10.18 17H7v-2h3c.08-.68.23-1.36.5-2H7v-2h4.82c.03-.03.05-.06.08-.1A6.53 6.53 0 0 1 16.5 9H7V7h10v2h-.5c1.62 0 3.24.61 4.5 1.82V5a2 2 0 0 0-2-2h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h8.06c-.41-.26-.8-.55-1.16-.9c-.9-.89-1.45-1.97-1.72-3.1M12 3c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1m8.31 14.9c.44-.69.69-1.52.69-2.4c0-2.5-2-4.5-4.5-4.5S12 13 12 15.5s2 4.5 4.5 4.5c.87 0 1.69-.25 2.38-.68L22 22.39L23.39 21zm-3.81.1a2.5 2.5 0 0 1 0-5a2.5 2.5 0 0 1 0 5"/></svg>');

/*constante para los iconos de editar del sitema -- edit */
define("EDIT_ICON",'<svg class="bx green icon-focus-options" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M6 2c-1.11 0-2 .89-2 2v16a2 2 0 0 0 2 2h4v-1.91L12.09 18H6v-2h8.09l2-2H6v-2h12.09L20 10.09V8l-6-6zm7 1.5L18.5 9H13zm7.15 9.5a.55.55 0 0 0-.4.16l-1.02 1.02l2.09 2.08l1.02-1.01c.21-.22.21-.58 0-.79l-1.3-1.3a.54.54 0 0 0-.39-.16m-2.01 1.77L12 20.92V23h2.08l6.15-6.15z"/></svg>');
//&nbsp&nbsp
/*constante para los iconos de deshabilitar del sistema -- web*/
define("DISABLE_ICON",'<svg class="bx orange icon-focus-options" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="m5.12 5l.81-1h12l.94 1M12 17.5L6.5 12H10v-2h4v2h3.5zm8.54-12.27l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6 3 6.5V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.5c0-.5-.17-.93-.46-1.27"/></svg>');

/* boton de retorceder */
define('portalReturn', '<svg class="bx green" xmlns="http://www.w3.org/2000/svg"  width="48" height="48" viewBox="0 0 24 24"><path fill="currentColor" d="M19 7v4H5.83l3.58-3.59L8 6l-6 6l6 6l1.41-1.41L5.83 13H21V7z"/></svg>');

/*Constante para definir los iconos de editar del sistema -- web*/
define("ENABLE_ICON", '<svg class="bx green icon-focus-options" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M20.54 5.23c.29.34.46.77.46 1.27V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6.5c0-.5.17-.93.46-1.27l1.38-1.68C5.12 3.21 5.53 3 6 3h12c.47 0 .88.21 1.15.55zM5.12 5h13.75l-.94-1h-12zM12 9.5L6.5 15H10v2h4v-2h3.5z"/></svg>');
//icono para la asistencia en el formulario
define("HELP_ICON",'<svg class="bx green" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M11.95 18q.525 0 .888-.363t.362-.887t-.362-.888t-.888-.362t-.887.363t-.363.887t.363.888t.887.362m-.9-3.85h1.85q0-.825.188-1.3t1.062-1.3q.65-.65 1.025-1.238T15.55 8.9q0-1.4-1.025-2.15T12.1 6q-1.425 0-2.312.75T8.55 8.55l1.65.65q.125-.45.563-.975T12.1 7.7q.8 0 1.2.438t.4.962q0 .5-.3.938t-.75.812q-1.1.975-1.35 1.475t-.25 1.825M12 22q-2.075 0-3.9-.787t-3.175-2.138T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>');
// Manejador de resaltado del sidebar

define("PDF_ICON", '<svg xmlns="http://www.w3.org/2000/svg" class="bx green icon-focus-options" width="36" height="36" viewBox="0 0 24 24" style="padding-top: 5px, padding-bottom: 5px;"><path fill="currentColor" d="M10 10.5h1q.425 0 .713-.288T12 9.5v-1q0-.425-.288-.712T11 7.5H9.5q-.2 0-.35.15T9 8v4q0 .2.15.35t.35.15t.35-.15T10 12zm0-1v-1h1v1zm5 3q.425 0 .713-.288T16 11.5v-3q0-.425-.288-.712T15 7.5h-1.5q-.2 0-.35.15T13 8v4q0 .2.15.35t.35.15zm-1-1v-3h1v3zm4-1h.5q.2 0 .35-.15T19 10t-.15-.35t-.35-.15H18v-1h.5q.2 0 .35-.15T19 8t-.15-.35t-.35-.15h-1q-.2 0-.35.15T17 8v4q0 .2.15.35t.35.15t.35-.15T18 12zM8 18q-.825 0-1.412-.587T6 16V4q0-.825.588-1.412T8 2h12q.825 0 1.413.588T22 4v12q0 .825-.587 1.413T20 18zm-4 4q-.825 0-1.412-.587T2 20V7q0-.425.288-.712T3 6t.713.288T4 7v13h13q.425 0 .713.288T18 21t-.288.713T17 22z"/></svg>');

//
class SIDEBAR_LOCATE {
    public static $activeOption = "none";
}




/* constantes para cargar la pagina por defecto en la main(pagina principal) */
define ( "DEFAULT_CONTROLLER", "home");//vista por defecto
define ("DEFAULT_ACTION", "homeInformation" );// accion por defecto

/*cookie de sesion que inidica el tiempo de vida de la sesion cuando de cierra el navegador */
session_set_cookie_params(0);

?>