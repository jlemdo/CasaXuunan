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

<!-- Hospitable widget fixes: dropdowns open upward -->
<script>
(function() {
    function injectShadowStyles(widget) {
        if (!widget || !widget.shadowRoot) return;
        if (widget.shadowRoot.querySelector('#home-widget-fix')) return;
        var style = document.createElement('style');
        style.id = 'home-widget-fix';
        style.textContent = [
            '.date-picker-container { bottom: 100% !important; top: auto !important; }',
            '.guests-expanded { bottom: 100% !important; top: auto !important; }',
            '.search-bar-container { margin-bottom: 0px !important; }'
        ].join('\n');
        widget.shadowRoot.appendChild(style);
    }

    var el = document.querySelector('.home-search-wrapper hospitable-direct-mps');
    if (el) {
        var attempts = 0;
        var interval = setInterval(function() {
            if (el.shadowRoot) {
                injectShadowStyles(el);
                clearInterval(interval);

                // DEBUG: log date-picker info on every click inside shadow DOM
                el.shadowRoot.addEventListener('click', function(e) {
                    var dpc = el.shadowRoot.querySelector('.date-picker-container');
                    if (!dpc) return;
                    var cs = window.getComputedStyle(dpc);
                    var rect = dpc.getBoundingClientRect();
                    console.log('=== CLICK DEBUG ===');
                    console.log('clicked element:', e.target.tagName, e.target.className, e.target.textContent.trim().substring(0, 20));
                    console.log('click coords: x=' + e.clientX + ' y=' + e.clientY);
                    console.log('dpc position:', cs.position);
                    console.log('dpc top:', cs.top, '| bottom:', cs.bottom);
                    console.log('dpc display:', cs.display, '| visibility:', cs.visibility);
                    console.log('dpc rect:', JSON.stringify(rect));
                    console.log('dpc offsetHeight:', dpc.offsetHeight, '| offsetTop:', dpc.offsetTop);
                    console.log('dpc inline style:', dpc.getAttribute('style'));
                    // Check all parent computed styles up to shadow root
                    var parent = dpc.parentElement;
                    var i = 0;
                    while (parent && i < 5) {
                        var pcs = window.getComputedStyle(parent);
                        console.log('parent[' + i + ']:', parent.tagName, parent.className, '| pos:', pcs.position, '| overflow:', pcs.overflow, '| rect:', JSON.stringify(parent.getBoundingClientRect()));
                        parent = parent.parentElement;
                        i++;
                    }
                    console.log('=== END CLICK DEBUG ===');
                }, true);
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

