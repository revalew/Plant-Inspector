#!/usr/bin/python3

#print which user is running the script
#import getpass
#print(getpass.getuser())

# general
import time
import threading

# 2x16 lcd libraries
import RPLCD as RPLCD
from RPLCD.gpio import CharLCD
import RPi.GPIO as GPIO

# 1Wire measurement
import os
import glob

# add data to database
import urllib.request

#oled libraries
import luma
from luma.core.interface.serial import i2c
from luma.oled.device import ssd1306
from luma.core.render import canvas
from PIL import Image, ImageOps

# remove warnings from console
GPIO.setwarnings(False)

# LCD setup
lcd = CharLCD(numbering_mode=GPIO.BCM, cols=16, rows=2, pin_rs=25, pin_e=24, pins_data=[23, 17, 18, 22])
lcd.clear()

# GPIO setup
sensor = 21 # BCM 21 -> soil moisture sensor
GPIO.setmode(GPIO.BCM)
GPIO.setup(sensor, GPIO.IN)

# 1-Wire setup
os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')

base_dir = '/sys/bus/w1/devices/'
device_folder = glob.glob(base_dir + '28*')[0]
device_file = device_folder + '/w1_slave'

# Raw temperature read from sensor
def read_temp_raw():
        f = open(device_file, 'r')
        lines = f.readlines()
        f.close()
        return lines

# Celsius calculation
def read_temp_c():
        lines = read_temp_raw()
        while lines[0].strip()[-3:] != 'YES':
                time.sleep(0.2)
                lines = read_temp_raw()
        equals_pos = lines[1].find('t=')
        if equals_pos != -1:
                temp_string = lines[1][equals_pos+2:]
                temp_c = int(temp_string) / 1000
                temp_c = str(round(temp_c, 1))
                return temp_c

# Change states
def callback(sensor):
        if GPIO.input(sensor):
#               print("No water detected")
                msg = "No water"
        else:
#               print("Water detected")
                msg = "Water detected"
        return msg

def sendDataToServer():
	global temperature

	t = threading.Timer(10,sendDataToServer)
	t.start()
	if (os.path.isfile('/var/www/plantinspector.com/public_html/python/stop-script')):
		t.cancel()

	print("Sensing...")
	temperature = read_temp_c()
	temperature = round(float(temperature),1)

	temp = "%.1f" %temperature
	url = 'http://plantinspector.com/add_data.php?temp=' + temp

	info = urllib.request.urlopen(str(url))
	printChartOnOLED()


def printDataOnLCD():
	global temperature

	t = threading.Timer(3, printDataOnLCD)
	t.start()
	if (os.path.isfile('/var/www/plantinspector.com/public_html/python/stop-script')):
		t.cancel()

	lcd.cursor_pos = (0, 0)
	lcd.write_string("Temp: " + read_temp_c() + chr(223) + "C")
	lcd.cursor_pos = (1, 0)
	lcd.write_string(callback(sensor))
	time.sleep(3)
	lcd.clear()


def printChartOnOLED():
	image = Image.open('/var/www/plantinspector.com/public_html/img/chart.png') #open desired image

	thresh = 200
	fn = lambda x : 255 if x > thresh else 0
	image = image.convert('L').point(fn, mode='1')

	image = ImageOps.invert(image)
	image.thumbnail((128, 64), Image.Resampling.BICUBIC)
	image.save('/var/www/plantinspector.com/public_html/img/chart_small.png', 'PNG')

	device = ssd1306(i2c(port=1, address=0x3c), width=128, height=64, rotate=0)
	device.contrast(1)

	logo = Image.open('/var/www/plantinspector.com/public_html/img/chart_small.png')

	with canvas(device, dither=False) as draw:
		draw.bitmap((0, 0), logo, fill='white')

	time.sleep(5)

# Add event listener to our moisture sensor input
GPIO.add_event_detect(sensor, GPIO.BOTH, bouncetime=300) # signals when the pin goes HIGH/LOW
GPIO.add_event_callback(sensor, callback) # assigns function to GPIO pin and runs it on change

try:
	lcd.clear()
	print("\tStarting the Plant Inspector data logger program\n")
	printDataOnLCD()
	sendDataToServer()

except KeyboardInterrupt:
        lcd.clear()
        print("Interrupt detected. Closing the program.")

except:
        lcd.clear()
        print("\nProgram has stopped because there was an error.\nWe are sorry!\n")

finally:
        print("\nProgram finished initialising.\nSensing and printing threads are now running.\n")

