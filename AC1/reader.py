import csv

lista = []

with open('test.txt') as f:
    l = f.readlines()
    for i in l:
        if i.split(';')[3] == '13':
            lista.append(i.strip())

# print(lista)

lista_limpia = []
for i in lista:
    t = []
    for j in i.replace('"', '').split(';'):
        d = j.rstrip().lstrip()
        t.append(d)
    t = t[1::3]
    t[-1] = int(t[-1].replace(',0', '').replace('.', ''))
    lista_limpia.append(tuple(t))

lista_limpia.sort(key=lambda x: -x[1])
print(lista_limpia)

with open('Ingreso.csv', 'w') as f:
    writer = csv.writer(f)
    writer.writerow(['Comuna', 'Ingreso'])
    writer.writerows(lista_limpia)
