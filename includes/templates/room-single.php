<?php
// Verificar si se proporcionó un ID de propiedad
if (!isset($_GET['id'])) {
    echo "ID de propiedad no proporcionado.";
    exit;
}

$propertyId = $_GET['id'];
?>
<!-- <div id="background" data-bgimage="url(images/room-single/bg.jpg) fixed"></div> -->
<div id="background"></div>
<div id="content-absolute">

    <!-- Subheader -->
    <section id="subheader" class="no-bg">
        <div class="container">
            <div class="row">
                <div id="room-name" class="col-md-12 text-center"></div>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section id="section-main" class="no-bg no-top" aria-label="section-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="de-content-overlay">
                        <!-- Social proof sobre el carrusel -->
                        <div class="room-hero-trust">
                            <span class="room-hero-stars">★★★★★</span>
                            <span class="room-hero-rating"><?php echo getCurrentLanguage() === 'es' ? '4.8/5 · Más de 50 reseñas verificadas' : '4.8/5 · 50+ verified reviews'; ?></span>
                        </div>

                        <!-- Carrusel de Imágenes -->
                        <div class="d-carousel wow fadeInRight animated" data-wow-delay="2s" style="position:relative;">
                            <!-- Banderín de disponibilidad flotante -->
                            <div id="room-availability-badge" class="room-availability-badge" style="display:none;"></div>
                            <div id="carousel-rooms" class="owl-carousel owl-theme owl-loaded owl-drag"></div>
                            <div class="d-arrow-left mod-a"><i class="fa fa-angle-left"></i></div>
                            <div class="d-arrow-right mod-a"><i class="fa fa-angle-right"></i></div>
                        </div>
                        <!-- Image counter (mobile replaces dots) -->
                        <div class="carousel-counter" id="carousel-counter"></div>

                        <!-- Detalles de la Habitación -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Barra room-details comentada: ya no se necesita con subtitulo + trust bar + price block
                                <div id="room-details" class="d-room-details de-flex">
                                    Detalles dinámicos de la habitación se insertarán aquí
                                </div>
                                -->
                                <div id="room-details" style="display:none;"></div>
                                <!-- Trust badges debajo del meta -->
                                <div class="room-trust-bar">
                                    <span class="room-trust-item"><i class="fa fa-bolt"></i> <?php echo t('rooms_instant_confirm'); ?></span>
                                    <span class="room-trust-item"><i class="fa fa-check-circle"></i> <?php echo t('rooms_no_prepay'); ?></span>
                                    <span class="room-trust-item"><i class="fa fa-cutlery"></i> <?php echo t('search_trust_breakfast'); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- **Nuevo Layout con Dos Columnas Izquierdas y Una Derecha** -->
                        <div class="row">
                            <!-- Lado Derecho: Booking Iframe -->
                            <div class="col-md-5 order-1 order-md-2 mb-4 booking-column">
                                <!-- Bloque de precio prominente -->
                                <div id="room-price-block" class="room-price-block" style="display:none;">
                                    <span class="room-price-from"><?php echo t('rooms_from'); ?></span>
                                    <div class="room-price-row">
                                        <span class="room-price-amount" id="room-price-amount"></span>
                                        <span class="room-price-unit">
                                            <span class="room-price-currency">MXN</span>
                                            <span class="room-price-night"><?php echo t('rooms_night'); ?></span>
                                        </span>
                                    </div>
                                    <span class="room-price-tax"><?php echo t('room_plus_tax'); ?></span>
                                </div>
                                <h3 class="text-center mb-3" id="booking-title"><?php echo t('room_book_now'); ?></h3>
                                <div class="booking-iframe-wrapper">
                                    <iframe id="booking-iframe" sandbox="allow-top-navigation allow-scripts allow-same-origin allow-forms allow-popups allow-popups-to-escape-sandbox" src="" allowfullscreen loading="lazy" class="booking-iframe-responsive">
                                    </iframe>
                                </div>

                                <!-- Neuromarketing: WhatsApp CTA -->
                                <div class="room-whatsapp-cta">
                                    <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(getCurrentLanguage() === 'es' ? '¡Hola! Me interesa reservar una habitación en Casa Xu\'unan' : 'Hi! I\'m interested in booking a room at Casa Xu\'unan'); ?>"
                                       target="_blank" rel="noopener noreferrer"
                                       onclick="if(typeof gtag==='function'){gtag('event','conversion',{'send_to':'AW-18041631980/6AUyCN_D3pMcEOzp9ZpD','value':1400,'currency':'MXN'});}">
                                        <i class="fa fa-whatsapp"></i>
                                        <?php echo getCurrentLanguage() === 'es' ? '¿Dudas? Escríbenos' : 'Questions? Message us'; ?>
                                    </a>
                                    <span class="cta-subtitle"><?php echo getCurrentLanguage() === 'es' ? 'Respuesta rápida por WhatsApp' : 'Quick reply via WhatsApp'; ?></span>
                                </div>

                                <!-- Neuromarketing: Social Proof -->
                                <div class="room-social-proof">
                                    <span><span class="stars">★★★★★</span> <?php echo getCurrentLanguage() === 'es' ? '4.8/5 · Más de 50 reseñas' : '4.8/5 · 50+ reviews'; ?></span>
                                </div>
                            </div>

                            <!-- Lado Izquierdo: Room Overview y Room Facilities -->
                            <div class="col-md-7 order-2 order-md-1">
                                <!-- Room Overview -->
                                <div class="mb-4">
                                    <h3 id="overview-title"><?php echo t('room_description'); ?></h3>
                                    <p id="room-overview">
                                        <!-- Descripción de la habitación se insertará aquí -->
                                    </p>
                                </div>

                                <!-- Room Facilities (Movido Debajo de Room Overview) -->
                                <div class="mb-4">
                                    <h3 id="facilities-title"><?php echo t('room_amenities'); ?></h3>
                                    <ul id="room-facilities" class="ul-style-2 grid-facilities collapsed">
                                        <!-- Facilidades de la habitación se insertarán aquí -->
                                    </ul>
                                    <div class="amenities-toggle">
                                        <button class="amenities-toggle-btn" onclick="toggleAmenities(this)">
                                            <?php echo getCurrentLanguage() === 'es' ? 'Ver todas' : 'See all'; ?> <i class="fa fa-chevron-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- **Fin del Nuevo Layout** -->

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sticky CTA mobile (solo visible en mobile) -->
    <div class="room-sticky-cta" id="room-sticky-cta" style="display:none;">
        <div class="sticky-cta-info">
            <span class="sticky-cta-from"><?php echo t('rooms_from'); ?></span>
            <span class="sticky-cta-price" id="sticky-cta-price"></span>
        </div>
        <a href="#booking-title" class="sticky-cta-btn">
            <?php echo t('rooms_cta_book'); ?> <i class="fa fa-arrow-right"></i>
        </a>
    </div>

    <!-- Estilos manejados por room-mobile.css -->

    <!-- JavaScript para cargar los detalles de la propiedad -->
    <script>
        // Variable global para almacenar las traducciones
        let translations = {};
        let currentLang = 'es';

        // Función para obtener el idioma actual
        function getCurrentLanguage() {
            // Primero intenta obtener del parámetro URL (MAYOR PRIORIDAD)
            const urlParams = new URLSearchParams(window.location.search);
            const langParam = urlParams.get('lang');
            if (langParam && (langParam === 'es' || langParam === 'en')) {
                // Guardar en localStorage para mantener preferencia
                localStorage.setItem('language', langParam);
                return langParam;
            }

            // Luego intenta obtener de localStorage
            const savedLang = localStorage.getItem('language');
            if (savedLang) return savedLang;

            // Por defecto, español
            return 'es';
        }

        // Función para cargar traducciones
        async function loadTranslations() {
            currentLang = getCurrentLanguage();

            try {
                const response = await fetch(`api/get_translations.php?lang=${currentLang}`);

                if (!response.ok) {
                    throw new Error('Error al cargar traducciones: ' + response.status);
                }
                translations = await response.json();
            } catch (error) {
                translations = {}; // Usar objeto vacío como fallback
            }
        }

        // Función helper para obtener traducción
        function t(key) {
            return translations[key] || key;
        }

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
                const propertyResponse = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}`);
                if (!propertyResponse.ok) {
                    throw new Error('Error al cargar los datos de la habitación.');
                }
                const propertyData = await propertyResponse.json();
                const property = propertyData.data;

                // Obtener precio del calendario — usar fechas seleccionadas si existen
                const urlParams = new URLSearchParams(window.location.search);
                const checkinParam = urlParams.get('checkin');
                const today = new Date().toISOString().split('T')[0];
                const priceDate = checkinParam || today;
                const calendarResponse = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}/calendar?start_date=${priceDate}&end_date=${priceDate}`);
                const calendarData = await calendarResponse.json();

                // Extraer precio oficial (con fallback a tags)
                let nightlyPrice = property.tags[0] || '---';
                if (calendarData.data && calendarData.data.days && calendarData.data.days.length > 0) {
                    const targetDay = calendarData.data.days.find(d => d.date === priceDate) || calendarData.data.days[0];
                    if (targetDay.price && targetDay.price.amount) {
                        var markup = window.HOSPITABLE_MARKUP || 1.10;
                        nightlyPrice = Math.round((targetDay.price.amount / 100) * markup).toString();
                    }
                }

                // Intentar obtener nombre traducido, si no existe usar el de la API
                const translationKey = `property_${propertyId}_name`;
                const translatedName = t(translationKey);
                const displayName = translatedName !== translationKey ? translatedName : property.name;

                // Dividir el nombre en "nombre" y "código"
                const [name, code] = displayName.split(':').map(part => part.trim());

                // Subtitulo descriptivo: capacidad + bedrooms (datos REALES de Hospitable, sin inventar)
                const guestsLabel = property.capacity.max == 1 ? t('room_guest_singular') : t('room_guests');
                const bedroomsLabel = property.capacity.bedrooms == 1 ? t('room_bedroom_singular') : t('room_bedrooms');
                const subtitle = `${t('room_for')} ${property.capacity.max} ${guestsLabel.toLowerCase()} · ${property.capacity.bedrooms} ${bedroomsLabel.toLowerCase()}`;

                // Insertar nombre de la habitación dinámicamente
                roomNameElement.innerHTML = `
            <h4>${name || ''}</h4>
            <h1>${code || ''}</h1>
            <p class="room-hero-subtitle">${subtitle}</p>
        `;

                // Barra room-details deshabilitada: datos ya se muestran en subtitulo + trust bar + price block
                // roomDetailsElement.innerHTML = `
                //     <div class="de-flex-col"><img src="images/ui/user.svg" alt=""> ${property.capacity.max} ${t('room_guests')}</div>
                //     <div class="de-flex-col"><img src="images/ui/floorplan.svg" alt=""> ${property.capacity.bedrooms} ${t('room_bedrooms')}</div>
                // `;

                // Llenar bloque de precio prominente + sticky CTA mobile
                if (nightlyPrice && nightlyPrice !== '---') {
                    const formattedPrice = Number(nightlyPrice).toLocaleString(currentLang === 'es' ? 'es-MX' : 'en-US');
                    const priceBlock = document.getElementById('room-price-block');
                    const priceAmount = document.getElementById('room-price-amount');
                    const stickyPrice = document.getElementById('sticky-cta-price');
                    const stickyCta = document.getElementById('room-sticky-cta');
                    if (priceBlock && priceAmount) {
                        priceAmount.textContent = '$' + formattedPrice;
                        priceBlock.style.display = 'block';
                    }
                    if (stickyPrice) stickyPrice.textContent = '$' + formattedPrice + ' MXN';
                    if (stickyCta) stickyCta.style.display = '';
                }

                // Banderin de disponibilidad (usa fechas de URL si hay, o HOY)
                (async function renderAvailabilityBadge() {
                    try {
                        const params = new URLSearchParams(window.location.search);
                        const ci = params.get('checkin');
                        const co = params.get('checkout');
                        let startDate, endDate, hasDates = false;
                        if (ci && co) {
                            startDate = ci; endDate = co; hasDates = true;
                        } else {
                            const today = new Date();
                            startDate = endDate = today.toISOString().split('T')[0];
                        }
                        const resp = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}/calendar?start_date=${startDate}&end_date=${endDate}`);
                        if (!resp.ok) return;
                        const json = await resp.json();
                        const days = json?.data?.days || [];
                        if (days.length === 0) return;
                        // Only check days within the actual stay range (checkin to day before checkout)
                        let available;
                        if (hasDates) {
                            const stayDays = days.filter(d => d.date >= startDate && d.date < endDate);
                            available = stayDays.length > 0 && stayDays.every(d => d.status && d.status.available);
                        } else {
                            available = days.length > 0 && days[0].status && days[0].status.available;
                        }
                        const badge = document.getElementById('room-availability-badge');
                        if (!badge) return;

                        let text;
                        if (hasDates) {
                            // Formato "20-22 abr"
                            const locale = currentLang === 'es' ? 'es-MX' : 'en-US';
                            const ciD = new Date(ci + 'T00:00:00');
                            const coD = new Date(co + 'T00:00:00');
                            const range = ciD.getMonth() === coD.getMonth()
                                ? ciD.toLocaleDateString(locale, { day: 'numeric' }) + '-' + coD.toLocaleDateString(locale, { day: 'numeric', month: 'short' })
                                : ciD.toLocaleDateString(locale, { day: 'numeric', month: 'short' }) + ' - ' + coD.toLocaleDateString(locale, { day: 'numeric', month: 'short' });
                            text = available
                                ? `${t('room_available_dates')} ${range}`
                                : t('room_unavailable_dates');
                        } else {
                            text = available ? t('room_available') : t('room_not_available');
                        }
                        badge.textContent = text;
                        badge.className = 'room-availability-badge ' + (available ? 'available' : 'not-available');
                        badge.style.display = 'inline-block';
                    } catch (e) {}
                })();
                // Intentar obtener descripción traducida, si no existe usar la de la API
                const summaryKey = `property_${propertyId}_summary`;
                const translatedSummary = t(summaryKey);
                const descriptionText = translatedSummary !== summaryKey ? translatedSummary : property.description;

                const formattedDescription = descriptionText.replace(/\n/g, '<br>');
                roomOverviewElement.innerHTML = formattedDescription;

                // Función para convertir snake_case a texto legible usando traducciones
                const formatAmenity = (amenity) => {
                    const amenityKey = `amenity_${amenity}`;
                    const translatedAmenity = t(amenityKey);
                    // Si existe traducción, usarla; si no, usar formato de fallback
                    if (translatedAmenity !== amenityKey) {
                        return translatedAmenity;
                    }
                    // Fallback: convertir snake_case a texto legible
                    return amenity.replace(/_/g, ' ').replace(/^\w/, (c) => c.toUpperCase());
                };


                // Generar la lista con formato
                const facilitiesList = property.amenities
                    .map(facility => `<li>${formatAmenity(facility)}</li>`)
                    .join('');
                roomFacilitiesElement.innerHTML = facilitiesList;

                // Obtener imágenes de la propiedad
                const imagesResponse = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}/images`);
                if (!imagesResponse.ok) {
                    throw new Error('Error al cargar las imágenes de la propiedad.');
                }
                const imagesData = await imagesResponse.json();
                const images = imagesData.data;

                // Insertar imágenes en la galería
                const imageGallery = images.map(image => `
                    <div class="item">
                        <div class="picframe" style="position: relative; overflow: hidden; width: 100%; border-radius: 12px;">
                            <a class="popup-gallery-item" href="${image.url}">
                                <span class="overlay">
                                    <span class="pf_title"><i class="icon_search"></i></span>
                                    <span class="pf_caption">${image.caption || (typeof NeuroCaptions !== 'undefined' ? NeuroCaptions.getRandomWord() : '')}</span>
                                </span>
                            </a>
                            <img src="${image.url}" alt="${image.caption || 'Image'}" loading="lazy" class="carousel-room-img">
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

                // // Inicializar el visualizador de imágenes
                $('.image-popup-gallery').magnificPopup({
                    type: 'image',
                    mainClass: 'mfp-with-zoom mfp-img-mobile',
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
                    loop: true,
                    dots: true,
                    nav: false,
                    touchDrag: true,
                    mouseDrag: true,
                    autoHeight: true,
                    responsive: {
                        0: {
                            items: 1,
                            margin: 0,
                            stagePadding: 0
                        },
                        600: {
                            items: 2,
                            margin: 15
                        },
                        1000: {
                            items: 3,
                            margin: 20
                        }
                    }
                });

                // Inicializar Magnific Popup en los elementos del carrusel
                $('#carousel-rooms').magnificPopup({
                    delegate: '.popup-gallery-item', // Selector para los enlaces de imágenes
                    type: 'image',
                    gallery: {
                        enabled: true, // Activa la galería
                        navigateByImgClick: true
                    },
                    image: {
                        titleSrc: function(item) {
                            return item.el.find('.pf_caption').text(); // Obtiene el título de la imagen
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

                // Image counter for mobile (replaces dots)
                const totalImages = images.length;
                const counterEl = document.getElementById('carousel-counter');
                if (counterEl) {
                    counterEl.innerHTML = `<span>1</span> / ${totalImages}`;
                    $('#carousel-rooms').on('changed.owl.carousel', function(event) {
                        const current = event.item.index - event.relatedTarget._clones.length / 2 + 1;
                        const adjustedCurrent = ((current - 1) % totalImages + totalImages) % totalImages + 1;
                        counterEl.innerHTML = `<span>${adjustedCurrent}</span> / ${totalImages}`;
                    });
                }


                // **Asignar el src del iframe dinámicamente usando ID de propiedad**
                // Mapeo directo de ID de Hospitable → URL del iframe de booking
                const bookingIframesByID = {
                    '33c1edc0-e09a-408b-9a57-5f3203e2f3de': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376728', // Casa Xu'unan: PB "B"
                    'b6687699-08bb-4508-b052-d1623c291d1a': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376730', // Casa Xu'unan: PB "A"
                    '2baa5ca2-6f6c-42e9-ad7c-68eac6230028': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376732', // Casa Xu'unan: PB "C"
                    '1c42a0ce-90fb-4033-9db6-7f0288e60e76': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1718966', // Casa Xu'unan: PB "D"
                    '8d72e6cf-34e6-40e5-8955-3a425971dce1': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376734', // Casa Xu'unan: PA "A"
                    'd0daae70-0f5f-476f-a6d1-1d8e5746c9a6': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376736', // Casa Xu'unan: PA "B"
                    'c64b251c-745e-4f77-b961-c22e9d1f0150': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376738', // Casa Xu'unan: PA "C"
                    '50655096-21a7-4386-995c-ecb5e8594afa': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376740', // Casa Xu'unan: J "B"
                    '8825b949-7c57-4ac5-ba7b-4ba7eb6c0e9d': 'https://booking.hospitable.com/widget/9d53ac64-203e-4623-bb00-0c90b835aaf6/1376742'  // Casa Xu'unan: J "A"
                };

                // Usar el propertyId directamente (mismo ID usado para calendario y precio)
                const iframeSrc = bookingIframesByID[propertyId];

                if (!iframeSrc) {
                    bookingIframeElement.src = 'about:blank';
                } else {
                    // Pre-populate dates from search widget (Step 3 integration)
                    let finalSrc = iframeSrc;
                    const urlParams = new URLSearchParams(window.location.search);
                    const checkin = urlParams.get('checkin');
                    const checkout = urlParams.get('checkout');
                    const adults = urlParams.get('adults');
                    const children = urlParams.get('children');
                    const infants = urlParams.get('infants');
                    const pets = urlParams.get('pets');

                    if (checkin || checkout || adults) {
                        const separator = finalSrc.includes('?') ? '&' : '?';
                        const params = [];
                        if (checkin) params.push(`checkin=${checkin}`);
                        if (checkout) params.push(`checkout=${checkout}`);
                        if (adults) params.push(`adults=${adults}`);
                        if (children) params.push(`children=${children}`);
                        if (infants) params.push(`infants=${infants}`);
                        if (pets) params.push(`pets=${pets}`);
                        finalSrc += separator + params.join('&');
                    }

                    bookingIframeElement.src = finalSrc;

                    // --- Hospitable iframe postMessage integration ---
                    // Listen for iframeHeight and language messages from the booking widget
                    window.addEventListener("message", function (event) {
                        if (event.origin !== "https://booking.hospitable.com") return;

                        // Auto-resize iframe height (recommended by Hospitable docs)
                        if (event.data && event.data.iframeHeight) {
                            bookingIframeElement.style.height = event.data.iframeHeight + "px";
                        }

                        // Respond to language request from widget
                        if (event.data && event.data.type === "GET_HOSPITABLE_LANGUAGE") {
                            const lang = document.documentElement.lang || 'en';
                            bookingIframeElement.contentWindow.postMessage(
                                { type: "SET_HOSPITABLE_LANGUAGE", language: lang },
                                "https://booking.hospitable.com"
                            );
                        }
                    });
                }

            } catch (error) {
                alert('Hubo un problema al cargar los detalles de la habitación.');
            }
        }

        // Toggle amenidades (ver más / ver menos)
        function toggleAmenities(btn) {
            const list = document.getElementById('room-facilities');
            const isCollapsed = list.classList.contains('collapsed');

            if (isCollapsed) {
                list.classList.remove('collapsed');
                btn.classList.add('expanded');
                btn.innerHTML = '<?php echo getCurrentLanguage() === "es" ? "Ver menos" : "See less"; ?> <i class="fa fa-chevron-up"></i>';
            } else {
                list.classList.add('collapsed');
                btn.classList.remove('expanded');
                btn.innerHTML = '<?php echo getCurrentLanguage() === "es" ? "Ver todas" : "See all"; ?> <i class="fa fa-chevron-down"></i>';
                // Scroll back to amenities section
                document.getElementById('facilities-title').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Inicializar: Cargar traducciones y luego cargar detalles de la habitación
        (async function init() {
            await loadTranslations();
            await loadRoomDetails(<?php echo json_encode($propertyId); ?>);
        })();
    </script>

    <!-- Google Ads: Track booking intent when user reaches a room page from search -->
    <script>
    (function() {
        if (typeof gtag !== 'function') return;
        try {
            if (sessionStorage.getItem('cx_intent_fired') === '1') return;
            var params = new URLSearchParams(window.location.search);
            // Solo contar como intent si vino con fechas (busqueda real, no navegacion directa)
            if (!params.get('checkin') || !params.get('checkout')) return;
            gtag('event', 'conversion', {
                'send_to': 'AW-18041631980/iN5dCO6stpwcEOzp9ZpD',
                'value': 2500.0,
                'currency': 'MXN',
                'transaction_id': 'cx_room_' + Date.now(),
                'transport_type': 'beacon'
            });
            sessionStorage.setItem('cx_intent_fired', '1');
        } catch(e) {}
    })();
    </script>