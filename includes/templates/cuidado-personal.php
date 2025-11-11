<div id="background" data-bgimage="url(images/background/6.jpg) fixed"></div>
        <div id="content-absolute">

            <!-- subheader -->
            <section id="subheader" class="no-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4><?php echo t('personal_care_subtitle'); ?></h4>
                            <h1><?php echo t('personal_care_title'); ?></h1>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-main" class="no-bg no-top" aria-label="section-menu">
                <div class="container">

                    <!-- Introducción y llamada a la acción principal -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2 text-center">
                            <p class="lead mb-4"><?php echo t('personal_care_intro'); ?></p>
                            <div class="mb-4">
                                <a href="#section-packages" class="btn-main btn-lg">
                                    <i class="fa fa-hand-paper-o mr-2"></i><?php echo t('personal_care_cta_button'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios en cards -->
                    <div class="row g-4 mb-5 justify-content-center">

                        <!-- Manicura Spa -->
                        <div class="col-md-5">
                            <div class="feature-box feature-box-style-3 h-100">
                                <div class="feature-box-icon">
                                    <i class="fa fa-hand-peace-o id-color"></i>
                                </div>
                                <div class="feature-box-info">
                                    <h4><?php echo t('personal_care_manicure_title'); ?></h4>
                                    <p><?php echo t('personal_care_manicure_desc'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Pedicura Spa -->
                        <div class="col-md-5">
                            <div class="feature-box feature-box-style-3 h-100">
                                <div class="feature-box-icon">
                                    <i class="fa fa-leaf id-color"></i>
                                </div>
                                <div class="feature-box-info">
                                    <h4><?php echo t('personal_care_pedicure_title'); ?></h4>
                                    <p><?php echo t('personal_care_pedicure_desc'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2 text-center">
                            <blockquote class="testimonial">
                                <p><?php echo t('personal_care_testimonial'); ?></p>
                            </blockquote>
                        </div>
                    </div>

                    <!-- Paquetes de Cuidado Personal -->
                    <div id="section-packages" class="row mb-5">
                        <div class="col-md-12">
                            <div class="text-center mb-4">
                                <h3 class="id-color"><?php echo t('personal_care_packages_title'); ?></h3>
                                <p class="lead"><?php echo t('personal_care_packages_subtitle'); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <!-- Manicura Clásica -->
                        <div class="col-md-4">
                            <div class="pricing-box featured">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('personal_care_manicure_package_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">600</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('personal_care_manicure_package_duration'); ?></span>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('personal_care_manicure_package_item1'); ?></li>
                                        <li><?php echo t('personal_care_manicure_package_item2'); ?></li>
                                        <li><?php echo t('personal_care_manicure_package_item3'); ?></li>
                                        <li><?php echo t('personal_care_manicure_package_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Pedicura Deluxe -->
                        <div class="col-md-4">
                            <div class="pricing-box featured highlight">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('personal_care_pedicure_package_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">800</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('personal_care_pedicure_package_duration'); ?></span>
                                    <div class="popular-tag"><?php echo t('personal_care_pedicure_package_popular'); ?></div>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('personal_care_pedicure_package_item1'); ?></li>
                                        <li><?php echo t('personal_care_pedicure_package_item2'); ?></li>
                                        <li><?php echo t('personal_care_pedicure_package_item3'); ?></li>
                                        <li><?php echo t('personal_care_pedicure_package_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Paquete Completo -->
                        <div class="col-md-4">
                            <div class="pricing-box featured">
                                <div class="pricing-box-header">
                                    <h5><?php echo t('personal_care_combo_package_title'); ?></h5>
                                    <div class="price">
                                        <span class="currency">$</span>
                                        <span class="amount">1,200</span>
                                        <span class="period">MXN</span>
                                    </div>
                                    <span class="duration"><?php echo t('personal_care_combo_package_duration'); ?></span>
                                </div>
                                <div class="pricing-box-content">
                                    <ul>
                                        <li><?php echo t('personal_care_combo_package_item1'); ?></li>
                                        <li><?php echo t('personal_care_combo_package_item2'); ?></li>
                                        <li><?php echo t('personal_care_combo_package_item3'); ?></li>
                                        <li><?php echo t('personal_care_combo_package_item4'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de reserva -->
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2">
                            <div class="text-center mb-4">
                                <h3 class="id-color"><?php echo t('personal_care_booking_title'); ?></h3>
                                <p class="lead"><?php echo t('personal_care_booking_subtitle'); ?></p>
                            </div>

                            <form id="whatsapp-form" class="contact-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="<?php echo t('personal_care_form_name'); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="<?php echo t('personal_care_form_phone'); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select id="paquete" name="paquete" class="form-control" required>
                                            <option value=""><?php echo t('personal_care_form_package'); ?></option>
                                            <option value="Manicura Spa"><?php echo t('personal_care_manicure_package_title'); ?> ($600)</option>
                                            <option value="Pedicura Spa Deluxe"><?php echo t('personal_care_pedicure_package_title'); ?> ($800)</option>
                                            <option value="Paquete Manos y Pies"><?php echo t('personal_care_combo_package_title'); ?> ($1,200)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="date" id="fecha" name="fecha" class="form-control" placeholder="<?php echo t('personal_care_form_date'); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select id="esmalte" name="esmalte" class="form-control" required>
                                            <option value=""><?php echo t('personal_care_form_polish_type'); ?></option>
                                            <option value="Esmalte tradicional"><?php echo t('personal_care_form_polish_traditional'); ?></option>
                                            <option value="Esmalte de gel"><?php echo t('personal_care_form_polish_gel'); ?></option>
                                            <option value="Colores naturales"><?php echo t('personal_care_form_polish_natural'); ?></option>
                                            <option value="Sin esmalte"><?php echo t('personal_care_form_polish_none'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select id="alergias" name="alergias" class="form-control" required>
                                            <option value=""><?php echo t('personal_care_form_allergies'); ?></option>
                                            <option value="Sin alergias"><?php echo t('personal_care_form_allergies_none'); ?></option>
                                            <option value="Alergias químicos"><?php echo t('personal_care_form_allergies_chemicals'); ?></option>
                                            <option value="Alergias fragancias"><?php echo t('personal_care_form_allergies_fragrances'); ?></option>
                                            <option value="Otras alergias"><?php echo t('personal_care_form_allergies_other'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <textarea id="comentarios" name="comentarios" class="form-control" rows="3" placeholder="<?php echo t('personal_care_form_comments'); ?>"></textarea>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn-main btn-lg">
                                        <i class="fa fa-whatsapp mr-2"></i><?php echo t('personal_care_form_submit'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Línea divisoria -->
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <div style="border-top: 1px solid rgba(255,255,255,0.3); margin: 20px 0;"></div>
                            <p style="color: white;"><?php echo t('personal_care_divider_text'); ?></p>
                            <a href="https://mpago.li/2JmGRPh" class="btn-line btn-lg">
                                <i class="fa fa-credit-card mr-2"></i><?php echo t('personal_care_mercadopago_button'); ?>
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
                                                    <img loading="lazy" src="images/gallery/gallery-item-1.jpg" alt="Sala de manicura y pedicura" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto2">
                                                <a href="images/gallery/gallery-item-2.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-2.jpg" alt="Productos de cuidado personal" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto3">
                                                <a href="images/gallery/gallery-item-3.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-3.jpg" alt="Ambiente de spa para manos y pies" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto4">
                                                <a href="images/gallery/gallery-item-4.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-4.jpg" alt="Detalle de tratamiento de pedicura" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto5">
                                                <a href="images/gallery/gallery-item-5.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-5.jpg" alt="Esmaltes y herramientas profesionales" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto6">
                                                <a href="images/gallery/gallery-item-6.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-6.jpg" alt="Experiencia de spa en Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto7">
                                                <a href="images/gallery/gallery-item-7.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/gallery/gallery-item-7.jpg" alt="Zona de relajación y cuidado" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto8">
                                                <a href="images/background/7.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/7.jpg" alt="Instalaciones de Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto9">
                                                <a href="images/background/8.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/8.jpg" alt="Suite de bienestar y cuidado" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto10">
                                                <a href="images/background/9.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/background/9.jpg" alt="Espacio de relajación y belleza" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto11">
                                                <a href="images/slider/1.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/1.jpg" alt="Ambiente de Casa Xuunan" class="cover-image">
                                                </a>
                                            </div>
                                            <div class="item foto12">
                                                <a href="images/slider/2.jpg" class="image-popup-gallery">
                                                    <img loading="lazy" src="images/slider/2.jpg" alt="Instalaciones premium para el cuidado" class="cover-image">
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
