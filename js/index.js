// js/index.js

jQuery(function($){
    var slides = [
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
            title: "<div class='slider-text'><h2 class='wow fadeInUp'>Tranquilidad</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='about.php'><span>Nuestras Instalaciones</span></a></div>",
            thumb: '',
            url: ''
        }
    ];

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
