<?php if(!isset($_SESSION['user'])) header("location:" . DEFAULT_ADDRESS_LOGOUT); ?>

<main>
    <div class="bottom-data">
        <div>
        <div class="header">
                <div class="titleModule">
                   
                  <?php if($_GET['type'] === 'E'){  ?>
                    <svg class='bx orange' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 2H8C4.691 2 2 4.691 2 8v12a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 13c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v7z"></path><circle cx="9.5" cy="11.5" r="1.5"></circle><circle cx="14.5" cy="11.5" r="1.5"></circle>
                     </svg>
                        <h2>Comentarios en espera</h2>
                    <?php }else if($_GET['type'] === 'A'){  ?>
                        <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 2H8C4.691 2 2 4.691 2 8v12a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 13c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v7z"></path><circle cx="9.5" cy="11.5" r="1.5"></circle><circle cx="14.5" cy="11.5" r="1.5"></circle>
                     </svg>
                        <h2>Comentarios acceptados</h2>
                    <?php  }else if($_GET['type'] === 'R'){ ?>
                        <div class="rex"><svg class='bx red' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 2H8C4.691 2 2 4.691 2 8v12a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 13c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v7z"></path><circle cx="9.5" cy="11.5" r="1.5"></circle><circle cx="14.5" cy="11.5" r="1.5"></circle>
                     </svg> </div>
                        <h2>Comentarios rechazados</h2>
                    <?php }?>
                </div>
                <div class="buttom-container">

                <?php if($_GET['type'] === 'A' || $_GET['type'] === 'R'){  ?>
                    <a class="enlaces" href="index.php?controller=comment&action=listComment&type=E&idWeblog=<?php echo (isset($_GET['idWeblog']) && !empty($_GET['idWeblog'])) ? $_GET['idWeblog']  :  null ;?>" title="Visualizar comentarios aceptados">
                        <button class="button-Rev2" >Comentarios en espera</button>
                    </a>
                    <?php }else{  ?>
                            <?php  
                                //var_dump($dataToView["data"]);
                                
                                if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' && count($dataToView["data"]["dataComment"]) > 0 ){ ?>
                                <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                            <?php  } ?>
                        <a class="enlaces" href="index.php?controller=comment&action=listComment&type=A&idWeblog=<?php echo (isset($_GET['idWeblog']) && !empty($_GET['idWeblog'])) ? $_GET['idWeblog']  :  null ;?>" title="Visualizar comentarios aceptados">
                            <button class="button-Rev2" >Aceptados</button>
                        </a>
                        <a class="enlaces" href="index.php?controller=comment&action=listComment&type=R&idWeblog=<?php echo (isset($_GET['idWeblog']) && !empty($_GET['idWeblog'])) ? $_GET['idWeblog']  :  null ;?>" title="Visualizar comentarios rechazados">
                            <button class="button-Rev2" >Rechazados</button>
                        </a>
                    <?php  } ?>
                </div>
            </div>
                   
                <table id="commentTable" class="display" style="width:100%">
                    <?php if (isset($dataToView["data"]["dataComment"]) && !empty($dataToView["data"]["dataComment"])) { ?>
                        <thead>
                            <tr>
                                <th>TiTulo</th>
                                <th>Comentario</th>
                                <th>Fecha de publicación</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataToView["data"]["dataComment"] as $data) { ?>
                                <tr>
                                    <td><?php echo $data['titleTrip'];  ?></td>
                                    <td  class="description">  <?php echo strlen($data['message']) > 100 ? substr($data['message'], 0, 100) . '...' : $data['message']; ?></td>
                                    <td>
                                        <?php
                                            $datetime = new DateTime($data['dataTime']);
                                            echo $datetime->format('d/m/Y h:i A');
                                        ?>
                                    </td>

                                    <td>
                                        <div class="dataTable-icon-center">
                                        <div title="Ver detalles" class="view-details" model='comment' id="<?php echo $data['idComment'] ?>">
                                            <?php echo DETAILS_ICON ?>                                
                                        </div>
                                            <?php if($_GET['type'] === 'E'){  ?>
                                                <a  title="Aceptar" class="acceptComment" href="index.php?controller=comment&action=commentAccept&id=<?php echo $data['idComment']; ?>&type=<?php echo $_GET['type']; ?>&idWeblog=<?php echo (isset($_GET['idWeblog']) && !empty($_GET['idWeblog'])) ? $_GET['idWeblog']  :  null ;?>" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="bx green icon-focus-options" width="30" height="30" viewBox="0 0 24 24">
                                                        <g fill="none" fill-rule="evenodd"> <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M21.546 5.111a1.5 1.5 0 0 1 0 2.121L10.303 18.475a1.6 1.6 0 0 1-2.263 0L2.454 12.89a1.5 1.5 0 1 1 2.121-2.121l4.596 4.596L19.424 5.111a1.5 1.5 0 0 1 2.122 0"/></g>
                                                    </svg>   
                                                </a>
                                                <a  title="Rechazar" class="rejectedComment" href="index.php?controller=comment&action=commentRejected&id=<?php echo $data['idComment']; ?>&type=<?php echo $_GET['type']; ?>&idWeblog=<?php echo (isset($_GET['idWeblog']) && !empty($_GET['idWeblog'])) ? $_GET['idWeblog']  :  null ;?>">
                                                    <svg class="icon-focus-options" xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24'>
                                                        <path fill='none' stroke='#d32f2f' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M18 6L6 18M6 6l12 12'/>
                                                    </svg>   
                                                </a> 
                                                <?php }else if($_GET['type'] === 'A'){  ?>
                                                    <a  title="Rechazar" class="rejectedComment" href="index.php?controller=comment&action=commentRejected&id=<?php echo $data['idComment']; ?>&type=<?php echo $_GET['type']; ?>&idWeblog=<?php echo (isset($_GET['idWeblog']) && !empty($_GET['idWeblog'])) ? $_GET['idWeblog']  :  null ;?>">
                                                        <svg class="icon-focus-options" xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24'>
                                                            <path fill='none' stroke='#d32f2f' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M18 6L6 18M6 6l12 12'/>
                                                        </svg>   
                                                    </a> 
                                                <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    <?php } ?>
                </table>
                    

            </div>
            
        </div>
    </div>


    <!--////////////////////////////////// Data Table //////////////////////////////////-->
    <script src="asset/js/scripts/dataTableDynamic.js"></script>

    <!--////////////////////////////////// Switc alert //////////////////////////////////-->
    <div id="alert" nameAlert=<?php echo json_encode($controller->response); ?> modelAlert="comment"></div>
    <script src="asset/js/scripts/alert.js"></script>

    <script src="asset\js\scripts\report.js" ></script>
</main>


        

 