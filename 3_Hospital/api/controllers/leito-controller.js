'use strict';
var ala = require('../models/ala-model')
var hospital = require('../models/hospital-model')
var leito = require('../models/leito-model')
//http://docs.sequelizejs.com/manual/models-usage.html

/**
 * @api {post} /hospital/:hsp_id/ala 03-Inserir
 * @apiName exports.post
 * @apiGroup Leito
 * @apiDescription Insere informa&ccedil;&otilde;es de um leito no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de leitos do hospital selecionado.
 * @apiParam {String} inputName  Nome do Leito
 * @apiParam {Number} inputCpf  CPF do paciente que est&aacute; ocupando a Leito
 */
exports.post = (req, res, next) => {
    var me = req.body;
    leito.create({
        bed_desc: me.inputName,
        bed_pat_cpf: (me.inputCpf.length > 0?me.inputCpf:null ),
        bed_wng_id: req.params.wng_id
    }).then(function(leito) {
		res.redirect('/hospital/'+req.params.wng_hsp_id+'/ala/' + req.params.wng_id + '/leito')
	}).catch(function(err) {
		err.message = 'Leito nao pode ser cadastrada!';
		next(err)
	})
};

/**
 * @api {get} /hospital/:hsp_id/ala/:wng_id 01-Listar
 * @apiName exports.get
 * @apiGroup Leito
 * @apiDescription Retorna uma tabela HTML contendo os campos
 *
 * Para cada registro, al&eacute;m das informa&ccedil;&otilde;es especificadas abaixo, h&aacute; ainda <em>links</em> para edi&ccedil;&atilde; do respectivo registro.
 * @apiSuccess {Number} ID  Identificador &uacute;nico do Leito
 * @apiSuccess {String} Nome  Nome do Leito
 * @apiSuccess {String} Paciente (cpf) CPF do paciente
 */
exports.get = (req, res, next) => {
	leito.belongsTo(ala, {foreignKey: 'bed_wng_id'});
	leito.findAll({
		include: [{
			model: ala,
			required: true
		}],
		where: {bed_wng_id: req.params.wng_id}

	}).then(function (leito) {
		ala.findOne({where : {wng_id : req.params.wng_id}}).then(function (wng) {
			res.render('leito-lista', { title: 'Lista de Leitos', leito: leito, wng : wng})
		})
	});
};

/**
 * @api {get} /hospital/:hsp_id/ala/:wng_id/leito/new 02-Cadastrar
 * @apiName exports.cadastro
 * @apiGroup Leito
 * @apiDescription Disponibiliza um formul&aacute;rio HTML para o cadastro das seguintes informa&ccedil;&otilde;es de um leito.
 * @apiParam {String} inputName  Nome do Leito
 * @apiParam {String} inputCpf  CPF do paciente
 */
exports.new = (req, res, next) => {
	hospital.findOne({ where: {hsp_id: req.params.hsp_id} }).then(function (hsp) {
		ala.findOne({where : {wng_id: req.params.wng_id}}).then(function (wng) {
			res.render('leito-cadastro', { title: 'Cadastro de Leito', hsp: hsp, wng: wng })
		})
	})
};

/**
 * @api {post} /hospital/:hsp_id/ala/:wng_id/update/:id 04-Atualizar
 * @apiName exports.update
 * @apiGroup Leito
 * @apiDescription Atualiza informa&ccedil;&otilde;es de um leito no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de leitos da ala selecionada.
 * @apiParam {String} inputName  Nome do Leito
 * @apiParam {String} inputCpf  CPF do paciente
 */
exports.update =  (req, res, next) => {
    var me = req.body;
    leito.update(
        {
			bed_desc :  me.inputName,
	        bed_pat_cpf: me.inputCpf
        },
        {returning: true, where: {bed_id: req.params.id} }
    ).then(function(leito) {
  		res.redirect('/hospital/' + req.params.hsp_id + '/ala/' +req.params.wng_id + '/leito')
  	}).catch(function(err) {
		err.message = 'Leito nao pode ser alterado!';
  		next(err)
  	})
}
