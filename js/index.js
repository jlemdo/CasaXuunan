// js/index.js

jQuery(function($){
    // Detectar idioma actual desde PHP (servidor) o URL
    var urlParams = new URLSearchParams(window.location.search);
    var currentLang = urlParams.get('lang') || window.PHP_LANG || 'es';

    // Slides en espanol
    var slidesES = [
        {
            image: 'images/slider/1.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Relájate</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Tu escape del ruido comienza aquí</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='about.php'><span>Nuestras Instalaciones</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/2.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Confort</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Sin lujos artificiales, sin frialdad corporativa</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='rooms.php'><span>Elige Habitación</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/3.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Paz</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Donde el tiempo se detiene para ti</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='about.php'><span>Nuestras Instalaciones</span></a></div>",
            thumb: '',
            url: ''
        }
    ];

    // Slides en ingles
    var slidesEN = [
        {
            image: 'images/slider/1.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Relax</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Your escape from the noise starts here</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='about.php'><span>Our Facilities</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/2.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Comfort</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>No artificial luxury, no corporate coldness</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='rooms.php'><span>Choose Room</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/3.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Peace</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Where time stands still for you</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='about.php'><span>Our Facilities</span></a></div>",
            thumb: '',
            url: ''
        }
    ];

    // Slides en frances (traduccion nativa profesional)
    // Nota: Las palabras hero deben ser CORTAS (7-9 letras) para
    // mantener consistencia visual con ES (Relajate) y EN (Relax)
    // y para que no rompan el layout en mobile/desktop
    var slidesFR = [
        {
            image: 'images/slider/1.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Détente</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Votre échappée du bruit commence ici</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='about.php'><span>Nos Installations</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/2.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Confort</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Sans luxe artificiel, sans froideur corporative</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='rooms.php'><span>Choisir une Chambre</span></a></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/3.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Sérénité</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Où le temps s'arrête pour vous</p><a class='btn-line wow fadeInUp' data-wow-delay='.4s' href='about.php'><span>Nos Installations</span></a></div>",
            thumb: '',
            url: ''
        }
    ];

    // Elegir slides segun idioma (3 idiomas: es / en / fr)
    var slides;
    if (currentLang === 'en') {
        slides = slidesEN;
    } else if (currentLang === 'fr') {
        slides = slidesFR;
    } else {
        slides = slidesES;
    }

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
