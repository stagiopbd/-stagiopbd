import json
import mysql.connector
from kafka import KafkaProducer

class ConexaoMySQL():
    
    def __init__(self):
        mysql.connector.connect()
        self.__mydb = mysql.connector.connect(
            host="localhost",
            port="3306",
            user="root",
            passwd="stagiopbdmysql**",
            database="stagiopbd_dev",
            auth_plugin='mysql_native_password'
        )
    
    def getData(self, sql):
        mycursor = self.__mydb.cursor()
        mycursor.execute(sql)
        myresult = mycursor.fetchall()

        return myresult

class ProducerKafka():

    def connect(self):
        #instancia objeto KafkaProducer, informando que enviará um valor serializado em json.
        producer = KafkaProducer(bootstrap_servers='localhost:9092', value_serializer=lambda v: json.dumps(v).encode('utf-8'))
        return producer

    def setMessages(self, json):
        producer = self.connect()
        #producer.send(<nome do canal/tópico>, <msg>)
        producer.send("notificacao", json)
        producer.close()

    def formatNotification(self):
        con = ConexaoMySQL()
        sql = "SELECT * FROM notification WHERE datetime >= NOW() - INTERVAL 24 HOUR"
        lista = con.getData(sql)
        for x in lista:
            msg = {}
            msg['type'] = 'notification'
            msg['from'] = str(x[1]) 
            msg['to'] = str(x[2])
            msg['datetime'] = str(x[3])
            msg['title'] = str(x[4])
            msg['text'] = str(x[5])
            msg['protocol'] = str(x[6])
            self.setMessages(msg)
            print(msg)

if __name__ == "__main__":
    producer = ProducerKafka()
producer.formatNotification()
