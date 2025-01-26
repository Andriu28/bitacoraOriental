<?php 
// validador de datos
require_once(CONTROLLER_PATH ."/dataValidator.php");

require_once(CONTROLLER_PATH."historys.php");

//llamado a la base de datos
  require_once(MODEL_PATH."db.php");

  class faq{
    /*Atributos de la clase preguntas frecuentes*/
    public $idFaq;
    public $query;
    public $respond;
    public $status;

    /*Atrubutos para la conexion con BD */
    public $table = 'faq';
    public $conection;

    /*conexion con DB siendo asignada en la variable conection para ser manipulada desde alli */
    public function getConection(){
      $DbObj= new Db;
      $this->conection = $DbObj->conection;
    }
    /*Consulta para saber si se repite fue para los faq */
    public function consulta($param, $var,$id = null) {    
      $this->getConection();    
      if (isset($param['query'])) { $this->query = $param['query']; }    
      if (isset($param['respond'])) { $this->respond = $param['respond'];}
  
      $sqlCheck = "SELECT COUNT(*) FROM " . $this->table . " WHERE ";
  
      if ($var === 'edit') {
          $sqlCheck .= "BINARY query = ? AND BINARY respond = ? ";
      } else {
          $sqlCheck .= "query = ? AND respond = ? ";
      }
      
      if ($id !== null) {        
          $sqlCheck .= " AND id_preg_frecuente != ?";    
      }
  
      $stmtCheck = $this->conection->prepare($sqlCheck);    
      
      if ($id !== null) {        
          $stmtCheck->execute([$this->query, $this->respond, $id]);    
      } else {        
          $stmtCheck->execute([$this->query, $this->respond]);    
      }    
      
      return $stmtCheck->fetchColumn();
  }

    /*Extraccion de todas las preguntas frecuentes de
     la tabla en la DB */
    public function getFaq(){
      $this->getConection();
      $sql = "SELECT * FROM " .$this->table. " WHERE status != 0";
      $stmt = $this->conection->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);
      
    }

/* insercion de registro */
  public function insertFaq($param){    
    //Se comprueba que los datos no esten vacios
    if(validateParams($param['query'],$param['respond'])){
      trigger_error(E_USER_ERROR." - El conjunto de datos de la pregunta frecuente que se intenta insertar no es válido.");
      return "error_insert_data";
    }
            
    $this->getConection();

    /* comprobacion y asignacion de las variables globales para simplificar su manipulacion */
    $this->query = $param['query'];
    $this->respond = $param['respond'];

    $this->status = true;
    /* guardado de la consulta correspondiente a realizar */
    $band = $this->consulta($param, "insert");//busqueda de parroquia Y lugar esta parte es para saber si ya esta insertada no se reincerte
    
    if($band==0){
      $sql = "INSERT INTO " . $this->table . "(`query`, `respond` , `status`) VALUES( ?, ? , ?)";
      /* preparado y ejecucion de la consulta */
      $stmt = $this->conection->prepare($sql);
      $stmt->execute([$this->query, $this->respond,$this->status]);
      $id = $this->conection->lastInsertId();
      $history = new historysController;
      $history->addRegister($this->table, "El usuario insertó.");
      return "save";      
    }else{
        return "duplicate";
    }
  }

  /* busqueda de registro por id */
  public function getFaqById($id){
    if(is_null($id)) return false;
    $this->getConection();
    /* guardado de la consulta correspondiente a realizar */
    $sql = "SELECT * FROM ".$this->table. " WHERE id_preg_frecuente = ?";
    $stmt = $this->conection->prepare($sql);/* preparado y ejecucion de la consulta */
    $stmt->execute([$id]); 
    return $stmt->fetch(PDO::FETCH_OBJ);/* envio del registro encontrado */
  }


  /* guardado de registro */
  public function saveFaq($param,$id){    

    //Se comprueba que los datos no esten vacios
    if(validateParams($param['query'],$param['respond'])){
      trigger_error(E_USER_ERROR." - El conjunto de datos de la pregunta frecuente que se intenta editar no es válido.");
      return "error_edit_data";
    }
    $this->getConection();
    /* verificar existencia */
    /* reasignacion de valores */
    $idFaq = $id;
    $query = $param["query"];
    $respond = $param["respond"];
    
    $this->status = true;
    /* operacion en la base de datos */

    $aux = $this->getFaqById($idFaq);
    $band = $this->consulta($param, "edit", $idFaq); // esta parte es para saber si hay un registro igual

    if ($band == 0 || (isset($aux) && $aux->id_preg_frecuente === $idFaq)) {
        $sql = "UPDATE ".$this->table. " SET query=?, respond=?, status=? WHERE id_preg_frecuente=?";
        $stmt = $this->conection->prepare($sql);
        $res = $stmt->execute([$query, $respond, $this->status, $idFaq]);
        $history = new historysController;
        $history->addRegister($this->table, "El usuario editó.");
        return "update" ;
    }else{
        return "duplicate_edition";

    }
}

  public function statusControl($id,$opc){

    $this->getConection();

    if(isset($id)){
                  
      $history = new historysController;
      if($opc === 'disable'){
          $this->status = "0";  
          $aux='disabled_allowed';
          $history->addRegister($this->table, "El usuario inhabilitó.");
      }else if($opc === 'enable'){
          $this->status = "1";
          $aux= 'enable_allowed';  
          $history->addRegister($this->table, "El usuario habilitó.");      
      }
    
    }
    
    $sql = "UPDATE " .$this->table. " SET status = ? WHERE id_preg_frecuente = ?";
    $stmt = $this->conection->prepare($sql);
    $res = $stmt->execute([$this->status, $id ]);
    return $aux; 
  }


  /*Extraccion de paquetes de la DB segun su estatus */
  public function getFaqByStatus($opc) {
    $this->getConection();
    if(!isset($opc)) return false; 
    $sql = "SELECT * FROM " . $this->table . " WHERE status = ?";
    $stmt = $this->conection->prepare($sql);

    /* condicional para saber que contenido extraer */    
    if ($opc === 'enable') {
      $stmt->execute(["1"]);        
    } elseif ($opc === 'disable') {
        $stmt->execute(["0"]);
    } 

    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


}

?>