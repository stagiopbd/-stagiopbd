const db = require("./dbConnection");

const leito = db.sequelize.define("LEITO", {
    lei_id: { type: db.Sequelize.INTEGER, primaryKey: true },
    ala_id: { type: db.Sequelize.INTEGER },
    pac_id: { type: db.Sequelize.INTEGER },
    lei: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /[\x20-\xff]{5,45}/,
				msg: 'Ala deve conter entre 5 e 45 caracteres alfanumericos'
			}
		}
	}
});

module.exports = leito;
