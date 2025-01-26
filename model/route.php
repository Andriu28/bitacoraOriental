<?php 
//--------------------------Modelo de las Rutas-----------------------///
// validador de datos
require_once(CONTROLLER_PATH ."/dataValidator.php");

require_once(CONTROLLER_PATH."historys.php");

require_once(MODEL_PATH."/db.php");
        
    class route{
       /*  se declaran las variables */
        public $idRoute;
        public $idParroquia;
        public $location;
        public $place  ;
        public $description;
        public $image;
        public $status;
        /* variable de la base de datos */
        public $table= 'route';
        public $conection;

        
        public function getConection(){ /* se conecta con la base de datos */
            $DbObj= new Db;
            $this->conection = $DbObj->conection;
        }
       
        public function getRoutesByStatus($status) { /* extrae las rutas segun el $status */
            $this->getConection();
            $sql = "SELECT r.*, p.parroquia, m.municipio, e.estado, i.imageUrl AS image
                    FROM $this->table r
                        INNER JOIN parroquia p ON r.idParroquia = p.id_p
                        INNER JOIN municipio m ON p.municipio_id = m.id_m
                        INNER JOIN estado e ON m.estado_id = e.id_e
                        INNER JOIN image i ON r.idImage = i.idImage
                    WHERE r.status = :status";
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
        public function addingRoute($param, $image) {  /*  añadir en BD la ruta de Viaje  */
            //Se comprueba que los datos no esten vacios
            if(validateParams($param['parroquia'],$param['location'], $param['place'],$param['description'] )){
                trigger_error(E_USER_ERROR." - El conjunto de datos de la ruta de viaje que se intenta editar no es válido.");
                return "error_insert_data";
            }

            $this->getConection();
            
            $this->idParroquia = $param['parroquia']; 
            $this->location = $param['location'];
            $this->place = $param['place'];
            $this->description = $param['description'];
            $this->status = true; 
            $imageId = null; // Variable para almacenar el ID de la imagen
            if (isset($image)) {    /* inserta la imagen para extraer el idImage */
                $routeImage = 'asset/img/' . basename($image['name']); 
                if (move_uploaded_file($image['tmp_name'], $routeImage)) {
                    // Insertar la URL de la imagen en la tabla 'image'
                    $sqlImage = "INSERT INTO image (imageUrl) VALUES (?)";
                    $stmtImage = $this->conection->prepare($sqlImage);
                    $stmtImage->execute([$routeImage]);
                    // Obtener el ID de la última imagen insertada
                    $imageId = $this->conection->lastInsertId();
                } else {
                    trigger_error(E_ERROR." - Error al insertar la imagen de la ruta de viaje.");
                    return "error_insert_data";
                }
            }else {
                trigger_error(E_USER_ERROR." - Error al insertar la imagen de la ruta de viaje.");
                return "error_insert_data";
            }

            $band = $this->consulta($param, "adding"); // Verificar si ya existe la parroquia y lugar
            if ($band == 0) {
                // Insertar datos en la tabla 'route' con el ID de la imagen
                $sql = "INSERT INTO " . $this->table . " (`idRoute`, `idParroquia`, `location`, `place`, `description`, `idImage`, `status`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$this->idParroquia, $this->location, $this->place, $this->description, $imageId, $this->status]);
                $history = new historysController;
                $history->addRegister($this->table, "El usuario insertó.");
                return "save";  /* Activa la alerta de guardado correctamente  */
            } else {
                return "duplicate"; /* activa la alerta de que el registro ya se encuentra guardado anteriormente */
            }
        }
        
        /* cosulta para saaber si la ruta ya existe para no agregarla denuevo o al editar no se haga duplicados*/
        public function consulta($param, $var, $id = null) {            
            $this->getConection();            
            if (isset($param['place'])) { $this->place = $param['place'];}            
            if (isset($param['parroquia'])) {$this->idParroquia = $param['parroquia'];
            }
        
            $sqlCheck = "SELECT COUNT(*) FROM " . $this->table . " WHERE ";
        
            if ($var === 'edit') {
                $sqlCheck .= "BINARY place = ? AND BINARY idParroquia = ? ";
            } else {
                $sqlCheck .= "place = ? AND idParroquia = ? ";
            }
                        
            if ($id !== null) {                
                $sqlCheck .= " AND idRoute != ?";            
            }
        
            $stmtCheck = $this->conection->prepare($sqlCheck);            
        
            if ($id !== null) {                
                $stmtCheck->execute([$this->place, $this->idParroquia, $id]);            
            } else {                
                $stmtCheck->execute([$this->place, $this->idParroquia]);            
            }            
        
            return $stmtCheck->fetchColumn();        
        }
        /* editar route */
        public function AboutWriting($param, $file, $id, $idImage) {  
            //Se comprueba que los datos no esten vacios                        
            if(validateParams($param['parroquia'],$param['location'], $param['place'],$param['description'] )){
                trigger_error(E_USER_ERROR." - El conjunto de datos de la ruta de viaje que se intenta insertar no es válido.");
                return "error_edit_data";
            }
            $this->getConection();
            
            if(isset($id)) $this->idRoute = $id;
            if(isset($param['parroquia'])) $this->idParroquia = $param['parroquia'];
            if(isset($param['place'])) $this->place = $param['place'];
            if(isset($param['location'])) $this->location = $param['location'];
            if(isset($param['description'])) $this->description = $param['description'];
            
            // Obtener información actual de la ruta
            $aux = $this->getRouteById($id);
            
            if (!empty($file) && $file['error'] == UPLOAD_ERR_OK) {
                $routeImage = 'asset/img/' . basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $routeImage)) {
                    // Insertar la nueva URL de la imagen en la tabla 'image'
                    $sqlImage = "INSERT INTO image (imageUrl) VALUES (?)";
                    $stmtImage = $this->conection->prepare($sqlImage);
                    $stmtImage->execute([$routeImage]);
                    // Obtener el ID de la última imagen insertada
                    $newImageId = $this->conection->lastInsertId();
                    // Actualizar el ID de la imagen en la tabla 'route'
                    $this->image = $newImageId;
                } else {
                    trigger_error(E_ERROR." - Error al editar la nueva imagen de la ruta de viaje.");
                    return "error_edit_data";
                }
            } else {
                $this->image = $idImage; // Usar la imagen de respaldo si no se sube una nueva
            }
        
            $band = $this->consulta($param, "AboutWriting", $this->idRoute); // Verificar si hay un registro igual
            if ($band == 0 || (isset($aux) && $aux['idRoute'] === $id)) {
                // Actualizar datos en la tabla 'route' con el nuevo ID de la imagen
                $sql = "UPDATE " . $this->table . " SET idParroquia = ?, location = ?, place = ?, description = ?, idImage = ? 
                WHERE idRoute = ?";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$this->idParroquia, $this->location, $this->place, $this->description, $this->image, $this->idRoute]);
                
                $history = new historysController;
                $history->addRegister($this->table, "El usuario editó.");

                return "update";
            } else {
                return "duplicate_edition";
            }
        }
        
        public function getRouteById($id) {  /* Busca por ID en la BD */
            $this->getConection();
            $sql = "SELECT route.* , i.imageUrl AS image 
                    FROM " . $this->table . " 
                    INNER JOIN image i ON route.idImage = i.idImage 
                    WHERE route.idRoute = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        public function getRouteByIdForDetails($id) {  /* Busca por ID en la BD */
            $this->getConection();
            $sql = "SELECT r.*, p.parroquia, m.municipio, e.estado, i.imageUrl AS image
                FROM $this->table r
                INNER JOIN parroquia p ON r.idParroquia = p.id_p
                INNER JOIN municipio m ON p.municipio_id = m.id_m
                INNER JOIN estado e ON m.estado_id = e.id_e
                INNER JOIN image i ON r.idImage = i.idImage
                WHERE r.idRoute = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
        
        public function statusRoute($id, $opc){   /*Modifica el Status en la BD*/ 
            $this->getConection();
            $this->idRoute=$id; 
            if($this->getRouteTraveloffer($this->idRoute) == 0){ 
                $opc==='true'? $opc='1': $opc='0'; 
                $this->status=$opc;
                $sql = "UPDATE ".$this->table. " SET status = ?  WHERE idRoute = ?";
                $stmt = $this->conection->prepare($sql);
                $res = $stmt->execute([$this->status, $this->idRoute ]);
                $history = new historysController;
                if($opc ==='1'){
                    $history->addRegister($this->table, "El usuario habilitó.");
                    return 'enable_allowed';
                }else{
                    $history->addRegister($this->table, "El usuario inhabilitó.");                     
                    return 'disabled_allowed';
                }
                
            }else{
                return 'disabled_not_allowed';
            }

        }

        public function getRouteTraveloffer($id){
            $this->getConection();
            $sql = "SELECT trip.idRoute
                    FROM traveloffer
                    JOIN trip ON traveloffer.idTrip = trip.idTrip
                    WHERE trip.idRoute = ? AND traveloffer.status = 1";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetchColumn();
        }

    }

?>