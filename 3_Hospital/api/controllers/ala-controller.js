 'use strict';
var ala = require('../models/ala-model')
var hospital = require('../models/hospital-model')
var situacao = require('../models/situacao-model')
var especialidade = require('../models/especialidade-model')
//http://docs.sequelizejs.com/manual/models-usage.html

/**
 * @api {post} /hospital/:hsp_id/ala 03-Inserir
 * @apiName exports.post
 * @apiGroup Ala
 * @apiDescription Insere informa&ccedil;&otilde;es de um ala no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de alas do hospital selecionado.
 * @apiParam {String} inputName  Nome da Ala
 * @apiParam {Number} inputSpeciality  ID da Especialidade atendida na Ala
 */
exports.post = (req, res, next) => {
    var me = req.body;
    ala.create({
        wng_desc: me.inputName,
        wng_spc_id: me.inputSpeciality,
		wng_hsp_id: req.params.hsp_id,
        wng_sit_id: 1 //Ativo
    }).then(function(ala) {
		res.redirect('/hospital/' + req.params.hsp_id + '/ala')
	}).catch(function(err) {
		err.message = 'Ala nao pode ser cadastrada!';
		next(err)
	})
};

/**
 * @api {get} /hospital/:hsp_id/ala 01-Listar
 * @apiName exports.get
 * @apiGroup Ala
 * @apiDescription Retorna uma tabela HTML contendo os campos
 *
 * Para cada registro, al&eacute;m das informa&ccedil;&otilde;es especificadas abaixo, h&aacute; ainda <em>links</em> para edi&ccedil;&atilde;o e remo&ccedil;&atilde;o do respectivo registro.
 * @apiSuccess {Number} ID  Identificador &uacute;nico do ala
 * @apiSuccess {String} Nome  Nome da Ala
 * @apiSuccess {String} Especialidade  Especialidade atendida na Ala
 */
exports.get = (req, res, next) => {
	ala.belongsTo(situacao, {foreignKey: 'wng_sit_id'});
	ala.belongsTo(especialidade, {foreignKey: 'wng_spc_id'});

	ala.findAll({
		include: [{
			model: situacao,
			required: true
		}, {
			model: especialidade,
			required: true
	    }],
		where: {wng_hsp_id: req.params.hsp_id}
	}).then(function (ala) {
		hospital.findOne({ where: {hsp_id: req.params.hsp_id} }).then(function (hsp) {
			especialidade.findAll().then(function (spc) {
				situacao.findAll({ order: [['sit_id', 'ASC']] }).then(function (sit) {
					res.render('ala-lista', { title: 'Lista de Alas', ala: ala, sit: sit, hsp: hsp, spc: spc })
				})
			})
		})
	});
};

/**
 * @api {get} /hospital/:hsp_id/ala/new 02-Cadastrar
 * @apiName exports.cadastro
 * @apiGroup Ala
 * @apiDescription Disponibiliza um formul&aacute;rio HTML para o cadastro das seguintes informa&ccedil;&otilde;es de um ala.
 * @apiParam {String} inputName  Nome da Ala
 * @apiParam {String} inputSpeciality  Especialidade atendida na Ala
 */
exports.new = (req, res, next) => {
	hospital.findOne({ where: {hsp_id: req.params.hsp_id} }).then(function (hsp) {
		especialidade.findAll().then(function (spc) {
			res.render('ala-cadastro', { title: 'Cadastro de Ala', hsp: hsp, spc: spc })
		})
	})
};

/**
 * @api {post} /hospital/:hsp_id/ala/update/:id 04-Atualizar
 * @apiName exports.update
 * @apiGroup Ala
 * @apiDescription Atualiza informa&ccedil;&otilde;es de um ala no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de alas do hospital selecionado.
 * @apiParam {String} inputName  Nome da Ala
 * @apiParam {String} inputSpeciality  Especialidade atendida na Ala
 * @apiParam {Number} inputSituation  ID da Situacao da Ala
 */
exports.update =  (req, res, next) => {
    var me = req.body;
    ala.update(
        {
			wng_desc: me.inputName,
	        wng_spc_id: me.inputSpeciality,
	        wng_sit_id: me.inputSituation
        },
        {returning: true, where: {wng_id: req.params.id} }
    ).then(function(ala) {
  		res.redirect('/hospital/' + req.params.hsp_id + '/ala')
  	}).catch(function(err) {
		err.message = 'Ala nao pode ser alterada!';
  		next(err)
  	})
}

/**
 * @api {get} /hospital/:hsp_id/ala/delete/:id 05-Desabilitar
 * @apiName exports.delete
 * @apiGroup Ala
 * @apiDescription Desabilita um ala no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de alas do hospital selecionado.
 */
exports.delete = (req, res, next) => {
	ala.update(
        {
            wng_sit_id: 2
        },
        {returning: true, where: {wng_id: req.params.id} }
    ).then(function(ala) {
  		res.redirect('/hospital/' + req.params.hsp_id + '/ala')
  	}).catch(function(err) {
		err.message = 'Ala nao pode ser alterada!';
  		next(err)
  	})
}
