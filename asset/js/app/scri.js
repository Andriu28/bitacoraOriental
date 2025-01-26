document.querySelectorAll('.faq_button').forEach(button => {
    button.addEventListener('click', () => {
        const content = button.nextElementSibling;
        const icon = button.querySelector('.faq_icon');

        // Cierra todos los contenidos abiertos
        document.querySelectorAll('.faq_content').forEach(item => {
            if (item !== content) {
                item.style.maxHeight = '0'; // Cierra el contenido
                item.style.opacity = '0'; // Restablece la opacidad
                item.previousElementSibling.classList.remove('active'); // Quita la clase active
                item.previousElementSibling.querySelector('.faq_icon').style.transform = 'rotate(0deg)';
            }
        });

        // Alterna el contenido del botón actual
        if (content.style.maxHeight === '200px') { // Asegúrate de que este valor coincida con el max-height en CSS
            content.style.maxHeight = '0'; // Cierra el contenido
            content.style.opacity = '0'; // Restablece la opacidad
            icon.style.transform = 'rotate(0deg)'; // Restablece la rotación
            button.classList.remove('active'); // Quita la clase active
        } else {
            content.style.maxHeight = '200px'; // Abre el contenido
            content.style.opacity = '1'; // Cambia a opacidad 1
            icon.style.transform = 'rotate(-90deg)'; // Rota 90 grados hacia la izquierda
            button.classList.add('active'); // Agrega la clase active
        }
    });
});



//codigo para ocultar el icono de subir al menu

$(document).ready(function() {
    // Ocultar el botón al cargar la página
    $('.back-to-top').hide();

    // Mostrar/ocultar el botón al hacer scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() > 380) {
            $('.back-to-top').fadeIn();  // Muestra el botón
        } else {
            $('.back-to-top').fadeOut(); // Oculta el botón
        }
    });

    // Al hacer clic en el botón, vuelve al inicio de la página
    $('.back-to-top').click(function() {
        $("html, body").animate({ scrollTop: 0 }, 400); // Desplazamiento suave
        return false; // Previene el comportamiento por defecto del enlace
    });
});