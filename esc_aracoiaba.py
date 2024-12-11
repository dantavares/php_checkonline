#!/usr/bin/python3 -u
import subprocess, mysql.connector, json

with open('db_config.json', 'r') as file: config = json.load(file)

# Tables ID for this update
id = 1

db = mysql.connector.connect(
  host = config['host'],
  user = config['user'],
  database = config['dbname'],
  password = config['password']
)

sql = db.cursor()
sql.execute(f"UPDATE tables SET isupt = 1 WHERE id = {id}")
db.commit()

sql.execute(f"select name from tables where id = {id}")
result = sql.fetchall()
t_name = result[0][0]

sql.execute(f"SELECT * FROM {t_name}")
result = sql.fetchall()

def portck(ip, port):
    tpip = f"ping -6 -c 1 {ip} | egrep -o -i '1 received'"
    
    if (tpip == '1 received'):
        ret = subprocess.getoutput(f"nmap -T2 -Pn -6 -p {port} {ip}|egrep -o -i 'open'")
        if (ret == 'open'):
            return 1
        else:
            return 0
    else:
        ret = subprocess.getoutput(f"nmap -T2 -Pn -p {port} {ip}|egrep -o -i 'open'")
        if (ret == 'open'):
            return 1
        else:
            return 0
    
for row in result:
    if ( portck(row[1], row[2]) ): 
        st_nvr = "OnLine"
    else:
        st_nvr = "OffLine"
    
    if ( portck(row[1], row[3]) ): 
        st_alm = "OnLine"
    else:
        st_alm = "OffLine"
    
    print (f"ID: {row[0]} - NVR: {st_nvr} Alarme: {st_nvr}")
    sql.execute(f"UPDATE {t_name} SET status_nvr = '{st_nvr}', status_al = '{st_alm}' WHERE id = {row[0]}")
    db.commit()

sql.execute(f"UPDATE tables SET lstupt = CURRENT_TIMESTAMP, isupt = 0 WHERE id = {id}")
db.commit()
sql.close()
db.close()  