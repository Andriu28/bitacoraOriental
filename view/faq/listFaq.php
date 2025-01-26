<?php 
if(!isset($_SESSION['user'])) header("location:". DEFAULT_ADDRESS_LOGOUT);

?>
<main>
    <div class="bottom-data">
        <div>

        <div class="header">
                <div class="titleModule">
                    <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 6a3.939 3.939 0 0 0-3.934 3.934h2C10.066 8.867 10.934 8 12 8s1.934.867 1.934 1.934c0 .598-.481 1.032-1.216 1.626a9.208 9.208 0 0 0-.691.599c-.998.997-1.027 2.056-1.027 2.174V15h2l-.001-.633c.001-.016.033-.386.441-.793.15-.15.339-.3.535-.458.779-.631 1.958-1.584 1.958-3.182A3.937 3.937 0 0 0 12 6zm-1 10h2v2h-2z"></path><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                    </svg>
                    <h2>Preguntas frecuentes </h2>
                </div>
                <div class="buttom-container"> 
                <?php  if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' &&count($dataToView["data"]) > 0 ){ ?>
                         <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                    <?php  } ?>
                <a href="index.php?controller=faqs&action=addFaq" title="Añadir"><button class="button-Rev2">Añadir</button></a>
                <a href="index.php?controller=faqs&action=listFaqDisable" title="Visualizar Preguntas Frecuentes Inhabilitadas"><button class="button-Rev2">Inhabilitados</button></a>

                </div>
            </div>
                      
           
            
            <table id="faqTable" class="display" style="width:100%">
                <?php if(count($dataToView["data"]) > 0): ?>
                <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Opciones</th>
                    </tr>
                </thead>    
                <tbody>
                    <?php foreach($dataToView["data"] as $data): ?>  
                    <tr>
                        <td>
                            <?php echo strlen($data->query) > 80 ? substr($data->query, 0, 80) . '...' : $data->query; ?>
                        </td>
                        <td>
                            <?php echo strlen($data->respond) > 100 ? substr($data->respond, 0, 100) . '...' : $data->respond; ?>
                        </td>
                        <td>
                            <div class="dataTable-icon-center">
                                <div title="Ver detalles" class="view-details" model='faqs' id="<?php echo $data->id_preg_frecuente;?>">
                                    <?php echo DETAILS_ICON ?>                                
                                </div>
                                <a title="Editar" href="index.php?controller=faqs&action=editFaq&id=<?php echo $data->id_preg_frecuente;?>" title="Editar">
                                    <?php echo EDIT_ICON ?>   
                                </a>
                                <a title="Inhabilitar" class="disable" href="index.php?controller=faqs&action=status&opc=disable&id=<?php echo $data->id_preg_frecuente;?>" title="Inhabilitar">
                                    <?php echo DISABLE_ICON ?>   
                                </a> 
                            </div>           
                        </td>            
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
</main>

<div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="faq"></div>
<script src="asset\js\scripts\alert.js"></script>
<script src="asset\js\scripts\dataTableDynamic.js"></script>
<script src="asset\js\scripts\report.js" ></script>
