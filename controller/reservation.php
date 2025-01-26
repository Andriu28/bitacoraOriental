<?php
//--------------------------------------Controlador de las Rutas----------------------------------///
require_once(MODEL_PATH."reservation.php"); //--------------llamado al archivo del controlador de las Rutas


class reservationController {

    public $view; //---------------Atributo para las vistas
    public $response;//--------------Atributo para enviar/recibir respuesta de alert.js
    public $ObjReservation; //---------- Atributo para el modelo de la base de datos
    public $objUserSession;//------Atributo para mantener la sesion activa

    public function __construct() { //-------------------Constructor de atributos base del controlador
        SIDEBAR_LOCATE::$activeOption = "Solicitudes de Reserva"; 
        $this->view = 'reservation/a'; //-------------listReservation vista base de las Rutas
        $this->ObjReservation = new Reservation; //----------------Instancia el modelo de la base de datos de Rutas
        $this->objUserSession = new userSession;
        $this->response = array(
            "response" => "none" 
          );
    }
    public function details(){

        if(isset($_GET['id']) && !empty($_GET['id'])){ 
            $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);    
            $_GET['barco'] = $this->ObjReservation->getRequestsReservationById($_GET['id']);   
            $this->view= $_GET['vista'] ;  
            $_GET['status'] === 'A' ||  $_GET['status'] === 'C' ?  SIDEBAR_LOCATE::$activeOption = "Reservaciones" :   SIDEBAR_LOCATE::$activeOption = "Solicitudes de Reserva";   ;                    
            if($_GET['status'] === 'A'){
                $_GET['trip']= $this->ObjReservation->listOptionTrip();
            }
           return $this->ObjReservation->listRequestsCase($_GET['status'], $sessionData['user']);      
        }       
    }

    public function alertRequetsReservation(){
        if(isset($_SESSION['user']) && isset($_SESSION['privilege']) && $_SESSION['privilege'] !== 'turista' ){        
            if($this->ObjReservation->pedientRequestsReservation()){
                echo "pending_reservations";
            }else{
                echo "not_pending_reservations";
            }        
        }
    exit(); 
    }
    /* añadir reservaciones, sea quien sea el rpivilegio */
    public function requestReservation() {
        SIDEBAR_LOCATE::$activeOption = "Reservaciones"; 
        if (isset($_SESSION['user'])) {
            // Obtener el ID del viaje desde GET o POST si está definido, de lo contrario asignar null
            $tripId = $_GET['idTrip'] ?? $_POST['idTrip'] ?? null;
    
            if ($tripId !== null) { /* si se recarga la accion te manda al home */
                // Obtener los detalles del viaje y los paquetes disponibles
                $_GET["trip"] = $this->ObjReservation->getVacantTrip($tripId);
                $_GET["packages"] = $this->ObjReservation->getPackagesByTrip($tripId);
    
                // Establecer la vista para añadir la solicitud de reserva
                $this->view = 'reservation/addRequestsReservation';
    
                // Procesar la solicitud de reserva
                if (isset($_POST['addRequestsReservation'])) {
                    // Desencriptar los datos del usuario de la sesión
                    $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'], KEY_DECRYP);
    
                    // Añadir la reserva
                    $this->response['response'] = $this->ObjReservation->addingReservation($_POST, $sessionData['user']['idPerson'], $sessionData['user']);
    
                    // Redirigir al usuario a la vista principal
                    if(isset($_POST['admin']) && $_POST['admin'] == 'si'){
                        return $this->listRequestsA();
                        
                    }else{
                        $this->view = "home/home";
                        return $this->redirectingToHome();  
                    }
                  
                }
            } else {
               // Redirigir al usuario a la vista principal
               $this->view = "home/home";
               return $this->redirectingToHome();
            }
        } else {
            // Si el usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
            $this->response['response'] = "firth_sesion";
            $this->view = 'user/login';
        }
    }
    
    public function editRequestReservation(){
        $this->view = 'reservation/editRequestsReservation'; 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->view = 'reservation/editRequestsReservation';             
            
            $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
            $this->response['response'] = $this->ObjReservation->editReservation($_POST,$sessionData['user']['idPerson'], $sessionData['user']);
                                    
            $this->view = "home/home";
            return $this->redirectingToHome();
        } 

        $tripId = $_GET['idTrip'] ?? $_POST['idTrip'] ?? null;
        if ($tripId !== null) { /*si se recarga la acciion te manda  al home  */
            if (isset($_SESSION['user'])){
                
                $_GET["trip"] = $this->ObjReservation->getVacantTrip(isset($_GET['idTrip']) ? $_GET['idTrip'] : $_POST['idTrip']  );                     
                
                $_GET["packages"] = $this->ObjReservation->getPackagesByTrip(isset($_GET['idTrip']) ? $_GET['idTrip'] : $_POST['idTrip']  ); // Corregir la llamada a la función
                
                $_GET ['reservation'] = $this->ObjReservation->getRequestsReservationById(isset($_GET['id'] ) ? $_GET['id'] : $_POST['idReservation'] );  
                
                $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);             
                
                $_GET['user'] = $this->ObjReservation->getUserReservation(isset($_GET['id'] ) ? $_GET['id'] : $_POST['idReservation'] ,$sessionData['user']['idUser'],$sessionData['user']['idPerson']); 

                //condificon para cuando el usuario esta incluido en el viaje
                if($_GET['user'] === 'SI'){//si esta incluido sse debe borrar de la lista de los turistas debido a que se usan los datos de la sesion
                    
                    //optioncon de los datos de la persona para borrarlos
                    $userPerson = $this->ObjReservation->getUserReservationToEditDelete($sessionData['user']['idPerson']);
                    //borrado de los datos
                    $resultArray = $this->ObjReservation->removeMatchedPerson($_GET ['reservation'],  $userPerson);
                    //asignacion de los datos para enviar a la vista
                    $_GET ['reservation'] = $resultArray;// asignacion del array sin el user incluido

                }
                
            }
        } else {
            // Redirigir al usuario a la vista principal
            $this->view = "home/home";
            return $this->redirectingToHome();
        } 


    }


    public function listRequestsE(){ /* invoca la  busqueda de las solicitudes */
        $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP); 
        $this->view='reservation/listRequestsReservationE';
        return $this->ObjReservation->listRequestsCase('E',$sessionData['user']);
    }
    
    public function listRequestsD(){ /* invoca la  busqueda de las solicitudes */
        $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP); 
        $this->view='reservation/listRequestsReservationD';
        return $this->ObjReservation->listRequestsCase('D',$sessionData['user']);
    }
    public function listRequestsA(){ /* invoca la  busqueda de las solicitudes */
        $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP); 
        SIDEBAR_LOCATE::$activeOption = "Reservaciones"; 
        $this->view='reservation/listRequestsReservationA';   
         $_GET['trip']= $this->ObjReservation->listOptionTrip();
         
        return $this->ObjReservation->listRequestsCase('A',$sessionData['user']);
    }
    public function listRequestsC(){ /* invoca la  busqueda de las solicitudes */
        $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP); 
        SIDEBAR_LOCATE::$activeOption = "Reservaciones"; 
        $this->view='reservation/listRequestsReservationC';
        return $this->ObjReservation->listRequestsCase('C',$sessionData['user']);
    }
    public function listRequestsTouristA(){
        $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
        $this->view='reservation/listRequestsTouristA';
      return $this->ObjReservation->listRequestsTourist('A',$sessionData['user']['idUser']);
    }
    public function listRequestsTouristE(){
        $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
        
        $this->view='reservation/listRequestsTouristE';
        return $this->ObjReservation->listRequestsTourist('E',$sessionData['user']['idUser']);
    }

    /*sirve de coneccion con el controlador para retornar la informacion necesaria para la vista */
    public function redirectingToHome(){
        $this->objUserSession= new userSession;
        require_once(CONTROLLER_PATH.'home.php');
        $obj = new homeController;
        return $obj->homeInformation() ;
    }

    public function contolStatusRequests(){
        if(isset($_GET['id'])){
            $this->response['response'] = $this->ObjReservation->statusRequests($_GET['id'], $_GET['status'], $_GET['cant'], $_GET['idTrip']);
            $vista = "listRequests" . $_GET['vista'];
            return $this->$vista();
        } else {
            trigger_error(E_ERROR." - El ID de la solicitud de reservación está indefinido o no tiene un valor significativo.");
            $this->response['response'] = "action_error_available";
            return $this->listRequestsE();
        }  
    }
    

    }  /*----------------------------------------------------------------------- FINAL DEL OBJETO Trip*/

?>