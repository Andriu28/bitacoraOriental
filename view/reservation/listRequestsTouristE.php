<main>

  <div class="reservacion">
  
    <div class="header">
        <div class="titleModulos">
            <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18 2H6c-1.103 0-2 .897-2 2v18l8-4.572L20 22V4c0-1.103-.897-2-2-2zm0 16.553-6-3.428-6 3.428V4h12v14.553z"></path>
            </svg>
            <h2>Mis solicitudes de reservación</h2>
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
            
              <a href="index.php?controller=reservation&action=details&id=<?php echo $data['idReservation']; ?>&vista=reservation/listRequestsTouristE&status=E"  title="Ver detalles" >
                <?php echo DETAILS_ICON; ?> 
              </a>
              <a  title="Editar" href="index.php?controller=reservation&action=editRequestReservation&idTrip=<?php echo $data['idTrip'] ?>&id=<?php echo $data['idReservation']; ?>" >
                      <?php echo EDIT_ICON ?>   
                  </a>
              <a  title="Cancelar" class="Cancelar_tourist" href="index.php?controller=reservation&action=contolStatusRequests&id=<?php echo $data['idReservation']; ?>&status=B&cant=0&idTrip=NULL&vista=TouristE">
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


