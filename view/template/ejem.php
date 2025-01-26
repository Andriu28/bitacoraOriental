<h2>holaaaaaaaaaaaaaa</h2>





<form id="formComment">
    <label for="commentMessage">Comentario</label>
    <span class="help-icon" data-tooltip='El comentario debe tener solo caracteres especiales permitidos. &#10;Ejemplo: - () @ $ . , ! ¡ ¿ ?'><?php echo HELP_ICON; ?></span>
    <textarea name="commentMessage" id="commentMessage"></textarea>
    <input type="hidden" value="1" name="idWebLog" id="idWebLog">
    <input type="hidden" value="5" name="idUser" id="idUser">
    <div class="errorMessage" id="commentMessageError" ></div>
    <input type="submit" value="Enviar comentario">
</form>


<script src="asset/js/scripts/helpForm.js"></script>

<div id="alert" nameAlert=<?php echo htmlspecialchars(json_encode($controller->response), ENT_QUOTES, 'UTF-8'); ?> modelAlert="home"></div>
<script src="asset/js/scripts/alert.js"></script>



