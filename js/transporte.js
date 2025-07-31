// JavaScript específico para la página de transporte
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('whatsapp-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtener los valores del formulario
            const nombre = document.getElementById('nombre').value.trim();
            const telefono = document.getElementById('telefono').value.trim();
            const ruta = document.getElementById('ruta').value;
            const pasajeros = document.getElementById('pasajeros').value;
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;
            const comentarios = document.getElementById('comentarios').value.trim();
            
            // Validar campos requeridos
            if (!nombre || !telefono || !ruta || !pasajeros || !fecha || !hora) {
                alert('Por favor completa todos los campos requeridos.');
                return;
            }
            
            // Construir el mensaje para WhatsApp
            let mensaje = `¡Hola! Necesito un traslado con Casa Xuunan.\n\n`;
            mensaje += `👤 *Nombre:* ${nombre}\n`;
            mensaje += `📱 *Teléfono:* ${telefono}\n`;
            mensaje += `🚗 *Ruta:* ${ruta}\n`;
            mensaje += `👥 *Pasajeros:* ${pasajeros}\n`;
            mensaje += `📅 *Fecha:* ${fecha}\n`;
            mensaje += `🕐 *Hora:* ${hora}\n`;
            
            if (comentarios) {
                mensaje += `💬 *Información adicional:* ${comentarios}\n`;
            }
            
            mensaje += `\n¿Podrían confirmarme disponibilidad y detalles del servicio? ¡Gracias!`;
            
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
                    <h3>✅ ¡Tu solicitud será enviada por WhatsApp!</h3>
                </div>
                <div class="modal-body">
                    <h4>📋 IMPORTANTE - Para tu traslado:</h4>
                    <ul class="instrucciones-list">
                        <li>🛂 Ten a la mano tu identificación oficial</li>
                        <li>✈️ Si es aeropuerto, proporciona número de vuelo</li>
                        <li>📱 Mantén tu teléfono disponible el día del viaje</li>
                        <li>🧳 Confirma cantidad de equipaje si es excesivo</li>
                        <li>⏰ Te contactaremos 1 día antes para confirmar</li>
                        <li>🚗 El conductor te esperará con un letrero personalizado</li>
                    </ul>
                    <p class="final-message">🚐 ¡Nos vemos pronto para llevarte cómodamente a tu destino!</p>
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