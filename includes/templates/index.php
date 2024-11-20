 <!-- content begin -->
 <div id="content" class="no-bottom no-top">

<!-- float text begin -->
<div class="float-text">
    <div class="de_social-icons">
        <a href="https://www.facebook.com/p/Casa-Xuunan-100091497343251/?locale=ne_NP&_rdr" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
        <a href="https://api.whatsapp.com/send?phone=5219852580599" target="_blank" ><i class="fa fa-whatsapp fa-lg"></i></a>
    </div>
    <span><a href="/rooms.php">Reserva Ahora</a></span>
</div>
<!-- float text close --> 

<div class='slider-overlay'></div>

<div id="slidecaption"></div>

<div class="container">    
    <div id="prevthumb"></div>
    <div id="nextthumb"></div>
    
    <!--Arrow Navigation-->
    <a id="prevslide" class="load-item"></a>
    <a id="nextslide" class="load-item"></a>
    
    <!--Time Bar-->
    <div id="progress-back" class="load-item">
        <div id="progress-bar"></div>
    </div>
    <!--Control Bar-->
    <div id="controls-wrapper" class="load-item">
        <div id="controls">
            
            <a id="play-button"><span id="pauseplay" class="play"></span></a>
        
            <!--Slide counter-->
            <div id="slidecounter">
                <span class="slidenumber"></span> / <span class="totalslides"></span>
            </div>
            
            <!--Navigation-->
            <ul id="slide-list"></ul>
            
        </div>
    </div>
</div>

</div>

<!-- Integración de la API de Hospitable -->


<!-- <script>
    async function fetchData(endpoint) {
        try {
            const response = await fetch(`api_proxy.php?endpoint=${endpoint}`);
            if (!response.ok) {
                throw new Error(`Error al obtener datos: ${response.statusText}`);
            }
            const data = await response.json();
            displayRooms(data.data);
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function fetchImages(propertyId) {
        try {
            const response = await fetch(`api_proxy.php?endpoint=properties/${propertyId}/images`);
            if (!response.ok) {
                throw new Error(`Error al obtener imágenes: ${response.statusText}`);
            }
            const data = await response.json();
            return data.data;
        } catch (error) {
            console.error('Error:', error);
            return [];
        }
    }

    async function checkAvailability(propertyId) {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        try {
            const response = await fetch(`api_proxy.php?endpoint=properties/${propertyId}/calendar?start_date=${formattedDate}&end_date=${formattedDate}`);
            if (!response.ok) {
                throw new Error('Error al verificar la disponibilidad.');
            }
            const data = await response.json();
            return data.data.days[0].status.available;
        } catch (error) {
            console.error('Error verificando disponibilidad:', error);
            return false;
        }
    }

    async function displayRooms(properties) {
        const roomContainer = document.getElementById('room-container');
        roomContainer.innerHTML = ''; // Limpiar el contenedor

        if (!properties || properties.length === 0) {
            roomContainer.innerHTML = '<p>No se encontraron habitaciones disponibles.</p>';
            return;
        }

        // Manejamos todas las solicitudes de imágenes y disponibilidad en paralelo
        const imagePromises = properties.map(property => fetchImages(property.id));
        const availabilityPromises = properties.map(property => checkAvailability(property.id));

        // Resolvemos todas las promesas de imágenes y disponibilidad
        const imagesList = await Promise.all(imagePromises);
        const availabilityList = await Promise.all(availabilityPromises);

        let roomHTML = ''; // Acumulador de HTML para una sola inserción en el DOM

        properties.forEach((property, index) => {
            const images = imagesList[index] || [];
            const isAvailable = availabilityList[index];

            const mainImageUrl = images.length > 0 ? images[0].url : 'ruta/default.jpg';
            const hoverImageUrl = images.length > 1 ? images[1].url : 'ruta/default-hover.jpg';

            // HTML de cada propiedad
            roomHTML += `
                <div class="col-lg-6">
                    <div class="de-room">
                        <div class="d-image">
                            <div class="d-label ${isAvailable ? 'available' : 'not-available'}">
                                ${isAvailable ? 'Disponible' : 'No Disponible'}
                            </div>
                            <a href="room.php?id=${property.id}">
                                <img src="${mainImageUrl}" class="img-fluid" style="width:100%; height:397px; object-fit:cover;" alt="${property.name}">
                                <img src="${hoverImageUrl}" class="d-img-hover img-fluid" style="width:100%; height:397px; object-fit:cover;" alt="${property.name}">
                            </a>
                        </div>
                        <div class="d-details">
                            <span class="d-meta-1"><img src="images/ui/user.svg" alt=""> ${property.capacity.max} Huéspedes</span>
                            <span class="d-meta-2"><img src="images/ui/floorplan.svg" alt=""> ${property.size ? property.size : 'N/A'} m²</span>
                        </div>
                        <div class="d-text">
                            <h3>${property.name}</h3>
                            <p>${property.description ? (property.description.length > 500 ? property.description.substring(0, 500) + '...' : property.description) : 'Descripción no disponible.'}</p>
                            <a href="room.php?id=${property.id}" class="btn-line"><span>Leer Más</span></a>
                        </div>
                    </div>
                </div>
            `;
        });

        // Insertar todo el HTML de una sola vez
        roomContainer.innerHTML = roomHTML;
    }

    // Llamada para obtener propiedades
    fetchData('properties');
</script> -->





