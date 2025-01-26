<?php

require_once(CONTROLLER_PATH ."/dataValidator.php");

require_once(CONTROLLER_PATH."historys.php");

require_once(MODEL_PATH."db.php");

class WebLog {
    public $idWebLog;
    public $idTravelOffer; // Atributo para la oferta de viaje
    public $description; // Descripción de la bitácora
    public $numberTravel; // Número del viaje
    public $status; // Estado de la bitácora

    /*Atrubutos para la conexion con BD */
    public $table = 'weblog'; // Nombre de la tabla
    public $conection; // Conexión a la base de datos

    public function __construct() {
        // Constructor vacío
    }

    // Conexión con la base de datos
    public function getConection() {
        $DbObj = new Db;
        $this->conection = $DbObj->conection;
    }

    public function getWebLogByIdforDetails($id){  
    $this->getConection();
    $sql = "SELECT 
            t.title AS tripTitle,
            t.departureDate,
            w.description,
            w.numberTravel,
            GROUP_CONCAT(img.imageUrl SEPARATOR '|') AS imageUrls,
            w.idTravelOffer,
            w.idWeblog,
            w.status
        FROM 
            imageweblog iw
        JOIN 
            weblog w ON iw.idWeblog = w.idWeblog
        JOIN 
            traveloffer toff ON w.idTraveloffer = toff.id
        JOIN 
            trip t ON toff.idTrip = t.idTrip
        JOIN 
            image img ON iw.idImage = img.idImage
        WHERE 
            w.idWeblog = ? AND iw.status = 1
        GROUP BY 
            w.idWeblog, w.idTravelOffer, w.description, w.numberTravel, w.status, t.title, t.departureDate;
        ";
    $stmt = $this->conection->prepare($sql);
    $stmt->execute([$id]);
    $aux = $stmt->fetch(PDO::FETCH_ASSOC); 
    if($aux === false){
        $sql = "SELECT 
        t.title AS tripTitle,
        t.departureDate,
        w.description,
        w.numberTravel,
        'noneImage' AS imageUrls,
        w.idTravelOffer,
        w.idWeblog,
        w.status
        FROM 
            weblog w
        JOIN 
            travelOffer toff ON w.idTravelOffer = toff.id
        JOIN 
            trip t ON toff.idTrip = t.idTrip
        WHERE 
            w.idWeblog = ?
        GROUP BY 
            w.idWeblog, w.idTravelOffer, w.description, w.numberTravel, w.status, t.title, t.departureDate;";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    return $aux;
}


    /*Extraccion de Bitacoras de la DB segun su estatus */
    public function getWebLogByStatus($opc) { // modelo
        $this->getConection();
        if (!isset($opc)) return false; 
    
        // Consulta SQL modificada para incluir el título de la tabla trip
        $sql = "
        SELECT DISTINCT 
            w.*,
            t.title AS tripTitle 
        FROM 
            " . $this->table . " w 
        JOIN 
            traveloffer toff ON w.idTraveloffer = toff.id 
        JOIN 
            trip t ON toff.idTrip = t.idTrip 
        WHERE 
            w.status = ?;";  // Esto devolverá solo títulos únicos

        $stmt = $this->conection->prepare($sql);

        
        $stmt = $this->conection->prepare($sql);
    
        /* Condicional para saber qué contenido extraer */
        if ($opc === 'enable') {
            $stmt->execute(["1"]);
        } elseif ($opc === 'disable') {
            $stmt->execute(["0"]);
        } 
    
        return $stmt->fetchAll();
    }


    public function getImagesByWebLogId($id) {
        $this->getConection();
        // Modificamos la consulta SQL para incluir una condición para el estatus en imageweblog
        $sql = "SELECT i.idImage, i.imageUrl 
                FROM image i 
                JOIN imageweblog iw ON i.idImage = iw.idImage 
                WHERE iw.idWebLog = ? AND iw.status = ?";        
        $stmt = $this->conection->prepare($sql);        
        // Ejecutamos la consulta pasando el ID del weblog y el estatus que queremos filtrar (1)
        $stmt->execute([$id, 1]);        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve las imágenes asociadas que cumplen con la condición
    }

    
    


    public function getTrip($status, $idTravelOffer = null) {
        $this->getConection();
        $sql = "
            SELECT 
                v.*, 
                MIN(t.id) AS idTraveloffer,  -- Obtener el primer idTraveloffer
                v.title AS titleTrip, 
                GROUP_CONCAT(t.amount SEPARATOR '<br><br>') AS amount,
                GROUP_CONCAT(p.title SEPARATOR '<br><br>') AS titlePackages,
                GROUP_CONCAT(t.idPackages SEPARATOR '<br><br>') AS idPackages,
                q.parroquia AS parroquiaName, 
                r.place, 
                m.municipio, 
                COUNT(t.idTrip) AS tripCount
            FROM 
                traveloffer t
            INNER JOIN 
                packages p ON t.idPackages = p.idPackages
            INNER JOIN 
                trip v ON t.idTrip = v.idTrip
            INNER JOIN 
                route r ON v.idRoute = r.idRoute
            INNER JOIN 
                parroquia q ON r.idParroquia = q.id_p
            INNER JOIN 
                municipio m ON q.municipio_id = m.id_m
            LEFT JOIN 
                weblog w ON t.id = w.idTravelOffer  -- Asegurarse de que idTravelOffer no esté en weblog
            WHERE 
                t.status = :status 
              ";  // Filtrar aquellos que no tienen idTravelOffer en weblog
    
        if ($idTravelOffer !== null) {
            $sql .= " OR t.id = :idTravelOffer";  // Incluir la condición de idTravelOffer si se proporciona
        }
    
        $sql .= " GROUP BY v.idTrip , t.status;";  // Agrupamos solo por v.idTrip
        
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        if ($idTravelOffer !== null) {
            $stmt->bindParam(':idTravelOffer', $idTravelOffer, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getWebLogById($id){  /* Busca por ID  en la BD*/
        $this->getConection();

        $sql = "SELECT * FROM ".$this->table. " WHERE idWebLog = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(); 
    }
    
    public function statusControl($id,$opc){

        $this->getConection();

        $history = new historysController;
        if(isset($id)) $this->idWebLog  = $id;

        if($opc === 'disable'){
            $this->status = "0"; 
            $aux="disabled_allowed";   
            $history->addRegister($this->table, "El usuario inhabilitó."); 
        }else if($opc === 'enable'){
            $this->status = "1";
            $aux= "enable_allowed";  
            $history->addRegister($this->table, "El usuario habilitó.");
        }
        
        $sql = "UPDATE ".$this->table. " SET status = ? WHERE idWebLog  = ?";
        $stmt = $this->conection->prepare($sql);
        $res = $stmt->execute([$this->status, $this->idWebLog ]);
        return $aux;
    } 

    
    public function editWebLog($param, $files, $id) {
        

        $this->getConection();
        // Validar y asignar parámetros
        if (isset($param['description'])) $this->description = $param['description'];
        if (isset($param['idTravelOffer'])) $this->idTravelOffer = $param['idTravelOffer'];
        if (isset($param['numberTravel']))  $this->numberTravel = $param['numberTravel'];
        

        $aux = $this->getWebLogById($id);// extraccion de los datos para optener el id de travelOffer        
        if($aux['idTravelOffer'] !== $this->idTravelOffer ){            
            $this->statusTravelChange($aux['idTravelOffer']);//cambio de status a la travelOffer que estaba antes por que si se cambia ta no tiene bitacora u se puede usar otra vez
            $this->statusTravel($this->idTravelOffer);//cambio del estatus a la nueva travelOffer
        }

        // Actualizar el weblog
        $sql = "UPDATE " . $this->table . " SET idTravelOffer = ?, description = ?, numberTravel = ? WHERE idWebLog = ?";
        $stmt = $this->conection->prepare($sql);
    
        // Ejecutar y verificar errores
        if (!$stmt->execute([$this->idTravelOffer, $this->description, $this->numberTravel, $id])) {
            trigger_error(E_USER_ERROR." - Error en la ejecucion de la consulta.");
            return "error_edit_data";
        }
        
         // Procesar las imágenes desde $_FILES
        if (isset($files['tmp_name']) && is_array($files['tmp_name'])){
            foreach ($files['tmp_name'] as $key => $tmpName) {
                // Verificar si hay un archivo cargado
                if (!empty($tmpName)) {
                    // Obtener la extensión del archivo
                    $fileExtension = pathinfo($files['name'][$key], PATHINFO_EXTENSION);
                    // Generar un nombre único para la imagen
                    $uniqueName = uniqid('img_', true) . '.' . $fileExtension;
                    // Definir la ruta de la imagen con el nombre único
                    $routeImage = 'asset/bitacora/' . $uniqueName;

                    // Mover el archivo cargado a la ubicación deseada
                    if (move_uploaded_file($tmpName, $routeImage)) {
                        // Insertar la URL de la imagen en la tabla 'image'
                        $sqlImage = "INSERT INTO image (imageUrl) VALUES (?)";
                        $stmtImage = $this->conection->prepare($sqlImage);
                        
                        if (!$stmtImage->execute([$routeImage])) {
                            trigger_error(E_ERROR." - Error al editar la nueva imagen de la ruta de viaje.");
                            return "error_edit_data";
                        }

                        // Obtener el ID de la última imagen insertada
                        $lastImageId = $this->conection->lastInsertId();

                       // Asociar la imagen al weblog
                        $sqlImageWeblog = "INSERT INTO imageweblog (idImage, idWebLog, status) VALUES (?, ?, ?)";
                        $stmtImageWeblog = $this->conection->prepare($sqlImageWeblog);

                        // Crear un array con los parámetros
                        $params = [$lastImageId, $id, "1"];

                        if (!$stmtImageWeblog->execute($params)) {
                            trigger_error(E_ERROR." - Error al editar la nueva imagen de la ruta de viaje.");
                            return "error_edit_data";
                        }

                    } else {
                        trigger_error(E_ERROR." - Error al editar la nueva imagen de la ruta de viaje.");
                        return "error_edit_data";
                    }
                }
            }
        }   


        // Procesar la recepción de imágenes para actualizar el estatus
        if (isset($param['UpdateImage'])) {
            foreach ($param['UpdateImage'] as $imageId) {
                // Preparar la consulta SQL para actualizar el estatus
                $sql = "UPDATE imageweblog SET status = 0 WHERE idImage = ?";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$imageId]);
            }
        }    
        $history = new historysController;
        $history->addRegister($this->table, "El usuario editó.");
        return "update"; // Indica que todo se actualizó correctamente
    }
    


    public function insertWebLog($param, $files) {
        $this->getConection();        
        if(validateParams($param['description'], $param['idTravelOffer'], $param['numberTravel'])){
            trigger_error(E_USER_ERROR." - El conjunto de datos de la bitácora de viaje que se intenta insertar no es válido.");
            return "error_insert_data";
        }

        if($this->weblogExist($param['idTravelOffer'])){
            return 'duplicate';
        }
    
        // Validar y asignar parámetros
        if (isset($param['description'])) $this->description = $param['description'];
        if (isset($param['idTravelOffer'])) $this->idTravelOffer = $param['idTravelOffer'];
        if (isset($param['numberTravel']))  $this->numberTravel = $param['numberTravel'];
    
        // Establecer estado por defecto
        $this->status = true; // Cambiado a 'A' para representar activo
    
        // Insertar el weblog
        $sql = "INSERT INTO " . $this->table . " (idWebLog, idTravelOffer, description, numberTravel, status) VALUES (NULL, ?, ?, ?, ?)";
        $stmt = $this->conection->prepare($sql);
    
        // Ejecutar y verificar errores
        if (!$stmt->execute([$this->idTravelOffer, $this->description, $this->numberTravel, $this->status])) {
            trigger_error(E_USER_ERROR." - Error en la ejecucion de la consulta.");
            return "error_insert_data";
        }
    
        // Obtener el ID del weblog recién insertado
        $lastInsertId = $this->conection->lastInsertId();
    
        // Procesar las imágenes desde $_FILES
        if (isset($files['tmp_name']) && is_array($files['tmp_name'])) {
            foreach ($files['tmp_name'] as $key => $tmpName) {
                // Verificar si hay un archivo cargado
                if (!empty($tmpName)) {
                    // Obtener la extensión del archivo
                    $fileExtension = pathinfo($files['name'][$key], PATHINFO_EXTENSION);
                    // Generar un nombre único para la imagen
                    $uniqueName = uniqid('img_', true) . '.' . $fileExtension;
                    // Definir la ruta de la imagen con el nombre único
                    $routeImage = 'asset/bitacora/' . $uniqueName;

                    // Mover el archivo cargado a la ubicación deseada
                    if (move_uploaded_file($tmpName, $routeImage)) {
                        // Insertar la URL de la imagen en la tabla 'image'
                        $sqlImage = "INSERT INTO image (imageUrl) VALUES (?)";
                        $stmtImage = $this->conection->prepare($sqlImage);
                        
                        if (!$stmtImage->execute([$routeImage])) {
                            trigger_error(E_ERROR." - Error al insertar la imagen de la ruta de viaje.");
                            return "error_insert_data";
                        }

                        // Obtener el ID de la última imagen insertada
                        $lastImageId = $this->conection->lastInsertId();

                       // Asociar la imagen al weblog
                        $sqlImageWeblog = "INSERT INTO imageweblog (idImage, idWebLog, status) VALUES (?, ?, ?)";
                        $stmtImageWeblog = $this->conection->prepare($sqlImageWeblog);

                        // Crear un array con los parámetros
                        $params = [$lastImageId, $lastInsertId, "1"];

                        if (!$stmtImageWeblog->execute($params)){
                            trigger_error(E_ERROR." - Error al insertar la imagen de la ruta de viaje.");
                            return "error_insert_data";
                        }

                    } else {
                        trigger_error(E_ERROR." - Error al insertar la imagen de la ruta de viaje.");
                        return "error_insert_data";
                    }
                }
            }
        }else{
            trigger_error(E_ERROR." - Error al insertar la imagen de la ruta de viaje.");
            return "error_insert_data";
        }
        $this->statusTravel($this->idTravelOffer);

        $history = new historysController;
        $history->addRegister($this->table, "El usuario insertó.");
        return "save"; // Indica que todo se guardó correctamente
    }
    // funcion para extraer el id de trip para cambair es status de las ofertas de viaje segun el trip
    public function getIdTrip($id,$status) {
        $this->getConection();
        $sql = "SELECT idTrip FROM traveloffer WHERE status= ? AND id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$status, $id]);
        return $stmt->fetchColumn();
    }

    // funcion para marcar la oferta de viaje como c de completada
    public function statusTravel($id) {
        $this->getConection();
        $idT = $this->getIdTrip($id,'R');
        
        if ($idT !== false) { // Verificar si se encontró el idTrip
            $sql = "UPDATE traveloffer SET status ='C' WHERE idTrip = ? AND status ='R'";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$idT]);
        }else{
            //poner exceptiocn
        } 
    }

    //funcion para cambiar el staus de la oferta de viaje se cambia de al bitacora por otra
    public function statusTravelChange($id) {
        $this->getConection();
        $idT = $this->getIdTrip($id,'C');
        
        if ($idT !== false) { // Verificar si se encontró el idTrip
            $sql = "UPDATE traveloffer SET status ='R' WHERE idTrip = ? AND  status = 'C' ";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$idT]);
            
          
        } else {
             //poner exceptiocn
        }
    }
    
    //funcion para comprobar que no exista otra bitacora igual segun el id de la oferta de viaje
    public function weblogExist($idTravelOffer){
        $this->getConection();
        $sql = "SELECT COUNT(idTravelOffer) FROM ".$this->table." AS w WHERE w.idTravelOffer = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idTravelOffer]);
        return $stmt->fetchColumn() > 0;                
    }

    /* extrae toodos los datos de la bitacora */
  public function getBitacora() {
    $this->getConection();
    
    // Consulta SQL que agrupa los datos repetidos y concatena las URLs de las imágenes
    $sql = "
        SELECT 
        w.idWebLog,                      -- Agrega el idWebLog a la selección
        v.departureDate, 
        w.description, 
        w.numberTravel, 
        v.title AS tripTitle,
        GROUP_CONCAT(DISTINCT i.imageUrl ORDER BY i.imageUrl SEPARATOR ', ') AS imageUrls
    FROM 
        imageweblog AS iw
    INNER JOIN 
        weblog AS w ON iw.idWebLog = w.idWebLog
    INNER JOIN 
        traveloffer AS t ON w.idTraveloffer = t.id
    INNER JOIN 
        trip AS v ON t.idTrip = v.idTrip
    INNER JOIN 
        image AS i ON i.idImage = iw.idImage AND iw.status = 1
    WHERE 
        w.status = ? 
    GROUP BY 
        w.idWebLog,                     -- Asegúrate de agrupar por idWebLog también
        v.departureDate, 
        w.description, 
        w.numberTravel, 
        v.title
    "; // Agrupamos por todos los campos necesarios
    
    $stmt = $this->conection->prepare($sql);
    $stmt->execute(["1"]);

    // Almacenar el resultado en una variable
    $result = $stmt->fetchAll();
    
    // Verificar si el resultado está vacío y devolver 'notWebLog' si es el caso
    return empty($result) ? 'notWebLog' : $result;
}

    
        
            
}        
    
?>