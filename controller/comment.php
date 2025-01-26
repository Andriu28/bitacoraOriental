<?php 

require_once( MODEL_PATH.'comment.php');

class commentController{/////////////////////////////////////////////////////////

    public $view;
    public $objComment;
    public $objUserSession;
    public $response;


    public function __construct(){
        SIDEBAR_LOCATE::$activeOption = 'Comentarios';
        $this->response = array(
            "response" => "none" 
          );        
        $this->view='comment/listComment';        
        $this->objComment = new comment;
        $this->objUserSession = new userSession;
        
    }

    // uncion para mostrar los detalles del item en cuestion
    public function details(){            
        if(isset($_GET['id']) && !empty($_GET['id'])){                               
            echo json_encode($this->objComment->getCommentById($_GET['id']), JSON_UNESCAPED_UNICODE);
        }else{                
            echo json_encode(false);
        }
        exit(); 
    }

    //funcion para insertar comentarios(pensado para regitrarlos de manera asincronicica).
    public function insert(){                      
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {                  
            echo json_encode(array('success' => $this->objComment->insertComment($_POST['idUser'],$_POST['idWebLog'],$_POST['commentMessage'])) );                        
        }
       
        exit();
    }

    public function addcomment(){
        $this->view = "template/ejem";
    }

    //Retorna los comentarios en espera de una bitacora
    public function listComment(){  
        $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas                         
        return array('dataComment' =>$this->objComment->getCommentByStatus($_GET['type'])); 
    }
    //funcion para cambiar el status aceptado
    public function commentAccept(){ 
        $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas            
        return $this->statusControl('A');// A comentario acceptado para que aparesca en la bitacora
    }
    //funcion para cambiar el status a rechazado
    public function commentRejected(){            
        $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas 
        return $this->statusControl('R');// R de comentario rechazado para que no aparezca en la bitacora
    }
    //funcion para usarse de manera asincronica

    public function commentDiscardted(){ // comentario Borrado para que no aparesca en ninguna lado()           
        $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas 
        $aux = $this->statusControl('B','send_json_response');
        echo json_encode(array('response' => $aux));
        exit(); 
    }

    public function statusControl($status,$json = 'none'){   
        $this->objUserSession->sessionAccessTourist();//Restringe el acceso a los turistas          
        if(isset($_GET['id']) && !empty($_GET['id'])){                           
            $this->response['response'] = $this->objComment->setStatusById($status, $_GET['id']);
            return array('dataComment' =>$this->objComment->getCommentByStatus($_GET['type'])); 
        }else{                
            if($json === 'none'){                
                if (!isset($_GET['id']) || empty($_GET['id'])){
                    trigger_error(E_ERROR." - El ID del comentario está indefinido o no tiene un valor significativo.");
                    $this->response['response'] = "action_error_available";
                    return array('dataComment' =>$this->objComment->getCommentByStatus($_GET['type'])); 
                } 
            }else{
               return 'error_delete_coment'; 
            }
        }
        
    }////////////////////////////////////////////////////////

    public function getBitacoraComent(){
        $this->view = 'webLog/bitacoraConComentarios';
        
        // Obtén los comentarios con estado 'A' usando objComment
        $dataComment = $this->objComment->getCommentView($_GET['id'],'A'); // Cambiado a objComment
   
        // Asegúrate de que los datos se pasen correctamente a la vista
        return array('dataComment' => $dataComment);
    }
       
}/////////////////////////////////////////////////////////////////////////////////
?>

