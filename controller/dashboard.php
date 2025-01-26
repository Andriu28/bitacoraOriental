<?php

    require_once(MODEL_PATH."dashboard.php");
   
    class dashboardController{

        public $view;
        public $objDashboard;
        public $objUserSession;
        public $response;
        
        public function __construct(){
            
            SIDEBAR_LOCATE::$activeOption = "Escritorio de Trabajo";
            $this->response = array(
                "response" => "none" 
              );
            $this->objDashboard = new dashboard;                        
        }

    public function summary(){
        $this->view = "/dashboard/dashboard";
       
        $this->objDashboard->refreshTravelTime();
        $this->objDashboard->refreshReservationTime();
        //llamado a los datos de la base de datos para el dashboard
        
        return array( // array asosiativo esquisofrenico 

            //panel de control del dasboard
            "packages" => $this->objDashboard->packetCounting(),
            "route" => $this->objDashboard->routeCounting(),
            "faq" => $this->objDashboard->faqCounting(),
            "pubSpecials" => $this->objDashboard->pubSpecialsCounting(),                
            "userTourist" => $this->objDashboard->userTouristCounting(),
            "userPublicist" => $this->objDashboard->userPublicistCounting(),
            "weblog" => $this->objDashboard->weblogCounting(),
            //notificaciones del dashboard                       
            "reservation"=>$this->objDashboard->pendingReservationCount(),
            "comment" => $this->objDashboard->pendingCommentCount(),
            
            //viajes planificados
            "traveloffer" => $this->objDashboard->traveloffer(),
        ); 
        
    }

}/////////////////////////////////////////////////////////////////


?>