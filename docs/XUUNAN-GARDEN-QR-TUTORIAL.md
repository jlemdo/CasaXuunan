# Tutorial: Sistema de Códigos QR para Xuunan Garden

## Resumen del Sistema

Cada planta tiene:
- **slug**: identificador único (ej: `chaya`)
- **unlock_code**: código secreto (ej: `XG-CH01-MAYA`)

El QR contiene una URL que desbloquea la planta:
```
https://casaxuunan.com/plant.php?id=chaya&unlock=XG-CH01-MAYA
```

---

## Paso 1: Plantas Actuales

Tienes 10 plantas en `data/plants.json`:

| # | Planta | URL del QR |
|---|--------|-----------|
| 1 | Chaya | `plant.php?id=chaya&unlock=XG-CH01-MAYA` |
| 2 | Bugambilia | `plant.php?id=bugambilia&unlock=XG-BU02-MAYA` |
| 3 | Achiote | `plant.php?id=achiote&unlock=XG-AC03-MAYA` |
| 4 | Flor de Mayo | `plant.php?id=flor-de-mayo&unlock=XG-FM04-MAYA` |
| 5 | Hierba Santa | `plant.php?id=hierba-santa&unlock=XG-HS05-MAYA` |
| 6 | Orquídea Araña | `plant.php?id=orquidea-arana&unlock=XG-OA06-MAYA` |
| 7 | Papaya | `plant.php?id=papaya&unlock=XG-PA07-MAYA` |
| 8 | Sábila | `plant.php?id=sabila&unlock=XG-SA08-MAYA` |
| 9 | Ave del Paraíso | `plant.php?id=ave-del-paraiso&unlock=XG-AP09-MAYA` |
| 10 | Chile Habanero | `plant.php?id=chile-habanero&unlock=XG-CH10-MAYA` |

---

## Paso 2: Generar los QR

1. Ve a **https://www.qrcode-monkey.com/** (gratis, sin marca de agua)
2. Pega la URL completa: `https://casaxuunan.com/plant.php?id=chaya&unlock=XG-CH01-MAYA`
3. Personaliza el color si quieres (verde #7baf89)
4. Descarga en PNG alta resolución
5. Repite para cada planta

---

## Paso 3: Agregar Nueva Planta

Edita `data/plants.json` y agrega al array `plants`:

```json
{
  "id": "aloe-vera",
  "slug": "aloe-vera",
  "unlock_code": "XG-AV11-MAYA",
  "order": 11,
  "featured": false,
  "names": {
    "common_es": "Aloe Vera",
    "common_en": "Aloe Vera",
    "scientific": "Aloe barbadensis",
    "maya": "Hunpets'kin",
    "family": "Asphodelaceae"
  },
  "category": "medicinal",
  "images": {
    "main": "images/garden/aloe-vera.jpg",
    "thumbnail": "images/garden/aloe-vera.jpg"
  },
  "description": {
    "es": "Descripción en español...",
    "en": "Description in English..."
  },
  "medicinal_uses": {
    "es": ["Uso 1", "Uso 2", "Uso 3"],
    "en": ["Use 1", "Use 2", "Use 3"]
  },
  "curious_facts": {
    "es": ["Dato curioso 1", "Dato curioso 2"],
    "en": ["Curious fact 1", "Curious fact 2"]
  },
  "region_info": {
    "es": "Información de la región...",
    "en": "Region information..."
  },
  "location_hint": {
    "es": "Cerca de la piscina",
    "en": "Near the pool"
  }
}
```

---

## Paso 4: Subir Imagen

1. Sube la foto de la planta a `images/garden/`
2. Nombre recomendado: mismo que el slug (ej: `aloe-vera.jpg`)
3. Tamaño recomendado: 800x600px o similar

---

## Paso 5: Imprimir QR

Para cada planta:
1. Imprime el QR en material resistente al agua
2. Agrega el número de planta y nombre
3. Colócalo junto a la planta física en el jardín

---

## Formato del Código de Desbloqueo

`XG-XX##-MAYA`
- **XG** = Xuunan Garden
- **XX** = Iniciales (2 letras)
- **##** = Número (01, 02...)
- **MAYA** = Sufijo temático

---

## Categorías Disponibles

- `medicinal` - Plantas medicinales
- `ornamental` - Plantas ornamentales
- `edible` - Plantas comestibles

---

## Archivos del Sistema

- `garden.php` - Página principal del jardín
- `plant.php` - Página de detalle de planta
- `data/plants.json` - Base de datos de plantas
- `css/garden.css` - Estilos del jardín
- `js/garden.js` - JavaScript del jardín
- `images/garden/` - Imágenes de plantas
