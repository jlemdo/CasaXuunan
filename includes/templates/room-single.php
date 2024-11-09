<?php
// Verificar si se proporcionó un ID de propiedad
if (!isset($_GET['id'])) {
    echo "ID de propiedad no proporcionado.";
    exit;
}

$propertyId = $_GET['id'];
?>
<!-- <div id="background" data-bgimage="url(images/room-single/bg.jpg) fixed"></div> -->
<div id="background" fixed"></div>
<div id="content-absolute">

    <!-- Subheader -->
    <section id="subheader" class="no-bg">
        <div class="container">
            <div class="row">
                <div id="room-name" class="col-md-12 text-center"></div>
            </div>
    </section>

    <!-- Main Content Section -->
    <section id="section-main" class="no-bg no-top" aria-label="section-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="de-content-overlay">
                        <!-- Carrusel de Imágenes -->
                        <div class="d-carousel wow fadeInRight animated" data-wow-delay="2s">
                            <div id="carousel-rooms" class="owl-carousel owl-theme owl-loaded owl-drag"></div>
                            <div class="d-arrow-left mod-a"><i class="fa fa-angle-left"></i></div>
                            <div class="d-arrow-right mod-a"><i class="fa fa-angle-right"></i></div>
                        </div>

                        <!-- Detalles de la Habitación -->
                        <div class="row">
                            <div class="col-md-12">
                                <div id="room-details" class="d-room-details de-flex">
                                    <!-- Detalles dinámicos de la habitación se insertarán aquí -->
                                </div>
                            </div>
                        </div>

                        <!-- **Nuevo Layout con Dos Columnas Izquierdas y Una Derecha** -->
                        <div class="row">
                            <!-- Lado Derecho: Booking Iframe -->
                            <div class="col-md-4 order-1 order-md-2 mb-4">
                                <h3 class="text-center mb-3">Booking</h3>
                                <div class="d-flex flex-row justify-content-center alig-items-center">
                                    <iframe id="booking-iframe" sandbox="allow-top-navigation allow-scripts allow-same-origin" src="" allowfullscreen loading="lazy" class="mx-auto" style="border: none; height: 550px;">
                                    </iframe>
                                </div>
                            </div>

                            <!-- Lado Izquierdo: Room Overview y Room Facilities -->
                            <div class="col-md-8 order-2 order-md-1">
                                <!-- Room Overview -->
                                <div class="mb-4">
                                    <h3>Room Overview</h3>
                                    <p id="room-overview">
                                        <!-- Descripción de la habitación se insertará aquí -->
                                    </p>
                                </div>

                                <!-- Room Facilities (Movido Debajo de Room Overview) -->
                                <div class="mb-4">
                                    <h3>Room Facilities</h3>
                                    <ul id="room-facilities" class="ul-style-2">
                                        <!-- Facilidades de la habitación se insertarán aquí -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- **Fin del Nuevo Layout** -->

                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- JavaScript para cargar los detalles de la propiedad -->
    <script>
        async function loadRoomDetails(propertyId) {
            try {
                // Cachear elementos del DOM para mejorar el rendimiento
                const roomNameElement = document.getElementById('room-name');
                const roomDetailsElement = document.getElementById('room-details');
                const roomOverviewElement = document.getElementById('room-overview');
                const roomFacilitiesElement = document.getElementById('room-facilities');
                const carouselRoomsElement = document.getElementById('carousel-rooms');
                const backgroundElement = document.getElementById('background');
                const bookingIframeElement = document.getElementById('booking-iframe');

                // Obtener detalles de la propiedad
                const propertyResponse = await fetch(`api_proxy.php?endpoint=properties/${propertyId}`);
                if (!propertyResponse.ok) {
                    throw new Error('Error al cargar los datos de la habitación.');
                }
                const propertyData = await propertyResponse.json();
                const property = propertyData.data;

                // Dividir el nombre en "nombre" y "código"
                const [name, code] = property.name.split(':').map(part => part.trim());
                console.log(property.name);

                // Insertar nombre de la habitación dinámicamente
                roomNameElement.innerHTML = `
            <h4>${name || ''}</h4>
            <h1>${code || ''}</h1>
        `;

                // Insertar detalles principales de la habitación
                roomDetailsElement.innerHTML = `
            <div class="de-flex-col"><img src="images/ui/user.svg" alt=""> ${property.capacity.max} Guests</div>
            <div class="de-flex-col"><img src="images/ui/floorplan.svg" alt=""> ${property.capacity.bedrooms} Bedrooms</div>
            <div class="de-flex-col"><img src="images/ui/bed.svg" alt=""> $${property.tags[0]} MXN / Night</div>
            <div class="de-flex-col"><a href="02-booking.php" class="btn-main"><span>Book Now</span></a></div>
        `;
                roomOverviewElement.textContent = property.description;

                // Insertar facilidades de la habitación
                const facilitiesList = property.amenities.map(facility => `<li>${facility}</li>`).join('');
                roomFacilitiesElement.innerHTML = facilitiesList;

                // Obtener imágenes de la propiedad
                const imagesResponse = await fetch(`api_proxy.php?endpoint=properties/${propertyId}/images`);
                if (!imagesResponse.ok) {
                    throw new Error('Error al cargar las imágenes de la propiedad.');
                }
                const imagesData = await imagesResponse.json();
                const images = imagesData.data;

                // Insertar imágenes en la galería
                const imageGallery = images.map(image => `
            <div class="item">
                <div class="picframe" style="position: relative; overflow: hidden; width: 100%; height: 200px;">
                    <a class="image-popup-gallery" href="${image.url}">
                        <span class="overlay">
                            <span class="pf_title"><i class="icon_search"></i></span>
                            <span class="pf_caption">${image.caption || 'No Caption'}</span>
                        </span>
                    </a>
                    <img src="${image.url}" alt="${image.caption || 'Image'}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        `).join('');
                carouselRoomsElement.innerHTML = imageGallery;

                // Establecer la imagen de fondo del div
                if (images.length > 0) {
                    const backgroundImageUrl = images[0].url;
                    backgroundElement.style.backgroundImage = `url(${backgroundImageUrl})`;
                    backgroundElement.style.backgroundSize = 'cover';
                    backgroundElement.style.backgroundPosition = 'center';
                }

                // Inicializar el visualizador de imágenes
                $('.image-popup-gallery').magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });

                // Inicializar o reinicializar el carrusel
                if ($.fn.owlCarousel && $('#carousel-rooms').hasClass('owl-loaded')) {
                    $('#carousel-rooms').trigger('destroy.owl.carousel');
                    $('#carousel-rooms').removeClass('owl-loaded');
                    $('#carousel-rooms').html(imageGallery);
                }

                $('#carousel-rooms').owlCarousel({
                    items: 3,
                    margin: 20,
                    loop: false,
                    dots: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        1000: {
                            items: 3
                        }
                    }
                });

                // Activar el carrusel de navegación
                $('.d-carousel .d-arrow-right').off('click').on('click', function() {
                    $('#carousel-rooms').trigger('next.owl.carousel');
                });
                $('.d-carousel .d-arrow-left').off('click').on('click', function() {
                    $('#carousel-rooms').trigger('prev.owl.carousel');
                });

                // **Asignar el src del iframe dinámicamente**
                const bookingIframes = {
                    'Casa Xu’unan: PB "B"': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376728',
                    'Casa Xu’unan: PB "A"': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376730',
                    'Casa Xu’unan: PB "C"': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376732',
                    'Casa Xu’unan: PA “A”': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376734',
                    'Casa Xu’unan: PA “B”': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376736',
                    'Casa Xu’unan: PA "C"': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376738',
                    'Casa Xu’unan:  J “B”': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376740',
                    'Casa Xu’unan:  J “A”': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376742'
                };

                // Asegurar que property.name coincide con las claves del objeto
                const iframeSrc = bookingIframes[property.name] || 'https://booking.hospitable.com/widget/default-url';
                bookingIframeElement.src = iframeSrc;

            } catch (error) {
                console.error('Error:', error);
                alert('Hubo un problema al cargar los detalles de la habitación.');
            }
        }

        // Llamada a la función con el ID de la propiedad
        loadRoomDetails(<?php echo json_encode($propertyId); ?>);
    </script>