const Influx = require('influx')


const host = '35.193.151.136'
const port = 8087
const username = 'stagiopbd'
const password = 'stagiopbd@2019'
const db_name = 'stagiopbd'


const influx = new Influx.InfluxDB(`http://${username}:${password}@${host}:${port}/${db_name}`)

old_datetime = "28/05/2019 19:17:00"
datetime = new Date(old_datetime.replace(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2}):(\d{2})/, "$2/$1/$3 $4:$5:$6"))

influx.writePoints(
    [
        {
            measurement: 'test_notifications',
            tags: { "user": "stagiopbd" },
            fields: {
                "notificationId": Number('11'),
                "type": "notificacao",
                "from": "hospital",
                "to": "patient",
                "datetime": old_datetime,
                "title": "ok",
                "text": "ok",
                "protocol": "extra"
            },
            timestamp: datetime,
        }
    ],
    {
        database: db_name
    }
)

