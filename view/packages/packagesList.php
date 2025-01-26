<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);
//include '/opt/lampp/htdocs/bitacora_oriental/lib/utils/tools.php';

?>  

<main>

    <div class="bottom-data">
        <div>
            <div class="header">
                <div class="titleModule">
                    <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22 8a.76.76 0 0 0 0-.21v-.08a.77.77 0 0 0-.07-.16.35.35 0 0 0-.05-.08l-.1-.13-.08-.06-.12-.09-9-5a1 1 0 0 0-1 0l-9 5-.09.07-.11.08a.41.41 0 0 0-.07.11.39.39 0 0 0-.08.1.59.59 0 0 0-.06.14.3.3 0 0 0 0 .1A.76.76 0 0 0 2 8v8a1 1 0 0 0 .52.87l9 5a.75.75 0 0 0 .13.06h.1a1.06 1.06 0 0 0 .5 0h.1l.14-.06 9-5A1 1 0 0 0 22 16V8zm-10 3.87L5.06 8l2.76-1.52 6.83 3.9zm0-7.72L18.94 8 16.7 9.25 9.87 5.34zM4 9.7l7 3.92v5.68l-7-3.89zm9 9.6v-5.68l3-1.68V15l2-1v-3.18l2-1.11v5.7z"></path>
                    </svg>
                    <h2>Paquetes de viaje</h2>
                </div>
                <div class="buttom-container">
                <?php  if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' &&count($dataToView["data"]) > 0 ){ ?>
                         <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                    <?php  } ?>
                    <a title="Añadir" href="index.php?controller=packages&action=insert" > <button class="button-Rev2" >Añadir</button>  </a>
                    <a href="index.php?controller=packages&action=listDisable" > <button  class="button-Rev2" title="Visualizar paquetes inhabilitados">Inhabilitados</button></a>
                </div> 
            </div>
        <table id="packgesTable" class="display" style="width:100%">
            <?php   if(count($dataToView["data"])>0){ ?>
            <thead>
            <tr>
                <th>Título</th>
                <th>Precio (<?php echo MONETARY_UNIT ?>)  </th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($dataToView["data"] as $data){ ?>
                    <tr>
                        <td><?php echo $data['title']; ?></td>
                        <td><?php echo $data['price']; ?></td>
                        <td>
                            <div class="dataTable-icon-center">
                                <div title="Ver detalles" class="view-details" model='packages' id="<?php echo $data['idPackages'] ?>">
                                    <?php echo DETAILS_ICON ?>                                
                                </div>
                                <a  title="Editar" href="index.php?controller=packages&action=edit&id=<?php echo $data['idPackages'] ?>" title="Editar">
                                    <?php echo EDIT_ICON ?>   
                                </a>
                                <a title="Inhabilitar" class="disable" href="index.php?controller=packages&action=status&opc=disable&id=<?php echo $data['idPackages'] ?>" title="Inhabilitar">
                                    <?php echo DISABLE_ICON ?>   
                                </a>
                            </div>
                        </td>
                            
                    </tr>
                <?php
                    }// foreach
                    }
                ?>

            </tbody>
        </table>
        </div>
    </div>
</main>
<!--////////////////////////////////// Switc alert //////////////////////////////////-->
<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="packages"></div>
<script src="asset\js\scripts\alert.js"></script>
<!--////////////////////////////////// Data Table //////////////////////////////////-->
<script src="asset\js\scripts\dataTableDynamic.js"></script>
<script src="asset\js\scripts\report.js" ></script>

 
    



