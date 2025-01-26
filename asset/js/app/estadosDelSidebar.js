document.addEventListener('DOMContentLoaded', function() {
    const sideMenu = document.querySelector('.side-menu');
    const sideMenuLis = document.querySelectorAll('.side-menu li');

    // Función para obtener el controlador de la URL
    function getControllerFromURL(url) {
        const urlParams = new URLSearchParams(url.split('?')[1]); // Obtiene los parámetros de la URL
        return urlParams.get('controller'); // Retorna el valor del parámetro 'controller'
    }

    // Función para establecer el enlace activo
    function setActiveLink() {
        const currentController = getControllerFromURL(window.location.href); // Obtiene el controlador actual

        sideMenuLis.forEach(li => {
            const link = li.querySelector('a');
            const linkController = getControllerFromURL(link.href); // Obtiene el controlador del enlace

            if (linkController === currentController) {
                li.classList.add('active'); // Agrega la clase active al li
            } else {
                li.classList.remove('active'); // Remueve la clase active del li
            }
        });
    }

    // Establece el enlace activo al cargar la página
    setActiveLink();

    // Delegación de eventos para manejar clics en los enlaces
    sideMenu.addEventListener('click', function(event) {
        if (event.target.matches('.side-menu a')) {
            const clickedLink = event.target;
            const clickedController = getControllerFromURL(clickedLink.href); // Obtiene el controlador del enlace clicado

            sideMenuLis.forEach(li => {
                const link = li.querySelector('a');
                const linkController = getControllerFromURL(link.href); // Obtiene el controlador de cada enlace

                // Remueve la clase active de todos los li
                li.classList.remove('active');

                // Agrega la clase active solo al li que coincide con el controlador clicado
                if (linkController === clickedController) {
                    li.classList.add('active');
                }
            });

            localStorage.setItem('activeLink', clickedLink.href); // Guarda el enlace activo en localStorage
        }
    });
});
