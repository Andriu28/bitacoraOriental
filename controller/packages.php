<?php
    require_once(MODEL_PATH."packages.php");
    require_once(CONTROLLER_PATH."historys.php");

    class packagesController{

        public $view;
        public $objpackages;
        public $objUserSession;
        public $response;
        public function __construct(){
            $this->response = array(
                "response" => "none" 
              );
            SIDEBAR_LOCATE::$activeOption = "Paquetes de Viaje";
            $this->view='packages/packagesList';
            $this->objpackages = new packages;
            $this->objUserSession = new userSession;
            $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas 
        }


        /* listar Paquetes */
        public function list(){
            return $this->objpackages->getPackagesByStatus('enable');
        }
        
        /*Listar paquetes deshabilitados*/
        public function listDisable(){
            
            $this->view= 'packages/listPackagesDisable';
            return $this->objpackages->getPackagesByStatus('disable');
        }
        // uncion para mostrar los detalles del item en cuestion
         public function details(){            
            if(isset($_GET['id']) && !empty($_GET['id'])){                               
                $data = $this->objpackages->getPackagesById($_GET['id']);
                //busqueda de la clabe price para concatenar la unidad monetaria utilizada
                if (array_key_exists("price", $data)) {
                    // Obtener el valor correspondiente a la clave
                    $data['price'] = $data['price']." ".MONETARY_UNIT;// se guarda en el mismo valor par imprimirlo   
                }
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            }else{                
                echo json_encode(false);
            }
            exit(); 
        } 
       
        
        
            


        /*Insertar paquetes */
        public function insert(){                           
            $this->view= 'packages/insertPackages';
            if( isset($_POST['send']) ){
               $this->response['response'] = $this->objpackages->insertPackages($_POST);
               $this->view = 'packages/packagesList';
                return $this->objpackages->getPackagesByStatus('enable');
            }                
        }

        /*editar paquetes */
        public function edit(){                        
            // compureba que el id tenga algun valor
            if (!isset($_GET['id']) || empty($_GET['id'])){
                trigger_error(E_ERROR." - El ID del paquete de viaje está indefinido o no tiene un valor significativo.");
                $this->response['response'] = "action_error_available";
                return $this->objpackages->getPackagesByStatus('enable');
            }       
            $this->view='packages/editPackages';
           // if($this->objpackages->getPackagesByTravel($_GET['id']) == 0){  
                if(isset($_GET['id'])){
                    if($_SERVER['REQUEST_METHOD'] === 'POST'){                    
                   $this->response['response'] = $this->objpackages->editPackages($_POST,$_GET['id']);
                    $this->view = 'packages/packagesList' ;
                    return $this->objpackages->getPackagesByStatus('enable');
                    }
                return $this->objpackages->getPackagesById($_GET['id']);
                }
            /* }else{
                $this->view = 'packages/packagesList' ; 
                $this->response['response'] = 'edit_not_allowed';
                return $this->objpackages->getPackagesByStatus('enable');
            }  */

        }
        
        /*habilitar e inhabilitar paqutes */
        public function status(){            
            // compureba que el id tenga algun valor
            if (!isset($_GET['id']) || empty($_GET['id'])){
                trigger_error(E_ERROR." - El ID del paquete de viaje está indefinido o no tiene un valor significativo.");
                $this->response['response'] = "action_error_available";
                return $this->objpackages->getPackagesByStatus('enable');
            }      
            if(isset($_GET['id'])){
                /*$_GET['opc'] es una variable que controla que opcion e una condicional se va a realizar */
               $this->response['response'] = $this->objpackages->statusControl($_GET['id'],$_GET['opc']);
            }
            if($_GET['opc'] === 'enable'){
                $this->view = 'packages/listPackagesDisable';
                return $this->objpackages->getPackagesByStatus('disable');
            }else{                
                return $this->objpackages->getPackagesByStatus('enable');
            }
        
        }
      
    }
?>
