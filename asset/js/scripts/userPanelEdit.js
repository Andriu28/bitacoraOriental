
 

document.addEventListener('DOMContentLoaded', function () {
    const editBtn = document.getElementById('editBtn');
    const form = document.getElementById('formRegister');
    const inputs = form.querySelectorAll('input, select');
    const formButtons = document.getElementById('formButtons');
    const cancelBtn = document.getElementById('cancelBtn');

    // Obtener el select de municipio
    const selectMunicipio = document.getElementById("municipio");

    // Obtener el select de parroquia
    const selectParroquia = document.getElementById("parroquia");

    const textMunicipio = selectMunicipio.options[selectMunicipio.selectedIndex].text;
    const textParroquia = selectParroquia.options[selectParroquia.selectedIndex].text;

    // Mostrar el botón de editar por defecto y ocultar los botones de guardar y cancelar
    editBtn.style.display = 'block';
    formButtons.style.display = 'none';

    editBtn.addEventListener('click', function () {
        inputs.forEach(input => input.disabled = false);
        formButtons.style.display = 'flex';
        editBtn.style.display = 'none';
    });

    cancelBtn.addEventListener('click', function () {
        // Reiniciar el select de parroquia
        if (selectParroquia.options.length > 0) {
            selectParroquia.innerHTML = ""; // Vaciar todas las opciones
            const firstOptionParroquia = document.createElement("option");
            firstOptionParroquia.text = textParroquia;
            selectParroquia.add(firstOptionParroquia); // Añadir solo la primera opción
        }
        
        // Reiniciar el select de municipio
        if (selectMunicipio.options.length > 0) {
            selectMunicipio.innerHTML = ""; // Vaciar todas las opciones
            const firstOptionMunicipio = document.createElement("option");
            firstOptionMunicipio.text = textMunicipio;
            selectMunicipio.add(firstOptionMunicipio); // Añadir solo la primera opción
        }

        inputs.forEach(input => input.disabled = true);
        formButtons.style.display = 'none';
        editBtn.style.display = 'block';

        // Restablecer los valores originales
        form.reset();
    });
});
