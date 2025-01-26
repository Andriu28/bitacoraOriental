const menuBar = document.querySelector('.content nav .bx.bx-menu');
const sideBar = document.querySelector('.sidebar');

// Verificar que sideBar no sea null
if (sideBar !== null) {
    // Verificar el estado de la barra lateral en localStorage al cargar
    if (localStorage.getItem('sidebarClosed') === 'true') {
        sideBar.classList.add('close'); // Agregar la clase 'close' si estaba cerrada
    }

    // Verificar que menuBar no sea null
    if (menuBar !== null) {
        // Listener de evento para el clic en el menú
        menuBar.addEventListener('click', () => {
            sideBar.classList.toggle('close'); // Alternar la visibilidad de la barra lateral

            // Guardar el estado de la barra lateral en localStorage
            if (sideBar.classList.contains('close')) {
                localStorage.setItem('sidebarClosed', 'true'); // La barra lateral está cerrada
            } else {
                localStorage.setItem('sidebarClosed', 'false'); // La barra lateral está abierta
            }
        });
    } 
} 



// Listener para el evento de redimensionar la ventana
window.addEventListener('resize', () => {
    const sideBar = document.querySelector('.sidebar');
    
    // Verificar que sideBar no sea null
    if (sideBar !== null) {
        if (window.innerWidth < 768) {
            sideBar.classList.add('close');
        } else {
            sideBar.classList.remove('close');
        }
    } 
    
});

// Verificación del tema y el modo oscuro
document.addEventListener('DOMContentLoaded', function () {
    const toggler = document.getElementById('theme-toggle');

    // Verificar que toggler no sea null
    if (toggler !== null) {
        toggler.addEventListener('change', function () {
            const swalPopup = document.querySelector('.swal2-container .swal2-popup');

            // Verificar que swalPopup no sea null
            if (swalPopup !== null) {
                if (this.checked) {
                    // Activar el modo oscuro
                    document.body.classList.add('dark');
                } else {
                    // Desactivar el modo oscuro
                    document.body.classList.remove('dark');
                }
            } 
        });
    } 
});

// Verificación del popup y el modo oscuro
document.addEventListener('DOMContentLoaded', function () {
    const toggler = document.getElementById('theme-toggle');

    // Verificar que toggler no sea null
    if (toggler !== null) {
        toggler.addEventListener('change', function () {
            // Seleccionamos el elemento popup
            const swalPopup = document.querySelector('div:where(.swal2-container) div:where(.swal2-popup)');

            // Verificar que swalPopup no sea null
            if (swalPopup !== null) {
                if (this.checked) {
                    // Activar el modo oscuro
                    swalPopup.style.setProperty('background', '#3a3a3a', 'important');
                    swalPopup.style.setProperty('color', '#d7d7d7', 'important');
                } else {
                    // Desactivar el modo oscuro
                    // Restaurar estilos originales (puedes especificar colores claros)
                    swalPopup.style.setProperty('background', '', ''); // Eliminar el estilo específico
                    swalPopup.style.setProperty('color', '', ''); // Eliminar el estilo específico
                }
            } 
        });
    } 
});

// Mantener el estado activo del sidebar
document.addEventListener('DOMContentLoaded', () => {
    const sidebarMenu = document.getElementById('sidebar-employee') ? document.getElementById('sidebar-employee') : null;
    if(sidebarMenu !== null){
        const activeOption = sidebarMenu.getAttribute('activeOption') ? sidebarMenu.getAttribute('activeOption') : null;    
        if(activeOption !== null && activeOption !== 'none' ){
           const fucusOption = document.getElementById(activeOption)? document.getElementById(activeOption) : null ;
            if (fucusOption) {
                fucusOption.classList.add('active');
            }
        }
    }
});

// Guardar el estado del modo oscuro
document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');

    // Verificar que themeToggle no sea null
    if (themeToggle !== null) {
        themeToggle.checked = localStorage.getItem('themeToggle') === 'true';
        document.body.classList.toggle('dark', themeToggle.checked);

        themeToggle.addEventListener('change', () => {
            localStorage.setItem('themeToggle', themeToggle.checked);
            document.body.classList.toggle('dark', themeToggle.checked);
        });
    } 
});

document.addEventListener('DOMContentLoaded', function() {
    // Obtener las referencias a los elementos
    const imageContainer = document.getElementById('image_container');
    const imgElement = document.getElementById('responsive_image');
    const imgTarget = document.getElementById('img');

    // Función para verificar el tamaño de la pantalla y mover la imagen si es necesario
    function checkScreenSize() {
        // Verificar si los elementos existen antes de manipularlos
        if (imageContainer && imgElement && imgTarget) {
            if (window.innerWidth <= 768) {
                if (imageContainer.contains(imgElement)) {
                    imgTarget.appendChild(imgElement);
                }
            } else {
                if (imgTarget.contains(imgElement)) {
                    imageContainer.appendChild(imgElement);
                }
            }
        } 
    }

    // Añadir listener para redimensionar la ventana
    window.addEventListener('resize', checkScreenSize);
    checkScreenSize(); // Verificar inicialmente al cargar la página
});


