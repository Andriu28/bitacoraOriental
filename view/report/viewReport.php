<?php 
if (!isset($_SESSION['user'])) {
    header("location:" . DEFAULT_ADDRESS_LOGOUT);
    exit(); // Asegurarse de que el script se detenga después de la redirección
}

?>
<main>
    <div class="contenedor-nuevo">
        <div class="caja-register">
            <div class="formulario-login-registro">

                
            <form target="_blank" method="POST" action="index.php?controller=reports&action=genReport">
                    <div class="btReset"  style="margin-bottom : 10px;">
                        <div class="header">
                            <svg class='bx green' xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6 21H3a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1zm7 0h-3a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v17a1 1 0 0 1-1 1zm7 0h-3a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1z"></path>
                            </svg>
                            <h2>Reportes</h2>
                        </div>
                        <img class="logis" width="75px" height="75px" src="asset/IconoBitacoraO/bitacora.jpg" alt="Logo" />
                    </div>
                <label for="">Modulo <span class="obligatorio">*</span></label>
                <select class="custom-select" name="table" id="tableSelect" onchange="updateDynamicFields()">
                    <option value="">Seleccione una opción</option>
                    <?php 
                    $jsonString = @file_get_contents('asset/json/modulos.json');
                    if ($jsonString === false) {
                        echo '<option value="">Error al cargar módulos</option>';
                    } else {
                        $module = json_decode($jsonString, true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            echo '<option value="">Error al decodificar JSON</option>';
                        } else {
                            foreach ($module as $key => $module) {
                                echo '<option value="' . $key . '">' . $module . '</option>';
                            }
                        }
                    }
                    ?>
                </select>

                <label for="dynamicFields" title="Si envía el formulario sin seleccionar un campo, se consultarán todos los campos de la opción seleccionada">
                    Campos 
                    <svg xmlns="http://www.w3.org/2000/svg" width="0.8em" height="0.8em" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M2.93 17.07A10 10 0 1 1 17.07 2.93A10 10 0 0 1 2.93 17.07m12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32M9 5h2v6H9zm0 8h2v2H9z"/>
                    </svg>
                </label>
                <div id="dynamicFields" style="display: grid; grid-template-columns: 1fr 2fr; gap: 5px 20px; margin-bottom: 20px;"></div>
                
                <div>
                    <h2 id="">Salida</h2>
                    <label for="fecha_inicio">Desde:</label>
                    <input class="input-box" type="date" name="starDate">
                    <label for="fecha_fin">Hasta:</label>
                    <input class="input-box" type="date" name="endDate">
                </div>
                <div>
                    <h2>Regreso</h2>
                    <label for="fecha_inicio">Desde:</label>
                    <input class="input-box" type="date" name="startReturn">
                    <label for="fecha_fin">Hasta:</label>
                    <input class="input-box" type="date" name="endReturn">

                </div>
                <div class="text-grey">
                    <p>Todos los campos con <span class="obligatorio">*</span> son obligatorios</p>
                </div>
                <input class="button-login-register" type="submit" value="Generar PDF" >
            </form>
            <div id="alert" nameAlert=<?php echo json_encode($controller->response) ?> modelAlert="faq"></div>
            </div>
        </div>
    </div>
</main>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        updateDynamicFields(); // Inicializar campos dinámicos si ya hay una selección
    });
    document.querySelector('form').addEventListener('submit', function(event) {
        const tableSelect = document.getElementById('tableSelect');
        if (tableSelect.value === '') {
            alert('Por favor, seleccione una opción antes de enviar el formulario.');
            event.preventDefault(); // Evitar el envío del formulario
        }
    });

    function updateDynamicFields() {
        const tableSelect = document.getElementById('tableSelect');
        const selectedValue = tableSelect.value;
       

        fetch('asset/json/campos.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar campos');
                }
                return response.json();
            })
            .then(data => {
                const dynamicFields = document.getElementById('dynamicFields');
                dynamicFields.innerHTML = ''; // Limpiar campos dinámicos anteriores
                if (data[selectedValue]) {
                    const fields = data[selectedValue][0];
                    for (const key in fields) {
                        if (fields.hasOwnProperty(key)) {
                            const div = document.createElement('div');
                            const label = document.createElement('label');
                            label.style.marginRight = '5px';
                            label.textContent = key;
                            const input = document.createElement('input');
                            input.className = 'camp';
                            input.id = 'query';
                            input.name = 'camp[]';
                            input.value = fields[key];
                            input.type = 'checkbox';
                            div.appendChild(label);
                            div.appendChild(input);
                            dynamicFields.appendChild(div);
                        }
                    }
                } else {
                    console.error('La clave dinámica no existe en el array de datos.');
                }
            })
            .catch(error => console.error('Error fetching JSON:', error));



        const startDateInput = document.querySelector('input[name="starDate"]');
        const endDateInput = document.querySelector('input[name="endDate"]');
        const starInput = document.querySelector('input[name="startReturn"]');
        const endInput = document.querySelector('input[name="endReturn"]');

        if (selectedValue !== 'trip' && selectedValue !== 'reservation') {
            startDateInput.disabled = true;
            endDateInput.disabled = true;
            starInput.disabled = true;
            endInput.disabled = true;
            startDateInput.style.backgroundColor = '#e0e0e0';
            endDateInput.style.backgroundColor = '#e0e0e0';
            starInput.style.backgroundColor = '#e0e0e0';
            endInput.style.backgroundColor = '#e0e0e0';
            startDateInput.style.color = '#a0a0a0';
            endDateInput.style.color = '#a0a0a0';
            starInput.style.color = '#a0a0a0';
            endInput.style.color = '#a0a0a0';
            startDateInput.title = 'Disponible solo para la opcion de "Viajes" y "Reservaciones".';
            endDateInput.title = 'Disponible solo para la opcion de "Viajes" y "Reservaciones".';
            
        } else if (selectedValue == 'trip') {
            
            startDateInput.disabled = false;
            endDateInput.disabled = false;
            starInput.disabled = false;
            endInput.disabled = false;
            startDateInput.style.backgroundColor = '';
            endDateInput.style.backgroundColor = '';
            starInput.style.backgroundColor = '';
            endInput.style.backgroundColor = '';
            startDateInput.style.color = '';
            endDateInput.style.color = '';
            starInput.style.color = '';
            endInput.style.color = '';
            startDateInput.title = '';
            endDateInput.title = '';
            
        } else {
            startDateInput.disabled = false;
            endDateInput.disabled = false;
            starInput.disabled = true;
            endInput.disabled = true;
            startDateInput.style.backgroundColor = '';
            endDateInput.style.backgroundColor = '';
            starInput.style.backgroundColor = '#e0e0e0';
            endInput.style.backgroundColor = '#e0e0e0';
            startDateInput.style.color = '';
            endDateInput.style.color = '';
            starInput.style.color = '#a0a0a0';
            endInput.style.color = '#a0a0a0';
            startDateInput.title = '';
            endDateInput.title = '';
        }
        
        

// Agregar un evento para validar la relación entre startDateInput y endDateInput
startDateInput.addEventListener('change', function() {
    if (startDateInput.value > endDateInput.value) {
       // endDateInput.value = startDateInput.value; // Ajustar endDateInput si es menor que startDateInput
    }
    endDateInput.setAttribute('min', startDateInput.value); // Establecer el mínimo de endDateInput
});

endDateInput.addEventListener('change', function() {
    if (endDateInput.value < startDateInput.value) {
       // startDateInput.value = endDateInput.value; // Ajustar startDateInput si es mayor que endDateInput
    }
    startDateInput.setAttribute('max', endDateInput.value); // Establecer el máximo de startDateInput
});

starInput.addEventListener('change', function() {
    if (starInput.value > endInput.value) {
       // endInput.value = starInput.value; // Ajustar endDateInput si es menor que startDateInput
    }
    endInput.setAttribute('min', starInput.value); // Establecer el mínimo de endDateInput
});

endInput.addEventListener('change', function() {
    if (endInput.value < starInput.value) {
       // starInput.value = endInput.value; // Ajustar startDateInput si es mayor que endDateInput
    }
    starInput.setAttribute('max', endInput.value); // Establecer el máximo de startDateInput
});

    
}
</script>