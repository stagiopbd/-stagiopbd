var mysql = require('mysql');

module.exports=function(){
  return connection = mysql.createConnection({
    host     : '35.237.186.164',
    user     : 'root',
    password : 'stagiopbd2019',
    database : 'stagiopbd'
  });
  
};

