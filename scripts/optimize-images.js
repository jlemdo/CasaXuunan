#!/usr/bin/env node
/**
 * Image Optimizer PRO — Casa Xu'unan
 * Usa Sharp (no requiere ImageMagick global)
 *
 * Uso:
 *   cd "D:/Trabajo/WorkSpaces/Casa Xuunan/Ambientes/Desarrollo/Beta"
 *   npm init -y               (primera vez si no hay package.json)
 *   npm install sharp         (primera vez)
 *   node scripts/optimize-images.js
 *   node scripts/optimize-images.js --dry-run
 *
 * Que hace:
 *   - JPG/JPEG: recomprime a quality 82 si pesa > 300KB
 *   - PNG sin transparencia: convierte a JPG (80-90% menor)
 *   - PNG con transparencia: optimiza con palette reducida
 *   - Redimensiona > 2000px de ancho a 2000px
 *   - Strip metadata EXIF
 *   - Backup automatico en images_backup/
 */

const fs = require('fs');
const path = require('path');
let sharp;

try {
    sharp = require('sharp');
} catch (e) {
    console.error('✗ Sharp no instalado. Ejecuta:');
    console.error('  npm install sharp');
    process.exit(1);
}

const IMAGES_DIR = 'images';
const BACKUP_DIR = 'images_backup';
const MAX_WIDTH = 2000;
const JPG_QUALITY = 82;
const JPG_THRESHOLD_KB = 300;

const DRY_RUN = process.argv.includes('--dry-run');

// Colores consola
const c = {
    red: '\x1b[31m',
    green: '\x1b[32m',
    yellow: '\x1b[33m',
    blue: '\x1b[34m',
    reset: '\x1b[0m',
    bold: '\x1b[1m'
};

let stats = {
    total: 0,
    optimized: 0,
    originalKB: 0,
    finalKB: 0,
    converted: []
};

// Copia recursiva
function copyDirSync(src, dest) {
    if (!fs.existsSync(dest)) fs.mkdirSync(dest, { recursive: true });
    for (const item of fs.readdirSync(src)) {
        const s = path.join(src, item);
        const d = path.join(dest, item);
        if (fs.statSync(s).isDirectory()) copyDirSync(s, d);
        else fs.copyFileSync(s, d);
    }
}

// Lista todos los archivos recursivo
function walk(dir) {
    const files = [];
    for (const item of fs.readdirSync(dir)) {
        const full = path.join(dir, item);
        const stat = fs.statSync(full);
        if (stat.isDirectory()) files.push(...walk(full));
        else files.push(full);
    }
    return files;
}

function kb(bytes) {
    return Math.round(bytes / 1024);
}

async function optimizeJpeg(file, sizeKB) {
    // Leer el archivo a buffer primero (evita problemas de handle + EXIF dañado)
    const inputBuffer = fs.readFileSync(file);

    const meta = await sharp(inputBuffer, { failOn: 'none' }).metadata();
    const needsResize = meta.width > MAX_WIDTH;
    const needsReencode = sizeKB > JPG_THRESHOLD_KB;

    if (!needsResize && !needsReencode) return null;

    if (DRY_RUN) {
        return { action: 'would-optimize' };
    }

    let pipeline = sharp(inputBuffer, { failOn: 'none' }).rotate();

    if (needsResize) {
        pipeline = pipeline.resize({ width: MAX_WIDTH, withoutEnlargement: true });
    }

    const outBuffer = await pipeline
        .jpeg({ quality: JPG_QUALITY, mozjpeg: true, progressive: true })
        .toBuffer();

    const newSize = outBuffer.length;
    if (newSize < inputBuffer.length) {
        fs.writeFileSync(file, outBuffer);
        return { newSizeKB: kb(newSize) };
    }
    return null;
}

async function optimizePng(file, sizeKB) {
    if (sizeKB < 50) return null; // logos/iconos chicos

    const inputBuffer = fs.readFileSync(file);
    const meta = await sharp(inputBuffer, { failOn: 'none' }).metadata();
    const hasAlpha = meta.hasAlpha;
    const needsResize = meta.width > MAX_WIDTH;

    if (!hasAlpha) {
        // PNG sin transparencia → convertir a JPG
        if (DRY_RUN) {
            return { action: 'would-convert-jpg' };
        }

        const jpgFile = file.replace(/\.png$/i, '.jpg');
        let pipeline = sharp(inputBuffer, { failOn: 'none' }).rotate();
        if (needsResize) pipeline = pipeline.resize({ width: MAX_WIDTH, withoutEnlargement: true });

        const outBuffer = await pipeline.jpeg({ quality: JPG_QUALITY, mozjpeg: true, progressive: true }).toBuffer();

        if (outBuffer.length < inputBuffer.length) {
            fs.writeFileSync(jpgFile, outBuffer);
            fs.unlinkSync(file);
            stats.converted.push({ from: path.basename(file), to: path.basename(jpgFile) });
            return { newSizeKB: kb(outBuffer.length), converted: true, newFile: jpgFile };
        }
        return null;
    } else {
        // PNG con transparencia → palette reducida
        if (DRY_RUN) {
            return { action: 'would-optimize-png' };
        }

        let pipeline = sharp(inputBuffer, { failOn: 'none' });
        if (needsResize) pipeline = pipeline.resize({ width: MAX_WIDTH, withoutEnlargement: true });

        const outBuffer = await pipeline
            .png({ quality: 85, compressionLevel: 9, palette: true })
            .toBuffer();

        if (outBuffer.length < inputBuffer.length) {
            fs.writeFileSync(file, outBuffer);
            return { newSizeKB: kb(outBuffer.length) };
        }
        return null;
    }
}

(async () => {
    console.log('');
    console.log(`${c.blue}${c.bold}================================================${c.reset}`);
    console.log(`${c.blue}${c.bold}  Image Optimizer — Casa Xu'unan${c.reset}`);
    console.log(`${c.blue}${c.bold}================================================${c.reset}`);

    if (DRY_RUN) {
        console.log(`${c.yellow}⚠  DRY RUN — no se modificaran archivos${c.reset}`);
    }
    console.log('');

    // Backup
    if (!fs.existsSync(BACKUP_DIR)) {
        if (!DRY_RUN) {
            console.log(`${c.blue}→ Creando backup en ${BACKUP_DIR}/...${c.reset}`);
            copyDirSync(IMAGES_DIR, BACKUP_DIR);
            console.log(`${c.green}✓ Backup listo${c.reset}\n`);
        }
    } else {
        console.log(`${c.yellow}⚠ ${BACKUP_DIR}/ ya existe, se conserva${c.reset}\n`);
    }

    const files = walk(IMAGES_DIR);

    for (const file of files) {
        const ext = path.extname(file).toLowerCase();
        if (!['.jpg', '.jpeg', '.png'].includes(ext)) continue;

        stats.total++;
        const sizeKB = kb(fs.statSync(file).size);
        stats.originalKB += sizeKB;

        let result = null;
        try {
            if (ext === '.png') {
                result = await optimizePng(file, sizeKB);
            } else {
                result = await optimizeJpeg(file, sizeKB);
            }
        } catch (err) {
            console.log(`${c.red}✗${c.reset} ${path.relative(IMAGES_DIR, file)}: ${err.message}`);
            stats.finalKB += sizeKB;
            continue;
        }

        if (result && result.newSizeKB !== undefined) {
            const saved = sizeKB - result.newSizeKB;
            if (saved > 0) {
                stats.optimized++;
                const arrow = result.converted ? ` → ${c.yellow}convertido a JPG${c.reset}` : '';
                console.log(
                    `  ${c.green}✓${c.reset} ${path.relative(IMAGES_DIR, file).padEnd(50)} ` +
                    `${String(sizeKB).padStart(5)}KB → ${String(result.newSizeKB).padStart(5)}KB ` +
                    `${c.yellow}(-${saved}KB)${c.reset}${arrow}`
                );
            }
            stats.finalKB += result.newSizeKB;
        } else if (result && result.action) {
            console.log(`  ${c.yellow}→${c.reset} ${path.relative(IMAGES_DIR, file)}: ${result.action}`);
            stats.finalKB += sizeKB;
        } else {
            stats.finalKB += sizeKB;
        }
    }

    // Resumen
    const saved = stats.originalKB - stats.finalKB;
    const percent = stats.originalKB > 0 ? ((saved / stats.originalKB) * 100).toFixed(1) : 0;

    console.log('');
    console.log(`${c.blue}${c.bold}================================================${c.reset}`);
    console.log(`${c.blue}${c.bold}  RESUMEN${c.reset}`);
    console.log(`${c.blue}${c.bold}================================================${c.reset}`);
    console.log(`  Total archivos procesados:  ${stats.total}`);
    console.log(`  Archivos optimizados:       ${c.green}${stats.optimized}${c.reset}`);
    console.log(`  Tamano original:            ${stats.originalKB} KB (${(stats.originalKB / 1024).toFixed(1)} MB)`);
    console.log(`  Tamano final:               ${stats.finalKB} KB (${(stats.finalKB / 1024).toFixed(1)} MB)`);
    console.log(`  ${c.green}Ahorro:                     ${saved} KB (${(saved / 1024).toFixed(1)} MB) — ${percent}%${c.reset}`);

    if (stats.converted.length > 0) {
        console.log('');
        console.log(`${c.yellow}⚠ Archivos convertidos de PNG a JPG:${c.reset}`);
        stats.converted.forEach(c => console.log(`  • ${c.from} → ${c.to}`));
        console.log(`${c.yellow}  Verifica referencias en HTML/CSS/PHP si los usabas directamente.${c.reset}`);
    }

    console.log('');
    if (DRY_RUN) {
        console.log(`${c.yellow}Este fue un DRY RUN. Ejecuta sin --dry-run para aplicar.${c.reset}`);
    } else {
        console.log(`${c.green}✓ Optimizacion completa. Backup en ${BACKUP_DIR}/${c.reset}`);
    }
})();
