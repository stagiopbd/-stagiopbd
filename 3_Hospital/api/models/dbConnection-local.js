const Sequelize = require('sequelize')

//conexao LOCAL com banco
const sequelize = new Sequelize('stagiop', 'nodeuser', 'node1234', {
    host: "localhost",
    dialect: 'mysql' ,
    define: {
		createdAt: false,
		updatedAt: false,
        //prevent sequelize from pluralizing table names
        freezeTableName: true //http://docs.sequelizejs.com/manual/models-definition.html#configuration
    }
})

sequelize.authenticate().then(function (){
    console.log("Conectado com sucesso no banco MySQL em localhost!")
}).catch(function (erro){
    console.log("Falha ao se conectar: " + erro)
})

module.exports = {
    Sequelize:Sequelize,
    sequelize:sequelize
}