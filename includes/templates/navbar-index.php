<body class="has-menu-bar">

    <div id="wrapper">
        <!-- header begin -->
        <header class="header-fullwidth transparent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <?php
                        $current_page = basename($_SERVER['REQUEST_URI']);
                        $current_lang = getCurrentLanguage();
                        $alternates = getAlternateLanguages();

                        // Banderas por idioma (nativas, no inventadas)
                        $flags = [
                            'es' => '🇲🇽', // Mexico (no Espana, porque somos un B&B en Mexico)
                            'en' => '🇺🇸', // USA (mercado angloparlante principal)
                            'fr' => '🇫🇷', // Francia
                        ];
                        ?>
                        <!-- Header HOME simplificado: hamburguesa + logo + idioma -->
                        <div class="home-header-simple">
                            <!-- 1. Hamburguesa a la izquierda -->
                            <div class="home-header-left">
                                <div id="menu-btn" class="menu-btn-mobile-overlay"></div>
                            </div>

                            <!-- 2. Logo centrado -->
                            <div class="home-header-center">
                                <div id="logo">
                                    <a href="index.php">
                                        <img class="logo" src="images/logo/blanco.png" alt="Casa Xuunan">
                                    </a>
                                </div>
                            </div>

                            <!-- 3. Selector de idioma (3 idiomas con dropdown) -->
                            <div class="home-header-right">
                                <div class="home-lang-wrapper">
                                    <button type="button"
                                            class="home-lang-btn home-lang-toggle"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                            aria-label="<?php echo getLanguageNativeName($current_lang); ?>"
                                            onclick="this.parentElement.classList.toggle('open'); this.setAttribute('aria-expanded', this.parentElement.classList.contains('open'));">
                                        <span class="home-lang-flag" aria-hidden="true"><?php echo $flags[$current_lang] ?? '🌐'; ?></span>
                                        <span class="home-lang-code"><?php echo getLanguageCode($current_lang); ?></span>
                                        <span class="home-lang-arrow" aria-hidden="true">▾</span>
                                    </button>
                                    <ul class="home-lang-menu" role="menu">
                                        <?php foreach ($alternates as $alt_lang): ?>
                                        <li role="none">
                                            <a href="?lang=<?php echo $alt_lang; ?>"
                                               role="menuitem"
                                               hreflang="<?php echo $alt_lang; ?>"
                                               class="home-lang-option">
                                                <span class="home-lang-option-flag" aria-hidden="true"><?php echo $flags[$alt_lang] ?? '🌐'; ?></span>
                                                <span class="home-lang-option-name"><?php echo getLanguageNativeName($alt_lang); ?></span>
                                                <span class="home-lang-option-code"><?php echo getLanguageCode($alt_lang); ?></span>
                                            </a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <!-- header close -->

        <!-- menu overlay begin -->
        <div id="menu-overlay" class="slideDown">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="col-md-12">
                        <div id="mo-button-close">
                            <div class="line-1"></div>
                            <div class="line-2"></div>
                        </div>

                        <div class="pt80 pb80">
                            <div class="mo-nav text-center">
                                <a href="index.php">
                                    <img class="logo" src="images/logo/blanco.png" alt="Casa Xuunan">
                                </a>

                                <div class="spacer-single"></div>

                                <!-- mainmenu begin -->
                                <ul id="mo-menu">
                                    <?php
                                    // Obtiene la ruta actual (sin dominio)
                                    $current_page = basename($_SERVER['REQUEST_URI']);
                                    ?>
                                    <li><a href="index.php" class="<?= $current_page === 'index.php' ? 'active-menu' : '' ?>"><?php echo t('nav_home'); ?></a></li>
                                    <li><a href="rooms.php" class="<?= $current_page === 'rooms.php' ? 'active-menu' : '' ?>"><?php echo t('nav_rooms'); ?></a></li>
                                    <li><a href="services.php" class="<?= $current_page === 'services.php' ? 'active-menu' : '' ?>"><?php echo t('nav_services'); ?></a></li>
                                    <li><a href="gallery.php" class="<?= $current_page === 'gallery.php' ? 'active-menu' : '' ?>"><?php echo t('nav_gallery'); ?></a></li>
                                    <li><a href="contact.php" class="<?= $current_page === 'contact.php' ? 'active-menu' : '' ?>"><?php echo t('nav_contact'); ?></a></li>
                                    <?php foreach ($alternates as $alt_lang): ?>
                                    <li><a href="?lang=<?php echo $alt_lang; ?>" class="lang-switcher-mobile" hreflang="<?php echo $alt_lang; ?>"><?php echo $flags[$alt_lang] ?? '🌐'; ?> <?php echo getLanguageNativeName($alt_lang); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>

                                <!-- mainmenu close -->

                                <!-- Social + WhatsApp -->
                                <div class="mo-footer">
                                    <div class="mo-social">
                                        <a href="https://www.facebook.com/people/Casa-Xuunan/61578964945156/" target="_blank"><i class="fa fa-facebook"></i></a>
                                        <a href="https://www.instagram.com/casa_xuunan/" target="_blank"><i class="fa fa-instagram"></i></a>
                                        <a href="https://api.whatsapp.com/send?phone=5219852580599" target="_blank"><i class="fa fa-whatsapp"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- menu overlay close -->
    </div>

    <!-- Lang switcher home: cerrar dropdown al hacer click fuera o presionar Escape -->
    <script>
    (function() {
        var wrapper = document.querySelector('.home-lang-wrapper');
        if (!wrapper) return;
        var toggle = wrapper.querySelector('.home-lang-toggle');

        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target) && wrapper.classList.contains('open')) {
                wrapper.classList.remove('open');
                if (toggle) toggle.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && wrapper.classList.contains('open')) {
                wrapper.classList.remove('open');
                if (toggle) toggle.setAttribute('aria-expanded', 'false');
                if (toggle) toggle.focus();
            }
        });
    })();
    </script>