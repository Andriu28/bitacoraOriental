<?php
// validador de datos
require_once(CONTROLLER_PATH ."/dataValidator.php");

require_once(CONTROLLER_PATH."historys.php");

/* modelo del modulo paquete */
require_once(MODEL_PATH."/db.php");



 class comment  {/////////////////////////////////////////////////////////////////////////

    public $idComment;
    public $idUser;
    public $idWebLog;
    public $message ;
    public $status ;
    public $dataTime;

    /*---------Conecion a la base de datos---------*/
    public $table= 'comment';
    public $conection;

    public function __construct(){}


    public function getConection(){
        $DbObj= new Db;
        $this->conection = $DbObj->conection;
    }
    /* ----------------------------------------- */

    function getCommentById($id){
                
        $this->getConection();        
        $sql = "
            SELECT c.*, t.title as titleTrip, p.name, p.lastName, u.email
            FROM " . $this->table . " c
            JOIN weblog w ON c.idWeblog = w.idWeblog
            JOIN user u ON c.idUser = u.idUser
            JOIN person p ON u.idPerson = p.idPerson
            JOIN traveloffer toff ON w.idTraveloffer = toff.id
            JOIN trip t ON toff.idTrip = t.idTrip
            WHERE c.idComment = ?
        ";

        $stmt = $this->conection->prepare($sql);        
        $stmt->execute([$id]);        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //funcion para insertar comentarios
    public function insertComment($idUser, $idWebLog, $message) {
        
        //Se comprueba que los datos no esten vacios
        if(validateParams($idUser, $idWebLog, $message)){
            return "error_insert_data";
        }

        $this->getConection();        
        // SQL para insertar datos en la tabla comment con CURRENT_TIMESTAMP()
        $sql = "
            INSERT INTO comment (idUser, idWebLog, message, status, dataTime)
            VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP())
        ";        
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idUser, $idWebLog, $message, 'E']);        
        return "success_insert"; // Devuelve el número de filas afectadas

    }
    


    
    //funcion para listar los comentarios segun el id
    public function getCommentByStatus($status){        
        $this->getConection();        
        $sql = "
            SELECT c.*, t.title as titleTrip 
            FROM " . $this->table . " c
            JOIN weblog w ON c.idWeblog = w.idWeblog
            JOIN traveloffer toff ON w.idTraveloffer = toff.id
            JOIN trip t ON toff.idTrip = t.idTrip
            WHERE c.status = ?
        ";
        $stmt = $this->conection->prepare($sql);        
        $stmt->execute([$status]);        
        return $stmt->fetchAll();
    }

    //cambiar el status de un comentarios 
    public function setStatusById($status, $idComment){        
        $this->getConection();
        $sql = "UPDATE comment AS c SET status = ? WHERE c.idComment = ? ";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$status, $idComment]);
        $aux = "none";
        $history = new historysController;   
        if($status === "A"){
            $aux = "Accept_comment";
            $history->addRegister($this->table, "El usuario aceptó el comentario.");
        }else if($status === "R"){
            $aux = "rejected_comment";
            $history->addRegister($this->table, "El usuario rechazó el comentario.");
        }        
        return $aux;
    }////////////////////////////////////////////////////

    /*funcion para sacar los datos del los comentarios al portal  */
    public function getCommentView($idWeblog, $status) {        
        $this->getConection();        
        $sql = "
            SELECT 
                c.*, 
                t.title AS titleTrip, 
                p.name, 
                p.lastName, 
                u.email
            FROM " . $this->table . " c
            JOIN weblog w ON c.idWeblog = w.idWeblog
            JOIN user u ON c.idUser = u.idUser
            JOIN person p ON u.idPerson = p.idPerson
            JOIN traveloffer toff ON w.idTraveloffer = toff.id
            JOIN trip t ON toff.idTrip = t.idTrip
            WHERE c.status = ? AND w.idWeblog = ?
        ";
        
        $stmt = $this->conection->prepare($sql);        
        $stmt->execute([$status, $idWeblog]);        
        return $stmt->fetchAll();
    }


}////////////////////////////////////////////////////////////////////////////////////


?>

