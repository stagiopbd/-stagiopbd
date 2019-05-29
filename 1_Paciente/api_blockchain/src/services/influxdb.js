// sudo docker run -d -p 8086:8086 influxdb
// influx -host 35.222.210.138 -username stagiopbd -password stagiopbd@2019 -database stagiopbd

const Influx = require('influx'),
    host = process.env.INFLUX_HOST || '35.222.210.138',
    port = Number(process.env.INFLUX_PORT) || 8087,
    username = process.env.INFLUX_USERNAME || 'stagiopbd',
    password = process.env.INFLUX_PASSWORD || 'stagiopbd@2019',
    db_name = process.env.INFLUX_DB_NAME || 'stagiopbd',

    influx_url = `http://${username}:${password}@${host}:${port}/${db_name}`;

console.log(influx_url)

const influx = new Influx.InfluxDB(influx_url)

async function save(measurement, data, datetime) {
    return influx.writePoints([
        {
            measurement: measurement,
            fields: data,
            timestamp: datetime.getTime(),
        }
    ], {
            database: db_name
        })

}

module.exports.save = save
