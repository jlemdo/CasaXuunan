/**
 * Flag Emoji Detection
 * Casa Xu'unan
 *
 * Detecta si el sistema soporta emojis de bandera (flag emojis).
 * Windows por defecto NO los soporta (muestra "US", "MX" en texto).
 * Si NO soporta, agrega clase 'no-flag-emoji' al body para que el CSS
 * oculte la bandera y deje solo el codigo de idioma.
 */
(function () {
    'use strict';

    function supportsFlagEmoji() {
        try {
            var canvas = document.createElement('canvas');
            if (!canvas.getContext) return false;
            var ctx = canvas.getContext('2d');
            if (!ctx) return false;

            canvas.width  = 20;
            canvas.height = 20;
            ctx.textBaseline = 'top';
            ctx.font = '16px Arial';

            // Dibuja bandera US: regional indicator U (1F1FA) + regional indicator S (1F1F8)
            ctx.fillText('\uD83C\uDDFA\uD83C\uDDF8', 0, 0);

            // Si el emoji se renderiza como bandera, los pixeles cerca del borde derecho
            // deberian tener color (bandera). Si NO soporta, se ven 2 letras "US".
            // Detectamos si hay color en el pixel (10, 10).
            var data = ctx.getImageData(12, 10, 1, 1).data;
            // Si hay alpha > 0 y color diferente al fondo = flag emoji soportado
            // Pero Windows si renderiza las letras "US" tambien tiene data.
            // Mejor test: ancho del texto. Bandera real ocupa menos que "US".
            var widthFlag = ctx.measureText('\uD83C\uDDFA\uD83C\uDDF8').width;
            var widthLetters = ctx.measureText('US').width;
            // Si el ancho de la "bandera" es muy parecido a las letras, no es bandera real
            // Emoji real de bandera: ~16-20px, "US" en Arial 16px: ~18-20px → pueden parecerse
            // Mejor: comparar pixel central de bandera vs solo letra U
            ctx.clearRect(0, 0, 20, 20);
            ctx.fillText('\uD83C\uDDFA\uD83C\uDDF8', 0, 0);
            var flagData = ctx.getImageData(0, 0, 20, 20).data;

            ctx.clearRect(0, 0, 20, 20);
            ctx.fillText('\uD83C\uDDFA', 0, 0); // Solo letra regional U
            var singleData = ctx.getImageData(0, 0, 20, 20).data;

            // Si los 2 caracteres juntos se ven igual que un solo caracter → es bandera (merged)
            // Si se ven DISTINTOS → son 2 letras separadas (no soporta bandera)
            var diffCount = 0;
            for (var i = 0; i < flagData.length; i += 4) {
                if (flagData[i] !== singleData[i] ||
                    flagData[i+1] !== singleData[i+1] ||
                    flagData[i+2] !== singleData[i+2]) {
                    diffCount++;
                }
            }
            // Si son casi iguales (pocos pixeles diferentes) → bandera renderizada como glyph unico
            // Si son muy diferentes (muchos pixeles) → 2 letras separadas
            return diffCount < 50;
        } catch (e) {
            return false;
        }
    }

    function apply() {
        if (!supportsFlagEmoji()) {
            document.body.classList.add('no-flag-emoji');
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', apply);
    } else {
        apply();
    }
})();
