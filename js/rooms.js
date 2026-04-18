// Variable global para almacenar las traducciones
let translations = {};
let currentLang = 'en';

// Leer fechas de la URL (si vienen de search.php)
const searchParams = new URLSearchParams(window.location.search);
const searchCheckin = searchParams.get('checkin');
const searchCheckout = searchParams.get('checkout');
const searchAdults = searchParams.get('adults');
const searchChildren = searchParams.get('children');
const searchInfants = searchParams.get('infants');
const searchPets = searchParams.get('pets');
const hasSearchDates = !!(searchCheckin && searchCheckout);

function getCurrentLanguage() {
    const urlParams = new URLSearchParams(window.location.search);
    const langParam = urlParams.get('lang');
    if (langParam && (langParam === 'es' || langParam === 'en')) {
        localStorage.setItem('language', langParam);
        return langParam;
    }
    if (window.PHP_LANG && (window.PHP_LANG === 'es' || window.PHP_LANG === 'en')) {
        localStorage.setItem('language', window.PHP_LANG);
        return window.PHP_LANG;
    }
    const savedLang = localStorage.getItem('language');
    if (savedLang) return savedLang;
    return 'en';
}

async function loadTranslations() {
    currentLang = getCurrentLanguage();
    try {
        const response = await fetch(`api/get_translations.php?lang=${currentLang}`);
        if (!response.ok) throw new Error('Error');
        translations = await response.json();
    } catch (error) {
        translations = {};
    }
}

function t(key) {
    return translations[key] || key;
}

// Formatea rango de fechas para el banderín: "20-22 abr"
function formatDateRange(checkin, checkout) {
    try {
        const locale = currentLang === 'es' ? 'es-MX' : 'en-US';
        const optsShort = { day: 'numeric' };
        const optsMonth = { day: 'numeric', month: 'short' };
        const ci = new Date(checkin + 'T00:00:00');
        const co = new Date(checkout + 'T00:00:00');
        if (ci.getMonth() === co.getMonth()) {
            return ci.toLocaleDateString(locale, optsShort) + '-' + co.toLocaleDateString(locale, optsMonth);
        }
        return ci.toLocaleDateString(locale, optsMonth) + ' - ' + co.toLocaleDateString(locale, optsMonth);
    } catch (e) {
        return '';
    }
}

function showPlaceholder() {
    const colDiv = document.createElement('div');
    colDiv.classList.add('col-lg-6', 'placeholder-room');
    colDiv.innerHTML = `
        <div class="de-room">
            <div class="d-image">
                <div class="d-label"><span class="placeholder placeholder-wave w-50"></span></div>
                <div class="d-details">
                    <span class="d-meta-1"><span class="placeholder placeholder-wave w-25"></span></span>
                    <span class="d-meta-2"><span class="placeholder placeholder-wave w-25"></span></span>
                </div>
                <a href="#"><div class="placeholder placeholder-wave w-100" style="height: 397px;"></div></a>
            </div>
            <div class="d-text">
                <h3 class="placeholder-glow"><span class="placeholder w-75"></span></h3>
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

async function fetchData(endpoint) {
    const roomContainer = document.getElementById('room-container');
    try {
        const response = await fetch(`api_proxy_secure.php?endpoint=${endpoint}`);
        if (!response.ok) throw new Error(`Error: ${response.statusText}`);
        const data = await response.json();

        if (!data.data || data.data.length === 0) {
            roomContainer.innerHTML = '<p>' + t('rooms_no_results') + '</p>';
            return;
        }

        const reversedData = data.data.reverse();
        const placeholders = [];
        const promises = [];

        for (const property of reversedData) {
            const placeholderDiv = showPlaceholder();
            roomContainer.appendChild(placeholderDiv);
            placeholders.push({ placeholderDiv, property });

            const imagesPromise = fetchImages(property.id);
            const availabilityPromise = checkAvailability(property.id);
            const pricePromise = fetchPrice(property.id);

            promises.push(
                Promise.all([imagesPromise, availabilityPromise, pricePromise])
                    .then(([images, availability, price]) => ({ images, availability, price, property }))
                    .catch(() => ({ images: [], availability: { available: false }, price: null, property }))
            );
        }

        const results = await Promise.all(promises);

        for (let i = 0; i < results.length; i++) {
            const { images, availability, price, property } = results[i];
            const { placeholderDiv } = placeholders[i];
            const roomContent = createRoomContent(property, images, availability, price);
            placeholderDiv.innerHTML = '';
            placeholderDiv.appendChild(roomContent);
            placeholderDiv.classList.remove('placeholder-room');
        }
    } catch (error) {
        roomContainer.innerHTML = '<p>Ocurrió un error al cargar las habitaciones.</p>';
    }
}

function createRoomContent(property, images, availability, price) {
    const mainImageUrl = images.length > 0 ? images[0].url : 'ruta/default.jpg';
    const hoverImageUrl = images.length > 1 ? images[1].url : null;
    const isAvailable = availability && availability.available;

    const roomDiv = document.createElement('div');
    roomDiv.classList.add('de-room');

    // Imagen
    const imageDiv = document.createElement('div');
    imageDiv.classList.add('d-image');

    // Banderín de disponibilidad (contextual a fechas de búsqueda si existen)
    const labelDiv = document.createElement('div');
    labelDiv.classList.add('d-label', isAvailable ? 'available' : 'not-available');
    if (hasSearchDates) {
        const range = formatDateRange(searchCheckin, searchCheckout);
        labelDiv.innerHTML = isAvailable
            ? `${t('room_available_dates')} ${range}`
            : `${t('room_unavailable_dates')}`;
    } else {
        labelDiv.textContent = isAvailable ? t('room_available') : t('room_not_available');
    }
    imageDiv.appendChild(labelDiv);

    // Detalles (capacidad + tamaño)
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
    const sizeData = roomSize[property.name] || 'N/A';
    const sizeSpan = document.createElement('span');
    sizeSpan.classList.add('d-meta-2');
    sizeSpan.innerHTML = `<img src="images/ui/floorplan.svg" alt=""> ${sizeData} m²`;
    detailsDiv.appendChild(sizeSpan);
    imageDiv.appendChild(detailsDiv);

    // Construir URL con parámetros de búsqueda (pre-populate iframe)
    const roomParams = new URLSearchParams();
    roomParams.set('id', property.id);
    if (searchCheckin) roomParams.set('checkin', searchCheckin);
    if (searchCheckout) roomParams.set('checkout', searchCheckout);
    if (searchAdults) roomParams.set('adults', searchAdults);
    if (searchChildren) roomParams.set('children', searchChildren);
    if (searchInfants) roomParams.set('infants', searchInfants);
    if (searchPets) roomParams.set('pets', searchPets);
    const roomUrl = `room.php?${roomParams.toString()}`;

    // Enlace con imagen
    const roomLink = document.createElement('a');
    roomLink.href = roomUrl;
    const img = document.createElement('img');
    img.src = mainImageUrl;
    img.classList.add('img-fluid');
    img.alt = property.name;
    img.style.width = '100%';
    img.style.height = '397px';
    img.style.objectFit = 'cover';
    img.loading = 'lazy';
    roomLink.appendChild(img);

    if (hoverImageUrl) {
        const imgHover = document.createElement('img');
        imgHover.src = hoverImageUrl;
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

    // Texto
    const textDiv = document.createElement('div');
    textDiv.classList.add('d-text');

    const title = document.createElement('h3');
    const translationKey = `property_${property.id}_name`;
    const translatedName = t(translationKey);
    title.textContent = translatedName !== translationKey ? translatedName : property.name;
    textDiv.appendChild(title);

    const description = document.createElement('p');
    const maxDescriptionLength = 220;
    const summaryKey = `property_${property.id}_summary`;
    const translatedSummary = t(summaryKey);
    const summaryText = translatedSummary !== summaryKey ? translatedSummary : (property.summary || property.description || '');
    description.textContent = summaryText.length > maxDescriptionLength
        ? summaryText.substring(0, maxDescriptionLength) + '...'
        : summaryText;
    textDiv.appendChild(description);

    // Bloque de precio
    if (price && price > 0) {
        const priceBlock = document.createElement('div');
        priceBlock.classList.add('d-price');
        priceBlock.innerHTML = `
            <span class="d-price-from">${t('rooms_from')}</span>
            <span class="d-price-amount">$${Number(price).toLocaleString(currentLang === 'es' ? 'es-MX' : 'en-US')}</span>
            <span class="d-price-currency">MXN</span>
            <span class="d-price-night">${t('rooms_night')}</span>
            <span class="d-price-taxes">${t('rooms_plus_taxes')}</span>
        `;
        textDiv.appendChild(priceBlock);
    }

    // Trust badges
    const trustDiv = document.createElement('div');
    trustDiv.classList.add('d-trust');
    trustDiv.innerHTML = `
        <span class="d-trust-item"><i class="fa fa-bolt"></i> ${t('rooms_instant_confirm')}</span>
        <span class="d-trust-item"><i class="fa fa-check-circle"></i> ${t('rooms_no_prepay')}</span>
    `;
    textDiv.appendChild(trustDiv);

    // CTA principal (diferenciado por disponibilidad)
    const buttonLink = document.createElement('a');
    buttonLink.href = roomUrl;
    if (isAvailable) {
        buttonLink.classList.add('d-cta', 'd-cta-primary');
        buttonLink.innerHTML = `<span>${t('rooms_cta_book')} <i class="fa fa-arrow-right"></i></span>`;
    } else {
        buttonLink.classList.add('d-cta', 'd-cta-secondary');
        buttonLink.innerHTML = `<span>${t('rooms_cta_view')}</span>`;
    }
    textDiv.appendChild(buttonLink);

    roomDiv.appendChild(textDiv);
    return roomDiv;
}

async function fetchImages(propertyId) {
    try {
        const response = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}/images`);
        if (!response.ok) throw new Error();
        const data = await response.json();
        return data.data || [];
    } catch (error) {
        return [];
    }
}

// Checa disponibilidad para fechas de búsqueda (si hay) o para HOY
async function checkAvailability(propertyId) {
    let startDate, endDate;
    if (hasSearchDates) {
        startDate = searchCheckin;
        endDate = searchCheckout;
    } else {
        const today = new Date();
        startDate = endDate = today.toISOString().split('T')[0];
    }

    try {
        const response = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}/calendar?start_date=${startDate}&end_date=${endDate}`);
        if (!response.ok) throw new Error();
        const data = await response.json();
        const days = data?.data?.days || [];
        if (days.length === 0) return { available: false };
        // Filter only days within requested range (API may return extra days)
        const stayDays = hasSearchDates
            ? days.filter(d => d.date >= startDate && d.date < endDate)
            : days.filter(d => d.date === startDate);
        if (stayDays.length === 0) return { available: false };
        const allAvailable = stayDays.every(d => d.status && d.status.available);
        return { available: allAvailable };
    } catch (error) {
        return { available: false };
    }
}

// Obtiene precio desde el calendario (primer día con precio)
async function fetchPrice(propertyId) {
    try {
        const today = new Date();
        const start = today.toISOString().split('T')[0];
        const endDate = new Date(today);
        endDate.setDate(endDate.getDate() + 30);
        const end = endDate.toISOString().split('T')[0];

        const response = await fetch(`api_proxy_secure.php?endpoint=properties/${propertyId}/calendar?start_date=${start}&end_date=${end}`);
        if (!response.ok) throw new Error();
        const data = await response.json();
        const days = data?.data?.days || [];
        // Buscar primer día con precio (Hospitable envía en centavos → dividir /100)
        for (const day of days) {
            const p = day?.price?.amount ?? day?.rate ?? null;
            if (p && Number(p) > 0) {
                var markup = window.HOSPITABLE_MARKUP || 1.10;
                return Math.round((Number(p) / 100) * markup);
            }
        }
        return null;
    } catch (error) {
        return null;
    }
}

(async function init() {
    await loadTranslations();
    fetchData('properties');
})();
