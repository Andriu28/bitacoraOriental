<h1 align="center">Ofertas de Viaje</h1>
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
                  
                    if (isset($data[0]['tripTitle'])) {
                        echo '<th>Viaje</th>';
                    }
                    if (isset($data[0]['packageTitle'])) {
                        echo '<th>Tipo de Paquete</th>';
                    }
                    if (isset($data[0]['amount'])) {
                        echo '<th>Precio Bs.S</th>';
                    }
                    if (isset($data[0]['lodging'])) {
                        echo '<th>Alojamiento</th>';
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
                    if (isset($datas['tripTitle'])) {
                        echo "<td>" . $datas['tripTitle'] . "</td>";
                    }    
                    if (isset($datas['packageTitle'])) {
                        echo "<td>" . $datas['packageTitle'] . "</td>";
                    }   
                    if (isset($datas['amount'])) {
                        echo "<td>" . $datas['amount'] . "</td>";
                    }    
                    if (isset($datas['status'])) {
                        
                        if ($datas['status'] == '1') {
                            echo "<td>Activo</td>";
                        } elseif ($datas['status'] == '0') {
                            echo "<td>Cancelado</td>";
                        } elseif ($datas['status'] == 'D') {
                            echo "<td>Descartado</td>";
                        } elseif ($datas['status'] == 'R') {
                            echo "<td>Realizado</td>";
                        } elseif ($datas['status'] == 'C') {
                            echo "<td>Completado</td>";
                        } else {
                            echo "<td>Desconocido</td>";
                        }
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

