import sqlite3
import csv

conn = sqlite3.connect('eod3.db')
c = conn.cursor()

# viajes a pie
i1 = '''create view totalbicicleta as select c.comuna,
count(case when p.sexo="1" then m.id end) as hombre,
count(case when p.sexo="2" then m.id end) as mujer,
count(m.id) as total,
cast(i.ingreso as integer) as ingreso
from viajes as v, personas as p, comuna as c, modo as m, ingreso as i
where v.persona = p.persona and v.comunaorigen = c.id and m.id = v.modoagregado
and i.comuna = c.comuna and m.id = '18'
group by c.id'''

i2 = '''select t.comuna, ingreso, (hombre*1.0)/total - (mujer*1.0)/total as diferencia
from totalbicicleta as t order by ingreso'''

c.execute('select * from totalbicicleta')
l = c.fetchall()
for i in l:
    print(i)
# with open('final_bicicleta.csv', 'w') as f:
#     writer = csv.writer(f)
#     writer.writerow(['Comuna', 'Ingreso', 'Diferencia'])
#     writer.writerows(l)
conn.close()
