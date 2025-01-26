<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>
<main >
  <div class="bottom-data">
    <div>
      <div class="header">
        <div class="titleModule">
            <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2H6c-1.103 0-2 .897-2 2v18l8-4.572L20 22V4c0-1.103-.897-2-2-2zm0 16.553-6-3.428-6 3.428V4h12v14.553z"></path>
            </svg>
          <h2>Solicitudes de reservación</h2>
        </div>
        <div>
        <?php  if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' &&count($dataToView["data"]) > 0 ){ ?>
                         <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                    <?php  } ?>
          <a class="enlaces" href="index.php?controller=reservation&action=listRequestsD" title="Solicitudes de reservaciones rechazadas">
            <button class="button-Rev2">Rechazadas</button>
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
              
                  <a href="index.php?controller=reservation&action=details&id=<?php echo $data['idReservation']; ?>&vista=reservation/listRequestsReservationE&status=E"  title="Ver detalles" >
                  <?php echo DETAILS_ICON; ?> 
                  </a>


                    <a  title="Aceptar" class="accept" href="index.php?controller=reservation&action=contolStatusRequests&id=<?php echo $data['idReservation']; ?>&status=A&cant=<?php echo $data['numberSlots']; ?>&idTrip=<?php echo $data['idTrip']; ?>&vista=E" >
                      <svg xmlns="http://www.w3.org/2000/svg" class="bx green icon-focus-options" width="30" height="30" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd"> <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M21.546 5.111a1.5 1.5 0 0 1 0 2.121L10.303 18.475a1.6 1.6 0 0 1-2.263 0L2.454 12.89a1.5 1.5 0 1 1 2.121-2.121l4.596 4.596L19.424 5.111a1.5 1.5 0 0 1 2.122 0"/></g>
                      </svg>   
                    </a>
                    <a  title="Rechazar" class="decline" href="index.php?controller=reservation&action=contolStatusRequests&id=<?php echo $data['idReservation']; ?>&status=D&cant=0&idTrip=NULL&vista=E">
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
  </div>
</main>


<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="reservation"></div>
<script src="asset/js/scripts/alert.js"></script>
<script src="asset\js\scripts\dataTableDynamic.js"></script>

<script src="asset/js/requests/requestsTrip.js"></script>
  
<script src="asset\js\scripts\report.js" ></script>

