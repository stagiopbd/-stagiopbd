'use strict';
var colaborador = require('../models/colaborador-model')
var hospital = require('../models/hospital-model')
var situacao = require('../models/situacao-model')
var especialidade = require('../models/especialidade-model')
//http://docs.sequelizejs.com/manual/models-usage.html

/**
 * @api {post} /hospital/:hsp_id/colaborador 03-Inserir
 * @apiName exports.post
 * @apiGroup Colaborador
 * @apiDescription Insere informa&ccedil;&otilde;es de um colaborador no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de colaboradores do hospital selecionado.
 * @apiParam {String} inputName  Nome do Colaborador
 * @apiParam {Number} inputSpeciality  ID da Especialidade atendida na Ala
 */
exports.post = (req, res, next) => {
    var me = req.body;
    colaborador.create({
		col_cpf : me.inputCpf,
		col_name: me.inputName, 
		col_hsp_id : req.params.hsp_id,
		col_gender : me.inputGender,
		col_function_id : me.inputFunction
    }).then(function(colaborador) {
		res.redirect('/hospital/' + req.params.hsp_id + '/colaborador')
	}).catch(function(err) {
		console.log(me.inputCpf);
		err.message = 'Colaborador nao pode ser cadastrado ou já existe!	';
		next(err)
	})
};

/**
 * @api {get} /hospital/:hsp_id/colaborador 01-Listar
 * @apiName exports.get
 * @apiGroup Colaborador
 * @apiDescription Retorna uma tabela HTML contendo os campos
 *
 * Para cada registro, al&eacute;m das informa&ccedil;&otilde;es especificadas abaixo, h&aacute; ainda <em>links</em> para edi&ccedil;&atilde;o e remo&ccedil;&atilde;o do respectivo registro.
 * @apiSuccess {String} CPF  Identificador &uacute;nico do Colaborador(a)
 * @apiSuccess {String} Nome  Nome do Colaborador(a)
 * @apiSuccess {String} Hospital  Hospital onde o colaborador(a) está cadastrado
 * @apiSuccess {String} Função  Função exercida do Colaborador(a)
 */
exports.get = (req, res, next) => {
	colaborador.findAll({
		where: {col_hsp_id: req.params.hsp_id}
	}).then(function (colaborador) {
		console.log("Aqui");
		hospital.findOne({ where: {hsp_id: req.params.hsp_id} }).then(function (hsp) {
			res.render('colaborador-lista', { title: 'Lista de Colaboradores', colaborador: colaborador, hsp: hsp })
		})
	});
};

/**
 * @api {get} /hospital/:hsp_id/colaborador/colaboradorNew 02-Cadastrar
 * @apiName exports.cadastro
 * @apiGroup Colaborador
 * @apiDescription Disponibiliza um formul&aacute;rio HTML para o cadastro das seguintes informa&ccedil;&otilde;es de um colaborador(a).
 * @apiParam {String} inputName  Nome do Colaborador(a)
 * @apiParam {String} inputCpf  CPF do Colaborador(a)
 * @apiParam {Number} inputGender  Genero do Colaborador(a)
 * @apiParam {Number} inputFunction  Função do Colaborador(a)
 */
exports.new = (req, res, next) => {
	hospital.findOne({ where: {hsp_id: req.params.hsp_id} }).then(function (hsp) {
			res.render('colaborador-cadastro', { title: 'Cadastro de Colaborador', hsp: hsp })
	})
};

/**
 * @api {post} /hospital/:hsp_id/colaborador/update/:id 04-Atualizar
 * @apiName exports.update
 * @apiGroup Colaborador(a)
 * @apiDescription Atualiza informa&ccedil;&otilde;es de um colaborador no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de colaboradores do hospital selecionado.
 * @apiParam {String} inputName  Nome da Colaborador(a)
 * @apiParam {String} inputFunction  função do Colaborador(a)
 */
exports.update =  (req, res, next) => {
    var me = req.body;
    colaborador.update(
        {
			col_name: me.inputName,
	        col_function_id: me.inputFunction
        },
        {returning: true, where: {col_cpf: req.params.id} }
    ).then(function(colaborador) {
  		res.redirect('/hospital/' + req.params.hsp_id + '/colaborador')
  	}).catch(function(err) {
		err.message = 'Colaborador nao pode ser alterado!';
  		next(err)
  	})
}

/**
 * @api {get} /hospital/:hsp_id/colaborador/delete/:id 05-Desabilitar
 * @apiName exports.delete
 * @apiGroup Colaborador
 * @apiDescription Desabilita um colaborador no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de colaboradores do hospital selecionado.
 */
exports.delete = (req, res, next) => {
	colaborador.delete(
        {returning: true, where: {col_cpf: req.params.id} }
    ).then(function(colaborador) {
  		res.redirect('/hospital/' + req.params.hsp_id + '/colaborador')
  	}).catch(function(err) {
		err.message = 'Colaborador nao pode ser deletado!';
  		next(err)
  	})
}
