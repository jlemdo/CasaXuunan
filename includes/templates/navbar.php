<body class="has-menu-bar">

    <!-- float text begin -->
    <div class="float-text">
        <div class="de_social-icons">
            <a href="https://www.facebook.com/p/Casa-Xuunan-100091497343251/?locale=ne_NP&_rdr" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
            <a href="https://api.whatsapp.com/send?phone=5219852580599" target="_blank"><i class="fa fa-whatsapp fa-lg"></i></a>
        </div>
        <span><a href="/rooms.php">Reserva Ahora</a></span>
    </div>
    <!-- float text close -->

    <div id="wrapper">
        <!-- header begin -->
        <header class="header-fullwidth transparent">
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
                                    <li><a href="index.php">Inicio</a></li>
                                    </li>
                                    <li><a href="about.php">Nosotros</a></li>
                                    <li><a href="rooms.php">Habitaciones</a></li>
                                    <!-- <li><a href="booking.php">Reservas</a></li> -->
                                    <!-- <li><a href="02-offer.php">Ofertas</a></li> -->
                                    <!-- <li><a href="02-blog.php">Blog</a></li> -->
                                    <li><a href="gallery.php">Galería</a></li>
                                    <li><a href="contact.php">Contacto</a></li>
                                </ul>
                                <!-- mainmenu close -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- menu overlay close -->