<h1 align="center">Rutas de Viaje</h1>
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
                    if (isset($data[0]['place'])) {
                        echo '<th>Lugar</th>';
                    }
                    if (isset($data[0]['location'])) {
                        echo '<th>Ubicación</th>';
                    }
                    if (isset($data[0]['parroquia'])) {
                        echo '<th>Parroquia</th>';
                    }
                    if (isset($data[0]['municipio'])) {
                        echo '<th>Municipio</th>';
                    }
                    if (isset($data[0]['estado'])) {
                        echo '<th>Estado</th>';
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
                    if (isset($datas['place'])) {
                        echo "<td>" . $datas['place'] . "</td>";
                    }    
                    if (isset($datas['location'])) {
                        echo "<td>" . $datas['location'] . "</td>";
                    }    
                    if (isset($datas['parroquia'])) {
                        echo "<td>" . $datas['parroquia'] . "</td>";
                    }    
                    if (isset($datas['municipio'])) {
                        echo "<td>" . $datas['municipio'] . "</td>";
                    }
                    if (isset($datas['estado'])) {
                        echo "<td>" . $datas['estado'] . "</td>";
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