from kafka import KafkaConsumer
from threading import Thread
import mysql.connector
import json

class ConsumerKafka(object):
    def __init__(self, Topic, User, Password, DataBaseName):
        self.Topic = Topic

        self.DbConnection = mysql.connector.connect(user=User, password=Password, host='35.237.186.164', database=DataBaseName, auth_plugin='mysql_native_password')
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
            if dataRead["type"] == "hospital":
                self.Cursor.execute("INSERT INTO hospital (hsp_id, hsp_cnpj, hsp_name, hsp_address, hsp_telephone, hsp_sit_id, hsp_create, hsp_update) "
                                    "VALUES (%(hsp_id)s, %(hsp_cnpj)s, %(hsp_name)s, %(hsp_address)s, %(hsp_phone)s, %(hsp_sit_id)s, %(hsp_create)s, %(hsp_update)s) ON DUPLICATE KEY UPDATE hsp_id = %(hsp_id)s", dataRead)

            elif dataRead["type"] == "situation":
                self.Cursor.execute("INSERT INTO situation (sit_id, sit_desc) "
                                    "VALUES (%(sit_id)s, %(sit_desc)s) ON DUPLICATE KEY UPDATE sit_id = %(sit_id)s", dataRead)

            elif dataRead["type"] == "wing":
                self.Cursor.execute("INSERT INTO wing (wng_id, wng_desc, wng_hsp_id, wng_sit_id, wng_spc_id) "
                                    "VALUES (%(wng_id)s, %(wng_desc)s, %(wng_hsp_id)s, %(wng_sit_id)s, %(wng_hsp_id)s) ON DUPLICATE KEY UPDATE wng_id = %(wng_id)s", dataRead)

            elif dataRead["type"] == "speciality":
                self.Cursor.execute("INSERT INTO speciality (spc_id, spc_desc) VALUES (%(spc_id)s, %(spc_desc)s) ON DUPLICATE KEY UPDATE spc_id = %(spc_id)s", dataRead)

            elif dataRead["type"] == "bed":
                self.Cursor.execute("INSERT INTO bed (bed_id, bed_desc, bed_wng_id, bed_pat_cpf) "
                                    "VALUES (%(bed_id)s, %(bed_desc)s, %(bed_wng_id)s, %(bed_pat_cpf)s) ON DUPLICATE KEY UPDATE bed_id = %(bed_id)s", dataRead)

            elif dataRead["type"] == "patient":
                self.Cursor.execute("INSERT INTO patient (pat_cpf, pat_name, pat_gender, pat_blood_type, pat_birthdate) "
                                    "VALUES (%(pat_cpf)s, %(pat_name)s, %(pat_gender)s, %(pat_blood_type)s, %(pat_birthdate)s) "
                                    "ON DUPLICATE KEY UPDATE pat_cpf = %(pat_cpf)s", dataRead)

            elif dataRead["type"] == "collaborator":
                self.Cursor.execute("INSERT INTO collaborator (col_cpf, col_name, col_gender, col_function_id, col_hsp_id) "
                                    "VALUES (%(col_cpf)s, %(col_name)s, %(col_gender)s, %(col_function_id)s, %(col_hsp_id)s) ON DUPLICATE KEY UPDATE col_cpf = %(col_cpf)s", dataRead)

            elif dataRead["type"] == "function":
                self.Cursor.execute("INSERT INTO function (func_id, func_descr) "
                                    "VALUES (%(func_id)s, %(func_descr)s) ON DUPLICATE KEY UPDATE func_id = %(func_id)s", dataRead)

            self.DbConnection.commit()
        self.Cursor.close()
        self.DbConnection.close()


if __name__ == "__main__":
    #Lembrar sempre de inicializar as classes com os parâmetros que seram utilizados #TODO Editar informações do tópico Kafka
    Consume = ConsumerKafka('hospital','root','stagiopbd2019','stagiopbd') #instancia da classe ConsumerKafka
    Consume.ReadProcess.start()#Inicio a Thread que irá executar o método readMessage