<h1 align="center">Paquetes de Viaje</h1>
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
                    if (isset($data[0]['transport'])) {
                        echo '<th>Transporte</th>';
                    }
                    if (isset($data[0]['food'])) {
                        echo '<th>Comida</th>';
                    }
                    if (isset($data[0]['lodging'])) {
                        echo '<th>Alojamiento</th>';
                    }
                    if (isset($data[0]['price'])) {
                        echo '<th>Precio</th>';
                    }
                    if (isset($data[0]['status'])) {
                        echo '<th>Estado</th>';
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
                    if (isset($datas['transport'])) {
                        echo "<td>" . $datas['transport'] . "</td>";
                    }    
                    if (isset($datas['food'])) {
                        echo "<td>" . $datas['food'] . "</td>";
                    }    
                    if (isset($datas['lodging'])) {
                        echo "<td>" . $datas['lodging'] . "</td>";
                    }    
                    if (isset($datas['price'])) {
                        echo "<td>" . $datas['price'] . "</td>";
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
