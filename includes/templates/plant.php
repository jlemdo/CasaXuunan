<?php
// Obtener el ID de la planta desde la URL
$plantId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
$unlockCode = isset($_GET['unlock']) ? htmlspecialchars($_GET['unlock']) : null;

// Cargar plantas del JSON
$plantsJson = file_get_contents(__DIR__ . '/../../data/plants.json');
$plantsData = json_decode($plantsJson, true);
$lang = getCurrentLanguage();

// Buscar la planta por ID
$plant = null;
$plantIndex = 0;
foreach ($plantsData['plants'] as $index => $p) {
    if ($p['slug'] === $plantId) {
        $plant = $p;
        $plantIndex = $index;
        break;
    }
}

// Si no se encuentra la planta, redirigir al jardín
if (!$plant) {
    header('Location: garden.php');
    exit;
}

// Verificar si hay un código de desbloqueo válido
$isUnlocking = false;
$unlockSuccess = false;
if ($unlockCode && isset($plant['unlock_code'])) {
    $isUnlocking = true;
    // Validar código (case-insensitive)
    $unlockSuccess = (strtoupper($unlockCode) === strtoupper($plant['unlock_code']));
}

// Obtener planta anterior y siguiente para navegación
$prevPlant = isset($plantsData['plants'][$plantIndex - 1]) ? $plantsData['plants'][$plantIndex - 1] : null;
$nextPlant = isset($plantsData['plants'][$plantIndex + 1]) ? $plantsData['plants'][$plantIndex + 1] : null;
?>

<div id="background" data-bgimage="url(images/background/6.jpg) fixed"></div>
<div id="content-absolute">

    <!-- Breadcrumb -->
    <section id="plant-breadcrumb" class="no-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="plant-breadcrumb">
                        <a href="garden.php"><i class="fa fa-leaf"></i> Xuunan Garden</a>
                        <span class="separator">/</span>
                        <span class="current"><?php echo $plant['names']['common_' . $lang]; ?></span>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section id="section-plant" class="no-bg no-top" aria-label="plant-detail">
        <div class="container">

            <!-- Header de la planta -->
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <div class="plant-header">
                        <span class="plant-order">#<?php echo str_pad($plant['order'], 3, '0', STR_PAD_LEFT); ?></span>
                        <div class="plant-names">
                            <h1><?php echo $plant['names']['common_' . $lang]; ?></h1>
                            <p class="maya-name">
                                <span class="maya-label"><?php echo t('plant_maya_name'); ?>:</span>
                                <span class="maya-text"><?php echo $plant['names']['maya']; ?></span>
                            </p>
                            <p class="scientific-name"><em><?php echo $plant['names']['scientific']; ?></em></p>
                            <p class="family-name"><?php echo t('plant_family'); ?>: <?php echo $plant['names']['family']; ?></p>
                        </div>
                        <div class="plant-category">
                            <span class="category-badge category-<?php echo $plant['category']; ?>">
                                <?php
                                $categoryIcon = 'leaf';
                                if ($plant['category'] === 'medicinal') $categoryIcon = 'heartbeat';
                                if ($plant['category'] === 'ornamental') $categoryIcon = 'star';
                                if ($plant['category'] === 'edible') $categoryIcon = 'cutlery';
                                ?>
                                <i class="fa fa-<?php echo $categoryIcon; ?>"></i>
                                <?php echo t('garden_cat_' . $plant['category']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Imagen principal y descripción -->
            <div class="row mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="plant-image-container">
                        <img src="<?php echo $plant['images']['main']; ?>" alt="<?php echo $plant['names']['common_' . $lang]; ?>" class="plant-main-image" onerror="this.src='images/garden/placeholder.svg'">
                        <div class="plant-location-hint">
                            <i class="fa fa-map-marker-alt"></i>
                            <?php echo $plant['location_hint'][$lang]; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="plant-description-card">
                        <h3><i class="fa fa-info-circle"></i> <?php echo t('plant_about'); ?></h3>
                        <p class="description-text"><?php echo $plant['description'][$lang]; ?></p>

                        <!-- Información nutricional si existe -->
                        <?php if (isset($plant['nutrition'][$lang])): ?>
                        <div class="nutrition-info">
                            <h5><i class="fa fa-chart-pie"></i> <?php echo t('plant_nutrition'); ?></h5>
                            <p><?php echo $plant['nutrition'][$lang]; ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Usos Medicinales -->
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="plant-section medicinal-section">
                        <div class="section-header">
                            <i class="fa fa-heartbeat"></i>
                            <h3><?php echo t('plant_medicinal_uses'); ?></h3>
                        </div>
                        <div class="medicinal-uses-grid">
                            <?php foreach ($plant['medicinal_uses'][$lang] as $index => $use): ?>
                            <div class="medicinal-use-item" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                <div class="use-icon">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <span><?php echo $use; ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos Curiosos -->
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="plant-section curious-section">
                        <div class="section-header">
                            <i class="fa fa-lightbulb"></i>
                            <h3><?php echo t('plant_curious_facts'); ?></h3>
                        </div>
                        <div class="curious-facts-carousel">
                            <?php foreach ($plant['curious_facts'][$lang] as $index => $fact): ?>
                            <div class="curious-fact-card">
                                <div class="fact-number"><?php echo $index + 1; ?></div>
                                <p><?php echo $fact; ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Región e Historia -->
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="plant-section region-section">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="section-header">
                                    <i class="fa fa-globe-americas"></i>
                                    <h3><?php echo t('plant_region_history'); ?></h3>
                                </div>
                                <p class="region-text"><?php echo $plant['region_info'][$lang]; ?></p>
                            </div>
                            <div class="col-md-4">
                                <div class="region-map">
                                    <img src="images/garden/yucatan-map.svg" alt="Yucatan Region" onerror="this.style.display='none'">
                                    <div class="region-badge">
                                        <i class="fa fa-map-pin"></i>
                                        <?php echo t('plant_native_yucatan'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recetas Tradicionales (si existen) -->
            <?php if (isset($plant['traditional_recipes'][$lang]) && count($plant['traditional_recipes'][$lang]) > 0): ?>
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="plant-section recipes-section">
                        <div class="section-header">
                            <i class="fa fa-utensils"></i>
                            <h3><?php echo t('plant_traditional_recipes'); ?></h3>
                        </div>
                        <div class="recipes-grid">
                            <?php foreach ($plant['traditional_recipes'][$lang] as $recipe): ?>
                            <div class="recipe-item">
                                <i class="fa fa-mortar-pestle"></i>
                                <span><?php echo $recipe; ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Navegación entre plantas -->
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="plant-navigation">
                        <?php if ($prevPlant): ?>
                        <div class="nav-prev nav-item" data-plant-id="<?php echo $prevPlant['slug']; ?>">
                            <i class="fa fa-chevron-left"></i>
                            <div class="nav-info">
                                <span class="nav-label"><?php echo t('plant_prev'); ?></span>
                                <span class="nav-name"><?php echo $prevPlant['names']['common_' . $lang]; ?></span>
                            </div>
                            <i class="fa fa-lock nav-lock-icon"></i>
                        </div>
                        <?php else: ?>
                        <div class="nav-placeholder"></div>
                        <?php endif; ?>

                        <a href="garden.php" class="nav-home">
                            <i class="fa fa-th-large"></i>
                            <span><?php echo t('plant_all_plants'); ?></span>
                        </a>

                        <?php if ($nextPlant): ?>
                        <div class="nav-next nav-item" data-plant-id="<?php echo $nextPlant['slug']; ?>">
                            <div class="nav-info">
                                <span class="nav-label"><?php echo t('plant_next'); ?></span>
                                <span class="nav-name"><?php echo $nextPlant['names']['common_' . $lang]; ?></span>
                            </div>
                            <i class="fa fa-chevron-right"></i>
                            <i class="fa fa-lock nav-lock-icon"></i>
                        </div>
                        <?php else: ?>
                        <div class="nav-placeholder"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Compartir -->
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="plant-share">
                        <span class="share-label"><?php echo t('plant_share'); ?></span>
                        <div class="share-buttons">
                            <a href="https://wa.me/?text=<?php echo urlencode(t('plant_share_text') . ' ' . $plant['names']['common_' . $lang] . ' - ' . $_SERVER['HTTP_HOST'] . '/plant.php?id=' . $plant['slug']); ?>" target="_blank" class="share-btn whatsapp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['HTTP_HOST'] . '/plant.php?id=' . $plant['slug']); ?>" target="_blank" class="share-btn facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <button class="share-btn copy" onclick="copyPlantLink()">
                                <i class="fa fa-link"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Planta descubierta - Feedback visual -->
            <div class="plant-discovered-toast" id="discovered-toast">
                <i class="fa fa-check-circle"></i>
                <span><?php echo t('plant_discovered'); ?></span>
            </div>

        </div>
    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const plantId = '<?php echo $plant['slug']; ?>';
    const isUnlocking = <?php echo $isUnlocking ? 'true' : 'false'; ?>;
    const unlockSuccess = <?php echo $unlockSuccess ? 'true' : 'false'; ?>;

    // Check if plant is unlocked
    let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');
    const isUnlocked = unlocked.includes(plantId);

    // If coming from QR with valid code, unlock the plant
    if (isUnlocking && unlockSuccess) {
        if (!unlocked.includes(plantId)) {
            unlocked.push(plantId);
            localStorage.setItem('xuunan_garden_unlocked', JSON.stringify(unlocked));

            // Also mark as discovered
            let discovered = JSON.parse(localStorage.getItem('xuunan_garden_discovered') || '[]');
            if (!discovered.includes(plantId)) {
                discovered.push(plantId);
                localStorage.setItem('xuunan_garden_discovered', JSON.stringify(discovered));
            }

            // Reload to update unlocked list
            unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');

            // Show success toast
            setTimeout(function() {
                const toast = document.getElementById('discovered-toast');
                toast.classList.add('show');
                setTimeout(function() {
                    toast.classList.remove('show');
                }, 3000);
            }, 500);
        }

        // Remove unlock code from URL (clean URL)
        if (window.history && window.history.replaceState) {
            const cleanUrl = window.location.pathname + '?id=' + plantId;
            window.history.replaceState({}, document.title, cleanUrl);
        }
    } else if (isUnlocking && !unlockSuccess) {
        // Invalid code - show error and redirect
        alert('<?php echo t('garden_invalid_code'); ?>');
        window.location.href = 'garden.php';
        return;
    } else if (!isUnlocked && !isUnlocking) {
        // Not unlocked and no unlock code - redirect to garden
        window.location.href = 'garden.php';
        return;
    }

    // Initialize navigation lock states
    initNavLockStates(unlocked);
});

/**
 * Initialize navigation buttons lock state
 */
function initNavLockStates(unlocked) {
    document.querySelectorAll('.nav-item').forEach(function(navItem) {
        const targetPlantId = navItem.getAttribute('data-plant-id');

        if (unlocked.includes(targetPlantId)) {
            // Plant is unlocked - make it clickable
            navItem.classList.add('unlocked');
            navItem.classList.remove('locked');
            navItem.style.cursor = 'pointer';

            navItem.addEventListener('click', function() {
                window.location.href = 'plant.php?id=' + targetPlantId;
            });
        } else {
            // Plant is locked
            navItem.classList.add('locked');
            navItem.classList.remove('unlocked');

            navItem.addEventListener('click', function(e) {
                e.preventDefault();
                // Shake animation
                this.classList.add('shake');
                setTimeout(function() {
                    navItem.classList.remove('shake');
                }, 500);
            });
        }
    });
}

function copyPlantLink() {
    // Share clean URL without unlock code
    const plantId = '<?php echo $plant['slug']; ?>';
    const url = window.location.origin + window.location.pathname + '?id=' + plantId;
    navigator.clipboard.writeText(url).then(function() {
        alert('<?php echo t('plant_link_copied'); ?>');
    });
}
</script>
