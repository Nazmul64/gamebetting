import json
import os
from PIL import Image

def slice_atlas(json_path, img_path, out_dir):
    if not os.path.exists(json_path) or not os.path.exists(img_path):
        return
    os.makedirs(out_dir, exist_ok=True)
    with open(json_path, "r", encoding="utf-8") as f:
        data = json.load(f)
    img = Image.open(img_path).convert("RGBA")
    frames = data.get("frames", {})
    for name, info in frames.items():
        frame = info["frame"]
        x, y, w, h = frame["x"], frame["y"], frame["w"], frame["h"]
        cropped = img.crop((x, y, x + w, y + h))
        dest = os.path.join(out_dir, f"{name}.png")
        cropped.save(dest, "PNG")
        print(f"Extracted: {name} -> {dest}")

base = r"f:\game\public\crystal\assets\images"
slice_atlas(os.path.join(base, "reels-0@1x.png.e07a6f7ca1b8.json"), os.path.join(base, "reels-0@1x.7da97e7a50b8.png"), os.path.join(base, "ui"))
slice_atlas(os.path.join(base, "win_list-0@1x.png.9aa72eabf9f5.json"), os.path.join(base, "win_list-0@1x.dd36e452d8ef.png"), os.path.join(base, "ui"))
slice_atlas(os.path.join(base, "win_list_common-0@1x.png.fe3879a7a7a0.json"), os.path.join(base, "win_list_common-0@1x.ae486a8005ff.png"), os.path.join(base, "ui"))
slice_atlas(os.path.join(base, "payout_vfx-0@1x.png.dc67d5a010d3.json"), os.path.join(base, "payout_vfx-0@1x.c759476fb2ea.png"), os.path.join(base, "ui"))
slice_atlas(os.path.join(base, "no_compression_elements-0@1x.png.09ee475fe1fb.json"), os.path.join(base, "no_compression_elements-0@1x.0d6033c9bf10.png"), os.path.join(base, "ui"))
print("UI slicing finished!")
