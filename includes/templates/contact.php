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
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-13">
                                                    <h3>Casa Xuunan Valladolid</h3>
                                                    <address>
                                                        <span><strong><?php echo t('contact_address'); ?>:</strong> C. 49 235, Sisal, Valladolid, Yucatán, México</span>
                                                        <span><strong><?php echo t('contact_phone_label'); ?>:</strong> (+52) 985 258 0599</span>
                                                        <span><strong><?php echo t('contact_email_label'); ?>:</strong><a href="mailto:reservas@casaxuunan.com">reservas@casaxuunan.com</a></span>
                                                    </address>
                                                </div>

                                                <!-- <div class="col-lg-6">
                                                    <h3>Casa Xuunan Mérida</h3>
                                                    <address>
                                                        <span><strong>Dirección:</strong> Calle 60 No. 456, Centro, Mérida, Yucatán, México</span>
                                                        <span><strong>Teléfono:</strong> (+52) 999 987 6543</span>
                                                        <span><strong>Email:</strong><a href="mailto:contacto@casaxuunan.com">contacto@casaxuunan.com</a></span>
                                                    </address>
                                                </div> -->
                                            </div>

                                            <div class="spacer-single"></div>

                                            <form name="contactForm" id='contact_form' method="post">
                                                <div class="row">
                                                    <div class="col-md-12 mb10">
                                                        <h3><?php echo t('contact_form_title'); ?></h3>
                                                    </div>
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

                                                        <!-- Alertas de éxito y error -->
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
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="map-container map-fullwidth">
                                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14930.418508272227!2d-88.2087843!3d20.6856583!3m2!1i1024!2i768!4f15!3m3!1m2!1s0x8f510b2730300389%3A0xa88c388eb4a4ead7!2sCasa%20Xu&#39;unan!5e0!3m2!1ses-419!2smx!4v1730254269839!5m2!1ses-419!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                   
                    </div>
                </section>
                <!-- cierre del subheader -->


