#!/usr/bin/python3 -u
import subprocess, mysql.connector, json

with open('db_config.json', 'r') as file: config = json.load(file)

# Tables ID for this update
id = 3

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

print (t_name)

sql.execute(f"SELECT * FROM {t_name}")
result = sql.fetchall()

def portck(ip, port):
    ret = subprocess.getoutput(f"nmap -T2 -6 -Pn -p {port} {ip}|egrep -o -i 'open'")
    if (ret == 'open'):
        return 1
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

    print (f"ID: {row[0]} - NVR: {st_nvr}")
    sql.execute(f"UPDATE {t_name} SET status = '{st_nvr}' WHERE id = {row[0]}")
    db.commit()

sql.execute(f"UPDATE tables SET lstupt = CURRENT_TIMESTAMP, isupt = 0 WHERE id = {id}")
db.commit()
sql.close()
db.close()
