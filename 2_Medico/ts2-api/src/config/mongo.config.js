const username = process.env.MONGODB_USERNAME;
const password = process.env.MONGODB_PASSWORD;
const database = process.env.MONGODB_DATABASE;
const authDb = process.env.MONGODB_AUTHDB || 'admin';
const host = process.env.MONGODB_HOST || 'localhost';
const port = process.env.MONGODB_PORT || 27017;
const URI = process.env.MONGODB_URI || getURI;

function getURI() {
  return `mongodb+srv://${username}:${password}@${host}/${database}`;
}

module.exports = {
  getURI,
  username,
  database,
  authDb,
  host,
  port,
  URI
};
