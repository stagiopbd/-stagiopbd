'use strict';
var hospital = require('../models/hospital-model')
//http://docs.sequelizejs.com/manual/models-usage.html

exports.post = (req, res, next) => {
    var me = req.body
    hospital.create({ 
        nome:      me.inputNome, 
        cnpj:      me.inputCnpj,
        endereco:  me.inputAddress,
        telefone:  me.inputAddress
    })
    //console.log(req.body)
    //res.send('seja bem vindo. ' + req.body.inputPhone) 
    res.redirect('/Hospital')
}; 

exports.get = (req, res, next) => {
    hospital.findAll({order : [['Nome', 'ASC']]}).then(function(hsp){
        //console.log(hsp)
        res.render('hospital-lista', { title: 'Lista de Hospitais', hsp: hsp })
    })
    //res.render('hospital', { title: 'Cadastro de Hospital' })
};

exports.cadastro = (req, res, next) => {
    res.render('hospital-cadastro', { title: 'Cadastro de Hospital' })
};