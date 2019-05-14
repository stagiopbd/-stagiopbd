const db = require("./dbConnection");

const colaborador = db.sequelize.define("collaborator", {
    col_cpf: { type: db.Sequelize.STRING, primaryKey: true,
        validate: {
			is: {
				args: /\d{3}\.\d{3}\.\d{3}\-\d{2}/,
				msg: 'CPF deve ser no formato 111.345.678-99'
            },
			isCPF(value) {
				/* Creditos: https://www.geradorcpf.com/javascript-validar-cpf.htm */
					let cpf = value.replace(/[^\d]+/g,'');
					if(cpf.length != 11)
				        throw new Error('CPF com tamanho invalido!');
					// Elimina CPFs invalidos conhecidos
					if (cpf.length != 11 ||
						cpf == "00000000000" ||
						cpf == "11111111111" ||
						cpf == "22222222222" ||
						cpf == "33333333333" ||
						cpf == "44444444444" ||
						cpf == "55555555555" ||
						cpf == "66666666666" ||
						cpf == "77777777777" ||
						cpf == "88888888888" ||
						cpf == "99999999999")
						throw new Error('CPF com 11 digitos iguais invalido!');
					// Valida 1o digito
					add = 0;
					for (i=0; i < 9; i ++)
						add += parseInt(cpf.charAt(i)) * (10 - i);
					rev = 11 - (add % 11);
					if (rev == 10 || rev == 11)
						rev = 0;
					if (rev != parseInt(cpf.charAt(9)))
						throw new Error('CPF com primeiro digito verificador invalido!');
					// Valida 2o digito
					add = 0;
					for (i = 0; i < 10; i ++)
						add += parseInt(cpf.charAt(i)) * (11 - i);
					rev = 11 - (add % 11);
					if (rev == 10 || rev == 11)
						rev = 0;
					if (rev != parseInt(cpf.charAt(10)))
						throw new Error('CPF com segundo digito verificador invalido!');

			}
		}
    },
    col_name: {type: db.Sequelize.STRING,},
    col_gender: { type: db.Sequelize.CHAR },
	col_function_id: { type: db.Sequelize.INTEGER },
	col_hsp_id: { type: db.Sequelize.INTEGER }
});

module.exports = colaborador;
