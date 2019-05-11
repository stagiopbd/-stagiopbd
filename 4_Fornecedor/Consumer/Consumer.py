from kafka import KafkaConsumer
import mysql.connector

CONN = None
CURSOR = None
CONSUMER = None
FILTER_KEEP = ['MEDICINE']


def prepareMessage(rawmsg):
    '''Extract from message tablename, columns and values to insert in DB'''
    import json
    message = json.loads(rawmsg)
    tablename = message.pop("type")
    columns, values = list(message.keys()), list(message.values())
    # if tablename.upper() in FILTER_KEEP:
    #     # print("---------OK----------")
    #     print(tablename.upper(), columns, values)
    insertDB(tablename, columns, values)


def initConsumer():
    '''Initialize consumer connection if not already initialized'''
    global CONSUMER
    if CONSUMER is None:
        CONSUMER = KafkaConsumer('det-fornecedor',
                                 bootstrap_servers=['localhost:9092'])
    return CONSUMER


def initCursor():
    '''Initialize connection and cursor if not already initialized'''
    global CONN, CURSOR
    if CONN is None:
        CONN = mysql.connector.connect(user='root',
                                       password='stagiopbdmysql**',
                                       host='localhost',
                                       database='stagiopbd_test')
    if CURSOR is None:
        CURSOR = CONN.cursor()
    return CURSOR


def insertDB(tablename, columns, values):
    '''Insert record into database with parameters informed'''
    sqltmpl = "insert into {tbl} ({cols}) values ({vals})"
    sql = sqltmpl.format(tbl=tablename,
                         cols=', '.join(columns),
                         vals=valuesToPlaceholder(values))
    # print(sql, values)
    initCursor().execute(sql, values)


def valuesToPlaceholder(message):
    '''Create placeholders for use in sql execution'''
    placeholders = ["%s" for n in range(len(message))]
    return ', '.join(placeholders)


def teardown():
    global CONN, CURSOR, CONSUMER
    CONN.commit()
    CURSOR.close()
    CONN.close()
    CONSUMER.close()


pollCount=0
while True:
    msg_pack = initConsumer().poll(timeout_ms=10000, max_records=5)

    if not msg_pack:
        break
    pollCount+=1
    print("\n\n\n>> POLL", pollCount)

    for tp, messages in msg_pack.items():
        for message in messages:
            prepareMessage(message.value)


teardown()