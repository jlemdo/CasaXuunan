// js/index.js

jQuery(function($){
    // Detectar idioma actual desde PHP (servidor) o URL
    var urlParams = new URLSearchParams(window.location.search);
    var currentLang = urlParams.get('lang') || window.PHP_LANG || 'es';

    // Slides en espanol (sin botones - se quitaron para CRO, ahora el CTA
    // viene del welcome popup CASA10 que aparece al cargar)
    var slidesES = [
        {
            image: 'images/slider/1.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Relájate</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Tu escape del ruido comienza aquí</p></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/2.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Confort</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Sin lujos artificiales, sin frialdad corporativa</p></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/3.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Paz</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Donde el tiempo se detiene para ti</p></div>",
            thumb: '',
            url: ''
        }
    ];

    // Slides en ingles (sin botones)
    var slidesEN = [
        {
            image: 'images/slider/1.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Relax</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Your escape from the noise starts here</p></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/2.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Comfort</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>No artificial luxury, no corporate coldness</p></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/3.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Peace</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Where time stands still for you</p></div>",
            thumb: '',
            url: ''
        }
    ];

    // Slides en frances (sin botones)
    var slidesFR = [
        {
            image: 'images/slider/1.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Détente</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Votre échappée du bruit commence ici</p></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/2.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Confort</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Sans luxe artificiel, sans froideur corporative</p></div>",
            thumb: '',
            url: ''
        },
        {
            image: 'images/slider/3.jpg',
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Sérénité</h2><p class='hp-slide-hook wow fadeInUp' data-wow-delay='.2s'>Où le temps s'arrête pour vous</p></div>",
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
