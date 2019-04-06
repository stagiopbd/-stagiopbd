'use strict';


exports.post = (req, res, next) => {
    console.log(req.body)
    //console.log(res)
    res.send('seja bem vindo. ' + req.body.inputNome)
}; 

exports.get = (req, res, next) => {
    res.render('hospital', { title: 'Cadastro de Hospital' })
};