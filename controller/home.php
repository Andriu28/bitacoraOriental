<?php

require_once( MODEL_PATH."home.php");

class homeController{

    public $view;
    public $objHome;
    public $objUserSession;
    public $response;
    public function __construct(){
      SIDEBAR_LOCATE::$activeOption = "Portal";
        $this->view= 'home/home'; 
         //activa la sesion si anterior mente habia una
         $this->objHome = new home;
         $this->objUserSession = new userSession;
         $this->objUserSession->recoverySession();
         $this->response = array(
            "response" => "none" 
          );
    }

    

    public function homeInformation(){
            
        //llamado a los datos de la base de datos para el dashboard
        return array( // array asosiativo esquisofrenico 
          //--------Controlador para mostrar las Rutas activas en el home
          "packages" => $this->objHome->packagesList("enable"),
          "route" => $this->objHome->routeList(1),
          "faq" => $this->objHome->faqList("enable"),
          "pubSpecial" => $this->objHome->pubSpecialLit("enable"),
          "trip" => $this->objHome->tripList(1)
        ); 
    
    }
      
}

?>