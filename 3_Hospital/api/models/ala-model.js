const db = require("./dbConnection");

const ala = db.sequelize.define("ALA", {
    ala_id: { type: db.Sequelize.INTEGER, primaryKey: true },
    hsp_id: { type: db.Sequelize.INTEGER },
    sit_id: { type: db.Sequelize.INTEGER },
    esp_id: { type: db.Sequelize.INTEGER },
    ala_tipo: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /[\x20-\xff]{5,45}/,
				msg: 'Ala deve conter entre 5 e 45 caracteres alfanumericos'
			}
		}
	}
});

module.exports = ala;
