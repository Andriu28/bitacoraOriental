<?php 
require_once(MODEL_PATH . "db.php");

class report {

  /* Atributos para la conexion con BD */
  
  public $conection;

  /* Conexion con DB siendo asignada en la variable conection para ser manipulada desde alli */
  public function getConection() {
    $DbObj = new Db;
    $this->conection = $DbObj->conection;
  }

  
  public function query($table, $camps = "*") {
    $this->getConection();
    
    $sql = "SELECT $camps FROM $table WHERE 1=1";
    
    $stmt = $this->conection->prepare($sql);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function queryTrip($camps, $startDate = null, $endDate = null, $startReturn = null, $endReturn = null) {
    $this->getConection();
    $sql = "SELECT " . $camps . " FROM trip v 
              INNER JOIN route r ON v.idRoute = r.idRoute
              INNER JOIN parroquia p ON r.idParroquia = p.id_p 
              INNER JOIN municipio m on p.municipio_id = m.id_m 
              INNER join estado e ON m.estado_id = e.id_e
              ";
    
    // Agregar condiciones de rango de fechas
    if (!empty($startDate) || !empty($endDate) || !empty($startReturn) || !empty($endReturn)) {
        $sql .= " WHERE";
        $conditions = [];
        if (!empty($startDate)) {
            $conditions[] = "v.departureDate >= :startDate";
        }
        if (!empty($endDate)) {
            $conditions[] = "v.departureDate <= :endDate";
        }
        if (!empty($startReturn)) {
          
          $conditions[] = "v.returnDate >= :startReturn";
        }
        if (!empty($endReturn)) {
            $conditions[] = "v.returnDate <= :endReturn";
        }
        $sql .= " " . implode(" AND ", $conditions);

    }
    $sql .= " ORDER BY v.departureDate ASC";
    $stmt = $this->conection->prepare($sql);

    // Vincular parámetros de fecha si están presentes
    if (!empty($startDate)) {
        $stmt->bindParam(':startDate', $startDate);
    }
    if (!empty($endDate)) {
        $stmt->bindParam(':endDate', $endDate);
    }
    if (!empty($startReturn)) {
      $stmt->bindParam(':startReturn', $startReturn);
    }
    if (!empty($endReturn)) {
      $stmt->bindParam(':endReturn', $endReturn);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function queryRoute($camps) {
  $this->getConection();
  $sql = "SELECT " . $camps . " FROM route r 
            INNER JOIN parroquia p ON r.idParroquia = p.id_p 
            INNER JOIN municipio m on p.municipio_id = m.id_m 
            INNER join estado e ON m.estado_id = e.id_e";
  
  $stmt = $this->conection->prepare($sql);

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function queryReservation($camps, $startDate, $endDate) {
  $this->getConection();
  $sql = "SELECT " . $camps . " FROM reservation r 
            INNER JOIN user s ON r.idUser = s.idUser 
            INNER JOIN traveloffer t ON r.idTravelOffer = t.id 
            INNER JOIN trip v ON t.idTrip = v.idTrip";
  
 // Agregar condiciones de rango de fechas
  if (!empty($startDate) || !empty($endDate)) {
  $sql .= " WHERE";
  $conditions = [];
  if (!empty($startDate)) {
      $conditions[] = "r.reservationDate >= :startDate";
  }
  if (!empty($endDate)) {
      $conditions[] = "r.reservationDate <= :endDate";
  }
  $sql .= " " . implode(" AND ", $conditions);
  
  }
  $sql .= " ORDER BY r.reservationDate ASC";

  $stmt = $this->conection->prepare($sql);

  // Vincular parámetros de fecha si están presentes
  if (!empty($startDate)) {
    $stmt->bindParam(':startDate', $startDate);
  }
  if (!empty($endDate)) {
    $stmt->bindParam(':endDate', $endDate);
  }

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function queryUser($camps) {
  $this->getConection();
  $sql = "SELECT " . $camps . " FROM user s inner join person p on s.idPerson = p.idPerson;";
  
  $stmt = $this->conection->prepare($sql);

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function queryOffer($camps) {
  $this->getConection();
  $sql = "SELECT " . $camps . " FROM traveloffer t 
          INNER JOIN trip v ON t.idTrip = v.idTrip 
          INNER JOIN packages p ON t.idPackages = p.idPackages;";
  $stmt = $this->conection->prepare($sql);

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function queryHistory($camps) {
  $this->getConection();
  $sql = "SELECT " . $camps . " FROM history h INNER JOIN user s ON h.idUser = s.idUser;";
  
  $stmt = $this->conection->prepare($sql);

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function queryWeblog($camps) {
  $this->getConection();
  $sql = "SELECT " . $camps . " FROM weblog w 
            INNER JOIN traveloffer t ON w.idTravelOffer = t.id 
            INNER JOIN trip v ON t.idTrip = v.idTrip";
  
  $stmt = $this->conection->prepare($sql);

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/* SELECT v.title, w.description, w.numberTravel, w.status FROM weblog w INNER JOIN traveloffer t ON w.idTravelOffer = t.id INNER JOIN trip v ON t.idTrip = v.idTrip;
 */
public function queryPerson($camps) {
  $this->getConection();
  $sql = "SELECT " . $camps . " FROM person p INNER JOIN parroquia a ON p.idParroquia = a.id_p;";
  
  $stmt = $this->conection->prepare($sql);

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getData(){
  return file_get_contents('C:\xampp\htdocs\bitacora_oriental\asset\txt\dataReport.txt');
}

public function tripGetMaxDate(){
  $this->getConection();
  $sql = "SELECT MAX(departureDate) as maxDateTrip FROM trip";
  $stmt = $this->conection->prepare($sql);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);	
}

public function reservGetMaxDate(){
  $this->getConection();
  $sql = "SELECT MAX(reservationDate) as maxDateReserv FROM reservation";
  $stmt = $this->conection->prepare($sql);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);	
}

}
?>
