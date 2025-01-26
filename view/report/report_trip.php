<h1 align="center">Viajes</h1>
<?php

if (isset($data[0]) && !empty($data[0])) {
    if (count($data[0]) > 12) {
        echo '<p class="nota">* El tamaño de la hoja es A3, Tome sus precausiones.</p>';
    }
}
?> 
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
                if (isset($data[0]['place'])) {
                    echo '<th>Lugar</th>';
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
                if (isset($data[0]['departureLocation'])) {
                    echo '<th>Ubicación Salida</th>';
                }
                if (isset($data[0]['departureDate'])) {
                    echo '<th>Fecha Salida</th>';
                }
                if (isset($data[0]['departureTime'])) {
                    echo '<th>Hora Salida</th>';
                }
                if (isset($data[0]['returnDate'])) {
                    echo '<th>Fecha Regreso</th>';
                }
                if (isset($data[0]['returnTime'])) {
                    echo '<th>Hora Regreso</th>';
                }
                if (isset($data[0]['numberSlots'])) {
                    echo '<th>Cantidad Permitida</th>';
                }
                if (isset($data[0]['vacant'])) {
                    echo '<th>Vacantes Disponibles</th>';
                }
                if (isset($data[0]['price'])) {
                    echo '<th>Precio Bs.S</th>';
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
                if (isset($datas['place'])) {
                    echo "<td>" . $datas['place'] . "</td>";
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
                if (isset($datas['departureLocation'])) {
                    echo "<td>" . $datas['departureLocation'] . "</td>";
                }    
                if (isset($datas['departureDate'])) {
                    echo "<td>" . date('d/m/Y', strtotime($datas['departureDate'])) . "</td>";
                }    
                if (isset($datas['departureTime'])) {
                    echo "<td>" . date('h:i A', strtotime($datas['departureTime'])) . "</td>";
                }    
                if (isset($datas['returnDate'])) {
                    echo "<td>" . date('d/m/Y', strtotime($datas['returnDate'])) . "</td>";
                }    
                if (isset($datas['returnTime'])) {
                    echo "<td>" . date('h:i A', strtotime($datas['returnTime'])) . "</td>";
                }    
                if (isset($datas['numberSlots'])) {
                    echo "<td>" . $datas['numberSlots'] . "</td>";
                }    
                if (isset($datas['vacant'])) {
                    echo "<td>" . $datas['vacant'] . "</td>";
                }    
                if (isset($datas['price'])) {
                    echo "<td>" . $datas['price'] . "</td>";
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