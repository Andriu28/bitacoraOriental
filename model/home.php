<?php
 require_once(MODEL_PATH."/db.php");

class home{
    public $conection;

    public function getConection(){
        $DbObj= new Db;
        $this->conection = $DbObj->conection;
    }

    public function packagesList($opc) {
        $this->getConection();
        if(!isset($opc)) return false; 
        $sql = "SELECT * FROM packages WHERE status = ?";
        $stmt = $this->conection->prepare($sql);

        /* condicional para saber que contenido extraer */
        if ($opc === 'enable') {
            $stmt->execute(["1"]);
        } elseif ($opc === 'disable') {
            $stmt->execute(["0"]);
        } 
        return $stmt->fetchAll();
    }

    public function routeList($status) {
      
        $this->getConection();
        $sql = "SELECT r.*, p.parroquia, m.municipio, e.estado, i.imageUrl AS image
                FROM route r
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

    public function FaqList(){
        $this->getConection();
        $sql = "SELECT * FROM " .'faq'. " WHERE status != 0";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
  
        return $stmt->fetchAll(PDO::FETCH_OBJ);
        
    }

    public function pubspecialLit($opc) {
        $this->getConection();
        if (!isset($opc)) return false;
    
        $sql = "SELECT ps.*, i.imageUrl AS image
                FROM pubspecials ps
                INNER JOIN image i ON ps.idImage = i.idImage
                WHERE ps.status = ?";
        $stmt = $this->conection->prepare($sql);
    
        /* Condicional para saber qué contenido extraer */
        if ($opc === 'enable') {
            $stmt->execute(["1"]);
        } elseif ($opc === 'disable') {
            $stmt->execute(["0"] );
        }
    
        return $stmt->fetchAll();
    }

    public function tripList($status) {
        $this->getConection();
        $sql = "SELECT v.*, v.title AS titleTrip, i.imageUrl,
                GROUP_CONCAT(t.amount SEPARATOR '<br><br>') AS amount,
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
                INNER JOIN image i ON r.idImage = i.idImage
                WHERE t.status = :status 
                GROUP BY v.idTrip, i.imageUrl
                ORDER BY v.departureDate ASC"; // Ordenar por returnDate en orden ascendente
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    


}////////////////////////////////

?>