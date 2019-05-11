'use strict'

const express = require('express');
const router = express.Router({mergeParams: true});
const controller = require('../controllers/ala-controller')

module.exports = function(app) {
    router.get('/', controller.get);
    router.get('/New', controller.new);
    router.post('/', controller.post);
    router.post('/Update/:id', controller.update);
    router.get('/Delete/:id', controller.delete);
    return router;
};
