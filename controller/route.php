<?php
//--------------------------------------Controlador de las Rutas----------------------------------///
    require_once(MODEL_PATH."route.php"); //--------------llamado al archivo del controlador de las Rutas
        
    class routeController{

        public $view; //---------------Atributo para las vistas
        public $ObjRoute; //---------- Atributo para el modelo de la base de datos
        public $objUserSession;//------Atributo para mantener la sesion activa
        public $response;
        public function __construct(){ //-------------------Constructor de atributos base del controlador
            SIDEBAR_LOCATE::$activeOption = "Rutas de Viajes";
            $this->view='route/listRoute';   //-------------listRoute vista base de las Rutas
            $this->ObjRoute = new route ; //----------------Instancia el modelo de la base de datos de Rutas
            $this->objUserSession = new userSession; //-----Instancia del obj sesion
            $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas 
            $this->response = array(
                "response" => "none" 
              );
        }
// uncion para mostrar los detalles del item en cuestion
        public function details(){
            if(isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id']) ){                
                echo json_encode($this->ObjRoute->getRouteByIdForDetails($_GET['id']),JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(false);
            }
            exit();
        }
         
        public function listRouteEnabled(){ /* --------------------listar Rutas Habiles  */
            return $this->ObjRoute->getRoutesByStatus(1); //----------llamado del lista de paquetes habilitados en la bd
        }
        
        public function listRouteDisabled(){    /* ----------Listar rutas Desahabilitas----------*/
           $this->view='route/routeListDisabled';   // -----------Asigna la vista de Rutas desahabilitadas
           return $this->ObjRoute->getRoutesByStatus(0); //---Retorna de la bd las rutas Desahabilitadas  
        }
  
        public function addRoute() {
            $this->view = 'route/addRoute'; // Se manda la vista de añadir Rutas 
            if (isset($_POST['send'])) { // Se evalúa si se enviaron datos en el botón send
                //$_POST = $this->chainCorrector($_POST); // Se depura el arreglo enviado 
                $this->response['response'] = $this->ObjRoute->addingRoute($_POST, $_FILES['image']);      
                $this->view = 'route/listRoute';
                return $this->ObjRoute->getRoutesByStatus(1); 
                
            }  
        }

        public function editRoute(){  //--------------------------Editar Rutas de  Viaje
            // compureba que el id tenga algun valor
            
            if (!isset($_GET['id']) || empty($_GET['id'])){
                trigger_error(E_ERROR." - El ID de la ruta de viaje está indefinido o no tiene un valor significativo.");
                $this->response['response'] = "action_error_available";
                return $this->ObjRoute->getRoutesByStatus(1); 
              }
            //---------------Cambia la pantalla al editRoute
            $this->view='route/editRoute';   
            //------------------------------------------------Llama a la funcion de sobre escribir
            if($this->ObjRoute->getRouteTraveloffer($_GET['id']) == 0){  
                if($_SERVER['REQUEST_METHOD'] === 'POST'){  
                    $this->response['response'] = $this->ObjRoute->AboutWriting($_POST, $_FILES['image'], $_GET['id'], $_GET['idImage']);
                    $this->view = 'route/listRoute';
                    return $this->ObjRoute->getRoutesByStatus(1);
                }
                return $this->ObjRoute->getRouteById($_GET['id']);  // Retorna el objeto modificado 
                
            }else{
                $this->view = 'route/listRoute'; 
                $this->response['response'] = 'edit_not_allowed';
                return $this->ObjRoute->getRoutesByStatus(1); 
            } 
              
        }

        public function disableRoute(){   /* ---------------------------Desahabilitar y habilitar Rutas de viaje----------*/
            // compureba que el id tenga algun valor
            
            if (!isset($_GET['id']) || empty($_GET['id'])){
                trigger_error(E_ERROR." - El ID de la ruta de viaje está indefinido o no tiene un valor significativo.");
                $this->response['response'] = "action_error_available";
                return $this->ObjRoute->getRoutesByStatus(1); 
              }
            if (isset($_GET['id']) && isset($_GET['opc'])){             //----------Valida si se envio el id y la opc a editar
                $this->response['response'] = $this->ObjRoute->statusRoute($_GET['id'], $_GET['opc']);  //----------Llama a el objeto que capta y edita el status
                return  $_GET['opc']==='false'?  $this->listRouteEnabled() : $this->listRouteDisabled();                 
                //---------------Muestra las vistas de habilitando o desahabilidando-----------------*/
            }    
        }

        public function chainCorrector($chain) {            /* CORRIGE LAS IMPERFECCIONES DE LA CADENA */
            foreach ($chain as &$valor) {         //-------------------Se recorre el objeto tipo arreglo
                if ($valor !== "backup") {        //-----------Se verifica si el valor no debe modificarse 
                    $valor = trim($valor);        //-------------------Se eliminan los espacios al principio y al final
                    $valor = strtolower($valor);  //----------------Se convierte toda la cadena en minuscula
                    $valor = ucfirst($valor);     //----------------Se convierte la primera letra en Mayuscula  
                }
            }
            return $chain;
        }
    }  /*----------------------------------------------------------------------- FINAL DEL OBJETO ROUTE*/
?>