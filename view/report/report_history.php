<h1 align="center">Historial</h1>
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
                
                    if (isset($data[0]['email'])) {
                        echo '<th>Usuario</th>';
                    }
                    if (isset($data[0]['privilege'])) {
                        echo '<th>Privilegio</th>';
                    }
                    if (isset($data[0]['module'])) {
                        echo '<th>Módulo</th>';
                    }
                    if (isset($data[0]['action'])) {
                        echo '<th>Acción</th>';
                    }
                    if (isset($data[0]['registrationDate'])) {
                        echo '<th>Fecha</th>';
                    }
                    if (isset($data[0]['registrationTime'])) {
                        echo '<th>Hora</th>';
                    }
                ?>
                
            </tr>
        </thead>
        <tbody>
            
            <?php
                foreach ($data as $datas) {
                    echo "<tr>";
                    if (isset($datas['email'])) {
                        echo "<td>" . $datas['email'] . "</td>";
                    }   
                    if (isset($datas['privilege'])) {
                        
                        if ($datas['privilege'] == 'admin') { 
                            $datas['privilege'] = 'Administrador'; 
                        } 
                        
                        else if ($datas['privilege'] == 'publicista') { 
                            $datas['privilege'] = 'Publicista'; 
                        } 
                        
                        else {
                            $datas['privilege'] = 'Turista';
                        }
                        
                        echo "<td>" . $datas['privilege'] . "</td>";
                    }    
                    if (isset($datas['module'])) {
                        echo "<td>" . $datas['module'] . "</td>";
                    }    
                    if (isset($datas['action'])) {
                        echo "<td>" . $datas['action'] . "</td>";
                    }    
                    if (isset($datas['registrationDate'])) {
                        echo "<td>" . $datas['registrationDate'] . "</td>";
                    }    
                    if (isset($datas['registrationTime'])) {
                        echo "<td>" . date('h:i A', strtotime($datas['registrationTime'])) . "</td>";
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
