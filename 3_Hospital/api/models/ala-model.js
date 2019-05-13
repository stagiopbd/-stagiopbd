const db = require("./dbConnection");

const ala = db.sequelize.define("wing", {
    wng_id: { type: db.Sequelize.INTEGER, primaryKey: true },
    wng_desc: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /[\x20-\xff]{5,45}/,
				msg: 'Ala deve conter entre 5 e 45 caracteres alfanumericos'
			}
		}
	},
	wng_hsp_id: { type: db.Sequelize.INTEGER },
	wng_sit_id: { type: db.Sequelize.INTEGER },
	wng_spc_id: { type: db.Sequelize.INTEGER }
});

module.exports = ala;
