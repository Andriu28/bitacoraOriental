<h1 align="center">Personas</h1>
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
                    if (isset($data[0]['ci'])) {
                        echo '<th>Cédula</th>';
                    }
                    if (isset($data[0]['name'])) {
                        echo '<th>Nombre</th>';
                    }
                    if (isset($data[0]['lastName'])) {
                        echo '<th>Apellido</th>';
                    }
                    if (isset($data[0]['birthDate'])) {
                        echo '<th>Fecha de Nacimiento</th>';
                    }
                    if (isset($data[0]['phone'])) {
                        echo '<th>Teléfono</th>';
                    }
                    if (isset($data[0]['parroquia'])) {
                        echo '<th>Parroquia</th>';
                    }
                    if (isset($data[0]['address'])) {
                        echo '<th>Dirección</th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($data as $datas) {
                    echo "<tr>";
                        if (isset($datas['ci'])) {
                            echo "<td>" . $datas['ci'] . "</td>";
                        }
                        if (isset($datas['name'])) {
                            echo "<td>" . $datas['name'] . "</td>";
                        }    
                        if (isset($datas['lastName'])) {
                            echo "<td>" . $datas['lastName'] . "</td>";
                        }    
                        if (isset($datas['birthDate'])) {
                            echo "<td>" . date('d/m/Y', strtotime($datas['birthDate'])) . "</td>";
                        }      
                        if (isset($datas['phone'])) {
                            echo "<td>" . $datas['phone'] . "</td>";
                        }    
                        if (isset($datas['parroquia'])) {
                            echo "<td>" . $datas['parroquia'] . "</td>";
                        }    
                        if (isset($datas['address'])) {
                            echo "<td>" . $datas['address'] . "</td>";
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