  <?php 
  if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT); ?>
  <main>
    
    <div class="bottom-data">
        <div>
            
            <div class="header">
                <div class="titleModule">
                    <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z"></path><path d="M11.42 21.814a.998.998 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819zM12 4c3.309 0 6 2.691 6 6.005.021 4.438-4.388 8.423-6 9.73-1.611-1.308-6.021-5.294-6-9.735 0-3.309 2.691-6 6-6z"></path>
                    </svg>
                    <h2>Rutas de viaje</h2>
                </div>
                <div class="buttom-container">
                    <?php  if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' &&count($dataToView["data"]) > 0 ){ ?>
                         <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                    <?php  } ?>
                    <a  href="index.php?controller=route&action=addRoute" title="Añadir"><button  class="button-Rev2">Añadir</button></a>
                    <a href="index.php?controller=route&action=listRouteDisabled" title="Visualizar rutas inhabilitadas"><button class="button-Rev2">Inhabilitados</button></a>
                </div>
            </div>


              <table id="routeTable" class="display" style="width:100%">
                  <thead >
                      <tr >
                          <th>Lugar</th>
                   
                          <th>Parroquia</th>
                         
                          <th>Estado</th>
                        
                          <th>Opciones</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php

                      if (count($dataToView["data"]) > 0) {
                          foreach ($dataToView["data"] as $data) {
                    ?>
                    <tr>
                        <td><?php echo $data['place']; ?></td>
                   
                          <td><?php echo $data['parroquia']; ?></td>
                       
                          <td><?php echo $data['estado']; ?></td>
                         
                          <td>
                            <div class="dataTable-icon-center">
                                <div title="Ver detalles" class="view-details" model='route' id="<?php echo $data['idRoute']; ?>">
                                    <?php echo DETAILS_ICON ?>                                
                                </div>
                                    <a  title="Editar" href="index.php?controller=route&action=editRoute&id=<?php echo $data['idRoute']; ?>" title="Editar">
                                    <?php echo EDIT_ICON ?>   
                                </a>
                                <a title="Inhabilitar" class="disable" href="index.php?controller=route&action=disableRoute&id=<?php echo $data['idRoute']; ?>&opc=false" title="Inhabilitar">
                                    <?php echo DISABLE_ICON ?>   
                                </a>
                            </div>                              
                          </td>
                      </tr>
                      <?php
                                  }
                                } 
                                ?>
                  </tbody>
              </table>
          </div>
      </div>
      <script src="asset\js\scripts\dataTableDynamic.js"></script>
      <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="route"></div>
      <script src="asset\js\scripts\alert.js"></script>
      <script src="asset\js\scripts\report.js" ></script>

  </main>