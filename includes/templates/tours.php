<div id="background" data-bgimage="url(images/background/6.jpg) fixed"></div>
        <div id="content-absolute">

            <!-- subheader -->
            <section id="subheader" class="no-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4><?php echo t('tours_subtitle'); ?></h4>
                            <h1><?php echo t('tours_title'); ?></h1>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-main" class="no-bg no-top" aria-label="section-menu">
                <div class="container">

                    <!-- Introducción y llamada a la acción principal -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2 text-center">
                            <p class="lead mb-4"><?php echo t('tours_intro'); ?></p>
                            <div class="mb-4">
                                <a href="#section-packages" class="btn-main btn-lg">
                                    <i class="fa fa-compass mr-2"></i><?php echo t('tours_cta_button'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tipos de Tours en cards -->
                    <div class="row g-4 mb-5 justify-content-center">

                        <!-- Aventura Cenote -->
                        <div class="col-md-5">
                            <div class="feature-box feature-box-style-3 h-100">
                                <div class="feature-box-icon">
                                    <i class="fa fa-tint id-color"></i>
                                </div>
                                <div class="feature-box-info">
                                    <h4><?php echo t('tours_cenotes_title'); ?></h4>
                                    <p><?php echo t('tours_cenotes_desc'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Ruta Arqueológica -->
                        <div class="col-md-5">
                            <div class="feature-box feature-box-style-3 h-100">
                                <div class="feature-box-icon">
                                    <i class="fa fa-university id-color"></i>
                                </div>
                                <div class="feature-box-info">
                                    <h4><?php echo t('tours_archaeological_title'); ?></h4>
                                    <p><?php echo t('tours_archaeological_desc'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2 text-center">
                            <blockquote class="testimonial">
                                <p><?php echo t('tours_testimonial'); ?></p>
                            </blockquote>
                        </div>
                    </div>

                    <!-- Paquetes de Tours -->
                    <div id="section-packages" class="row mb-5">
                        <div class="col-md-12">
                            <div class="text-center mb-4">
                                <h3 class="id-color"><?php echo t('tours_packages_title'); ?></h3>
                                <p class="lead"><?php echo t('tours_packages_subtitle'); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <!-- TOUR 1 -->
                        <div class="col-md-4">
                            <div class="pricing-box featured">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('tours_maya_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">2,000</span>
                                        <span class="period">MXN / persona</span>
                                    </div>
                                    <span class="duration"><?php echo t('tours_maya_duration'); ?></span>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('tours_maya_item1'); ?></li>
                                        <li><?php echo t('tours_maya_item2'); ?></li>
                                        <li><?php echo t('tours_maya_item3'); ?></li>
                                        <li><?php echo t('tours_maya_item4'); ?></li>
                                        <li><?php echo t('tours_maya_item5'); ?></li>
                                        <li><?php echo t('tours_maya_item6'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- TOUR 2 -->
                        <div class="col-md-4">
                            <div class="pricing-box featured highlight">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('tours_adventure_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">1,900</span>
                                        <span class="period">MXN / persona</span>
                                    </div>
                                    <span class="duration"><?php echo t('tours_adventure_duration'); ?></span>
                                    <div class="popular-tag"><?php echo t('tours_adventure_popular'); ?></div>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('tours_adventure_item1'); ?></li>
                                        <li><?php echo t('tours_adventure_item2'); ?></li>
                                        <li><?php echo t('tours_adventure_item3'); ?></li>
                                        <li><?php echo t('tours_adventure_item4'); ?></li>
                                        <li><?php echo t('tours_adventure_item5'); ?></li>
                                        <li><?php echo t('tours_adventure_item6'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- TOUR 3 -->
                        <div class="col-md-4">
                            <div class="pricing-box featured">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('tours_pink_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">2,500</span>
                                        <span class="period">MXN / persona</span>
                                    </div>
                                    <span class="duration"><?php echo t('tours_pink_duration'); ?></span>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('tours_pink_item1'); ?></li>
                                        <li><?php echo t('tours_pink_item2'); ?></li>
                                        <li><?php echo t('tours_pink_item3'); ?></li>
                                        <li><?php echo t('tours_pink_item4'); ?></li>
                                        <li><?php echo t('tours_pink_item5'); ?></li>
                                        <li><?php echo t('tours_pink_item6'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de reserva -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2">
                            <div class="text-center mb-4">
                                <h3 class="id-color"><?php echo t('tours_booking_title'); ?></h3>
                                <p class="lead"><?php echo t('tours_booking_subtitle'); ?></p>
                            </div>

                            <form id="whatsapp-form" class="contact-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="<?php echo t('tours_form_name'); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="<?php echo t('tours_form_phone'); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select id="paquete" name="paquete" class="form-control" required>
                                            <option value=""><?php echo t('tours_form_package'); ?></option>
                                            <option value="Maravilla Maya y Cenotes Sagrados"><?php echo t('tours_maya_title'); ?> ($2,000)</option>
                                            <option value="Aventura Arqueologica y Cenotes"><?php echo t('tours_adventure_title'); ?> ($1,900)</option>
                                            <option value="Magia Rosa y Arqueologia"><?php echo t('tours_pink_title'); ?> ($2,500)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="number" id="personas" name="personas" class="form-control" placeholder="<?php echo t('tours_form_people'); ?>" min="1" max="15" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="date" id="fecha" name="fecha" class="form-control" placeholder="<?php echo t('tours_form_date'); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select id="edad" name="edad" class="form-control" required>
                                            <option value=""><?php echo t('tours_form_age'); ?></option>
                                            <option value="18-30 años"><?php echo t('tours_form_age_18_30'); ?></option>
                                            <option value="31-50 años"><?php echo t('tours_form_age_31_50'); ?></option>
                                            <option value="51-65 años"><?php echo t('tours_form_age_51_65'); ?></option>
                                            <option value="65+ años"><?php echo t('tours_form_age_65plus'); ?></option>
                                            <option value="Grupo mixto"><?php echo t('tours_form_age_mixed'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <textarea id="comentarios" name="comentarios" class="form-control" rows="3" placeholder="<?php echo t('tours_form_comments'); ?>"></textarea>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn-main btn-lg">
                                        <i class="fa fa-whatsapp mr-2"></i><?php echo t('tours_form_submit'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Línea divisoria -->
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <div style="border-top: 1px solid rgba(255,255,255,0.3); margin: 20px 0;"></div>
                            <p style="color: white;"><?php echo t('tours_divider_text'); ?></p>
                            <a href="https://mpago.li/2JmGRPh" class="btn-line btn-lg">
                                <i class="fa fa-credit-card mr-2"></i><?php echo t('tours_mercadopago_button'); ?>
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
                                                <a href="images/slider/1.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/1.jpg" alt="Tours en Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto9">
                                                <a href="images/slider/2.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/2.jpg" alt="Experiencias de turismo" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto10">
                                                <a href="images/slider/3.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/3.jpg" alt="Aventuras en Yucatán" class="cover-image">
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
