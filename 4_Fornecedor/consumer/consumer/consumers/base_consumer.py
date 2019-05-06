import abc

class BaseConsumer(abc.ABC):
    @abc.abstractmethod
    def consumeAll(self, messages):
        pass

    @abc.abstractmethod
    def consume(self, message):
        pass

    @abc.abstractmethod
    def process(self, tablename, message):
        pass