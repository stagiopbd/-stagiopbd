from . import base_consumer
from db.database import Database as db
from consumer import Utils

class Medicines(base_consumer.BaseConsumer):
    def __init__(self):
        pass

    def consumeAll(self, messages):
        for message in messages:
            self.consume(message)

    def consume(self, message):
        m = Utils.jsonMessageToJson(message)
        tablename = m.pop("type")
        self.process(tablename, m)

    def process(self, tablename, message):
        sql, values = Utils.messageToInsertSQL(message, tablename)
        db.setData(sql)
