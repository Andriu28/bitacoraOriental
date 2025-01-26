<?php
require_once (CONTROLLER_PATH . "/userSession.php");
require_once  MODEL_PATH . 'history.php';
class historysController{

    public $view;
    public $objHistory;
    public $objUserSession;
    public $response;
    public function __construct(){
        
        $this->view = 'history/listHistory';
        $this->objHistory = new history;
        $this->objUserSession = new userSession;
        
        $this->response = array(
            "response" => "none" 
          );
    }

    public function listHistory(){
        $this->objUserSession->sessionAccessAdmin();//para denegar el accesp a los usurios no admins
        SIDEBAR_LOCATE::$activeOption = "Historial";
        return $this->objHistory->getHistory();

    }

    public function addRegister($module, $action) { 

        //array con el mapa de las modulos del sistema
        $table = array(
            "packages" => "Paquete de viaje",
            "faq" => "Preguntas Frecuente",
            "weblog" => "Bitácora de viaje",
            "comment" => "Comentarios",
            "history" => "Historial de usuario",
            "traveloffer" => "Oferta de Viaje",
            "trip" => "Oferta de Viaje",
            "user" => "Usuario",
            "reservation" => "Reservación",
            "route" => "Ruta",
            "accompanist" => "Acompañante",
            "pubspecials" => "Publicaciones Especiales",
            "person" => "Persona"
        );

        // descencriptado de los datos para optener el id del usuario
       $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
       $user = $sessionData['user']['idUser'];
       $module = $table[$module];
       

       $this->objHistory->regisHistory($user, $module, $action);
       
    }
}