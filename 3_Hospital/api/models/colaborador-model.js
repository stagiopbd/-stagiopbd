const db = require("./dbConnection");

const colaborador = db.sequelize.define("collaborator", {
    col_cpf: { type: db.Sequelize.STRING, primaryKey: true,
        validate: {
			is: {
				args: /\d{3}\.\d{3}\.\d{3}\-\d{2}/,
				msg: 'CPF deve ser no formato 111.345.678-99'
            } }
        },
    col_name: {type: db.Sequelize.STRING,},
    col_gender: { type: db.Sequelize.CHAR },
	col_function_id: { type: db.Sequelize.INTEGER },
	col_hsp_id: { type: db.Sequelize.INTEGER }
});

module.exports = colaborador;
