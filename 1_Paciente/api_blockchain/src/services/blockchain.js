module.exports.post = post

const axios = require("axios");
const base_url = `${process.env.HYPERLEDGER_URL}/api/` || 'http://35.193.151.136:3000/api/'

async function post(url, data) {
    return axios.post(`${base_url}${url}`, data);
};