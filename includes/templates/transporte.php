<div id="background" data-bgimage="url(images/background/6.jpg) fixed"></div>
        <div id="content-absolute">

            <!-- subheader -->
            <section id="subheader" class="no-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4><?php echo t('transport_subtitle'); ?></h4>
                            <h1><?php echo t('transport_title'); ?></h1>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-main" class="no-bg no-top" aria-label="section-menu">
                <div class="container">

                    <!-- Introducción y llamada a la acción principal -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2 text-center">
                            <p class="lead mb-4"><?php echo t('transport_intro'); ?></p>
                            <div class="mb-4">
                                <a href="#section-packages" class="btn-main btn-lg">
                                    <i class="fa fa-car mr-2"></i><?php echo t('transport_cta_button'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios en cards -->
                    <div class="row g-4 mb-5 justify-content-center">

                        <!-- Traslados Aeroportuarios -->
                        <div class="col-md-5">
                            <div class="feature-box feature-box-style-3 h-100">
                                <div class="feature-box-icon">
                                    <i class="fa fa-plane id-color"></i>
                                </div>
                                <div class="feature-box-info">
                                    <h4><?php echo t('transport_airport_title'); ?></h4>
                                    <p><?php echo t('transport_airport_desc'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Conexión Tulum -->
                        <div class="col-md-5">
                            <div class="feature-box feature-box-style-3 h-100">
                                <div class="feature-box-icon">
                                    <i class="fa fa-map-marker id-color"></i>
                                </div>
                                <div class="feature-box-info">
                                    <h4><?php echo t('transport_tulum_title'); ?></h4>
                                    <p><?php echo t('transport_tulum_desc'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2 text-center">
                            <blockquote class="testimonial">
                                <p><?php echo t('transport_testimonial'); ?></p>
                            </blockquote>
                        </div>
                    </div>

                    <!-- Rutas y Precios -->
                    <div id="section-packages" class="row mb-5">
                        <div class="col-md-12">
                            <div class="text-center mb-4">
                                <h3 class="id-color"><?php echo t('transport_packages_title'); ?></h3>
                                <p class="lead"><?php echo t('transport_packages_subtitle'); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <!-- Ruta Cancún -->
                        <div class="col-md-4">
                            <div class="pricing-box featured">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('transport_cancun_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">2,500</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('transport_cancun_duration'); ?></span>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('transport_cancun_item1'); ?></li>
                                        <li><?php echo t('transport_cancun_item2'); ?></li>
                                        <li><?php echo t('transport_cancun_item3'); ?></li>
                                        <li><?php echo t('transport_cancun_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Ruta Mérida -->
                        <div class="col-md-4">
                            <div class="pricing-box featured highlight">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('transport_merida_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">1,800</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('transport_merida_duration'); ?></span>
                                    <div class="popular-tag"><?php echo t('transport_merida_popular'); ?></div>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('transport_merida_item1'); ?></li>
                                        <li><?php echo t('transport_merida_item2'); ?></li>
                                        <li><?php echo t('transport_merida_item3'); ?></li>
                                        <li><?php echo t('transport_merida_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Ruta Tulum -->
                        <div class="col-md-4">
                            <div class="pricing-box featured">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('transport_tulum_route_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">2,200</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('transport_tulum_route_duration'); ?></span>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('transport_tulum_route_item1'); ?></li>
                                        <li><?php echo t('transport_tulum_route_item2'); ?></li>
                                        <li><?php echo t('transport_tulum_route_item3'); ?></li>
                                        <li><?php echo t('transport_tulum_route_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de reserva -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2">
                            <div class="text-center mb-4">
                                <h3 class="id-color"><?php echo t('transport_booking_title'); ?></h3>
                                <p class="lead"><?php echo t('transport_booking_subtitle'); ?></p>
                            </div>

                            <form id="whatsapp-form" class="contact-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="<?php echo t('transport_form_name'); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="<?php echo t('transport_form_phone'); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select id="ruta" name="ruta" class="form-control" required>
                                            <option value=""><?php echo t('transport_form_route'); ?></option>
                                            <option value="Xuunan-Cancun"><?php echo t('transport_form_route_cancun'); ?></option>
                                            <option value="Xuunan-Merida"><?php echo t('transport_form_route_merida'); ?></option>
                                            <option value="Xuunan-Tulum"><?php echo t('transport_form_route_tulum'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="number" id="pasajeros" name="pasajeros" class="form-control" placeholder="<?php echo t('transport_form_passengers'); ?>" min="1" max="8" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="date" id="fecha" name="fecha" class="form-control" placeholder="<?php echo t('transport_form_date'); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="time" id="hora" name="hora" class="form-control" placeholder="<?php echo t('transport_form_time'); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <textarea id="comentarios" name="comentarios" class="form-control" rows="3" placeholder="<?php echo t('transport_form_comments'); ?>"></textarea>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn-main btn-lg">
                                        <i class="fa fa-whatsapp mr-2"></i><?php echo t('transport_form_submit'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Línea divisoria -->
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <div style="border-top: 1px solid rgba(255,255,255,0.3); margin: 20px 0;"></div>
                            <p style="color: white;"><?php echo t('transport_divider_text'); ?></p>
                            <a href="https://mpago.li/2JmGRPh" class="btn-line btn-lg">
                                <i class="fa fa-credit-card mr-2"></i><?php echo t('transport_mercadopago_button'); ?>
                            </a>
                        </div>
                    </div>

                </div>

                    <!-- Separador antes de la galería -->
                    <div class="spacer-single"></div>

                                <section id="section-gallery" class="no-bg no-top" aria-label="section-gallery">
                                    <div class="container">
                                        <div id="carousel-rooms" class="gallery-grid">
                                            <div class="item foto1">
                                                <a href="images/gallery/gallery-item-1.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-1.jpg" alt="Vehículos de transporte Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto2">
                                                <a href="images/gallery/gallery-item-2.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-2.jpg" alt="Servicio de traslados premium" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto3">
                                                <a href="images/gallery/gallery-item-3.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-3.jpg" alt="Rutas hacia Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto4">
                                                <a href="images/gallery/gallery-item-4.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-4.jpg" alt="Comodidad en el traslado" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto5">
                                                <a href="images/gallery/gallery-item-5.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-5.jpg" alt="Llegada a Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto6">
                                                <a href="images/gallery/gallery-item-6.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-6.jpg" alt="Experiencia de viaje premium" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto7">
                                                <a href="images/gallery/gallery-item-7.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-7.jpg" alt="Conexiones regionales" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto8">
                                                <a href="images/background/4.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/4.jpg" alt="Destino Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto9">
                                                <a href="images/background/5.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/5.jpg" alt="Instalaciones de llegada" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto10">
                                                <a href="images/background/6.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/6.jpg" alt="Comodidades Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto11">
                                                <a href="images/slider/1.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/1.jpg" alt="Ambiente Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto12">
                                                <a href="images/slider/2.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/2.jpg" alt="Vista panorámica destino" class="cover-image">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
