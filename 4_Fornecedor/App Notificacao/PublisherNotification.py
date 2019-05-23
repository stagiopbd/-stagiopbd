# pip3 install kafka-python
# pip3 install mysql-connector-python

from kafka import KafkaProducer
import mysql.connector
import json
import re

lastMsg = 0
# Confirmar se a base existe e se os dados de acesso estão corretos
cnx = mysql.connector.connect(user='root', password='stagiopbdmysql**', host='localhost', database='stagiopbd_dev2')

# Se cadastra no tópico "det-fornecedor" do servidor Kafka apontado em bootstrap_servers.
# Demais parâmetros garantem que quando executar novamente irá ler somente mensagens recentes.
producer = KafkaProducer('det-fornecedor', bootstrap_servers=['localhost:9092'],
                         auto_offset_reset='earliest', enable_auto_commit=True,
                         auto_commit_interval_ms=1000, group_id='fornecedor',
                         value_deserializer=lambda m: json.loads(m.decode('utf-8')))



#================================= OPCAO de CONFIGURACAO ===========================================
# producer =  KafkaProducer(bootstrap_servers=['localhost:9092'])
#===================================================================================================

# Conexão com o banco MySQL
cursor = cnx.cursor()

# Consulta a tabela de notificacao no banco de dados
query = ("SELECT * FROM notificacao")
cursor.execute(query)

# Exibe mensagem por mensagem
for i in cursor:
    print(i)
    if i.id > lastMsg: #caso o id da mensagem seja maior que a ultima mensagem enviada ele envia a notificacao
        producer.send('topico', i)

#============================= COMENTARIO DE EXEMPLO ================================================
# producer.send('fizzbuzz', {'type' : 'notificacao', 'from' : 'supplier', 'to' : '', 'datetime' : '', 'title' : '', 'text' : '', 'protocol' : ''})
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


