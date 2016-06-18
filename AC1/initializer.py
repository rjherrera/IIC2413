import sqlite3
import csv

conn = sqlite3.connect('eod3.db')
c = conn.cursor()

# c.execute('create table sexo (Id, Sexo);')

# with open('Sexo.csv', 'r') as fin:
#     dr = csv.DictReader(fin)
#     to_db = [(i['Id'], i['Sexo']) for i in dr]

# c.executemany("INSERT INTO sexo (Id, Sexo) VALUES (?, ?);", to_db)
# conn.commit()

# c.execute('create table modo (Id, Modo);')

# with open('ModoAgregado.csv', 'r') as fin:
#     dr = csv.DictReader(fin)
#     to_db = [(i['Id'], i['Modo']) for i in dr]

# c.executemany("INSERT INTO modo (Id, Modo) VALUES (?, ?);", to_db)
# conn.commit()

# c.execute('create table comuna (Id, Comuna);')

# with open('Comuna.csv', 'r') as fin:
#     dr = csv.DictReader(fin)
#     to_db = [(i['Id'], i['Comuna']) for i in dr]

# c.executemany("INSERT INTO comuna (Id, Comuna) VALUES (?, ?);", to_db)
# conn.commit()
c.execute('drop table ingreso')
c.execute('create table ingreso (Comuna, Ingreso);')

with open('Ingreso.csv', 'r') as fin:
    dr = csv.DictReader(fin)
    to_db = [(i['Comuna'], i['Ingreso']) for i in dr]

c.executemany("INSERT INTO ingreso (Comuna, Ingreso) VALUES (?, ?);",
              to_db)
conn.commit()
