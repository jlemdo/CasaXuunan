        <div id="background" data-bgimage="url(images/background/2.jpg) fixed"></div>
        <div id="content-absolute">

            <!-- subheader -->
            <section id="subheader" class="no-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4><?php echo t('blog_subtitle'); ?></h4>
                            <h1><?php echo t('blog_title'); ?></h1>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-main" class="no-bg no-top" aria-label="section-blog">
                <div class="container">

                    <!-- Blog intro text for SEO -->
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 text-center mb-4">
                            <p class="blog-intro"><?php echo t('blog_intro'); ?></p>
                        </div>
                    </div>

                    <!-- Blog posts grid -->
                    <div class="row">
                        <?php
                        require_once __DIR__ . '/../blog-posts.php';
                        $lang = getCurrentLanguage();

                        foreach ($blog_posts as $post):
                            $title = ($lang === 'es') ? $post['title_es'] : $post['title_en'];
                            $category = ($lang === 'es') ? $post['category_es'] : $post['category_en'];
                            $slug = ($lang === 'es') ? $post['slug'] : $post['slug_en'];
                            $desc = ($lang === 'es') ? $post['meta_desc_es'] : $post['meta_desc_en'];
                            $image = file_exists($post['image']) ? $post['image'] : $post['fallback_image'];
                            $date_formatted = date(($lang === 'es') ? 'd M Y' : 'M d, Y', strtotime($post['date']));
                            $read_label = ($lang === 'es') ? 'min de lectura' : 'min read';
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4 wow fadeInUp" data-wow-duration="1s">
                            <a href="blog-post.php?slug=<?php echo urlencode($slug); ?>" class="blog-card-link">
                                <div class="blog-card">
                                    <div class="blog-card-image">
                                        <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($title); ?>" loading="lazy">
                                        <span class="blog-card-category"><?php echo $category; ?></span>
                                    </div>
                                    <div class="blog-card-content">
                                        <div class="blog-card-meta">
                                            <span><i class="fa fa-calendar"></i> <?php echo $date_formatted; ?></span>
                                            <span><i class="fa fa-clock-o"></i> <?php echo $post['read_time']; ?> <?php echo $read_label; ?></span>
                                        </div>
                                        <h3 class="blog-card-title"><?php echo $title; ?></h3>
                                        <p class="blog-card-excerpt"><?php echo $desc; ?></p>
                                        <span class="blog-card-read"><?php echo t('blog_read_more'); ?> <i class="fa fa-arrow-right"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- CTA section -->
                    <div class="row mt-4">
                        <div class="col-lg-8 offset-lg-2 text-center">
                            <div class="blog-cta-box wow fadeInUp">
                                <h3><?php echo t('blog_cta_title'); ?></h3>
                                <p><?php echo t('blog_cta_desc'); ?></p>
                                <a href="rooms.php" class="btn-line"><span><?php echo t('blog_cta_button'); ?></span></a>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- subheader close -->
