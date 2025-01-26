<?php
// validador de datos
require_once (MODEL_PATH."faq.php");

class faqsController{

    public $view;
    public $objFaq;
    public $objUserSession;
    public $response;
    public function __construct(){
        SIDEBAR_LOCATE::$activeOption = "Preguntas Frecuentes";
        $this->view= 'faq/listFaq';
        $this->objFaq = new faq ;
        $this->objUserSession = new userSession;
        $this->objUserSession->sessionAccessAdmin();//para denegar el accesp a los usurios no admins
        $this->response = array(
          "response" => "none" 
        );
    }
// uncion para mostrar los detalles del item en cuestion
    public function details(){
      if(isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id']) ){                
          echo json_encode($this->objFaq->getFaqById($_GET['id']),JSON_UNESCAPED_UNICODE);
      }else{
        echo json_encode(false);
      }
      exit();
  }
    
    public function listFaq(){
      
      return $this->objFaq->getFaq();
    }

    /*Listar paquetes deshabilitados*/
    public function listFaqDisable(){
      
      $this->view= 'faq/listFaqDisable';
      return $this->objFaq->getFaqByStatus('disable');
  }


  public function addFaq(){
    
    $this->view= 'faq/addFaq';
    if( isset($_POST['query']) ){
      $this->response['response'] =   $this->objFaq->insertFaq($_POST);
      $this->view= 'faq/listFaq';
      return $this->objFaq->getFaq();

    } 
  }

  public function editFaq(){
    // compureba que el id tenga algun valor
    if (!isset($_GET['id']) || empty($_GET['id'])){
      trigger_error(E_ERROR." - El ID de la pregunta frecuente está indefinido o no tiene un valor significativo.");
      $this->response['response'] = "action_error_available";
      return $this->objFaq->getFaqByStatus('enable');
    }

    $this->view = 'faq/editFaq';
    if($_SERVER['REQUEST_METHOD'] === 'POST'){  
      $this->response['response'] = $this->objFaq->saveFaq($_POST,$_GET['id']);
      $this->view= 'faq/listFaq';
      return $this->objFaq->getFaq();
    }
    return $this->objFaq->getFaqById($_GET['id']);  //------------Retorna el objeto modificado
  }


   /*habilitar e inhabilitar paqutes */
  public function status($id=null){    
    // compureba que el id tenga algun valor
    if (!isset($_GET['id']) || empty($_GET['id'])) {
      trigger_error(E_ERROR." - El ID de la pregunta frecuente está indefinido o no tiene un valor significativo.");
      $this->response['response'] = "action_error_available";
      return $this->objFaq->getFaqByStatus('enable');
    }
    

    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $opc  = $_GET['opc'];
  
      /*$_GET['opc'] es una variable que controla que opcion e una condicional se va a realizar */
      $this->response['response'] = $this->objFaq->statusControl($id, $opc);
        
    }
    if($_GET['opc'] === 'enable'){
      $this->view = 'faq/listFaqDisable';
      return $this->objFaq->getFaqByStatus('disable');
    }else{
      return $this->objFaq->getFaqByStatus('enable');
    }
  }
}