<?php
require_once __DIR__ . '/../blog-posts.php';
$lang = getCurrentLanguage();
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Find the post by slug (check both ES and EN slugs)
$current_post = null;
foreach ($blog_posts as $post) {
    if ($post['slug'] === $slug || $post['slug_en'] === $slug) {
        $current_post = $post;
        break;
    }
}

// If post not found, redirect to blog
if (!$current_post) {
    header('Location: blog.php');
    exit;
}

$title = ($lang === 'es') ? $current_post['title_es'] : $current_post['title_en'];
$content = ($lang === 'es') ? $current_post['content_es'] : $current_post['content_en'];
$category = ($lang === 'es') ? $current_post['category_es'] : $current_post['category_en'];
$date_formatted = date(($lang === 'es') ? 'd \d\e F, Y' : 'F d, Y', strtotime($current_post['date']));
$read_label = ($lang === 'es') ? 'min de lectura' : 'min read';
$image = file_exists($current_post['image']) ? $current_post['image'] : $current_post['fallback_image'];

// Get related posts (same category, exclude current)
$related = [];
foreach ($blog_posts as $p) {
    if ($p['id'] !== $current_post['id']) {
        $p_cat = ($lang === 'es') ? $p['category_es'] : $p['category_en'];
        if ($p_cat === $category && count($related) < 3) {
            $related[] = $p;
        }
    }
}
// Fill with other posts if not enough related
if (count($related) < 3) {
    foreach ($blog_posts as $p) {
        if ($p['id'] !== $current_post['id'] && !in_array($p, $related) && count($related) < 3) {
            $related[] = $p;
        }
    }
}
?>
        <div id="background" data-bgimage="url(images/background/2.jpg) fixed"></div>
        <div id="content-absolute">

            <!-- subheader -->
            <section id="subheader" class="no-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4><?php echo $category; ?></h4>
                            <h1><?php echo $title; ?></h1>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-main" class="no-bg no-top" aria-label="section-blog-post">
                <div class="container">
                    <div class="row">

                        <!-- Main content -->
                        <div class="col-lg-8 offset-lg-2">

                            <!-- Post meta -->
                            <div class="blog-post-meta text-center wow fadeIn">
                                <span><i class="fa fa-calendar"></i> <?php echo $date_formatted; ?></span>
                                <span class="mx-3">|</span>
                                <span><i class="fa fa-clock-o"></i> <?php echo $current_post['read_time']; ?> <?php echo $read_label; ?></span>
                                <span class="mx-3">|</span>
                                <span><i class="fa fa-folder-o"></i> <?php echo $category; ?></span>
                            </div>

                            <!-- Featured image -->
                            <div class="blog-post-image wow fadeInUp">
                                <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive">
                            </div>

                            <!-- Post content -->
                            <article class="blog-post-content wow fadeIn">
                                <?php echo $content; ?>
                            </article>

                            <!-- Share buttons -->
                            <div class="blog-post-share">
                                <span><?php echo ($lang === 'es') ? 'Compartir:' : 'Share:'; ?></span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://casaxuunan.com/blog-post.php?slug=' . $slug); ?>" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($title . ' - https://casaxuunan.com/blog-post.php?slug=' . $slug); ?>" target="_blank" rel="noopener"><i class="fa fa-whatsapp"></i></a>
                                <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($title); ?>&url=<?php echo urlencode('https://casaxuunan.com/blog-post.php?slug=' . $slug); ?>" target="_blank" rel="noopener"><i class="fa fa-twitter"></i></a>
                            </div>

                            <!-- CTA Box -->
                            <div class="blog-post-cta wow fadeInUp">
                                <h3><?php echo t('blog_cta_title'); ?></h3>
                                <p><?php echo t('blog_cta_desc'); ?></p>
                                <a href="rooms.php" class="btn-line"><span><?php echo t('blog_cta_button'); ?></span></a>
                            </div>

                            <!-- Related posts -->
                            <?php if (!empty($related)): ?>
                            <div class="blog-related wow fadeInUp">
                                <h3 class="text-center"><?php echo ($lang === 'es') ? 'También te puede interesar' : 'You might also like'; ?></h3>
                                <div class="row mt-3">
                                    <?php foreach ($related as $rel):
                                        $rel_title = ($lang === 'es') ? $rel['title_es'] : $rel['title_en'];
                                        $rel_slug = ($lang === 'es') ? $rel['slug'] : $rel['slug_en'];
                                        $rel_image = file_exists($rel['image']) ? $rel['image'] : $rel['fallback_image'];
                                    ?>
                                    <div class="col-md-4 mb-3">
                                        <a href="blog-post.php?slug=<?php echo urlencode($rel_slug); ?>" class="blog-related-card">
                                            <img src="<?php echo $rel_image; ?>" alt="<?php echo htmlspecialchars($rel_title); ?>" loading="lazy">
                                            <h4><?php echo $rel_title; ?></h4>
                                        </a>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Back to blog -->
                            <div class="text-center mt-4 mb-4">
                                <a href="blog.php" class="btn-line"><span><i class="fa fa-arrow-left"></i> <?php echo ($lang === 'es') ? 'Volver al Blog' : 'Back to Blog'; ?></span></a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>

            <!-- subheader close -->
