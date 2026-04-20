#!/bin/bash
# =============================================
# Image Optimizer PRO — Casa Xu'unan
# =============================================
# Optimiza todas las imagenes del sitio:
#   - JPG/JPEG: recomprime si pesa > 300KB (calidad 82)
#   - PNG con transparencia: pngquant (reduce 40-60%)
#   - PNG sin transparencia: convierte a JPG (reduce 80-90%)
#   - Redimensiona si exceden 2000px de ancho
#   - Backup automatico en images_backup/
#
# REQUISITOS:
#   - ImageMagick (magick o convert)
#   - pngquant (opcional, para PNG)
#   - Para Windows Git Bash: ImageMagick from https://imagemagick.org/
#
# USO:
#   bash scripts/optimize-images.sh
#   bash scripts/optimize-images.sh --dry-run    (simulacion sin cambios)
# =============================================

set -e

# Config
IMAGES_DIR="images"
BACKUP_DIR="images_backup"
MAX_WIDTH=2000
JPG_QUALITY=82
JPG_THRESHOLD_KB=300
PNG_QUANT_QUALITY="70-85"

# Flags
DRY_RUN=false
if [ "$1" = "--dry-run" ]; then
    DRY_RUN=true
    echo "⚠  DRY RUN MODE — no se modificaran archivos"
fi

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Verificar ImageMagick
if command -v magick &> /dev/null; then
    MAGICK_CMD="magick"
elif command -v convert &> /dev/null; then
    MAGICK_CMD="convert"
else
    echo -e "${RED}✗ ImageMagick no encontrado.${NC}"
    echo "  Instalar:"
    echo "    Windows: https://imagemagick.org/script/download.php#windows"
    echo "    Mac:     brew install imagemagick"
    echo "    Linux:   sudo apt install imagemagick"
    exit 1
fi

# Verificar pngquant (opcional)
HAS_PNGQUANT=false
if command -v pngquant &> /dev/null; then
    HAS_PNGQUANT=true
fi

# Contadores
TOTAL_FILES=0
OPTIMIZED_FILES=0
ORIGINAL_SIZE=0
FINAL_SIZE=0

# Helper: tamano en KB
file_size_kb() {
    if [ -f "$1" ]; then
        du -k "$1" | cut -f1
    else
        echo 0
    fi
}

# Helper: obtiene dimensiones
get_width() {
    $MAGICK_CMD identify -format "%w" "$1" 2>/dev/null || echo 0
}

# Helper: detecta si PNG tiene transparencia
png_has_alpha() {
    local alpha=$($MAGICK_CMD identify -format "%A" "$1" 2>/dev/null)
    [ "$alpha" = "Blend" ] || [ "$alpha" = "True" ]
}

# Setup backup
if [ ! -d "$BACKUP_DIR" ]; then
    echo -e "${BLUE}→ Creando backup en $BACKUP_DIR/...${NC}"
    if [ "$DRY_RUN" = false ]; then
        cp -r "$IMAGES_DIR" "$BACKUP_DIR"
    fi
    echo -e "${GREEN}✓ Backup listo${NC}"
else
    echo -e "${YELLOW}⚠ $BACKUP_DIR ya existe, se conserva el backup previo${NC}"
fi

echo ""
echo -e "${BLUE}================================================${NC}"
echo -e "${BLUE}  Optimizando imagenes — Casa Xu'unan${NC}"
echo -e "${BLUE}================================================${NC}"
echo ""

# Procesar JPG/JPEG
echo -e "${BLUE}▸ Procesando JPG/JPEG...${NC}"
while IFS= read -r -d '' file; do
    TOTAL_FILES=$((TOTAL_FILES + 1))
    size_kb=$(file_size_kb "$file")
    ORIGINAL_SIZE=$((ORIGINAL_SIZE + size_kb))

    width=$(get_width "$file")
    needs_resize=false
    if [ "$width" -gt "$MAX_WIDTH" ]; then
        needs_resize=true
    fi

    # Recomprimir si pesa > threshold o si es muy ancho
    if [ "$size_kb" -gt "$JPG_THRESHOLD_KB" ] || [ "$needs_resize" = true ]; then
        if [ "$DRY_RUN" = false ]; then
            if [ "$needs_resize" = true ]; then
                $MAGICK_CMD "$file" -resize "${MAX_WIDTH}x>" -quality "$JPG_QUALITY" -strip "$file.tmp"
            else
                $MAGICK_CMD "$file" -quality "$JPG_QUALITY" -strip "$file.tmp"
            fi
            mv "$file.tmp" "$file"
        fi
        new_size=$(file_size_kb "$file")
        saved=$((size_kb - new_size))
        if [ "$saved" -gt 0 ]; then
            OPTIMIZED_FILES=$((OPTIMIZED_FILES + 1))
            echo -e "  ${GREEN}✓${NC} $(basename "$file"): ${size_kb}KB → ${new_size}KB ${YELLOW}(-${saved}KB)${NC}"
        fi
        FINAL_SIZE=$((FINAL_SIZE + new_size))
    else
        FINAL_SIZE=$((FINAL_SIZE + size_kb))
    fi
done < <(find "$IMAGES_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" \) -print0)

# Procesar PNG
echo ""
echo -e "${BLUE}▸ Procesando PNG...${NC}"
while IFS= read -r -d '' file; do
    TOTAL_FILES=$((TOTAL_FILES + 1))
    size_kb=$(file_size_kb "$file")
    ORIGINAL_SIZE=$((ORIGINAL_SIZE + size_kb))

    # Skip logos chicos e iconos
    if [ "$size_kb" -lt 50 ]; then
        FINAL_SIZE=$((FINAL_SIZE + size_kb))
        continue
    fi

    has_alpha=false
    if png_has_alpha "$file"; then
        has_alpha=true
    fi

    if [ "$has_alpha" = false ]; then
        # PNG sin transparencia → convertir a JPG
        jpg_file="${file%.png}.jpg"
        if [ "$DRY_RUN" = false ]; then
            $MAGICK_CMD "$file" -quality "$JPG_QUALITY" -strip "$jpg_file"
            # Solo borrar PNG si el JPG es mas chico
            new_size=$(file_size_kb "$jpg_file")
            if [ "$new_size" -lt "$size_kb" ]; then
                rm "$file"
                OPTIMIZED_FILES=$((OPTIMIZED_FILES + 1))
                saved=$((size_kb - new_size))
                echo -e "  ${GREEN}✓${NC} $(basename "$file") → $(basename "$jpg_file"): ${size_kb}KB → ${new_size}KB ${YELLOW}(-${saved}KB)${NC}"
                echo -e "    ${YELLOW}⚠ PNG convertido a JPG — verifica referencias en HTML/CSS${NC}"
                FINAL_SIZE=$((FINAL_SIZE + new_size))
            else
                rm "$jpg_file"
                FINAL_SIZE=$((FINAL_SIZE + size_kb))
            fi
        else
            echo -e "  ${YELLOW}→${NC} $(basename "$file"): se convertiria a JPG (sin transparencia)"
            FINAL_SIZE=$((FINAL_SIZE + size_kb))
        fi
    else
        # PNG con transparencia → pngquant si disponible
        if [ "$HAS_PNGQUANT" = true ] && [ "$DRY_RUN" = false ]; then
            pngquant --quality="$PNG_QUANT_QUALITY" --force --output "$file" "$file" 2>/dev/null || true
            new_size=$(file_size_kb "$file")
            if [ "$new_size" -lt "$size_kb" ]; then
                saved=$((size_kb - new_size))
                OPTIMIZED_FILES=$((OPTIMIZED_FILES + 1))
                echo -e "  ${GREEN}✓${NC} $(basename "$file"): ${size_kb}KB → ${new_size}KB ${YELLOW}(-${saved}KB) con transparencia${NC}"
                FINAL_SIZE=$((FINAL_SIZE + new_size))
            else
                FINAL_SIZE=$((FINAL_SIZE + size_kb))
            fi
        else
            echo -e "  ${YELLOW}⊘${NC} $(basename "$file"): PNG con transparencia, instalar pngquant para optimizar"
            FINAL_SIZE=$((FINAL_SIZE + size_kb))
        fi
    fi
done < <(find "$IMAGES_DIR" -type f -iname "*.png" -print0)

# Resumen
echo ""
echo -e "${BLUE}================================================${NC}"
echo -e "${BLUE}  RESUMEN${NC}"
echo -e "${BLUE}================================================${NC}"
echo -e "  Total archivos procesados:  $TOTAL_FILES"
echo -e "  Archivos optimizados:       ${GREEN}$OPTIMIZED_FILES${NC}"
echo -e "  Tamano original:            ${ORIGINAL_SIZE} KB ($(echo "scale=1; $ORIGINAL_SIZE/1024" | bc) MB)"
echo -e "  Tamano final:               ${FINAL_SIZE} KB ($(echo "scale=1; $FINAL_SIZE/1024" | bc) MB)"

if [ "$ORIGINAL_SIZE" -gt 0 ]; then
    saved=$((ORIGINAL_SIZE - FINAL_SIZE))
    percent=$(echo "scale=1; ($saved * 100) / $ORIGINAL_SIZE" | bc)
    echo -e "  Ahorro:                     ${GREEN}${saved} KB ($(echo "scale=1; $saved/1024" | bc) MB) — ${percent}%${NC}"
fi

echo ""
if [ "$DRY_RUN" = true ]; then
    echo -e "${YELLOW}Este fue un DRY RUN. Ejecuta sin --dry-run para aplicar cambios.${NC}"
else
    echo -e "${GREEN}✓ Optimizacion completa. Backup disponible en $BACKUP_DIR/${NC}"
    echo -e "${YELLOW}⚠ Si algun PNG se convirtio a JPG, verifica referencias en HTML/CSS/PHP.${NC}"
fi
