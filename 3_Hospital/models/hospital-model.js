const db = require("./dbConnection")

const hospital = db.sequelize.define("HOSPITAL", {
    hsp_id:     { type: db.Sequelize.INTEGER, primaryKey: true }, 
    nome:       { type: db.Sequelize.STRING }, 
    cnpj:       { type: db.Sequelize.STRING },
    endereco:   { type: db.Sequelize.STRING },
    telefone:   { type: db.Sequelize.STRING }
})

module.exports = hospital