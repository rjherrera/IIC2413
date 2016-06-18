import sqlite3
import csv

conn = sqlite3.connect('eod1.db')
c = conn.cursor()

# c.execute('create table sexo (Id, Sexo);')

# with open('Sexo.csv', 'r') as fin:
#     dr = csv.DictReader(fin)
#     to_db = [(i['Id'], i['Sexo']) for i in dr]

# c.executemany("INSERT INTO sexo (Id, Sexo) VALUES (?, ?);", to_db)
# conn.commit()


i1 = '''create view viajestotales as select c.comuna,
count(*) as cantidad from comuna as c, viajes as v, modo as m where
v.comunaorigen=c.id and m.id = v.modoagregado group by c.comuna;'''

i2 = '''create view viajesmodo as select c.comuna, m.modo, count(*) as
cantidad from comuna as c, viajes as v, modo as m where v.comunaorigen=c.id and
m.id = v.modoagregado group by c.comuna, m.modo;'''

i3 = '''select vt.comuna, vm.modo, vt.cantidad, vm.cantidad,
cast(vm.cantidad as float)/cast(vt.cantidad as float) as
p from viajestotales as vt, viajesmodo as vm where vt.comuna=vm.comuna
and vm.modo=order by vm.modo, p desc;'''

i4 = '''select vt.comuna, vt.cantidad, vm.cantidad,
cast(vm.cantidad as float)/cast(vt.cantidad as float) as p from viajestotales
as vt, viajesmodo as vm where vt.comuna=vm.comuna and vm.modo="Caminata"
order by p desc;'''

i5 = '''create view caminatasexo as
select s.sexo, c.comuna, count(m.id) as cantidad
from viajes as v, personas as p, comuna as c, modo as m, sexo as s
where v.persona = p.persona and v.comunaorigen = c.id and m.id = v.modoagregado
and m.id=17 and p.sexo = s.id group by comuna, s.sexo'''

i6 = '''create view totalsexo as
select s.sexo, c.comuna, count(m.id) as cantidad
from viajes as v, personas as p, comuna as c, modo as m, sexo as s
where v.persona = p.persona and v.comunaorigen = c.id and
m.id = v.modoagregado and p.sexo = s.id
group by comuna, s.sexo'''

i7 = '''create view proporcion as
select ts.sexo, ts.comuna,
cast(cs.cantidad as float)/cast(ts.cantidad as float) as proporcion
from totalsexo as ts, caminatasexo as cs
where ts.comuna = cs.comuna and ts.sexo = cs.sexo'''

i8 = '''select p.comuna, p.sexo, p.proporcion, p1.sexo, p1.proporcion
from proporcion as p, proporcion as p1
where p.comuna = p1.comuna and p.sexo != p1.sexo
order by p1.proporcion - p.proporcion'''

# c.execute('drop view caminatasexo')
# c.execute('drop view totalsexo')
# c.execute(i5)
# c.execute(i6)
c.execute(i8)
# print(c.fetchmany(30))
l = c.fetchall()
for i in l:
    print(i)



conn.close()
