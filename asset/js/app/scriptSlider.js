const swiper = new Swiper('.card-wrapper', {

    loop: true,
    spaceBetween: 30,
    
    // Autoplay configuration
    autoplay: {
        delay: 3000, // Tiempo en milisegundos entre cada cambio (5000 ms = 5 segundos)
        disableOnInteraction: false, // Permite que el autoplay continúe después de la interacción
        pauseOnMouseEnter: true,// pausa el autoplay cuando el cursor esta encima
    },
    
    // Pagination bullets
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true
    },
    
    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    
    // Responsive breakpoints
    breakpoints: {
        0: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 3
        }
    }
});




