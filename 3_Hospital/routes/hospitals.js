var express = require('express');
var router = express.Router();
var mysql = require('mysql');

router.get('/', function(req, res, next) {
	var con = mysql.createConnection({
		host: "localhost",
		user: "nodeuser",
		password: "nodeuser@1234"
	});

	con.connect(function(err) {
		if (err) throw err;

		var sql = `	SELECT	*
					  FROM	stagiop.hospital
				  ORDER BY	hsp_name`;

		con.query(sql, function (err, result) {
			if (err) throw err;
			res.send(result);
	    });
	});
});

router.get('/:seq', function(req, res, next) {
	var hspSeq = req.params.seq;

	var con = mysql.createConnection({
		host: "localhost",
		user: "nodeuser",
		password: "nodeuser@1234"
	});

	con.connect(function(err) {
		if (err) throw err;

		var sql = `	SELECT	*
					  FROM	stagiop.hospital
					 WHERE	hsp_seq = ` + hspSeq + `
				  ORDER BY	hsp_name`;

		con.query(sql, function (err, result) {
			if (err) throw err;

			if (result.length == 0)
				res.send('Hospital n&atilde;o encontrado!');
			else
				res.send(result[0]);
	    });
	});
});

module.exports = router;
