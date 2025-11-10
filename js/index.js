// js/index.js

jQuery(function($){
    // Cargar traducciones dinámicamente
    $.getJSON('get-translations.php', function(trans) {
        var slides = [
            {
                image: 'images/slider/1.jpg',
                title: "<div class='slider-text'><h2 class='wow fadeInUp'>" + trans.slider_1_title + "</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='about.php'><span>" + trans.slider_1_button + "</span></a></div>",
                thumb: '',
                url: ''
            },
            {
                image: 'images/slider/2.jpg',
                title: "<div class='slider-text'><h2 class='wow fadeInUp'>" + trans.slider_2_title + "</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='rooms.php'><span>" + trans.slider_2_button + "</span></a></div>",
                thumb: '',
                url: ''
            },
            {
                image: 'images/slider/3.jpg',
                title: "<div class='slider-text'><h2 class='wow fadeInUp'>" + trans.slider_3_title + "</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='about.php'><span>" + trans.slider_3_button + "</span></a></div>",
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
});
