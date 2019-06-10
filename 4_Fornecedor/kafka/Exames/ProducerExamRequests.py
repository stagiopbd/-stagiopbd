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
        #instancia objeto KafkaProducer, informando que enviara um valor serializado em json.
        producer = KafkaProducer(bootstrap_servers='localhost:9092', value_serializer=lambda v: json.dumps(v).encode('utf-8'))
        return producer

    def setMessages(self, json):
        producer = self.connect()
        #producer.send(<nome do canal/topico>, <msg>)
        producer.send("det-fornecedor", json)
        producer.close()

    def formatNotification(self):
        con = ConexaoMySQL()
        sql = "SELECT * FROM exam_request_source LIMIT 132"
        lista = con.getData(sql)
        for x in lista:
            msg = {}
            msg['type'] = 'exam_request_destiny'
            msg['exr_id'] = str(x[0]) 
            msg['exr_pat_cpf'] = str(x[1])
            msg['exr_phy_cpf'] = str(x[2])
            msg['ext_hsp_seq'] = str(x[3])
            msg['exr_sup_id'] = str(x[4])
            msg['exr_date_request'] = str(x[5])
            msg['exr_date_forecast_release'] = str(x[6])
            msg['exr_date_delivery'] = str(x[7])
            msg['exr_urgency'] = str(x[8])
            msg['exr_result'] = str(x[9])
            self.setMessages(msg)
            print(msg)

if __name__ == "__main__":
    producer = ProducerKafka()
producer.formatNotification()
