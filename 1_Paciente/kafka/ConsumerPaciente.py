#Pre-requisites:
#install python 3.x
#install apache kafka: https://www.digitalocean.com/community/tutorials/how-to-install-apache-kafka-on-centos-7
#on command prompt, set: pip install kafka-python
    #This add Kafka at Python Enviroment.

import json
import mysql.connector
from kafka import KafkaConsumer

class ConexaoMySQL():
    
    def __init__(self):
        mysql.connector.connect()
        self.__mydb = mysql.connector.connect(
            host="35.237.186.164",
            port="3306",
            user="root",
            passwd="stagiopbd2019",
            database="stagiopbd",
            auth_plugin="mysql_native_password"
        )
    
    def getData(self, sql):
        mycursor = self.__mydb.cursor()
        mycursor.execute(sql)
        myresult = mycursor.fetchall()

        return myresult

    def setData(self, sql):
        mycursor = self.__mydb.cursor()
        mycursor.execute(sql)
        self.__mydb.commit()
        #print(mycursor.rowcount, "record inserted.")

class ConsumerKafka():
    
    def connect(self):
        self.__con = ConexaoMySQL()
        consumer = KafkaConsumer(bootstrap_servers='35.237.186.164:9092', auto_offset_reset='earliest')
        return consumer

    def getMessages(self):
        consumer = self.connect()
        #consumer.subscribe([<nome do canal/tópico>])
        consumer.subscribe(['det-paciente'])
        for message in consumer:

            message = json.loads(message.value)
            if message['type'] == "patient":
                self.savePatient(message)

    def savePatient(self, msg):
        pat_cpf = str(msg['pat_cpf'])
        pat_name = str(msg['pat_name'])
        pat_birthdate = str(msg['pat_birthdate'])
        pat_gender = str(msg['pat_gender'])
        pat_bloodtype = str(msg['pat_bloodtype'])
        pat_email = str(msg['pat_email'])
        sql = "INSERT INTO patient(pat_cpf, pat_name, pat_gender, pat_bloodtype, pat_birthdate, pat_email) VALUES(\'"+pat_cpf+"', \'"+pat_name+"', \'"+pat_gender+"', \'"+pat_bloodtype+"', \'"+pat_birthdate+"', \'"+pat_email+"')"
        self.__con.setData(sql)

if __name__ == "__main__":
    consumer = ConsumerKafka()
    consumer.getMessages()