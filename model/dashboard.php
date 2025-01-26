<?php

//llamado la base de datos
require_once(MODEL_PATH."db.php");

class dashboard {

    /* Atributos para la conexión con BD */
    public $table;
    public $conection;

    public function __construct() {
        
    }

    public function getConection() {
        $DbObj = new Db();
        $this->conection = $DbObj->conection;
    }

    public function packetCounting() {
        $this->getConection();
        // Consulta SQL para contar registros con status = 1
        $sql_status_1 = "SELECT COUNT(*) AS total_status_1 FROM packages WHERE status = 1";
        $result_status_1 = $this->conection->query($sql_status_1);
        $total_enable = $result_status_1->fetch();
        // Consulta SQL para contar registros con status = 0
        $sql_status_0 = "SELECT COUNT(*) AS total_status_0 FROM packages WHERE status = 0";
        $result_status_0 = $this->conection->query($sql_status_0);
        $total_disable =  $result_status_0->fetch();      
        return array(
            "packages" => $total_enable['total_status_1'] + $total_disable['total_status_0'],
            "packagesEnable" => $total_enable['total_status_1'],
            "packagesDisable" => $total_disable['total_status_0']
        );
    }

    public function routeCounting(){
        $this->getConection();
        // Consulta SQL para contar registros con status = 1
        $sql_status_1 = "SELECT COUNT(*) AS total_status_1 FROM route WHERE status = 1";
        $result_status_1 = $this->conection->query($sql_status_1);
        $total_enable = $result_status_1->fetch();
        // Consulta SQL para contar registros con status = 0
        $sql_status_0 = "SELECT COUNT(*) AS total_status_0 FROM route WHERE status = 0";
        $result_status_0 = $this->conection->query($sql_status_0);
        $total_disable =  $result_status_0->fetch();
        return array(
            "route" => $total_enable['total_status_1'] + $total_disable['total_status_0'],
            "routeEnable" => $total_enable['total_status_1'],
            "routeDisable" => $total_disable['total_status_0']
        );

    }

    public function faqCounting(){
        $this->getConection();
        // Consulta SQL para contar registros con status = 1
        $sql_status_1 = "SELECT COUNT(*) AS total_status_1 FROM faq WHERE status = 1";
        $result_status_1 = $this->conection->query($sql_status_1);
        $total_enable = $result_status_1->fetch();
        // Consulta SQL para contar registros con status = 0
        $sql_status_0 = "SELECT COUNT(*) AS total_status_0 FROM faq WHERE status = 0";
        $result_status_0 = $this->conection->query($sql_status_0);
        $total_disable =  $result_status_0->fetch();
        return array(
            "faq" => $total_enable['total_status_1']+$total_disable['total_status_0'],
            "faqEnable" => $total_enable['total_status_1'],
            "faqDisable" => $total_disable['total_status_0']
        );
    }

    public function pubSpecialsCounting(){
        $this->getConection();
        // Consulta SQL para contar registros con status = 1
        $sql_status_1 = "SELECT COUNT(*) AS total_status_1 FROM pubspecials WHERE status = 1";
        $result_status_1 = $this->conection->query($sql_status_1);
        $total_enable = $result_status_1->fetch();
        // Consulta SQL para contar registros con status = 0
        $sql_status_0 = "SELECT COUNT(*) AS total_status_0 FROM pubspecials WHERE status = 0";
        $result_status_0 = $this->conection->query($sql_status_0);
        $total_disable =  $result_status_0->fetch();
        return array(
            "pubSpecials" => $total_enable['total_status_1']+$total_disable['total_status_0'],
            "pubSpecialsEnable" => $total_enable['total_status_1'],
            "pubSpecialsDisable" => $total_disable['total_status_0']
        );

    }

    public function weblogCounting(){
        $this->getConection();
        // Consulta SQL para contar registros con status = 1
        $sql_status_1 = "SELECT COUNT(*) AS total_status_1 FROM weblog WHERE status = 1";
        $result_status_1 = $this->conection->query($sql_status_1);
        $total_enable = $result_status_1->fetch();
        // Consulta SQL para contar registros con status = 0
        $sql_status_0 = "SELECT COUNT(*) AS total_status_0 FROM weblog WHERE status = 0";
        $result_status_0 = $this->conection->query($sql_status_0);
        $total_disable =  $result_status_0->fetch();
        return array(
            "weblog" => $total_enable['total_status_1']+$total_disable['total_status_0'],
            "weblogEnable" => $total_enable['total_status_1'],
            "weblogDisable" => $total_disable['total_status_0']
        );
    }

    public function userTouristCounting(){
        $this->getConection();
         // Consulta SQL para contar registros con status = 1
         $sql_status_1 = "SELECT COUNT(*) AS total_status_1 FROM user WHERE privilege = 'turista' AND status = 1";
         $result_status_1 = $this->conection->query($sql_status_1);
         $total_enable = $result_status_1->fetch();
         // Consulta SQL para contar registros con status = 0
         $sql_status_0 = "SELECT COUNT(*) AS total_status_0 FROM user WHERE privilege = 'turista' AND status = 0";
         $result_status_0 = $this->conection->query($sql_status_0);
         $total_disable =  $result_status_0->fetch();
         return array(
             "userTourist" => $total_enable['total_status_1']+$total_disable['total_status_0'],
             "userTouristEnable" => $total_enable['total_status_1'],
             "userTouristDisable" => $total_disable['total_status_0']
         );
   
        
        }

        
        public function userPublicistCounting(){
            $this->getConection();
            $sql_status_1 = "SELECT COUNT(*) AS total_status_1 FROM user WHERE privilege = 'publicista' AND status = 1";
            $result_status_1 = $this->conection->query($sql_status_1);
            $total_enable = $result_status_1->fetch();
            // Consulta SQL para contar registros con status = 0
            $sql_status_0 = "SELECT COUNT(*) AS total_status_0 FROM user WHERE privilege = 'publicista' AND status = 0";
            $result_status_0 = $this->conection->query($sql_status_0);
            $total_disable =  $result_status_0->fetch();
            return array(
                "userPublicist" => $total_enable['total_status_1']+$total_disable['total_status_0'],
                "userPublicistEnable" => $total_enable['total_status_1'],
                "userPublicistDisable" => $total_disable['total_status_0']
            );

    }
    /*retorna un viaje si esta serca de cumplirce en un plazo establecido*/
    


    /*Retorna las primeras 5 ofertas de viaje mas proximas a la fecha en orden asendente(mas cercana hasta mas lejana) */
    public function traveloffer(){
        $this->getConection();
        
        $sql = "WITH UniqueTrips AS 
            ( SELECT traveloffer.id, trip.title, trip.departureDate, trip.vacant, ROW_NUMBER()
            OVER (PARTITION BY trip.idTrip ORDER BY trip.departureDate ASC)
            AS rn FROM traveloffer JOIN trip ON traveloffer.idTrip = trip.idTrip 
            WHERE traveloffer.status = 1 AND trip.departureDate >= CURRENT_DATE )
            SELECT id, title, departureDate, vacant
            FROM UniqueTrips 
            WHERE rn = 1 ORDER BY departureDate ASC LIMIT 4; ";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function pendingReservationCount(){
        $this->getConection();
        $sql = "SELECT COUNT(*) AS totalE FROM `reservation` AS r WHERE r.confirmation = 'E'";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function pendingCommentCount(){
        $this->getConection();
        $sql = "SELECT COUNT(*) AS totalE FROM `comment` AS c WHERE c.status = 'E'";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    /*funcion para refrescar las ofertas de viaje que ya se hicieron */
    public function refreshTravelTime(){
        $this->getConection();
        $sql = "UPDATE traveloffer t 
            JOIN trip tr ON t.idTrip = tr.idTrip 
            SET t.status = 'R' 
             WHERE tr.departureDate < CURDATE()
                AND t.status = '1';";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $stmt->fetchAll();
    }
    public function refreshReservationTime() {
        $this->getConection();
        $sql = "UPDATE reservation r 
                JOIN traveloffer tr ON tr.id = r.idTravelOffer
                JOIN trip t ON t.idTrip = tr.idTrip
                SET r.confirmation = 'R' 
                WHERE t.departureDate < CURDATE()
                AND r.confirmation = 'A';";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $stmt->fetchAll();

        $sql = "UPDATE reservation r 
                JOIN traveloffer tr ON tr.id = r.idTravelOffer
                JOIN trip t ON t.idTrip = tr.idTrip
                SET r.confirmation='Z'
                WHERE t.departureDate < CURDATE()
                AND r.confirmation = 'E';";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $stmt->fetchAll();


    }
    



}//////////////////////////////////////////////////////////////////////

?>