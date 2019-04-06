'use strict' 

const express = require('express');
const router = express.Router();
const controller = require('../controllers/hospital-controller')

module.exports = function(app) {
    router.get('/', controller.get);
    router.get('/hospital/:id', controller.getOne)
    router.get('/Cadastro', controller.cadastro);
    router.post('/', controller.post);
    // router.put('/:id', controller.put);
	// router.delete('/', controller.delete);
    return router;
};
