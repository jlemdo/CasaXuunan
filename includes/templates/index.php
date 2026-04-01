 <!-- content begin -->
 <div id="content" class="no-bottom no-top">

<!-- float text begin -->
<div class="float-text">
    <div class="de_social-icons">
        <a href="https://www.facebook.com/people/Casa-Xuunan/61578964945156/" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
        <a href="https://www.instagram.com/casa_xuunan/" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
        <a href="https://api.whatsapp.com/send?phone=5219852580599" target="_blank" ><i class="fa fa-whatsapp fa-lg"></i></a>
    </div>
    <span><a href="/rooms.php"><?php echo t('btn_book'); ?></a></span>
</div>
<!-- float text close -->

<div class='slider-overlay'></div>

<div id="slidecaption"></div>

<!-- Botón sutil dentro del slider -->
<div class="reviews-scroll-btn-wrapper">
    <a href="#" class="reviews-scroll-btn" id="open-reviews-overlay">
        <span class="rating-stars">★★★★★ 4.8</span>
        <span class="scroll-text"><?php echo t('index_rating'); ?></span>
    </a>
</div>

<!-- Search Bar - Hospitable Property Search -->
<div class="home-search-section">
    <div class="home-search-wrapper">
        <div class="home-search-title"><?php echo t('search_home_title'); ?> <span><?php echo t('search_home_highlight'); ?></span></div>
        <hospitable-direct-mps identifier="acfc5534-2d3d-4f1e-88a0-74360d86804f" type="custom" results-url="/search"></hospitable-direct-mps>
        <div class="home-search-subtitle"><i class="fa fa-star"></i> <?php echo t('search_home_subtitle'); ?></div>
    </div>
</div>

<div class="container">
    <div id="prevthumb"></div>
    <div id="nextthumb"></div>

    <!--Arrow Navigation-->
    <a id="prevslide" class="load-item"></a>
    <a id="nextslide" class="load-item"></a>

    <!--Time Bar-->
    <div id="progress-back" class="load-item">
        <div id="progress-bar"></div>
    </div>
    <!--Control Bar-->
    <div id="controls-wrapper" class="load-item">
        <div id="controls">

            <a id="play-button"><span id="pauseplay" class="play"></span></a>

            <!--Slide counter-->
            <div id="slidecounter">
                <span class="slidenumber"></span> / <span class="totalslides"></span>
            </div>

            <!--Navigation-->
            <ul id="slide-list"></ul>

        </div>
    </div>
</div>

</div>
<!-- content close -->

<!-- reviews overlay begin -->
<div id="reviews-overlay" class="slideUp">
    <div class="reviews-overlay-content">
        <div class="reviews-overlay-header">
            <h4><?php echo t('index_reviews_overlay_title1'); ?></h4>
            <h2><?php echo t('index_reviews_overlay_title2'); ?></h2>
            <div id="reviews-close-button">
                <div class="line-1"></div>
                <div class="line-2"></div>
            </div>
        </div>

        <div class="reviews-overlay-body">
            <div class="container">
                <!-- Elfsight Google Reviews Widget -->
                <div class="elfsight-app-d417e2fd-4c4c-4718-af81-b5995cd6c060" data-elfsight-app-lazy></div>

                <div class="text-center">
                    <div class="spacer-single"></div>
                    <a href="/rooms.php" class="btn-line">
                        <span><?php echo t('index_reviews_button'); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- reviews overlay close -->

