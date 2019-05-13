describe("Wing", function() {
	var leito = require('../models/leito-model');
	var ala = require('../models/ala-model');
	var hospital = require('../models/hospital-model');
	var especialidade = require('../models/especialidade-model');
	var situacao = require('../models/situacao-model');

	const BED_DESC = 'Teste: Leito 01';
	const NEW_BED_DESC = 'Teste: Leito 02';

	beforeAll(function(done) {
		Promise.all([
			hospital.create({
				hsp_id: -100,
				hsp_name: 'Hospital 1',
				hsp_cnpj: '41.419.836/0001-02',
				hsp_address: 'Atalaia Leste do Mar, Muralha',
				hsp_telephone: '(12) 3456-7890',
				hsp_sit_id: 1
			}),
			especialidade.create({
				spc_id: -100,
				spc_desc: 'TDD: BED_DESCTO'
			}),
			situacao.create({
				sit_id: -100,
				sit_desc: 'TDD: ALA'
			})
		]).then(function() {
			ala.create({
				wng_id: -100,
				wng_hsp_id: -100,
				wng_sit_id: -100,
				wng_spc_id: -100,
				wng_desc: 'TDD: BED_DESCTO'
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
		leito.destroy({ where: { bed_wng_id: -100 } }, { truncate: true }).then(function() {
			ala.destroy({ where: { wng_hsp_id: -100 } }, { truncate: true }).then(function() {
				Promise.all([
					hospital.destroy({ where: { hsp_id: -100 } }, { truncate: true }),
					especialidade.destroy({ where: { spc_id: -100 } }, { truncate: true }),
					situacao.destroy({ where: { sit_id: -100 } }, { truncate: true })
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
		leito.destroy({where: {bed_wng_id: -100, bed_desc: BED_DESC}}).then(function() {
			leito.create({
				bed_wng_id: -100,
				bed_desc: BED_DESC
			}).then(function(result) {
				expect(result.bed_desc).toBe(BED_DESC);
				done();
			});
		});
	});

// ** TC002 *****************************************************************
	it("should NOT create when bed already exists in the same wing", function(done) {
		leito.create({
			bed_wng_id: -100,
			bed_desc: BED_DESC
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC003 *****************************************************************
	it("should NOT create when BED_DESC has less than 5 characters", function(done) {
		leito.create({
	        bed_wng_id: -100,
	        bed_desc: '123'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC004 ******************************************************************
	it("should NOT create when BED_DESC is longer than 45 characters", function(done) {
		leito.create({
			bed_wng_id: -100,
			bed_desc: '123456789 123456789 123456789 123456789 123456789 '
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
        	bed_desc: NEW_BED_DESC
		}, {
			where: {bed_wng_id: -100, bed_desc: 'Teste: Leito 01'}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

// ** TC006 ******************************************************************
	it("should NOT update when record does not exist", function(done) {
		leito.update({
			bed_desc: NEW_BED_DESC
		}, {
			where: {bed_wng_id: -1}
		}).then(function(result) {
			expect(result[0]).toBe(0); // Numero de registros alterados
			done();
		});
	});

// ** TC007 ******************************************************************
	it("should delete", function(done) {
		leito.destroy({
			where: {bed_wng_id: -100, bed_desc: NEW_BED_DESC}
		}).then(function(result) {
			expect(result).toBe(1); // Numero de registros removidos
			done();
		});
	});

// ** TC008 ******************************************************************
	it("should NOT delete when record does not exist", function(done) {
		leito.destroy({
			where: {bed_wng_id: -1}
		}).then(function(result) {
			expect(result).toBe(0); // Numero de registros removidos
			done();
		});
	});
});
