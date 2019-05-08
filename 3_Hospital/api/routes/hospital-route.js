'use strict'

const express = require('express');
const router = express.Router();
const controller = require('../controllers/hospital-controller')

module.exports = function(app) {
    router.get('/', controller.get);
    router.get('/New', controller.new);
    router.post('/', controller.post);
    router.post('/Update/edit/:id', controller.update);
    router.get('/Delete/:id', controller.delete);
    return router;
};
