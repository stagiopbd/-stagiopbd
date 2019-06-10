import schedule
import time
import mysql.connector

class ConexaoMySQL():
    
    def __init__(self):
        mysql.connector.connect()
        self.__mydb = mysql.connector.connect(
            host="35.237.186.164",
            port="3306",
            user="root",
            passwd="stagiopbd2019",
            database="stagiopbd",
            auth_plugin='mysql_native_password'
        )
    
    def getData(self, sql):
        mycursor = self.__mydb.cursor()
        mycursor.execute(sql)
        myresult = mycursor.fetchall()

        return myresult

    # def setData(self, sql, val):
    #     mycursor = self.__mydb.cursor()
    #     mycursor.execute(sql, val)
    #     self.__mydb.commit()
    #     print(mycursor.rowcount, "record inserted.")


class Email():
    def callSendEmailForPentaVaccine(self):
        con = ConexaoMySQL()
        result = con.getData("CALL send_email_for_penta_vaccine();")
        print("Vacina obrigatória para Penta!")
        print("Enviar email para os pacientes:")
        for r in result:
            print(r)

if __name__ == "__main__":
    # email = Email()
    # email.callSendEmailForPentaVaccine()

    def call():
        email = Email()
        email.callSendEmailForPentaVaccine()

    schedule.every().day.at("00:00").do(call)
    
    while True:
        schedule.run_pending() 
        time.sleep(1)