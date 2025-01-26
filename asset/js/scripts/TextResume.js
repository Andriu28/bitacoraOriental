document.addEventListener('DOMContentLoaded', function() {
    const excerpts = document.querySelectorAll('.resumeText');
    const maxLength = 100; // Define el número máximo de caracteres antes de recortar

    excerpts.forEach(excerpt => {
        const fullText = excerpt.innerHTML;
        
        if (fullText.length > maxLength) {
            const shortText = fullText.substring(0, maxLength) + '... ';
            const readMoreLink = document.createElement('a');
            readMoreLink.href = '#';
            readMoreLink.innerText = 'Leer más';
            readMoreLink.style.color = '#0275d8';
            readMoreLink.style.cursor = 'pointer';

            readMoreLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (readMoreLink.innerText === 'Leer más') {
                    excerpt.innerHTML = fullText; // Muestra el texto completo
                    readMoreLink.innerText = ' Leer menos';
                    excerpt.appendChild(readMoreLink); // Añade el enlace "Leer menos"
                } else {
                    excerpt.innerHTML = shortText; // Muestra el texto resumido nuevamente
                    readMoreLink.innerText = ' Leer más';
                    excerpt.appendChild(readMoreLink); // Añade el enlace "Leer más"
                }
            });

            excerpt.innerHTML = shortText; // Muestra el texto resumido inicialmente
            excerpt.appendChild(readMoreLink); // Añade el enlace "Leer más"
        }
    });
});

