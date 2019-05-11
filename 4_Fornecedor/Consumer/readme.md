

## Find where kafka scripts are located
Input:
```
find . -name "*kafka*.sh"
```

Output:
```
./usr/bin/start-kafka.sh
./opt/kafka_2.11-2.0.0/bin/kafka-producer-perf-test.sh
./opt/kafka_2.11-2.0.0/bin/kafka-console-consumer.sh
./opt/kafka_2.11-2.0.0/bin/kafka-preferred-replica-election.sh
./opt/kafka_2.11-2.0.0/bin/kafka-delegation-tokens.sh
./opt/kafka_2.11-2.0.0/bin/kafka-consumer-perf-test.sh
./opt/kafka_2.11-2.0.0/bin/kafka-mirror-maker.sh
./opt/kafka_2.11-2.0.0/bin/kafka-verifiable-consumer.sh
./opt/kafka_2.11-2.0.0/bin/kafka-reassign-partitions.sh
./opt/kafka_2.11-2.0.0/bin/kafka-configs.sh
./opt/kafka_2.11-2.0.0/bin/kafka-server-stop.sh
./opt/kafka_2.11-2.0.0/bin/kafka-server-start.sh
./opt/kafka_2.11-2.0.0/bin/kafka-delete-records.sh
./opt/kafka_2.11-2.0.0/bin/kafka-run-class.sh
./opt/kafka_2.11-2.0.0/bin/kafka-topics.sh
./opt/kafka_2.11-2.0.0/bin/kafka-streams-application-reset.sh
./opt/kafka_2.11-2.0.0/bin/kafka-broker-api-versions.sh
./opt/kafka_2.11-2.0.0/bin/kafka-consumer-groups.sh
./opt/kafka_2.11-2.0.0/bin/kafka-log-dirs.sh
./opt/kafka_2.11-2.0.0/bin/kafka-verifiable-producer.sh
./opt/kafka_2.11-2.0.0/bin/kafka-replica-verification.sh
./opt/kafka_2.11-2.0.0/bin/kafka-acls.sh
./opt/kafka_2.11-2.0.0/bin/kafka-console-producer.sh
./opt/kafka_2.11-2.0.0/bin/kafka-dump-log.sh
```

## List topics
Input:
```
./opt/kafka_2.11-2.0.0/bin/kafka-topics.sh \
        --list \
        --zookeeper zookeeper
```

Output:
```
__consumer_offsets
det-fornecedor
det-fornecedor-0
```

## Show messages
Input:
```
./opt/kafka_2.11-2.0.0/bin/kafka-console-consumer.sh \
        --bootstrap-server localhost:9092 \
        --topic det-fornecedor \
        --max-messages 5
```

Output:
```
```
