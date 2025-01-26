<?php
// validador de datos
require_once(CONTROLLER_PATH ."/dataValidator.php");

require_once(CONTROLLER_PATH."historys.php");

/* modelo del modulo paquete */
require_once(MODEL_PATH."/db.php");

    class packages{

        /*Atributos de la clase paquetes  */
        public $idPackages;
        public $title;
        public $description;
        public $transport;
        public $food;
        public $lodging;
        public $price;
        public $status;

        /*Atributos para la conexion con BD */
        public $table= 'packages';
        public $conection;

        public function __construct(){
            
        }

        /*conexion con DB */
        public function getConection(){
            $DbObj= new Db;
            $this->conection = $DbObj->conection;
        }
        
        
        /*Extraccion de paquetes de la DB segun su estatus */
        public function getPackagesByStatus($opc) {

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
            return $stmt->fetchAll();
        }

        

        /*Extraccion  de paquetes por ID de la BD */
        public function getPackagesById($id){
            if(is_null($id)) return false;
            $this->getConection();
            $sql = "SELECT * FROM ".$this->table. " WHERE idPackages = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        public function getPackagesBydata($title, $var, $id = null){
            $this->getConection();
            
            if ($var === 'insert') {
                $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE title = ?";
                $params = [$title];
            } else if ($var === 'edit') {
                $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE BINARY title = ? AND idPackages != ?";
                $params = [$title, $id];
            }
        
            $stmt = $this->conection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn() > 0;
        }
        

        /*Insertar nuevos paquetes a  la DB */
        public function insertPackages($param){
            
            //Se comprueba que los datos no esten vacios
            if(validateParams($param['title'],$param['description'],$param['transport'],
                $param['food'],$param['lodging'],$param['price'] )){
                trigger_error(E_USER_ERROR." - El conjunto de datos del paquete de viaje que se intenta insertar no es válido.");
                return "error_insert_data";
            }
            
            $this->getConection();

           
            $this->title = $param['title'];
            $this->description = $param['description'];          
            $this->transport = $param['transport'];
            $this->food = $param['food'];
            $this->lodging = $param['lodging'];
            $this->price = floatval($param['price']);
            $this->status = true ;

            if(!$this->getPackagesBydata($this->title,"insert")){
                $sql = "INSERT INTO ".$this->table. "(`idPackages`, `title`, `description`, `transport`, `food`, `lodging`, `price`, `status`) VALUES(NULL, ? , ? , ? , ? , ? , ? , ? )";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$this->title,$this->description,$this->transport,$this->food,$this->lodging,$this->price,$this->status]);
                $this->conection->lastInsertId();
                $history = new historysController;
                $history->addRegister($this->table, "El usuario insertó.");

                return "save";
            }else{
                return "duplicate";
            }
        }
        /*Edicion de Paquetes de viaje en la DB */
        public function editPackages($param,$id){            
            //Se comprueba que los datos no esten vacios
            if(validateParams($param['title'],$param['description'],$param['transport'],
                $param['food'],$param['lodging'],$param['price'] )){
                trigger_error(E_USER_ERROR." - El conjunto de datos del paquete de viaje que se intenta editar no es válido.");
                return "error_edit_data";
            }
            $this->getConection();
            
            $this->idPackages = $id;
            $this->title = $param['title'];            
            $this->description = $param['description'];            
             $this->transport = $param['transport'];
            $this->food = $param['food'];
             $this->lodging = $param['lodging'];        
            $this->price = str_replace(',', '.', $param['price']);
            $this->price = floatval($this->price);//salida con el la DB se guarden con los numerso flotantes solo con punto;
            
            $aux = $this->getPackagesById($id);
            $band = $this->getPackagesBydata($this->title,"edit",$this->idPackages);// esta parte es para saber si hay un registro igual
            if ($band === FALSE || (isset($aux) && $aux['idPackages'] === $id)) {
                $sql = "UPDATE ".$this->table. " SET title = ? ,description = ? ,transport = ? ,food = ? 
                ,lodging = ? ,price = ? WHERE idPackages = ?";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$this->title, $this->description, $this->transport, $this->food, $this->lodging, $this->price, $this->idPackages   ]);                
                $idPkgToUpdate = $this->idPackages;                
                
                $this->updateTravelOfferAmount($idPkgToUpdate);                
                $history = new historysController;
                $history->addRegister($this->table, "El usuario editó.");                
                return "update";
            }else{
                return "duplicate_edition";
            }
        }
    
        public function statusControl($id,$opc){
            $this->getConection();
            if(isset($id)) $this->idPackages = $id;
            if($this->getPackagesByTravel($this->idPackages) == 0){ 

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
                $sql = "UPDATE ".$this->table. " SET status = ? WHERE idPackages = ?";
                $stmt = $this->conection->prepare($sql);
                $res = $stmt->execute([$this->status, $this->idPackages ]);      
                return $aux; 
            }else{
                return 'disabled_not_allowed';
            }
           
        }

        public function getPackagesByTravel($id){
            $this->getConection();
            $sql = "SELECT COUNT(*) FROM traveloffer WHERE idPackages = ? AND status = 1";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetchColumn();
        }

        public function updateTravelOfferAmount($idPkgToUpdate) {
            $this->getConection();
            
            $sqlSelect = "SELECT idPackages, idTrip FROM travelOffer WHERE idPackages = ?";
            $stmtSelect = $this->conection->prepare($sqlSelect);
            $stmtSelect->execute([$idPkgToUpdate]);
            $results = $stmtSelect->fetchAll();
        
            foreach ($results as $row) {
                $idPkg = $row['idPackages'];
                $idTrp = $row['idTrip'];
                
                // Obtener el precio del paquete
                $sqlPkgPrice = "SELECT price FROM packages WHERE idPackages = ?";
                $stmtPkgPrice = $this->conection->prepare($sqlPkgPrice);
                $stmtPkgPrice->execute([$idPkg]);
                $pkgPrice = $stmtPkgPrice->fetchColumn();
        
                // Obtener el precio del viaje
                $sqlTrpPrice = "SELECT price FROM trip WHERE idTrip = ?";
                $stmtTrpPrice = $this->conection->prepare($sqlTrpPrice);
                $stmtTrpPrice->execute([$idTrp]);
                $trpPrice = $stmtTrpPrice->fetchColumn();
                
                // Calcular el monto total
                $totalAmount = $pkgPrice + $trpPrice;
                
                // Actualizar la tabla travelOffer con el nuevo monto
                $sqlUpdate = "UPDATE travelOffer SET amount = ? WHERE idPackages = ? AND idTrip = ?";
                $stmtUpdate = $this->conection->prepare($sqlUpdate);
                $stmtUpdate->execute([$totalAmount, $idPkg, $idTrp]);
            }
        
            return true;
        }
        

    }

?>