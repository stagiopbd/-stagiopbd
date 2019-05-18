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
        consumer.subscribe(['det-fornecedor'])
        for message in consumer: 
            message = json.loads(message.value)
            if message['type'] == 'medicine':
                self.saveMedicine(message)

    def saveMedicine(self, msg):
        print(msg)
        #self.__con.setData(sql)


if __name__ == "__main__":
    consumer = ConsumerKafka()
    consumer.getMessages()