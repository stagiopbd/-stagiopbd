const Sequelize = require('sequelize')

//conexao com banco
const sequelize = new Sequelize('kiizj5q0n6quilvc', 'u8m691gex60b7dqt', 'cq4m4jg54uwbnm9d', { 
    host: "fnx6frzmhxw45qcb.cbetxkdyhwsb.us-east-1.rds.amazonaws.com",
    dialect: 'mysql' 
}) 

sequelize.authenticate().then(function (){
    console.log("Conectado com sucesso no banco MySQL JawsDB!")
}).catch(function (erro){
    console.log("Falha ao se conectar: " + erro)
})

module.exports = {
    Sequelize:Sequelize,
    sequelize:sequelize
}