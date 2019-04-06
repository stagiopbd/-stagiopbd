//bibliotecas principais
const express = require('express');
const app = express(); //cria e configura a aplicacao
const handlebars = require("express-handlebars")
const bodyParser = require('body-parser')

//Outras bibliotecas
var createError = require('http-errors');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');

//configuracoes gerais
  // view engine setup
  app.engine("handlebars", handlebars({defaultLayout: "main"}))
  app.set('view engine', 'handlebars');

  // body Parser
  app.use(bodyParser.urlencoded({extended: false})) //para codificar as urls
  app.use(bodyParser.json()) //todo conteudo deve convertido para json


//configuracao de Rotas
  app.use('/', require('./routes/index-route')(app));
  app.use('/hospital', require('./routes/hospital-route')(app));


app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));


// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

module.exports = app;
