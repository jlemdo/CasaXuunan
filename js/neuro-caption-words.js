/**
 * NeuroCaptions — Evocative single-word captions for Casa Xu'unan
 * Used in room lightbox and gallery to replace generic "No Caption"
 */
window.NeuroCaptions = (function () {
    var words = {
        es: [
            // Hogar / Confort
            'Refugio', 'Serenidad', 'Calidez', 'Descanso', 'Paz', 'Cobijo', 'Nido', 'Calma',
            'Reposo', 'Armonía', 'Sosiego', 'Confort', 'Abrigo', 'Dulzura', 'Ternura', 'Bienestar',
            'Quietud', 'Plenitud', 'Acogida', 'Sueño', 'Hogar', 'Refugiar', 'Rincón', 'Amparo',
            'Pausa',
            // Naturaleza / Yucatán
            'Cenote', 'Amanecer', 'Brisa', 'Jade', 'Selva', 'Trópico', 'Laguna', 'Verde',
            'Raíz', 'Flor', 'Luna', 'Tierra', 'Palma', 'Coral', 'Arena', 'Oasis',
            'Manglar', 'Rocío', 'Follaje', 'Cantera', 'Atardecer', 'Oleaje', 'Cielo', 'Caracol',
            'Mariposa',
            // Emoción / Pertenencia
            'Abrazo', 'Alegría', 'Nostalgia', 'Recuerdo', 'Familia', 'Raíces', 'Conexión',
            'Encuentro', 'Vínculo', 'Gratitud', 'Cariño', 'Complicidad', 'Presencia', 'Instante',
            'Origen', 'Esencia', 'Latido', 'Huella', 'Pertenencia', 'Unión', 'Tradición',
            'Herencia', 'Comunidad', 'Identidad', 'Celebración',
            // Sensorial
            'Aroma', 'Silencio', 'Luz', 'Fragancia', 'Susurro', 'Textura', 'Brillo', 'Eco',
            'Color', 'Sombra', 'Murmullo', 'Reflejo', 'Tacto', 'Vibración', 'Matiz', 'Tonalidad',
            'Resplandor', 'Melodía', 'Rumor', 'Fulgor', 'Destello', 'Penumbra', 'Transparencia',
            'Nitidez', 'Contraste',
            // Escape / Aspiración
            'Escape', 'Destino', 'Descubrir', 'Aventura', 'Libertad', 'Horizonte', 'Camino',
            'Travesía', 'Explorar', 'Asombro', 'Misterio', 'Despertar', 'Vuelo', 'Renacer',
            'Inmensidad', 'Infinito', 'Sendero', 'Frontera', 'Viaje', 'Rumbo', 'Impacto',
            'Transformar', 'Revelación', 'Posibilidad', 'Impulso',
            // Gastronomía / Mañana
            'Sabor', 'Miel', 'Café', 'Fresco', 'Pan', 'Cocina', 'Dulce', 'Cacao',
            'Vainilla', 'Canela', 'Maíz', 'Frutal', 'Cosecha', 'Sazón', 'Elixir',
            'Néctar', 'Huerto', 'Receta', 'Fusión', 'Delicia', 'Trigo', 'Especias',
            'Infusión', 'Merienda', 'Festín'
        ],
        en: [
            // Home / Comfort
            'Refuge', 'Serenity', 'Warmth', 'Rest', 'Peace', 'Haven', 'Nest', 'Calm',
            'Repose', 'Harmony', 'Tranquil', 'Comfort', 'Shelter', 'Gentle', 'Tenderness', 'Wellness',
            'Stillness', 'Bliss', 'Welcome', 'Dream', 'Home', 'Retreat', 'Nook', 'Solace',
            'Pause',
            // Nature / Yucatan
            'Cenote', 'Sunrise', 'Breeze', 'Jade', 'Jungle', 'Tropic', 'Lagoon', 'Verdant',
            'Root', 'Bloom', 'Moon', 'Earth', 'Palm', 'Coral', 'Sand', 'Oasis',
            'Mangrove', 'Dew', 'Foliage', 'Limestone', 'Sunset', 'Tide', 'Sky', 'Shell',
            'Butterfly',
            // Emotion / Belonging
            'Embrace', 'Joy', 'Nostalgia', 'Memory', 'Family', 'Roots', 'Bond',
            'Encounter', 'Kinship', 'Gratitude', 'Affection', 'Complicity', 'Presence', 'Moment',
            'Origin', 'Essence', 'Heartbeat', 'Imprint', 'Belonging', 'Unity', 'Tradition',
            'Heritage', 'Community', 'Identity', 'Celebration',
            // Sensory
            'Aroma', 'Silence', 'Light', 'Fragrance', 'Whisper', 'Texture', 'Glow', 'Echo',
            'Color', 'Shadow', 'Murmur', 'Reflection', 'Touch', 'Vibrance', 'Hue', 'Tones',
            'Radiance', 'Melody', 'Rustle', 'Shimmer', 'Spark', 'Twilight', 'Clarity',
            'Crisp', 'Contrast',
            // Escape / Aspiration
            'Escape', 'Destiny', 'Discover', 'Adventure', 'Freedom', 'Horizon', 'Path',
            'Journey', 'Explore', 'Wonder', 'Mystery', 'Awaken', 'Flight', 'Renewal',
            'Vastness', 'Infinite', 'Trail', 'Frontier', 'Voyage', 'Course', 'Impact',
            'Transform', 'Revelation', 'Possibility', 'Impulse',
            // Gastronomy / Morning
            'Flavor', 'Honey', 'Coffee', 'Fresh', 'Bread', 'Kitchen', 'Sweet', 'Cacao',
            'Vanilla', 'Cinnamon', 'Maize', 'Fruity', 'Harvest', 'Savor', 'Elixir',
            'Nectar', 'Garden', 'Recipe', 'Fusion', 'Delight', 'Grain', 'Spice',
            'Infusion', 'Brunch', 'Feast'
        ]
    };

    function getLang() {
        if (window.PHP_LANG) return window.PHP_LANG === 'en' ? 'en' : 'es';
        var htmlLang = document.documentElement.lang || '';
        if (htmlLang.indexOf('en') === 0) return 'en';
        var params = new URLSearchParams(window.location.search);
        var urlLang = params.get('lang');
        if (urlLang === 'en') return 'en';
        return 'es';
    }

    function getRandomWord(lang) {
        var l = lang || getLang();
        var pool = words[l] || words.es;
        return pool[Math.floor(Math.random() * pool.length)];
    }

    return {
        words: words,
        getLang: getLang,
        getRandomWord: getRandomWord
    };
})();
