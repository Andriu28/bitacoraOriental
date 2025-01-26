<?php
/* hola */
//Contante para la doreccion de la carpeta log
define("LOG_PATH",__DIR__."/log" );

// Configurar el informe de errores
error_reporting(E_ALL);
ini_set("display_errors", 0); // Mostrar errores en pantalla para desarrollo

// Registrar el manejador de errores
set_error_handler("globalErrorHandler");

// Registrar el manejador de excepciones
set_exception_handler("globalExceptionHandler");

// Función para manejar errores
function globalErrorHandler($errno, $errstr, $errfile, $errline) {
    checkLogFileSize(LOG_PATH."/PHPerrors.log");
    logError($errno, $errstr, $errfile, $errline);
    // Opcional: Mostrar un mensaje de error amigable al usuario
}

// Función para manejar excepciones
function globalExceptionHandler($exception) {
    checkLogFileSize(LOG_PATH."/PHPexceptions.log");
    logException($exception);
    // Opcional: Mostrar un mensaje de error amigable al usuario
}


// Función para registrar errores
function logError($errno, $errstr, $errfile, $errline) {
    date_default_timezone_set('America/Caracas');// se establece la zona horaria
    $errorMessage = "[" . date("Y-m-d H:i:s") . "] Error: $errno - $errstr en $errfile:$errline\n";
    echo $errorMessage;
    error_log($errorMessage, 3, LOG_PATH."/PHPerrors.log");
}

// Función para registrar excepciones
function logException($exception) {
    date_default_timezone_set('America/Caracas');// se establece la zona horaria
    $errorMessage = "[" . date("Y-m-d H:i:s") . "] Exception: " . $exception->getMessage() ." en " . $exception->getFile() . " en la línea " . $exception->getLine() . "\n";
   echo $errorMessage;
    error_log($errorMessage, 3, LOG_PATH."/PHPexceptions.log");
}

// Función para verificar el tamaño del archivo de log y archivarlo si es necesario
function checkLogFileSize($logFile) {
    $maxSize = 1048576; // 1MB
    if (file_exists($logFile) && filesize($logFile) > $maxSize) {
        rename($logFile, $logFile . '.' . time());
    } else if (!file_exists($logFile)) {
        // Crear el archivo de log si no existe
        file_put_contents($logFile, '');// Crea el archivo 'errors.log' si no existe
    }
}

// funcion auqe llama recusos requiridos para operar
function requiredResources(){
    
    
}
// funcion para mostrar la vista de error y registrar la Exeption
function putError($e){
    
    // Construccion de la vista para mostrar el error
    require_once(VIEW_PATH . "template/500.php");
    // registrp del error en el archivo log 
    globalExceptionHandler($e);
    
}
try {

    // LLamado a los archivos config y direccionador
    require_once(__DIR__  ."/config/config.php");
        
    // LLamado a el archivo userSession para manejar sesiones
    require_once(CONTROLLER_PATH . "userSession.php");
    // instancia del objeto de userSession para operar en el sistema
    $objUserSession = new userSession;
    
    // Validación del controlador y la acción
    if (!isset($_GET["controller"])) $_GET["controller"] = constant("DEFAULT_CONTROLLER");
    if (!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

    // Se crea la dirección del controlador a la que se quiere acceder
    $controller_path = "controller/" . $_GET["controller"] . ".php";

    // Valida si el archivo existe, si no existe se redirige a la vista 404
    if(!file_exists($controller_path)){
        // registro del error
        trigger_error(E_WARNING." - La dirección (URL) del controlador no existe.");
        // vista 404 para indicar que el link no existe o esta roto
        require_once(VIEW_PATH . "template/404.php");
        exit();
    }

    // Se accede al controlador
    require_once $controller_path;

    // Se crea el nombre de la clase del controlador que se quiere usar y se le concatena Controller
    $controllerName = $_GET["controller"] . 'Controller';

    // Se instancia el controlador
    $controller = new $controllerName();

    // Validar que el método exista
    $dataToView["data"] = array();
    if (method_exists($controller, $_GET["action"])){
        $dataToView['data'] = $controller->{$_GET["action"]}();        
    }else{
        throw new Exception("Error en la acción del controlador, la acción no existe.");
    }
            
    // ensamble de la vista para el usuario
    require_once(VIEW_PATH . "template/header.php");
    require_once(VIEW_PATH . $controller->view . ".php"); //Accediendo al atributo view que contiene la vista
    require_once(VIEW_PATH . "template/footer.php");


        // Código que puede lanzar diferentes tipos de excepciones
    } catch (PDOException $e) {// Capta errores de la base de datos
        putError($e);
    } catch (DivisionByZeroError $e) { // capta la divicion por 0 
        putError($e);
    } catch (ArgumentCountError $e) {// capta la falta de argumentos en una funcion
        putError($e);
    } catch (TypeError $e) {// capta errors con tipo de datos incorrectos
        putError($e);
    } catch (ErrorException $e) { // capta errores en general
        putError($e);
    } catch (Exception $e) {// capta Exceptions personalizadas
       
        putError($e);

        /* 
        Errores de Cliente (4xx): Errores causados por problemas en la solicitud del cliente (ej., 400, 401, 403, 404, 405).

        Errores de Servidor (5xx): Errores causados por problemas en el servidor al procesar la solicitud (ej., 500, 502, 503, 504).
        */
}
?>
