 // Agregar evento de clic a las imágenes
 document.querySelectorAll('.image-checkbox').forEach(function(image) {
    image.addEventListener('click', function() {
        const checkbox = this.nextElementSibling; // Obtener el checkbox asociado
        const checkIcon = this.parentElement.querySelector('.check-icon'); // Obtener el icono de check

        // Alternar el estado del checkbox
        checkbox.checked = !checkbox.checked;

        // Mostrar u ocultar el icono de check según el estado del checkbox
        if (checkbox.checked) {
            checkIcon.style.display = 'flex'; // Mostrar el icono
            this.parentElement.classList.add('selected'); // Aplicar clase para cambiar la opacidad
        } else {
            checkIcon.style.display = 'none'; // Ocultar el icono
            this.parentElement.classList.remove('selected'); // Remover clase para restaurar opacidad
        }
    });
});

document.getElementById('images').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('imagePreviewContainer');
    previewContainer.innerHTML = ''; // Limpiar el contenedor previo
    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {

        const file = files[i];
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.width = 90; // Ajustar el ancho según sea necesario
            img.style.marginRight = '10px'; // Espaciado entre imágenes
            previewContainer.appendChild(img);
        };

        reader.readAsDataURL(file);
    }
});