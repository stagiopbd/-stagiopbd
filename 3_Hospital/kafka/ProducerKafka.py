from kafka import KafkaProducer
from threading import Thread
import mysql.connector
import time
import json

class ProducerKafka(object):
    def __init__(self, Topic, User, Password, DataBaseName):
        self.Topic = Topic
        self.State = "function"

        self.DbConnection = mysql.connector.connect(user=User, password=Password, host='localhost', database=DataBaseName, auth_plugin='mysql_native_password')#Todo Verificar Fabio
        self.Cursor = self.DbConnection.cursor()
        self.ProduceProcess = Thread(target=self.runThread)

    def createProducer(self):
        producer = KafkaProducer(bootstrap_servers='35.237.186.164:9092', value_serializer=lambda v: json.dumps(v).encode('utf-8'))
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

        if TableName == "speciality":
            sql = "SELECT `speciality`.`spc_id`,`speciality`.`spc_desc` FROM `speciality`"

        elif TableName == "function":
            sql = "SELECT `function`.`func_id`,`function`.`func_descr` FROM `function`"

        elif TableName == "bed":
            sql = "SELECT `bed`.`bed_id`,`bed`.`bed_desc`,`bed`.`bed_wng_id`,`bed`.`bed_pat_cpf` FROM `bed`"

        elif TableName == "patient":
            sql = "SELECT `patient`.`pat_cpf`,`patient`.`pat_name`,`patient`.`pat_gender`,`patient`.`pat_blood_type`,`patient`.`pat_birthdate` FROM `patient`"

        elif TableName == "hospital":
            sql = "SELECT `hospital`.`hsp_id`,`hospital`.`hsp_cnpj`,`hospital`.`hsp_name`,`hospital`.`hsp_address`,`hospital`.`hsp_telephone`,`hospital`.`hsp_sit_id`,`hospital`.`hsp_create`,`hospital`.`hsp_update` FROM `hospital`"

        elif TableName == "situation":
            sql = "SELECT `situation`.`sit_id`,`situation`.`sit_desc` FROM `situation`"

        elif TableName == "wing":
            sql = "SELECT `wing`.`wng_id`,`wing`.`wng_desc`,`wing`.`wng_hsp_id`,`wing`.`wng_sit_id`,`wing`.`wng_spc_id` FROM `wing`"

        elif TableName == "collaborator":
            sql = "SELECT `collaborator`.`col_cpf`,`collaborator`.`col_name`,`collaborator`.`col_gender`,`collaborator`.`col_function_id`,`collaborator`.`col_hsp_id` FROM `collaborator`"

        receiveDBData = self.getData(sql)

        return receiveDBData

    def formatData(self, Table):
        msg = {}
        Data = self.getDBMessage(Table)

        if Table == "function":
            for x in Data:
                msg['type'] = 'function'
                msg['func_id'] = x[0]
                msg['func_descr'] = x[1]
                self.sendMessage(msg)

        elif Table == "wing":
            for x in Data:
                msg['type'] = 'wing'
                msg['wng_id'] = x[0]
                msg['wng_desc'] = x[1]
                msg['wng_hsp_id'] = x[2]
                msg['wng_sit_id'] = x[3]
                msg['wng_spc_id'] = x[4]
                self.sendMessage(msg)

        elif Table == "bed":
            for x in Data:
                msg['type'] = 'bed'
                msg['bed_id'] = x[0]
                msg['bed_desc'] = x[1]
                msg['bed_wng_id'] = x[2]
                msg['bed_pat_cpf'] = x[3]
                self.sendMessage(msg)

        elif Table == "patient":
            for x in Data:
                msg['type'] = 'patient'
                msg['pat_cpf'] = x[0]
                msg['pat_name'] = x[1]
                msg['pat_gender'] = x[2]
                msg['pat_blood_type'] = x[3]
                msg['pat_birthdate'] = str(x[4])
                self.sendMessage(msg)

        elif Table == "hospital":
            for x in Data:
                msg['type'] = 'hospital'
                msg['hsp_id'] = x[0]
                msg['hsp_cnpj'] = x[1]
                msg['hsp_name'] = x[2]
                msg['hsp_address'] = x[3]
                msg['hsp_telephone'] = x[4]
                msg['hsp_sit_id'] = x[5]
                msg['hsp_create'] = str(x[6])
                msg['hsp_update'] = str(x[7])
                self.sendMessage(msg)

        elif Table == "situation":
            for x in Data:
                msg['type'] = 'situation'
                msg['sit_id'] = x[0]
                msg['sit_desc'] = x[1]
                self.sendMessage(msg)

        elif Table == "speciality":
            for x in Data:
                msg['type'] = 'speciality'
                msg['spc_id'] = x[0]
                msg['spc_desc'] = x[1]
                self.sendMessage(msg)

        elif Table == "collaborator":
            for x in Data:
                msg['type'] = 'collaborator'
                msg['col_cpf'] = x[0]
                msg['col_name'] = x[1]
                msg['col_gender'] = x[2]
                msg['col_function_id'] = x[3]
                msg['col_hsp_id'] = x[4]
                self.sendMessage(msg)

    def machineState(self):

        if self.State == "function":
            print()
            self.formatData("function")
            self.State = "wing"

        elif self.State == "wing":
            self.formatData("wing")
            self.State = "bed"

        elif self.State == "bed":
            self.formatData("bed")
            self.State = "patient"

        elif self.State == "patient":
            self.formatData("patient")
            self.State = "hospital"

        elif self.State == "hospital":
            self.formatData("hospital")
            self.State = "situation"

        elif self.State == "situation":
            self.formatData("situation")
            self.State = "speciality"

        elif self.State == "speciality":
            self.formatData("speciality")
            self.State = "collaborator"

        elif self.State == "collaborator":
            self.formatData("collaborator")
            self.State = "function"


    def runThread(self):
        while True:
            self.machineState()
            time.sleep(120)#Thread executa o processo a cada 2 min

if __name__ == "__main__":
    #Lembrar sempre de inicializar as classes com os parÃ¢metros que seram utilizados
    producer = ProducerKafka('det-hospital','root','123','kiizj5q0n6quilvc')#Verificar fabio informaç?es banco

    producer.ProduceProcess.start()#Start da Thread do processo

