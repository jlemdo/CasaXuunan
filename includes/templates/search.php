<div id="background" data-bgimage="url(images/background/20.jpg) 100% 100% fixed"></div>
<div id="content-absolute">

    <!-- subheader -->
    <section id="subheader" class="no-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4><?php echo t('search_subtitle'); ?></h4>
                    <h1><?php echo t('search_title'); ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Results -->
    <section id="section-main" class="no-bg no-top" aria-label="search-results">

        <!-- Trust Badge (contained) -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="de-content-overlay search-results-overlay">
                        <div class="search-trust-bar">
                            <div class="trust-item">
                                <i class="fa fa-shield"></i>
                                <span><?php echo t('search_trust_secure'); ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fa fa-cutlery"></i>
                                <span><?php echo t('search_trust_breakfast'); ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fa fa-star"></i>
                                <span><?php echo t('search_trust_rating'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hospitable Search Widget (full-width, no container restriction) -->
        <div class="search-widget-fullwidth">
            <hospitable-direct-mps identifier="acfc5534-2d3d-4f1e-88a0-74360d86804f" type="custom"></hospitable-direct-mps>
        </div>

        <!-- WhatsApp Help CTA (contained) -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="de-content-overlay search-results-overlay" style="margin-top: 0;">
                        <div class="search-help-cta">
                            <div class="search-help-icon">
                                <i class="fa fa-whatsapp"></i>
                            </div>
                            <div class="search-help-text">
                                <strong><?php echo t('search_help_title'); ?></strong>
                                <p><?php echo t('search_help_desc'); ?></p>
                            </div>
                            <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(getCurrentLanguage() === 'es' ? '¡Hola! Necesito ayuda para encontrar la habitación ideal en Casa Xu\'unan' : 'Hi! I need help finding the perfect room at Casa Xu\'unan'); ?>"
                               class="search-help-btn"
                               target="_blank"
                               rel="noopener noreferrer"
                               onclick="if(typeof gtag==='function'){gtag('event','conversion',{'send_to':'AW-18041631980/6AUyCN_D3pMcEOzp9ZpD','value':1400,'currency':'MXN'});}">
                                <?php echo t('search_help_btn'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
