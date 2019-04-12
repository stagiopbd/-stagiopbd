const express = require('express');
const router = express.Router();
const consultRouter = require('./consultation');
const patientRouter = require('./patient');
const physicianRouter = require('./physician');

router.use('/consultation', consultRouter);
router.use('/patient', patientRouter);
router.use('/physician', physicianRouter);

router.get('/ping', (req, res) => {
    res.status(200).end();
});

module.exports = router;
