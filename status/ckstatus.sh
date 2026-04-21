#!/bin/bash

cd /var/www/html/status
python3 uptscripts/esc_aracoiaba.py
python3 uptscripts/def_single.py 4
python3 uptscripts/def_single.py 5
