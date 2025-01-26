<?php 
  require_once(CONTROLLER_PATH ."/dataValidator.php");

  require_once(MODEL_PATH. "/db.php");

  class history{
    /*Atributos de la clase preguntas frecuentes*/
    public $idHistory;
    public $idUser;
    public $module;
    public $action;

    /*Atrubutos para la conexion con BD */
    public $table = 'history';
    public $conection;

    

    /*conexion con DB siendo asignada en la variable conection para ser manipulada desde alli */
    public function getConection() {
      
      $this->conection = (new Db)->conection;

    }



    public function getHistory() {
      $this->getConection();
      
      $sql = '
          SELECT user.email, user.privilege, history.module, history.action, history.registrationDate, history.registrationTime
          FROM user
          INNER JOIN history ON user.idUser = history.idUser
          WHERE history.registrationDate BETWEEN DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND CURDATE()
          ORDER BY history.registrationDate DESC, history.registrationTime DESC;
      ';
      
      $stmt = $this->conection->prepare($sql);
      $stmt->execute();
      
      // Obtener y devolver los resultados como objetos
      return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  

    public function regisHistory($idUser, $module, $action) {
        $this->getConection();        
        
        if ((!isset($idUser) || empty($idUser)) || (!isset($module) || empty($module)) || (!isset($action) || empty($action))   ){
          trigger_error(E_ERROR." - Error en el registro de historial, faltan datos para la operación.");
          return;
        }

        
        
        $sql = "INSERT INTO " . $this->table . " (`idHistory`, `idUser`, `module`, `action`, `registrationDate`, `registrationTime`) VALUES(NULL , ? , ? , ? , ? , ? )";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idUser, $module, $action, date('Y/m/d'), date('H:i:s')]);
        $this->conection->lastInsertId();
    }
  }