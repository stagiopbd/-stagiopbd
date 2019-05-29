var express = require('express'),
    router = express.Router(),
    bodyParser = require('body-parser'),
    urlencodedParser = bodyParser.urlencoded({ extended: false }),
    controller = require('./../controllers/notifications');

router.post('/', urlencodedParser, function (req, res) {
    controller.create_notification(req, res)
});

router.get('/', urlencodedParser, function (req, res) {
    res.status(500);
    res.json({ message: "Endpoint sem implementação!", success: false })
});

module.exports = router;
