 'use strict';
var especialidade = require('../models/especialidade-model')
//http://docs.sequelizejs.com/manual/models-usage.html

/**
 * @api {post} /especialidade/ 03-Insercao
 * @apiName exports.post
 * @apiGroup Especialidade
 * @apiDescription Insere informa&ccedil;&otilde;es de um especialidade no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de especialidades.
 * @apiParam {String} inputDesc  Descri&ccedil;&atilde;o da Especialidade
 */
exports.post = (req, res, next) => {
    var me = req.body;
    especialidade.create({
        esp_desc: me.inputDesc
    }).then(function(esp) {
		res.redirect('/Especialidade')
	}).catch(function(err) {
		err.message = 'Especialidade nao pode ser cadastrada!';
		next(err)
	})
};

/**
 * @api {get} /especialidade 01-Lista
 * @apiName exports.get
 * @apiGroup Especialidade
 * @apiDescription Retorna uma tabela HTML contendo os campos
 *
 * Para cada registro, al&eacute;m das informa&ccedil;&otilde;es especificadas abaixo, h&aacute; ainda <em>links</em> para edi&ccedil;&atilde;o e remo&ccedil;&atilde;o do respectivo registro.
 * @apiSuccess {Number} ID  Identificador &uacute;nico do especialidade
 * @apiSuccess {String} Descricao  Descri&ccedil;&atilde;o da Especialidade
 */
exports.get = (req, res, next) => {
    especialidade.findAll({ order: [['esp_desc', 'ASC']] }).then(function (esp) {
		res.render('especialidade-lista', { title: 'Lista de Especialidades', esp: esp })
    })
};

/**
 * @api {get} /especialidade/cadastro 02-Cadastro
 * @apiName exports.cadastro
 * @apiGroup Especialidade
 * @apiDescription Disponibiliza um formul&aacute;rio HTML para o cadastro das seguintes informa&ccedil;&otilde;es de um especialidade.
 * @apiSuccess {String} Descricao  Descri&ccedil;&atilde;o da Especialidade
 */
exports.cadastro = (req, res, next) => {
    res.render('especialidade-cadastro', { title: 'Cadastro de Especialidade' })
};

/**
 * @api {post} /especialidade/update/edit/:id 04-Atualizacao
 * @apiName exports.update
 * @apiGroup Especialidade
 * @apiDescription Atualiza informa&ccedil;&otilde;es de um especialidade no banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de especialidades.
 * @apiParam {String} inputDesc  Descri&ccedil;&atilde;o da Especialidade
 */
exports.update =  (req, res, next) => {
    var me = req.body;
    especialidade.update(
        {
            esp_desc: me.inputDesc
        },
        {returning: true, where: {ESP_ID: req.params.id} }
    ).then(function(esp) {
  		res.redirect('/Especialidade')
  	}).catch(function(err) {
		err.message = 'Especialidade nao pode ser alterada!';
  		next(err)
  	})
}

/**
 * @api {get} /especialidade/delete/:id 05-Remocao
 * @apiName exports.delete
 * @apiGroup Especialidade
 * @apiDescription Remove um especialidade do banco de dados.
 * Em caso de sucesso, redirecionao o usu&aacute;rio &agrave; lista de especialidades.
 */
exports.delete = (req, res, next) => {
    especialidade.destroy({ where: { ESP_ID: req.params.id } }, { truncate: true }
	).then(function() {
  		res.redirect('/Especialidade')
  	}).catch(function(err) {
		err.message = 'Especialidade nao pode ser removida!';
  		next(err)
  	})
}
