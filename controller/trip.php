<?php
//--------------------------------------Controlador de las Rutas----------------------------------///
require_once(MODEL_PATH."trip.php"); //--------------llamado al archivo del controlador de las Rutas


    class tripController{

        public $view; //---------------Atributo para las vistas
        public $ObjTrip; //---------- Atributo para el modelo de la base de datos
        public $objUserSession;//------Atributo para mantener la sesion activa
        public $response;

        public function __construct(){ //-------------------Constructor de atributos base del controlador
            SIDEBAR_LOCATE::$activeOption = "Ofertas de Viaje";
            $this->view='trip/listTrip';   //-------------listTrip vista base de las Rutas
            $this->ObjTrip = new trip ; //----------------Instancia el modelo de la base de datos de Rutas
            $this->objUserSession = new userSession;
            $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas 
            $this->response = array(
                "response" => "none" 
              );
        }
// uncion para mostrar los detalles del item en cuestion
        public function details(){            
            if(isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id']) ){                                                
                $data = $this->ObjTrip->getTripByIdForDetails($_GET['id']); 
                
                $data["MONETARY_UNIT"] = MONETARY_UNIT;

                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(false);
            }
            exit();
        }
        public function listTripEnabled(){ /* --------------------listar Rutas Habiles  */
            return $this->ObjTrip->getTrip("1"); //----------llamado del lista de paquetes habilitados en la bd
        }
        public function listTripRealiz(){ /* --------------------listar Rutas Habiles  */
            $this->view='trip/listRealzTrip';
            return $this->ObjTrip->getTrip("R"); //----------llamado del lista de paquetes habilitados en la bd
        }

        public function listTripDisabled(){    /* ----------Listar rutas Desahabilitas----------*/
            $this->view='trip/listDisabledTrip';
            return $this->ObjTrip->getTrip("0"); //---Retorna de la bd las rutas Desahabilitadas  
        }
  
        public function addTrip() {
            $this->view = 'trip/addTrip'; //-------------- Se manda la vista de añadir viajes
            if (isset($_POST['send'])) { //----------------Se evalúa si se enviaron datos en el botón send
               $this->response['response'] =  $this->ObjTrip->addingTrip($_POST);    
               $this->view = 'trip/listTrip' ;
               return $this->ObjTrip->getTrip(1);
            } else{
                require_once "route.php";           //--------Llama archivo controlador del Rutas      
                $route= new routeController;        //--------Se instancia el controlador del rutas
                SIDEBAR_LOCATE::$activeOption = "Ofertas de Viaje"; //-----para indicar el resaltado del sidebar
                return $route->listRouteEnabled();  //--------Se retornan los valores de las Rutas de la BD
            }
        }

        public function editTrip(){  //--------------------------Editar Rutas de  Viaje            
            // compureba que el id tenga algun valor
            if (!isset($_GET['id']) || empty($_GET['id'])){
                trigger_error(E_ERROR." - El ID de la oferta de viaje está indefinido o no tiene un valor significativo.");
                $this->response['response'] = "action_error_available";
                return $this->ObjTrip->getTrip(1);
            }
            $this->view='trip/editTrip';       //---------------Cambia la pantalla al editTrip
                //------------------------------------------------Llama a la funcion de sobre escribir
                if($_SERVER['REQUEST_METHOD'] === 'POST'){  
                $this->response['response'] = $this->ObjTrip->AboutWritingTrip($_POST, $_GET['id']); 
                $this->view = 'trip/listTrip' ;
                return $this->ObjTrip->getTrip(1);
            }
            return $this->ObjTrip->getTripById($_GET['id']);  //------------Retorna el objeto modificado
             
        }

        public function disableTrip(){   /* ---------------------------Desahabilitar y habilitar Rutas de viaje----------*/            
            // compureba que el id tenga algun valor
            if (!isset($_GET['id']) || empty($_GET['id'])){
                trigger_error(E_ERROR." - El ID de la oferta de viaje está indefinido o no tiene un valor significativo.");
                $this->response['response'] = "action_error_available";
                return $this->ObjTrip->getTrip(1);
            }

            if (isset($_GET['id']) && isset($_GET['opc'])){             //----------Valida si se envio el id y la opc a editar
                $this->response['response'] = $this->ObjTrip->statusTrip($_GET['id'], $_GET['opc']);  //----------Llama a el objeto que capta y edita el status
                return  $_GET['opc']==='I'?  $this->listTripEnabled() : $this->listTripDisabled();                 
                //---------------Muestra las vistas de habilitando o desahabilidando-----------------*/
            }    
        }

    }  /*----------------------------------------------------------------------- FINAL DEL OBJETO Trip*/
?>