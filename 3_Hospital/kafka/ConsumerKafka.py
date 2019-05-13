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
            if dataRead["type"] == "hospital":
                self.Cursor.execute("INSERT INTO hospital (hsp_id, hsp_cnpj, hsp_name, hsp_address, hsp_phone, hsp_per_id, hsp_sit_id) "
                                    "VALUES (%(hsp_id)s, %(hsp_cnpj)s, %(hsp_name)s, %(hsp_address)s, %(hsp_phone)s, %(hsp_per_id)s, %(hsp_sit_id)s) ON DUPLICATE KEY UPDATE hsp_id = %(hsp_id)s", dataRead)

            elif dataRead["type"] == "hospital_situation":
                self.Cursor.execute("INSERT INTO hospital_situation (sit_id, sit_description, sit_bedroom, sit_physician, sit_available) "
                                    "VALUES (%(sit_id)s, %(sit_description)s, %(sit_bedroom)s, %(sit_physician)s, %(sit_available)s) ON DUPLICATE KEY UPDATE sit_id = %(sit_id)s", dataRead)

            elif dataRead["type"] == "hospital_wing":
                self.Cursor.execute("INSERT INTO hospital_wing (wng_id, wng_type, wng_msp_code, wng_sit_id, wng_hsp_id) "
                                    "VALUES (%(wng_id)s, %(wng_type)s, %(wng_msp_code)s, %(wng_sit_id)s, %(wng_hsp_id)s) ON DUPLICATE KEY UPDATE wng_id = %(wng_id)s", dataRead)

            elif dataRead["type"] == "medical_speciality":
                print(dataRead)
                self.Cursor.execute("INSERT INTO medical_speciality (msp_code, msp_name) VALUES (%(msp_code)s, %(msp_name)s) ON DUPLICATE KEY UPDATE msp_code = %(msp_code)s", dataRead)

            elif dataRead["type"] == "bedroom":
                self.Cursor.execute("INSERT INTO bedroom (bed_id, bed_wng_id, bed_pat_cpf) VALUES (%(bed_id)s, %(bed_wng_id)s, %(bed_pat_cpf)s) ON DUPLICATE KEY UPDATE bed_id = %(bed_id)s", dataRead)

            elif dataRead["type"] == "physician_speciality":
                self.Cursor.execute("INSERT INTO physician_speciality (spc_msp_code, spc_phy_cpf) VALUES (%(spc_msp_code)s, %(spc_phy_cpf)s) ON DUPLICATE KEY UPDATE msp_code = %(spc_msp_code)s", dataRead)

            elif dataRead["type"] == "physician":
                self.Cursor.execute("INSERT INTO physician (phy_cpf, phy_phone_pro, phy_per_id) "
                                    "VALUES (%(phy_cpf)s, %(phy_phone_pro)s, %(phy_per_id)s) ON DUPLICATE KEY UPDATE phy_cpf = %(phy_cpf)s", dataRead)

            self.DbConnection.commit()
        self.Cursor.close()
        self.DbConnection.close()


if __name__ == "__main__":
    #Lembrar sempre de inicializar as classes com os parâmetros que seram utilizados
    Consume = ConsumerKafka('ts3topic','root','admin','logic685_stagiopbd') #instancia da classe ConsumerKafka
    Consume.ReadProcess.start()#Inicio a Thread que irá executar o método readMessage