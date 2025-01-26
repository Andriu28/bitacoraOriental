const toggleMenu = document.querySelector('.menuProfile');
const actionMenu = document.getElementById('profileMenuItem');
let hideTimeout;

function showMenu() {
    clearTimeout(hideTimeout);
    toggleMenu.classList.add('active');
}

function hideMenu() {
    hideTimeout = setTimeout(() => {
        toggleMenu.classList.remove('active');
    }, 350); // Ajusta el tiempo en milisegundos según tus necesidades
}

// Verifica si los elementos existen en el DOM antes de agregar los event listeners
if (toggleMenu && actionMenu) {
    actionMenu.addEventListener('mouseover', showMenu);
    actionMenu.addEventListener('mouseout', () => {
        if (!toggleMenu.matches(':hover')) {
            hideMenu();
        }
    });

    toggleMenu.addEventListener('mouseover', showMenu);
    toggleMenu.addEventListener('mouseout', () => {
        if (!actionMenu.matches(':hover')) {
            hideMenu();
        }
    });
}