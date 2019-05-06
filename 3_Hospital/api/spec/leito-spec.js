describe("Wing", function() {
	var leito = require('../models/leito-model');
	var ala = require('../models/ala-model');
	var hospital = require('../models/hospital-model');
	var especialidade = require('../models/especialidade-model');
	var situacao = require('../models/situacao-model');

	const LEI = 'Teste: Leito 01';
	const NEW_LEI = 'Teste: Leito 02';

	beforeAll(function(done) {
		Promise.all([
			hospital.create({
				hsp_id: -100,
				nome: 'Hospital 1',
				cnpj: '41.419.836/0001-02',
				endereco: 'Atalaia Leste do Mar, Muralha',
				telefone: '(12) 3456-7890'
			}),
			especialidade.create({
				esp_id: -100,
				esp_desc: 'TDD: LEITO'
			}),
			situacao.create({
				sit_id: -100,
				sit_desc: 'TDD: LEITO'
			})
		]).then(function() {
			ala.create({
				ala_id: -100,
				hsp_id: -100,
				sit_id: -100,
				esp_id: -100,
				ala_tipo: 'TDD: LEITO'
			}).then(function() {
				console.log('Setup complete!');
				done();
			}).catch(function(err) {
				console.log('Setup failed!');
				console.log(err);
				done();
			})
		}).catch(function(err) {
			console.log('Setup failed!');
			console.log(err);
			done();
		});
	});

	afterAll(function(done) {
		leito.destroy({ where: { ALA_ID: -100 } }, { truncate: true }).then(function() {
			ala.destroy({ where: { HSP_ID: -100 } }, { truncate: true }).then(function() {
				Promise.all([
					hospital.destroy({ where: { HSP_ID: -100 } }, { truncate: true }),
					especialidade.destroy({ where: { ESP_ID: -100 } }, { truncate: true }),
					situacao.destroy({ where: { SIT_ID: -100 } }, { truncate: true })
				]).then(function() {
					console.log('Reset complete!');
					done();
				}).catch(function(err) {
					console.log('Reset failed!');
					console.log(err);
					done();
				});
			}).catch(function(err) {
				console.log('Reset failed!');
				console.log(err);
				done();
			});
		}).catch(function(err) {
			console.log('Reset failed!');
			console.log(err);
			done();
		});
	});

// ** TC001 ******************************************************************
	it("should create", function(done) {
		leito.destroy({where: {ala_id: -100, lei: LEI}}).then(function() {
			leito.create({
				ala_id: -100,
				lei: LEI
			}).then(function(result) {
				expect(result.lei).toBe(LEI);
				done();
			});
		});
	});

// ** TC002 *****************************************************************
	it("should NOT create when bed already exists in the same wing", function(done) {
		leito.create({
			ala_id: -100,
			lei: LEI
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC003 *****************************************************************
	it("should NOT create when LEI has less than 5 characters", function(done) {
		leito.create({
	        ala_id: -100,
	        lei: '123'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC004 ******************************************************************
	it("should NOT create when LEI is longer than 45 characters", function(done) {
		leito.create({
			ala_id: -100,
			lei: '123456789 123456789 123456789 123456789 123456789 '
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC005 ******************************************************************
	it("should update", function(done) {
		leito.update({
        	lei: NEW_LEI
		}, {
			where: {ala_id: -100, lei: 'Teste: Leito 01'}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

// ** TC006 ******************************************************************
	it("should NOT update when record does not exist", function(done) {
		leito.update({
			lei: NEW_LEI
		}, {
			where: {ala_id: -1}
		}).then(function(result) {
			expect(result[0]).toBe(0); // Numero de registros alterados
			done();
		});
	});

// ** TC007 ******************************************************************
	it("should delete", function(done) {
		leito.destroy({
			where: {ala_id: -100, lei: NEW_LEI}
		}).then(function(result) {
			expect(result).toBe(1); // Numero de registros removidos
			done();
		});
	});

// ** TC008 ******************************************************************
	it("should NOT delete when record does not exist", function(done) {
		leito.destroy({
			where: {ala_id: -1}
		}).then(function(result) {
			expect(result).toBe(0); // Numero de registros removidos
			done();
		});
	});
});
