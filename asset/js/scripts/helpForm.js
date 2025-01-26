 // Insertar el div tooltip dinámicamente
 const tooltip = document.createElement('div');
 tooltip.id = 'tooltip';
 tooltip.className = 'tooltip';
 document.body.appendChild(tooltip);

 const helpIcons = document.querySelectorAll('.help-icon');

 helpIcons.forEach(icon => {
     icon.addEventListener('mouseenter', () => {
         tooltip.innerText = icon.getAttribute('data-tooltip');
         const rect = icon.getBoundingClientRect();
         tooltip.style.top = `${rect.bottom + window.scrollY + 5}px`;
         tooltip.style.left = `${rect.left + window.scrollX + 5}px`;
         tooltip.style.display = 'block';
     });

     icon.addEventListener('mouseleave', () => {
         tooltip.style.display = 'none';
     });
 });