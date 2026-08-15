 <!-- content begin -->
 <!-- ============================================================
      FIX: SmoothScroll vs Hospitable Widget
      ============================================================
      designesia.js carga una libreria SmoothScroll (linea ~215) que
      intercepta TODOS los eventos 'wheel' del navegador para animar
      el scroll. Esto rompe el scroll interno del widget de Hospitable
      (calendario, lista de huespedes, etc).

      Solucion: configuramos window.SmoothScrollOptions ANTES de que
      designesia.js inicialice la libreria, indicandole que excluya
      el widget. Esto hace que el scroll nativo del navegador funcione
      correctamente dentro del calendario de Hospitable.

      Funciona en desktop. Mobile no usa SmoothScroll (esta desactivado
      por user-agent), pero agregamos stopPropagation por seguridad.
 ============================================================ -->
 <script>
 window.SmoothScrollOptions = {
     excluded: '.home-search-wrapper, .home-search-section, .search-widget-fullwidth, hospitable-direct-mps'
 };
 </script>
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

<!-- ============================================================
     iOS bottom bar fix (iOS 26 Safari/Brave/WebKit)
     ============================================================
     La barra flotante inferior del navegador en iOS 26 tapa y RECORTA
     el contenido position:fixed anclado a bottom:0 (el buscador se veia
     cortado: sin boton Search ni subtitulo). env(safe-area-inset-bottom)
     no sirve aqui: solo mide el home indicator (~34px), no la barra
     (~100px). Solucion 2026: la API visualViewport reporta la altura
     REALMENTE visible; el hueco entre el layout viewport (donde ancla
     position:fixed) y el visualViewport = alto tapado por la barra.
     Ajustamos bottom dinamicamente (se recalcula al scroll/rotacion,
     cuando iOS colapsa/expande la barra). En Android/desktop el hueco
     es 0 y este script no cambia nada.
     Ref: developer.apple.com/forums/thread/800798
============================================================ -->
<script>
(function () {
    var vv = window.visualViewport;
    if (!vv) return; // navegadores sin la API: se quedan con bottom:0

    function apply() {
        var section = document.querySelector('.home-search-section');
        if (!section) return;
        // Hueco entre el fondo del layout viewport y el fondo visible real
        var gap = window.innerHeight - vv.height - vv.offsetTop;
        if (gap > 0) {
            section.style.bottom = gap + 'px';
        } else {
            section.style.bottom = '';
        }
    }

    var raf = null;
    function schedule() {
        if (raf) return;
        raf = requestAnimationFrame(function () { raf = null; apply(); });
    }

    vv.addEventListener('resize', schedule);
    vv.addEventListener('scroll', schedule);
    window.addEventListener('orientationchange', schedule);
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', apply);
    } else {
        apply();
    }
})();
</script>

<!-- iOS 26 Safari fix: detectar y aplicar workaround para bug position:fixed -->
<script>
(function() {
    // Detectar iOS 26+ Safari (donde existe el bug del modal accidental)
    // Referencia: https://x.com/devongovett/status/1968384768703349198
    var ua = navigator.userAgent;
    var isIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
    var iOSVersionMatch = ua.match(/OS (\d+)_/);
    var iOSVersion = iOSVersionMatch ? parseInt(iOSVersionMatch[1], 10) : 0;
    var isAffectedIOS = isIOS && iOSVersion >= 17;  // iOS 17+ tambien afectado

    if (isAffectedIOS) {
        // Agregar clase al body para que CSS pueda hacer overrides especificos
        document.documentElement.classList.add('ios-safari-fix');
        document.body.classList.add('ios-safari-fix');

        // CSS inyectado especifico para forzar widget Shadow DOM modals
        // a NO mostrarse hasta interaccion explicita del usuario
        var iosFix = document.createElement('style');
        iosFix.id = 'ios-26-widget-fix';
        iosFix.textContent = [
            // Cuando el widget esta colapsado (estado normal), NO permitir que
            // ningun overlay/modal interno se renderice por accidente
            'hospitable-direct-mps:not([data-user-active]) .modal-overlay,',
            'hospitable-direct-mps:not([data-user-active]) .date-picker-popup,',
            'hospitable-direct-mps:not([data-user-active]) .guests-popup {',
            '  visibility: hidden !important;',
            '  opacity: 0 !important;',
            '  pointer-events: none !important;',
            '  transform: translateY(100%) !important;',
            '}',
            // Solo cuando el usuario interactua (click en input), permitir mostrar
            'hospitable-direct-mps[data-user-active] .modal-overlay,',
            'hospitable-direct-mps[data-user-active] .date-picker-popup,',
            'hospitable-direct-mps[data-user-active] .guests-popup {',
            '  visibility: visible !important;',
            '  opacity: 1 !important;',
            '  pointer-events: auto !important;',
            '  transform: translateY(0) !important;',
            '}'
        ].join('\n');
        document.head.appendChild(iosFix);
    }
})();
</script>

<!-- Hospitable widget: smooth slide-up when calendar/guests open -->
<script>
(function() {
    function initWidget(widget) {
        if (!widget || !widget.shadowRoot) return;

        // FIX iOS 26: el widget Hospitable puede mostrar su modal sin que el
        // usuario haga click por el bug de position:fixed en iOS 26 Safari.
        // Solucion: solo marcar widget como "user-active" cuando hay click real.
        var ua = navigator.userAgent;
        var isAffectedIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream &&
                            parseInt((ua.match(/OS (\d+)_/) || [0, 0])[1], 10) >= 17;

        if (isAffectedIOS) {
            // El widget Shadow DOM necesita marcarse explicitamente cuando hay
            // interaccion real. Antes de eso, los modales internos permanecen
            // ocultos por el CSS aplicado arriba.
            widget.shadowRoot.addEventListener('click', function(e) {
                var target = e.target;
                var tag = target.tagName;
                var cls = target.className || '';

                // Marcar widget como activo solo cuando hay click EXPLICITO en
                // inputs (check-in, check-out) o controles del widget
                if (tag === 'INPUT' || tag === 'SELECT' ||
                    cls.indexOf('check') > -1 || cls.indexOf('guest') > -1 ||
                    cls.indexOf('date') > -1 || cls.indexOf('button') > -1) {
                    widget.setAttribute('data-user-active', '');
                }
            }, true);

            // Si el usuario hace click FUERA del widget, remover el flag
            document.addEventListener('click', function(e) {
                if (!widget.contains(e.target)) {
                    setTimeout(function() {
                        widget.removeAttribute('data-user-active');
                    }, 300);
                }
            }, true);
        }

        // Compact spacing inside widget + fix estilo nativo de inputs en iOS.
        // En iOS Safari/Brave los <input> del widget Hospitable salen con
        // appearance:auto -> Safari les pinta su fondo gris con degradado y
        // relieve (se ven "rotos"). Forzamos -webkit-appearance:none para que
        // respeten el fondo blanco/plano igual que en Chrome/Android.
        if (!widget.shadowRoot.querySelector('#home-widget-fix')) {
            var style = document.createElement('style');
            style.id = 'home-widget-fix';
            style.textContent = [
                '.search-bar-container { margin-bottom: 0px !important; }',
                'input, input[type="text"], input.check-in, input.check-out {',
                '  -webkit-appearance: none !important;',
                '  -moz-appearance: none !important;',
                '  appearance: none !important;',
                '  background-image: none !important;',
                '  background-color: #ffffff !important;',
                '  -webkit-box-shadow: none !important;',
                '  box-shadow: none !important;',
                '  border-radius: 12px !important;',
                '}'
            ].join('\n');
            widget.shadowRoot.appendChild(style);
        }

        // FIX SCROLL: Detener propagacion de wheel/touchmove dentro del widget
        // para que SmoothScroll (designesia.js) no se robe los eventos del calendario.
        // Defensa secundaria: aunque ya excluimos via SmoothScrollOptions, esto
        // garantiza el scroll nativo dentro del shadowRoot.
        function stopWheelPropagation(e) {
            e.stopPropagation();
        }
        widget.shadowRoot.addEventListener('wheel', stopWheelPropagation, { passive: true, capture: true });
        widget.shadowRoot.addEventListener('touchmove', stopWheelPropagation, { passive: true, capture: true });
        widget.addEventListener('wheel', stopWheelPropagation, { passive: true, capture: true });
        widget.addEventListener('touchmove', stopWheelPropagation, { passive: true, capture: true });

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

        // ========== BODY SCROLL LOCK (FIX BUG) ==========
        // Cuando el widget esta abierto, bloquear el scroll de la pagina para
        // que ningun focus-scroll del browser, ningun touch accidental, ni el
        // teclado virtual mobile puedan mover la pagina.
        // Pattern simple: al abrir widget, scroll al top y bloquear body.
        // Al cerrar, mantener Y=0 (hero completo visible) en lugar de
        // restaurar la posicion anterior.
        // Razon: el widget de busqueda solo es usable cuando estas cerca
        // del hero (fade lo oculta abajo). Asi que despues de cerrar, lo
        // mas natural es quedarse arriba.
        function lockBodyScroll() {
            // Scroll al top primero (asi el hero se ve completo)
            window.scrollTo(0, 0);

            // Bloquear scroll del body con position:fixed
            document.body.style.position = 'fixed';
            document.body.style.top = '0';
            document.body.style.left = '0';
            document.body.style.right = '0';
            document.body.style.width = '100%';
            document.body.style.overflow = 'hidden';
        }

        function unlockBodyScroll() {
            // Restaurar estilos del body
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.left = '';
            document.body.style.right = '';
            document.body.style.width = '';
            document.body.style.overflow = '';

            // Asegurar que queda en Y=0 (top, hero completo visible)
            // Esto evita cualquier "scroll fantasma" residual del browser
            window.scrollTo(0, 0);
        }

        function collapseSearch() {
            if (!isExpanded) return;
            isExpanded = false;

            // Desbloquear scroll del body
            unlockBodyScroll();

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

            // Bloquear scroll del body (esto tambien hace scroll a top primero)
            lockBodyScroll();

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

