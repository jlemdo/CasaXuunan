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
        // Mostrar un indicador de carga global si lo deseas
        // showLoadingIndicator();

        const response = await fetch(`api_proxy.php?endpoint=${endpoint}`);
        if (!response.ok) {
            throw new Error(`Error al obtener datos: ${response.statusText}`);
        }

        const data = await response.json();

        // Verificar si hay habitaciones disponibles
        if (!data.data || data.data.length === 0) {
            roomContainer.innerHTML = '<p>No se encontraron habitaciones disponibles.</p>';
            return;
        }

        // Procesar cada habitación individualmente
        for (const property of data.data) {
            // Mostrar un placeholder para la habitación actual
            const placeholderDiv = showPlaceholder();
            roomContainer.appendChild(placeholderDiv);

            // Iniciar las solicitudes en paralelo para imágenes y disponibilidad
            const imagesPromise = fetchImages(property.id);
            const availabilityPromise = checkAvailability(property.id);

            // Esperar a que las promesas se resuelvan
            const [images, isAvailable] = await Promise.all([imagesPromise, availabilityPromise]);

            // Generar el contenido real de la habitación
            const roomContent = createRoomContent(property, images, isAvailable);

            // Reemplazar el placeholder con el contenido real
            placeholderDiv.innerHTML = '';
            placeholderDiv.appendChild(roomContent);
            placeholderDiv.classList.remove('placeholder-room');
        }

        // Ocultar el indicador de carga global si lo utilizaste
        // hideLoadingIndicator();

    } catch (error) {
        console.error('Error:', error);
        roomContainer.innerHTML = '<p>Ocurrió un error al cargar las habitaciones.</p>';
    }
}

// Función para crear el contenido de la habitación
function createRoomContent(property, images, isAvailable) {
    const mainImageUrl = images.length > 0 ? images[0].url : 'ruta/default.jpg';
    const hoverImageUrl = images.length > 1 ? images[1].url : 'ruta/default-hover.jpg';

    // Crear elementos HTML para la habitación
    const roomDiv = document.createElement('div');
    roomDiv.classList.add('de-room');

    // Imagen de la habitación
    const imageDiv = document.createElement('div');
    imageDiv.classList.add('d-image');

    // Etiqueta de disponibilidad
    const labelDiv = document.createElement('div');
    labelDiv.classList.add('d-label', isAvailable ? 'available' : 'not-available');
    labelDiv.textContent = isAvailable ? 'Disponible' : 'No Disponible';
    imageDiv.appendChild(labelDiv);

    // Detalles de la habitación
    const detailsDiv = document.createElement('div');
    detailsDiv.classList.add('d-details');

    const guestSpan = document.createElement('span');
    guestSpan.classList.add('d-meta-1');
    guestSpan.innerHTML = `<img src="images/ui/user.svg" alt=""> ${property.capacity?.max || 'N/A'} Huéspedes`;
    detailsDiv.appendChild(guestSpan);

    const sizeSpan = document.createElement('span');
    sizeSpan.classList.add('d-meta-2');
    sizeSpan.innerHTML = `<img src="images/ui/floorplan.svg" alt=""> ${property.size || 'N/A'} m²`;
    detailsDiv.appendChild(sizeSpan);

    imageDiv.appendChild(detailsDiv);

    // Enlace a la página de detalle de la habitación
    const roomLink = document.createElement('a');
    roomLink.href = `02-room-single.php?id=${property.id}`;

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
    title.textContent = property.name;
    textDiv.appendChild(title);

    const description = document.createElement('p');
    const maxDescriptionLength = 500;
    description.textContent = property.description
        ? property.description.length > maxDescriptionLength
            ? property.description.substring(0, maxDescriptionLength) + '...'
            : property.description
        : 'Descripción no disponible.';
    textDiv.appendChild(description);

    const buttonLink = document.createElement('a');
    buttonLink.href = `02-room-single.php?id=${property.id}`;
    buttonLink.classList.add('btn-line');
    buttonLink.innerHTML = `<span>Leer Más</span>`;
    textDiv.appendChild(buttonLink);

    roomDiv.appendChild(textDiv);

    return roomDiv;
}

// Función para obtener imágenes de una propiedad
async function fetchImages(propertyId) {
    try {
        const response = await fetch(`api_proxy.php?endpoint=properties/${propertyId}/images`);
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
        const response = await fetch(`api_proxy.php?endpoint=properties/${propertyId}/calendar?start_date=${formattedDate}&end_date=${formattedDate}`);
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

// Llamada para obtener propiedades
fetchData('properties');
