import json
import os
from PIL import Image

src_img_path = r"f:\game\public\crystal\assets\images\symbols-0@1x.131de0d872a2.png"
json_path = r"f:\game\public\crystal\assets\images\symbols-0@1x.png.4835f86a5a3a.json"
out_dir = r"f:\game\public\crystal\assets\images\symbols"
os.makedirs(out_dir, exist_ok=True)

with open(json_path, "r", encoding="utf-8") as f:
    data = json.load(f)

img = Image.open(src_img_path).convert("RGBA")

frames = data.get("frames", {})
for name, info in frames.items():
    frame = info["frame"]
    x, y, w, h = frame["x"], frame["y"], frame["w"], frame["h"]
    cropped = img.crop((x, y, x + w, y + h))
    dest = os.path.join(out_dir, f"{name}.png")
    cropped.save(dest, "PNG")
    print(f"Extracted symbol: {name} -> {dest}")

print("All symbols extracted successfully!")
