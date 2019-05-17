from kafka import KafkaProducer
from threading import Thread
import mysql.connector
import time
import json

class ProducerKafka(object):
    def __init__(self, Topic, User, Password, DataBaseName):
        self.Topic = Topic
        self.State = "hsp_speciality"

        self.DbConnection = mysql.connector.connect(user=User, password=Password, host='localhost', database=DataBaseName, auth_plugin='mysql_native_password')
        self.Cursor = self.DbConnection.cursor()
        self.ProduceProcess = Thread(target=self.runThread)

    def createProducer(self):
        producer = KafkaProducer(bootstrap_servers='127.0.0.1:9092', value_serializer=lambda v: json.dumps(v).encode('utf-8'))
        return producer

    #Envia a mensagem para o topic do kafka
    def sendMessage(self, message):
        producer = self.createProducer()
        producer.send(self.Topic, message)
        producer.close()

    #Envio o comando sql para pegar os dados do banco
    def getData(self, sql):
        self.Cursor.execute(sql)
        returnData = self.Cursor.fetchall()
        return returnData


    def getDBMessage(self, TableName):
        sqlCommand = ''

        if TableName == "hsp_speciality":
            sql = "SELECT `hsp_speciality`.`hms_hsp_seq`,`hsp_speciality`.`hms_msp_code` FROM `stagiopbd`.`hsp_speciality`"

        elif TableName == "bed_type":
            sql = "SELECT `bed_type`.`bdt_seq`,`bed_type`.`bdt_desc` FROM `stagiopbd`.`bed_type`"

        elif TableName == "bed":
            sql = "SELECT `bed`.`bed_seq`,`bed`.`bed_hsp_seq`,`bed`.`bed_bdt_seq`,`bed`.`bed_desc`,`bed`.`bed_available` FROM `stagiopbd`.`bed`"

        elif TableName == "hsp_patient":
            sql = "SELECT `hsp_patient`.`hpt_seq`,`hsp_patient`.`hpt_hsp_seq`,`hsp_patient`.`hpt_id`,`hsp_patient`.`hpt_bed_seq`,`hsp_patient`.`hpt_in_date`,`hsp_patient`.`hpt_out_date` FROM `stagiopbd`.`hsp_patient`"

        elif TableName == "hospital":
            sql = "SELECT `hospital`.`hsp_seq`,`hospital`.`hsp_id`,`hospital`.`hsp_name`,`hospital`.`hsp_address`,`hospital`.`hsp_phone`,`hospital`.`hsp_stt_seq` FROM `stagiopbd`.`hospital`"

        elif TableName == "hospital_situation":
            sql = "SELECT `hospital_situation`.`stt_seq`,`hospital_situation`.`stt_desc` FROM `stagiopbd`.`hospital_situation`"

        elif TableName == "medical_speciality":
            sql = "SELECT `medical_speciality`.`msp_seq`,`medical_speciality`.`msp_desc` FROM `stagiopbd`.`medical_speciality`"

        elif TableName == "hsp_doctor":
            sql = "SELECT `hsp_doctor`.`hdc_seq`,`hsp_doctor`.`hdc_hsp_seq`,`hsp_doctor`.`hdc_id` FROM `stagiopbd`.`hsp_doctor`;"

        receiveDBData = self.getData(sql)

        return receiveDBData

    def formatData(self, Table):
        msg = {}
        Data = self.getDBMessage(Table)

        if Table == "hsp_speciality":
            for x in Data:
                msg['type'] = 'hsp_speciality'
                msg['hms_hsp_seq'] = x[0]
                msg['hms_msp_code'] = x[1]
                self.sendMessage(msg)

        elif Table == "bed_type":
            for x in Data:
                msg['type'] = 'bed_type'
                msg['bdt_seq'] = x[0]
                msg['bdt_desc'] = x[1]
                self.sendMessage(msg)

        elif Table == "bed":
            for x in Data:
                msg['type'] = 'bed'
                msg['bed_seq'] = x[0]
                msg['bed_hsp_seq'] = x[1]
                msg['bed_bdt_seq'] = x[2]
                msg['bed_desc'] = x[3]
                msg['bed_available'] = x[4]
                self.sendMessage(msg)

        elif Table == "hsp_patient":
            for x in Data:
                msg['type'] = 'hsp_patient'
                msg['hpt_seq'] = x[0]
                msg['hpt_hsp_seq'] = x[1]
                msg['hpt_id'] = x[2]
                msg['hpt_bed_seq'] = x[3]
                msg['hpt_in_date'] = x[4]
                msg['hpt_out_date'] = x[5]
                self.sendMessage(msg)

        elif Table == "hospital":
            for x in Data:
                msg['type'] = 'hospital'
                msg['hsp_seq'] = x[0]
                msg['hsp_id'] = x[1]
                msg['hsp_name'] = x[2]
                msg['hsp_address'] = x[3]
                msg['hsp_phone'] = x[4]
                msg['hsp_stt_seq'] = x[5]
                self.sendMessage(msg)

        elif Table == "hospital_situation":
            for x in Data:
                msg['type'] = 'hospital_situation'
                msg['hsp_seq'] = x[0]
                msg['hsp_id'] = x[1]
                self.sendMessage(msg)

        elif Table == "medical_speciality":
            for x in Data:
                msg['type'] = 'medical_speciality'
                msg['msp_code'] = x[0]
                msg['msp_name'] = x[1]
                self.sendMessage(msg)

        elif Table == "hsp_doctor":
            for x in Data:
                msg['type'] = 'hsp_doctor'
                msg['hdc_seq'] = x[0]
                msg['hdc_hsp_seq'] = x[1]
                msg['hdc_id'] = x[2]
                self.sendMessage(msg)

    def machineState(self):

        if self.State == "hsp_speciality":
            self.formatData("hsp_speciality")
            self.State = "bed_type"

        elif self.State == "bed_type":
            self.formatData("bed_type")
            self.State = "bed"

        elif self.State == "bed":
            self.formatData("bed")
            self.State = "hsp_patient"

        elif self.State == "hsp_patient":
            self.formatData("hsp_patient")
            self.State = "hospital"

        elif self.State == "hospital":
            self.formatData("hospital")
            self.State = "hospital_situation"

        elif self.State == "hospital_situation":
            self.formatData("hospital_situation")
            self.State = "medical_speciality"

        elif self.State == "medical_speciality":
            self.formatData("medical_speciality")
            self.State = "hsp_doctor"

        elif self.State == "hsp_doctor":
            self.formatData("hsp_doctor")
            self.State = "hsp_speciality"


    def runThread(self):
        while True:
            self.machineState()
            time.sleep(120)#Thread executa o processo a cada 2 min

if __name__ == "__main__":
    #Lembrar sempre de inicializar as classes com os parâmetros que seram utilizados
    producer = ProducerKafka('ts3topic','root','admin','stagiopbd')

    producer.ProduceProcess.start()#Start da Thread do processo

