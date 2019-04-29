const db = require("./dbConnection");

const especialidade = db.sequelize.define("ESPECIALIDADE", {
    esp_id: { type: db.Sequelize.INTEGER, primaryKey: true },
    esp_desc: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /[\x20-\xff]{5,45}/,
				msg: 'Especialidade deve conter entre 5 e 45 caracteres alfanumericos'
			}
		}
	}
});

module.exports = especialidade;
