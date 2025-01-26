<h1 align="center">Reservaciones</h1>
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
                if (isset($data[0]['title'])) {
                    echo '<th>Viaje</th>';
                }
                if (isset($data[0]['numberSlots'])) {
                    echo '<th>Cupos Reservados</th>';
                }
                if (isset($data[0]['reservationDate'])) {
                    echo '<th>Fecha de Reserva</th>';
                }
                if (isset($data[0]['amount'])) {
                    echo '<th>Precio Total Bs.S</th>';
                }
                if (isset($data[0]['confirmation'])) {
                    echo '<th>Confirmación</th>';
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
                if (isset($datas['title'])) {
                    echo "<td>" . $datas['title'] . "</td>";
                }    
                if (isset($datas['numberSlots'])) {
                    echo "<td>" . $datas['numberSlots'] . "</td>";
                }    
                if (isset($datas['reservationDate'])) {
                    echo "<td>" . date('d/m/Y', strtotime($datas['reservationDate'])) . "</td>";
                }    
                if (isset($datas['amount'])) {
                    echo "<td>" . $datas['amount'] . "</td>";
                }  
                if (isset($datas['confirmation'])) {
                    switch ($datas['confirmation']) {
                        case 'A':
                            echo "<td>Aceptado</td>";
                            break;
                        case 'B':
                            echo "<td>Borrado</td>";
                            break;
                        case 'E':
                            echo "<td>Espera</td>";
                            break;
                        case 'D':
                            echo "<td>Denegado</td>";
                            break;
                        case 'C':
                            echo "<td>Cancelado</td>";
                            break;
                        case 'R':
                            echo "<td>Realizado</td>";
                            break;
                        case 'Z':
                            echo "<td>Olvidado</td>";
                            break;
                        default:
                            echo "<td>Desconocido</td>";
                            break;
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