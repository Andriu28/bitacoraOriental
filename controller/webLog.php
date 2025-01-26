<?php

require_once (MODEL_PATH."webLog.php");

class webLogController {
    public $view;
    public $objWebLog;
    public $objUserSession;
    public $response;

    public function __construct() {
        SIDEBAR_LOCATE::$activeOption = 'Bitacoras de Viaje';
        $this->response = array(
            "response" => "none" 
          );
        $this->view = 'webLog/WebLogList';
        $this->objWebLog = new WebLog(); 
        $this->objUserSession = new UserSession();
        //$this->objUserSession->sessionAccessTourist(); // Restringe el acceso a los turistas 
        /* esto no permie ver las bitacoras a los turistas */
    }

    public function list() {
        // Obtén todas las bitácoras habilitadas               
        return $this->objWebLog->getWebLogByStatus('enable');
    }
    

    public function listDisable() {
        $this->view = 'webLog/listWeblogDisable';
        // Obtén todas las bitácoras deshabilitadas       
        return $this->objWebLog->getWebLogByStatus('disable');
    }


    public function details(){       
        if(isset($_GET['id']) && !empty($_GET['id'])){                                              
            echo json_encode($this->objWebLog->getWebLogByIdforDetails($_GET['id']),JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode(false);
        }
        exit();
    }


     
     public function insert() {
        $this->objUserSession->sessionAccessTourist(); // Asegurarse de que se permite el acceso como sea necesario
        $this->view = 'webLog/insertWebLog';    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capturar respuesta de insertWebLog
           $this->response['response'] = $this->objWebLog->insertWebLog($_POST, $_FILES['images']);
           $this->view = 'webLog/WebLogList';
           return $this->objWebLog->getWebLogByStatus('enable');
        }
        return $this->objWebLog->getTrip("R"); //----------llamado del lista de paquetes habilitados en la bd
    }
    
    

    public function edit() {

        if (!isset($_GET['id']) || empty($_GET['id'])){
            trigger_error(E_ERROR." - El ID de la bitcora de viaje está indefinido o no tiene un valor significativo.");
            $this->response['response'] = "action_error_available";
            return $this->objWebLog->getWebLogByStatus('enable');
        }   

        $this->view = 'webLog/editWebLog';     
        // Comprobar si se está enviando el formulario de edición
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {                            
                // Llamar al método para editar el weblog y pasar los datos del formulario
                $this->response['response'] = $this->objWebLog->editWebLog($_POST, $_FILES["images"], $_GET['id']);                
                $this->view = 'webLog/WebLogList';
                return $this->objWebLog->getWebLogByStatus('enable');
        }

        //Extraccion de la bitacora para editar
        $weblogData = $this->objWebLog->getWebLogById($_GET['id']);    
        //retorne de los elementos necesarios para la edicion
        return array(
            'weblog' => $weblogData,// bitacora para editar
            'travelOffer' => $this->objWebLog->getTrip("R", $weblogData["idTravelOffer"]),// offertas de viaje
            'images' => $this->objWebLog->getImagesByWebLogId($weblogData['idWebLog']),// imagenes de la bitacora
        );
    }
    

    public function status() {
        if (!isset($_GET['id']) || empty($_GET['id'])){
            trigger_error(E_ERROR." - El ID de la bitcora de viaje está indefinido o no tiene un valor significativo.");
            $this->response['response'] = "action_error_available";
            return $this->objWebLog->getWebLogByStatus('enable');
        } 
        if (isset($_GET['id'])) {
           $this->response['response'] = $this->objWebLog->statusControl($_GET['id'], $_GET['opc']);
        }
    
        // Recuperar todos los weblogs según el estado
        if ($_GET['opc'] === 'enable') {
            $this->view = 'webLog/listWeblogDisable';
            return $this->objWebLog->getWebLogByStatus('disable');
        } 
        else {
           
            return $this->objWebLog->getWebLogByStatus('enable');
        }
        
    }//////////////////////////////////////////////////////////////////

    /* vista para las bitacoras */
    public function getBitacora(){
        
        $var = $this->objWebLog->getBitacora();
        if($var=='notWebLog'){
            $this->view='home/home';
            $this->response['response']  = $var; 
            require_once (CONTROLLER_PATH."home.php");
            $h= new homeController;
             return $h->homeInformation();
        }else{
            $this->view = 'webLog/bitacoras';
            return $this->objWebLog->getBitacora();
        }
     }

    /* vista de los comentarios*/
    public function getBitacoraComent(){

        $this->view = 'webLog/bitacoraConComentarios';
        require_once (MODEL_PATH."webLog.php");
    
        // Obtén los comentarios con estado 'A' usando objComment
        $dataComment = $objComment->getCommentView($_GET['id'],'A'); // Cambiado a objComment
   
        // Asegúrate de que los datos se pasen correctamente a la vista
        return array('dataComment' => $dataComment);
    }

   
    
    
   
}


?>
