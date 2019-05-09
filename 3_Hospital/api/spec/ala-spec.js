describe("Wing", function() {
	var ala = require('../models/ala-model');
	var hospital = require('../models/hospital-model');
	var especialidade = require('../models/especialidade-model');
	var situacao = require('../models/situacao-model');

	const ALA_TIPO = 'Teste: Ala 01';
	const NEW_ALA_TIPO = 'Teste: Ala 02';

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
				ala_tipo: 'TDD: ALA'
			}),
			situacao.create({
				sit_id: -100,
				sit_desc: 'TDD: ALA'
			})
		]).then(function() {
			console.log('Setup complete!');
			done();
		}).catch(function(err) {
			console.log('Setup failed!');
			console.log(err);
			done();
		});
	});

	afterAll(function(done) {
		Promise.all([
			ala.destroy({ where: { HSP_ID: -100 } }, { truncate: true }),
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
	});

// ** TC009 ******************************************************************
	it("should create", function(done) {
		ala.destroy({where: {hsp_id: -100, ala_tipo: ALA_TIPO}}).then(function() {
			ala.create({
				hsp_id: -100,
				sit_id: -100,
				esp_id: -100,
				ala_tipo: ALA_TIPO
			}).then(function(result) {
				expect(result.ala_tipo).toBe(ALA_TIPO);
				done();
			});
		});
	});

// ** TC010 *****************************************************************
	it("should NOT create when wing already exists in the same hospital", function(done) {
		ala.create({
			hsp_id: -100,
			sit_id: -100,
			esp_id: -100,
			ala_tipo: ALA_TIPO
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC011 *****************************************************************
	it("should NOT create when ALA_TIPO has less than 5 characters", function(done) {
		ala.create({
			hsp_id: -100,
			sit_id: -100,
			esp_id: -100,
			ala_tipo: '123'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC012 ******************************************************************
	it("should NOT create when ALA_TIPO is longer than 45 characters", function(done) {
		ala.create({
			hsp_id: -100,
			sit_id: -100,
			esp_id: -100,
			ala_tipo: '123456789 123456789 123456789 123456789 123456789 '
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC013 ******************************************************************
	it("should update", function(done) {
		ala.update({
			ala_tipo: NEW_ALA_TIPO
		}, {
			where: {hsp_id: -100, ala_tipo: ALA_TIPO}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

// ** TC014 ******************************************************************
	it("should NOT update when record does not exist", function(done) {
		ala.update({
			ala_tipo: NEW_ALA_TIPO
		}, {
			where: {ala_id: -1}
		}).then(function(result) {
			expect(result[0]).toBe(0); // Numero de registros alterados
			done();
		});
	});

// ** TC015 ******************************************************************
	it("should delete", function(done) {
		ala.destroy({
			where: {hsp_id: -100, ala_tipo: NEW_ALA_TIPO}
		}).then(function(result) {
			expect(result).toBe(1); // Numero de registros removidos
			done();
		});
	});

// ** TC016 ******************************************************************
	it("should NOT delete when record does not exist", function(done) {
		ala.destroy({
			where: {ala_id: -1}
		}).then(function(result) {
			expect(result).toBe(0); // Numero de registros removidos
			done();
		});
	});
});
