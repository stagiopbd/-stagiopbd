from kafka import KafkaConsumer
import mysql.connector
import json

CONN = None
CURSOR = None
CONSUMER = None


def prepareMessage(rawmsg):
    '''Extract from message tablename, columns and values to insert in DB'''
    message = json.loads(rawmsg)
    tablename = message.pop("type")
    columns, values = list(message.keys()), list(message.values())
    insertDB(tablename, columns, values)


def initConsumer():
    '''Initialize consumer connection if not already initialized'''
    global CONSUMER
    if CONSUMER is None:
        CONSUMER = KafkaConsumer('det-fornecedor',
                                 bootstrap_servers=['localhost:9092'])
                                 #PODE SER NECESSARIO, MAS ACHO QUE NAO
                                 #auto_offset_reset='earliest',
                                 #enable_auto_commit=True,
                                 #auto_commit_interval_ms=1000,
                                 #group_id='fornecedor')
    return CONSUMER


def initCursor():
    '''Initialize connection and cursor if not already initialized'''
    global CONN, CURSOR
    if CONN is None:
        CONN = mysql.connector.connect(user='root',
                                       password='stagiopbdmysql**',
                                       host='localhost',
                                       database='unified_database')
    if CURSOR is None:
        CURSOR = CONN.cursor()
    return CURSOR


def insertDB(tablename, columns, values):
    '''Insert record into database with parameters informed'''
    sqltmpl = "INSERT IGNORE INTO {tbl} ({cols}) VALUES ({vals})"
    sql = sqltmpl.format(tbl=tablename,
                         cols=', '.join(columns),
                         vals=valuesToPlaceholder(values))
    initCursor().execute(sql, values)


def valuesToPlaceholder(message):
    '''Create placeholders for use in sql execution'''
    placeholders = ["%s" for n in range(len(message))]
    return ', '.join(placeholders)


def teardown():
    global CONN, CURSOR, CONSUMER
    CURSOR.close()
    CONN.close()
    CONSUMER.close()


pollCount=0
while True:
    
    #CONSOME AS MENSAGENS (SE NÃO CONSUMIR NADA EM 2 DIAS, ENCERRA), 1000 DE CADA VEZ
    msg_pack = initConsumer().poll(timeout_ms=172800000, max_records=1000)

    #CASO NÃO RECEBA NADA, PRAZO DE 2 DIAS
    if not msg_pack:
        break
    
    #PARA CADA MENSAGEM FAZ O INSERT
    for tp, messages in msg_pack.items():
        for message in messages:
            prepareMessage(message.value)

    #PERSISTE OS DADOS NO BANCO, 1000 TUPLAS DE CADA VEZ
    CONN.commit()


teardown()
