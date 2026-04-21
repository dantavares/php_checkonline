# php check online

* Install mysql-connector-python

* Move "status" folder to your html web server

* Create "status" mysql database and import "init.sql"

* Config mysql connection on "db_config.json" file

* Create crontab entry to "ckstatus.sh" script, to update services status
  
  * */15 * * * * /var/www/html/status/ckstatus.sh 2>&1 #Update Status every 15 min

* Enter User And Password
  
  * USER: admin
  
  * Passwd: admin
