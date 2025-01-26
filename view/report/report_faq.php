<h1 align="center">Preguntas Frecuentes</h1>
<p align="right ">
    <?php             
        $region = date_default_timezone_get();
        date_default_timezone_set($region);
        echo "Fecha y Hora: " . date('d/m/Y h:i:s A');
    ?>
</p>
<?php if (isset($data[0])) { ?>
    
    <table>
        <thead>
            <tr>
                <?php 
                    if (isset($data[0]['query'])) {
                        echo '<th>Pregunta</th>';
                    }
                    if (isset($data[0]['respond'])) {
                        echo '<th>Respuesta</th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($data as $datas) {
                    echo "<tr>";
                    if (isset($datas['query'])) {
                        echo "<td>" . $datas['query'] . "</td>";
                    }    
                    if (isset($datas['respond'])) {
                        echo "<td>" . $datas['respond'] . "</td>";
                    }    
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>

<?php } else { ?>
<hr>
<h1 align="center" style="font-size: xxx-large;">No hay registros disponibles</h1>
 <?php } ?> 
</body>
</html>
