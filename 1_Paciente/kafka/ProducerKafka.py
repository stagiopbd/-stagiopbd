#Pre-requisites:
#install python 3.x
#install apache kafka: https://www.digitalocean.com/community/tutorials/how-to-install-apache-kafka-on-centos-7
#on command prompt, set: pip install kafka-python
    #This add Kafka at Python Enviroment.
import json
import mysql.connector
from kafka import KafkaProducer

class ConexaoMySQL():
    
    def __init__(self):
        mysql.connector.connect()
        self.__mydb = mysql.connector.connect(
            host="35.237.186.164",
            port="3306",
            user="paciente",
            passwd="paciente#123",
            database="paciente",
            auth_plugin='mysql_native_password'
        )
    
    def getData(self, sql):
        mycursor = self.__mydb.cursor()
        mycursor.execute(sql)
        myresult = mycursor.fetchall()

        return myresult

    def setData(self, sql, val):
        mycursor = self.__mydb.cursor()
        mycursor.execute(sql, val)
        self.__mydb.commit()
        print(mycursor.rowcount, "record inserted.")
    
class ProducerKafka():

    def connect(self):
        #instancia objeto KafkaProducer, informando que enviará um valor serializado em json.
        producer = KafkaProducer(bootstrap_servers='35.237.186.164:9092', value_serializer=lambda v: json.dumps(v).encode('utf-8'))
        return producer

    def setMessages(self, json):
        producer = self.connect()
        #producer.send(<nome do canal/tópico>, <msg>)
        producer.send("det-paciente", json)
        producer.close()

    def formatPatient(self):
        con = ConexaoMySQL()
        sql = "SELECT * FROM paciente"
        lista = con.getData(sql)
        for x in lista:
            msg = {}
            msg['type'] = 'patient'
            msg['pat_cpf'] = str(x[0]) 
            msg['pat_name'] = str(x[1])
            msg['pat_birthdate'] = str(x[2])
            msg['pat_gender'] = str(x[3])
            msg['pat_bloodtype'] = str(x[4])
            msg['pat_email'] = str(x[6])
            self.setMessages(msg)
            print(msg)


    def formatAllergy(self):
        con = ConexaoMySQL()
        sql = "SELECT * FROM alergia"
        lista = con.getData(sql)
        for x in lista:
            msg = {}
            msg['type'] = 'allergy'
            msg['alg_id'] = x[0]
            msg['alg_med_active_principle'] = x[1]
            msg['alg_description'] = x[2]
            msg['alg_classification'] = x[3]

        self.setMessages(msg)

    #tabela feita com estrutura diferente da modelada
    def formatPatientHasAllergy(self):
        con = ConexaoMySQL()
        sql = "SELECT * FROM paciente_tem_alergia"
        lista = con.getData(sql)
        for x in lista:
            msg = {}
            msg['type'] = 'patient_has_allergy'
            msg['pat_cpf'] = x[2]
            msg['alg_id'] = x[1]
            msg['dgn_id'] = x[0]
            #msg['date'] = x[3]

        self.setMessages(msg)

    #tabela feita com estrutura diferente da modelada
    def formatPatientHealth(self):
        con = ConexaoMySQL()
        sql = "SELECT * FROM quadro_clinico"
        lista = con.getData(sql)
        for x in lista:
            msg = {}
            msg['type'] = 'patient_health'
            msg['phl_pat_cpf'] = x[2]
            msg['phl_weight'] = x[1]
            msg['phl_height'] = x[1]
            msg['phl_imc'] = x[1]
            msg['phl_smokeoften'] = x[1]
            msg['phl_drinkoften'] = x[1]
            msg['phl_trainingoften'] = x[1]
            #msg['date'] = x[3]

        self.setMessages(msg)


if __name__ == "__main__":
    producer = ProducerKafka()
    producer.formatPatient()