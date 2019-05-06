INSERT_SQL = "insert into {tablename} ({columns}) values {values};"

def jsonMessageToObject(message):
    import json
    return json.loads(message, object_hook=__json_object_hook)

def jsonMessageToJson(message):
    import json
    return json.loads(message)

def __json_object_hook(jsonData):
    from collections import namedtuple
    return namedtuple('Message', jsonData.keys())(*jsonData.values())

def messageToInsertSQL(message, tablename):
    keys = list()
    vals = list()
    for key,value in message.items():
        keys.append(key)
        vals.append(value)
    return INSERT_SQL.format(tablename=tablename,
                             columns=', '.join(keys),
                             values=', '.join(__parseValuesToInsertSQL(vals)))

def __parseValuesToInsertSQL(values):
    fmtvalues = list()
    for value in values:
        if isinstance(value, str):
            value = "\"{}\"".format(value)
        fmtvalues.append(str(value))
    return fmtvalues
