<?php 
//--------------------------Modelo de las Rutas-----------------------///
// validador de datos
require_once(CONTROLLER_PATH ."/dataValidator.php");    
/*  modelo del modulo paquete*/
require_once(MODEL_PATH."/db.php");
        
    class reservation{
       /*  se declaran las variables */
        public $idReservation;
        public $idTravelOffer;
        public $idTrip;
        public $idPackages;
        public $idUser;      
        public $numberSlots;
        public $numberMiner;
        public $minorNotMoney;
        public $numberMoney;
        public $amountTotal;
        public $amount;
        public $reservationDate;
        public $confirmation;
        public $status;

        /* variable de la base de datos */
        public $table= 'reservation';
        public $conection;


        public function getConection(){ /* se conecta con la base de datos */
            $DbObj= new Db;
            $this->conection = $DbObj->conection;
        }

        /* pregunnta la cantidade de solicitudes de reservscion SIN POROCESAR */
        public function pedientRequestsReservation(){
            $this->getConection();
            $sql="SELECT COUNT(r.confirmation) FROM reservation AS r WHERE r.confirmation = 'E' ";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }

        /* funcion para añadir y procesar toda la solicitud de recervacion */ 
        /* sirve para que se liste los packetes correspondientes al viaje en el add de reservacion */
        public function getPackagesByTrip($idTrip) {
            $this->getConection();
            $sql = "SELECT  p.*, t.amount
                    FROM traveloffer t
                    INNER JOIN packages p ON t.idPackages = p.idPackages
                    WHERE t.idTrip = :idTrip AND p.status=1 AND t.status=1";
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        /*  sirve pata que se sepa la cantidad de vacantes y no se puedan hacer solicitudes o resservaciones de mas */
        public function getVacantTrip($idTrip) {
            $this->getConection();
            $sql = "SELECT t.vacant, t.numberSlots , t.departureDate, r.place  
                    FROM trip AS t  
                INNER JOIN route AS r ON t.idRoute = r.idRoute 
                WHERE t.idTrip = :idTrip";
                   
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }   
        


        
       /* inicializar variables */
       public function initializeReservationParams($param){        
        if(isset($param['idUser'])) $this->idUser = $param['idUser']; 
            if(isset($param['idTrip'])) $this->idTrip = $param['idTrip']; 
            if(isset($param['idPackages'])) $this->idPackages = $param['idPackages'];      
            if(isset($param['numTurista'])) $this->numberSlots = $param['numTurista']; 
            if(isset($param['numChildren'])) $this->numberMiner = $param['numChildren']; 
            if(isset($param['minorMoney'])) $this->minorNotMoney = $param['minorMoney'];  
            if(isset($param['currentDate'])) $this->reservationDate = $param['currentDate']; 
            $travelOffer =  $this->valuePackages( $this->idTrip , $this->idPackages);
            $this->idTravelOffer  = $travelOffer['idTravelOffer'];
            $this->amount= $travelOffer['amountsTravel'];
            $this->amountTotal = ( ($this->numberSlots - $this->minorNotMoney) * ($this->amount) );
            if (isset($_SESSION['user']) && $_SESSION['privilege'] === 'turista') {
                $this->confirmation = "E";
            }else if(isset($_SESSION['user']) && ($_SESSION['privilege'] === 'publicista' || $_SESSION['privilege'] === 'admin' )) {
                $this->confirmation = "A";
            }
        }
        public function addingReservation($param,$idPerson,$sessionData){ 
            
            $this->initializeReservationParams($param);/* llamado de valores de reservacion */
            $param['name0'] = $sessionData['name'];
            $param['lastName0'] = $sessionData['lastName'];
          
            $this->idReservation = $this->insertReservation();/* inserto los datos de la reservacion y extraigo el id */
            $idPersonUser = $idPerson;//idPerson del usuario

            if( ($param['includeUser']==="SI") && ($this->numberSlots == 1) ){
                $this->inserTourist($idPersonUser , $this->idReservation);

            }else if(($this->numberSlots >= 1)){

                if($param['includeUser'] === "NO" && $param['includeMinor'] !== "SI"   ){
                    $this->insertPerson($param, $this->numberSlots ,$this->idReservation);
                } else if($param['includeUser'] === "SI"){
                    $this->inserTourist($idPersonUser,$this->idReservation);
                    if($param['includeMinor'] === "NO"){
                        //funcion para añadir personas
                        $total =  $this->numberSlots-1;
                        $this->insertPerson($param,$total,$this->idReservation);
                    }else if($param['includeMinor'] === "SI"){
                        /* condicion para saber si ademas de niños y usuarios van adultos */
                        if( $this->numberSlots - $this->numberMiner - 1 != 0 ){
                            //añadir personas
                            $total =  $this->numberSlots - $this->numberMiner - 1;
                            $this->insertPerson($param,$total,$this->idReservation);
                        } //funcion para añadir niños
                        $total =  $this->numberSlots - $this->numberMiner ;
                        $this->insertMinor($param, $this->idReservation, $this->numberMiner, $total);
                    }                        
                }else if($param['includeUser'] === "NO" && $param['includeMinor'] === "SI"){
                    //añadir personas 
                    $total =  $this->numberSlots - $this->numberMiner;
                    $this->insertPerson($param,$total,$this->idReservation);
                    //anadir niños
                    $this->insertMinor($param, $this->idReservation, $this->numberMiner, $total+1);
                } 

            }    
            if ($_SESSION['privilege'] == 'turista') {
                return  "add_requests_tourits";
            }
            if ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'publicista') {
                return  "add_requests_reservation";
            }
            
        }
        /* funciones complementarias para addingReservation($param)  */
        public function valuePackages($idTrip, $idPackages) { //extrae el idTravelOffer y amount
            $this->getConection();
            $sql = "SELECT t.amount AS amountsTravel, t.id AS idTravelOffer
                    FROM traveloffer t
                    WHERE t.idTrip = :idTrip AND t.idPackages = :idPackages";
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':idTrip', $idTrip, PDO::PARAM_INT);
            $stmt->bindParam(':idPackages', $idPackages, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /* que se inserte los datos de la reservacion */
        public function insertReservation() {
 
                $this->getConection();            
                // Consulta SQL para insertar los datos en la tabla reservation
                $sql = "INSERT INTO $this->table (idReservation, idUser, idTravelOffer, numberSlots, reservationDate, amount, confirmation)
                        VALUES (NULL, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$this->idUser, $this->idTravelOffer, $this->numberSlots, $this->reservationDate, $this->amountTotal, $this->confirmation]);
               return $this->conection->lastInsertId(); // Obtener el idReservation recién insertado
           
        }
        /* sirve para insertar con turista */
        public function inserTourist($idPersonUser,$idReservation){
                $this->getConection();            
                // Consulta SQL para insertar los datos en la tabla reservation
                $sql = "INSERT INTO tourist (idTourist, idPerson, idReservation, status)
                        VALUES (NULL, ?, ?, ?)";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$idPersonUser, $idReservation,'1']);
        }
        /* función para insertar niños */
        public function insertMinor($data, $idReservation, $numMinor,$total) {
            for ($i = 0; $i < $numMinor; $i++) {
                $age = $data['ageMinor' . $i];
                $sex = $data['sexMinor' . $i];
                $responsibleMinor = $data['responsibleMinor' . $i];        
                // Consulta SQL para insertar los datos en la tabla underage
                $idResponsible = $this->getIdPerson($responsibleMinor , $data ,$total);
               $this->getConection();
                $sql = "INSERT INTO underage (idMinor, age, sex, responsible, idReservation,status)
                        VALUES (NULL, ?, ?, ?, ?,?)";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$age, $sex, $idResponsible, $idReservation,'1']); 
            }
        }

       /* buscar id de persona por cédula, nombre y apellido */
        public function getIdPerson($ci, $data, $total) {
            $this->getConection(); 
        
            for ($i = 0; $i < $total; $i++) {
                $name = $data['name' . $i];
                $lastName = $data['lastName' . $i];   
                $sql = "SELECT idPerson FROM person WHERE ci = :ci AND name = :name AND lastName = :lastName";
                $stmt = $this->conection->prepare($sql);
                $stmt->bindParam(':ci', $ci, PDO::PARAM_STR);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
                $stmt->execute();
                
                $idPerson = $stmt->fetchColumn();
                
                if ($idPerson) {
                    return $idPerson; // Retorna el idPerson encontrado
                }
            }
        
            return null; // Retorna null si no se encontró ningún idPerson que coincida
        }

        /* insertar Personas y viajes */
        public function insertPerson($data, $total, $idReservation) {
            for ($i = 1; $i <= $total; $i++) {
                $ci = $data['ci' . $i];

                $name = $data['name' . $i];
                $lastName = $data['lastName' . $i];
                $birthDate = $data['birthDate' . $i];  
                $phone = (strlen($data['phone' . $i]) == 11) ? $data['phone' . $i] : "POR ASIGNAR";
                $idParroquia = $data['parroquia' . $i];
                $address = $data['address' . $i]; 
                    $this->getConection();
                    $idPerson = $this->findOrInsertPerson($ci, $name, $lastName, $birthDate, $phone, $idParroquia, $address);

                /* insertar la solicitud reservacion de acompañante por acompañante */
                $this->inserTourist($idPerson, $idReservation);
            }
        }
        /* verifica si la persona ya esta registrada y extrae el id o la añade  */
        public function findOrInsertPerson($ci, $name, $lastName, $birthDate, $phone, $idParroquia, $address) {
            $this->getConection();
        
            // Buscar si ya existe la persona
            $sqlCheck = "SELECT idPerson FROM person WHERE REPLACE(ci, 'á', 'a') = REPLACE(:ci, 'á', 'a')
                         AND REPLACE(name, 'á', 'a') = REPLACE(:name, 'á', 'a')
                         AND REPLACE(lastName, 'á', 'a') = REPLACE(:lastName, 'á', 'a')";
            $stmtCheck = $this->conection->prepare($sqlCheck);
            $stmtCheck->bindParam(':ci', $ci, PDO::PARAM_STR);
            $stmtCheck->bindParam(':name', $name, PDO::PARAM_STR);
            $stmtCheck->bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
            if ($result) {
                // Si existe, retornar el idPerson
                return $result['idPerson'];
            } else {
                // Si no existe, insertar la persona
                $sqlInsert = "INSERT INTO person (idPerson, ci, name, lastName, birthDate, phone, idParroquia, address)
                              VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
                $stmtInsert = $this->conection->prepare($sqlInsert);
                $stmtInsert->execute([$ci, $name, $lastName, $birthDate, $phone, $idParroquia, $address]);
                // Retornar el idPerson recién insertado
                return $this->conection->lastInsertId();
            }
        }
        public function listOptionTrip() {
            $this->getConection();
            
            // Obtener la fecha actual en el formato adecuado
            $currentDate = date('Y-m-d H:i:s');
            
            // Consulta base con las condiciones
            $sql = "SELECT v.title, v.idTrip
                    FROM trip v
                    INNER JOIN traveloffer AS t ON t.idTrip = v.idTrip
                    WHERE v.departureDate > :currentDate
                    AND v.vacant > 0 AND t.status='1'";
            
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR); // Enlazar el parámetro de fecha actual
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener resultados
            return $results;
        }
        

       
        public function listRequestsCase($case, $user) {
            $this->getConection();
            $idUser = $user['idUser'];
        
            // Consulta base
            $sql = "SELECT v.title, v.departureDate, v.vacant, v.idTrip,
                           p.name, p.lastName, p.phone, u.email,
                           r.idReservation, r.numberSlots, r.amount, r.reservationDate
                    FROM reservation AS r
                    INNER JOIN traveloffer AS f ON f.id = r.idTravelOffer
                    INNER JOIN trip AS v ON v.idTrip = f.idTrip
                    INNER JOIN user AS u ON u.idUser = r.idUser 
                    INNER JOIN person AS p ON u.idPerson = p.idPerson 
                    WHERE r.confirmation = :case 
                    AND v.departureDate >= CURDATE()  ";
            
            // Filtrar por usuario si es turista
            if($user['privilege'] === 'turista') {
                $sql .= ' AND r.idUser = :idUser
                ORDER BY r.reservationDate ASC'; 
            }else{
                $sql .= 'ORDER BY r.reservationDate ASC'; 

            }
        
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':case', $case, PDO::PARAM_STR); // Vincular el parámetro como STRING
            if($user['privilege'] === 'turista') {
                $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT); // Vincular el parámetro de idUsuario si aplica
            }
            $stmt->execute();
        
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener resultados
            return $results;
        }
        
        public function listRequestsTourist($case,$user) {

            $this->getConection();
            // Consulta base
            $sql = "SELECT v.title, v.departureDate, v.vacant, v.idTrip,
                        p.name, p.lastName, p.phone, u.email,
                        r.idReservation, r.numberSlots, r.amount , r.reservationDate
                    FROM reservation AS r
                    INNER JOIN traveloffer AS f ON f.id = r.idTravelOffer
                    INNER JOIN trip AS v ON v.idTrip = f.idTrip
                    INNER JOIN user AS u ON u.idUser = r.idUser 
                    INNER JOIN person AS p ON u.idPerson = p.idPerson 
                    WHERE r.confirmation = :case AND v.departureDate >= CURDATE() AND r.idUser= $user
                    ORDER BY r.reservationDate ASC"; // Ordenar por reservationDate de más antiguo a más reciente
        
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':case', $case, PDO::PARAM_STR); // Vincular el parámetro como STRING
            $stmt->execute();
        
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener resultados
            return $results;
        }
        

        public function statusRequests($id, $status, $cant, $idTrip) {
            $this->getConection();
            $this->idReservation = $id; 
            $this->confirmation = $status;
            $band="fine";
            if($this->confirmation ==="B"){ $sms ="borrRequests";}
            if($this->confirmation ==="D"){ $sms ="deniedRequests";}
            if($this->confirmation ==="E"){ $sms ="reconcedeRequests";}

            if($this->confirmation === "A") { 
                $sms ="acceptRequests";
                $band = $this->udpateVacantMenos($cant, $idTrip);
            }
            if($this->confirmation === "C"){
                 $sms ="cancelRequests";
                 $band = $this->udpateVacantMas($cant, $idTrip);
            }
        
            if($band!= 'exceedsVacant'){
                $sql = "UPDATE " . $this->table . " SET confirmation = ? WHERE idReservation = ?";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$this->confirmation, $this->idReservation]);
                return $sms;
            }else{
               return "exceedsVacant";
            }
        }
        
        public function udpateVacantMenos($cant, $idTrip) {
            $vacant = $this->getVacantTrip($idTrip);

            $currentVacant = $vacant['vacant'];
            $newVacant = $currentVacant - $cant;
            
            if($newVacant < 0) { return "exceedsVacant";}
        
            $sql = "UPDATE trip SET vacant = ? WHERE idTrip = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$newVacant, $idTrip]);
        
            return "updatedVacant";
        }

        public function udpateVacantMas($cant, $idTrip) {
            $vacant = $this->getVacantTrip($idTrip);
            $numberSlots = $vacant['numberSlots'];
            $newVacant =  $vacant['vacant'];
            $comprobar = $newVacant + $cant;
            
            if( $comprobar >  $numberSlots) { return "exceedsVacant";}
        
            $sql = "UPDATE trip SET vacant = ? WHERE idTrip = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$comprobar, $idTrip]);
        
            return "updatedVacant";
        }

        /* sirve para ver el detalles */
        public function getRequestsReservationById($id){
            if (is_null($id)) return false;
            $this->getConection();
            
            $sql = "SELECT
                        p.name, p.lastName, p.phone, 
                        k.title AS title_travel, k.price AS price_travel, k.idPackages,
                        u.email,    t.amount AS price_person,
                        v.title AS title_trip, v.idTrip AS trip, v.departureDate, v.price AS price_trip,
                        r.reservationDate, r.numberSlots, r.amount
                    FROM reservation AS r
                    INNER JOIN user AS u ON r.idUser = u.idUser
                    INNER JOIN person AS p ON p.idPerson = u.idPerson
                    INNER JOIN traveloffer AS t ON t.id = r.idTravelOffer
                    INNER JOIN packages AS K ON t.idPackages = k.idPackages
                    INNER JOIN trip AS v ON v.idTrip = t.idTrip
                    WHERE r.idReservation = ?";
            
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            $aux = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $sql = "SELECT COUNT(t.idTourist) AS cantTourit
                    FROM tourist AS t
                    INNER JOIN reservation AS r ON t.idReservation = r.idReservation
                    WHERE r.idReservation = ? and t.status=?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id,'1']);
            $aux['cantTourist'] = $stmt->fetchColumn();

            $sql = "SELECT COUNT(u.idMinor) AS cantMinor
            FROM underage AS u
            INNER JOIN reservation AS r ON u.idReservation = r.idReservation
            WHERE r.idReservation = ? AND u.status=?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id,'1']);
            $aux['cantMinor'] = $stmt->fetchColumn();
            $aux['cantMinor']?  $aux['cantMinor']: $aux['cantMinor']='0';


            $sql= "SELECT p.name, p.lastName,p.ci,p.phone,p.address, p.birthDate,
                            m.id_m, 
                            e.id_e,
                            q.id_p,
                            m.municipio,
                            e.estado,
                            q.parroquia
                    FROM tourist AS t
                    INNER JOIN reservation AS r ON t.idReservation = r.idReservation
                    INNER JOIN person AS p ON t.idPerson = p.idPerson
                    INNER JOIN parroquia AS  q ON p.idParroquia = q.id_p
                    INNER JOIN municipio AS m ON q.municipio_id = m.id_m
                    INNER JOIN estado AS e ON m.estado_id = e.id_e 
                    WHERE r.idReservation=? AND t.status='1'
                    ";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            $aux['tourist'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql = "SELECT u.age, u.sex, p.name, p.lastName, p.ci
                FROM underage AS u
                INNER JOIN person AS p ON u.responsible = p.idPerson
                INNER JOIN reservation AS r ON u.idReservation = r.idReservation
                WHERE r.idReservation = ? AND u.status='1'
                ORDER BY u.age ASC
                ";
    
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$id]);
            $aux['minior'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $aux;
        }

        public function getUserReservation($idR, $idUser, $idPerson) {
            $this->getConection();
        
            $sql = "SELECT COUNT(t.idPerson) AS user 
                    FROM tourist AS t 
                    INNER JOIN reservation AS r 
                        ON r.idReservation = t.idReservation
                    INNER JOIN person AS p
                        ON p.idPerson = t.idPerson    
                    INNER JOIN user AS u
                         ON u.idPerson = p.idPerson    
                    WHERE t.idReservation = :idR AND t.idPerson = :idPerson AND r.idUser = :idUser AND t.status = '1' ";
        
            $stmt = $this->conection->prepare($sql);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmt->bindParam(':idPerson', $idPerson, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $result['user'];
        
            return $count == 1 ? 'SI' : 'NO';
        }





         /* FUNCION PARA EDITAR LAS RESERVACION */
         public function editReservation($param, $idPerson, $sessionData) {   
            $this->idReservation = $param['idReservation'];// asignacion para usar el idReservation con su proio atrinuto de la clase         
            //$total = 0; //variable para controlar el numero de cupos 
            $param['name0'] = $sessionData['name'] ;
            $param['lastName0'] = $sessionData['lastName'];


            // Inicializa los parámetros de la reservación
            $this->initializeReservationParams($param);            

            // en esa funcion se hace la modificacion a la solicitud de reservación
            if($this->updateReservation($this->idReservation)){
                
                $this->updateTouristStatusToEdit($this->idReservation);// actualizacion de los estados del turista
                $idPersonUser = $idPerson;//idPerson del usuario

                // deshabilitan el status de los niños segun el id de la reservacion 
                // si no hay niños en la reservacion simplemente no hara cambios en la BD
                $this->updateUnderageStatusToEdit($this->idReservation);
                

                if( ($param['includeUser']==="SI") && ($this->numberSlots == 1) ){
                    // si el usuario va incluido en el viaje el status cambia a 1 para que valla al viaje 
                    if(!$this->updateTouristStatusById($idPersonUser, $this->idReservation)){
                    // si no esta incluido en el viaje de se incluye aca
                        $this->inserTourist($idPersonUser , $this->idReservation);
                    }
                    
    
                }else if(($this->numberSlots >= 1)){
                    //caso para cuando no van mnenores y el usuario 
                    if($param['includeUser'] === "NO" && $param['includeMinor'] !== "SI"   ){
                        // agragcion de personas si no van los niños y no va el usuario
                        $this->comprovationTouristTravel($param, $this->numberSlots, $this->idReservation);
                        
                    } else if($param['includeUser'] === "SI"){                           
                            
                        // si el usuario va incluido en el viaje el status cambia a 1 para que valla al viaje 
                        if(!$this->updateTouristStatusById($idPersonUser, $this->idReservation)){
                        // si no esta incluido en el viaje de se incluye aca
                            $this->inserTourist($idPersonUser , $this->idReservation);
                        }
                        // caso de que no vallan los niños
                        if($param['includeMinor'] === "NO"){   
                            $total =  $this->numberSlots-1;                                
                            $this->comprovationTouristTravel($param,$total,$this->idReservation);

                        }else if($param['includeMinor'] === "SI"){

                            /* condicion para saber si ademas de niños y usuarios van adultos */
                        if( $this->numberSlots - $this->numberMiner - 1 != 0 ){
                         

                            $total =  $this->numberSlots - $this->numberMiner - 1;// se actualiza el número de cupos
                            $this->comprovationTouristTravel($param,$total,$this->idReservation);// se llama la funcion con esa cantidad
                                                                
                        } 
                            
                            $total =  $this->numberSlots - $this->numberMiner ;
                            
                            //se insertan nuevmanete los datos de los niños en la tabla underage
                            $this->insertMinor($param, $this->idReservation, $this->numberMiner, $total);

                        }  

                    }else if($param['includeUser'] === "NO" && $param['includeMinor'] === "SI"){
                  
                        //se calcula el total de personas
                        $total =  $this->numberSlots - $this->numberMiner;
                                                
                        //compureba las personas para añadirlas a la reservacion
                        $this->comprovationTouristTravel($param,$total , $this->idReservation);
                       
                        //se añade los niños a la tabla underage
                        $this->insertMinor($param, $this->idReservation, $this->numberMiner, $total+1);
                    } 

    
                }
                
                
                if ($_SESSION['privilege'] == 'turista') {
                    return  "edit_requests_tourits";
                }
                if ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'publicista') {
                    return  "edit_requests_reservation";
                }

            }else{
                
                //colocar manejo de errores 

            }


        }


       
        //funcion para comprobar que las personas estan en el viaje y si no estan se insertarn
        public function comprovationTouristTravel($data, $total, $idReservation) {            
            for ($i = 1; $i <= $total; $i++){            
                $idPerson = "";
        
                $ci = $data['ci' . $i];
                $name = $data['name' . $i];
                $lastName = $data['lastName' . $i];
                $birthDate = $data['birthDate' . $i];  
                $phone = (strlen($data['phone' . $i]) == 11) ? $data['phone' . $i] : "POR ASIGNAR";
                $idParroquia = $data['parroquia' . $i];
                $address = $data['address' . $i]; 
        
                $aux = $this->getIdPersonForEdit($ci, $name, $lastName);// para indicar si la persona esta insertada
        
                if($aux === false){// la la persona no lo esta entonces se inserta en la BD
                    //se extrae el id de la persona para la insertarla en el viaje luego de insertar a la persona
                    $idPerson = $this->findOrInsertPerson($ci, $name, $lastName, $birthDate, $phone, $idParroquia, $address);
                    // si no esta incluido en el viaje de se incluye aca
                    $this->inserTourist($idPerson, $idReservation);
                } else {// la la persona ya esta inserta se capta su id para ponerlo en la lista de turistas
                   
                    $idPerson = $aux;
                    //en la funcion si la persona ya estaba en el viaje se cambia el status a 1 y se retorna true si no retorna false
                    $aux2 = $this->updateTouristStatusById($idPerson, $idReservation);// sirve para indicar si un usuario esta en la lista de los turistas
                    if ($aux2 === false) {
                        // si no esta incluido en el viaje de se incluye aca
                        $this->inserTourist($idPerson, $idReservation);
                    }
                }
            }
        }



        /* buscar id de persona por cédula, nombre y apellido */
        public function getIdPersonForEdit($ci, $name, $lastName) {
        $this->getConection(); 
    
        
        $sql = "SELECT idPerson FROM person WHERE ci = :ci AND name = :name AND lastName = :lastName";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':ci', $ci, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->execute();
        
        $idPerson = $stmt->fetchColumn();
        
        if ($idPerson){
            return $idPerson; // Retorna el idPerson encontrado
        }

            return false; // Retorna false si no se encontró ningún idPerson que coincida
        }




        // cambia el status de la persona a 1 para que valla incluida en el viaje
            public function updateTouristStatusById($idPerson, $idReservation) {
            $this->getConection();            
            
            // Consulta SQL para verificar si existe el registro según idPerson y idReservation
            $sqlCheck = "SELECT COUNT(*) FROM tourist WHERE idPerson = ? AND idReservation = ?";
            $stmtCheck = $this->conection->prepare($sqlCheck);
            $stmtCheck->execute([$idPerson, $idReservation]);
            $exists = $stmtCheck->fetchColumn();
            
            if ($exists) {                
                $sqlTourist = "UPDATE tourist 
                               SET status = '1'
                               WHERE idPerson = ? AND idReservation = ?";
                
                $stmtTourist = $this->conection->prepare($sqlTourist);
                $resultTourist = $stmtTourist->execute([$idPerson, $idReservation]);
                
                return $resultTourist; // Retorna verdadero si se ejecuta correctamente
            } else {
                return false; // Retorna falso si no se encontró ningún registro que coincida
            }
        }
        

        //funcion para cambiar el status de los turistas de la reservacion a D (descartado) momentaneamente
        public function updateTouristStatusToEdit($idReservation) {


            $this->getConection();
            // Consulta SQL para actualizar el estado a 'D' en la tabla tourist según idReservation
            $sqlTourist = "UPDATE tourist
                           SET status = 'D'
                           WHERE idReservation = ?";            
            $stmtTourist = $this->conection->prepare($sqlTourist);
            $stmtTourist->execute([$idReservation]);                
        }
        
        //funcion para modificar el status del los niños que van en el viaje a 'D' momentaneamente
        public function updateUnderageStatusToEdit($idReservation) {
            $this->getConection();            
            // Consulta SQL para actualizar el estado a 'D' en la tabla underage según idReservation
            $sqlUnderage = "UPDATE underage 
                            SET status = 'D'
                            WHERE idReservation = ?";
            
            $stmtUnderage = $this->conection->prepare($sqlUnderage);
            $stmtUnderage->execute([$idReservation]);                
        }
        
        
        // funcion para sobre escribir los datos de la reservación
        public function updateReservation($id) {
            $this->getConection();

            
            

            $idTravelOffer = $this->valuePackages($this->idTrip ,$this->idPackages);
            // Consulta SQL para actualizar los datos en la tabla reservation
            $sql = "UPDATE $this->table 
                    SET  idTravelOffer = ? , numberSlots = ?, amount   = ?
                    WHERE idReservation = ?";
            
            $stmt = $this->conection->prepare($sql);
            $result = $stmt->execute([
                $idTravelOffer['idTravelOffer'],
                $this->numberSlots,
                $this->amountTotal,

                $id 
            ]);//id es el id de la reservacion
        
            return $result; // Retorna verdadero si se ejecuta correctamente, falso en caso contrario
        }

        public function getUserReservationToEditDelete($idPerson) {
            $this->getConection();
            
            $sql = "SELECT p.*
                    FROM person AS p   
                    WHERE  p.idPerson = :idPerson ";

            $stmt = $this->conection->prepare($sql);                
            $stmt->bindParam(':idPerson', $idPerson, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;

        }


        public function removeMatchedPerson(&$dataArray, $person) {
            foreach ($dataArray['tourist'] as $key => $tourist) {
                if (
                    $tourist['ci'] === $person['ci'] &&
                    $tourist['name'] === $person['name'] &&
                    $tourist['lastName'] === $person['lastName'] &&
                    $tourist['birthDate'] === $person['birthDate'] &&
                    $tourist['phone'] === $person['phone'] &&
                    $tourist['id_p'] === $person['idParroquia'] &&
                    $tourist['address'] === $person['address']
                ) {
                    unset($dataArray['tourist'][$key]);
                    // Reset array keys to ensure consistency after deletion
                    $dataArray['tourist'] = array_values($dataArray['tourist']);
                    break;
                }
            }
        
            return $dataArray;
        }
        
        
      
        /* //////////Fin el editar //////////////// */
        
    
        
        
        

        
    }
    
?>