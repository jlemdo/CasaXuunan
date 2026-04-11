<!-- ============================================
     HOMEPAGE CONVERSION SECTIONS
     Casa Xu'unan - El Lujo de lo Auténtico
     ============================================ -->

<!-- Enable scrolling: override #wrapper overflow:hidden immediately -->
<script>document.body.classList.add('hp-has-sections');</script>

<!-- Scroll down indicator (fixed position, independent of slider) -->
<div class="hp-scroll-indicator" aria-label="<?php echo t('hp_scroll_discover'); ?>">
    <span><?php echo t('hp_scroll_discover'); ?></span>
    <i class="fa fa-angle-down"></i>
</div>

<!-- Spacer: creates 100vh height so hero slider is fully visible before sections -->
<div class="hp-hero-spacer"></div>

<div class="hp-sections-wrapper">

    <!-- ========== SECTION 1: El Lujo de lo Auténtico ========== -->
    <section id="hp-lujo" class="hp-section hp-section-dark">
        <div class="container text-center">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="hp-subtitle"><?php echo t('hp_lujo_subtitle'); ?></div>
                <h2 class="hp-title"><?php echo t('hp_lujo_title'); ?></h2>
            </div>
            <div class="wow fadeInUp" data-wow-delay="0.3s">
                <p class="hp-text"><?php echo t('hp_lujo_text'); ?></p>
            </div>
            <div class="wow fadeInUp" data-wow-delay="0.5s">
                <div class="hp-lujo-location">
                    <?php echo t('hp_lujo_location'); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 2: El Ecosistema de Pertenencia ========== -->
    <section id="hp-ecosistema" class="hp-section hp-section-warm">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="text-center">
                        <div class="wow fadeInUp" data-wow-delay="0.1s">
                            <h2 class="hp-title"><?php echo t('hp_eco_title'); ?></h2>
                        </div>
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <div class="hp-quote-text"><?php echo t('hp_eco_quote'); ?></div>
                        </div>
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <p class="hp-philosophy-text" style="margin-left:auto;margin-right:auto;"><?php echo t('hp_eco_philosophy'); ?></p>
                        </div>
                    </div>

                    <!-- 3 Pillar Cards -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="hp-pillar-card wow fadeInUp" data-wow-delay="0.2s">
                                <h4><?php echo t('hp_eco_pillar1_title'); ?></h4>
                                <p><?php echo t('hp_eco_pillar1_desc'); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hp-pillar-card wow fadeInUp" data-wow-delay="0.3s">
                                <h4><?php echo t('hp_eco_pillar2_title'); ?></h4>
                                <p><?php echo t('hp_eco_pillar2_desc'); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hp-pillar-card wow fadeInUp" data-wow-delay="0.4s">
                                <h4><?php echo t('hp_eco_pillar3_title'); ?></h4>
                                <p><?php echo t('hp_eco_pillar3_desc'); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Breakfast Hero Card -->
                    <div class="hp-breakfast-card wow fadeInUp" data-wow-delay="0.3s">
                        <p><?php echo t('hp_eco_breakfast_text'); ?></p>
                        <span class="hp-badge hp-badge-gold"><?php echo t('hp_eco_breakfast_badge'); ?></span>
                    </div>

                    <!-- Extras Row -->
                    <div class="hp-extras-row wow fadeInUp" data-wow-delay="0.4s">
                        <div class="hp-extra-item"><i class="fa fa-wifi"></i> <?php echo t('hp_eco_extra_wifi'); ?></div>
                        <div class="hp-extra-item"><i class="fa fa-car"></i> <?php echo t('hp_eco_extra_parking'); ?></div>
                        <div class="hp-extra-item"><i class="fa fa-tint"></i> <?php echo t('hp_eco_extra_pool'); ?></div>
                        <div class="hp-extra-item"><i class="fa fa-leaf"></i> <?php echo t('hp_eco_extra_garden'); ?></div>
                    </div>

                    <!-- Anchor Text -->
                    <div class="text-center wow fadeInUp" data-wow-delay="0.5s">
                        <p class="hp-anchor-text"><?php echo t('hp_eco_anchor'); ?></p>
                        <a href="/rooms.php" class="hp-cta-btn"><?php echo t('hp_eco_cta'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 3: El Filtro de Autenticidad ========== -->
    <section id="hp-filtro" class="hp-section hp-section-light">
        <div class="hp-filtro-image"></div>
        <div class="hp-filtro-content">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h2 class="hp-title"><?php echo t('hp_filtro_title'); ?></h2>
                </div>

                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="hp-filtro-columns wow fadeInUp" data-wow-delay="0.2s">
                            <div class="hp-filtro-col hp-filtro-col-left">
                                <p><?php echo t('hp_filtro_left'); ?></p>
                            </div>
                            <div class="hp-filtro-divider"></div>
                            <div class="hp-filtro-col hp-filtro-col-right">
                                <p><?php echo t('hp_filtro_right'); ?></p>
                            </div>
                        </div>

                        <div class="hp-filtro-bottom wow fadeInUp" data-wow-delay="0.4s">
                            <?php echo t('hp_filtro_bottom'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 4: Experiencias Reales (Social Proof) ========== -->
    <section id="hp-social-proof" class="hp-section hp-section-dark">
        <div class="container text-center">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="hp-subtitle"><?php echo t('hp_social_subtitle'); ?></div>
                <h2 class="hp-title"><?php echo t('hp_social_title'); ?></h2>
                <p class="hp-text"><?php echo t('hp_social_subtext'); ?></p>
            </div>

            <!-- Review Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="hp-review-card wow fadeInUp" data-wow-delay="0.2s">
                        <div class="hp-review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <p class="hp-review-quote"><?php echo t('hp_social_review1_text'); ?></p>
                        <div class="hp-review-author"><?php echo t('hp_social_review1_name'); ?></div>
                        <span class="hp-review-badge">Google Review</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="hp-review-card wow fadeInUp" data-wow-delay="0.3s">
                        <div class="hp-review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <p class="hp-review-quote"><?php echo t('hp_social_review2_text'); ?></p>
                        <div class="hp-review-author"><?php echo t('hp_social_review2_name'); ?></div>
                        <span class="hp-review-badge">Google Review</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="hp-review-card wow fadeInUp" data-wow-delay="0.4s">
                        <div class="hp-review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <p class="hp-review-quote"><?php echo t('hp_social_review3_text'); ?></p>
                        <div class="hp-review-author"><?php echo t('hp_social_review3_name'); ?></div>
                        <span class="hp-review-badge">Google Review</span>
                    </div>
                </div>
            </div>

            <!-- Counter -->
            <div class="hp-counter-row wow fadeInUp" data-wow-delay="0.3s">
                <div class="hp-counter-number" data-count="500">0+</div>
                <div class="hp-counter-label"><?php echo t('hp_social_counter_label'); ?></div>
            </div>

            <!-- CTAs -->
            <div class="hp-social-ctas wow fadeInUp" data-wow-delay="0.4s">
                <a href="#" id="hp-see-all-reviews" class="hp-cta-btn-outline"><?php echo t('hp_social_see_all'); ?></a>
                <a href="/rooms.php" class="hp-cta-btn"><?php echo t('hp_social_cta'); ?></a>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 5: Tu Base en Yucatán (Ubicación) ========== -->
    <section id="hp-ubicacion" class="hp-section hp-section-warm">
        <div class="container text-center">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="hp-subtitle"><?php echo t('hp_location_subtitle'); ?></div>
                <h2 class="hp-title"><?php echo t('hp_location_title'); ?></h2>
            </div>

            <div class="hp-distance-grid wow fadeInUp" data-wow-delay="0.2s">
                <div class="hp-distance-card">
                    <div class="hp-distance-icon"><i class="fa fa-building"></i></div>
                    <div class="hp-distance-info">
                        <div class="hp-distance-time"><?php echo t('hp_location_chichen_time'); ?></div>
                        <div class="hp-distance-name"><?php echo t('hp_location_chichen_name'); ?></div>
                        <div class="hp-distance-desc"><?php echo t('hp_location_chichen_desc'); ?></div>
                    </div>
                </div>
                <div class="hp-distance-card">
                    <div class="hp-distance-icon"><i class="fa fa-tint"></i></div>
                    <div class="hp-distance-info">
                        <div class="hp-distance-time"><?php echo t('hp_location_cenotes_time'); ?></div>
                        <div class="hp-distance-name"><?php echo t('hp_location_cenotes_name'); ?></div>
                        <div class="hp-distance-desc"><?php echo t('hp_location_cenotes_desc'); ?></div>
                    </div>
                </div>
                <div class="hp-distance-card">
                    <div class="hp-distance-icon"><i class="fa fa-compass"></i></div>
                    <div class="hp-distance-info">
                        <div class="hp-distance-time"><?php echo t('hp_location_ekbalam_time'); ?></div>
                        <div class="hp-distance-name"><?php echo t('hp_location_ekbalam_name'); ?></div>
                        <div class="hp-distance-desc"><?php echo t('hp_location_ekbalam_desc'); ?></div>
                    </div>
                </div>
                <div class="hp-distance-card">
                    <div class="hp-distance-icon"><i class="fa fa-map-marker"></i></div>
                    <div class="hp-distance-info">
                        <div class="hp-distance-time"><?php echo t('hp_location_calzada_time'); ?></div>
                        <div class="hp-distance-name"><?php echo t('hp_location_calzada_name'); ?></div>
                        <div class="hp-distance-desc"><?php echo t('hp_location_calzada_desc'); ?></div>
                    </div>
                </div>
                <div class="hp-distance-card">
                    <div class="hp-distance-icon"><i class="fa fa-camera"></i></div>
                    <div class="hp-distance-info">
                        <div class="hp-distance-time"><?php echo t('hp_location_coloradas_time'); ?></div>
                        <div class="hp-distance-name"><?php echo t('hp_location_coloradas_name'); ?></div>
                        <div class="hp-distance-desc"><?php echo t('hp_location_coloradas_desc'); ?></div>
                    </div>
                </div>
            </div>

            <div class="wow fadeInUp" data-wow-delay="0.4s">
                <p class="hp-location-note"><?php echo t('hp_location_address'); ?></p>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 6: CTA Final ========== -->
    <section id="hp-final-cta" class="hp-section">
        <div class="container text-center">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="hp-title"><?php echo t('hp_final_title'); ?></h2>
                <p class="hp-text"><?php echo t('hp_final_subtext'); ?></p>
            </div>
            <div class="wow fadeInUp" data-wow-delay="0.3s">
                <a href="/rooms.php" class="hp-cta-glow"><?php echo t('hp_final_cta'); ?></a>
            </div>
            <div class="hp-trust-row wow fadeInUp" data-wow-delay="0.4s">
                <div class="hp-trust-item"><i class="fa fa-check-circle"></i> <?php echo t('hp_final_trust1'); ?></div>
                <div class="hp-trust-item"><i class="fa fa-lock"></i> <?php echo t('hp_final_trust2'); ?></div>
                <div class="hp-trust-item"><i class="fa fa-clock-o"></i> <?php echo t('hp_final_trust3'); ?></div>
            </div>
            <div class="hp-wa-alt wow fadeInUp" data-wow-delay="0.5s">
                <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(getCurrentLanguage() === 'es' ? '¡Hola! Me interesa reservar en Casa Xu\'unan' : 'Hi! I\'m interested in booking at Casa Xu\'unan'); ?>" target="_blank" rel="noopener noreferrer">
                    <i class="fa fa-whatsapp"></i> <?php echo t('hp_final_wa'); ?>
                </a>
            </div>
        </div>
    </section>

</div>
<!-- END HOMEPAGE CONVERSION SECTIONS -->

<!-- WhatsApp Floating Button -->
<div class="whatsapp-float">
    <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(getCurrentLanguage() === 'es' ? '¡Hola! Me gustaría obtener información sobre Casa Xu\'unan' : 'Hi! I would like to get information about Casa Xu\'unan'); ?>"
       class="whatsapp-float-btn"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="WhatsApp">
        <i class="fa fa-whatsapp"></i>
    </a>
    <span class="whatsapp-float-tooltip"><?php echo getCurrentLanguage() === 'es' ? '¿Necesitas ayuda?' : 'Need help?'; ?></span>
</div>

<!-- footer begin -->
<footer class="no-top pl20 pr20">
    <div class="subfooter">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">&copy; <?php echo t('footer_copyright'); ?> <?php echo date('Y') ?> - Casa Xuunan <?php echo t('footer_by'); ?> <span class="id-color">PixelCrafters</span></div>
                <div class="col-md-6 text-right">
                    <div class="social-icons">
                        <a href="https://www.facebook.com/people/Casa-Xuunan/61578964945156/" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
                        <a href="https://www.instagram.com/casa_xuunan/" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#" id="back-to-top"></a>
</footer>
<!-- footer close -->
</div>
