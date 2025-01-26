<main>
  <div class="reservacion">
    <div class="header">
      
        <div class="titleModulos">
            <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
            </svg>
            <h2>Mis reservaciones</h2>
        </div>
        <div class="back-button-container">
              <a  title="Regresar" href="index.php?controller=home&action=homeInformation" >
              <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" /><!-- SVG -->
              </a>
          </div>

    </div>

    <div class="table-responsive">
      <table id="requestsReservationTourist" class="display nowrap" style="width:100%">
        <thead>
          <tr>
            <th>Viaje</th>
            <th>Fecha Salida</th>
            <th>Fecha de compra</th>
            <th>Cantidad</th> 
            <th>Monto(BS)</th>
            <th>Vacante</th>
         
          </tr>
        </thead>
        <tbody>
          <?php
          if (count($dataToView["data"]) > 0) {
              foreach ($dataToView["data"] as $data) { 
          ?>
          <tr>
            <td><?php echo $data['title']; ?></td>
            <td><?php echo date("d/m/Y", strtotime($data['departureDate'])); ?> </td> 
            <td><?php echo date("d/m/Y", strtotime($data['reservationDate'])); ?> </td>        
            <td> <?php echo $data['numberSlots']; ?></td>
            <td> <?php echo $data['amount']; ?> </td>
            <td class="dataTable-icon-center">  
            <!-- Botón para mostrar detalles -->
   
            <a href="index.php?controller=reservation&action=details&id=<?php echo $data['idReservation']; ?>&vista=reservation/listRequestsTouristA&status=A"  title="Ver detalles" >
              <?php echo DETAILS_ICON; ?> 
            </a>                            
            <a  title="Cancelar" class="Cancelar_tourist_reservation" href="index.php?controller=reservation&action=contolStatusRequests&id=<?php echo $data['idReservation']; ?> &status=C&cant=<?php echo $data['numberSlots']; ?>&idTrip=<?php echo $data['idTrip']; ?>&vista=TouristA">
                     <svg class="icon-focus-options" xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24'>
                        <path fill='none' stroke='#d32f2f' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M18 6L6 18M6 6l12 12'/>
                      </svg>    
            </a> 
       
            </td>
            
          </tr>
          <?php
                  } ;
                } 
                ?>
        </tbody>
      </table>
       <?php require_once('aletReservation.php'); ?>
    </div> 
  </div>
</main>



<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="reservation"></div>
<script src="asset/js/scripts/alert.js"></script>

<script src="asset\js\scripts\dataTableDynamic.js"></script>
<script src="asset/js/requests/requestsTrip.js"></script>
