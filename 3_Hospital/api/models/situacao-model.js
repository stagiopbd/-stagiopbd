const db = require("./dbConnection");

const situacao = db.sequelize.define("SITUACAO", {
	sit_id: { type: db.Sequelize.INTEGER, primaryKey: true },
    sit_desc: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /[\x20-\xff]{5,45}/,
				msg: 'Situacao deve conter entre 5 e 45 caracteres alfanumericos'
			}
		}
	}
});

module.exports = situacao;
