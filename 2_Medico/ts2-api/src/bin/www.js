/**
 * Load Environment Variables
 */
require('dotenv').config();
require('@babel/polyfill');
const { createConnection, getConnectionOptions } = require('typeorm');
const { MongoClient } = require('mongodb');
const { host, port, env } = require('../config/api.config');
const mongoConfig = require('../config/mongo.config');
const app = require('../app');
const http = require('http');
const { getLogger } = require('../services/logger.service');

/**
 * Configure API Logger
 */
const logger = getLogger('api');

/**
 * Gracefully shutdown the process
 */
process.on('uncaughtException', () => {
  try {
    server.close();
  } catch (error) {
    throw error;
  }
});

process.on('SIGTERM', () => {
  try {
    app.locals.mysqlDb.close();
    server.close();
  } catch (error) {
    throw error;
  }
});

/**
 * Create MySQL Database Connection Pool
 */
createConnection()
  .then(async connection => {
    const { type, host, port, database } = await getConnectionOptions();
    logger.info(`connected to database instance ${type}://${host}:${port}/${database}`);
    app.locals.mysqlDb = connection;
  })
  .catch(error => {
    logger.error(error);
    throw error;
  });

/**
 *  Create MongoDB Connection Pool
 */
const mongoClient = new MongoClient(mongoConfig.getURI(), { useNewUrlParser: true });
mongoClient.connect((error, client) => {
  if (error) {
    logger.error(error.stack);
    throw error;
  }
  const { host, database } = mongoConfig;
  logger.info(`connected to database instance mongodb://${host}/${database}`);
  app.locals.mongoDb = client.db(database);
});

/**
 * Create HTTP server.
 */
app.set('port', port);
const server = http.createServer(app);

/**
 * Listen on provided port, on all network interfaces.
 */

server.on('error', onError);
server.on('listening', onListening);
server.listen(port, host);

/**
 * Event listener for HTTP server "error" event.
 */

function onError(error) {
  if (error.syscall !== 'listen') {
    throw error;
  }

  const bind = typeof port === 'string' ? 'Pipe ' + port : 'Port ' + port;

  // handle specific listen errors with friendly messages
  switch (error.code) {
    case 'EACCES':
      throw new Error(bind + ' requires elevated privileges');
    case 'EADDRINUSE':
      throw new Error(bind + ' is already in use');
    default:
      throw error;
  }
}

/**
 * Event listener for HTTP server "listening" event.
 */

function onListening() {
  const addr = server.address();
  const bind = typeof addr === 'string' ? addr : addr.port;
  logger.info(`'stagiop-ts2-api' started on ${addr.address}:${bind} - environment: ${env}`);
}
