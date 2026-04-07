import cv2
import numpy as np
from pathlib import Path

#The point of this program is to assist in making the buttons. 
#This is not meant to be run on the exhibit monitor, and is meant to help potential future devs on this project.
#If anyone in the future wants to use the program, do these steps:
#1. Install Python
#2. pip install opencv-python
#   pip install numpy
#   pip install pathlib

def hex_to_rgb(hex_color: str):
    hex_color = hex_color.strip().lstrip("#")
    if len(hex_color) != 6:
        raise ValueError("Color must be a 6-digit hex value like FF0000")
    return tuple(int(hex_color[i:i+2], 16) for i in (0, 2, 4))

def apply_color_overlay(input_path, output_path, color_rgb, opacity=0.92):
    img = cv2.imread(str(input_path))
    if img is None:
        raise FileNotFoundError(input_path)

    color_bgr = color_rgb[::-1]
    overlay = np.full_like(img, color_bgr)
    result = cv2.addWeighted(overlay, opacity, img, 1 - opacity, 0)
    cv2.imwrite(output_path, result)


folder = Path(__file__).resolve().parent
image_name = input("Image filename: ").strip()
color_input = input("Color hex: ").strip()
output_name = input("Output filename: ").strip()

if not output_name:
        stem = Path(image_name).stem
        output_name = f"{stem}_tinted.png"

input_path = Path(image_name)
if not input_path.is_absolute():
    input_path = (folder / input_path).resolve()

output_path = (folder / output_name).resolve()
rgb = hex_to_rgb(color_input)
apply_color_overlay(input_path, output_path, rgb, opacity=0.92)
print(f"Created: {output_path}")