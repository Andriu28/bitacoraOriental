<?php
require_once (MODEL_PATH."report.php");
require_once 'C:\xampp\htdocs\bitacora_oriental\lib\dompdf\autoload.inc.php'; 
use Dompdf\Dompdf; 
use Dompdf\Options;

class reportsController{

    public $view;
    public $maxDateTrip;
    public $maxDateReserv;
    public $objReport;
    public $objUserSession;
    public $response;
    public function __construct(){
        $this->view = 'report\viewReport';
        $this->objReport = new report ;
        $this->objUserSession = new userSession;
        $this->objUserSession->sessionAccessAdmin();//para denegar el accesp a los usurios no admins
        $this->response = array(
          "response" => "none" 
        );
    }
    
    public function viewReport(){
      $this->view = 'report\viewReport';
    }

    public function genReport() {

      $table = isset($_POST['table']) ? $_POST['table'] : null;
      $campos = isset($_POST['camp']) ? $_POST['camp'] : '';
      $starDate = isset($_POST['starDate']) ? $_POST['starDate'] : null;
      $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;
      $startReturn = isset($_POST['startReturn']) ? $_POST['startReturn'] : null;
      
      $endReturn = isset($_POST['endReturn']) ? $_POST['endReturn'] : null;
      
      switch ($table) {
        case 'trip':
          $camps = empty($campos) ? 'v.title, r.place, p.parroquia, m.municipio, e.estado, v.departureLocation, v.departureDate, v.departureTime, v.returnDate, v.returnTime, v.numberSlots, v.vacant, v.price' : implode(", ", $campos);
          $data = $this->dataTrip($camps, $starDate, $endDate, $startReturn, $endReturn);
          break;

        case 'route':
          $camps = empty($campos) ? 'r.place, r.location, p.parroquia, m.municipio, e.estado, r.description, r.status' : implode(", ", $campos);
          $data = $this->dataRoute($camps);
          break;

        case 'reservation':
          $camps = empty($campos) ? 's.email, v.title, r.numberSlots, r.reservationDate, r.amount, r.confirmation' : implode(", ", $campos);
          $data = $this->dataReservation($camps, $starDate, $endDate);
          break;

        case 'user':
          $camps = empty($campos) ? 'p.name, s.email, s.privilege, s.status, s.verified' : implode(", ", $campos);
          $data = $this->dataUser($camps);
          break;

        case 'history':
          $email = is_array($campos) && $campos[0] == 'email' ? 'h.email' : '';
          $camps = empty($campos) ? 's.email, h.module, h.action, h.registrationDate, h.registrationTime' : implode(", ", $campos);
          $data = $this->dataHistory($camps, $email);
          break;

        case 'weblog':
          $camps = empty($campos) ? 'v.title, w.description, w.numberTravel, w.status' : implode(", ", $campos);
          $data = $this->dataWeblog($camps);
          break;

        case 'traveloffer':
          $camps = empty($campos) ? 'v.title AS tripTitle, p.title AS packageTitle, t.amount, t.status' : implode(", ", $campos);
          $data = $this->dataOffer($camps);
          break;
        
          case 'person':
            $camps = empty($campos) ? 'p.ci, p.name, p.lastName, p.birthDate, p.phone, a.parroquia, p.address' : implode(", ", $campos);
            $data = $this->dataPerson($camps);
            break;
        default:
          $camps = empty($campos) ? '*' : implode(", ", $campos);
          $data = $this->objReport->query($table, $camps);
          break;
      }

      $html = $this->render('C:\xampp\htdocs\bitacora_oriental\view\report\report_' . $table . '.php', $data); // la ruta tiene que ser absoluta 
      
      $options = new Options(); 
      $options->set('isRemoteEnabled', true); 
      $dompdf = new Dompdf($options); // Carga la vista y pasa los datos
      $dompdf->loadHtml($html); 
      $columnCount = count(explode(',', $camps));
      // Configurar orientación y tamaño del papel 
      if ($columnCount > 12) { 
        $dompdf->setPaper('A3', 'landscape'); 
      } else { 
        $orientation = ($columnCount > 7) ? 'landscape' : 'portrait'; 
        $dompdf->setPaper('A4', $orientation); 
      }
      $dompdf->render(); // Envia el PDF como descarga al navegador 
      // Obtener el canvas de Dompdf para agregar contenido 
      $canvas = $dompdf->getCanvas(); 
      $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) { 
        $text = "Pagina $pageNumber de $pageCount"; 
        $font = $fontMetrics->getFont('Helvetica', 'normal'); 
        $size = 12; $width = $fontMetrics->getTextWidth($text, $font, $size); 
        $canvas->text(520 - $width / 2, 820, $text, $font, $size); 

        // Agregar dirección y número de teléfono en la esquina inferior izquierda 
        $address = "Dirección: Sucre, Carúpano, Sector Guayacan, las Cuatro Equinas "; 
        $phone = "Teléfono: +58 4122918427"; 
        $canvas->text(30, 805, $address, $font, $size); 
        $canvas->text(30, 820, $phone, $font, $size);
      });
      $dompdf->stream("reporte". $table .".pdf", ["Attachment" => 0]);  

     
    }

    
  public function render($view, $data = []) {
    // Verifica si la vista existe
    if (!file_exists($view)) {
      return "Error: La vista no existe.";
    }

    // Captura el contenido de la vista
    ob_start();
    include 'C:\xampp\htdocs\bitacora_oriental\view\template\headerReport.php';
    include $view;
    $html = ob_get_clean();

    return $html;
  }

  public function dataTrip($camps, $starDate, $endDate, $startReturn, $endReturn){
    $data = $this->objReport->queryTrip($camps, $starDate, $endDate, $startReturn, $endReturn);
    return $data;
  }

  public function dataRoute($camps){
    $data = $this->objReport->queryRoute($camps);
    return $data;
  }

  public function dataUser($camps){
    $data = $this->objReport->queryUser($camps);
    return $data;
  }

  public function dataOffer($camps){
    $data = $this->objReport->queryOffer($camps);
    return $data;
  }

  public function dataReservation($camps, $starDate, $endDate){
    $data = $this->objReport->queryReservation($camps, $starDate, $endDate);
    return $data;
  }

  public function dataHistory($camps){
    $data = $this->objReport->queryHistory($camps);
    return $data;
  }

  public function dataWeblog($camps){
    $data = $this->objReport->queryWeblog($camps);
    return $data;
  }

  public function dataPerson($camps){
    $data = $this->objReport->queryPerson($camps);
    return $data;
  }

  public function report() {
    $data = $this->objReport->getData();
    $html = $this->render('C:\xampp\htdocs\bitacora_oriental\view\report\bodyReport.php', $data); // la ruta tiene que ser absoluta 
       
      $options = new Options(); 
      $options->set('isRemoteEnabled', true); 
      $dompdf = new Dompdf($options); // Carga la vista y pasa los datos
      $dompdf->loadHtml($html); 
      $dompdf->setPaper('A4', 'portrait'); // Renderiza el HTML como PDF
      $dompdf->render(); // Envia el PDF como descarga al navegador 
      $dompdf->stream("reporte.pdf", ["Attachment" => 0]); 

  }


}