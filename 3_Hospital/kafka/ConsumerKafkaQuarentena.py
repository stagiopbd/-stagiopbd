from kafka import KafkaConsumer
from threading import Thread
import mysql.connector
import json

class ConsumerKafka(object):
    def __init__(self, Topic, User, Password, DataBaseName):
        self.Topic = Topic

        self.DbConnection = mysql.connector.connect(user=User, password=Password, host='localhost', database=DataBaseName, auth_plugin='mysql_native_password')
        self.Cursor = self.DbConnection.cursor()
        self.ReadProcess = Thread(target=self.readMessage)

    def createConsumer(self):
        consumerKafka = KafkaConsumer(self.Topic, bootstrap_servers=['127.0.0.1:9092'], auto_offset_reset='earliest',
                                      enable_auto_commit=True, auto_commit_interval_ms=1000, value_deserializer=lambda m: json.loads(m.decode('utf-8')))
        return consumerKafka

    def readMessage(self):
        consumer = self.createConsumer()
        for readMsg in consumer:
            dataRead = readMsg.value
            if dataRead["type"] == "medicalconsultation":
                if dataRead["cns_stm_id"] == "B05" or dataRead["cns_stm_id"] == "05" or dataRead["cns_stm_id"] == "5" or dataRead["cns_stm_id"] == "Sarampo" or dataRead["cns_stm_id"] == "sarampo" or dataRead["cns_stm_id"] == "B05 Sarampo" or dataRead["cns_stm_id"] == "B05 sarampo":
                    #Todo setar as configurações para a nova tabela
                    data = (dataRead["cns_phy_cpf"], "UNIDADE ISOLAMENTO")
                    self.Cursor.callproc("Internacao", data)

            self.DbConnection.commit()
        self.Cursor.close()
        self.DbConnection.close()


if __name__ == "__main__":
    #Lembrar sempre de inicializar as classes com os parâmetros que seram utilizados
    Consume = ConsumerKafka('ts3topic','root','admin','stagiopbd') #instancia da classe ConsumerKafka
    Consume.ReadProcess.start()#Inicio a Thread que irá executar o método readMessage