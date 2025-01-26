<?php 



require_once(MODEL_PATH."user.php");

  class usersController{
    public $view;
    
    public $response;
    public $objUser;
    public $objUserSession; 

    public function __construct(){   
      SIDEBAR_LOCATE::$activeOption = "Lista de Usuarios";   
      $this->view = 'user/listUser';
      $this->objUser = new user;      
      $this->response = array(
        "response" => "none"         
      );
      $this->objUserSession = new userSession;      
    }

    public function list(){
      $this->objUserSession->sessionAccessAdmin();//para denegar el accesp a los usurios no admins
      return $this->objUser->getUsersByPrivilege($_GET['userType'],$_GET['status']);
    }
// uncion para mostrar los detalles del item en cuestion
    public function details(){
      if(isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id']) ){        
          $data = $this->objUser->getUserById($_GET['id']);                    
          $data['privilege'] = ucfirst($data['privilege']);
          echo json_encode($data,JSON_UNESCAPED_UNICODE);

      }else{
        echo json_encode(false);
      }
      exit();
  }

    public function register(){
      //resgitringe el acesso a los usuarios si iniciaron sesion o si hay una sesion activa inseperada      
      $this->objUserSession->activeSessionValidation();
      $this->view='user/register';
      if(isset($_POST['send'])){
        /*comprueba si el email exite si es asi devuelve true en caso contrario false */
        if($this->objUser->getUserByEmail($_POST['email'],"COUNT")){//COUNT indica el tipo de consulta
          $this->response['response'] = "registered_mail";//da una respuesta en la vista, indica si el correo ya fue registrado
        }else{
          $_POST['idUser'] = $this->objUser->insert($_POST);//insersion de las datos en la DB        
          
          if($_POST['idUser'] === "error_insert_data"){
            $this->response['response'] = $_POST['idUser'];
            return;
          }
          
          if($_POST['idUser'] !== "ci_duplicate"){
            $_POST['action'] = "validation";
            $_GET['idUser'] = $_POST['idUser'];
            $this->view='user/codeIntroduction';
            $this->response['response'] = $this->objUser->accountVerification($_POST['email'],$_POST['hash'],$_POST['idHash']); //verificador de correo electronico
          }else{
            $this->response['response'] = $_POST['idUser'];
          }
        }
      }
    }
    /*funcion para cambiar la vista del al login comprobando que no alla sesiones activas */
    public function loginView(){
      $this->objUserSession->activeSessionValidation();
      $this->view = 'user/login';
    }

    /*Inicio de sesion del usuario */
    public function login(){
      
      $this->view='user/login';      
      /*se comprueba que se quiera pasar datos */
      if(isset($_POST['send'])){
        if(!isset($_POST['email']) || empty($_POST['email'])){
          $this->response['response'] = "error_login";
          trigger_error(E_ERROR." - El email está indefinido o no tiene un dato significativo.");
          return;
        }
        /*se extraen los datos de la BD para comparar */
        $param = $this->objUser->getUserByEmail($_POST['email']);
        /*Comprobacion de los datos del formulario con la base de datos*/
        if($param !== false && password_verify($_POST['password'], $param['password'])){
          $_GET['idUser'] = $param['idUser']; 
          $aux = $this->objUser->accountVerification($param['email'],$_POST['hash'],$_POST['idHash']);
          if($aux === 'valid_verify' ){
           
            $this->objUserSession= new userSession;//-------Se inicia la sesion a travez de la instanciacion del objeto
            $this->objUserSession->setCurrentUser($param,$param['privilege']);//-Se inicializan los datos de la SESSION
            $this->objUserSession->timeSession();
            
            //

            //$_GET['idTrip'];
            
            if( isset($_POST['idTrip']) && !empty($_POST['idTrip']) ){
              $_GET['idTrip'] = $_POST['idTrip'];
              $this->view = 'reservation/addRequestsReservation'; 
              $this->redirectingToReservation();
              return;
            }
            /*Se seleciona la vista segun el privilegio*/

            if($param['privilege'] === 'turista'){
              $this->view ='home/home';
              return $this->redirectingToHome();              
            }else{

              $this->objUser->accesRegisterHistory("el usuario inicio sesión");
              $this->view = "dashboard/dashboard";
              return $this->redirectingToDashboard();              
            }
            //require_once('controller/home.php');
            /**En caso de que el usuario necesite verificarse */
          }else if($aux === "set_verify" || $aux === "error_send_Verify"){
            $_POST['idUser'] = $param['idUser']; 
            $_POST['action'] = "validation";
            $this->view='user/codeIntroduction';
          }
         $this->response['response'] = $aux ;
        }else{
          if( isset($_POST['idTrip']) && !empty($_POST['idTrip']) ){
            $_GET['idTrip'] = $_POST['idTrip'];
          }
         $this->response['response'] = "incorrect_email_pass" ; //----si no se inicia se devuelve false a travez de la variable $_GET
        }
      }
      
      
    }

   /*Registro de usuarios publicistas */
    public function registerPublicist(){
      $this->objUserSession->sessionAccessAdmin();//para denegar el accesp a los usurios no admins
      $this->view='user/register';
      $_GET['userType']='publicist';//indica el tipo de usuario que se esta registrando
      
      if(isset($_POST['send'])){  
        if($this->objUser->getUserByEmail($_POST['email'],"COUNT")){//se verifica que el correo ingresado no este registrado
         $this->response['response'] = "registered_mail";
        }else{
          $aux = $this->objUser->insert($_POST,'publicista');//insersion de las datos en la DB
          if(is_numeric($aux)){
            $aux = 'user_insert';
          }

         $this->response['response'] = $aux;
          $this->view = 'user/listUser';
          return $this->objUser->getUsersByPrivilege($_GET['userTypeAux'],$_GET['status']);
        }
      }
    }

    /*Cambia el status de la cuenta */
    public function status(){
      $this->objUserSession->sessionAccessAdmin();//para denegar el accesp a los usurios no admins
      $this->view = 'user/listUser';
      if(isset($_GET['id'])){
         $this->response['response'] = $this->objUser->statusControl($_GET['id'],$_GET['opc']);
      }else{
        trigger_error(E_ERROR." - El ID del usuario es nulo o está vacío.");
        $this->response['response'] = "action_error_available";
      }
      return $this->objUser->getUsersByPrivilege($_GET['userType'],$_GET['status']);   
  }


 /**Edita perfiles de usuario */
 public function editUser(){
  $this->objUserSession->sessionAccessAdmin();//para denegar el accesp a los usurios no admins
  $this->view = 'user/editUser';
  if($_SERVER['REQUEST_METHOD'] === 'POST'){  
    if (!isset($_GET['id']) || empty($_GET['id'])){     
      $this->view = 'user/listUser'; 
      $this->response['response'] = "error_access_data";
      trigger_error(E_ERROR." - El ID del usuario es nulo o está vacío.");
      return $this->objUser->getUsersByPrivilege($_GET['userType'],$_GET['status']);
    }
   $this->response['response'] = $this->objUser->editDateByAdmin($_POST,$_GET['id']);
    $this->view = 'user/listUser';
    return $this->objUser->getUsersByPrivilege($_GET['userType'],$_GET['status']);
  }
  return $this->objUser->getUserById($_GET['id']);
}

  /*function para cambiar a la vista panel de usuario */
  public function userPanel(){
    SIDEBAR_LOCATE::$activeOption = "none";  
    $this->view = 'user/userPanel';
  }
  /*funcion para que el usuario pueda editar sus datos personales */
  public function editData(){
    $this->view = 'user/userPanel';
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);      
      if(!isset($sessionData['user']['idUser']) || empty($sessionData['user']['idUser'])){
        $this->response['response'] = "action_error_available";
        trigger_error(E_ERROR." - El ID del usuario es nulo o está vacío.");
        return;
      }
      $aux = $sessionData['user']['idUser'];      
      $this->response['response'] = $this->objUser->editDataUser($_POST, $_POST['idPerson']);            
      if($this->response['response'] === 'edited_user'){
        unset($_SESSION['user']);// se destruye la variable de sesion para ponerlo nuevos datos
        $user = $this->objUser->getUserById($aux);// asigancion del variable de sesion
        $_SESSION['user'] = $this->objUserSession->encryptData($user, KEY_DECRYP);
      }
      
      
    }

  }


  /*permite manejar comprobar el email ingresado para la recuperacion y enviar el mail con el codigo de verificacion */
  public function emailForRecover(){
    
    $this->objUserSession->activeSessionValidation();

    $this->view = 'user/recoverEmail';
      if(isset($_POST['send'])){
        $param = $this->objUser->getUserByEmail($_POST['email']);//se comprueba que el correo ingresado existe
        if($param !== false ){//si existe se cambia la vista y se envia el mail
          $hash="none";$idhash ="none";
          $aux = $this->objUser->accountVerification($_POST['email'], $hash ,$idhash,'not_send');
          if( $aux === 'valid_verify' ){//envio de codigo de verificacion
            $_GET['idUser'] = $param['idUser'];
            $_POST['action'] = "recover";
            $this->response['response'] = $this->objUser->sendCodeRecoverPassword($param, $_POST['idUser'], $_POST['hash'],$_POST['idHash'],"no_send_json");//envio de mail
            $this->view = "user/codeIntroduction";//cambio de la vista 
          }else{// en caso de que no este verificado e intente cambiar de contraseña
            if($aux === 'set_verify'){
             $this->response['response'] = "account_verification";
              $_GET['idUser'] = $param['idUser'];
            }else{
             $this->response['response'] = $aux ;  
            }
          }
        }else{
         $this->response['response'] = 'mail_not_found';//retorna una respues a la vista para indicar que el email ingresado no esta registrado
        }
      }   
      
  }
  /*permite recibir y validar el codigo enviado por el usuario */
  public function codeValidation(){
    
    //$this->objUserSession->activeSessionValidation();
    $this->view = "user/codeIntroduction";
    if(isset($_POST['send'])){
      if(!isset($_POST['idUser']) || empty($_POST['idUser'])){
        trigger_error(E_ERROR." - El ID del usuario está indefinido.");
        $this->view = 'user/login';;
        return;
      }
      /* llamado al modelo con los datos enviados por el usuario para validar */
      $aux = $this->objUser->codeValidation($_POST['idUser'], $_POST['code'], $_POST['hash']);
      if($aux === "valid_code" ){
        if($_GET['opc'] === "validation"){
          $this->view = 'user/login';
          $param = $this->objUser->getUserById($_POST['idUser']);
          $aux = $this->objUser->accountActivation($param);
          if($aux === 'error_verifivation'){
            $this->view = "user/codeIntroduction";
          }
        }else if($_GET['opc'] === "recover"){
          $this->view = 'user/recoverPassword';
        }
        
      }// si aux es verdadero se cambia la vista para el cambio de contraseña
     $this->response['response'] = $aux;// capta la respuesta del modelo para enviarla a la vista
      $_GET['idUser'] = $_POST['idUser'];
      $_POST['action'] =  $_GET['opc'];//indica la accion que quiero realizar en la vista de codeIntrodiction
    }
    $_GET['menuWeb'] = true;
  }

  /**permite reenviar el codigo de verificacion en caso de que este alla vencido*/
  public function sendCode(){
    $this->view = "user/codeIntroduction";
    $data = array("error" => "error_send");
    if(!isset($_GET['id']) || empty($_GET['id'])){      
      echo json_encode($data);
      exit();
    }

    $param = $this->objUser->getUserById($_GET['id']);
    if(isset($_GET['opc']) && $_GET['opc'] === "validation"){
      $hash = "none";$idHash = "none";
      $this->objUser->sendEmailValidation($param,$hash,$idHash);
    }else if( isset($_GET['opc']) && $_GET['opc'] === "recover"){
      $this->objUser->sendCodeRecoverPassword($param,$_POST['idUser'],$_POST['hash'],$_POST['idHash']);// se envia el mail al usuario
    }
  }
  
  /**permite el cambio de contraseña */
  public function changePassword(){    
    //$this->objUserSession->activeSessionValidation();
    $this->view = 'user/recoverPassword';
    
    if(isset($_POST['send'])){
      if(!isset($_POST['idUser']) || empty($_POST['idUser'])){
        trigger_error(E_ERROR." - El ID del usuario está indefinido.");
        $this->view = 'user/login';;
        return;
      }
    $aux = "";        
      /*llamado al modelo para cambiar la contraseña y retorna una repuesta a la vista */
     $aux = $this->objUser->passwordChangeAuthentication($_POST['idUser'],$_POST['idHash'], $_POST['password'],$_POST['hash']);     
      if($aux === 'password_found'){
        if(isset($_SESSION['user'])){
          $this->view = 'user/userPanel'; 
        }else{
          $this->view = 'user/login';
        }
      } 
   $this->response['response'] = $aux;
    }
    $_GET['menuWeb'] = true;
  }
  /**cambio de contraseña a travez del sistema (dentro de este) */
  public function changePasswordFromSystem(){
    if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);
    $this->view = "user/codeIntroduction";
    $sessionData['user'] = $this->objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);
    $param = $this->objUser->getUserByEmail($sessionData['user']['email']);
   $_GET['idUser'] = $sessionData['user']['idUser'];
    $_POST['action'] = "recover";
   $this->response['response'] = $this->objUser->sendCodeRecoverPassword($param, $_POST['idUser'], $_POST['hash'],$_POST['idHash'],"no_send_json");//envio de mail
  }

  //funcion para cambiar la contrasela del usuario a travez del admin
  public function changePasswordByAdmin(){       
    if (isset($_GET['id']) && !empty($_GET['id'])){      
      $this->response['response'] = $this->objUser->adminChangepassword($_GET['id']);      
    }else{
      $this->response['response'] = "none";
    }
      echo json_encode($this->response);
      exit();    
  }

  public function userVerification(){
    $this->view='user/codeIntroduction';
    if(isset($_GET['idUser']) && !empty($_GET['idUser'])){
      $param = $this->objUser->getUserById($_GET['idUser']);
      $this->objUser->sendEmailValidation($param,$_POST['hash'],$_POST['idHash'],'none');
      $_POST['idUser'] = $_GET['idUser']; 
      $_POST['action'] = "validation";      
     $this->response['response'] = 'set_verify';
    }else{
      trigger_error(E_ERROR." - El ID del usuario es nulo o está vacío.");
      $this->response['response'] = "action_error_available";
      $_POST['idUser'] = $_GET['idUser']; 
      $_POST['action'] = "validation";   
    }
  }
  /*sirve de coneccion con el controlador para retornar la informacion necesaria para la vista */
  public function redirectingToDashboard(){
    $this->objUserSession= new userSession;
    require_once(CONTROLLER_PATH.'dashboard.php');
    $obj = new dashboardController;
    return $obj->summary() ;
  }
  /*sirve de coneccion con el controlador para retornar la informacion necesaria para la vista */
  public function redirectingToHome(){
    $this->objUserSession= new userSession;
    require_once(CONTROLLER_PATH.'home.php');
    $obj = new homeController;
    return $obj->homeInformation() ;
  }

  public function redirectingToReservation(){
    $this->objUserSession= new userSession;
    require_once(CONTROLLER_PATH."reservation.php");
    $obj = new reservationController;
    $obj->requestReservation();    
  }
    /*Cierre de session */
  public function logout(){
    if( (isset($_SESSION['user'])) && ($_SESSION['privilege'] === "admin" || $_SESSION['privilege'] === "publicista" )){
      $this->objUser->accesRegisterHistory("el usuario cerro sesión");
    }
      $band = true;// esta variable se usa en el constructor de userSession
      $this->objUserSession = new userSession;
      $this->objUserSession->closeSession(); 
  }

  /*Para cuando se cierra la sesion por inactividad */
  public function timeLoguot(){

    $this->view='home/home';
    $this->response['response'] = "loguot_time";

    if( (isset($_SESSION['user'])) && ($_SESSION['privilege'] === "admin" || $_SESSION['privilege'] === "publicista" )){
      $this->objUser->accesRegisterHistory("La sesión del usuario fue cerrada por inactividad.");
    }

    $this->objUserSession = new userSession;
    session_unset();
    session_destroy();
    return $this->redirectingToHome();
  }

  }


?>