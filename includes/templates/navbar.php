<body class="has-menu-bar">

    <!-- float text begin -->
    <div class="float-text">
        <div class="de_social-icons">
            <a href="https://www.facebook.com/people/Casa-Xuunan/61578964945156/" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
            <a href="https://www.instagram.com/casa_xuunan/" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
            <a href="https://api.whatsapp.com/send?phone=5219852580599" target="_blank"><i class="fa fa-whatsapp fa-lg"></i></a>
        </div>
        <span><a href="/rooms.php"><?php echo t('btn_book'); ?></a></span>
    </div>
    <!-- float text close -->

    <div id="wrapper">
        <!-- header begin -->
        <header class="header-fullwidth transparent">
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
                                        <a href="about.php" class="<?= $current_page === 'about.php' ? 'active-menu' : '' ?>"><?php echo t('nav_about'); ?></a>
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
                                    <!-- Garden temporalmente oculto -->
                                    <!--
                                    <li>
                                        <a href="garden.php" class="<?= $current_page === 'garden.php' || $current_page === 'plant.php' ? 'active-menu' : '' ?>"><?php echo t('nav_garden'); ?></a>
                                    </li>
                                    -->
                                    <li>
                                        <a href="blog.php" class="<?= strpos($current_page, 'blog') !== false ? 'active-menu' : '' ?>"><?php echo t('nav_blog'); ?></a>
                                    </li>
                                    <li>
                                        <a href="contact.php" class="<?= $current_page === 'contact.php' ? 'active-menu' : '' ?>"><?php echo t('nav_contact'); ?></a>
                                    </li>
                                </ul>
                            </div>


                            <div class="de-flex-col de-flex-col-mobile">
                                <div class="d-extra">
                                    <!-- Language Switcher -->
                                    <?php $current_lang = getCurrentLanguage(); ?>
                                    <a href="?lang=<?php echo switchLanguage(); ?>"
                                       class="lang-switcher"
                                       data-tooltip="<?php echo $current_lang === 'es' ? 'View site in English' : 'Ver sitio en Español'; ?>">
                                        <?php echo $current_lang === 'es' ? 'EN' : 'ES'; ?>
                                    </a>
                                    <a class="btn-main btn-mobile-reservas" href="/search.php"><?php echo t('btn_bookings'); ?></a>
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
                                    <li><a href="about.php" class="<?= $current_page === 'about.php' ? 'active-menu' : '' ?>"><?php echo t('nav_about'); ?></a></li>
                                    <li><a href="rooms.php" class="<?= $current_page === 'rooms.php' ? 'active-menu' : '' ?>"><?php echo t('nav_rooms'); ?></a></li>
                                    <li><a href="services.php" class="<?= $current_page === 'services.php' ? 'active-menu' : '' ?>"><?php echo t('nav_services'); ?></a></li>
                                    <li><a href="gallery.php" class="<?= $current_page === 'gallery.php' ? 'active-menu' : '' ?>"><?php echo t('nav_gallery'); ?></a></li>
                                    <!-- Garden temporalmente oculto -->
                                    <!--<li><a href="garden.php" class="<?= $current_page === 'garden.php' || $current_page === 'plant.php' ? 'active-menu' : '' ?>"><?php echo t('nav_garden'); ?></a></li>-->
                                    <li><a href="blog.php" class="<?= strpos($current_page, 'blog') !== false ? 'active-menu' : '' ?>"><?php echo t('nav_blog'); ?></a></li>
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
    </div>
    <!-- menu overlay close -->