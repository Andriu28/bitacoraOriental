<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT); ?>
<main id="user">
  <div class="bottom-data">
    <div>
      <div class="header">
        <div class="titleModule">
            <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
            </svg>
          <h2>Reservaciones de viaje</h2>
        </div>
        <div class="buttom-container">
              <?php  if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' &&count($dataToView["data"]) > 0 ){ ?>
                         <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                <?php  } ?>
              <?php // Obtener los datos de las opciones de viaje
                $data = $_GET['trip'] ; 
                echo '<select class="custom-select" onchange="handleSelectChange(this)">';
                echo '<option value="">Añadir</option>';
                foreach ($data as $trip) {
                    echo '<option value="index.php?controller=reservation&action=requestReservation&idTrip=' . $trip['idTrip'] . '&admin=si">' . $trip['title'] . '</option>';
                }
                echo '</select>';
              ?>

             <a  href="index.php?controller=reservation&action=listRequestsC" title="Reservaciones canceladas">
            <button class="button-Rev2">Canceladas</button>
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
              <a href="index.php?controller=reservation&action=details&id=<?php echo $data['idReservation']; ?>&vista=reservation/listRequestsReservationA&status=A"  title="Ver detalles" >
               <?php echo DETAILS_ICON; ?> 
              </a>
              
              
              <a  title="Cancelar" class="canceld" href="index.php?controller=reservation&action=contolStatusRequests&id=<?php echo $data['idReservation']; ?>&status=C&cant=<?php echo $data['numberSlots']; ?>&idTrip=<?php echo $data['idTrip']; ?>&vista=A">
              <?php echo DISABLE_ICON ?>   
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
<script src="asset\js\scripts\report.js" ></script>

<script>
    function handleSelectChange(selectElement) {
        var selectedValue = selectElement.value;
        if (selectedValue) {
            window.location.href = selectedValue;
        }
    }
</script>

<script> window.onload = function() { if (window.history.replaceState) { window.history.replaceState(null, null, window.location.href); } }; </script>