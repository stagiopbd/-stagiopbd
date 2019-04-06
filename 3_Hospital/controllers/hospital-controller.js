'use strict';
var hospital = require('../models/hospital-model')

exports.post = (req, res, next) => {
    var me = req.body
    hospital.create({ 
        nome:      me.inputNome, 
        cnpj:      me.inputCnpj,
        endereco:  me.inputAddress,
        telefone:  me.inputAddress
    })
    //console.log(req.body)
    res.send('seja bem vindo. ' + req.body.inputPhone) 
}; 

exports.get = (req, res, next) => {
    res.render('hospital', { title: 'Cadastro de Hospital' })
};