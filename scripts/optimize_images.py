#!/usr/bin/env python3
"""
Casa Xu'unan - Image Optimization Script
==========================================
Optimiza imagenes para web:
  - Redimensiona a max 1920px ancho (configurable)
  - Comprime JPG con calidad inteligente (75-85)
  - Genera version .webp opcional (50-70% mas liviano)
  - Mantiene originales en _originals/
  - Genera reporte antes/despues

Uso:
    python optimize_images.py <carpeta>

Ejemplos:
    python optimize_images.py images/_briefs/home/hero
    python optimize_images.py images/_briefs/home/locations --max-width 1200
    python optimize_images.py images/_briefs/home/hero --webp

Requisitos:
    pip install Pillow
"""

import os
import sys
import shutil
import argparse
from pathlib import Path
from PIL import Image, ImageOps

# ===== CONFIGURACION =====
DEFAULT_MAX_WIDTH = 1920      # ancho maximo en px
DEFAULT_QUALITY = 82          # calidad JPG (sweet spot calidad/peso)
WEBP_QUALITY = 80             # calidad WebP
PROGRESSIVE = True            # JPG progresivo (carga gradual mejor UX)
STRIP_EXIF = True             # quitar metadata (GPS, camara, etc) - reduce peso + privacidad
ORIGINALS_DIR = "_originals"  # subcarpeta para guardar originales
SUPPORTED = {".jpg", ".jpeg", ".png", ".avif", ".webp"}  # formatos a procesar

# ANSI colors
GREEN = "\033[92m"
YELLOW = "\033[93m"
RED = "\033[91m"
BLUE = "\033[94m"
BOLD = "\033[1m"
RESET = "\033[0m"


def human_size(bytes_size: int) -> str:
    """Convierte bytes a formato legible (KB, MB)."""
    for unit in ["B", "KB", "MB", "GB"]:
        if bytes_size < 1024:
            return f"{bytes_size:.1f} {unit}"
        bytes_size /= 1024
    return f"{bytes_size:.1f} TB"


def reduction_pct(original: int, new: int) -> str:
    """Calcula porcentaje de reduccion."""
    if original == 0:
        return "0%"
    pct = ((original - new) / original) * 100
    return f"{pct:.0f}%"


def crop_to_aspect(img: Image.Image, target_ratio: float) -> Image.Image:
    """
    Recorta una imagen al ratio deseado (ej 16:9 = 1.777).
    Crop centrado: si vertical, recorta arriba/abajo; si horizontal, recorta lados.
    """
    width, height = img.size
    current_ratio = width / height

    if abs(current_ratio - target_ratio) < 0.01:
        # Ya tiene el ratio correcto
        return img

    if current_ratio > target_ratio:
        # Imagen mas ancha de lo necesario: recortar lados
        new_width = int(height * target_ratio)
        left = (width - new_width) // 2
        return img.crop((left, 0, left + new_width, height))
    else:
        # Imagen mas alta de lo necesario: recortar arriba/abajo
        new_height = int(width / target_ratio)
        top = (height - new_height) // 2
        return img.crop((0, top, width, top + new_height))


def optimize_image(
    img_path: Path,
    output_path: Path,
    max_width: int,
    quality: int,
    create_webp: bool = False,
    crop_ratio: float = None,
) -> dict:
    """
    Optimiza una imagen individual.
    Retorna dict con stats: original_size, new_size, dimensions, webp_size.

    Args:
        crop_ratio: Si se especifica (ej 16/9 = 1.777), recorta al centro
                    para forzar ese aspect ratio.
    """
    original_size = img_path.stat().st_size

    # Abrir imagen
    img = Image.open(img_path)

    # Auto-rotar segun EXIF (fotos de celular vienen rotadas)
    img = ImageOps.exif_transpose(img)

    # Convertir a RGB si es PNG con transparencia
    if img.mode in ("RGBA", "LA", "P"):
        # Fondo blanco para PNGs transparentes (mejor para JPG)
        rgb_img = Image.new("RGB", img.size, (255, 255, 255))
        if img.mode == "P":
            img = img.convert("RGBA")
        rgb_img.paste(img, mask=img.split()[-1] if img.mode == "RGBA" else None)
        img = rgb_img

    original_dimensions = img.size

    # Crop a aspect ratio si se solicita (antes de redimensionar)
    if crop_ratio:
        img = crop_to_aspect(img, crop_ratio)

    # Redimensionar si excede max_width
    if img.size[0] > max_width:
        ratio = max_width / img.size[0]
        new_height = int(img.size[1] * ratio)
        img = img.resize((max_width, new_height), Image.Resampling.LANCZOS)

    new_dimensions = img.size

    # Guardar JPG optimizado
    save_kwargs = {
        "format": "JPEG",
        "quality": quality,
        "optimize": True,
        "progressive": PROGRESSIVE,
    }

    if STRIP_EXIF:
        # No pasar exif al guardar = quita metadata
        pass
    else:
        if "exif" in img.info:
            save_kwargs["exif"] = img.info["exif"]

    img.save(output_path, **save_kwargs)
    new_size = output_path.stat().st_size

    # Generar WebP si solicitado
    webp_size = None
    if create_webp:
        webp_path = output_path.with_suffix(".webp")
        img.save(webp_path, format="WEBP", quality=WEBP_QUALITY, method=6)
        webp_size = webp_path.stat().st_size

    return {
        "original_size": original_size,
        "new_size": new_size,
        "webp_size": webp_size,
        "original_dimensions": original_dimensions,
        "new_dimensions": new_dimensions,
    }


def process_folder(folder: Path, max_width: int, quality: int, create_webp: bool, crop_ratio: float = None):
    """Procesa todas las imagenes de una carpeta."""

    if not folder.is_dir():
        print(f"{RED}ERROR: La carpeta '{folder}' no existe.{RESET}")
        sys.exit(1)

    # Crear carpeta _originals
    originals_dir = folder / ORIGINALS_DIR
    originals_dir.mkdir(exist_ok=True)

    # Recolectar imagenes (ignorar las que ya estan en _originals)
    images = [
        f for f in folder.iterdir()
        if f.is_file()
        and f.suffix.lower() in SUPPORTED
        and ORIGINALS_DIR not in f.parts
    ]

    if not images:
        print(f"{YELLOW}No se encontraron imagenes en '{folder}'.{RESET}")
        print(f"Formatos soportados: {', '.join(SUPPORTED)}")
        return

    print(f"\n{BOLD}{BLUE}=== Casa Xu'unan - Image Optimizer ==={RESET}")
    print(f"Carpeta:       {folder}")
    print(f"Imagenes:      {len(images)}")
    print(f"Max ancho:     {max_width}px")
    print(f"Calidad JPG:   {quality}")
    print(f"WebP:          {'Si' if create_webp else 'No'}")
    if crop_ratio:
        print(f"Crop ratio:    {crop_ratio:.3f} ({'16:9 horizontal' if abs(crop_ratio - 16/9) < 0.01 else 'custom'})")
    print(f"Originales en: {originals_dir}\n")

    total_original = 0
    total_new = 0
    total_webp = 0
    skipped = []

    for idx, img_path in enumerate(images, 1):
        rel_name = img_path.name

        # Mover original a _originals si no esta ya respaldado
        backup_path = originals_dir / rel_name
        if not backup_path.exists():
            shutil.copy2(img_path, backup_path)

        try:
            print(f"{BOLD}[{idx}/{len(images)}]{RESET} {rel_name}")

            stats = optimize_image(
                img_path=backup_path,  # leer del original respaldado
                output_path=img_path,   # sobreescribir en su lugar
                max_width=max_width,
                quality=quality,
                create_webp=create_webp,
                crop_ratio=crop_ratio,
            )

            total_original += stats["original_size"]
            total_new += stats["new_size"]
            if stats["webp_size"]:
                total_webp += stats["webp_size"]

            # Mostrar resultado
            orig_dim = stats["original_dimensions"]
            new_dim = stats["new_dimensions"]
            dim_changed = orig_dim != new_dim

            print(
                f"  {GREEN}OK{RESET}  "
                f"{human_size(stats['original_size'])} -> "
                f"{human_size(stats['new_size'])} "
                f"({GREEN}-{reduction_pct(stats['original_size'], stats['new_size'])}{RESET})"
            )

            if dim_changed:
                print(
                    f"      Dimensiones: {orig_dim[0]}x{orig_dim[1]} -> "
                    f"{new_dim[0]}x{new_dim[1]}"
                )

            if stats["webp_size"]:
                webp_pct = reduction_pct(stats["original_size"], stats["webp_size"])
                print(
                    f"      WebP: {human_size(stats['webp_size'])} "
                    f"({GREEN}-{webp_pct}{RESET})"
                )

        except Exception as e:
            print(f"  {RED}ERROR: {e}{RESET}")
            skipped.append(rel_name)

        print()

    # Resumen final
    print(f"{BOLD}{BLUE}=== RESUMEN ==={RESET}")
    print(f"Procesadas:    {len(images) - len(skipped)}/{len(images)}")

    if total_original > 0:
        print(
            f"Peso total:    {human_size(total_original)} -> "
            f"{human_size(total_new)} "
            f"({GREEN}-{reduction_pct(total_original, total_new)}{RESET})"
        )

        if create_webp and total_webp > 0:
            print(
                f"WebP total:    {human_size(total_webp)} "
                f"({GREEN}-{reduction_pct(total_original, total_webp)}{RESET})"
            )

        # Estimar tiempo de carga ahorrado en 3G
        # 3G promedio: 1.6 Mbps = 200 KB/s
        saved_bytes = total_original - total_new
        seconds_saved = saved_bytes / (200 * 1024)
        print(f"Tiempo carga 3G ahorrado: ~{seconds_saved:.1f} segundos")

    if skipped:
        print(f"\n{YELLOW}Saltadas ({len(skipped)}):{RESET}")
        for name in skipped:
            print(f"  - {name}")

    print(
        f"\n{GREEN}Originales respaldados en:{RESET} {originals_dir}\n"
        f"{YELLOW}TIP:{RESET} Si necesitas restaurar, copia de _originals/ a la carpeta.\n"
    )


def main():
    parser = argparse.ArgumentParser(
        description="Optimiza imagenes para web (Casa Xu'unan)",
        formatter_class=argparse.RawDescriptionHelpFormatter,
    )
    parser.add_argument("folder", help="Carpeta con imagenes a optimizar")
    parser.add_argument(
        "--max-width",
        type=int,
        default=DEFAULT_MAX_WIDTH,
        help=f"Ancho maximo en px (default: {DEFAULT_MAX_WIDTH})",
    )
    parser.add_argument(
        "--quality",
        type=int,
        default=DEFAULT_QUALITY,
        choices=range(50, 96),
        metavar="[50-95]",
        help=f"Calidad JPG (default: {DEFAULT_QUALITY})",
    )
    parser.add_argument(
        "--webp",
        action="store_true",
        help="Generar tambien version .webp (mas liviano)",
    )
    parser.add_argument(
        "--crop",
        type=str,
        default=None,
        help="Recortar al aspect ratio (ej: '16:9', '4:3', '1:1', '21:9')",
    )

    args = parser.parse_args()

    # Parsear crop ratio (ej "16:9" -> 1.777)
    crop_ratio = None
    if args.crop:
        try:
            w, h = args.crop.split(":")
            crop_ratio = float(w) / float(h)
        except (ValueError, ZeroDivisionError):
            print(f"{RED}ERROR: --crop debe tener formato 'W:H' (ej: 16:9){RESET}")
            sys.exit(1)

    folder = Path(args.folder)
    process_folder(
        folder=folder,
        max_width=args.max_width,
        quality=args.quality,
        create_webp=args.webp,
        crop_ratio=crop_ratio,
    )


if __name__ == "__main__":
    main()
