import mysql.connector

class Database():
    def __init__(self):
        self.__mydb = mysql.connector.connect(
            host="localhost",
            user="VieiraDias",
            passwd="ita2019#",
            database="CE229",
            auth_plugin='mysql_native_password'
        )
    
    def getData(self, sql):
        mycursor = self.__mydb.cursor()
        mycursor.execute(sql)
        myresult = mycursor.fetchall()

        for x in myresult:
            print("matricula | name | entrada")
            print(x[0], "|", str(x[1]), "|", str(x[2]))
            return x[0], str(x[1]), str(x[2])

    def setData(self, sql, val=None):
        mycursor = self.__mydb.cursor()
        if val is not None:
            mycursor.execute(sql)
        else:
            mycursor.execute(sql, val)
        self.__mydb.commit()
        print(mycursor.rowcount, "record inserted.")