<body class="has-menu-bar">

    <div id="wrapper">
        <!-- header begin -->
        <header class="header-fullwidth menu-expand transparent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="de-flex de-flex-mobile-vertical">
                            <div class="de-flex-col">
                                <!-- logo begin -->
                                <div id="logo">
                                    <a href="index.php">
                                        <img class="logo" src="images/logo/blanco.png" alt="Casa Xuunan">
                                    </a>
                                </div>
                                <!-- logo close -->
                            </div>

                            <div class="de-flex-col">
                                <ul id="mainmenu">
                                    <?php
                                    // Obtiene la ruta actual (sin dominio)
                                    $current_page = basename($_SERVER['REQUEST_URI']);
                                    ?>
                                    <li>
                                        <a href="/index.php" class="<?= $current_page === 'index.php' ? 'active-menu' : '' ?>"><?php echo t('nav_home'); ?></a>
                                    </li>
                                    <li>
                                        <a href="rooms.php" class="<?= $current_page === 'rooms.php' ? 'active-menu' : '' ?>"><?php echo t('nav_rooms'); ?></a>
                                    </li>
                                    <li>
                                        <a href="services.php" class="<?= $current_page === 'services.php' ? 'active-menu' : '' ?>"><?php echo t('nav_services'); ?></a>
                                    </li>
                                    <li>
                                        <a href="gallery.php" class="<?= $current_page === 'gallery.php' ? 'active-menu' : '' ?>"><?php echo t('nav_gallery'); ?></a>
                                    </li>
                                    <li>
                                        <a href="contact.php" class="<?= $current_page === 'contact.php' ? 'active-menu' : '' ?>"><?php echo t('nav_contact'); ?></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="de-flex-col de-flex-col-mobile">
                                <div class="d-extra">
                                    <!-- Language Switcher -->
                                    <a href="?lang=<?php echo switchLanguage(); ?>"
                                       class="lang-switcher"
                                       data-tooltip="<?php echo $current_lang === 'es' ? 'View site in English' : 'Ver sitio en Español'; ?>">
                                        <?php echo $current_lang === 'es' ? 'EN' : 'ES'; ?>
                                    </a>
                                    <a class="btn-main btn-mobile-reservas" href="/rooms.php"><?php echo t('btn_book'); ?></a>
                                </div>
                                <div id="menu-btn" class="menu-btn-mobile-overlay"></div>
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- menu overlay close -->
    </div>