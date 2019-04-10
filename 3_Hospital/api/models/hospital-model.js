const db = require("./dbConnection")

const hospital = db.sequelize.define("HOSPITAL", {
    hsp_id: { type: db.Sequelize.INTEGER, primaryKey: true },
    nome: {
		type: db.Sequelize.STRING,
		validate: {
			is: /[\x20-\xff]{10,100}/
		}
	},
    cnpj: {
		type: db.Sequelize.STRING,
		validate: {
			is: /\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}/
		}
	},
    endereco: {
		type: db.Sequelize.STRING,
		validate: {
			is: /[\x20-\xff]{10,200}/
		}
	},
    telefone: {
		type: db.Sequelize.STRING ,
		validate: {
			is: /\(\d{2}\)\s\d{4}\-\d{4}/
		}
	}
})

module.exports = hospital
