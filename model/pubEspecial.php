<?php
// validador de datos
require_once(CONTROLLER_PATH ."/dataValidator.php");

require_once(CONTROLLER_PATH."historys.php");

/*  modelo del modulo publicaciones especiales */
require_once(MODEL_PATH."/db.php");

    class pubEspecial{
      public $idPubSpecial;
      public $title;
      public $description;
      public $image;
      public $status;

   
      /*Atrubutos para la conexion con BD */
      public $table = 'pubspecials';
      public $conection;

      public function __construct(){
            
      }

      /*conexion con DB */
      public function getConection(){
        $DbObj= new Db;
        $this->conection = $DbObj->conection;
      }

      public function getPubEspecialByStatus($opc) {
        $this->getConection();
        if(!isset($opc)) return false; 
        $sql = "SELECT ps.*, i.imageUrl AS image
        FROM pubspecials ps
        INNER JOIN image i ON ps.idImage = i.idImage
        WHERE ps.status = ?";
        $stmt = $this->conection->prepare($sql);

        /* condicional para saber que contenido extraer */
        if ($opc === 'enable') {
            $stmt->execute(["1"]);
        } elseif ($opc === 'disable') {
            $stmt->execute(["0"]);
        } 
    
        return $stmt->fetchAll();
    }
        
  
      /*Extraccion de publicaciones especiales de la DB */

      public function getpubEspecialById($id) {
        if (is_null($id)) return false;
        $this->getConection();
        
        // Corrigiendo el uso del alias y la selección de columnas
        $sql = "SELECT PubSpecials.*, i.imageUrl AS image
                FROM " . $this->table . " PubSpecials
                INNER JOIN image i ON PubSpecials.idImage = i.idImage
                WHERE PubSpecials.idPubSpecial = ?";
                
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
    
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devolviendo el resultado como un array asociativo
    }
    

      

      /*Insertar nuevas publicaciones especiales a  la DB */
        
      public function insertPubEspecial($param,$image) {
        //Se comprueba que los datos no esten vacios                
        if(validateParams($param['title'],$param['description'],$image['name'])){
            trigger_error(E_USER_ERROR." - El conjunto de datos de la publicación especial que se intenta insertar no es válido.");
            return "error_insert_data";
        }
        $this->getConection();
        $this->title = $param['title'];
        $this->description = $param['description'];
        $this->status = true;
        if (isset($image)) {    /* inserta la imagen para extraer el idImage */
            $routeImage = 'asset/img/' . basename($image['name']); 
            if (move_uploaded_file($image['tmp_name'], $routeImage)) {
                // Insertar la URL de la imagen en la tabla 'image'
                $sqlImage = "INSERT INTO image (imageUrl) VALUES (?)";
                $stmtImage = $this->conection->prepare($sqlImage);
                $stmtImage->execute([$routeImage]);
                // Obtener el ID de la última imagen insertada
                $this->image = $this->conection->lastInsertId();
            } else {
                trigger_error(E_ERROR." - Error al insertar la imagen de la publicación especial.");
                return "error_insert_data";
            }
        } else {
            trigger_error(E_USER_ERROR." -  Error al insertar la imagen de la publicación especial.");
            return "error_insert_data";
        }
        $band = $this->consulta($param, "insert");//busqueda de parroquia Y lugar esta parte es para saber si ya esta insertada no se reincerte
        if($band==0){
            $sql = "INSERT INTO pubSpecials (`idPubSpecial`, `title`, `description`, `idImage`, `status`) 
            VALUES(NULL, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$this->title, $this->description, $this->image,  $this->status]);
            
            $history = new historysController;
            $history->addRegister($this->table, "El usuario insertó.");
            return "save";
        }else{
            return "duplicate";
        }
    }
    /* buscar coincidencias para no repetr el registro */
    public function consulta($param, $var, $id = null) {        
        $this->getConection();        
        if (isset($param['title'])) { $this->title = $param['title']; }        
        if (isset($param['description'])) { $this->description = $param['description']; }        
      
        $sqlCheck = "SELECT COUNT(*) FROM " . $this->table . " WHERE ";
    
        if ($var === 'edit') {
            $sqlCheck .= "BINARY title = ? AND BINARY description = ? ";
        } else {
            $sqlCheck .= "title = ? AND description = ? ";
        }
            
        if ($id !== null) {            
            $sqlCheck .= " AND idPubSpecial != ?";        
        }            
    
        $stmtCheck = $this->conection->prepare($sqlCheck);        
    
        if ($id !== null) {            
            $stmtCheck->execute([$this->title, $this->description, $id]);        
        } else {            
            $stmtCheck->execute([$this->title, $this->description]);        
        }        
    
        return $stmtCheck->fetchColumn();    
    }

    public function getPubSpecialById($id){  /* Busca por ID  en la BD*/
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table. " WHERE idPubSpecial = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(); 
    }

    

    /*edita las publicaciones especiales de la DB */
    public function editPubEspecial($param, $file, $id, $idImage) {
        //Se comprueba que los datos no esten vacios
          ;
        if(validateParams($param['title'],$param['description'],$idImage)){
            trigger_error(E_USER_ERROR." - El conjunto de datos de la publicación especial que se intenta editar no es válido.");
            return "error_edit_data";
        }
        $this->getConection();
        if (isset($id)) $this->idPubSpecial = $id;
        if (isset($param['title'])) $this->title = $param['title'];
        if (isset($param['description'])) $this->description = $param['description'];
        
        if (!empty($file) && $file['error'] == UPLOAD_ERR_OK) {
            $pubSpecialImage = 'asset/img/' . basename($file['name']);
            
            if (move_uploaded_file($file['tmp_name'], $pubSpecialImage)) {
                // Insertar la nueva URL de la imagen en la tabla 'image'
                $sqlImage = "INSERT INTO image (imageUrl) VALUES (?)";
                $stmtImage = $this->conection->prepare($sqlImage);
                $stmtImage->execute([$pubSpecialImage]);
                // Obtener el ID de la última imagen insertada
                $newImageId = $this->conection->lastInsertId();
                // Actualizar el ID de la imagen en la tabla 'route'
                $this->image = $newImageId;
            } else {
                trigger_error(E_ERROR." - Error al editar la nueva imagen de la publicación especial.");
                return "error_edit_data";
            }
        } else {
            $this->image = $idImage; // Usar la imagen de respaldo si no se sube una nueva
        }
        
        $aux = $this->getPubSpecialById($id);
        $band = $this->consulta($param, "edit", $this->idPubSpecial); // esta parte es para saber si hay un registro igual
        if ($band == 0 || (isset($aux) && $aux['idPubSpecial'] === $id)) {
            $sql = "UPDATE " . $this->table . " SET title = ?, description = ?, idImage = ? 
                    WHERE idPubSpecial = ?";
            $stmt = $this->conection->prepare($sql);
            $res = $stmt->execute([$this->title, $this->description, $this->image, $this->idPubSpecial]);
            
            $history = new historysController;
            $history->addRegister($this->table, "El usuario editó.");            
            return "update";
        } else {
            return "duplicate_edition";
        }
    }

    public function statusControl($id,$opc){

        $this->getConection();

        if(isset($id)) $this->idPubSpecial = $id;

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
        
        $sql = "UPDATE ".$this->table. " SET status = ? WHERE idPubSpecial = ?";
        $stmt = $this->conection->prepare($sql);
        $res = $stmt->execute([$this->status, $this->idPubSpecial]);
        return $aux;
    }    

}

?>