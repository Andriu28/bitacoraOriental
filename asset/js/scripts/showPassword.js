// Inputs de la contraseña
const passwordInput = document.getElementById('password') ? document.getElementById('password') : null;
const repPasswordInput = document.getElementById('repPassword') ? document.getElementById('repPassword') : null;

// Caja que contiene el icono
const togglePassword = document.getElementById('togglePassword') ? document.getElementById('togglePassword') : null;
const toggleRepPassword = document.getElementById('toggleRepPassword') ? document.getElementById('toggleRepPassword') : null;

function togglePasswordVisibility(input, toggle) {
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);

    // Cambiar icono del botón y el título
    if (type === 'password') {
        toggle.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.282 21.782l4.278-4.278M21.782 3.282L17.673 7.39m-3.363 3.363a2.64 2.64 0 0 0-1.063-1.063a2.625 2.625 0 1 0-2.494 4.62m3.557-3.557l-3.557 3.557m3.557-3.557l3.363-3.363m-6.92 6.92L7.56 17.504M17.673 7.39c-.38-.319-.791-.621-1.232-.894C15.2 5.726 13.717 5.19 12 5.19c-4.956 0-7.948 4.459-8.91 6.16c-.11.196-.165.293-.197.446a1.2 1.2 0 0 0 0 .408c.032.152.088.25.198.445c.51.903 1.593 2.582 3.237 3.96c.38.319.791.621 1.232.895m12.18-7.925c.528.694.919 1.328 1.17 1.773c.11.194.165.292.197.444c.023.112.023.296 0 .408c-.032.152-.087.25-.197.444c-.96 1.702-3.95 6.162-8.91 6.162q-.714-.002-1.374-.117"/>
            </svg>
        `;
        toggle.setAttribute('title', 'Mostrar contraseña');
    } else {
        toggle.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="#000" d="M5.09 14.781c1.749 1.368 3.219 1.806 4.91 1.806c1.471 0 3.391-.613 5.238-1.919c1.332-.942 2.433-2.315 3.3-4.13q-1.41-2.447-3.263-4.013c-1.71-1.448-3.582-2.112-5.312-2.112c-1.79 0-3.85.798-5.608 2.474q-1.898 1.81-2.88 3.638q1.598 2.682 3.614 4.256M10 18c-1.974 0-3.735-.525-5.741-2.094q-2.365-1.85-4.164-5a.72.72 0 0 1-.021-.678Q1.176 7.99 3.42 5.851C5.438 3.928 7.833 3 9.963 3c2.043 0 4.223.775 6.184 2.434q2.173 1.84 3.763 4.722c.11.198.12.439.027.645c-.988 2.2-2.295 3.882-3.921 5.032C13.94 17.3 11.749 18 9.999 18m.234-3.6a3.7 3.7 0 1 1 0-7.4a3.7 3.7 0 0 1 0 7.4m0-1.4a2.3 2.3 0 1 0 0-4.6a2.3 2.3 0 0 0 0 4.6"/></svg>
        `;
        toggle.setAttribute('title', 'Ocultar contraseña');
    }
}

if (togglePassword !== null) { // evento para mostrar/ocultar la contraseña
    togglePassword.addEventListener('click', function () {
        togglePasswordVisibility(passwordInput, togglePassword);
    });
}

if (toggleRepPassword !== null) { // evento para mostrar/ocultar la repetición de la contraseña
    toggleRepPassword.addEventListener('click', function () {
        togglePasswordVisibility(repPasswordInput, toggleRepPassword);
    });
}


