<div id="background" data-bgimage="url(images/background/6.jpg) fixed"></div>

<!-- Aquí va tu código del header y menú, asegúrate de que esté traducido al español -->

<!-- Contenido principal -->
<div id="content-absolute">

    <!-- Subheader -->
    <section id="subheader" class="no-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4><?php echo t('rooms_subtitle'); ?></h4>
                    <h1><?php echo t('rooms_title'); ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección principal -->
    <section id="section-main" class="no-bg no-top" aria-label="section-menu">
        <div class="container">
            <div class="row g-4" id="room-container">
                <!-- Aquí se cargarán dinámicamente las habitaciones -->
            </div>
        </div>
    </section>
    <!-- Subheader close -->

<!-- El script rooms.js se carga automáticamente desde js.php -->


