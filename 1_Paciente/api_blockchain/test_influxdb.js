const Influx = require('influx')


const host = '35.222.210.138'
const port = 8086
const username = 'stagiopbd'
const password = 'stagiopbd@2019'
const db_name = 'stagiopbd'


const influx = new Influx.InfluxDB(`http://${username}:${password}@${host}:${port}/${db_name}`)

influx.writePoints(
    [
        {
            measurement: 'notifications',
            tags: { "user": "stagiopbd" },
            fields: {
                "notificationId": Number('4481'),
                "type": "notificacao",
                "from": "hospital",
                "to": "patient",
                "datetime": "2019-05-29T20:20",
                "title": "ok",
                "text": "ok",
                "protocol": "extra"
            },
            timestamp: Math.floor(Date.now() / 1000),
        }
    ],
    {
        database: db_name
    }
)

