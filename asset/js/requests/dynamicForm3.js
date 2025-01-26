// Variable para llevar un seguimiento de la sección actual de los formularios de menores
let currentMinorSection = 0;

// Array para almacenar los datos de los menores
let minorData = [];

// Datos del usuario, extraídos del servidor mediante PHP
let userData = {
    name: "<?php echo $_SESSION['user']['name']; ?>",
    lastName: "<?php echo $_SESSION['user']['lastName']; ?>",
    ci: "<?php echo $_SESSION['user']['ci']; ?>"
};

// Función para extraer los datos del usuario desde el HTML
function extractUserData() {
    const includeUserElem = document.getElementById('user_yes'); // Elemento checkbox para incluir al usuario
    const includeUser = includeUserElem && includeUserElem.checked; // Verificar si el usuario está incluido

    if (!includeUser) {
        return null; // Si el usuario no está incluido, devolver null
    }

    // Extraer los datos del usuario desde el HTML
    return {
        name: document.getElementById('user_name').value,
        lastName: document.getElementById('user_lastName').value,
        ci: document.getElementById('user_ci').value
    };
}

// Función para actualizar los selectores de "Responsable del niño"
function updateResponsibleSelects() {
    const responsibleSelects = document.querySelectorAll('select[name^="responsibleMinor"]'); // Seleccionar todos los selectores de "responsableMinor"
    const userData = extractUserData(); // Extraer los datos del usuario

    responsibleSelects.forEach((select, index) => {
        if (!select) return;  // Asegurarse de que el select existe

        // Guardar el valor seleccionado
        const selectedValue = select.value;

        // Limpiar opciones previas
        select.innerHTML = `<option value="">Seleccione</option>`;

        // Añadir el usuario como opción si va al viaje
        if (userData) {
            select.innerHTML += `<option value="${userData.ci}">${userData.name} ${userData.lastName}</option>`;
        }

        // Añadir los pasajeros como opciones
        passengerData.forEach(passenger => {
            select.innerHTML += `<option value="${passenger.ci}" ${minorData[index] && minorData[index].responsible === passenger.ci ? 'selected' : ''}>${passenger.name} ${passenger.lastName}</option>`;
        });

        // Restaurar el valor seleccionado si existe en las nuevas opciones
        if (Array.from(select.options).some(option => option.value === selectedValue)) {
            select.value = selectedValue;
        } else {
            select.value = "";
        }
    });
}



// Función para generar los formularios de menores
function generateMinorForms() {

    const numChildrenElem = document.getElementById('numChildren');
    const minorFormsContainer = document.getElementById('minorFormsContainer');
    if (!numChildrenElem || !minorFormsContainer) return;

    const numChildren = parseInt(numChildrenElem.value, 10);
    if (isNaN(numChildren) || numChildren <= 0) return;

    storeMinorData(); // Guardar datos actuales antes de regenerar los formularios

    minorFormsContainer.innerHTML = ''; // Limpiar formularios anteriores

    let numSections = Math.ceil(numChildren / 3);

    for (let sectionNumber = 0; sectionNumber < numSections; sectionNumber++) {
        let section = document.createElement('div');
        section.classList.add('minor-form-section');
        section.id = `minorFormSection${sectionNumber}`;
        section.style.display = sectionNumber === 0 ? 'block' : 'none';

        for (let i = sectionNumber * 3; i < Math.min((sectionNumber + 1) * 3, numChildren); i++) {
            const previousData = minorData[i] || {};
            
            let info ='<svg class="bx green" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M11.95 18q.525 0 .888-.363t.362-.887t-.362-.888t-.888-.362t-.887.363t-.363.887t.363.888t.887.362m-.9-3.85h1.85q0-.825.188-1.3t1.062-1.3q.65-.65 1.025-1.238T15.55 8.9q0-1.4-1.025-2.15T12.1 6q-1.425 0-2.312.75T8.55 8.55l1.65.65q.125-.45.563-.975T12.1 7.7q.8 0 1.2.438t.4.962q0 .5-.3.938t-.75.812q-1.1.975-1.35 1.475t-.25 1.825M12 22q-2.075 0-3.9-.787t-3.175-2.138T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>';

            let form = document.createElement('div');
            form.classList.add('minor-info-container');
            form.id = `minorForm${i}`;
            form.innerHTML = `

                <div class="btReset">
                    <div class="header">
                        <div class="header-content">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 48 48">
                                <path fill="#a86c4d" d="M24 .85a10.76 10.76 0 0 1 10.76 10.76v14a1.23 1.23 0 0 1-.76 1.17a26.9 26.9 0 0 1-20 0a1.23 1.23 0 0 1-.76-1.13v-14A10.76 10.76 0 0 1 24 .85" />
                                <path fill="#de926a" d="M24 .85a10.76 10.76 0 0 0-10.76 10.76v3.17A10.76 10.76 0 0 1 24 4a10.76 10.76 0 0 1 10.76 10.78v-3.17A10.76 10.76 0 0 0 24 .85" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M24 .85a10.76 10.76 0 0 1 10.76 10.76v14a1.23 1.23 0 0 1-.76 1.17h0a26.9 26.9 0 0 1-20 0h0a1.23 1.23 0 0 1-.76-1.13v-14A10.76 10.76 0 0 1 24 .85" />
                                <path fill="#ff87af" d="M35.75 47.5h-23.5V37.24A11.75 11.75 0 0 1 24 25.49a11.75 11.75 0 0 1 11.75 11.75z" />
                                <path fill="#ff6196" d="M24 25.49a11.75 11.75 0 0 1 11.75 11.75v3.59a11.75 11.75 0 0 0-23.5 0v-3.59A11.75 11.75 0 0 1 24 25.49" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M35.75 47.5h-23.5h0V37.24A11.75 11.75 0 0 1 24 25.49h0a11.75 11.75 0 0 1 11.75 11.75z" />
                                <path fill="#ffcebf" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M21.48 21.48h5.03v7.85h-5.03Z" />
                                <path fill="#ffcebf" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M33 13.86a8.68 8.68 0 0 1-5.62-5l-.61-1.47a15.75 15.75 0 0 1-9.84 6.11l-1.93.36a1.8 1.8 0 0 0 0 3.59h.11a9 9 0 0 0 17.72 0H33a1.8 1.8 0 0 0 0-3.59" />
                                <path fill="#45413c" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M18.62 15.29a.77.77 0 0 0 .77.76a.76.76 0 0 0 0-1.52a.77.77 0 0 0-.77.76m10.76 0a.77.77 0 0 1-.77.76a.76.76 0 0 1 0-1.52a.77.77 0 0 1 .77.76" />
                                <path fill="#ff6242" d="M21.19 19.93a.45.45 0 0 0-.33.16a.43.43 0 0 0-.1.35a3.29 3.29 0 0 0 6.48 0a.43.43 0 0 0-.1-.35a.45.45 0 0 0-.33-.16Z" />
                                <path fill="#ffa694" d="M24 23.18a3.3 3.3 0 0 0 2.3-.93a3.31 3.31 0 0 0-4.6 0a3.3 3.3 0 0 0 2.3.93" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M21.19 19.93a.45.45 0 0 0-.33.16a.43.43 0 0 0-.1.35a3.29 3.29 0 0 0 6.48 0a.43.43 0 0 0-.1-.35a.45.45 0 0 0-.33-.16Z" />
                                <path fill="#ffb59e" d="M17.13 18.54a.99.59 0 1 0 1.98 0a.99.59 0 1 0-1.98 0m11.76 0a.99.59 0 1 0 1.98 0a.99.59 0 1 0-1.98 0" />
                                <path fill="#a86c4d" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M26.81 41.17a8.1 8.1 0 0 0 1.62-2c.8-1.38 2.69-1.69 3.46-.46c.67 1.06.28 2.35-1.49 3a3.84 3.84 0 0 1-3.59-.54m19.75 0a8.2 8.2 0 0 1-1.61-2c-.8-1.38-2.69-1.69-3.47-.46c-.67 1.06-.27 2.35 1.5 3a3.81 3.81 0 0 0 3.58-.54" />
                                <path fill="#bf8df2" d="M45.5 47.5a9.42 9.42 0 0 0-17.62 0Z" />
                                <path fill="#9f5ae5" d="M36.69 44.17a9.36 9.36 0 0 1 7.18 3.33h1.63a9.42 9.42 0 0 0-17.62 0h1.62a9.4 9.4 0 0 1 7.19-3.33" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M45.5 47.5a9.42 9.42 0 0 0-17.62 0Z" />
                                <path fill="#ffcebf" d="M34.83 38.22h3.72v6.4h-3.72Z" />
                                <path fill="#ffb59e" d="M34.83 38.22h3.72v4.64h-3.72Z" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M34.83 38.22h3.72v6.4h-3.72Z" />
                                <path fill="#a86c4d" d="M36.69 23.77A7.26 7.26 0 0 1 43.95 31v3.8H29.43V31a7.26 7.26 0 0 1 7.26-7.23" />
                                <path fill="#de926a" d="M36.69 23.77A7.26 7.26 0 0 0 29.43 31v2.28a7.26 7.26 0 0 1 14.52 0V31a7.26 7.26 0 0 0-7.26-7.23" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M36.69 23.77A7.26 7.26 0 0 0 29.43 31v3.8H44V31a7.26 7.26 0 0 0-7.31-7.23" />
                                <path fill="#ffcebf" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M44.72 34.27a1.35 1.35 0 0 0-1-1.14a7.64 7.64 0 0 1-7-3.83a7.65 7.65 0 0 1-7 3.83a1.38 1.38 0 0 0-1 1.14A1.35 1.35 0 0 0 30 35.73h.08a6.69 6.69 0 0 0 13.24 0h.08a1.34 1.34 0 0 0 1.32-1.46" />
                                <path fill="#45413c" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M33.17 34.66a.5.5 0 0 0 1 0a.5.5 0 0 0-1 0m7.04 0a.51.51 0 0 1-.5.5a.5.5 0 0 1-.5-.5a.5.5 0 0 1 .5-.5a.5.5 0 0 1 .5.5" />
                                <path fill="#ffb59e" d="M31.69 36.78a.65.39 0 1 0 1.3 0a.65.39 0 1 0-1.3 0m8.69 0a.65.39 0 1 0 1.3 0a.65.39 0 1 0-1.3 0" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M35 38.76a2.34 2.34 0 0 0 1.69.54a2.34 2.34 0 0 0 1.69-.54" />
                                <path fill="#00f5bc" d="M20.12 47.5a9.42 9.42 0 0 0-17.62 0Z" />
                                <path fill="#00dba8" d="M11.31 44.17a9.4 9.4 0 0 1 7.19 3.33h1.62a9.42 9.42 0 0 0-17.62 0h1.63a9.36 9.36 0 0 1 7.18-3.33" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M20.12 47.5a9.42 9.42 0 0 0-17.62 0Z" />
                                <path fill="#ffcebf" d="M9.45 38.22h3.72v6.4H9.45Z" />
                                <path fill="#ffb59e" d="M9.45 38.22h3.72v4.64H9.45Z" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M9.45 38.22h3.72v6.4H9.45Z" />
                                <path fill="#a86c4d" d="M11.31 23.77a7 7 0 0 0-1.8.23a12.1 12.1 0 0 1-4.78.52a3.05 3.05 0 0 0 .62 2.37A7.2 7.2 0 0 0 4.05 31v3.8h14.52V31a7.26 7.26 0 0 0-7.26-7.23" />
                                <path fill="#de926a" d="M11.31 23.77a7 7 0 0 0-1.8.23a12.1 12.1 0 0 1-4.78.52a3.1 3.1 0 0 0 .6 2.35a14.6 14.6 0 0 0 4.18-.59a7 7 0 0 1 1.8-.23a7.26 7.26 0 0 1 7.26 7.26V31a7.26 7.26 0 0 0-7.26-7.23" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M11.31 23.77a7 7 0 0 0-1.8.23a12.1 12.1 0 0 1-4.78.52a3.05 3.05 0 0 0 .62 2.37A7.2 7.2 0 0 0 4.05 31v3.8h14.52V31a7.26 7.26 0 0 0-7.26-7.23" />
                                <path fill="#ffcebf" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M4.31 33.13a1.31 1.31 0 0 0 .3 2.6h.08a6.69 6.69 0 0 0 13.24 0H18a1.35 1.35 0 0 0 1.34-1.46a1.38 1.38 0 0 0-1-1.14c-3-.59-4.65-3.76-4.69-3.83c-.06.09-2.5 3.92-9.34 3.83" />
                                <path fill="#45413c" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M7.79 34.66a.51.51 0 0 0 .5.5a.5.5 0 0 0 .5-.5a.5.5 0 0 0-.5-.5a.5.5 0 0 0-.5.5m7.04 0a.5.5 0 0 1-1 0a.5.5 0 0 1 1 0" />
                                <path fill="#ffb59e" d="M6.32 36.78a.65.39 0 1 0 1.3 0a.65.39 0 1 0-1.3 0m8.69 0a.65.39 0 1 0 1.3 0a.65.39 0 1 0-1.3 0" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M9.62 38.63a2.34 2.34 0 0 0 1.69.54a2.34 2.34 0 0 0 1.69-.54" />
                        </svg>
                            <h2><strong>Menor de edad ${i + 1}</strong></h2>
                        </div>
                    </div>
                    <div>
                        <button class="button-action" type="button" onclick="clearMinorForm(${i})">
                            <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
                                <g fill="#a65f3e">
                                    <path d="M56.31 74.64c-.88 0-1.71-.34-2.34-.97a3.3 3.3 0 0 1-.97-2.34c0-.88.34-1.71.97-2.34l64.56-64.56a3.307 3.307 0 0 1 4.68 0a3.314 3.314 0 0 1 0 4.68L58.65 73.67c-.63.63-1.46.97-2.34.97" />
                                    <path d="M120.87 4c.71 0 1.42.27 1.96.81a2.79 2.79 0 0 1 0 3.93L58.27 73.3c-.54.54-1.25.81-1.96.81s-1.42-.27-1.96-.81a2.79 2.79 0 0 1 0-3.93l64.56-64.56c.54-.54 1.25-.81 1.96-.81m0-1.06c-1.03 0-1.99.4-2.71 1.12L53.6 68.62a3.78 3.78 0 0 0-1.12 2.71a3.82 3.82 0 0 0 3.83 3.83c1.03 0 1.99-.4 2.71-1.12l64.56-64.56c1.5-1.5 1.5-3.93 0-5.43a3.85 3.85 0 0 0-2.71-1.11" />
                                </g>
                                <path fill="#ffe082" d="m5.61 91.49l31.11 31.11c6.99-7.7 12.97-16.45 16.19-26.5c.23-.73.27-1.92 1.02-2.87c3.61-4.53 14.92-16.06 5.65-25.33c-8.85-8.85-19.5 1.81-23.95 5.48c-1.36 1.13-3.07 1.83-4.85 2.21C18.84 78.2 6.51 90.54 5.61 91.49" />
                                <path fill="#ffe082" d="M59.07 60.61c.77-.4 1.87-.9 3.15-.68c.78.14 1.89 1.08 3.04 2.23s2.23 2.44 2.55 3.27c.33.83-.03 1.94-.03 1.94c-.93 1.84-3.07 5.52-4.8 4.99c-1.93-.59-3.86-2.44-5.29-3.83c-.81-.78-1.65-1.64-2.2-2.63c-.77-1.41.06-2.59 1.03-3.57c.69-.66 1.86-1.36 2.55-1.72" />
                                <path fill="#f9c248" d="M58.61 63.79c.93.88 1.68 1.95 2.71 2.71c2.02 1.48 3.64.77 4.96-.42c.39-.35.98-.8 1.36-.44c.11.11.16.26.2.41c.16.73-.06 1.49-.36 2.18c-.74 1.69-1.95 3.17-3.46 4.23c-.26.18-.57.36-.88.26c-.19-.06-.33-.21-.45-.36c-1.66-1.95-2.96-4.26-5.01-5.79c-.82-.61-2.91-1.06-2.38-2.43c.79-2.09 2.53-1.09 3.31-.35" />
                                <path fill="#f9c248" d="M52.91 96.1c.23-.73.27-1.92 1.02-2.87c4.12-5.16 9.78-11.04 9.16-18.2c-.08-.98-1.35-6-2.74-4.11c-.31.42-.19 2.52-.23 3.03c-.8 9.38-8.16 14.57-9.52 16.19c-1.36 1.63-1.32 3.15-2.49 5.56c-1.31 2.71-2.99 5.24-4.88 7.58c-3.03 3.75-6.6 7.03-10.29 10.15c-.61.51-1.24 1.04-1.62 1.74c-1.05 1.93 1.22 3.25 2.44 4.46l2.95 2.95c6.99-7.69 12.97-16.44 16.2-26.48" />
                                <path fill="#a65f3e" d="M62.67 73.4s-3.5-6.6-8.13-8.59c0 0-.17-.43.16-.8c.41-.46.96-.56 1.25-.37c3.42 2.12 6.5 4.95 8.06 8.82c.31.74-1.05 1.83-1.34.94" />
                                <path fill="#e2a610" d="M36.3 118.46c-.8-1.25-1.94-2.4-2.54-3.66c-.14-.31-.27-.64-.23-.98c.07-.64 1.04-1.21 1.49-1.59c.68-.58 1.37-1.15 2.03-1.76c1.3-1.19 2.51-2.51 3.35-4.07c.14-.25.26-.56.13-.82c-.28-.52-1.9 1.22-2.2 1.49c-.84.74-1.66 1.5-2.54 2.18c-1.17.9-3.38 2.43-4.95 1.7c-.8-.37-1.52-1.35-2.1-1.99c-.67-.75-1.31-1.53-2.02-2.26c-1.02-1.06-2.06-2.1-3.11-3.12c-.53-.52-1.07-1.04-1.62-1.54c-.41-.37-.49-.53-.03-.98c1.52-1.48 2.98-3.03 4.37-4.63c.18-.21.35-.54.14-.72c-.15-.13-.39-.04-.56.05c-2.08 1.1-3.74 2.83-5.54 4.35c-.44.37-1.71-1.04-1.99-1.26c-.74-.59-1.23-.82-.37-1.69c3.87-3.92 7.78-7.56 12.43-10.58c.86-.55 1.76-1.12 2.25-2.02c-.09-.24-.44-.21-.69-.12c-6.45 2.32-15.12 10.33-15.86 11.04c-1.3 1.26-3.63-1.65-7.08-3.85c-1.18-.75 0-1.88.3-2.23c2.08-2.46 4.83-5.14 4.83-5.14c-1.02.11-7.65 6.09-8.44 6.99c-.67.77-1.35 1.47-1.4 2.54c-.05.93.32 1.86.86 2.6c6.16 8.4 20.69 22.35 25.84 26.03c3.07 2.19 4.02 1.79 5.27.54c.65-.65.96-1.48.84-2.4c-.1-.74-.43-1.44-.86-2.1" />
                            <path fill="#f44336" d="M53.11 95.03c-4.22-6.54-13.04-15.49-19.68-20.19c-.52-.37 1.64-1.63 2.18-1.25c6.9 4.91 14.03 12.4 18.48 19.19c.36.53-.73 2.63-.98 2.25m4.43-6.41c-4.05-5.69-12.17-13.91-17.9-18.5c-.5-.4 1.45-1.76 1.85-1.45c6.04 4.82 13.35 11.99 17.44 18.11c.3.45-1.1 2.25-1.39 1.84" />
                             </svg>
                        </button>
                        ${numChildren > 1 ? `
                        <button class="button-action" type="button" onclick="deleteMinorForm(${i})">
                            <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24">
                                <path fill="#c91a1a" d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10s10-4.47 10-10S17.53 2 12 2m5 13.59L15.59 17L12 13.41L8.41 17L7 15.59L10.59 12L7 8.41L8.41 7L12 10.59L15.59 7L17 8.41L13.41 12z" />
                            </svg>
                        </button>` : ''}
                    </div>
                </div>
                <div class="minor-info">
                    <div class="field-group">
                        <label for="ageMinor${i}">Edad<span class="obligatorio">*</span>
                         <span class="help-icon" title="Ingrese la edad del pasajero.&#10Se cobrara el pasaje a los niños de 4 años en adelante.">${info}</span></label>  
                        <div class="errorMessage" id="errorMessageageMinor${i}"></div>
                        <input class="input-box" type="number" id="ageMinor${i}" name="ageMinor${i}" title="Ingrese la edad del niño" placeholder="Ingrese la edad" min="0" max="17" value="${previousData.age || ''}">
                    </div>
                    <div class="field-group">
                        <label for="sexMinor${i}">Sexo<span class="obligatorio">*</span>
                        <span class="help-icon" title="Ingrese el sexo del niño.">${info}</span></label>
                        <div class="errorMessage" id="errorMessagesexMinor${i}"></div>
                        <select class="input-box" id="sexMinor${i}" name="sexMinor${i}" title="Seleccione el sexo">
                            <option value="">Seleccione</option>
                            <option value="m" ${previousData.sex === 'm' ? 'selected' : ''}>Masculino</option>
                            <option value="f" ${previousData.sex === 'f' ? 'selected' : ''}>Femenino</option>
                        </select>
                    </div>
                    <div class="field-group"> 
                        <label for="responsibleMinor${i}">Responsable<span class="obligatorio">*</span> 
                        <span class="help-icon" title="Seleccione un responsable del menor de entre los acompañantes del viaje.">${info}</span></label>
                        <div class="errorMessage" id="errorMessageresponsibleMinor${i}"></div>
                        <select class="input-box" id="responsibleMinor${i}" name="responsibleMinor${i}" title="Seleccione el responsable"> 
                            <option value="${previousData.idResponsible || ''}">${previousData.responsible || 'Seleccione'}</option> 
                        </select> 
                    </div>
                </div>
            `;
            

            section.appendChild(form);
            minorFormsContainer.appendChild(section);
            addDynamicMinorFormListeners(i);
            const ageInput = form.querySelector(`#ageMinor${i}`);
            const errorMessageElement = form.querySelector(`#errorMessageageMinor${i}`);

            ageInput.addEventListener('input', () => validateMinorAge(ageInput, errorMessageElement));
            ageInput.addEventListener('keypress', function(e) {
                if (e.key < '0' || e.key > '9') {
                    e.preventDefault();
                    errorMessageElement.textContent = 'Solo se permiten números.';
                    alertMessageDisappear(errorMessageElement);
                }
            });
            ageInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const clipboardData = (e.clipboardData || window.clipboardData).getData('text');
                if (/^[0-9]+$/.test(clipboardData)) {
                    document.execCommand('insertText', false, clipboardData);
                } else {
                    errorMessageElement.textContent = 'Solo se permiten números.';
                    alertMessageDisappear(errorMessageElement);
                }
            });
        }

        const navigationButtons = document.createElement('div');
        navigationButtons.classList.add('buttom-container');
        navigationButtons.style.display = 'flex';
        navigationButtons.style.justifyContent = 'space-between';

        if (sectionNumber > 0) {
            navigationButtons.innerHTML += `<button class="button-prev-passenger" type="button"  id="ziseMineA" onclick="previousMinorSection(${sectionNumber - 1})">
            <svg  width="36" height="36" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1)">
                <path d="M13.939 4.939 6.879 12l7.06 7.061 2.122-2.122L11.121 12l4.94-4.939z"></path>
            </svg>
            </button>`;
        } else {
            navigationButtons.innerHTML += `<button class="button-prev-passenger" type="button" style="visibility: hidden;">
            <svg  width="36" height="36" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1)">
                <path d="M13.939 4.939 6.879 12l7.06 7.061 2.122-2.122L11.121 12l4.94-4.939z"></path>
            </svg>
            </button>`;
        }

        if (sectionNumber < numSections - 1) {
            navigationButtons.innerHTML += `<button class="button-next-passenger" type="button" id="ziseMineS" onclick="nextMinorSection(${sectionNumber + 1})">
            <svg  width="36" height="36" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1)">
                <path d="M10.061 19.061 17.121 12l-7.06-7.061-2.122 2.122L12.879 12l-4.94 4.939z"></path>
            </svg>
            </button>`;
        } else {
            navigationButtons.innerHTML += `<button class="button-next-passenger" type="button"  style="visibility: hidden;">
            <svg  width="36" height="36" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1)">
                <path d="M10.061 19.061 17.121 12l-7.06-7.061-2.122 2.122L12.879 12l-4.94 4.939z"></path>
            </svg>
            </button>`;
        }

        section.appendChild(navigationButtons);
        minorFormsContainer.appendChild(section);

        
    }

    updateMinorSections();
}


/*  */
// Añadir validaciones para el input de edad


function clearMinorForm(index) {
    const form = document.getElementById(`minorForm${index}`);
    if (form) {
        form.querySelectorAll('input').forEach(input => input.value = '');
        form.querySelectorAll('select').forEach(select => select.value = '');
    }
}

function deleteMinorForm(index) {
    storeMinorData(); // Guardar los datos actuales

    // Eliminar el elemento de los datos de los niños
    minorData.splice(index, 1);

    // Eliminar el formulario del DOM
    const formToDelete = document.getElementById(`minorForm${index}`);
    if (formToDelete) {
        formToDelete.remove();
    }

    // Actualizar selects de responsables
    updateResponsibleSelects();

    // Actualizar los índices de los formularios restantes
    updatePassengerAndChildrenCounts(index);

    // Retroceder a la sección anterior si el último niño de la sección es eliminado
    if (index % 3 === 0 && currentMinorSection > 0) {
        currentMinorSection--;
    }

    // Regenerar formularios para actualizar los índices
    generateMinorForms();

    // Actualizar las secciones visualmente
    updateMinorSections();
}

// Función para guardar los datos actuales de los menores
function storeMinorData() {
    minorData = [];

    document.querySelectorAll('.minor-info-container').forEach((container, index) => {
        const ageInput = container.querySelector(`input[id="ageMinor${index}"]`);
        const sexSelect = container.querySelector(`select[id="sexMinor${index}"]`);
        const responsibleSelect = container.querySelector(`select[id="responsibleMinor${index}"]`);

        const responsible = responsibleSelect ? (responsibleSelect.options[responsibleSelect.selectedIndex] ? responsibleSelect.options[responsibleSelect.selectedIndex].text : "") : "";
        const idResponsible = responsibleSelect ? responsibleSelect.value : "";

        if (ageInput && sexSelect && responsibleSelect) {
            minorData.push({
                age: ageInput.value || "",
                sex: sexSelect.value || "",
                responsible,
                idResponsible
            });
        }
    });
}


// Función para actualizar los contadores de pasajeros y niños
function updatePassengerAndChildrenCounts(deletedIndex) {
    const numChildrenElem = document.getElementById('numChildren');
    const numTuristaElem = document.getElementById('numTurista');
    
    if (!numChildrenElem || !numTuristaElem) return;

    let numChildren = parseInt(numChildrenElem.value, 10);
    let numTurista = parseInt(numTuristaElem.value, 10);
    
    if (!isNaN(numChildren) && numChildren > 0) {
        numChildrenElem.value = numChildren - 1;
    }

    if (!isNaN(numTurista) && numTurista > 0) {
        numTuristaElem.value = numTurista - 1;
    }

    // Ajustar índices de los formularios restantes
    const forms = document.querySelectorAll('.minor-info-container');
    forms.forEach((form, i) => {
        form.id = `minorForm${i}`;
        form.querySelector('h2').textContent = `Menor de edad #${i + 1}`;
        form.querySelector('label[for^="ageMinor"]').setAttribute('for', `ageMinor${i}`);
        form.querySelector('input[id^="ageMinor"]').setAttribute('id', `ageMinor${i}`);
        form.querySelector('label[for^="sexMinor"]').setAttribute('for', `sexMinor${i}`);
        form.querySelector('select[id^="sexMinor"]').setAttribute('id', `sexMinor${i}`);
        form.querySelector('label[for^="responsibleMinor"]').setAttribute('for', `responsibleMinor${i}`);
        form.querySelector('select[id^="responsibleMinor"]').setAttribute('id', `responsibleMinor${i}`);
        form.querySelector('.button-action[onclick^="clearMinorForm"]').setAttribute('onclick', `clearMinorForm(${i})`);
        const deleteButton = form.querySelector('.button-action[onclick^="deleteMinorForm"]');
        if (deleteButton) {
            deleteButton.setAttribute('onclick', `deleteMinorForm(${i})`);
        }
    });
}


function updateMinorSections() {
    const sections = document.querySelectorAll('.minor-form-section');
    sections.forEach((section, i) => {
        if (i === currentMinorSection) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
}

function nextMinorSection(index) {
    storeMinorData(); // Guardar datos antes de cambiar de sección
    const sections = document.querySelectorAll('.minor-form-section');
    if (index < sections.length) {
        currentMinorSection = index;
        updateMinorSections();
    }
}

function previousMinorSection(index) {
    storeMinorData(); // Guardar datos antes de cambiar de sección
    if (index >= 0) {
        currentMinorSection = index;
        updateMinorSections();
    }
}


// Llamar a la función al cargar la página y cada vez que se actualicen los valores
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('numChildren').addEventListener('change', generateMinorForms);
});
function updateMinorMoney() {
    const minorForms = document.querySelectorAll('.minor-info-container');
    let minorCountUnderFour = 0;

    minorForms.forEach(form => {
        const ageInput = form.querySelector('input[name^="ageMinor"]');
        if (ageInput && ageInput.value && parseInt(ageInput.value, 10) < 4) {
            minorCountUnderFour++;
        }
    });

    const minorMoneyInput = document.getElementById('minorMoney');
    if (minorMoneyInput) {
        minorMoneyInput.value = minorCountUnderFour;
    }
}


