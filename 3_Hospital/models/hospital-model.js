const db = require("./dbConection")

const hospital = sequelize.define('postagens', {
    nome:       { type: db.Sequelize.STRING }, 
    cnpj:       { type: db.Sequelize.STRING },
    endereco:   { type: db.Sequelize.STRING },
    telefone:   { type: db.Sequelize.INT }
})

module.exports = hospital