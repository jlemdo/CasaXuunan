<body class="has-menu-bar">

    <div id="wrapper">
        <!-- header begin -->
        <header class="header-fullwidth menu-expand transparent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="de-flex">
                            <div class="de-flex-col">
                                <!-- logo begin -->
                                <div id="logo">
                                    <a href="index.php">
                                        <img class="logo" src="images/logo.png" alt="">
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
                                        <a href="/index.php" class="<?= $current_page === 'index.php' ? 'active-menu' : '' ?>">Inicio</a>
                                    </li>
                                    <li>
                                        <a href="about.php" class="<?= $current_page === 'about.php' ? 'active-menu' : '' ?>">Nosotros</a>
                                    </li>
                                    <li>
                                        <a href="rooms.php" class="<?= $current_page === 'rooms.php' ? 'active-menu' : '' ?>">Habitaciones</a>
                                    </li>
                                    <li>
                                        <a href="gallery.php" class="<?= $current_page === 'gallery.php' ? 'active-menu' : '' ?>">Galería</a>
                                    </li>
                                    <li>
                                        <a href="contact.php" class="<?= $current_page === 'contact.php' ? 'active-menu' : '' ?>">Contacto</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="de-flex-col">
                                <div class="d-extra">
                                    <a class="btn-main" href="/rooms.php">Reservas</a>
                                </div>
                                <div id="menu-btn"></div>
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
                                    <img class="logo" src="images/logo.png" alt="">
                                </a>

                                <div class="spacer-single"></div>

                                <!-- mainmenu begin -->
                                <ul id="mo-menu">
                                    <?php
                                    // Obtiene la ruta actual (sin dominio)
                                    $current_page = basename($_SERVER['REQUEST_URI']);
                                    ?>
                                    <li><a href="index.php" class="<?= $current_page === 'index.php' ? 'active-menu' : '' ?>">Inicio</a></li>
                                    <li><a href="about.php" class="<?= $current_page === 'about.php' ? 'active-menu' : '' ?>">Nosotros</a></li>
                                    <li><a href="rooms.php" class="<?= $current_page === 'rooms.php' ? 'active-menu' : '' ?>">Habitaciones</a></li>
                                    <li><a href="gallery.php" class="<?= $current_page === 'gallery.php' ? 'active-menu' : '' ?>">Galería</a></li>
                                    <li><a href="contact.php" class="<?= $current_page === 'contact.php' ? 'active-menu' : '' ?>">Contacto</a></li>
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