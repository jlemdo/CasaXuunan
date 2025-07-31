// JavaScript específico para la página de tours
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('whatsapp-form');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Obtener los valores del formulario
            const nombre = document.getElementById('nombre').value.trim();
            const telefono = document.getElementById('telefono').value.trim();
            const paquete = document.getElementById('paquete').value;
            const personas = document.getElementById('personas').value;
            const fecha = document.getElementById('fecha').value;
            const edad = document.getElementById('edad').value;
            const comentarios = document.getElementById('comentarios').value.trim();

            // Validar campos requeridos
            if (!nombre || !telefono || !paquete || !personas || !fecha || !edad) {
                alert('Por favor completa todos los campos requeridos.');
                return;
            }

            // Construir el mensaje para WhatsApp
            let mensaje = `¡Hola! Me interesa reservar un tour con Casa Xuunan.\n\n`;
            mensaje += `👤 *Nombre:* ${nombre}\n`;
            mensaje += `📱 *Teléfono:* ${telefono}\n`;
            mensaje += `🏞️ *Tour Seleccionado:* ${paquete}\n`;
            mensaje += `👥 *Número de personas:* ${personas}\n`;
            mensaje += `📅 *Fecha Deseada:* ${fecha}\n`;
            mensaje += `👶 *Rango de edad:* ${edad}\n`;

            if (comentarios) {
                mensaje += `💬 *Información adicional:* ${comentarios}\n`;
            }

            mensaje += `\n¿Podrían confirmarme disponibilidad y detalles? ¡Gracias!`;

            // Codificar el mensaje para URL
            const mensajeCodificado = encodeURIComponent(mensaje);

            // Número de WhatsApp (el mismo que ya usan)
            const numeroWhatsApp = '5219852580599';

            // Crear URL de WhatsApp
            const urlWhatsApp = `https://api.whatsapp.com/send?phone=${numeroWhatsApp}&text=${mensajeCodificado}`;

            // Mostrar modal con instrucciones antes de abrir WhatsApp
            mostrarModalInstrucciones(() => {
                // Después de cerrar el modal, abrir WhatsApp
                window.open(urlWhatsApp, '_blank');
                // Limpiar el formulario
                form.reset();
            });
        });
    }
});

// Función para mostrar modal con instrucciones estilizado
function mostrarModalInstrucciones(callback) {
    // Crear el modal
    const modal = document.createElement('div');
    modal.id = 'instrucciones-modal';
    modal.innerHTML = `
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>✅ ¡Tu solicitud de tour será enviada por WhatsApp!</h3>
                </div>
                <div class="modal-body">
                    <h4>🎒 IMPORTANTE - Para tu aventura maya:</h4>
                    <ul class="instrucciones-list">
                        <li>👟 Usa calzado cómodo y cerrado (evita sandalias)</li>
                        <li>🏊‍♀️ Trae traje de baño y toalla para los cenotes</li>
                        <li>🧢 Sombrero, gorra y gafas de sol obligatorios</li>
                        <li>🧴 Protector solar biodegradable (OBLIGATORIO en cenotes)</li>
                        <li>💧 Botella de agua reutilizable (incluimos refill)</li>
                        <li>📸 Cámara impermeable o funda para cenotes</li>
                        <li>💵 Efectivo para artesanías locales y propinas</li>
                        <li>🩱 Cambio de ropa seca para después de cenotes</li>
                    </ul>
                    <p class="final-message">🏛️ ¡Te esperamos para vivir la auténtica experiencia maya en Yucatán!</p>
                </div>
                <div class="modal-footer">
                    <button id="continuar-whatsapp" class="btn-modal">
                        <i class="fa fa-whatsapp"></i> Continuar a WhatsApp
                    </button>
                </div>
            </div>
        </div>
    `;

    // Agregar al DOM
    document.body.appendChild(modal);

    // Mostrar el modal
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

    // Event listener para el botón
    document.getElementById('continuar-whatsapp').addEventListener('click', function() {
        // Ocultar modal
        modal.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(modal);
            // Ejecutar callback (abrir WhatsApp)
            callback();
        }, 300);
    });

    // Cerrar con clic fuera del modal
    modal.querySelector('.modal-overlay').addEventListener('click', function(e) {
        if (e.target === this) {
            modal.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(modal);
                callback();
            }, 300);
        }
    });
}