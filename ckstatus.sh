#!/bin/bash

cd /var/www/html/status; python3 uptscripts/hosp_upas_hortolandia.py
cd /var/www/html/status; python3 uptscripts/esc_aracoiaba.py
cd /var/www/html/status; python3 uptscripts/esc_itapecerica.py
cd /var/www/html/status; python3 uptscripts/cmv_barueri.py
