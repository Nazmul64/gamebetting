import os
import shutil
from PIL import Image

src_bg = r"C:\Users\nazmu\.gemini\antigravity-ide\brain\3f7527b6-1662-4cbf-ba00-d5b721a90470\crystal_castle_bg_1789906513805.jpg"
src_king_sleep = r"C:\Users\nazmu\.gemini\antigravity-ide\brain\3f7527b6-1662-4cbf-ba00-d5b721a90470\king_character_1789906533417.jpg"
src_king_awake = r"C:\Users\nazmu\.gemini\antigravity-ide\brain\3f7527b6-1662-4cbf-ba00-d5b721a90470\king_awake_1789906554851.jpg"

dest_dir = r"f:\game\public\crystal\assets\images"
os.makedirs(dest_dir, exist_ok=True)

# 1. Copy background
img_bg = Image.open(src_bg).convert("RGB")
img_bg.save(os.path.join(dest_dir, "background.png"), "PNG")
print("Saved background.png")

def make_transparent_sprite(src_path, dest_path, threshold=25):
    img = Image.open(src_path).convert("RGBA")
    datas = img.getdata()
    new_data = []
    for item in datas:
        # If black background
        r, g, b, a = item
        brightness = max(r, g, b)
        if brightness < threshold:
            new_data.append((r, g, b, 0))
        elif brightness < threshold + 30:
            alpha = int(255 * (brightness - threshold) / 30)
            new_data.append((r, g, b, alpha))
        else:
            new_data.append((r, g, b, 255))
    img.putdata(new_data)
    img.save(dest_path, "PNG")
    print(f"Saved transparent sprite: {dest_path}")

make_transparent_sprite(src_king_sleep, os.path.join(dest_dir, "king_sleep.png"), threshold=15)
make_transparent_sprite(src_king_awake, os.path.join(dest_dir, "king_awake.png"), threshold=15)

print("All image processing complete!")
