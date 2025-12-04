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
    console.log('🌐 Cargando traducciones para idioma:', currentLang);

    try {
        const response = await fetch(`api/get_translations.php?lang=${currentLang}`);
        console.log('📡 Respuesta de API:', response.status, response.statusText);

        if (!response.ok) {
            throw new Error('Error al cargar traducciones: ' + response.status);
        }
        translations = await response.json();
        console.log('✅ Traducciones cargadas:', Object.keys(translations).length, 'claves');
        console.log('🔍 Ejemplo - room_available:', translations.room_available);
        console.log('🔍 Ejemplo - room_guests:', translations.room_guests);
    } catch (error) {
        console.error('❌ Error cargando traducciones:', error);
        translations = {}; // Usar objeto vacío como fallback
    }
}

// Función helper para obtener traducción
function t(key) {
    return translations[key] || key;
}

// Función para mostrar un placeholder mientras se carga cada habitación
function showPlaceholder() {
    const colDiv = document.createElement('div');
    colDiv.classList.add('col-lg-6', 'placeholder-room');

    colDiv.innerHTML = `
        <div class="de-room">
            <div class="d-image">
                <div class="d-label">
                    <span class="placeholder placeholder-wave w-50"></span>
                </div>
                <div class="d-details">
                    <span class="d-meta-1">
                        <span class="placeholder placeholder-wave w-25"></span>
                    </span>
                    <span class="d-meta-2">
                        <span class="placeholder placeholder-wave w-25"></span>
                    </span>
                </div>
                <a href="#">
                    <div class="placeholder placeholder-wave w-100" style="height: 397px;"></div>
                </a>
            </div>
            <div class="d-text">
                <h3 class="placeholder-glow">
                    <span class="placeholder w-75"></span>
                </h3>
                <p class="placeholder-glow">
                    <span class="placeholder w-100"></span>
                    <span class="placeholder w-100"></span>
                    <span class="placeholder w-50"></span>
                </p>
                <a href="#" class="btn-line disabled placeholder col-6"></a>
            </div>
        </div>
    `;

    return colDiv;
}

// Función principal para obtener y mostrar las habitaciones
async function fetchData(endpoint) {
    const roomContainer = document.getElementById('room-container');

    try {
        const response = await fetch(`api_proxy_secure.php?endpoint=${endpoint}`);
        if (!response.ok) {
            throw new Error(`Error al obtener datos: ${response.statusText}`);
        }

        const data = await response.json();

        // Verificar si hay habitaciones disponibles
        if (!data.data || data.data.length === 0) {
            roomContainer.innerHTML = '<p>No se encontraron habitaciones disponibles.</p>';
            return;
        }

        const reversedData = data.data.reverse();

        // Arrays para almacenar placeholders y promesas
        const placeholders = [];
        const promises = [];

        // Mostrar placeholders y iniciar solicitudes
        for (const property of reversedData) {
            // Mostrar placeholder
            const placeholderDiv = showPlaceholder();
            roomContainer.appendChild(placeholderDiv);
            placeholders.push({ placeholderDiv, property });

            // Iniciar solicitudes de imágenes y disponibilidad sin esperar
            const imagesPromise = fetchImages(property.id);
            const availabilityPromise = checkAvailability(property.id);

            // Almacenar las promesas combinadas
            promises.push(
                Promise.all([imagesPromise, availabilityPromise])
                    .then(([images, isAvailable]) => ({ images, isAvailable, property }))
                    .catch(error => {
                        console.error('Error:', error);
                        return { images: [], isAvailable: false, property };
                    })
            );
        }

        // Esperar a que todas las promesas se resuelvan
        const results = await Promise.all(promises);

        // Actualizar el DOM con los datos reales
        for (let i = 0; i < results.length; i++) {
            const { images, isAvailable, property } = results[i];
            const { placeholderDiv } = placeholders[i];

            // Generar el contenido real de la habitación
            const roomContent = createRoomContent(property, images, isAvailable);

            // Reemplazar el placeholder con el contenido real
            placeholderDiv.innerHTML = '';
            placeholderDiv.appendChild(roomContent);
            placeholderDiv.classList.remove('placeholder-room');
        }

    } catch (error) {
        console.error('Error:', error);
        roomContainer.innerHTML = '<p>Ocurrió un error al cargar las habitaciones.</p>';
    }
}

// Función para crear el contenido de la habitación
function createRoomContent(property, images, isAvailable) {
    const mainImageUrl = images.length > 0 ? images[0].url : 'ruta/default.jpg';
    const hoverImageUrl = images.length > 1 ? images[1].url : null; // Usar null si no hay imagen de hover

    // Crear elementos HTML para la habitación
    const roomDiv = document.createElement('div');
    roomDiv.classList.add('de-room');

    // Imagen de la habitación
    const imageDiv = document.createElement('div');
    imageDiv.classList.add('d-image');

    // Etiqueta de disponibilidad
    const labelDiv = document.createElement('div');
    labelDiv.classList.add('d-label', isAvailable ? 'available' : 'not-available');
    labelDiv.textContent = isAvailable ? t('room_available') : t('room_not_available');
    imageDiv.appendChild(labelDiv);

    // Detalles de la habitación
    const detailsDiv = document.createElement('div');
    detailsDiv.classList.add('d-details');

    const guestSpan = document.createElement('span');
    guestSpan.classList.add('d-meta-1');
    guestSpan.innerHTML = `<img src="images/ui/user.svg" alt=""> ${property.capacity?.max || 'N/A'} ${t('room_guests')}`;
    detailsDiv.appendChild(guestSpan);

    const roomSize = {
        'Casa Xu’unan: PB "B"': '23.2',
        'Casa Xu’unan: PB "A"': '22.4',
        'Casa Xu’unan: PB "C"': '23.2',
        'Casa Xu’unan: PB "D"': '30.1',
        'Casa Xu’unan: PA “A”': '20.4',
        'Casa Xu’unan: PA “B”': '27.0',
        'Casa Xu’unan: PA "C"': '32.86',
        'Casa Xu’unan:  J “B”': '26.66',
        'Casa Xu’unan:  J “A”': '26.66'
    };

    // Asegurar que property.name coincide con las claves del objeto
    const sizeData = roomSize[property.name] || 'N/A';

    const sizeSpan = document.createElement('span');
    sizeSpan.classList.add('d-meta-2');
    sizeSpan.innerHTML = `<img src="images/ui/floorplan.svg" alt=""> ${sizeData} m²`;
    detailsDiv.appendChild(sizeSpan);

    imageDiv.appendChild(detailsDiv);

    // Enlace a la página de detalle de la habitación
    const roomLink = document.createElement('a');
    roomLink.href = `room.php?id=${property.id}`;

    // Imagen principal
    const img = document.createElement('img');
    img.src = mainImageUrl; // Imagen principal
    img.classList.add('img-fluid');
    img.alt = property.name;
    img.style.width = '100%';
    img.style.height = '397px';
    img.style.objectFit = 'cover';
    img.loading = 'lazy';

    roomLink.appendChild(img);

    // Imagen al pasar el mouse (opcional)
    if (hoverImageUrl) {
        const imgHover = document.createElement('img');
        imgHover.src = hoverImageUrl; // Imagen secundaria
        imgHover.classList.add('d-img-hover', 'img-fluid');
        imgHover.alt = property.name;
        imgHover.style.width = '100%';
        imgHover.style.height = '397px';
        imgHover.style.objectFit = 'cover';
        imgHover.loading = 'lazy';
        roomLink.appendChild(imgHover);
    }

    imageDiv.appendChild(roomLink);
    roomDiv.appendChild(imageDiv);

    // Texto de la habitación
    const textDiv = document.createElement('div');
    textDiv.classList.add('d-text');

    const title = document.createElement('h3');
    // Intentar obtener nombre traducido, si no existe usar el de la API
    const translationKey = `property_${property.id}_name`;
    const translatedName = t(translationKey);

    console.log(`🏠 Habitación ID: ${property.id}`);
    console.log(`🔑 Buscando clave: ${translationKey}`);
    console.log(`📝 Nombre API: ${property.name}`);
    console.log(`🌐 Nombre traducido: ${translatedName}`);
    console.log(`✅ ¿Encontró traducción?: ${translatedName !== translationKey}`);

    title.textContent = translatedName !== translationKey ? translatedName : property.name;
    textDiv.appendChild(title);

    const description = document.createElement('p');
    const maxDescriptionLength = 500;
    // Intentar obtener descripción traducida, si no existe usar la de la API
    const summaryKey = `property_${property.id}_summary`;
    const translatedSummary = t(summaryKey);

    console.log(`📄 Buscando descripción: ${summaryKey}`);
    console.log(`🌐 Descripción traducida encontrada: ${translatedSummary !== summaryKey}`);

    const summaryText = translatedSummary !== summaryKey ? translatedSummary : (property.summary || property.description || 'Descripción no disponible.');
    description.textContent = summaryText.length > maxDescriptionLength
        ? summaryText.substring(0, maxDescriptionLength) + '...'
        : summaryText;
    textDiv.appendChild(description);

    const buttonLink = document.createElement('a');
    buttonLink.href = `room.php?id=${property.id}`;
    buttonLink.classList.add('btn-line');
    buttonLink.innerHTML = `<span>${t('room_read_more')}</span>`;
    textDiv.appendChild(buttonLink);

    roomDiv.appendChild(textDiv);

    return roomDiv;
}

// Función para obtener imágenes de una propiedad
async function fetchImages(propertyId) {
    try {
        const response = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}/images`);
        if (!response.ok) {
            throw new Error(`Error al obtener imágenes: ${response.statusText}`);
        }

        const data = await response.json();
        return data.data; // Retornamos el array de imágenes
    } catch (error) {
        console.error('Error:', error);
        return [];
    }
}

// Función para verificar la disponibilidad
async function checkAvailability(propertyId) {
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];

    try {
        const response = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}/calendar?start_date=${formattedDate}&end_date=${formattedDate}`);
        if (!response.ok) {
            throw new Error('Error al verificar la disponibilidad.');
        }
        const data = await response.json();
        return data.data.days[0].status.available; // Retorna la disponibilidad del primer día
    } catch (error) {
        console.error('Error verificando disponibilidad:', error);
        return false; // Asumir no disponible en caso de error
    }
}

// Inicializar: Cargar traducciones y luego obtener propiedades
(async function init() {
    await loadTranslations();
    fetchData('properties');
})();
