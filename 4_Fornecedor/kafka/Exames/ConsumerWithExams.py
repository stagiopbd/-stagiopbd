from kafka import KafkaConsumer
import mysql.connector
import json
import math
import random

CONN = None
CURSOR = None
CONSUMER = None

# Aqui definimos duas variaveis de controle
# para a quantidade de exames que terão os
# resultados positivos e negativos. Isso é 
# usado e atualizado na geração desses resul-
# tados em blocos na função getExamResults.
POSITIVE = 0
NEGATIVE = 0

# Nessa linha o usuário pode definir a porcen-
# tagem desejada de resultados POSITIVOS que
# desejar. Os negativos automaticamente terão
# porcentagem igual a 1 - THRESHOLD.
THRESHOLD = 0.05

# Essa variável define o número mínimo de tuplas
# necessário para se alcançar o threshold. Por 
# exemplo, dizer que eu quero probabilidade de 5%
# significa dizer que 1 a cada 20 exames deve ter
# resultado positivo. Se fizermos 5% de 19, 18,
# 17...etc, teremos um valor menor do que 1 e não
# seria possível atribuir 1 tupla com resultado
# positivo. A função floor é justamente para fazer
# o arredondamento para baixo (insere um erro).
MIN_TUPLES = math.floor(1/float(THRESHOLD))

#
# Nome da função: getExamResults
#
# Entrada: número de exames que precisam ter seus
# resultados definidos.
#
# Saída: Uma lista contendo os resultados dos exames, 
# na forma como esperado no banco de dados.
#
def getExamResults(numberofresults):
    #Acessar variáveis globais
    global THRESHOLD, POSITIVE, NEGATIVE

    #Positivos são sempre 1 a cada bloco.
    POSITIVE = 1

    #Negativos são todos os exames para os quais não 
    #tenha sido atribuído resultado positivo   
    NEGATIVE = numberofresults - POSITIVE
    
    #Criação e preenchimento da lista de resultados
    results=[]
    for i in range(POSITIVE):
        results.append('POSITIVO')
    for j in range(NEGATIVE):
        results.append('NEGATIVO')

    return results

#
# Nome da função: updateExamResults
#
# Entrada: TIDs das tuplas relacionadas à requisições
# de exames que ainda estejam sem resultado.
#
# Saída: tuplas atualizadas no banco de dados com os
# resultados obedecendo o padrão de probabilidade.
#
def updateExamResults():
    #Acessar variáveis globais
    global CURSOR

    # Consulta para obter o mínimo de tuplas necessárias
    # do banco que possam permitir a garantia da distri-
    # buição de probabilidade.
    query_input = "SELECT exr_id FROM exam_request_destiny WHERE exr_result = 'None' LIMIT " + str(MIN_TUPLES)

    # Consulta que permite atualizar os resultados dos
    # exames que necessitarem, com base no TID.
    query_output = """UPDATE exam_request_destiny SET exr_result = %s WHERE exr_id = %s"""

    # Buscar tuplas com resultados em branco
    CURSOR.execute(query_input)

    # Converter o resultado da busca para uma lista
    tids = [row[0] for row in CURSOR.fetchall()]

    # Foi obtido o número mínimo de tuplas?
    if len(tids) == MIN_TUPLES:
        # Para deixar os dados esparsos, embaralhe
        # os TIDs. Ex para três: (3, 1, 2)
        random.shuffle(tids)

        # Obtenha os resultados dos exames, porém
        # aqui os POSITIVOS sempre vem primeiro. 
        # Ex para três: (POSITIVO, NEGATIVO, NEGATIVO).
        results = getExamResults(len(tids))

        #Combine as duas listas dois a dois.
        # Ex para três ((POSITIVO,3),(NEGATIVO,1),(NEGATIVO,2))
        data = list(zip(results, tids))

        #Para cada uma das consultas acima execute a atualização.
        for pair in data:
            CURSOR.execute(query_output, (pair[0], pair[1]))

    

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
                                       database='stagiopbd_dev')
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
    #CONSOME AS MENSAGENS (SE NÃO CONSUMIR DENTRO DO TIMEOUT, ENCERRA), MÁX. 1000 DE CADA VEZ
    msg_pack = initConsumer().poll(timeout_ms=20000, max_records=1000)

    #CASO NÃO RECEBA NADA, PRAZO DE DEFINIDO NO TIMEOUT
    if not msg_pack:
        break
    
    #PARA CADA MENSAGEM FAZ O INSERT
    for tp, messages in msg_pack.items():
        for message in messages:
            prepareMessage(message.value)

    #PERSISTE OS DADOS NO BANCO, MÁX. 1000 TUPLAS DE CADA VEZ
    CONN.commit()

    #VERIFICA SE EXISTEM ATUALIZAÇÕES NECESSÁRIAS NO RESULTADO DE EXAMES
    updateExamResults()

    #PERSISTE AS ATUALIZAÇÕES DE RESULTADO DE EXAME, SE HOUVEREM
    CONN.commit()

teardown()
