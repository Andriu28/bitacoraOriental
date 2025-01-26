<?php
/*empezando a modifixar */
require_once(MODEL_PATH."pubEspecial.php");


    class pubEspecialController{

        public $view;
        public $ObjpubEspecial;
        public $objUserSession;
        public $response;
        public function __construct(){
            SIDEBAR_LOCATE::$activeOption = "Publicaciones Especiales";
            $this->view='pubSpecial/pubEspecialList';
            $this->ObjpubEspecial = new pubEspecial;
            $this->objUserSession = new userSession;
            $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas 
            $this->response = array(
                "response" => "none" 
              );
        }

        public function list(){           /*lista  publicaciones especiales habilitadas */
            return $this->ObjpubEspecial->getPubEspecialByStatus('enable');
        }
        
        public function listDisable(){    /*Listar publicaciones especiales deshabilitados*/
            $this->view= 'pubSpecial/listPubEspecialDisable';
            return $this->ObjpubEspecial->getPubEspecialByStatus('disable');
        }
// uncion para mostrar los detalles del item en cuestion
        public function details(){
            if(isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id']) ){                
                echo json_encode($this->ObjpubEspecial->getpubEspecialById($_GET['id']),JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(false);
            }
            exit();
        }

        /*Insertar publicaciones especiales */
        public function insert() {
            $this->view = 'pubSpecial/insertPubEspecial'; // Se manda la vista de añadir Rutas 
            if (isset($_POST['send'])) { // Se evalúa si se enviaron datos en el botón send
                $this->response['response'] = $this->ObjpubEspecial->insertPubEspecial($_POST, $_FILES['image']);      
                $this->view='pubSpecial/pubEspecialList';
                return $this->ObjpubEspecial->getPubEspecialByStatus('enable');
            }  
            
        }

         /*editar publicacion */
         public function edit() {            
             // compureba que el id tenga algun valor
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                trigger_error(E_ERROR." - El ID de la publicación especial está indefinido o no tiene un valor significativo.");
                $this->response['response'] = "action_error_available";
                return $this->ObjpubEspecial->getPubEspecialByStatus('enable');
            }
            $this->view = 'pubSpecial/editPubEspecial'; 
   
            if($_SERVER['REQUEST_METHOD'] === 'POST'){  
                 $this->response['response'] = $this->ObjpubEspecial->editPubEspecial($_POST, $_FILES['image'] , $_GET['id'], $_GET['idImage']); 
                 $this->view='pubSpecial/pubEspecialList';
                 return $this->ObjpubEspecial->getPubEspecialByStatus('enable');
            }
            return  $this->ObjpubEspecial->getPubEspecialById($_GET['id']); //------------Retorna el objeto modificado 
        }

        public function status($id=null){            
            // compureba que el id tenga algun valor
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                trigger_error(E_ERROR." - El ID de la publicación especial está indefinido o no tiene un valor significativo.");
                $this->response['response'] = "action_error_available";
                return $this->ObjpubEspecial->getPubEspecialByStatus('enable');
            }
            if(isset($_GET['id'])){
                $id=$_GET['id'];
                /*$_GET['opc'] es una variable que controla que opcion e una condicional se va a realizar */
                $this->response['response'] = $this->ObjpubEspecial->statusControl($id,$_GET['opc']);
                
            }
            
            if($_GET['opc'] === 'enable'){
                $this->view = 'pubSpecial/listPubEspecialDisable';
                return $this->ObjpubEspecial->getPubEspecialByStatus('disable');
            }else{
                return $this->ObjpubEspecial->getPubEspecialByStatus('enable');
            }
        }

    }

?>