<h1 align="center">Usuarios</h1>
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
                    if (isset($data[0]['name'])) {
                        echo '<th>Nombre</th>';
                    }
                    if (isset($data[0]['email'])) {
                        echo '<th>Correo Electrónico</th>';
                    }
                    if (isset($data[0]['privilege'])) {
                        echo '<th>Privilegio</th>';
                    }
                    if (isset($data[0]['status'])) {
                        echo '<th>Estado</th>';
                    }
                    if (isset($data[0]['verified'])) {
                        echo '<th>Verificado</th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($data as $datas) {
                    echo "<tr>";
                    if (isset($datas['name'])) {
                        echo "<td>" . $datas['name'] . "</td>";
                    }    
                    if (isset($datas['email'])) {
                        echo "<td>" . $datas['email'] . "</td>";
                    }   
                    if (isset($datas['privilege'])) {
                        switch ($datas['privilege']) {
                            case 'admin':
                                echo "<td>Administrador</td>";
                                break;
                            case 'turista':
                                echo "<td>Turista</td>";
                                break;
                            case 'publicista':
                                echo "<td>Publicista</td>";
                                break;
                            default:
                                echo "<td>Desconocido</td>";
                                break;
                        }
                    }    
                    if (isset($datas['status'])) {
                        echo "<td>" . ($datas['status'] == 1 ? 'Activo' : 'Inactivo') . "</td>";
                    }    
                    if (isset($datas['verified'])) {
                        echo "<td>" . ($datas['verified'] == 1 ? 'Verificado' : 'No Verificado') . "</td>";
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