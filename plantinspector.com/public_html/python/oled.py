#!/usr/bin/python3

from PIL import Image, ImageOps

image = Image.open('/var/www/plantinspector.com/public_html/img/chart.png') #open desired image

#image = image.convert('1') #convert img to black and white
thresh = 200
fn = lambda x : 255 if x > thresh else 0
image = image.convert('L').point(fn, mode='1')

image = ImageOps.invert(image)
image.thumbnail((128, 64), Image.Resampling.BICUBIC)
image.save('/var/www/plantinspector.com/public_html/img/chart_small.png', 'PNG')

import time
import luma
from luma.core.interface.serial import i2c
from luma.oled.device import ssd1306
from luma.core.render import canvas
from PIL import Image
import os #added for testing flag detection

# NB ssd1306 devices are monochromatic; a pixel is enabled with
#    white and disabled with black.
# NB the ssd1306 class has no way of knowing the device resolution/size.
device = ssd1306(i2c(port=1, address=0x3c), width=128, height=64, rotate=0)

# set the contrast to minimum.
device.contrast(1)

# load the rpi logo.
logo = Image.open('/var/www/plantinspector.com/public_html/img/chart_small.png')

# show some info.
print(f'device size {device.size}')
print(f'device mode {device.mode}')
print(f'logo size {logo.size}')
print(f'logo mode {logo.mode}')

# NB this will only send the data to the display after this "with" block is complete.
# NB the draw variable is-a PIL.ImageDraw.Draw (https://pillow.readthedocs.io/en/3.1.x/reference/ImageDraw.html).
# see https://github.com/rm-hull/luma.core/blob/master/luma/core/render.py
#with canvas(device, dither=True) as draw:
with canvas(device, dither=False) as draw:
#    draw.rectangle(device.bounding_box, outline='white', fill='black')
    draw.bitmap((0, 0), logo, fill='white')
#    message = 'Raspberry Pi'
#    text_size = draw.textsize(message)
#    text_size = draw.textbbox((51,0), message)
#    draw.text((device.width - text_size[0], (device.height - text_size[1]) // 2), message, fill='black')
#    draw.text((device.width, (device.height) // 2), message, fill='white')

# NB the display will be turn off after we exit this application.
time.sleep(2)

if (os.path.isfile('/var/www/plantinspector.com/public_html/python/stop-script')):
    print(f'\nstop\nnow')
    os.system('rm -rf /var/www/plantinspector.com/public_html/python/stop-script')
    time.sleep(2)
