<div id="background" data-bgimage="url(images/background/5.jpg) fixed"></div>

<div id="content-absolute">
    <!-- Subheader -->
    <section id="subheader" class="no-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4><?php echo t('gallery_subtitle'); ?></h4>
                    <h1><?php echo t('gallery_title'); ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="section-gallery" class="no-bg no-top" aria-label="gallery">
        <div class="container">
            <div id="carousel-rooms" class="gallery-grid">
                <!-- Fila 1 -->
                <div class="item foto1">
                    <div class="picframe">
                        <a href="images/gallery/gallery-item-1.jpg" class="image-popup-gallery">
                            <span class="overlay">
                                <span class="pf_title"><i class="icon_search"></i></span>
                                <span class="pf_caption"></span>
                            </span>
                        </a>
                        <img src="images/gallery/gallery-item-1.jpg" alt="<?php echo t('gallery_alt_pool'); ?>" class="cover-image" loading="lazy">
                    </div>
                </div>
                <div class="item foto2">
                    <div class="picframe">
                        <a href="images/gallery/gallery-item-2.jpg" class="image-popup-gallery">
                            <span class="overlay">
                                <span class="pf_title"><i class="icon_search"></i></span>
                                <span class="pf_caption"></span>
                            </span>
                        </a>
                        <img src="images/gallery/gallery-item-2.jpg" alt="<?php echo t('gallery_alt_hammocks'); ?>" class="cover-image" loading="lazy">
                    </div>
                </div>
                <div class="item foto3">
                    <div class="picframe">
                        <a href="images/gallery/gallery-item-3.jpg" class="image-popup-gallery">
                            <span class="overlay">
                                <span class="pf_title"><i class="icon_search"></i></span>
                                <span class="pf_caption"></span>
                            </span>
                        </a>
                        <img src="images/gallery/gallery-item-3.jpg" alt="<?php echo t('gallery_alt_landscape'); ?>" class="cover-image" loading="lazy">
                    </div>
                </div>

                <!-- Fila 2 -->
                <div class="item foto4">
                    <div class="picframe">
                        <a href="images/gallery/gallery-item-4.jpg" class="image-popup-gallery">
                            <span class="overlay">
                                <span class="pf_title"><i class="icon_search"></i></span>
                                <span class="pf_caption"></span>
                            </span>
                        </a>
                        <img src="images/gallery/gallery-item-4.jpg" alt="<?php echo t('gallery_alt_terrace'); ?>" class="cover-image" loading="lazy">
                    </div>
                </div>
                <div class="item foto5">
                    <div class="picframe">
                        <a href="images/gallery/gallery-item-5.jpg" class="image-popup-gallery">
                            <span class="overlay">
                                <span class="pf_title"><i class="icon_search"></i></span>
                                <span class="pf_caption"></span>
                            </span>
                        </a>
                        <img src="images/gallery/gallery-item-5.jpg" alt="<?php echo t('gallery_alt_group'); ?>" class="cover-image" loading="lazy">
                    </div>
                </div>

                <!-- Fila 3 -->
                <div class="item foto6">
                    <div class="picframe">
                        <a href="images/gallery/gallery-item-6.jpg" class="image-popup-gallery">
                            <span class="overlay">
                                <span class="pf_title"><i class="icon_search"></i></span>
                                <span class="pf_caption"></span>
                            </span>
                        </a>
                        <img src="images/gallery/gallery-item-6.jpg" alt="<?php echo t('gallery_alt_sunset'); ?>" class="cover-image" loading="lazy">
                    </div>
                </div>
                <div class="item foto7">
                    <div class="picframe">
                        <a href="images/gallery/gallery-item-7.jpg" class="image-popup-gallery">
                            <span class="overlay">
                                <span class="pf_title"><i class="icon_search"></i></span>
                                <span class="pf_caption"></span>
                            </span>
                        </a>
                        <img src="images/gallery/gallery-item-7.jpg" alt="<?php echo t('gallery_alt_sharing'); ?>" class="cover-image" loading="lazy">
                    </div>
                </div>
            </div>

            <!-- Load More (visible only on mobile, managed by gallery.js) -->
            <div id="gallery-load-more" style="display: none; text-align: center; margin-top: 30px;">
                <button id="btn-load-more" style="
                    display: inline-flex; align-items: center; gap: 8px;
                    padding: 14px 36px;
                    background: rgba(123,175,137,0.12);
                    border: 1px solid rgba(123,175,137,0.3);
                    border-radius: 30px;
                    color: rgba(255,255,255,0.8);
                    font-family: Montserrat, sans-serif;
                    font-size: 14px; font-weight: 500;
                    letter-spacing: 0.3px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                ">
                    <?php echo tx([
                        'es' => 'Ver Más Fotos',
                        'en' => 'Load More Photos',
                        'fr' => 'Voir Plus de Photos',
                    ]); ?>
                    <i class="fa fa-arrow-down"></i>
                </button>
            </div>
        </div>
    </section>
</div>
