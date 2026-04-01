<div id="background" data-bgimage="url(images/background/20.jpg) 100% 100% fixed"></div>
            <div id="content-absolute">


                <!-- subheader -->
                <section id="subheader" class="no-bg">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4><?php echo t('contact_subtitle'); ?></h4>
                                <h1><?php echo t('contact_title'); ?></h1>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="section-main" class="no-bg no-top" aria-label="section-menu">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="de-content-overlay">

                                    <!-- WhatsApp CTA Principal -->
                                    <div class="contact-whatsapp-cta">
                                        <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(getCurrentLanguage() === 'es' ? '¡Hola! Me gustaría obtener información sobre Casa Xu\'unan' : 'Hi! I would like to get information about Casa Xu\'unan'); ?>"
                                           class="contact-whatsapp-btn"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           onclick="if(typeof gtag==='function'){gtag('event','conversion',{'send_to':'AW-18041631980/6AUyCN_D3pMcEOzp9ZpD','value':1400,'currency':'MXN'});}">
                                            <i class="fa fa-whatsapp"></i>
                                            <?php echo t('contact_whatsapp_cta'); ?>
                                        </a>
                                        <p class="contact-whatsapp-subtitle"><?php echo t('contact_whatsapp_subtitle'); ?></p>
                                    </div>

                                    <!-- Info Cards -->
                                    <div class="contact-info-cards">
                                        <div class="contact-info-card">
                                            <div class="contact-info-icon location">
                                                <i class="fa fa-map-marker"></i>
                                            </div>
                                            <h5><?php echo t('contact_address'); ?></h5>
                                            <p>
                                                <a href="https://maps.google.com/?q=Casa+Xu'unan+Valladolid+Yucatan" target="_blank" rel="noopener noreferrer">
                                                    C. 49 235, Sisal<br>Valladolid, Yucat&aacute;n
                                                </a>
                                            </p>
                                        </div>
                                        <div class="contact-info-card">
                                            <div class="contact-info-icon phone">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <h5><?php echo t('contact_phone_label'); ?></h5>
                                            <p><a href="tel:+529852580599">(+52) 985 258 0599</a></p>
                                        </div>
                                        <div class="contact-info-card">
                                            <div class="contact-info-icon hours">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <h5><?php echo t('contact_hours_label'); ?></h5>
                                            <p><?php echo t('contact_hours_value'); ?></p>
                                        </div>
                                    </div>

                                    <!-- Divider -->
                                    <div class="contact-form-divider">
                                        <?php echo getCurrentLanguage() === 'es' ? 'o env&iacute;anos un mensaje' : 'or send us a message'; ?>
                                    </div>

                                    <div class="row">
                                        <!-- Formulario -->
                                        <div class="col-lg-7">
                                            <div class="contact-form-section">
                                                <form name="contactForm" id='contact_form' method="post">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div id='name_error' class='error' style="display:none;"><?php echo t('contact_error_name'); ?></div>
                                                            <div class="mb10">
                                                                <input type='text' name='Name' id='name' class="form-control" placeholder="<?php echo t('contact_name'); ?>" required>
                                                            </div>

                                                            <div id='email_error' class='error' style="display:none;"><?php echo t('contact_error_email'); ?></div>
                                                            <div class="mb10">
                                                                <input type='email' name='Email' id='email' class="form-control" placeholder="<?php echo t('contact_email'); ?>">
                                                            </div>

                                                            <div id='phone_error' class='error' style="display:none;"><?php echo t('contact_error_phone'); ?></div>
                                                            <div class="mb10">
                                                                <input type='tel' name='phone' id='phone' class="form-control" placeholder="<?php echo t('contact_phone'); ?>">
                                                            </div>

                                                            <div id='contact_error' class='error' style="display:none;"><?php echo t('contact_error_contact'); ?></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div id='message_error' class='error' style="display:none;"><?php echo t('contact_error_message'); ?></div>
                                                            <div>
                                                                <textarea name='message' id='message' class="form-control" placeholder="<?php echo t('contact_message'); ?>" required></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <p id='submit' class="mt20">
                                                                <input type='submit' id='send_message' value='<?php echo t('contact_send'); ?>' class="btn btn-line">
                                                            </p>

                                                            <!-- Alertas -->
                                                            <div id='success_message' class='xuunan-alert xuunan-alert-success' style="display:none;">
                                                                <i class="fa fa-check-circle"></i>
                                                                <span><?php echo t('contact_success'); ?></span>
                                                            </div>
                                                            <div id='error_message' class='xuunan-alert xuunan-alert-error' style="display:none;">
                                                                <i class="fa fa-exclamation-circle"></i>
                                                                <span><?php echo t('contact_error'); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <!-- Email secundario -->
                                                <div class="contact-email-secondary">
                                                    <span><?php echo t('contact_email_label'); ?>: <a href="mailto:reservas@casaxuunan.com">reservas@casaxuunan.com</a></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mapa -->
                                        <div class="col-lg-5">
                                            <div class="contact-map-container">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14930.418508272227!2d-88.2087843!3d20.6856583!3m2!1i1024!2i768!4f15!3m3!1m2!1s0x8f510b2730300389%3A0xa88c388eb4a4ead7!2sCasa%20Xu&#39;unan!5e0!3m2!1ses-419!2smx!4v1730254269839!5m2!1ses-419!2smx" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>

