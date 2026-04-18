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

                            <!-- 3. Boton idioma sencillo con fallback -->
                            <div class="home-header-right">
                                <a href="?lang=<?php echo switchLanguage(); ?>"
                                   class="lang-switcher home-lang-btn"
                                   aria-label="<?php echo $current_lang === 'es' ? 'Switch to English' : 'Cambiar a Español'; ?>">
                                    <span class="home-lang-flag" aria-hidden="true"><?php echo $current_lang === 'es' ? '🇺🇸' : '🇲🇽'; ?></span>
                                    <span class="home-lang-code"><?php echo $current_lang === 'es' ? 'EN' : 'ES'; ?></span>
                                </a>
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
                                    <li><a href="?lang=<?php echo switchLanguage(); ?>" class="lang-switcher-mobile"><?php echo $current_lang === 'es' ? 'English' : 'Español'; ?></a></li>
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