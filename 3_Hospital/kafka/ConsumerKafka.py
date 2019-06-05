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
                self.Cursor.execute("INSERT INTO hospital (hsp_seq, hsp_id, hsp_name, hsp_address, hsp_phone, hsp_sst_seq) "
                                    "VALUES (%(hsp_seq)s, %(hsp_id)s, %(hsp_name)s, %(hsp_address)s, %(hsp_phone)s, %(hsp_sst_seq)s) ON DUPLICATE KEY UPDATE hsp_seq = %(hsp_seq)s", dataRead)

            elif dataRead["type"] == "hospital_situation":
                self.Cursor.execute("INSERT INTO hospital_situation (sst_seq, sst_desc) "
                                    "VALUES (%(sst_seq)s, %(sst_desc)s) ON DUPLICATE KEY UPDATE sst_seq = %(sst_seq)s", dataRead)

            elif dataRead["type"] == "hsp_doctor":
                self.Cursor.execute("INSERT INTO hsp_doctor (hdc_seq, hdc_hsp_seq, hdc_id) "
                                    "VALUES (%(hdc_seq)s, %(hdc_hsp_seq)s, %(hdc_id)s) ON DUPLICATE KEY UPDATE hdc_seq = %(hdc_seq)s", dataRead)

            elif dataRead["type"] == "medical_speciality":
                self.Cursor.execute("INSERT INTO medical_speciality (msp_code, msp_name) VALUES (%(msp_code)s, %(msp_name)s) ON DUPLICATE KEY UPDATE msp_code = %(msp_code)s", dataRead)

            elif dataRead["type"] == "bed":
                self.Cursor.execute("INSERT INTO bed (bed_seq, bed_hsp_seq, bed_bdt_seq, bed_desc, bed_available) "
                                    "VALUES (%(bed_seq)s, %(bed_hsp_seq)s, %(bed_bdt_seq)s, %(bed_desc)s, %(bed_available)s) ON DUPLICATE KEY UPDATE bed_seq = %(bed_seq)s", dataRead)

            elif dataRead["type"] == "hsp_patient":
                self.Cursor.execute("INSERT INTO hsp_patient (hpt_seq, hpt_hsp_seq, hpt_id, hpt_bed_seq, hpt_in_date, hpt_out_date) "
                                    "VALUES (%(hpt_seq)s, %(hpt_hsp_seq)s, %(hpt_id)s, %(hpt_bed_seq)s, %(hpt_in_date)s, %(hpt_out_date)s) "
                                    "ON DUPLICATE KEY UPDATE hpt_seq = %(hpt_seq)s", dataRead)

            elif dataRead["type"] == "hsp_speciality":
                self.Cursor.execute("INSERT INTO hsp_speciality (hms_hsp_seq, hms_msp_code) "
                                    "VALUES (%(hms_hsp_seq)s, %(hms_msp_code)s) ON DUPLICATE KEY UPDATE hms_hsp_seq = %(hms_hsp_seq)s", dataRead)

            elif dataRead["type"] == "bed_type":
                self.Cursor.execute("INSERT INTO hsp_speciality (bdt_seq, bdt_desc) "
                                    "VALUES (%(bdt_seq)s, %(bdt_desc)s) ON DUPLICATE KEY UPDATE bdt_seq = %(bdt_seq)s", dataRead)

            self.DbConnection.commit()
        self.Cursor.close()
        self.DbConnection.close()


if __name__ == "__main__":
    #Lembrar sempre de inicializar as classes com os parâmetros que seram utilizados
    Consume = ConsumerKafka('hospital','stagiopbd','stagiopbd2019','stagiopbd') #instancia da classe ConsumerKafka
    Consume.ReadProcess.start()#Inicio a Thread que irá executar o método readMessage