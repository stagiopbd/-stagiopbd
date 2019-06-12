from kafka import KafkaConsumer
from kafka import KafkaProducer
from threading import Thread
import datetime
import time
import mysql.connector
import json

class ConsumerKafka(object):
    def __init__(self, Topic, User, Password, DataBaseName):
        self.ContCasos = 0
        self.Topic = Topic

        self.DbConnection = mysql.connector.connect(user=User, password=Password, host='localhost', database=DataBaseName, auth_plugin='mysql_native_password')
        self.Cursor = self.DbConnection.cursor()
        self.ReadProcess = Thread(target=self.readMessage)

    def createConsumer(self):
        consumerKafka = KafkaConsumer(self.Topic, bootstrap_servers=['35.237.186.164:9092'], auto_offset_reset='earliest',
                                      enable_auto_commit=True, auto_commit_interval_ms=1000, value_deserializer=lambda m: json.loads(m.decode('utf-8')))
        return consumerKafka

    def createProducer(self, ipAddress):
        producer = KafkaProducer(bootstrap_servers=ipAddress, value_serializer=lambda v: json.dumps(v).encode('utf-8'))
        return producer

    def sendMessage(self, ipAddress, topicNotification, message):
        producer = self.createProducer(ipAddress)
        producer.send(topicNotification, message)
        producer.close()

    def getTimeStamp(self):
        ts = time.time()
        st = datetime.datetime.fromtimestamp(ts).strftime('%d-%m-%Y %H:%M:%S')

        return st

    def formartMessage(self, timestamp, contCasos):
        msg={}
        msg['type'] = "notificacao"
        msg['from'] = "hospital"
        msg['to'] = "physician" #Todo verificar
        msg['datetime'] = timestamp
        msg['title'] = "Notificacao Hospital"

        if contCasos == 0:
            msg['text'] =" "
            msg['protocol'] ="normal"

        elif contCasos == 1:
            msg['text'] ="Caso de sarampo registrado"
            msg['protocol'] ="attention"

        elif contCasos > 1:
            msg['text'] ="Caso de sarampo registrado"
            msg['protocol'] ="critical"

        return msg

    def readMessage(self):
        msg={}
        consumer = self.createConsumer()
        for readMsg in consumer:
            dataRead = readMsg.value
            if dataRead["type"] == "bed_request":#tabela bed_request
                if dataRead["cid_code"] == "B05" or dataRead["cid_code"] == "05" or dataRead["cid_code"] == "5" or dataRead["cid_code"] == "Sarampo" or dataRead["cid_code"] == "sarampo" or dataRead["cid_code"] == "B05 Sarampo" or dataRead["cid_code"] == "B05 sarampo":
                    self.ContCasos = self.ContCasos + 1
                    timeStamp = self.getTimeStamp()
                    msg = self.formartMessage(timeStamp, self.ContCasos)
                    self.sendMessage('35.237.186.164:9092', 'notificacao', msg)#Envio da mensagem para o tópico notificação

                    #Todo setar as configurações para a nova tabela
                    data = (dataRead["pat_cpf"], "UNIDADE ISOLAMENTO")
                    self.Cursor.callproc("Internacao", data)#Chamada da Procedure

                else:
                    if self.ContCasos == 0:#Envio de mensagens caso nao tenha nenhum caso registrado
                        timeStamp = self.getTimeStamp()
                        msg = self.formartMessage(timeStamp, self.ContCasos)
                        self.sendMessage('35.237.186.164:9092', 'notificacao', msg)#Envio da mensagem para o tópico notificação

            self.DbConnection.commit()
        self.Cursor.close()
        self.DbConnection.close()


if __name__ == "__main__":
    #Lembrar sempre de inicializar as classes com os parâmetros que seram utilizados
    Consume = ConsumerKafka('detmedico','root','123','kiizj5q0n6quilvc') #instancia da classe ConsumerKafka que escuta tópico medico para detectar casos de sarampo
    Consume.ReadProcess.start()#Inicio a Thread que irá executar o método readMessage