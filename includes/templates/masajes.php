        <div id="background" data-bgimage="url(images/background/6.jpg) fixed"></div>
        <div id="content-absolute">

            <!-- subheader -->
            <section id="subheader" class="no-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4><?php echo t('massage_subtitle'); ?></h4>
                            <h1><?php echo t('massage_title'); ?></h1>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-main" class="no-bg no-top" aria-label="section-menu">
                <div class="container">

                    <!-- Introducción y llamada a la acción principal -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2 text-center">
                            <p class="lead mb-4"><?php echo t('massage_intro'); ?></p>
                            <div class="mb-4">
                                <a href="#section-packages" class="btn-main btn-lg">
                                    <i class="fa fa-hand-paper-o mr-2"></i><?php echo t('massage_cta_button'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios en cards -->
                    <div class="row g-4 mb-5 justify-content-center">

                        <!-- Quiromasaje Terapéutico -->
                        <div class="col-md-5">
                            <div class="feature-box feature-box-style-3 h-100">
                                <div class="feature-box-icon">
                                    <i class="fa fa-hand-paper-o id-color"></i>
                                </div>
                                <div class="feature-box-info">
                                    <h4><?php echo t('massage_therapeutic_title'); ?></h4>
                                    <p><?php echo t('massage_therapeutic_desc'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Quiromasaje Relajante -->
                        <div class="col-md-5">
                            <div class="feature-box feature-box-style-3 h-100">
                                <div class="feature-box-icon">
                                    <i class="fa fa-heart id-color"></i>
                                </div>
                                <div class="feature-box-info">
                                    <h4><?php echo t('massage_relaxing_title'); ?></h4>
                                    <p><?php echo t('massage_relaxing_desc'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2 text-center">
                            <blockquote class="testimonial">
                                <p><?php echo t('massage_testimonial'); ?></p>
                            </blockquote>
                        </div>
                    </div>

                    <!-- Paquetes Especiales -->
                    <div id="section-packages" class="row mb-5">
                        <div class="col-md-12">
                            <div class="text-center mb-4">
                                <h3 class="id-color"><?php echo t('massage_packages_title'); ?></h3>
                                <p class="lead"><?php echo t('massage_packages_subtitle'); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <!-- Sesión Express -->
                        <div class="col-md-4">
                            <div class="pricing-box featured">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('massage_express_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">1,000</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('massage_express_duration'); ?></span>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('massage_express_item1'); ?></li>
                                        <li><?php echo t('massage_express_item2'); ?></li>
                                        <li><?php echo t('massage_express_item3'); ?></li>
                                        <li><?php echo t('massage_express_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Sesión Integral -->
                        <div class="col-md-4">
                            <div class="pricing-box featured highlight">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('massage_integral_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">1,200</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('massage_integral_duration'); ?></span>
                                    <div class="popular-tag"><?php echo t('massage_integral_popular'); ?></div>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('massage_integral_item1'); ?></li>
                                        <li><?php echo t('massage_integral_item2'); ?></li>
                                        <li><?php echo t('massage_integral_item3'); ?></li>
                                        <li><?php echo t('massage_integral_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Experiencia Premium -->
                        <div class="col-md-4">
                            <div class="pricing-box featured">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('massage_premium_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">1,500</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('massage_premium_duration'); ?></span>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('massage_premium_item1'); ?></li>
                                        <li><?php echo t('massage_premium_item2'); ?></li>
                                        <li><?php echo t('massage_premium_item3'); ?></li>
                                        <li><?php echo t('massage_premium_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de reserva -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2">
                            <div class="text-center mb-4">
                                <h3 class="id-color"><?php echo t('massage_booking_title'); ?></h3>
                                <p class="lead"><?php echo t('massage_booking_subtitle'); ?></p>
                            </div>

                            <form id="whatsapp-form" class="contact-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="<?php echo t('massage_form_name'); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="<?php echo t('massage_form_phone'); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select id="paquete" name="paquete" class="form-control" required>
                                            <option value=""><?php echo t('massage_form_package'); ?></option>
                                            <option value="Express"><?php echo t('massage_express_title'); ?> (45 min - $1,000)</option>
                                            <option value="Integral"><?php echo t('massage_integral_title'); ?> (1 hora - $1,200)</option>
                                            <option value="Premium"><?php echo t('massage_premium_title'); ?> (1.5 horas - $1,500)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select id="tipo" name="tipo" class="form-control" required>
                                            <option value=""><?php echo t('massage_form_type'); ?></option>
                                            <option value="Relajante"><?php echo t('massage_form_type_relaxing'); ?></option>
                                            <option value="Terapeutico"><?php echo t('massage_form_type_therapeutic'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select id="intensidad" name="intensidad" class="form-control" required>
                                            <option value=""><?php echo t('massage_form_intensity'); ?></option>
                                            <option value="Suave"><?php echo t('massage_form_intensity_soft'); ?></option>
                                            <option value="Media"><?php echo t('massage_form_intensity_medium'); ?></option>
                                            <option value="Fuerte"><?php echo t('massage_form_intensity_strong'); ?></option>
                                            <option value="Personalizada"><?php echo t('massage_form_intensity_custom'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select id="zonas" name="zonas" class="form-control" required>
                                            <option value=""><?php echo t('massage_form_zones'); ?></option>
                                            <option value="Cuello y hombros"><?php echo t('massage_form_zones_neck'); ?></option>
                                            <option value="Espalda completa"><?php echo t('massage_form_zones_back'); ?></option>
                                            <option value="Espalda baja"><?php echo t('massage_form_zones_lumbar'); ?></option>
                                            <option value="Piernas y pies"><?php echo t('massage_form_zones_legs'); ?></option>
                                            <option value="Cuerpo completo"><?php echo t('massage_form_zones_full'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select id="condiciones" name="condiciones" class="form-control" required>
                                            <option value=""><?php echo t('massage_form_conditions'); ?></option>
                                            <option value="Sin condiciones"><?php echo t('massage_form_conditions_none'); ?></option>
                                            <option value="Lesiones recientes"><?php echo t('massage_form_conditions_injuries'); ?></option>
                                            <option value="Embarazo"><?php echo t('massage_form_conditions_pregnancy'); ?></option>
                                            <option value="Problemas circulatorios"><?php echo t('massage_form_conditions_circulatory'); ?></option>
                                            <option value="Alergias"><?php echo t('massage_form_conditions_allergies'); ?></option>
                                            <option value="Otras condiciones"><?php echo t('massage_form_conditions_other'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="date" id="fecha" name="fecha" class="form-control" placeholder="<?php echo t('massage_form_date'); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <textarea id="comentarios" name="comentarios" class="form-control" rows="3" placeholder="<?php echo t('massage_form_comments'); ?>"></textarea>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn-main btn-lg">
                                        <i class="fa fa-whatsapp mr-2"></i><?php echo t('massage_form_submit'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Línea divisoria -->
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <div style="border-top: 1px solid rgba(255,255,255,0.3); margin: 20px 0;"></div>
                            <p style="color: white;"><?php echo t('massage_divider_text'); ?></p>
                            <a href="https://mpago.li/2JmGRPh" class="btn-line btn-lg">
                                <i class="fa fa-credit-card mr-2"></i><?php echo t('massage_mercadopago_button'); ?>
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
                                                    <img loading="lazy" src="images/gallery/gallery-item-1.jpg" alt="Ambiente relajante Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto2">
                                                <a href="images/gallery/gallery-item-2.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-2.jpg" alt="Espacios de bienestar" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto3">
                                                <a href="images/gallery/gallery-item-3.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-3.jpg" alt="Instalaciones Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto4">
                                                <a href="images/gallery/gallery-item-4.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-4.jpg" alt="Zona de relajación" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto5">
                                                <a href="images/gallery/gallery-item-5.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-5.jpg" alt="Ambiente spa Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto6">
                                                <a href="images/gallery/gallery-item-6.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-6.jpg" alt="Experiencias de bienestar" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto7">
                                                <a href="images/gallery/gallery-item-7.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-7.jpg" alt="Espacio de relajación" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto8">
                                                <a href="images/background/1.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/1.jpg" alt="Sala de masajes" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto9">
                                                <a href="images/background/2.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/2.jpg" alt="Espacio de bienestar" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto10">
                                                <a href="images/background/3.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/3.jpg" alt="Ambiente de relajación" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto11">
                                                <a href="images/slider/1.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/1.jpg" alt="Casa Xuunan ambiente" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto12">
                                                <a href="images/slider/2.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/2.jpg" alt="Instalaciones premium" class="cover-image">
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
