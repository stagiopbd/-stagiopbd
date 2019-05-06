from kafka import KafkaConsumer

class Consumer():
    """Create a consumer to fetch messages in the topic.

    Arguments:
    - servers:
        ‘host[:port]’ string (or list of ‘host[:port]’ strings) that the
        consumer should contact to bootstrap initial cluster metadata
    """
    def __init__(self, servers):
        self.consumer = KafkaConsumer(bootstrap_servers=servers,
                                      auto_offset_reset='earliest')

    '''Fetch messages on the topic and send them to the callback, if informed'''
    def getMessages(self, topic, callback=None):
        messages = self.consumer.subscribe([topic])
        if callback is not None:
            return callback(messages)
        return messages
