// js/index.js

jQuery(function($){
    // Detectar idioma actual desde el parámetro URL o sesión
    var urlParams = new URLSearchParams(window.location.search);
    var currentLang = urlParams.get('lang') || 'es';

    console.log('Current language detected:', currentLang);
    console.log('URL params:', window.location.search);

    // Slides en español
    var slidesES = [
        {
            image: 'images/slider/1.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Relájate</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='about.php'><span>Nuestras Instalaciones</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/2.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Confort</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='rooms.php'><span>Elige Habitación</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/3.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Paz</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='about.php'><span>Nuestras Instalaciones</span></a></div>",
            thumb: '',
            url: ''
        }
    ];

    // Slides en inglés
    var slidesEN = [
        {
            image: 'images/slider/1.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Relax</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='about.php'><span>Our Facilities</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/2.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Comfort</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='rooms.php'><span>Choose Room</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/3.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Peace</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='about.php'><span>Our Facilities</span></a></div>",
            thumb: '',
            url: ''
        }
    ];

    // Elegir slides según idioma
    var slides = (currentLang === 'en') ? slidesEN : slidesES;

    console.log('Selected slides array:', slides);
    console.log('Number of slides:', slides.length);
    console.log('First slide image:', slides[0].image);
    console.log('jQuery version:', $.fn.jquery);
    console.log('Supersized exists:', typeof $.supersized);

    if (typeof $.supersized !== 'function') {
        console.error('ERROR: supersized plugin not loaded!');
        return;
    }

    $.supersized({
        slide_interval: 5000,
        transition: 1,
        transition_speed: 500,
        slide_links: 'blank',
        slides: slides,
        autoplay: 1,
        fit_always: 0,
        performance: 0,
        image_protect: 1
    });

    $("#pauseplay").toggle(
        function () { $(this).addClass("pause"); },
        function () { $(this).removeClass("pause").addClass("play"); }
    );

    $("#pauseplay").stop().fadeTo(150, .5);
    $("#pauseplay").hover(
        function () { $(this).stop().fadeTo(150, 1); },
        function () { $(this).stop().fadeTo(150, .5); }
    );
});
