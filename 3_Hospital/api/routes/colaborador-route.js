'use strict'

const express = require('express');
const router = express.Router({mergeParams: true});
const controller = require('../controllers/colaborador-controller')

module.exports = function(app) {
    router.get('/', controller.get);
    router.get('/ColaboradorNew', controller.new);
    router.post('/', controller.post);
    router.post('/Update/:cpf', controller.update);
    // router.get('/Delete/:cpf', controller.delete);
    return router;
};
