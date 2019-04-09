 'use strict';
var hospital = require('../models/hospital-model')
//http://docs.sequelizejs.com/manual/models-usage.html

/**
 * @api {post} /hospital/ 03-Insercao
 * @apiName exports.post
 * @apiGroup Hospital
 * @apiDescription Insere informa&ccedil;&otilde;es de um hospital no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de hospitais.
 * @apiParam {String} Nome  Nome do Hospital
 * @apiParam {String} CNPJ  CNPJ do Hospital
 * @apiParam {String} Endereco  Endere&ccedil;o completo do Hospital
 * @apiParam {String} Telefone  Telefone do Hospital
 */
exports.post = (req, res, next) => {
    var me = req.body
    hospital.create({
        nome: me.inputNome,
        cnpj: me.inputCnpj,
        endereco: me.inputAddress,
        telefone: me.inputPhone
    })
    //console.log(req.body)
    //res.send('seja bem vindo. ' + req.body.inputPhone)
    res.redirect('/Hospital')
};

/**
 * @api {get} /hospital 01-Lista
 * @apiName exports.get
 * @apiGroup Hospital
 * @apiDescription Retorna uma tabela HTML contendo os campos
 *
 * Para cada registro, al&eacute;m das informa&ccedil;&otilde;es especificadas abaixo, h&aacute; ainda <em>links</em> para edi&ccedil;&atilde;o e remo&ccedil;&atilde;o do respectivo registro.
 * @apiSuccess {Number} ID  Identificador &uacute;nico do hospital
 * @apiSuccess {String} Nome  Nome do Hospital
 * @apiSuccess {String} CNPJ  CNPJ do Hospital
 * @apiSuccess {String} Endereco  Endere&ccedil;o completo do Hospital
 * @apiSuccess {String} Telefone  Telefone do Hospital
 */
exports.get = (req, res, next) => {
    hospital.findAll({ order: [['Nome', 'ASC']] }).then(function (hsp) {
        //console.log(hsp)
        res.render('hospital-lista', { title: 'Lista de Hospitais', hsp: hsp })
    })
    //res.render('hospital', { title: 'Cadastro de Hospital' })
};

/**
 * @api {get} /hospital/cadastro 02-Cadastro
 * @apiName exports.cadastro
 * @apiGroup Hospital
 * @apiDescription Disponibiliza um formul&aacute;rio HTML para o cadastro das seguintes informa&ccedil;&otilde;es de um hospital.
 * @apiSuccess {String} Nome  Nome do Hospital
 * @apiSuccess {String} CNPJ  CNPJ do Hospital
 * @apiSuccess {String} Endereco  Endere&ccedil;o completo do Hospital
 * @apiSuccess {String} Telefone  Telefone do Hospital
 */
exports.cadastro = (req, res, next) => {
    res.render('hospital-cadastro', { title: 'Cadastro de Hospital' })
};

/**
 * @api {post} /hospital/update/:id 04-Atualizacao
 * @apiName exports.update
 * @apiGroup Hospital
 * @apiDescription Atualiza informa&ccedil;&otilde;es de um hospital no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de hospitais.
 * @apiParam {String} Nome  Nome do Hospital
 * @apiParam {String} CNPJ  CNPJ do Hospital
 * @apiParam {String} Endereco  Endere&ccedil;o completo do Hospital
 * @apiParam {String} Telefone  Telefone do Hospital
 */
exports.update =  (req, res, next) => {
    var me = req.body;
    hospital.update(
        {
            nome: me.inputNome,
            cnpj: me.inputCnpj,
            endereco: me.inputAddress,
            telefone: me.inputPhone
        },
        {returning: true, where: {HSP_ID: req.params.id} }
      )
      .then(function() {
        res.redirect('/Hospital');
      })
}

/**
 * @api {get} /hospital/delete/:id 05-Remocao
 * @apiName exports.delete
 * @apiGroup Hospital
 * @apiDescription Remove um hospital do banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de hospitais.
 */
exports.delete = (req, res, next) => {
    hospital.destroy({ where: { HSP_ID: req.params.id } }
        , { truncate: true }).then(() => {
            res.redirect('/Hospital');

        })
}
