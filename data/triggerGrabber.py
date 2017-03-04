import copy
import json
from collections import OrderedDict

with open('moves.json') as js:
    mlist = json.load(js, object_pairs_hook=OrderedDict)

d = OrderedDict()
d["Triggers by Type"]=OrderedDict()
for name,obj in mlist.items():
    if "Triggers" in obj:
        for i in obj["Triggers"]:
            l = copy.deepcopy(i)
            l.pop("type",None)
            if "prereq" in i:
                pass
            else:
                if "type" in i:
                    if i["type"] in d["Triggers by Type"]:
                        d["Triggers by Type"][i["type"]][name]=l
                    else:
                        d["Triggers by Type"][i["type"]]=OrderedDict()
                        d["Triggers by Type"][i["type"]][name]=l
                else:
                    print [name,i]

with open('triggersList.json', 'w') as outfile:
    json.dump(d, outfile,indent=4)
