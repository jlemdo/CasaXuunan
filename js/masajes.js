// JavaScript específico para la página de masajes
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('whatsapp-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtener los valores del formulario
            const nombre = document.getElementById('nombre').value.trim();
            const telefono = document.getElementById('telefono').value.trim();
            const paquete = document.getElementById('paquete').value;
            const tipo = document.getElementById('tipo').value;
            const comentarios = document.getElementById('comentarios').value.trim();
            
            // Validar campos requeridos
            if (!nombre || !telefono || !paquete || !tipo) {
                alert('Por favor completa todos los campos requeridos.');
                return;
            }
            
            // Construir el mensaje para WhatsApp
            let mensaje = `¡Hola! Me interesa agendar un masaje en Hotel Xuunan.\n\n`;
            mensaje += `👤 *Nombre:* ${nombre}\n`;
            mensaje += `📱 *Teléfono:* ${telefono}\n`;
            mensaje += `💆‍♀️ *Paquete:* ${paquete}\n`;
            mensaje += `✨ *Tipo de masaje:* ${tipo}\n`;
            
            if (comentarios) {
                mensaje += `💬 *Comentarios:* ${comentarios}\n`;
            }
            
            mensaje += `\n¿Podrían confirmarme disponibilidad? ¡Gracias!`;
            
            // Codificar el mensaje para URL
            const mensajeCodificado = encodeURIComponent(mensaje);
            
            // Número de WhatsApp (el mismo que ya usan)
            const numeroWhatsApp = '5219852580599';
            
            // Crear URL de WhatsApp
            const urlWhatsApp = `https://api.whatsapp.com/send?phone=${numeroWhatsApp}&text=${mensajeCodificado}`;
            
            // Abrir WhatsApp en nueva ventana
            window.open(urlWhatsApp, '_blank');
            
            // Opcional: Limpiar el formulario después de enviar
            form.reset();
            
            // Mostrar mensaje de confirmación con instrucciones
            setTimeout(() => {
                alert(`✅ ¡Tu solicitud ha sido enviada por WhatsApp!

📋 IMPORTANTE - Para tu sesión de masaje:

🚿 Toma una ducha antes de venir
👕 Usa ropa cómoda y fácil de quitar
🍽️ Evita comidas pesadas 2 horas antes
💧 Mantente hidratado/a
📱 Llega 10 minutos antes de tu cita
🧘‍♀️ Ven relajado/a y sin prisas

💆‍♀️ Nos vemos pronto en Hotel Xuunan para tu experiencia de Quiromasaje.

¡Esperamos tu confirmación por WhatsApp!`);
            }, 1000);
        });
    }
});