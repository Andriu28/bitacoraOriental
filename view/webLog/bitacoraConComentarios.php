<!-- Contenedor Principal -->
<main class="rs">
<div class="reservacion">
    <!-- boton para regresar -->
<div class="comments-container">
        <div class="back-button-container">
            <a  title="Regresar" href="index.php?controller=webLog&action=getBitacora" >
                <?php echo portalReturn ?><!-- SVG -->
            </a>
        </div>
        <div class="titleModule">
             <div class="header">
                <div class="titleModule">
                 
                    <svg class='bx bx_comment' xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 2H8C4.691 2 2 4.691 2 8v12a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 13c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v7z"></path><circle cx="9.5" cy="11.5" r="1.5"></circle><circle cx="14.5" cy="11.5" r="1.5"></circle>
                     </svg>
                     <h1>Comentarios</h1>
                    
                </div>
               
            </div>   
        </div> 


    <ul id="comments-list" class="comments-list">
    <?php if (isset($dataToView["data"]["dataComment"]) && !empty($dataToView["data"]["dataComment"])) {
        ?>
                        
        <?php foreach ($dataToView["data"]["dataComment"] as $data) { ?>
                                
        <li>
            <div class="comment-main-level">
                <!-- Avatar -->
                <div class="comment-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" class="bx blue_green" width="60" height="60" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4"/></svg>
                </div>
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name"><?php echo $data['name'] ?> <?php echo $data['lastName']; ?></a></h6>
                        <span><?php
                            $dateTime = new DateTime($data["dataTime"]);
                            echo $dateTime->format('d/m/Y h:i A');
                            ?>
                        </span>
                        
                        
                    </div>
                    <div class="comment-content">
                    <?php echo ucfirst($data['message']); ?>

                    </div>
                </div>
            </div>
        </li>

                                    
        <?php } ?>
    <?php } ?>
        
    </ul>
</div>

                       

    <section>
        <h1>Deja un comentario</h1>
        <form id="formComment">
            <label for="commentMessage">Comentario</label>
            <span class="help-icon" data-tooltip='El comentario debe tener solo caracteres especiales permitidos. &#10;Ejemplo: - () @ $ . , ! ¡ ¿ ?'><?php echo HELP_ICON; ?></span>
            <textarea name="commentMessage" id="commentMessage"></textarea>
            <input type="hidden" value="<?php echo $_GET['id']?>" name="idWebLog" id="idWebLog">
            <input type="hidden" value="<?php echo $sessionData['user']['idUser']?>" name="idUser" id="idUser">
            <div class="errorMessage" id="commentMessageError" ></div>
            <input class="btn" title="Enviar comentario" type="submit" value="Enviar comentario">
        </form>

        <script src="asset/js/scripts/helpForm.js"></script>

        <div id="alert" nameAlert=<?php echo htmlspecialchars(json_encode($controller->response), ENT_QUOTES, 'UTF-8'); ?> modelAlert="home"></div>
        <script src="asset/js/scripts/alert.js"></script>


    </section>


</div>
 </main>
