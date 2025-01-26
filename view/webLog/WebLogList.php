
       

<?php if(!isset($_SESSION['user']))header("location:". DEFAULT_ADDRESS_LOGOUT);?>  

<main>
    
    <div class="bottom-data">
        <div>
            <div class="header">
                <div class="titleModule">
                    <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2 12h2a7.986 7.986 0 0 1 2.337-5.663 7.91 7.91 0 0 1 2.542-1.71 8.12 8.12 0 0 1 6.13-.041A2.488 2.488 0 0 0 17.5 7C18.886 7 20 5.886 20 4.5S18.886 2 17.5 2c-.689 0-1.312.276-1.763.725-2.431-.973-5.223-.958-7.635.059a9.928 9.928 0 0 0-3.18 2.139 9.92 9.92 0 0 0-2.14 3.179A10.005 10.005 0 0 0 2 12zm17.373 3.122c-.401.952-.977 1.808-1.71 2.541s-1.589 1.309-2.542 1.71a8.12 8.12 0 0 1-6.13.041A2.488 2.488 0 0 0 6.5 17C5.114 17 4 18.114 4 19.5S5.114 22 6.5 22c.689 0 1.312-.276 1.763-.725A9.965 9.965 0 0 0 12 22a9.983 9.983 0 0 0 9.217-6.102A9.992 9.992 0 0 0 22 12h-2a7.993 7.993 0 0 1-.627 3.122z"></path><path d="M12 7.462c-2.502 0-4.538 2.036-4.538 4.538S9.498 16.538 12 16.538s4.538-2.036 4.538-4.538S14.502 7.462 12 7.462zm0 7.076c-1.399 0-2.538-1.139-2.538-2.538S10.601 9.462 12 9.462s2.538 1.139 2.538 2.538-1.139 2.538-2.538 2.538z"></path>
                    </svg>
                    <h2>Bitácoras de viaje</h2>
                </div>
                <div class="buttom-container">
                
                <?php  if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' &&count($dataToView["data"]) > 0 ){ ?>
                         <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                    <?php  } ?>

                <a class="enlaces" href="index.php?controller=webLog&action=insert" ><button class="button-Rev2" >Añadir</button></a>  
                <a class="enlaces" href="index.php?controller=webLog&action=listDisable" title="Visualizar Paquetes Inhabilitados"><button class="button-Rev2" >Inhabilitados</button></a>
                </div> 
            </div>
            <table id="webLogTable"  style="width:100%">
                <thead>
                    <tr>
                        <th>Título del Viaje</th>
                        <th>Descripción</th>
                        <th>Número de viajeros</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($dataToView["data"]) > 0) { ?>
                        <?php foreach ($dataToView["data"] as $data) { ?>
                            <tr>
                                <td><?php echo $data['tripTitle']; ?></td>
                                <td  class="description"> <?php echo strlen($data['description']) > 100 ? substr($data['description'], 0, 100) . '...' : $data['description']; ?></td>
                                <td><?php echo $data['numberTravel']; ?></td>
                                <td >
                                    
                                    <div title="Ver detalles" class="view-details" model='webLog' id="<?php echo $data['idWebLog'] ?>"><?php echo DETAILS_ICON ?></div>
                                    <a title="Editar" href="index.php?controller=webLog&action=edit&id=<?php echo $data['idWebLog'] ?>" title="Editar">
                                        <?php echo EDIT_ICON ?>
                                    </a>
                                    <a title="Inhabilitar" class="disable" href="index.php?controller=webLog&action=status&opc=disable&id=<?php echo $data['idWebLog'] ?>" title="Inhabilitar">
                                        <?php echo DISABLE_ICON ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } // foreach ?>
                    <?php } // if ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<!--////////////////////////////////// Switc alert //////////////////////////////////-->
<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="webLog"></div>
<script src="asset/js/scripts/alert.js"></script>
<!--////////////////////////////////// Data Table //////////////////////////////////-->
<script src="asset/js/scripts/dataTableDynamic.js"></script>
<script src="asset\js\scripts\report.js" ></script>

 
    




