const db = require("./dbConnection")

const hospital = db.sequelize.define("HOSPITAL", {
    hsp_id: { type: db.Sequelize.INTEGER, primaryKey: true },
    nome: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /[\x20-\xff]{10,100}/,
				msg: 'Nome do Hospital deve conter entre 10 e 100 caracteres alfanumericos'
			}
		}
	},
    cnpj: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}/,
				msg: 'CNPJ deve ser no formato 12.345.678/9999-00'
			},
			isCNPJ(value) {
				/* Creditos: http://araujo.cc/blog/funcao-javascript-para-validar-cnpj.html */
			    var b = [6,5,4,3,2,9,8,7,6,5,4,3,2];

			    if((c = value.replace(/[^\d]/g,"")).length != 14)
			        throw new Error('CNPJ com tamanho invalido!');

			    if(/0{14}/.test(c))
			        throw new Error('CNPJ com 14 zeros invalido!');

			    for (var i = 0, n = 0; i < 12; n += c[i] * b[++i]);
			    if(c[12] != (((n %= 11) < 2) ? 0 : 11 - n))
			        throw new Error('CNPJ com primeiro digito verificador invalido!');

			    for (var i = 0, n = 0; i <= 12; n += c[i] * b[i++]);
			    if(c[13] != (((n %= 11) < 2) ? 0 : 11 - n))
			        throw new Error('CNPJ com segundo digito verificador invalido!');
			}
		}
	},
    endereco: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /[\x20-\xff]{10,200}/,
				msg: 'Endereco do Hospital deve conter entre 10 e 200 caracteres alfanumericos'
			}
		}
	},
    telefone: {
		type: db.Sequelize.STRING ,
		validate: {
			is: {
				args: /\(\d{2}\)\s\d{4}\-\d{4}/,
				msg: 'Telefone deve ser no formato (12) 3456-7890'
			}
		}
	}
})

module.exports = hospital
