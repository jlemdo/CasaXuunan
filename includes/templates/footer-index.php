<!-- ============================================
     HOMEPAGE CONVERSION SECTIONS (REDISEÑO 2026)
     Casa Xu'unan - Anti-AI, denso, visual
     7 secciones mobile-first + desktop genial
     ============================================ -->

<!-- Enable scrolling: override #wrapper overflow:hidden immediately -->
<script>document.body.classList.add('hp-has-sections');</script>

<!-- Spacer: creates 100vh height so hero slider is fully visible before sections -->
<div class="hp-hero-spacer"></div>

<div class="hp-sections-wrapper">

    <!-- ========== SECCIÓN 1: Aquí nadie es un número de habitación ========== -->
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

    <!-- ========== SECCIÓN 2: Lo que sí tenemos. Lo que no. ========== -->
    <section id="hp-ecosistema" class="hp-section hp-section-warm">
        <div class="container">
            <div class="text-center">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <h2 class="hp-title"><?php echo t('hp_eco_title'); ?></h2>
                </div>
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <div class="hp-quote-text"><?php echo t('hp_eco_quote'); ?></div>
                </div>
                <div class="wow fadeInUp" data-wow-delay="0.3s">
                    <p class="hp-philosophy-text"><?php echo t('hp_eco_philosophy'); ?></p>
                </div>
            </div>

            <!-- Comparativa Sí / No (2 cols desktop, apilada mobile) -->
            <div class="hp-yesno-grid wow fadeInUp" data-wow-delay="0.3s">
                <!-- LO QUE SÍ -->
                <div class="hp-yesno-col hp-yesno-yes">
                    <div class="hp-yesno-header">
                        <span class="hp-yesno-tag"><?php echo t('hp_eco_yes_title'); ?></span>
                    </div>
                    <ul class="hp-yesno-list">
                        <li><?php echo t('hp_eco_yes_1'); ?></li>
                        <li><?php echo t('hp_eco_yes_2'); ?></li>
                        <li><?php echo t('hp_eco_yes_3'); ?></li>
                        <li><?php echo t('hp_eco_yes_4'); ?></li>
                        <li><?php echo t('hp_eco_yes_5'); ?></li>
                        <li><?php echo t('hp_eco_yes_6'); ?></li>
                    </ul>
                </div>

                <!-- LO QUE NO -->
                <div class="hp-yesno-col hp-yesno-no">
                    <div class="hp-yesno-header">
                        <span class="hp-yesno-tag"><?php echo t('hp_eco_no_title'); ?></span>
                    </div>
                    <ul class="hp-yesno-list">
                        <li><?php echo t('hp_eco_no_1'); ?></li>
                        <li><?php echo t('hp_eco_no_2'); ?></li>
                        <li><?php echo t('hp_eco_no_3'); ?></li>
                        <li><?php echo t('hp_eco_no_4'); ?></li>
                        <li><?php echo t('hp_eco_no_5'); ?></li>
                        <li><?php echo t('hp_eco_no_6'); ?></li>
                    </ul>
                </div>
            </div>

            <!-- Anchor + CTA -->
            <div class="text-center wow fadeInUp" data-wow-delay="0.5s">
                <p class="hp-anchor-text"><?php echo t('hp_eco_anchor'); ?></p>
                <a href="<?php echo searchUrl(); ?>" class="hp-cta-btn"><?php echo t('hp_eco_cta'); ?></a>
            </div>
        </div>
    </section>

    <!-- ========== SECCIÓN 3 (NUEVA): Jardín con +50 plantas ==========
         MODO TESTING: 2 imagenes alternan cada 5 seg con CSS animation
         para que el usuario decida cual deja final.
         Una vez decidido, dejar solo 1 background-image.
    -->
    <section id="hp-jardin" class="hp-section hp-section-jardin">
        <div class="hp-jardin-wrap">
            <div class="hp-jardin-image hp-jardin-image-testing wow fadeIn" data-wow-delay="0.1s"
                 role="img" aria-label="Jardín tropical de Casa Xu'unan">
                <!-- Capa 1: jardin-amplio -->
                <div class="hp-jardin-bg-layer hp-jardin-bg-1"
                     style="background-image: url('<?php echo BASE_URL; ?>/images/slider/section-jardin-test-1-amplio.webp');"></div>
                <!-- Capa 2: jardin-detalles-pasillo -->
                <div class="hp-jardin-bg-layer hp-jardin-bg-2"
                     style="background-image: url('<?php echo BASE_URL; ?>/images/slider/section-jardin-test-2-pasillo.webp');"></div>
                <!-- Etiqueta para identificar cual se ve -->
                <div class="hp-jardin-test-label">
                    <span class="hp-jardin-test-1-label">[1] Jardín Amplio</span>
                    <span class="hp-jardin-test-2-label">[2] Jardín Pasillo</span>
                </div>
            </div>
            <div class="hp-jardin-text-wrap">
                <div class="container">
                    <div class="hp-jardin-content wow fadeInUp" data-wow-delay="0.2s">
                        <div class="hp-subtitle"><?php echo t('hp_jardin_subtitle'); ?></div>
                        <h2 class="hp-title"><?php echo t('hp_jardin_title'); ?></h2>
                        <p class="hp-text"><?php echo t('hp_jardin_text'); ?></p>

                        <!-- Tags de plantas -->
                        <div class="hp-jardin-tags">
                            <span class="hp-jardin-chip"><?php echo t('hp_jardin_tag_tomate'); ?></span>
                            <span class="hp-jardin-chip"><?php echo t('hp_jardin_tag_limon'); ?></span>
                            <span class="hp-jardin-chip"><?php echo t('hp_jardin_tag_chile'); ?></span>
                            <span class="hp-jardin-chip"><?php echo t('hp_jardin_tag_papaya'); ?></span>
                        </div>

                        <p class="hp-jardin-punchline"><?php echo t('hp_jardin_punchline'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECCIÓN 4: ¿Es Casa Xu'unan para ti? (REDISEÑO CHECKLIST) ==========
         Diseño distinto a la Sección 2 (no mas 2 columnas Si/No):
         - Los "SI" son protagonistas: cards horizontales con check animado
         - Los "NO" son secundarios: texto inline discreto abajo
         - Manifiesto final destacado
    -->
    <section id="hp-filtro" class="hp-section hp-section-light">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="hp-subtitle"><?php echo t('hp_filtro_subtitle'); ?></div>
                <h2 class="hp-title"><?php echo t('hp_filtro_title'); ?></h2>
            </div>

            <!-- Checklist de "SI" - cards horizontales con check animado -->
            <div class="hp-filtro-checklist">
                <div class="hp-filtro-check-item wow fadeInUp" data-wow-delay="0.15s">
                    <span class="hp-filtro-check-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M4 12.5l5 5L20 6"/></svg>
                    </span>
                    <span class="hp-filtro-check-text"><?php echo t('hp_filtro_yes_1'); ?></span>
                </div>
                <div class="hp-filtro-check-item wow fadeInUp" data-wow-delay="0.25s">
                    <span class="hp-filtro-check-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M4 12.5l5 5L20 6"/></svg>
                    </span>
                    <span class="hp-filtro-check-text"><?php echo t('hp_filtro_yes_2'); ?></span>
                </div>
                <div class="hp-filtro-check-item wow fadeInUp" data-wow-delay="0.35s">
                    <span class="hp-filtro-check-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M4 12.5l5 5L20 6"/></svg>
                    </span>
                    <span class="hp-filtro-check-text"><?php echo t('hp_filtro_yes_3'); ?></span>
                </div>
                <div class="hp-filtro-check-item wow fadeInUp" data-wow-delay="0.45s">
                    <span class="hp-filtro-check-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M4 12.5l5 5L20 6"/></svg>
                    </span>
                    <span class="hp-filtro-check-text"><?php echo t('hp_filtro_yes_4'); ?></span>
                </div>
            </div>

            <!-- Separador + "NO" discreto inline -->
            <div class="hp-filtro-no-block wow fadeInUp" data-wow-delay="0.3s">
                <div class="hp-filtro-no-title"><?php echo t('hp_filtro_no_title'); ?></div>
                <div class="hp-filtro-no-items">
                    <span><?php echo t('hp_filtro_no_1'); ?></span>
                    <span><?php echo t('hp_filtro_no_2'); ?></span>
                    <span><?php echo t('hp_filtro_no_3'); ?></span>
                    <span><?php echo t('hp_filtro_no_4'); ?></span>
                </div>
            </div>

            <!-- Manifiesto final destacado -->
            <div class="hp-filtro-bottom wow fadeInUp" data-wow-delay="0.4s">
                <?php echo t('hp_filtro_bottom'); ?>
            </div>
        </div>
    </section>

    <!-- ========== SECCIÓN 5: Reseñas Reales (Verified Social Proof) ==========
         Estructura:
         1) Badges grandes con ratings reales (Google 4.8 / Booking 9.1 / TripAdvisor 4.7)
         2) Carrusel de screenshots reales de cada plataforma (zero edicion = max confianza)
         3) CTA "Ver todas las reseñas" + "Reservar"
    -->
    <section id="hp-social-proof" class="hp-section hp-section-dark">
        <div class="container text-center">
            <!-- Header -->
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="hp-subtitle"><?php echo t('hp_social_subtitle'); ?></div>
                <h2 class="hp-title"><?php echo t('hp_social_title'); ?></h2>
                <p class="hp-text"><?php echo t('hp_social_subtext'); ?></p>
            </div>

            <!-- Badges de ratings reales (3 cards) -->
            <div class="hp-ratings-grid wow fadeInUp" data-wow-delay="0.2s">
                <!-- Google -->
                <div class="hp-rating-card">
                    <div class="hp-rating-number">4.8</div>
                    <div class="hp-rating-stars">★ ★ ★ ★ ★</div>
                    <div class="hp-rating-logo-wrap">
                        <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-google.webp"
                             alt="Google Reviews"
                             class="hp-rating-logo"
                             loading="lazy">
                    </div>
                    <div class="hp-rating-count">141 opiniones</div>
                </div>

                <!-- Booking -->
                <div class="hp-rating-card">
                    <div class="hp-rating-number">9.1</div>
                    <div class="hp-rating-badge-text">Wonderful</div>
                    <div class="hp-rating-logo-wrap">
                        <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-booking.webp"
                             alt="Booking.com Reviews"
                             class="hp-rating-logo"
                             loading="lazy">
                    </div>
                    <div class="hp-rating-count">502 reviews</div>
                </div>

                <!-- TripAdvisor -->
                <div class="hp-rating-card">
                    <div class="hp-rating-number">4.7</div>
                    <div class="hp-rating-stars">● ● ● ● ◐</div>
                    <div class="hp-rating-logo-wrap">
                        <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-tripadvisor.webp"
                             alt="TripAdvisor Reviews"
                             class="hp-rating-logo"
                             loading="lazy">
                    </div>
                    <div class="hp-rating-count">16 opiniones</div>
                </div>
            </div>

            <!-- Separador -->
            <div class="hp-reviews-divider wow fadeInUp" data-wow-delay="0.3s">
                <span><?php echo tx([
                    'es' => 'Capturas reales · Sin filtros · Sin edición',
                    'en' => 'Real screenshots · No filters · No edits',
                    'fr' => 'Captures réelles · Sans filtres · Sans retouches'
                ]); ?></span>
            </div>

            <!-- Carrusel de screenshots reales (9 imagenes) -->
            <div class="hp-reviews-carousel wow fadeInUp" data-wow-delay="0.4s">
                <!-- Google reviews -->
                <div class="hp-review-slide" data-platform="google">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-google.webp" alt="Google" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-google-1.webp"
                         alt="Google review screenshot - Paul, Johannes, Stefanie"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>
                <div class="hp-review-slide" data-platform="google">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-google.webp" alt="Google" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-google-2.webp"
                         alt="Google review screenshot - Margarita, Chase"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>
                <div class="hp-review-slide" data-platform="google">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-google.webp" alt="Google" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-google-3.webp"
                         alt="Google review screenshot - Jess, Joan, John"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>

                <!-- Booking reviews -->
                <div class="hp-review-slide" data-platform="booking">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-booking.webp" alt="Booking" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-booking-1.webp"
                         alt="Booking review screenshot - Susan, Ziga, Magali"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>
                <div class="hp-review-slide" data-platform="booking">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-booking.webp" alt="Booking" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-booking-2.webp"
                         alt="Booking review screenshot - Theresa, Zan, Ria"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>
                <div class="hp-review-slide" data-platform="booking">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-booking.webp" alt="Booking" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-booking-3.webp"
                         alt="Booking review screenshot - Fabiano, Bernhard, Caroline"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>

                <!-- TripAdvisor reviews -->
                <div class="hp-review-slide" data-platform="tripadvisor">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-tripadvisor.webp" alt="TripAdvisor" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-trip-1.webp"
                         alt="TripAdvisor review screenshot - Sherpa, domingo, celinoc"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>
                <div class="hp-review-slide" data-platform="tripadvisor">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-tripadvisor.webp" alt="TripAdvisor" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-trip-2.webp"
                         alt="TripAdvisor review screenshot - GTmaria, 549olaff, andreanG"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>
                <div class="hp-review-slide" data-platform="tripadvisor">
                    <div class="hp-review-platform-badge">
                        <div class="hp-review-platform-badge-logo">
                            <img src="<?php echo BASE_URL; ?>/images/reviews/social-logo-tripadvisor.webp" alt="TripAdvisor" loading="lazy">
                        </div>
                        <span>Verified</span>
                    </div>
                    <img src="<?php echo BASE_URL; ?>/images/reviews/reviews-reales-trip-3.webp"
                         alt="TripAdvisor review screenshot - viajandop, 391claudiag, P3877"
                         class="hp-review-screenshot"
                         loading="lazy">
                </div>
            </div>

            <!-- Counter total huéspedes -->
            <div class="hp-counter-row wow fadeInUp" data-wow-delay="0.5s">
                <div class="hp-counter-number" data-count="659">0+</div>
                <div class="hp-counter-label"><?php echo t('hp_social_counter_label'); ?></div>
            </div>

            <!-- CTAs -->
            <div class="hp-social-ctas wow fadeInUp" data-wow-delay="0.6s">
                <a href="#" id="hp-see-all-reviews" class="hp-cta-btn-outline"><?php echo t('hp_social_see_all'); ?></a>
                <a href="<?php echo searchUrl(); ?>" class="hp-cta-btn"><?php echo t('hp_social_cta'); ?></a>
            </div>
        </div>
    </section>

    <!-- ========== SECCIÓN 6: Ubicación (locations con imágenes) ========== -->
    <!-- Carrusel horizontal scroll en mobile, grid 5 cards desktop -->
    <section id="hp-ubicacion" class="hp-section hp-section-warm">
        <div class="container text-center">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="hp-subtitle"><?php echo t('hp_location_subtitle'); ?></div>
                <h2 class="hp-title"><?php echo t('hp_location_title'); ?></h2>
            </div>

            <div class="hp-locations-scroll wow fadeInUp" data-wow-delay="0.2s">
                <!-- Chichén Itzá (primer card = gigante en desktop) -->
                <a href="<?php echo searchUrl(); ?>" class="hp-location-card"
                   style="background-image: linear-gradient(rgba(0,0,0,0.40),rgba(0,0,0,0.70)), url('<?php echo BASE_URL; ?>/images/locations/location-chichen-itza.webp');">
                    <div class="hp-location-overlay">
                        <span class="hp-location-time"><?php echo t('hp_location_chichen_time'); ?></span>
                        <h3 class="hp-location-name"><?php echo t('hp_location_chichen_name'); ?></h3>
                        <p class="hp-location-desc"><?php echo t('hp_location_chichen_desc'); ?></p>
                    </div>
                </a>

                <!-- Cenote Suytun -->
                <a href="<?php echo searchUrl(); ?>" class="hp-location-card"
                   style="background-image: linear-gradient(rgba(0,0,0,0.40),rgba(0,0,0,0.70)), url('<?php echo BASE_URL; ?>/images/locations/location-cenote-suytun.webp');">
                    <div class="hp-location-overlay">
                        <span class="hp-location-time"><?php echo t('hp_location_cenotes_time'); ?></span>
                        <h3 class="hp-location-name"><?php echo t('hp_location_cenotes_name'); ?></h3>
                        <p class="hp-location-desc"><?php echo t('hp_location_cenotes_desc'); ?></p>
                    </div>
                </a>

                <!-- Ek Balam -->
                <a href="<?php echo searchUrl(); ?>" class="hp-location-card"
                   style="background-image: linear-gradient(rgba(0,0,0,0.40),rgba(0,0,0,0.70)), url('<?php echo BASE_URL; ?>/images/locations/location-ek-balam.webp');">
                    <div class="hp-location-overlay">
                        <span class="hp-location-time"><?php echo t('hp_location_ekbalam_time'); ?></span>
                        <h3 class="hp-location-name"><?php echo t('hp_location_ekbalam_name'); ?></h3>
                        <p class="hp-location-desc"><?php echo t('hp_location_ekbalam_desc'); ?></p>
                    </div>
                </a>

                <!-- Calzada de los Frailes -->
                <a href="<?php echo searchUrl(); ?>" class="hp-location-card"
                   style="background-image: linear-gradient(rgba(0,0,0,0.40),rgba(0,0,0,0.70)), url('<?php echo BASE_URL; ?>/images/locations/location-calzada-frailes.webp');">
                    <div class="hp-location-overlay">
                        <span class="hp-location-time"><?php echo t('hp_location_calzada_time'); ?></span>
                        <h3 class="hp-location-name"><?php echo t('hp_location_calzada_name'); ?></h3>
                        <p class="hp-location-desc"><?php echo t('hp_location_calzada_desc'); ?></p>
                    </div>
                </a>

                <!-- Las Coloradas -->
                <a href="<?php echo searchUrl(); ?>" class="hp-location-card"
                   style="background-image: linear-gradient(rgba(0,0,0,0.40),rgba(0,0,0,0.70)), url('<?php echo BASE_URL; ?>/images/locations/location-las-coloradas.webp');">
                    <div class="hp-location-overlay">
                        <span class="hp-location-time"><?php echo t('hp_location_coloradas_time'); ?></span>
                        <h3 class="hp-location-name"><?php echo t('hp_location_coloradas_name'); ?></h3>
                        <p class="hp-location-desc"><?php echo t('hp_location_coloradas_desc'); ?></p>
                    </div>
                </a>
            </div>

            <div class="wow fadeInUp" data-wow-delay="0.4s">
                <p class="hp-location-note"><?php echo t('hp_location_address'); ?></p>
            </div>
        </div>
    </section>

    <!-- ========== SECCIÓN 7: CTA Final con CASA10 ========== -->
    <section id="hp-final-cta" class="hp-section">
        <div class="container text-center">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="hp-title"><?php echo t('hp_final_title'); ?></h2>
                <p class="hp-text"><?php echo t('hp_final_subtext'); ?></p>
            </div>

            <!-- Promo box CASA10 -->
            <div class="hp-promo-box wow fadeInUp" data-wow-delay="0.2s">
                <?php echo t('hp_final_promo'); ?>
            </div>

            <div class="wow fadeInUp" data-wow-delay="0.3s">
                <a href="<?php echo searchUrl(); ?>" class="hp-cta-glow"><?php echo t('hp_final_cta'); ?> →</a>
            </div>
            <div class="hp-trust-row wow fadeInUp" data-wow-delay="0.4s">
                <div class="hp-trust-item"><i class="fa fa-check-circle"></i> <?php echo t('hp_final_trust1'); ?></div>
                <div class="hp-trust-item"><i class="fa fa-lock"></i> <?php echo t('hp_final_trust2'); ?></div>
                <div class="hp-trust-item"><i class="fa fa-clock-o"></i> <?php echo t('hp_final_trust3'); ?></div>
            </div>
            <div class="hp-wa-alt wow fadeInUp" data-wow-delay="0.5s">
                <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(tx([
                       'es' => '¡Hola! Me interesa reservar en Casa Xu\'unan',
                       'en' => 'Hi! I\'m interested in booking at Casa Xu\'unan',
                       'fr' => 'Bonjour ! J\'aimerais réserver à Casa Xu\'unan',
                   ])); ?>" target="_blank" rel="noopener noreferrer">
                    <i class="fa fa-whatsapp"></i> <?php echo t('hp_final_wa'); ?>
                </a>
            </div>

            <!-- Copyright & Social (replaces footer) -->
            <div class="hp-footer-info wow fadeInUp" data-wow-delay="0.6s">
                <div class="hp-footer-social">
                    <a href="https://www.facebook.com/people/Casa-Xuunan/61578964945156/" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a href="https://www.instagram.com/casa_xuunan/" target="_blank"><i class="fa fa-instagram"></i></a>
                </div>
                <div class="hp-footer-copy">&copy; <?php echo date('Y'); ?> Casa Xu'unan &middot; Valladolid, Yucat&aacute;n</div>
            </div>
        </div>
    </section>

</div>
<!-- END HOMEPAGE CONVERSION SECTIONS -->

<!-- WhatsApp Floating Button -->
<div class="whatsapp-float">
    <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(tx([
           'es' => '¡Hola! Me gustaría obtener información sobre Casa Xu\'unan',
           'en' => 'Hi! I would like to get information about Casa Xu\'unan',
           'fr' => 'Bonjour ! J\'aimerais obtenir des informations sur Casa Xu\'unan',
       ])); ?>"
       class="whatsapp-float-btn"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="WhatsApp">
        <i class="fa fa-whatsapp"></i>
    </a>
    <span class="whatsapp-float-tooltip"><?php echo tx([
        'es' => '¿Necesitas ayuda?',
        'en' => 'Need help?',
        'fr' => 'Besoin d\'aide ?',
    ]); ?></span>
</div>

<!-- Scroll explore button (fixed bottom-right, replaces back-to-top) -->
<div id="hp-scroll-btn" class="hp-scroll-btn">
    <i class="fa fa-angle-down"></i>
</div>

</div>
