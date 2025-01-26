<?php  if(!isset($_SESSION['user'])) header("location: ".DEFAULT_ADDRESS_LOGOUT); ?>

<main>
    <div class="bottom-data">
        <div>
            <div class="header">
                <div class="titleModule">
                    <svg class='bx red' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                        <path d="m6.516 14.323-1.49 6.452a.998.998 0 0 0 1.529 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082a1 1 0 0 0-.59-1.74l-5.701-.454-2.467-5.461a.998.998 0 0 0-1.822 0L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.214 4.107zm2.853-4.326a.998.998 0 0 0 .832-.586L12 5.43l1.799 3.981a.998.998 0 0 0 .832.586l3.972.315-3.271 2.944c-.284.256-.397.65-.293 1.018l1.253 4.385-3.736-2.491a.995.995 0 0 0-1.109 0l-3.904 2.603 1.05-4.546a1 1 0 0 0-.276-.94l-3.038-2.962 4.09-.326z"></path>
                    </svg>
                    <h2>Publicaciones especiales inhabilitadas</h2>
                </div>
                <div>
                    <a class="enlaces" href="index.php?controller=pubEspecial&action=list" title="Visualizar publicaciones habilitadas"><button class="button-Rev2" >Habilitados</button></a>  
                </div>
            </div>

            
            <table id="pubEspecialTable" class="display" style="width:100%">
              <thead>
                <tr>
                  <th class="heade">Título</th>
                  <th class="heade">Descripción</th>                  
                  <th class="heade">Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (count($dataToView["data"]) > 0) {
                  foreach ($dataToView["data"] as $data) {
                ?>
                    <tr>
                      
                      <td><?php echo $data['title']; ?></td>
                      <td class="description">
                                <?php echo strlen($data['description']) > 100 ? substr($data['description'], 0, 100) . '...' : $data['description']; ?>
                            </td>
                      <td>
                        <div class="dataTable-icon-center">
                            <div title="Ver detalles" class="view-details" model='pubEspecial' id="<?php echo $data['idPubSpecial'] ?>" >
                              <?php echo DETAILS_ICON ?>
                            </div>
                            <a title="Habilitar" class="enable" href="index.php?controller=pubEspecial&action=status&opc=enable&id=<?php echo $data['idPubSpecial'] ?>" title="habilitar">
                              <?php echo ENABLE_ICON ?>
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
</main>
<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="pubSpecial"></div>
<script src="asset\js\scripts\alert.js"></script>
<script src="asset\js\scripts\dataTableDynamic.js"></script>

            
