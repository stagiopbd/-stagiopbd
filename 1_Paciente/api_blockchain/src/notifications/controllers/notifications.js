var validator = require('../validators/notifications'),
    blockchain = require('../../services/blockchain'),
    influx = require('../../services/influxdb');

async function create_notification(req, res) {
    try {
        var errors = validator.validate_body(req)
        if (errors) {
            res.status(errors.status || 400);
            res.json({ message: errors, success: false })
        } else {
            console.log("* ENVIANDO AO BLOCKCHAIN")
            const response = await blockchain.post('stagiopbd.notification.NotificationParticipant', req.body)
            if (response && response.data) {
                console.log("** RESPOSTA COM SUCESSO DO BLOCKCHAIN")
                console.log("*** ENVIANDO AO INFLUXDB")
                req.body.notificationId = Number(req.body.notificationId)
                await influx.save("notifications", req.body)
                console.log("**** RESPOSTA COM SUCESSO DO INFLUXDB")
            }
            res.status(201);
            res.json({ message: "Notificação cadastrada com sucesso!", success: true })
        }
    } catch (error) {
        console.log(error)
        res.status(500);
        message = error.response.data.error.message || "Ocorreu um erro! Por favor tente novamente!"
        res.json({ message, success: false })
    }
}

module.exports.create_notification = create_notification