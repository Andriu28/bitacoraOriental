<h1 align="center">Publicaciones Especiales</h1>
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
                    if (isset($data[0]['title'])) {
                        echo '<th>Título</th>';
                    }
                    if (isset($data[0]['description'])) {
                        echo '<th>Descripción</th>';
                    }
                    if (isset($data[0]['status'])) {
                        echo '<th>Estatus</th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($data as $datas) {
                    echo "<tr>";
                    if (isset($datas['title'])) {
                        echo "<td>" . $datas['title'] . "</td>";
                    }    
                    if (isset($datas['description'])) {
                        echo "<td>" . $datas['description'] . "</td>";
                    }    
                    if (isset($datas['status'])) {
                        echo "<td>" . ($datas['status'] == 1 ? 'Habilitado' : 'Deshabilitado') . "</td>";
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