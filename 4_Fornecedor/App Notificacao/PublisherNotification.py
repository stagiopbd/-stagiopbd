# pip3 install kafka-python
# pip3 install mysql-connector-python

from kafka import KafkaProducer
import mysql.connector
import json
import re

lastMsg = 0

# ============================= Configura conexao com MySQL ===========================================================
# cnx = mysql.connector.connect(user='root', password='stagiopbdmysql**', host='localhost', database='stagiopbd_dev2')
cnx = mysql.connector.connect(user='stagiopbduser', password='stagiopbdmysql**', host='localhost', database='stagiopbd_dev')


#================================= Configura Conexao com Broker Kafka ===========================================
# producer =  KafkaProducer(bootstrap_servers=['kafka:9093'])
producer =  KafkaProducer(bootstrap_servers=['localhost:9092'])


# Conexão com o banco MySQL
cursor = cnx.cursor()

# Consulta a tabela de notificacao no banco de dados
query = ("SELECT * FROM supplier")
cursor.execute(query)

# Exibe mensagem por mensagem
for i in cursor:
    print(i)
#     if i.id > lastMsg: #caso o id da mensagem seja maior que a ultima mensagem enviada ele envia a notificacao
#         producer.send('topico', i)

#============================= Exemplo de Envio de Mensagem JSON ======================================
# producer.send('fizzbuzz', {'type' : 'notificacao', 'from' : 'supplier', 'to' : '', 'datetime' : '', 'title' : '', 'text' : '', 'protocol' : ''})
#
#============================== Exemplo de Mensagem Notificacao =======================================
# msg = {}
# msg['type'] = ‘notificacao’
# msg['from'] = 'patient' or 'physician' or 'hospital' or 'supplier' (Can be 'stagiopbd')
# msg['to'] = 'patient' or 'physician' or 'hospital' or 'supplier'
# msg['datetime'] = 19/05/2019 às 00h00min (timestamp)
# msg['title'] = ‘’
# msg['text'] = ''
# msg['protocol'] = 'normal' or 'attention' or 'critical' or ‘extra’
#=====================================================================================================

cursor.close()
cnx.close()


