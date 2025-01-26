<?php 

// validador de datos
require_once(CONTROLLER_PATH ."/dataValidator.php");

require_once(CONTROLLER_PATH."historys.php");

/* Modelo de usuario */
require_once(MODEL_PATH."/db.php");
  

  class user {

    /* Atributos de el usuario */
    public $idUser;
    public $idPerson;
    public $ci;
    public $name;
    public $lastname;
    public $birthDate;
    public $phone;
    public $email;
    public $idParroquia;
    public $address;
    public $privilege;
    public $password;
    public $status;
    public $verified;
   
    /*Atributos de conexion con BD */
    private $table = 'user';
	  private $conection;

    /*Atributo para manejar el cambio de contraseña*/ 
    public $objAuCode;

    public function __construct() {
		
    }

    /*Conexion con DB */
    public function getConection(){
      $dbObj = new Db();
      $this->conection = $dbObj->conection;
    }

    /*Extraccion de usuarios de la DB */
    public function getUsersByPrivilege($userType, $status) {
      $this->getConection();
      $sql = "SELECT 
                  u.*, 
                  p.* 
              FROM " . $this->table . " u 
              JOIN person p ON u.idPerson = p.idPerson 
              WHERE u.privilege = ? AND u.status = ? AND u.verified != 0";
      $stmt = $this->conection->prepare($sql);
      $stmt->execute([$userType, $status]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);

  }

  public function getUserById($id,$query="NONE"){
      $this->getConection();      
      /*condicional para saber que tipo de consulta con respecto al id se quiere hacer */
      if($query === "COUNT"){
        $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE idUser = ?";
      }else{
        $sql = " SELECT 
                u.idUser,
                u.idPerson,
                p.ci,
                p.name, 
                p.lastname as lastName , 
                p.birthDate, 
                u.email,
                p.phone, 
                u.privilege,
                p.address,
                p.idParroquia,
                pr.id_p,           
                pr.parroquia AS parroquia, 
                m.municipio AS municipio, 
                e.estado AS estado
            FROM 
                user u
            JOIN 
                person p ON u.idPerson = p.idPerson
            JOIN 
                parroquia pr ON p.idParroquia = pr.id_p
            JOIN 
                municipio m ON pr.municipio_id = m.id_m
            JOIN 
                estado e ON m.estado_id = e.id_e
            WHERE 
                u.idUser = ?;";      
      }
       
      $stmt = $this->conection->prepare($sql);
      $stmt->execute([$id]);
      /*segun la consulta retorna el valor adecuado para esta */
      return ($query === "COUNT")?  $stmt->fetchColumn() > 0 :  $stmt->fetch(PDO::FETCH_ASSOC);
  }
  //consulta para saber si la cedula el nombre y el apellido del usaurio ya existe
  function isPersonUnique($ci,$name,$lastName, $id = null) {
    $this->getConection();

    if ($id === null) {
        // Nuevo registro
        $sql = "SELECT COUNT(*) FROM person WHERE ci = ? AND name = ? AND lastName = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$ci, $name, $lastName]);
    } else {
        // Actualización de registro
        $sql = "SELECT COUNT(*) FROM person WHERE ci = ? AND name = ? AND lastName = ? AND idPerson != ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$ci, $name, $lastName, $id]);
    }

    return $stmt->fetchColumn() > 0;
}


    /*Extraccion de Usuarios Por el email de la DB y devuelve true o false */
    public function getUserByEmail($email,$query="NONE"){  
      $this->getConection();
      /* Condicional para saber qué tipo de consulta con respecto al email se quiere hacer */
      if ($query === "COUNT") {
          $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE email = ?";
      } else {
        $sql = "SELECT 
                u.*, 
                p.* 
                FROM " . $this->table . " u 
                JOIN person p ON u.idPerson = p.idPerson 
                WHERE u.email = ?";
      }
      $stmt = $this->conection->prepare($sql);
      $stmt->execute([$email]);
      /* Según la consulta, retorna el valor adecuado para esta */
      return ($query === "COUNT") ? $stmt->fetchColumn() > 0 : $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //funcion para comprobar que la persona tiene una cuenta
    public function userExist($ci,$name,$lastName) {
      $this->getConection();
      
      // Verificar si existe una persona con el ci el name y el lastName dado
      $sqlPerson = "SELECT p.*, idParroquia AS parroquia FROM person AS p WHERE ci = ? AND name = ? AND lastName = ?";
      $stmtPerson = $this->conection->prepare($sqlPerson);
      $stmtPerson->execute([$ci,$name,$lastName]);
      $person = $stmtPerson->fetch();

          // Verificar si la persona tiene un usuario asociado
          $sqlUser = "SELECT * FROM user WHERE idPerson = ?";
          $stmtUser = $this->conection->prepare($sqlUser);
          $stmtUser->execute([$person['idPerson']]);
          $user = $stmtUser->fetch();
  
          if ($user) {
              // La persona ya tiene un usuario asociado
              return false;
          } else {
              // La persona no tiene un usuario asociado, retornar datos de la persona
              return $person;
          }

  }
  
  
    /* Insercion de nuevos Usuarios a la DB */
    public function insert($param,$privilege = 'turista'){
      //condicional para comprobar que los datos no esten vacios
      if(validateParams($param['ci'],$param['name'],$param['lastName']
      ,$param['birthDate'],$param['phone'],$param['email'],
      $param['parroquia'],$param['address'])){
        trigger_error(E_USER_ERROR." - Error al registrar $privilege, el conjunto de datos que se intenta insertar no es válido.");
        return "error_insert_data";
      } 

      $personExist = "";      
      $CiExist = $this->isPersonUnique($param['ci'],$param['name'],$param['lastName']);
      if($CiExist){          
        $personExist = $this->userExist($param['ci'],$param['name'],$param['lastName']);//comprueva si la persona tiene cuanta y si no extrare los datos de esa persona para crearla
        if($personExist){
          $auxEmail = $param['email'];
          $auxPassword = $param['password']; 
          $param = $personExist;
          $param['email'] = $auxEmail;
          $param['password'] = $auxPassword;
        }else{
          return "ci_duplicate";
        }          
      }
                
      $this->getConection();

      // Asignación de parámetros
      $this->ci = $param['ci'];
      $this->name = strtolower($param['name']);
      $this->name = ucfirst($this->name);
      $this->lastname = strtolower($param['lastName']);
      $this->lastname = ucfirst($this->lastname);
      $this->birthDate = $param['birthDate'];
      $this->phone = $param['phone'];
      $this->email=$param['email'];      
      $this->idParroquia = $param['parroquia'];
      $this->address = $param['address'];
      $this->password = $param['password'];
      $hash = password_hash($this->password, PASSWORD_BCRYPT, COST_PASSWORD );
    

      $this->privilege = $privilege;
      if($privilege === 'turista'){
        $this->status = "0";
        $this->verified = "0";
      }else{
        $history = new historysController;
        $history->addRegister($this->table, "Insertó un usuario publicista.");

        $this->status = "1";
        $this->verified = "1";
      }

      if( $CiExist === false){    
        $sqlPerson = "INSERT INTO person (`ci`, `name`, `lastname`, `birthDate`, `phone`, `idParroquia`, `address`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtPerson = $this->conection->prepare($sqlPerson);
        $stmtPerson->execute([$this->ci, $this->name, $this->lastname, $this->birthDate, $this->phone, $this->idParroquia, $this->address]);  
        // Obtener el último ID insertado en 'person'
        $this->idPerson = $this->conection->lastInsertId();
      }else{        
        $this->idPerson = $param['idPerson'];
      }
      

      // Datos de la tabla 'user'
      $sqlUser = "INSERT INTO " . $this->table . " (`idPerson`, `email`, `privilege`, `password`, `status`, `verified`) VALUES (?, ?, ?, ?, ?, ?)";
      $stmtUser = $this->conection->prepare($sqlUser);
      $stmtUser->execute([$this->idPerson, $this->email, $this->privilege, $hash, $this->status, $this->verified]);

      // Obtener el último ID insertado en 'user'
      return $this->conection->lastInsertId();
    }

   

    public function editDataUser($param, $idPerson) {
      //condicional para comprobar que los datos no esten vacios
      if(validateParams($param['ci'],$param['name'],$param['lastName']
      ,$param['birthDate'],$param['phone'],$param['parroquia'],$param['address'])){
        trigger_error(E_USER_ERROR." - Error al editar datos del usuario, el conjunto de datos que se intenta editar no es válido.");
        return "error_edit_data";
      } 

      if($this->isPersonUnique($param['ci'],$param['name'],$param['lastName'], $idPerson)){
        return "ci_duplicate";
      }

      $this->getConection();
      $aux = "";
      // Asignación de parámetros
      $this->ci = $param['ci'];
      $this->name = strtolower($param['name']);
      $this->name = ucfirst($this->name);
      $this->lastname = strtolower($param['lastName']);
      $this->lastname = ucfirst($this->lastname);
      $this->birthDate = $param['birthDate'];
      $this->phone = $param['phone'];   
      $this->idParroquia = $param['parroquia'];
      $this->address = $param['address'];
  
      if ($this->editDataUserValidation($this->ci, $this->name, $this->lastname, $this->birthDate, $this->phone, $this->idParroquia, $this->address, $idPerson)) {
        $sqlPerson = "UPDATE person SET ci = ?, name = ?, lastname = ?, birthDate = ?, phone = ?, idParroquia = ?, address = ? WHERE idPerson = ?"; 
        $stmtPerson = $this->conection->prepare($sqlPerson); 
        $stmtPerson->execute([$this->ci, $this->name, $this->lastname, $this->birthDate, $this->phone, $this->idParroquia, $this->address, $idPerson]);
        //$stmtPerson->fetch(); 
        $aux = "edited_user"; // respuesta para cuando se edite el usuario
      } else {
          $aux = "user_no_changes"; // respuesta para cuando el usuario no haya hecho cambios
      }
      return $aux; // retorno de la respuesta
  }
  
  // Función para validar del lado del servidor si el usuario modificó los datos
  function editDataUserValidation($ci, $name, $lastname, $birthDate, $phone, $idParroquia, $address, $idPerson) {
      $this->getConection();
      $sql = "SELECT COUNT(*) FROM person WHERE idPerson = ? AND BINARY ci = ? AND BINARY name = ? AND BINARY lastName = ? AND BINARY birthDate = ? AND BINARY phone = ? AND idParroquia = ? AND BINARY address = ?";
      $stmt = $this->conection->prepare($sql);
      $stmt->execute([$idPerson, $ci, $name, $lastname, $birthDate, $phone, $idParroquia, $address]);
      return $stmt->fetchColumn() == 0;
  }
  


    public function editDateByAdmin($param,$id){
      //condicional para comprobar que los datos no esten vacios
      if(validateParams($param['ci'],$param['name'],$param['lastName']
      ,$param['birthDate'],$param['phone'],$param['parroquia'],$param['address'])){
        trigger_error(E_USER_ERROR." - Error al editar datos del usuario, la cadena de datos que se intenta editar no es válida.");
        return "error_edit_data";
      } 
      
      $this->getConection();

      // Asignación de parámetros
      $this->ci = $param['ci'];
      $this->name = strtolower($param['name']);
      $this->name = ucfirst($this->name);
      $this->lastname = strtolower($param['lastName']);
      $this->lastname = ucfirst($this->lastname);
      $this->birthDate = $param['birthDate'];
      $this->phone = $param['phone'];  
      $this->idParroquia = $param['parroquia'];
      $this->address = $param['address']; 
      
      // Obtiene el idPerson asociado al idUser
      $sqlGetIdPerson = "SELECT idPerson FROM " . $this->table . " WHERE idUser = ?";
      $stmtGetIdPerson = $this->conection->prepare($sqlGetIdPerson);
      $stmtGetIdPerson->execute([$id]);
      $idPerson = $stmtGetIdPerson->fetchColumn();

      if($this->isPersonUnique($param['ci'],$param['name'],$param['lastName'], $idPerson)){
        return "ci_duplicate";
      }

      // Actualiza los datos en la tabla person
      $sqlPerson = "UPDATE person SET ci = ?, name = ?, lastname = ?, birthDate = ?, phone = ?, idParroquia = ?, address = ? WHERE idPerson = ?";
      $stmtPerson = $this->conection->prepare($sqlPerson);
      $stmtPerson->execute([$this->ci, $this->name, $this->lastname, $this->birthDate, $this->phone, $this->idParroquia, $this->address, $idPerson]);
      
      $history = new historysController;
      $history->addRegister($this->table, "Editó datos de un usuario.");
      
      return "edited_user";
      
    }
    // funcion para cambiar el status del usaurio
    public function statusControl($id,$opc){
      $this->getConection();
      
      if(!empty($id) ){// se verifica que el id no este vacio 
        $this->idUser = $id;
      }else{// si esta vacio manda un reporte a PHPerror
        trigger_error(E_ERROR." - El ID del usuario es nulo o está vacío.");
        return "action_error_available";
      }
      //segun opc se banea o desbanea usuarios del sistema
      $history = new historysController;
      if($opc === 'disable') {
          $this->status = "0";
          $aux = "user_baned";    
          $history->addRegister($this->table, "Baneo un usuario.");
      }else if($opc === 'enable'){
          $this->status = "1";
          $aux = "user_desbaned";    
          $history->addRegister($this->table, "Desbaneo un usuario.");
      }
      //consulta para modoficar el status
      $sql = "UPDATE ".$this->table. " SET status = ? WHERE idUser = ?";
      $stmt = $this->conection->prepare($sql);
      $stmt->execute([$this->status, $this->idUser ]);
      return $aux;
  } 
  
  /*verifica que el usuario alla verificado su cuenta */
  public function accountVerification($email,&$hash,&$idHash, $aux = 'none'){
    $param = $this->getUserByEmail($email);

    if($param['status'] === '1' && $param['verified'] === '1' ){
       return 'valid_verify';//retorna verifiaccion valida si esta verificado
    }else if($param['status'] === '0' && $param['verified'] === '0'){
      if($aux === 'not_send') return 'set_verify';
      return  ($this->sendEmailValidation($param,$hash,$idHash,"none"));// si no esta verificado se envia un mensaje al correo del usuario para que pueda verificarse
    }else if($param['status'] === '0' && $param['verified'] === '1'){
      return 'user_ban';//indica que el usuario se encuentra baneado
    }else{
      trigger_error(E_ERROR." - Error en la autenticación del usuario, debido a que status = 1 y verified = 0; el usuario no puede estar activo y no verificado.");
      return 'account_verification_error';//indica un error en la verificacion      
    }
  }
  
  /*envia un mensaje de con un link el cual al acceder verifica que el correo es utilizado por alguien */
  public function sendEmailValidation($param,&$hash,&$idHash, $JS_json = 'send_json'){
    
    $auCode = $this->codeControl($param['idUser']);//auCode contiene datos de la autenticacion
    $hash = $auCode['hash'];// se guarda el valor del hash para operar en la vista 
    $idHash = $auCode['id'];
    $message = $this->headMail();// se capta el estandar del head del mail
    $message .= "<body>
        <div class='container'>
            <div class='header'>Código de Verificación: </div>
            <div class='content'>
                <p>Intento de verificación de cuenta ".$auCode['date']."</p>
                <p>Hola! ".$param['name']." ".$param['lastName'].",</p>
                <p>Su código de verificación de un solo uso es:</p>
                <div class='code'>".$auCode['code']."</div>
                <p>Por favor, utilice este código para completar su proceso de verificación. Si no solicitó este código, por favor ignore este mensaje.</p>
            </div>
            <div class='footer'>
                <p>Por favor, no responda a este mensaje ya que es generado automáticamente por nuestro sistema.</p>
                <p>Atentamente:<br>El equipo de Bitácora Oriental</p>
            </div>
        </div>
    </body>
    </html>";

    $to      = $param['email']; // Enviar Email al usuario
    $subject = "Bitácora Oriental: Verificación de cuenta"; // Darle un asunto al correo electrónico
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: tuemail@ejemplo.com' . "\r\n"; 
    
    if ( mail($to,$subject,$message,$headers)){//se envia el correo y se valida si se a enviado correctamente
      if($JS_json === "send_json"){

        // Datos que quieres enviar como JSON
        $data = array(
          "idHash" => $auCode['hash'],
          "hash" => $auCode['id'],
          "error" => "success"
        );
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
      } 
      return 'set_verify';//indica que se envio correctamente y genera un respuesta en la vista
    } else {
      if($JS_json === "send_json"){
        $data = array(
          "error" => "error_send"
        );
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
      } 
        return 'error_send_Verify';//inidica que no se envio correctamente el correo
    }

  }
  /*Activacion de cuenta del usuario */
  public function accountActivation($param){   
    $hash ="none";$idHash = "none";
    $aux =  $this->accountVerification($param['email'],$hash,$idHash,'not_send');
   if( $aux === 'set_verify'){
      $this->getConection();
      $this->email = $param['email'];
      /*consulta para saber si el email y el hash enviados a traves del link coinciden con los de la DB */
      $sql = "SELECT email FROM " . $this->table . " WHERE email = ?";
      $stmt = $this->conection->prepare($sql);
      $stmt->execute([$this->email]);
      if($stmt->rowCount() > 0){//condicion para ver si coinciden los datos email y hash
        /*consulta para acivar la cuenta, Modifica los valores status y hash */
        $sql = "UPDATE " . $this->table . " SET status = ?, verified = ? WHERE email = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute(['1', '1', $this->email]);
      
        $message = $this->headMail();// se capta el estandar del head del mail
        $message .= "<body>
            <div class='container'>
                <div class='header'>Registro de cuenta realizado con exito!</div>
                <div class='content'>
                    <p>Hola! ".$param['name']." ".$param['lastName'].",</p>
                    <p>Gracias por registrarte en nuestro sitio Web Bitácora Oriental</p>
                    <p>Ingresa a nuestro sitio web y disfruta de las experiencias turisticas que Bitacora Oriental puede ofrecer</p>
                    <a href='http://localhost/bitacora_oriental/index.php?controller=users&action=login' ><button class='button' >Iniciar Sesión</button></a> 
                    
                </div>
                <div class='footer'>
                    <p>Por favor, no responda a este mensaje ya que es generado automáticamente por nuestro sistema.</p>
                    <p>Atentamente:<br>El equipo de Bitácora Oriental</p>
                </div>
            </div>
        </body>
        </html>";
    
        $to      = $param['email']; // Enviar Email al usuario
        $subject = "Bitácora Oriental: Bienvenido!"; // Darle un asunto al correo electrónico
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: tuemail@ejemplo.com' . "\r\n"; 

        mail($to,$subject,$message,$headers);
          return "success_verifivation";
        }else{
          //echo '<br>Error de activacion de cuenta';//si no se logra activar debe retornar algun mensaje de error al usuario
          $aux = 'error_verifivation';
        }
    }
    return $aux; 
  }

  /**Envia un codigo de verificacion al correo del usuario */
  public function sendCodeRecoverPassword($param,&$idUser,&$hash,&$idHash, $JS_json = 'send_json'){
    $auCode = $this->codeControl($param['idUser']);//auCode tiene datos de la persona
    $idUser = $param['idUser'];//se guarda el valor del idUser para operar en la vista
    $hash = $auCode['hash'];// se guarda el valor del hash para operar en la vista 
    $idHash = $auCode['id'];

    $message = $this->headMail();// se capta el estandar del head del mail
    $message .= "<body>
        <div class='container'>
            <div class='header'>Código de Verificación: </div>
            <div class='content'>
                <p>Intento de recuperacion de contraseña ".$auCode['date']."</p>
                <p>Estimado ".$param['name']." ".$param['lastName'].",</p>
                <p>Su código de verificación de un solo uso es:</p>
                <div class='code'>".$auCode['code']."</div>
                <p>Por favor, utilice este código para completar su proceso de verificación. Si no solicitó este código, por favor ignore este mensaje.</p>
            </div>
            <div class='footer'>
                <p>Por favor, no responda a este mensaje ya que es generado automáticamente por nuestro sistema.</p>
                <p>Atentamente,<br>El equipo de Bitácora Oriental</p>
            </div>
        </div>
    </body>
    </html>";

    $to      = $param['email']; // Enviar Email al usuario
    $subject = "Bitácora Oriental: ¿Olvidaste tu contraseña?"; // Darle un asunto al correo electrónico
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: tuemail@ejemplo.com' . "\r\n"; 
    
    if (mail($to,$subject,$message,$headers)){//se envia el correo y se valida si se a enviado correctamente
      if($JS_json === "send_json"){
       
        // Datos que quieres enviar como JSON
        $data = array(
            "idHash" => $auCode['hash'],
            "hash" => $auCode['id'],
            "error" => "success"
        );

        header('Content-Type: application/json');

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
      } 
     
      return 'mail_send';//indica que se envio correctamente y genera un respuesta en la vista
    }else{
      if($JS_json === "send_json"){
        $data = array(
          "error" => "error_send"
        );
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
      } 
        return 'error_send';//inidica que no se envio correctamente el correo
    } 

  }

  /**establece la comunicacion entre el modelo de authenticationCode y user, y a su vez crea
   y extrea de la base de datos un codigo de verificacion para validar al usuario*/
  public function codeControl($idUser){
    require_once ('model/authenticationCode.php');// se requiere al modelo de authenticationCode
    $this->getConection();// la conexion se realiza en el modelo de user
    $this->objAuCode = new authenticationCode;//instancia de la clase de authenticationCode    
    $id = $this->objAuCode->createAuthenticationCode($idUser,$this->conection);//crea y retorna el id del codigo creado
    return $this->objAuCode->getAuthenticationCodeByIdANDIdUser($idUser,$id,$this->conection);// extrae los datos del codigo y los retorna
  }

  /**valida el codigo que el usuario esta ingresando*/
  public function codeValidation($idUser, $code, $hash){
    if(validateParams($idUser, $code, $hash)){
      trigger_error(E_USER_ERROR." - El conjunto de datos para validar al usuario está indefinido.");
      return "action_error_available";  
    }
    require_once ('model/authenticationCode.php');// se requiere al modelo de authenticationCode
    $this->getConection();// la conexion se realiza en el modelo de user
    $AuCode = new authenticationCode;//instancia de la clase de authenticationCode    
    /*se comprueba que el codigo de verificacion exista */
    if($AuCode->getAuthenticationCodeByIdUserANDCodeANDHash($idUser, $code, $hash, $this->conection)){
      if($AuCode->dateVerification($idUser, $code, $hash, $this->conection)){// se comprueba que el codigo de verificacion no alla expirado
        $AuCode->defuseCode($idUser, $code, $hash, $this->conection);
        return "valid_code";
      }else{
        return 'code_date_expire';// retorna una respuesta que indica que el codigo caduco
      }
    }else{ 
      return $AuCode->statusOfCode($idUser, $code, $hash, $this->conection) ? 'code_invalid' : 'code_expire' ;
    }
  }
  /*funcion que permite que los adminitradores puedan cambiar ellos mismos las contrasñeas de sus usuarios */
  public function adminChangepassword($idUser){

        //cadean de caracteres permitidos
        $letras = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // a-z y A-Z
        $numeros = '0123456789'; // 0-9
        $caracteresEspeciales = '-_.$+*@';
        
        // Asegurar que la contraseña contiene al menos un número, una letra y un carácter especial
        $contraseña = [
            $letras[rand(0, strlen($letras) - 1)],
            $numeros[rand(0, strlen($numeros) - 1)],
            $caracteresEspeciales[rand(0, strlen($caracteresEspeciales) - 1)]
        ];
        
        // Llenar los 7 caracteres restantes con los caracteres permitidos
        $caracteresPermitidos = $letras . $numeros . $caracteresEspeciales;
        for ($i = 0; $i < 7; $i++) {
            $contraseña[] = $caracteresPermitidos[rand(0, strlen($caracteresPermitidos) - 1)];
        }
        


        // Mezclar los caracteres para evitar patrones predecibles
        shuffle($contraseña);
        
        // Devolver la contraseña como un string
        $password = implode('', $contraseña);
        $param = $this->getUserById($idUser);
        $x = $password;
        $message = $this->headMail();// se capta el estandar del head del mail
        $message .= "<body>
            <div class='container'>
                <div class='header'>Código de Verificación: </div>
                <div class='content'>
                    <p>Intento de recuperación de contraseña a través del equipo de soporte de Bitácora Oriental</p>
                    <p>Estimado ".$param['name']." ".$param['lastName'].",</p>
                    <p>Su contraseña a sido restablecida</p>
                    <div class='code'>Nueva contraseña: "."$password"."</div>
                    <p>Inicie sesion con su nueva contraseña</p>
                </div>
                <div class='footer'>
                    <p>Por favor, no responda a este mensaje ya que es generado automáticamente por nuestro sistema.</p>
                    <p>Atentamente,<br>El equipo de Bitácora Oriental</p>
                </div>
            </div>
        </body>
        </html>";          
        $to      = $param['email']; // Enviar Email al usuario
        $subject = "Bitácora Oriental: ¿Olvidaste tu contraseña?"; // Darle un asunto al correo electrónico
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: tuemail@ejemplo.com' . "\r\n"; 
        //envio de la contraseña por correo
        if(mail($to,$subject,$message,$headers)){// si se envia correctamente se inserta en la basde de datos encriptada
          $this->conection;
          $this->changePassword($idUser,$password);          
          
          $history = new historysController;
          $history->addRegister($this->table, "Restablecio la contraseña de un usuario.");

          return 'password_recovered';
        } else {
          return 'password_not_change';
        } 

       
    }
  


  /*consulta para el cambio de contraseña */
  public function passwordChangeAuthentication($idUser,$idHash, $password,$hash){
    if(validateParams($idUser,$idHash,$password,$hash)){
      trigger_error(E_ERROR." - El conjunto de datos para el cambio de contraseña está indefinido.");
      return "action_error_available";
    } 

    $this->getConection();
    require_once ('model/authenticationCode.php');// se requiere al modelo de authenticationCode
    $AuCode = new authenticationCode;//instancia de la clase de authenticationCode    
    if($AuCode->hashVerificationExistAndUsed($idUser,$idHash,$this->conection)){
      $hash = $this->getPasswordById($idUser);
      /*comprueba que la la nueva contraseña no se igual a la vieja */
      if(password_verify($password, $hash)){
        return 'same_passwords';// retorna una respuesta que indica que las contraseñas son iguales
      }else{// si no son siguales se procede a modificar el password del usuario en la DB       
        $AuCode->hashDiscarted($idUser,$idHash,$this->conection);//modifica el status del codigo para descartarlo
        /*cambio de contraseña */
        $this->changePassword($idUser, $password);               
        $this->sendEmailOfsuccessChangePassword($idUser);
        return 'password_found';// retorna una respuesta que indica que el cambio de contraseña se echo correctamente
      }
    }else{
     return 'hash_discarted';
    }
  }

  /*funcion para extrar un password para comprar, es complementaria para el cambio de contraseña */
  public function getPasswordById($idUser){
    $this->getConection();
    /**extrae el hash vinculado al usuario de la base de datos*/
    $sql = "SELECT `password` FROM " . $this->table . " WHERE idUser = ? ";
    $stmt = $this->conection->prepare($sql);
    $stmt->execute([$idUser]);
    return $stmt->fetchColumn(); // Obtener el valor de la columna directamente
  }

  public function changePassword($idUser,$password){
    $this->getConection();
    $newhash = password_hash($password, PASSWORD_BCRYPT, COST_PASSWORD );//se encripta la nuea contrsaseña
    $sql = "UPDATE " . $this->table . " SET password = ? WHERE idUser = ?";
    $stmt = $this->conection->prepare($sql);
    $stmt->execute([$newhash,$idUser]);//se ejecuta la constulta
  }

  /*function es capas de enviar un email cuando se cambia la contraseña, es complementaria para el cambio de comtraseña */
  public function sendEmailOfsuccessChangePassword($idUser){
    $param = $this->getUserById($idUser);
        
    $message = $this->headMail(); // se capta el estandar del head del mail
    $message .= "<body>
        <div class='container'>
            <div class='header'>Contraseña actualizada!</div>
            <div class='content'>
                <p>Hola! ".$param['name']." ".$param['lastName'].",</p>
                <p>Su cambio de contraseña fue realizado correctamente</p>
                <p>Esperomos que pueda seguir disfrutando de las experiencias turisticas que Bitácora Oriental puede ofrecer</p>
                <a href='http://localhost/MVC_11nuevo/index.php?controller=users&action=login' ><button class='button' >Iniciar Sesión</button></a> 
            </div>
            <div class='footer'>
                <p>Por favor, no responda a este mensaje ya que es generado automáticamente por nuestro sistema.</p>
                <p>Atentamente:<br>El equipo de Bitácora Oriental</p>
            </div>
        </div>
    </body>
    </html>";
  
    $to      = $param['email']; // Enviar Email al usuario
    $subject = "Bitácora Oriental: Contraseña Actualizada"; // Darle un asunto al correo electrónico
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: tuemail@ejemplo.com' . "\r\n"; 
    mail($to,$subject,$message,$headers);
  }

  /*Funcion para estandarizar el estilo de las mails */
  public function headMail(){//return el head de un html con css para crear el mail
    return "<!DOCTYPE html>
  <html lang='es'>
  <head>
      <meta charset='uft8_spanish2_ci'>
      <style>
          body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; display: flex; justify-content: center; align-items: center; height: 100vh; }
          .container { background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px; width: 100%; }
          .header { font-size: 24px; color: #333333; text-align: center; }
          .content { margin-top: 20px; color: #555555; }
          .content p { font-size: 16px; }
          .code { font-size: 20px; color: #000000; font-weight: bold; text-align: center; margin: 20px 0; }
          .button { display: block; width: 180px; margin: 20px auto; padding: 10px; background-color: #2dbd2d; color: #ffffff ; text-align: center; text-decoration: none; border-radius: 7px; }
          .footer { margin-top: 20px; font-size: 12px; color: #999999; text-align: center; }
      </style>
  </head>";
    }

    public function accesRegisterHistory($message){
      $history = new historysController;             
      $history->addRegister($this->table, $message);
    }


  }//////////////////////////////////////////////////////////////////////////////////////
?>