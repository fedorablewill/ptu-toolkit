import json

with open('ptu_pokedex_1_05.json') as infile:
	dex = json.load(infile)

print dex["001"]["Species"]