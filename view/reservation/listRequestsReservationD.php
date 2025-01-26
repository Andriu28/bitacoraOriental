<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>
<main >
  <div class="bottom-data">
    <div>
      <div class="header">
        <div class="titleModule">
            <svg class='bx red' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2H6c-1.103 0-2 .897-2 2v18l8-4.572L20 22V4c0-1.103-.897-2-2-2zm0 16.553-6-3.428-6 3.428V4h12v14.553z"></path>
            </svg>
          <h2>Solicitudes de reservación rechazadas</h2>
        </div>
        <div>
          <a class="enlaces" href="index.php?controller=reservation&action=listRequestsE" title="Solicitudes de reservaciones">
            <button class="button-Rev2">Solicitudes de reservación</button>
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
                foreach ($dataToView["data"] as $data) {  ?>
            
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
                  <a href="index.php?controller=reservation&action=details&id=<?php echo $data['idReservation']; ?>&vista=reservation/listRequestsReservationD&status=D"  title="Ver detalles" >
                  <?php echo DETAILS_ICON; ?> 
                  </a>
                    <a  title="Reconciderar" class="reconcile" href="index.php?controller=reservation&action=contolStatusRequests&id=<?php echo $data['idReservation']; ?>&status=E&cant=NULL&idTrip=NULL&vista=D" >
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
