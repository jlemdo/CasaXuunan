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

<!-- SEO H1 - visible in slider area -->
<h1 class="homepage-h1"><?php echo t('index_h1'); ?></h1>

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

        // Create dark overlay for focus effect
        var overlay = document.createElement('div');
        overlay.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0);z-index:1001;pointer-events:none;transition:background 0.4s ease;';
        document.body.appendChild(overlay);

        function collapseSearch() {
            if (!isExpanded) return;
            isExpanded = false;
            section.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            section.style.transform = 'translateY(0)';
            overlay.style.background = 'rgba(0,0,0,0)';
            overlay.style.pointerEvents = 'none';
            overlay.style.zIndex = '1001';
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

        function expandSearch() {
            if (isExpanded) return;
            isExpanded = true;
            var vh = window.innerHeight;
            var isDesktop = window.innerWidth > 992;
            var moveUp = Math.round(vh * (isDesktop ? 0.30 : 0.22));

            section.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            section.style.transform = 'translateY(-' + moveUp + 'px)';

            overlay.style.background = 'rgba(0,0,0,0.6)';
            if (isDesktop) {
                // Desktop: overlay behind search widget so it doesn't block calendar/guests
                overlay.style.zIndex = '49';
                overlay.style.pointerEvents = 'auto';
            } else {
                // Mobile: overlay above everything, search section is raised to 1002
                overlay.style.zIndex = '1001';
                overlay.style.pointerEvents = 'auto';
            }

            if (reviews) {
                reviews.style.transition = 'opacity 0.3s ease';
                reviews.style.opacity = '0';
                reviews.style.pointerEvents = 'none';
            }
            if (caption) {
                caption.style.transition = 'opacity 0.3s ease';
                caption.style.opacity = '0';
            }
            wrapper.style.transition = 'background 0.4s ease, box-shadow 0.4s ease';
            wrapper.style.background = 'rgba(10, 10, 10, 0.85)';
            wrapper.style.boxShadow = '0 -10px 60px rgba(0,0,0,0.5)';
        }

        // Click on dark overlay = collapse
        overlay.addEventListener('click', function() {
            collapseSearch();
        });

        // Detect any dropdown open inside shadow DOM
        function isAnyDropdownOpen() {
            var sr = widget.shadowRoot;
            // Check calendar
            var dpc = sr.querySelector('.date-picker-container');
            if (dpc && dpc.offsetHeight > 0) return true;
            // Check guests
            var guests = sr.querySelector('.guests-expanded');
            if (guests && guests.offsetHeight > 0) return true;
            // Check for any visible calendar/picker by looking at all containers
            var allPickers = sr.querySelectorAll('[class*="date-picker"], [class*="calendar"], [class*="guest"]');
            for (var i = 0; i < allPickers.length; i++) {
                if (allPickers[i].offsetHeight > 50) return true;
            }
            return false;
        }

        // Listen for clicks inside shadow DOM to detect input focus
        widget.shadowRoot.addEventListener('click', function(e) {
            var tag = e.target.tagName;
            var cls = e.target.className || '';
            // If clicking on check-in, check-out inputs or guest-related elements
            var isInput = tag === 'INPUT' || tag === 'SELECT';
            var isDateCell = cls.indexOf('date-cell') > -1 || cls.indexOf('calendar') > -1;
            var isGuestBtn = cls.indexOf('guest') > -1 || cls.indexOf('increment') > -1 || cls.indexOf('decrement') > -1;

            if (isInput || isDateCell || isGuestBtn) {
                // Small delay to let widget render the dropdown
                setTimeout(function() {
                    if (isAnyDropdownOpen()) {
                        expandSearch();
                    }
                }, 150);
            }
        }, true);

        // Watch for changes that might close dropdowns
        var observer = new MutationObserver(function() {
            requestAnimationFrame(function() {
                if (isExpanded && !isAnyDropdownOpen()) {
                    collapseSearch();
                }
            });
        });
        observer.observe(widget.shadowRoot, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['class', 'style']
        });

        // Click outside widget = collapse
        document.addEventListener('click', function(e) {
            if (!isExpanded) return;
            // If click is outside the search wrapper, collapse
            if (!wrapper.contains(e.target) && !widget.contains(e.target)) {
                collapseSearch();
            }
        });

        // Also collapse on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isExpanded) {
                collapseSearch();
            }
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
                <div class="elfsight-app-d417e2fd-4c4c-4718-af81-b5995cd6c060"></div>

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

