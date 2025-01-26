<?php 
//--------------------------Modelo de las Rutas-----------------------///

// validador de datos
require_once(CONTROLLER_PATH ."/dataValidator.php");

require_once(CONTROLLER_PATH."historys.php");

require_once(MODEL_PATH."/db.php");
        
    class trip{
       /*  se declaran las variables */
        public $idTrip;
        public $idRoute;
        public $idPackages;
        public $title;
        public $departureLocation;
        public $departureDate;
        public $departureTime;
        public $returnDate;
        public $returnTime;
        public $numberSlots;
        public $price;
        public $status;
        /* variable de la base de datos */
        public $table= 'trip';
        public $conection;

        
        public function getConection(){ /* se conecta con la base de datos */
            $DbObj= new Db;
            $this->conection = $DbObj->conection;
        }
         
        public function getTrip($status) {
            $this->getConection();
            $sql = "SELECT v.*, v.title AS titleTrip, 
                     GROUP_CONCAT(t.amount SEPARATOR '<br><br>') AS amount ,
                     GROUP_CONCAT(p.title SEPARATOR '<br><br>') AS titlePackages, 
                     GROUP_CONCAT(t.idPackages SEPARATOR '<br><br>') AS idPackages,
                    q.parroquia AS parroquiaName, r.place, m.municipio, e.estado,
                    COUNT(t.idTrip) AS tripCount
                        FROM traveloffer t
                            INNER JOIN packages p ON t.idPackages = p.idPackages
                        INNER JOIN trip v ON t.idTrip = v.idTrip
                        INNER JOIN route r ON v.idRoute = r.idRoute
                        INNER JOIN parroquia q ON r.idParroquia = q.id_p
                        INNER JOIN municipio m ON q.municipio_id = m.id_m
                        INNER JOIN estado e ON m.estado_id = e.id_e
                        WHERE t.status = :status 
                        GROUP BY v.idTrip ";
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR); // Ajuste a PDO::PARAM_STR
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function addingTrip($param){  /* añadir en BD la ruta de Viaje */
            //Se comprueba que los datos no esten vacios
            
            
            if(validateParams($param['idRoute'],$param['title'],$param['departureLocation'],
            $param['departureDate'],$param['departureTime'],$param['returnDate'],$param['returnTime'],$param['numberSlots'],$param['price'])){
                trigger_error(E_USER_ERROR." - El conjunto de datos de la oferta de viaje que se intenta insertar no es válido.");
                return "error_insert_data";
            }            
            if(!isset($param['idPackages']) || empty($param['idPackages'])){
                trigger_error(E_USER_ERROR." - El ID de los paquetes de viaje asociados a la oferta está indefinido o no tiene valores.");
                return "error_insert_data";
            }
            $this->getConection();
            $this->idRoute = $param['idRoute'];  
            $this->idPackages = $param['idPackages'];   
            $this->title = $param['title'];
            $this->departureLocation = $param['departureLocation'] ;
            $this->departureDate = $param['departureDate'];
            $this->departureTime = $param['departureTime'];
            $this->returnDate = $param['returnDate'];
            $this->returnTime = $param['returnTime'];
            $this->numberSlots = $param['numberSlots'];
            $this->price = $param['price'];
            $this->status = true; 
            
            $band = $this->consulta($param,"adding");//busqueda de parroquia Y lugar esta parte es para saber si ya esta insertada no se reincerte
            if($band==0){
                $sql = "INSERT INTO " . $this->table . 
                " (`idTrip`, `idRoute`, `title`, `departureLocation`, `departureDate`, `departureTime`, `returnDate`, `returnTime`, `numberSlots`, `price`, `vacant`) 
                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$this->idRoute, $this->title, $this->departureLocation, $this->departureDate, $this->departureTime, $this->returnDate, $this->returnTime, $this->numberSlots, $this->price, $this->numberSlots]);
                $lastInsertId = $this->conection->lastInsertId(); 
                $this->addingTravelOffer($this->idPackages, $lastInsertId,$this->price, $this->status); 
                
                $history = new historysController;
                $history->addRegister($this->table, "El usuario insertó.");
                
                return "save";
            }else{
                return "duplicate";
            }
            
        }

        public function addingTravelOffer($param, $lastInsertId, $price, $status){
            if(count($param)>0){                   
                foreach($param as $data){ 
                    $packagePrice = is_numeric($this->getPackagePrice($data)) ? $this->getPackagePrice($data) : 0;
                    $totalPrice = $price + $packagePrice;
                    $sql2 = "INSERT INTO traveloffer (`id`, `idTrip`, `idPackages`, `amount`, `status` ) 
                    VALUES (NULL, ?, ?, ?, ?)"; 
                    $stmt2 = $this->conection->prepare($sql2); 
                    $stmt2->execute([$lastInsertId, $data, $totalPrice, $status]);
                }
            }
        }
        public function getPackagePrice($idPackages) {
            $this->getConection();
            $sql = "SELECT price FROM packages WHERE idPackages = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$idPackages]);
            return $stmt->fetchColumn();
        }
        /* AUN NO LA USO */
        public function consulta($param, $var, $id = null) {            
            $this->getConection();            
            if(isset($param['idRoute'])) $this->idRoute = $param['idRoute'];              
            if(isset($param['title']))  $this->title = $param['title'];            
            if(isset($param['departureLocation'])) $this->departureLocation = $param['departureLocation'];            
            if(isset($param['departureDate'])) $this->departureDate = $param['departureDate'];            
            if(isset($param['returnDate'])) $this->returnDate = $param['returnDate'];
        
            $sqlCheck = "SELECT COUNT(*) FROM " . $this->table . " WHERE ";
        
            if ($var === 'AboutWriting') {
                $sqlCheck .= "BINARY idRoute = ? AND BINARY title = ? AND BINARY departureLocation = ? AND BINARY departureDate = ? AND BINARY returnDate = ? ";
            } else {
                $sqlCheck .= "idRoute = ? AND title = ? AND departureLocation = ? AND departureDate = ? AND returnDate = ? ";
            }
                        
            if ($id !== null) {                
                $sqlCheck .= " AND idTrip != ?";            
            }                    
            $stmtCheck = $this->conection->prepare($sqlCheck);            
        
            if ($id !== null) {                
                $stmtCheck->execute([$this->idRoute, $this->title, $this->departureLocation, $this->departureDate, $this->returnDate, $id]);            
            } else {                
                $stmtCheck->execute([$this->idRoute, $this->title, $this->departureLocation, $this->departureDate, $this->returnDate]);            
            }            
        
            return $stmtCheck->fetchColumn();        
        }        

        /* sorbreescribir */
        public function AboutWritingTrip($param, $id){  /* añadir en BD la ruta de Viaje */                    
             //Se comprueba que los datos no esten vacios
              if(validateParams($param['idRoute'],$param['title'],$param['departureLocation'],
             $param['departureDate'],$param['departureTime'],$param['returnTime'],$param['numberSlots'],$param['price'])){
                 trigger_error(E_USER_ERROR." - El conjunto de datos de la oferta de viaje que se intenta editar no es válido.");
                 return "error_edit_data";
             }             
              if(!isset($param['idPackages']) || empty($param['idPackages'])){
                trigger_error(E_USER_ERROR." - El ID de los paquetes de viaje asociados a la oferta está indefinido o no tiene valores.");
                return "error_edit_data";
            }  
         
            $this->getConection();
            $this->idTrip = $id;  
            $this->idRoute = $param['idRoute'];  
            $this->idPackages = $param['idPackages'];  
            $this->title =$param['title'];
            $this->departureLocation = $param['departureLocation'] ;
            $this->departureDate = $param['departureDate'];
            $this->departureTime = $param['departureTime'];
            (isset($param['returnDate'])) ?$this->returnDate = $param['returnDate']: $this->returnDate = $param['returnDateedit'];
            $this->returnTime = $param['returnTime']; 
             
            $this->numberSlots = $param['numberSlots'];
            if($param ['cuposantes'] == $this->numberSlots  )  {
                $vacant = $param ['vacant'];
            } else{ 
                $vacant = ( (($this->numberSlots)-($param ['cuposantes'])) + $param ['vacant']);
            }
           
            $param ['vacant']; $param ['cuposantes']; 
            
            if(isset($param['price']))  $this->price = $param['price'];
            $this->status = true; 
           
            $band = $this->consulta($param, "AboutWriting", $this->idTrip);//busqueda de parroquia Y lugar esta parte es para saber si ya esta insertada no se reincerte
            if($band == 0){
                $sql = "UPDATE " . $this->table . 
                " SET  idRoute = ?, title = ?,  departureLocation = ?, departureDate = ?, departureTime = ?,
                 returnDate = ?, returnTime = ?, numberSlots = ?, price = ? , vacant =?
                WHERE idTrip = ?";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$this->idRoute, $this->title, $this->departureLocation, $this->departureDate, 
                    $this->departureTime, $this->returnDate, $this->returnTime, $this->numberSlots, $this->price, 
                    $vacant, $this->idTrip
                ]);
                $this->resetPackages($this->idTrip);
                $this->AboutWritingTravelOffer($this->idPackages, $this->price, $this->idTrip); 

                $history = new historysController;
                $history->addRegister($this->table, "El usuario editó.");

                return "update" ;

            }else{
                return "duplicate_edition";
            }
        }

        public function AboutWritingTravelOffer($Packages, $price, $idTrip){
            if(count($Packages)>0){                   
                foreach($Packages as $data){ 
                    $packagePrice = $this->getPackagePrice($data);
                    $totalPrice = $price + $packagePrice;
                    $exists = $this->checkPackages($data, $idTrip);
                    if ($exists) {
                        // Actualizar el paquete existente
                        $sqlUpdate = "UPDATE traveloffer SET amount = ?, status = ? WHERE idTrip = ? AND idPackages = ? ";
                        $stmtUpdate = $this->conection->prepare($sqlUpdate);
                        $stmtUpdate->execute([$totalPrice, 1, $idTrip, $data]);
                    } else {
                        // Insertar un nuevo paquete
                        $sqlInsert = "INSERT INTO traveloffer (idTrip, idPackages, amount, status) VALUES (?, ?, ?, ?)";
                        $stmtInsert = $this->conection->prepare($sqlInsert);
                        $stmtInsert->execute([$idTrip, $data, $totalPrice, 1]);
                    }
                }
            }
        }
        public function resetPackages($id){ // resetea los estatus de los paquetes
            $sql = "UPDATE traveloffer SET  status = ? WHERE idTrip = ? AND status = 1";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute(['D', $id ]);
        }

        public function checkPackages($Packages, $trip){// Verificar si el paquete ya existe
            $sqlCheck = "SELECT COUNT(*) FROM traveloffer WHERE idTrip = ? AND idPackages = ? AND status = ?";
            $stmtCheck = $this->conection->prepare($sqlCheck);
            $stmtCheck->execute([ $trip,$Packages,'D']);
            return $stmtCheck->fetchColumn();
        }

        public function getTripById($id) {
            $this->getConection();
            $sql = "SELECT v.*,r.*, q.parroquia , m.municipio, e.estado
                    FROM trip v
                    INNER JOIN route r ON v.idRoute = r.idRoute
                    INNER JOIN parroquia q ON r.idParroquia = q.id_p
                    INNER JOIN municipio m ON q.municipio_id = m.id_m
                    INNER JOIN estado e ON m.estado_id = e.id_e
                    WHERE v.idTrip = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

       
        public function getTripByIdForDetails($id, $status = '1') {
            $this->getConection();
            $sql = "SELECT v.*, r.place, v.title AS titleTrip, 
                        GROUP_CONCAT(p.title SEPARATOR '|') AS titlePackages, 
                        GROUP_CONCAT(p.price SEPARATOR '|') AS amount,                     
                        COUNT(t.idTrip) AS tripCount
                    FROM traveloffer t
                        INNER JOIN packages p ON t.idPackages = p.idPackages
                        INNER JOIN trip v ON t.idTrip = v.idTrip
                        INNER JOIN route r ON v.idRoute = r.idRoute
                        INNER JOIN parroquia q ON r.idParroquia = q.id_p
                        INNER JOIN municipio m ON q.municipio_id = m.id_m
                        INNER JOIN estado e ON m.estado_id = e.id_e
                    WHERE v.idTrip = :id AND t.status = :status
                    GROUP BY v.idTrip";
        
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
        
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Si no se encuentra ningún resultado con status '1', buscar con status 'R'
            if (!$result && $status == '1') {
                $status = 'R';
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if (!$result && $status === 'R') {
                $status = '0';
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        
            return $result;

        }
        
        
        public function statusTrip($id, $opc) {
            $this->getConection();
            /* LOS ESTATUS DE ESTE MODULO SON ------------ 1 PARA HABILITADOS
            ----------- 0 PARA INHABILITADOS ------------- R PARA REALIZADOS 
            ----------- D PARA DESCARTADOS -------------- C PARA COMPLETADOS */
            $this->status = $opc === 'H' ? 1 : 0;
            $sql = "UPDATE traveloffer SET status = ? WHERE idTrip = ? AND status = ?";
            $newStatus = $this->status;
            $currentStatus = $this->status === 1 ? 0 : 1;
        
            $stmt = $this->conection->prepare($sql);
            $res = $stmt->execute([$newStatus, $id, $currentStatus]);
        
            $history = new historysController;


            
            
            
            

            if($newStatus == 1){

                $history->addRegister($this->table, "El usuario Reanudó el viaje."); 
                return 'trip_restart';
            }else{
                
                $history->addRegister($this->table, "El usuario canceló el viaje.");
                return 'trip_cancel';
            }


            
        }
        
         

    }


?>