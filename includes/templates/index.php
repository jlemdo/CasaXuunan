 <!-- content begin -->
 <div id="content" class="no-bottom no-top">

<!-- float text begin -->
<div class="float-text">
    <div class="de_social-icons">
        <a href="https://www.facebook.com/people/Casa-Xuunan/61578964945156/" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
        <a href="https://www.instagram.com/casa_xuunan/" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
        <a href="https://api.whatsapp.com/send?phone=5219852580599" target="_blank" ><i class="fa fa-whatsapp fa-lg"></i></a>
    </div>
    <span><a href="/rooms.php"><?php echo t('btn_book'); ?></a></span>
</div>
<!-- float text close -->

<div class='slider-overlay'></div>

<div id="slidecaption"></div>

<!-- Botón sutil dentro del slider -->
<div class="reviews-scroll-btn-wrapper">
    <a href="#" class="reviews-scroll-btn" id="open-reviews-overlay">
        <span class="rating-stars">★★★★★ 4.8</span>
        <span class="scroll-text"><?php echo t('index_rating'); ?></span>
    </a>
</div>

<!-- Search Bar - Hospitable Property Search -->
<div class="home-search-section">
    <div class="home-search-wrapper">
        <div class="home-search-title"><?php echo t('search_home_title'); ?> <span><?php echo t('search_home_highlight'); ?></span></div>
        <hospitable-direct-mps identifier="acfc5534-2d3d-4f1e-88a0-74360d86804f" type="custom" results-url="/search.php"></hospitable-direct-mps>
        <div class="home-search-subtitle"><i class="fa fa-star"></i> <?php echo t('search_home_subtitle'); ?></div>
    </div>
</div>

<!-- Hospitable widget: smooth slide-up when calendar/guests open -->
<script>
(function() {
    function initWidget(widget) {
        if (!widget || !widget.shadowRoot) return;

        // Compact spacing inside widget
        if (!widget.shadowRoot.querySelector('#home-widget-fix')) {
            var style = document.createElement('style');
            style.id = 'home-widget-fix';
            style.textContent = '.search-bar-container { margin-bottom: 0px !important; }';
            widget.shadowRoot.appendChild(style);
        }

        var section = document.querySelector('.home-search-section');
        var wrapper = document.querySelector('.home-search-wrapper');
        var reviews = document.querySelector('.reviews-scroll-btn-wrapper');
        var caption = document.getElementById('slidecaption');
        if (!section) return;

        var isExpanded = false;

        // Smoothly slide the search box up when calendar/guest picker opens
        function checkExpanded() {
            var dpc = widget.shadowRoot.querySelector('.date-picker-container');
            var guests = widget.shadowRoot.querySelector('.guests-expanded');
            var calOpen = dpc && dpc.offsetHeight > 0;
            var guestOpen = guests && guests.offsetHeight > 0;
            var shouldExpand = calOpen || guestOpen;

            if (shouldExpand && !isExpanded) {
                isExpanded = true;
                // Calculate how much to raise: put search bar near top third of screen
                var vh = window.innerHeight;
                var dropdownH = calOpen ? dpc.offsetHeight : (guests ? guests.offsetHeight : 0);
                var wrapperH = wrapper ? wrapper.offsetHeight : 80;
                // Center the whole thing (wrapper + dropdown) vertically
                var totalH = wrapperH + dropdownH;
                var targetTop = Math.max(20, (vh - totalH) / 3);
                var currentBottom = wrapper ? wrapper.getBoundingClientRect().top : (vh - 100);
                var moveUp = currentBottom - targetTop;

                section.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                section.style.transform = 'translateY(-' + moveUp + 'px)';

                // Fade out other elements for focus
                if (reviews) {
                    reviews.style.transition = 'opacity 0.3s ease';
                    reviews.style.opacity = '0';
                    reviews.style.pointerEvents = 'none';
                }
                if (caption) {
                    caption.style.transition = 'opacity 0.3s ease';
                    caption.style.opacity = '0';
                }

                // Darken backdrop
                wrapper.style.transition = 'background 0.4s ease, box-shadow 0.4s ease';
                wrapper.style.background = 'rgba(10, 10, 10, 0.85)';
                wrapper.style.boxShadow = '0 -10px 60px rgba(0,0,0,0.5)';

            } else if (!shouldExpand && isExpanded) {
                isExpanded = false;
                // Slide back down
                section.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                section.style.transform = 'translateY(0)';

                // Restore other elements
                if (reviews) {
                    reviews.style.transition = 'opacity 0.3s ease 0.2s';
                    reviews.style.opacity = '1';
                    reviews.style.pointerEvents = '';
                }
                if (caption) {
                    caption.style.transition = 'opacity 0.3s ease 0.2s';
                    caption.style.opacity = '1';
                }

                wrapper.style.transition = 'background 0.4s ease, box-shadow 0.4s ease';
                wrapper.style.background = '';
                wrapper.style.boxShadow = '';
            }
        }

        // Watch for calendar/guest picker opening/closing
        var observer = new MutationObserver(function() {
            requestAnimationFrame(checkExpanded);
        });
        observer.observe(widget.shadowRoot, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['class', 'style']
        });
    }

    var el = document.querySelector('.home-search-wrapper hospitable-direct-mps');
    if (el) {
        var attempts = 0;
        var interval = setInterval(function() {
            if (el.shadowRoot) {
                initWidget(el);
                clearInterval(interval);
            }
            if (++attempts > 50) clearInterval(interval);
        }, 100);
    }
})();
</script>

<div class="container">
    <div id="prevthumb"></div>
    <div id="nextthumb"></div>

    <!--Arrow Navigation-->
    <a id="prevslide" class="load-item"></a>
    <a id="nextslide" class="load-item"></a>

    <!--Time Bar-->
    <div id="progress-back" class="load-item">
        <div id="progress-bar"></div>
    </div>
    <!--Control Bar-->
    <div id="controls-wrapper" class="load-item">
        <div id="controls">

            <a id="play-button"><span id="pauseplay" class="play"></span></a>

            <!--Slide counter-->
            <div id="slidecounter">
                <span class="slidenumber"></span> / <span class="totalslides"></span>
            </div>

            <!--Navigation-->
            <ul id="slide-list"></ul>

        </div>
    </div>
</div>

</div>
<!-- content close -->

<!-- reviews overlay begin -->
<div id="reviews-overlay" class="slideUp">
    <div class="reviews-overlay-content">
        <div class="reviews-overlay-header">
            <h4><?php echo t('index_reviews_overlay_title1'); ?></h4>
            <h2><?php echo t('index_reviews_overlay_title2'); ?></h2>
            <div id="reviews-close-button">
                <div class="line-1"></div>
                <div class="line-2"></div>
            </div>
        </div>

        <div class="reviews-overlay-body">
            <div class="container">
                <!-- Elfsight Google Reviews Widget -->
                <div class="elfsight-app-d417e2fd-4c4c-4718-af81-b5995cd6c060" data-elfsight-app-lazy></div>

                <div class="text-center">
                    <div class="spacer-single"></div>
                    <a href="/rooms.php" class="btn-line">
                        <span><?php echo t('index_reviews_button'); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- reviews overlay close -->

