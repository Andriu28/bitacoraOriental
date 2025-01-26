<?php

// Recibir los paquetes según el viaje
$dataToView['data'] = $_GET['packages'] ?? [];
$dataTrip['data'] = $_GET['trip'] ?? [];

class Address {
    public $conection;

    public function __construct() {
        $this->getConection();
    }

    public function getConection() {

            $this->conection = new PDO('mysql:host=localhost;dbname=bitacora_oriental', 'root', '');
            $this->conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public function getDependence($aux) {
        $sql = "SELECT p.id_p, p.parroquia, m.id_m AS municipio_id, m.municipio, e.id_e AS estado_id, e.estado
                FROM parroquia p 
                INNER JOIN municipio m ON p.municipio_id = m.id_m
                INNER JOIN estado e ON m.estado_id = e.id_e
                WHERE p.id_p = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$aux]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addressEdo() {
        $sql = "SELECT id_e, estado FROM estado";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMunicipios() {
        $sql = "SELECT id_m, estado_id, municipio FROM municipio";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getParroquias() {
        $sql = "SELECT id_p, municipio_id, parroquia FROM parroquia";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



$address = new Address();

$sessionData['user'] = $objUserSession->decryptData($_SESSION['user'],KEY_DECRYP);

$states = $address->addressEdo();
$municipios = $address->getMunicipios();
$parroquias = $address->getParroquias();
$idParroquiaUsuario = $sessionData['user']['idParroquia'];
$aux = $address->getDependence($idParroquiaUsuario);

$estado = '';
$municipio = '';
$parroquia = '';
if (count($aux) > 0) {
    $estado = $aux[0]['estado'];
    $municipio = $aux[0]['municipio'];
    $parroquia = $aux[0]['parroquia'];
}
?>
<script>
    const statesOptions = <?php echo json_encode($states); ?>;
    const municipiosOptions = <?php echo json_encode($municipios); ?>;
    const parroquiasOptions = <?php echo json_encode($parroquias); ?>;
</script>

<?php
if (isset($_POST['id_p'])) {
    $sql = "SELECT p.id_p, p.parroquia, m.id_m AS municipio_id, m.municipio, e.id_e AS estado_id, e.estado
            FROM parroquia p 
            INNER JOIN municipio m ON p.municipio_id = m.id_m
            INNER JOIN estado e ON m.estado_id = e.id_e
            WHERE p.id_p = ?";
    $stmt = $address->conection->prepare($sql);
    $stmt->execute([$_POST['id_p']]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit();
}

if (isset($_POST['id_e'])) {
    $sql = "SELECT id_m, municipio FROM municipio WHERE estado_id = ? ORDER BY municipio ASC";
    $stmt = $address->conection->prepare($sql);
    $stmt->execute([$_POST['id_e']]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $respuesta = "<option value=''>Seleccionar</option>";
    if (count($result) > 0) {
        foreach ($result as $row) {
            $respuesta .= "<option value='" . htmlspecialchars($row['id_m']) . "'>" . htmlspecialchars($row['municipio']) . "</option>";
        }
    }
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    exit();
}

if (isset($_POST['id_m'])) {
    $sql = "SELECT id_p, parroquia FROM parroquia WHERE municipio_id = ? ORDER BY parroquia ASC";
    $stmt = $address->conection->prepare($sql);
    $stmt->execute([$_POST['id_m']]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $respuesta = "<option value=''>Seleccionar</option>";
    if (count($result) > 0) {
        foreach ($result as $row) {
            $respuesta .= "<option value='" . htmlspecialchars($row['id_p']) . "'>" . htmlspecialchars($row['parroquia']) . "</option>";
        }
    }
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    exit();
}
?>
