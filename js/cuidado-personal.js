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
            const comentarios = document.getElementById('comentarios').value.trim();

            // Validar campos requeridos
            if (!nombre || !telefono || !paquete || !fecha) {
                alert('Por favor completa todos los campos requeridos.');
                return;
            }

            // Construir el mensaje para WhatsApp
            let mensaje = `¡Hola! Me interesa agendar un servicio de cuidado personal en Casa Xuunan.\n\n`;
            mensaje += `👤 *Nombre:* ${nombre}\n`;
            mensaje += `📱 *Teléfono:* ${telefono}\n`;
            mensaje += `💅 *Servicio:* ${paquete}\n`;
            mensaje += `📅 *Fecha Deseada:* ${fecha}\n`;

            if (comentarios) {
                mensaje += `💬 *Comentarios:* ${comentarios}\n`;
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
                    <h4>✨ IMPORTANTE - Para tu servicio de Spa:</h4>
                    <ul class="instrucciones-list">
                        <li>💅 Si tienes esmalte de gel, avísanos con anticipación.</li>
                        <li>👣 Para pedicura, usa sandalias o calzado abierto.</li>
                        <li>🧴 Evita aplicar cremas o aceites antes de tu cita.</li>
                        <li>⏰ Llega 10 minutos antes para elegir tu esmalte con calma.</li>
                        <li>🧘‍♀️ Ven lista para relajarte y disfrutar.</li>
                    </ul>
                    <p class="final-message">💖 ¡Te esperamos en Casa Xuunan para consentirte!</p>
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