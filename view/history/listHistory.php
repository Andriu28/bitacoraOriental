<?php 
if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);

?>
<main>
<div class="bottom-data">
        <div>
            <div class="header">
                <div class="titleModule">
                    <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.903 8.586a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.952.952 0 0 0-.051-.259c-.01-.032-.019-.063-.033-.093zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z"></path><path d="M8 12h8v2H8zm0 4h8v2H8zm0-8h2v2H8z"></path>
                    </svg>
                    <h2>Historial</h2>
                </div>

                <div class="buttom-action">
                <?php  if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' &&count($dataToView["data"]) > 0 ){ ?>
                         <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                    <?php  } ?>
                </div>           

            </div>     
        <table id="historyTable" class="display" style="width:100%" >
        <?php
            if(count($dataToView["data"]) > 0){ ?>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acción</th>
                <th>Módulo</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>    
        <tbody>
          <?php
              foreach($dataToView["data"] as $data) :
          ?>  
          <tr>
            <td><?php echo $data->email; ?></td>
            <td><?php echo $data->privilege==='admin'?'Administrador': 'Publicista'; ?></td>
            <td><?php echo ucfirst($data->action); ?></td>

            <td class=""><?php echo $data->module; ?></td>
            <td><?php echo date('d /m /Y', strtotime($data->registrationDate)); ?></td>


            <td><?php echo date('h:i A', strtotime($data->registrationTime)); ?></td>

          </tr>
       
        <?php 
          endforeach;
          }
        ?>
        
       </tbody>
      </table>
      <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="history"></div>
      <script src="asset/js/scripts/alert.js"></script>
    </div>
    <script src="asset/js/scripts/dataTableDynamic.js"></script>
    <script src="asset\js\scripts\report.js" ></script>
</div>


</main>