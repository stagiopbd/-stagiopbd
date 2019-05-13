const db = require("./dbConnection");

const leito = db.sequelize.define("bed", {
    bed_id: { type: db.Sequelize.INTEGER, primaryKey: true },
    bed_desc: {
		type: db.Sequelize.STRING,
		validate: {
			is: {
				args: /[\x20-\xff]{5,45}/,
				msg: 'Leito deve conter entre 5 e 45 caracteres alfanumericos'
			}
		}
	},
	bed_wng_id: { type: db.Sequelize.INTEGER },
	bed_pat_cpf: { type: db.Sequelize.INTEGER }
});

module.exports = leito;
