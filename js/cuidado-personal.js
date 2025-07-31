// JavaScript específico para la página de Cuidado Personal
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('whatsapp-form');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Obtener los valores del formulario
            const nombre = document.getElementById('nombre').value.trim();
            const telefono = document.getElementById('telefono').value.trim();
            const paquete = document.getElementById('paquete').value;
            const fecha = document.getElementById('fecha').value;
            const esmalte = document.getElementById('esmalte').value;
            const alergias = document.getElementById('alergias').value;
            const comentarios = document.getElementById('comentarios').value.trim();

            // Validar campos requeridos
            if (!nombre || !telefono || !paquete || !fecha || !esmalte || !alergias) {
                alert('Por favor completa todos los campos requeridos.');
                return;
            }

            // Construir el mensaje para WhatsApp
            let mensaje = `¡Hola! Me interesa agendar un servicio de cuidado personal en Casa Xuunan.\n\n`;
            mensaje += `👤 *Nombre:* ${nombre}\n`;
            mensaje += `📱 *Teléfono:* ${telefono}\n`;
            mensaje += `💅 *Servicio:* ${paquete}\n`;
            mensaje += `📅 *Fecha Deseada:* ${fecha}\n`;
            mensaje += `✨ *Tipo de esmalte:* ${esmalte}\n`;
            mensaje += `⚠️ *Alergias:* ${alergias}\n`;

            if (comentarios) {
                mensaje += `💬 *Información adicional:* ${comentarios}\n`;
            }

            mensaje += `\n¿Podrían confirmarme disponibilidad? ¡Gracias!`;

            // Codificar el mensaje para URL
            const mensajeCodificado = encodeURIComponent(mensaje);

            // Número de WhatsApp
            const numeroWhatsApp = '5219852580599';

            // Crear URL de WhatsApp
            const urlWhatsApp = `https://api.whatsapp.com/send?phone=${numeroWhatsApp}&text=${mensajeCodificado}`;

            // Mostrar modal con instrucciones antes de abrir WhatsApp
            mostrarModalInstrucciones(() => {
                window.open(urlWhatsApp, '_blank');
                form.reset();
            });
        });
    }
});

// Función para mostrar modal con instrucciones estilizado
function mostrarModalInstrucciones(callback) {
    const modal = document.createElement('div');
    modal.id = 'instrucciones-modal';
    modal.innerHTML = `
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>✅ ¡Tu cita será confirmada por WhatsApp!</h3>
                </div>
                <div class="modal-body">
                    <h4>✨ IMPORTANTE - Para tu cita de belleza:</h4>
                    <div class="instrucciones-sections">
                        <h5>🤏 ANTES de venir:</h5>
                        <ul class="instrucciones-list">
                            <li>💅 Si tienes esmalte de gel actual, avísanos para programar tiempo extra</li>
                            <li>👣 Para pedicura, usa sandalias o calzado fácil de quitar</li>
                            <li>🧴 Evita cremas o aceites en manos/pies 2 horas antes</li>
                            <li>⏰ Llega 10 minutos antes para relajarte y elegir colores</li>
                        </ul>
                        <h5>💅 DESPUÉS del servicio:</h5>
                        <ul class="instrucciones-list">
                            <li>⏱️ Espera 30 min antes de tocar superficies rugosas</li>
                            <li>🚫 Evita agua caliente las primeras 2 horas</li>
                            <li>🧤 Usa guantes para tareas domésticas</li>
                            <li>✨ Aplica aceite de cutícula cada 3 días</li>
                        </ul>
                    </div>
                    <p class="final-message">💖 ¡Te esperamos en Casa Xuunan para consentirte como te mereces!</p>
                </div>
                <div class="modal-footer">
                    <button id="continuar-whatsapp" class="btn-modal">
                        <i class="fa fa-whatsapp"></i> Continuar a WhatsApp
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

    document.getElementById('continuar-whatsapp').addEventListener('click', function() {
        modal.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(modal);
            callback();
        }, 300);
    });

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