<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>
<main >
  <div class="bottom-data">
    <div>
      <div class="header">
        <div class="titleModule">
            <svg class='bx red' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
            </svg>
          <h2>Reservaciones canceladas</h2>
        </div>
        <div>
          <a class="enlaces" href="index.php?controller=reservation&action=listRequestsA" title="Reservaciones de viaje">
            <button class="button-Rev2">Reservaciones</button>
          </a>
        </div>
      </div>
      <div class="table-responsive">
        <table id="requestsReservation" class="display nowrap" style="width:100%">
          <thead>
            <tr>
              <th>Viaje</th>
              <th>Fecha Salida</th>
              <th>Correo</th>
              <th>Teléfono</th>
              <th>Vacante</th>
              <th>Cantidad</th>
              <th>Monto(BS)</th>
              
              <th>Opciones</th>
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
              <td> <?php echo $data['email']; ?> </td>
              <td>  <?php echo $data['phone']; ?></td> 
              <td> <?php echo $data['vacant']; ?> </td>
              <td> <?php echo $data['numberSlots']; ?></td>
              <td> <?php echo $data['amount']; ?> </td>
              <td class="dataTable-icon-center">  
         
              <!-- Botón para mostrar detalles -->
              <a href="index.php?controller=reservation&action=details&id=<?php echo $data['idReservation']; ?>&vista=reservation/listRequestsReservationC&status=C"  title="Ver detalles" >
               <?php echo DETAILS_ICON; ?> 
              </a>
               
              <a  title="Reconciderar" class="reconcileCancel" href="index.php?controller=reservation&action=contolStatusRequests&id=<?php echo $data['idReservation']; ?>&status=A&cant=<?php echo $data['numberSlots']; ?>&idTrip=<?php echo $data['idTrip']; ?>&vista=C" >
                    <?php echo ENABLE_ICON ?>
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
  </div>
</main>


<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="reservation"></div>
<script src="asset/js/scripts/alert.js"></script>

  <script src="asset\js\scripts\dataTableDynamic.js"></script>
  <script src="asset/js/requests/requestsTrip.js"></script>