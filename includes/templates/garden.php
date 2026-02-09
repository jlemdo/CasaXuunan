<?php
// Cargar plantas del JSON
$plantsJson = file_get_contents(__DIR__ . '/../../data/plants.json');
$plantsData = json_decode($plantsJson, true);
$lang = getCurrentLanguage();

// Calcular estadísticas dinámicas
$totalPlants = count($plantsData['plants']);
$medicinalCount = 0;
$ornamentalCount = 0;
$edibleCount = 0;

foreach ($plantsData['plants'] as $plant) {
    switch ($plant['category']) {
        case 'medicinal':
            $medicinalCount++;
            break;
        case 'ornamental':
            $ornamentalCount++;
            break;
        case 'edible':
            $edibleCount++;
            break;
    }
}

// Obtener planta destacada
$featuredPlant = null;
foreach ($plantsData['plants'] as $plant) {
    if ($plant['featured']) {
        $featuredPlant = $plant;
        break;
    }
}

// Filtrar por categoría si se especifica
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
?>

<div id="background" data-bgimage="url(images/background/6.jpg) fixed"></div>
<div id="content-absolute">

    <!-- Subheader - igual que rooms.php -->
    <section id="subheader" class="no-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4><?php echo t('garden_subtitle'); ?></h4>
                    <h1><?php echo t('garden_title'); ?></h1>
                    <p class="garden-tagline"><?php echo sprintf(t('garden_tagline'), $totalPlants); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section id="section-main" class="no-bg no-top" aria-label="section-garden">
        <div class="container">

            <!-- Introducción interactiva -->
            <div class="row mb-5">
                <div class="col-md-10 offset-md-1">
                    <div class="garden-intro-card">
                        <div class="garden-intro-icon">
                            <div class="pulse-ring"></div>
                            <i class="fa fa-qrcode"></i>
                        </div>
                        <h3><?php echo t('garden_how_title'); ?></h3>
                        <p class="lead"><?php echo t('garden_how_desc'); ?></p>

                        <div class="garden-steps">
                            <div class="garden-step">
                                <div class="step-number">1</div>
                                <div class="step-icon"><i class="fa fa-street-view"></i></div>
                                <h5><?php echo t('garden_step1_title'); ?></h5>
                                <p><?php echo t('garden_step1_desc'); ?></p>
                            </div>
                            <div class="garden-step">
                                <div class="step-number">2</div>
                                <div class="step-icon"><i class="fa fa-qrcode"></i></div>
                                <h5><?php echo t('garden_step2_title'); ?></h5>
                                <p><?php echo t('garden_step2_desc'); ?></p>
                            </div>
                            <div class="garden-step">
                                <div class="step-number">3</div>
                                <div class="step-icon"><i class="fa fa-book"></i></div>
                                <h5><?php echo t('garden_step3_title'); ?></h5>
                                <p><?php echo t('garden_step3_desc'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas del jardín (DINÁMICAS) -->
            <div class="row mb-5">
                <div class="col-md-10 offset-md-1">
                    <div class="garden-stats">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fa fa-leaf"></i></div>
                            <div class="stat-number" data-count="<?php echo $totalPlants; ?>"><?php echo $totalPlants; ?></div>
                            <div class="stat-label"><?php echo t('garden_stat_plants'); ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fa fa-heartbeat"></i></div>
                            <div class="stat-number" data-count="<?php echo $medicinalCount; ?>"><?php echo $medicinalCount; ?></div>
                            <div class="stat-label"><?php echo t('garden_stat_medicinal'); ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fa fa-history"></i></div>
                            <div class="stat-number">500+</div>
                            <div class="stat-label"><?php echo t('garden_stat_years'); ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fa fa-map-marker"></i></div>
                            <div class="stat-number">100%</div>
                            <div class="stat-label"><?php echo t('garden_stat_native'); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de categorías -->
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <h3 class="id-color"><?php echo t('garden_categories_title'); ?></h3>
                    <p class="lead"><?php echo t('garden_categories_desc'); ?></p>
                </div>
            </div>

            <div class="row g-4 mb-5 justify-content-center">
                <div class="col-md-4">
                    <a href="garden.php?category=medicinal#plants-grid" class="garden-category-card <?php echo $categoryFilter === 'medicinal' ? 'active' : ''; ?>" data-category="medicinal" data-filter-text="<?php echo t('garden_click_filter'); ?>" data-active-text="<?php echo t('garden_filter_active'); ?>">
                        <div class="category-icon category-medicinal">
                            <i class="fa fa-heartbeat"></i>
                        </div>
                        <h4><?php echo t('garden_cat_medicinal'); ?></h4>
                        <p><?php echo t('garden_cat_medicinal_desc'); ?></p>
                        <span class="category-count"><?php echo $medicinalCount; ?> <?php echo t('garden_species'); ?></span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="garden.php?category=ornamental#plants-grid" class="garden-category-card <?php echo $categoryFilter === 'ornamental' ? 'active' : ''; ?>" data-category="ornamental" data-filter-text="<?php echo t('garden_click_filter'); ?>" data-active-text="<?php echo t('garden_filter_active'); ?>">
                        <div class="category-icon category-ornamental">
                            <i class="fa fa-star"></i>
                        </div>
                        <h4><?php echo t('garden_cat_ornamental'); ?></h4>
                        <p><?php echo t('garden_cat_ornamental_desc'); ?></p>
                        <span class="category-count"><?php echo $ornamentalCount; ?> <?php echo t('garden_species'); ?></span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="garden.php?category=edible#plants-grid" class="garden-category-card <?php echo $categoryFilter === 'edible' ? 'active' : ''; ?>" data-category="edible" data-filter-text="<?php echo t('garden_click_filter'); ?>" data-active-text="<?php echo t('garden_filter_active'); ?>">
                        <div class="category-icon category-edible">
                            <i class="fa fa-cutlery"></i>
                        </div>
                        <h4><?php echo t('garden_cat_edible'); ?></h4>
                        <p><?php echo t('garden_cat_edible_desc'); ?></p>
                        <span class="category-count"><?php echo $edibleCount; ?> <?php echo t('garden_species'); ?></span>
                    </a>
                </div>
            </div>

            <!-- Filtro activo -->
            <?php if ($categoryFilter): ?>
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <div class="active-filter">
                        <span><?php echo t('garden_showing'); ?>: <strong><?php echo t('garden_cat_' . $categoryFilter); ?></strong></span>
                        <a href="garden.php#plants-grid" class="clear-filter">
                            <i class="fa fa-times"></i> <?php echo t('garden_show_all'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Grid de Plantas -->
            <div id="plants-grid" class="row mb-5">
                <div class="col-md-12 text-center mb-4">
                    <h3 class="id-color"><?php echo $categoryFilter ? t('garden_cat_' . $categoryFilter) : t('garden_all_plants'); ?></h3>
                    <p class="lead"><?php echo t('garden_explore_collection'); ?></p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <?php
                foreach ($plantsData['plants'] as $plant) {
                    // Filtrar por categoría si aplica
                    if ($categoryFilter && $plant['category'] !== $categoryFilter) {
                        continue;
                    }

                    $categoryIcon = 'leaf';
                    $categoryClass = '';
                    switch ($plant['category']) {
                        case 'medicinal':
                            $categoryIcon = 'heartbeat';
                            $categoryClass = 'category-medicinal';
                            break;
                        case 'ornamental':
                            $categoryIcon = 'star';
                            $categoryClass = 'category-ornamental';
                            break;
                        case 'edible':
                            $categoryIcon = 'cutlery';
                            $categoryClass = 'category-edible';
                            break;
                    }
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="plant-card locked" data-plant-id="<?php echo $plant['slug']; ?>" data-plant-order="<?php echo $plant['order']; ?>">
                        <div class="plant-card-image">
                            <img src="<?php echo $plant['images']['main']; ?>" alt="<?php echo $plant['names']['common_' . $lang]; ?>" onerror="this.src='images/garden/placeholder.svg'">
                            <div class="plant-card-order">#<?php echo str_pad($plant['order'], 2, '0', STR_PAD_LEFT); ?></div>
                            <div class="plant-card-category <?php echo $categoryClass; ?>">
                                <i class="fa fa-<?php echo $categoryIcon; ?>"></i>
                            </div>
                            <!-- Lock overlay - shown by default -->
                            <div class="plant-card-lock-overlay">
                                <i class="fa fa-lock"></i>
                                <span class="lock-text"><?php echo t('garden_plant_locked'); ?></span>
                                <span class="hint-text"><i class="fa fa-map-marker"></i> <?php echo $plant['location_hint'][$lang]; ?></span>
                            </div>
                            <!-- Unlocked badge - hidden by default -->
                            <div class="plant-card-unlocked-badge" style="display: none;">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="plant-card-info">
                            <h5><?php echo $plant['names']['common_' . $lang]; ?></h5>
                            <p class="maya-name"><?php echo $plant['names']['maya']; ?></p>
                            <p class="scientific-name"><em><?php echo $plant['names']['scientific']; ?></em></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Planta destacada -->
            <?php if ($featuredPlant && !$categoryFilter): ?>
            <div class="row mb-5">
                <div class="col-md-12 text-center mb-4">
                    <h3 class="id-color"><?php echo t('garden_featured_title'); ?></h3>
                    <p class="lead"><?php echo t('garden_featured_desc'); ?></p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-10 offset-md-1">
                    <div class="garden-featured-plant" id="featured-plant" data-plant-id="<?php echo $featuredPlant['slug']; ?>">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="featured-plant-image">
                                    <div class="plant-badge"><?php echo t('garden_featured_badge'); ?></div>
                                    <img src="<?php echo $featuredPlant['images']['main']; ?>" alt="<?php echo $featuredPlant['names']['common_' . $lang]; ?>" onerror="this.src='images/garden/placeholder.svg'" class="featured-img">
                                    <div class="plant-maya-name"><?php echo $featuredPlant['names']['maya']; ?></div>
                                    <!-- Lock overlay for featured plant -->
                                    <div class="featured-lock-overlay">
                                        <i class="fa fa-lock"></i>
                                        <span class="lock-text"><?php echo t('garden_plant_locked'); ?></span>
                                        <span class="hint-text"><i class="fa fa-map-marker"></i> <?php echo $featuredPlant['location_hint'][$lang]; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="featured-plant-info">
                                    <span class="plant-category-tag">
                                        <i class="fa fa-heartbeat"></i> <?php echo t('garden_cat_' . $featuredPlant['category']); ?>
                                    </span>
                                    <h2><?php echo $featuredPlant['names']['common_' . $lang]; ?></h2>
                                    <p class="scientific-name"><em><?php echo $featuredPlant['names']['scientific']; ?></em></p>
                                    <p class="plant-description featured-description"><?php echo $featuredPlant['description'][$lang]; ?></p>

                                    <div class="plant-quick-facts featured-facts">
                                        <div class="quick-fact">
                                            <i class="fa fa-check-circle"></i>
                                            <span><?php echo $featuredPlant['medicinal_uses'][$lang][0]; ?></span>
                                        </div>
                                        <div class="quick-fact">
                                            <i class="fa fa-check-circle"></i>
                                            <span><?php echo $featuredPlant['medicinal_uses'][$lang][1]; ?></span>
                                        </div>
                                    </div>

                                    <a href="plant.php?id=<?php echo $featuredPlant['slug']; ?>" class="btn-main featured-btn" data-plant-id="<?php echo $featuredPlant['slug']; ?>">
                                        <i class="fa fa-arrow-right"></i> <?php echo t('garden_learn_more'); ?>
                                    </a>
                                    <!-- Locked button alternative -->
                                    <div class="btn-locked featured-btn-locked">
                                        <i class="fa fa-lock"></i> <?php echo t('garden_scan_to_unlock'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Call to Action - Bloqueado por rangos -->
            <div class="row mb-5">
                <div class="col-md-10 offset-md-1">
                    <div class="garden-cta" id="garden-cta">
                        <!-- Locked overlay -->
                        <div class="cta-locked-overlay" id="cta-locked-overlay">
                            <i class="fa fa-lock"></i>
                            <span><?php echo t('garden_cta_locked'); ?></span>
                        </div>
                        <div class="cta-content">
                            <i class="fa fa-camera"></i>
                            <div>
                                <h3><?php echo t('garden_cta_title'); ?></h3>
                                <p><?php echo t('garden_cta_desc'); ?></p>
                            </div>
                        </div>
                        <div class="cta-action">
                            <div class="cta-hashtag">#XuunanGarden</div>
                            <div class="cta-social">
                                <!-- WhatsApp - Explorador (badge 1) -->
                                <a href="https://wa.me/?text=<?php echo urlencode('#XuunanGarden - ' . t('garden_share_message')); ?>" target="_blank" class="social-btn social-whatsapp" data-badge="1" title="WhatsApp">
                                    <i class="fa fa-whatsapp"></i>
                                    <span class="social-lock"><i class="fa fa-lock"></i></span>
                                </a>
                                <!-- Facebook - Botánico (badge 2) -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://casaxuunan.com/garden.php'); ?>" target="_blank" class="social-btn social-facebook" data-badge="2" title="Facebook">
                                    <i class="fa fa-facebook"></i>
                                    <span class="social-lock"><i class="fa fa-lock"></i></span>
                                </a>
                                <!-- Instagram - Experto (badge 3) -->
                                <a href="https://www.instagram.com/casa_xuunan/" target="_blank" class="social-btn social-instagram" data-badge="3" title="Instagram">
                                    <i class="fa fa-instagram"></i>
                                    <span class="social-lock"><i class="fa fa-lock"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progreso del visitante (gamificación) -->
            <div class="row mb-5">
                <div class="col-md-10 offset-md-1">
                    <div class="garden-progress-card" id="visitor-progress">
                        <div class="progress-header">
                            <i class="fa fa-trophy"></i>
                            <h4><?php echo t('garden_progress_title'); ?></h4>
                        </div>
                        <div class="progress-wrapper">
                            <span class="progress-text" id="progress-text">0 / <?php echo $totalPlants; ?> <?php echo t('garden_plants_discovered'); ?></span>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" id="progress-fill" style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="progress-badges">
                            <?php
                            // Calcular umbrales dinámicos basados en el total de plantas
                            $badge1 = max(1, round($totalPlants * 0.10)); // 10%
                            $badge2 = max(2, round($totalPlants * 0.25)); // 25%
                            $badge3 = max(3, round($totalPlants * 0.50)); // 50%
                            $badge4 = $totalPlants; // 100%
                        ?>
                            <div class="badge-item locked" data-unlock="<?php echo $badge1; ?>">
                                <i class="fa fa-pagelines"></i>
                                <span class="badge-name"><?php echo t('garden_badge_explorer'); ?></span>
                                <span class="badge-requirement"><?php echo $badge1; ?> <?php echo t('garden_plants'); ?></span>
                            </div>
                            <div class="badge-item locked" data-unlock="<?php echo $badge2; ?>">
                                <i class="fa fa-leaf"></i>
                                <span class="badge-name"><?php echo t('garden_badge_botanist'); ?></span>
                                <span class="badge-requirement"><?php echo $badge2; ?> <?php echo t('garden_plants'); ?></span>
                            </div>
                            <div class="badge-item locked" data-unlock="<?php echo $badge3; ?>">
                                <i class="fa fa-tree"></i>
                                <span class="badge-name"><?php echo t('garden_badge_expert'); ?></span>
                                <span class="badge-requirement"><?php echo $badge3; ?> <?php echo t('garden_plants'); ?></span>
                            </div>
                            <div class="badge-item locked" data-unlock="<?php echo $badge4; ?>">
                                <i class="fa fa-sun-o"></i>
                                <span class="badge-name"><?php echo t('garden_badge_master'); ?></span>
                                <span class="badge-requirement"><?php echo $badge4; ?> <?php echo t('garden_plants'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<script>
// Datos para JavaScript
window.GARDEN_DATA = {
    totalPlants: <?php echo $totalPlants; ?>,
    lang: '<?php echo $lang; ?>',
    translations: {
        plants_discovered: '<?php echo t('garden_plants_discovered'); ?>'
    }
};
</script>
