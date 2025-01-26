<?php 
/*Este modelo es capas de gestionar codigos de verificacion para los distintos tipos de usuarios
 */


class authenticationCode {
    /*atributos para manejar codigos de autenticacion*/
    public $id;
    public $idUser;
    public $code;
    public $hash;
    public $date;
    public $status;

    private $table = 'authenticationcode';
   
  

  public function __construct(){}
  
  /**crea codigos de verificacion unicos y los guarda en la BD */
  public function createAuthenticationCode($idUser,$conection){
    $this->idUser = $idUser;// id del usuario para ser utilizado como clave foranea
    $this->code = rand(100000,999999);// generacion del codigo de confirmacion
    $this->hash = md5(rand(0,10000));// generacion del token
    $this->status = '1';
    /**consulta que guarda los datos del codigo de autenticacion */
    $sql = "INSERT INTO ".$this->table. "(`id`,`idUser`,`code`,`hash`,`date`,`status` ) VALUES(NULL, ? , ? , ? , NOW(),? )";
    $stmt = $conection->prepare($sql); 
    $stmt->execute([$this->idUser, $this->code, $this->hash,$this->status]);
    $id = $conection->lastInsertId();
    return $id;
  }
  /**consulta para extrar los datos de un codigo de verificacion segun su id */
  public function getAuthenticationCodeByIdANDIdUser($idUser, $id , $conection){
    $sql = "SELECT * FROM " . $this->table . " WHERE id = ? AND idUser = ?" ;
    $stmt = $conection->prepare($sql);
    $stmt->execute([$id, $idUser]);
    return $stmt->fetch();
  }

  /**consulta para verificar si un codigo de verificacion existe */
  public function getAuthenticationCodeByIdUserANDCodeANDHash($idUser, $code, $hash, $conection){
    $sql = "SELECT * FROM " . $this->table . " WHERE idUser = ? AND code = ? AND hash = ? AND status = 1" ;
    $stmt = $conection->prepare($sql);
    $stmt->execute([$idUser, $code, $hash]);
    return $stmt->rowCount() > 0;
  }

  /**consulta para validar que el codigo de verificacion no a caducado */
  public function dateVerification($idUser, $code, $hash, $conection){
    /**consulta de extra de la fecha del codigo*/
    $sql = "SELECT `date` FROM " . $this->table . " WHERE idUser = ? AND code = ? AND hash = ?";
    $stmt = $conection->prepare($sql);
    $stmt->execute([$idUser, $code, $hash]);
    $dateCode = $stmt->fetchColumn(); // Obtener la fecha del codigo para operar

    date_default_timezone_set('America/Caracas');// se establece la zona horaria
    $dateExpire = date("Y-m-d H:i:s"); // Formato de fecha // si no esta asi Y-m-d H:i:s no funciona
    $seconds = strtotime($dateExpire) - strtotime($dateCode);// determinado los segundos transcurridos
    $minutes = $seconds / 60;// convirtiendo a minutos
    return ($minutes < DEFAULT_DATE_CODE); // Retorna true si han pasado más de 10 minutos 
    }
    //desactiva el codigo de veridicacion una vez que se a usado correctamente
    public function defuseCode($idUser, $code, $hash, $conection){
      $sql = "UPDATE ".$this->table. " SET status = 0 WHERE idUser = ? AND code = ? AND hash = ?";
      $stmt = $conection->prepare($sql);
      $stmt->execute([$idUser, $code, $hash]);
      $stmt->fetch(); 
    }
    //verifica el estatus del codigo de verificacion
    public function statusOfCode($idUser, $code, $hash, $conection){
      $sql = "SELECT status FROM " . $this->table . " WHERE idUser = ? AND code = ? AND hash = ?";
      $stmt = $conection->prepare($sql);
      $stmt->execute([$idUser, $code, $hash]);
      $this->status = $stmt->fetchColumn(); 
      return ($this->status === '1' || $this->status === false )? true : false ;
    }

    public function hashVerificationExistAndUsed($idUser, $id , $conection){
      $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE id = ? AND idUser = ? AND status = 0" ;
      $stmt = $conection->prepare($sql);
      $stmt->execute([$id, $idUser]);
      return $stmt->fetchColumn() > 0;
    }

    public function hashDiscarted($idUser, $id , $conection){      
      $sql = "UPDATE ".$this->table. " SET status = 2 WHERE id = ? AND idUser = ?";
      $stmt = $conection->prepare($sql);
      $stmt->execute([$id,$idUser]);
      $stmt->fetch(); // Obtener la fecha del codigo para operar
    }

}


?>


