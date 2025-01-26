<?php if(!isset($_SESSION['user'])) header("location:" . DEFAULT_ADDRESS_LOGOUT); ?>
<link rel="stylesheet" href="asset/css/adashboard.css">
<main>
    <div class="bottom-data">
        <div>
          
        <div class="header">
                <div class="titleModule">
                    <svg  class='bx  <?php echo ($_GET['status'] === '1') ? 'green' : 'red'; ?>' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path>
                    </svg>
                    <h2>Usuarios <?php echo $_GET['userType']; ?>s <?php echo ($_GET['status'] === '1') ? ' habilitados' : ' Inhabilitados'; ?></h2>
                </div>
                <div class="buttom-container">
                   
                <?php  if( isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin' &&count($dataToView["data"]) > 0 ){ ?>
                         <a title="Descagar PDF" target="_blank" href="index.php?controller=reports&action=report" id="getDataButton"><?php echo PDF_ICON; ?></a>
                    <?php  } ?>
                    <div id="user">
                    <select  class="custom-select" id="menu-listUser" name="menu-listUser" onchange="redirigir(this)">
                        <option value="#"><a href="#">Tipo de usuario...</a></option>
                        <option value="index.php?controller=users&action=list&userType=publicista&status=1"><a href="">Usuarios Publicistas Habilitados</a></option>
                        <option value="index.php?controller=users&action=list&userType=publicista&status=0"><a href="#">Usuarios Publicistas Inhabilitados</a></option>
                        <option value="index.php?controller=users&action=list&userType=turista&status=1"><a href="#">Usuarios Turistas Habilitados</a></option>
                        <option value="index.php?controller=users&action=list&userType=turista&status=0"><a href="#">Usuarios Turistas Inhabilitados</a></option>
                    </select>
                    </div>
                    <a  href="index.php?controller=users&action=registerPublicist" title="Registrar un usuario publicista"><button class="button-Rev2">Registrar usuario publicista</button></a>
          
                </div>
            </div>




            <div class="header">
                <div class="left">
                   
                </div>
            </div>
            <div>
                <br>
                <div class="rift">
                    
                
                </div>
             
                <table id="userTable" class="display" style="width:100%">
                    <?php if (count($dataToView["data"]) > 0) { ?>
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Teléfono</th>
                                <th>Correo</th>                                
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataToView["data"] as $data) { ?>
                                <tr>   
                                <td>
                                    <?php
                                        $formattedCi = number_format($data['ci'], 0, '', '.');
                                        echo $formattedCi;
                                    ?>
                                    </td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['lastName']; ?></td>
                                    <td><?php echo $data['phone']; ?></td>
                                    <td><?php echo $data['email']; ?></td>                                    
                                    <td>
                                        <div class="dataTable-icon-center">
                                            <div title="Ver detalles" class="view-details" model='users' id="<?php echo $data['idUser'] ?>">
                                                <?php echo DETAILS_ICON ?>   
                                            </div>

                                            <a class="passwordChangeAlert icon-focus-options"  title="Cambiar contraseña" href="index.php?controller=users&action=changePasswordByAdmin&id=<?php echo $data['idUser'] ?>&userType=<?php echo $_GET['userType'] ?>&status=<?php echo $_GET['status'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="#f0a00d" d="M2 10.5A4.5 4.5 0 0 1 6.5 6h19a4.5 4.5 0 0 1 4.5 4.5v11a4.5 4.5 0 0 1-4.5 4.5h-19A4.5 4.5 0 0 1 2 21.5zm5.707 2.793a1 1 0 0 0-1.414 1.414L7.586 16l-1.293 1.293a1 1 0 1 0 1.414 1.414L9 17.414l1.293 1.293a1 1 0 0 0 1.414-1.414L10.414 16l1.293-1.293a1 1 0 0 0-1.414-1.414L9 14.586zm6.086 0a1 1 0 0 0 0 1.414L15.086 16l-1.293 1.293a1 1 0 0 0 1.414 1.414l1.293-1.293l1.293 1.293a1 1 0 0 0 1.414-1.414L17.914 16l1.293-1.293a1 1 0 0 0-1.414-1.414L16.5 14.586l-1.293-1.293a1 1 0 0 0-1.414 0M22 17a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2z"/></svg>
                                            </a>
                                            <?php if ($_GET['status'] === '1') { ?>     
                                                
                                                <a href="index.php?controller=users&action=editUser&id=<?php echo $data['idUser']; ?>">
                                                    <svg class="bx green icon-focus-options" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24"><path fill="currentColor" d="m21.7 13.35l-1 1l-2.05-2.05l1-1a.55.55 0 0 1 .77 0l1.28 1.28c.21.21.21.56 0 .77M12 18.94l6.06-6.06l2.05 2.05L14.06 21H12zM12 14c-4.42 0-8 1.79-8 4v2h6v-1.89l4-4c-.66-.08-1.33-.11-2-.11m0-10a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4"/></svg>
                                                </a>    
                                                <div class="rex">
                                                <a class="ban" href="index.php?controller=users&action=status&opc=disable&id=<?php echo $data['idUser']; ?>&userType=<?php echo $_GET['userType']; ?>&status=<?php echo $_GET['status']; ?>" title="Banear">                                            
                                                    <svg class="bx red icon-focus-options" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24"><path fill="currentColor" d="M10 4a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4m7.5 9C15 13 13 15 13 17.5s2 4.5 4.5 4.5s4.5-2 4.5-4.5s-2-4.5-4.5-4.5M10 14c-4.42 0-8 1.79-8 4v2h9.5a6.5 6.5 0 0 1-.5-2.5a6.5 6.5 0 0 1 .95-3.36c-.63-.08-1.27-.14-1.95-.14m7.5.5c1.66 0 3 1.34 3 3c0 .56-.15 1.08-.42 1.5L16 14.92c.42-.27.94-.42 1.5-.42M14.92 16L19 20.08c-.42.27-.94.42-1.5.42c-1.66 0-3-1.34-3-3c0-.56.15-1.08.42-1.5"/></svg>
                                                </a> 
                                                </div>                                                                                                                             
                                            <?php } else { ?>                                       
                                                <a class="desban" href="index.php?controller=users&action=status&opc=enable&id=<?php echo $data['idUser']; ?>&userType=<?php echo $_GET['userType']; ?>&status=<?php echo $_GET['status']; ?>" title="desbanear">
                                                    <svg class="bx green icon-focus-options"  xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24"><path fill="currentColor" d="m21.1 12.5l1.4 1.41l-6.53 6.59L12.5 17l1.4-1.41l2.07 2.08zM10 17l3 3H3v-2c0-2.21 3.58-4 8-4l1.89.11zm1-13a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4"/></svg>
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
    <div id="alert" nameAlert=<?php echo json_encode($controller->response); ?> modelAlert="users"></div>
    <script src="asset/js/scripts/alert.js"></script>
    <script src="asset\js\scripts\report.js" ></script>

</main>


        

 