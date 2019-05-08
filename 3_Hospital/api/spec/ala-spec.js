describe("Wing", function() {
	var ala = require('../models/ala-model');
	var hospital = require('../models/hospital-model');
	var especialidade = require('../models/especialidade-model');
	var situacao = require('../models/situacao-model');

	const WNG_DESC = 'Teste: Ala 01';
	const NEW_WNG_DESC = 'Teste: Ala 02';

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
				spc_desc: 'TDD: ALA'
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
	});

// ** TC001 ******************************************************************
	it("should create", function(done) {
		ala.destroy({where: {wng_hsp_id: -100, wng_desc: WNG_DESC}}).then(function() {
			ala.create({
				wng_hsp_id: -100,
				wng_sit_id: -100,
				wng_spc_id: -100,
				wng_desc: WNG_DESC
			}).then(function(result) {
				expect(result.wng_desc).toBe(WNG_DESC);
				done();
			});
		});
	});

// ** TC002 *****************************************************************
	it("should NOT create when WNG_DESC already exists in the same hospital", function(done) {
		ala.create({
			wng_hsp_id: -100,
			wng_sit_id: -100,
			wng_spc_id: -100,
			wng_desc: WNG_DESC
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC003 *****************************************************************
	it("should NOT create when WNG_DESC has less than 5 characters", function(done) {
		ala.create({
			wng_hsp_id: -100,
			wng_sit_id: -100,
			wng_spc_id: -100,
			wng_desc: '123'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC004 ******************************************************************
	it("should NOT create when WNG_DESC is longer than 45 characters", function(done) {
		ala.create({
			wng_hsp_id: -100,
			wng_sit_id: -100,
			wng_spc_id: -100,
			wng_desc: '123456789 123456789 123456789 123456789 123456789 '
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC005 ******************************************************************
	it("should update", function(done) {
		ala.update({
			wng_desc: NEW_WNG_DESC
		}, {
			where: {wng_hsp_id: -100, wng_desc: WNG_DESC}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

// ** TC006 ******************************************************************
	it("should NOT update when record does not exist", function(done) {
		ala.update({
			wng_desc: NEW_WNG_DESC
		}, {
			where: {wng_id: -1}
		}).then(function(result) {
			expect(result[0]).toBe(0); // Numero de registros alterados
			done();
		});
	});

// ** TC007 ******************************************************************
	it("should delete", function(done) {
		ala.destroy({
			where: {wng_hsp_id: -100, wng_desc: NEW_WNG_DESC}
		}).then(function(result) {
			expect(result).toBe(1); // Numero de registros removidos
			done();
		});
	});

// ** TC008 ******************************************************************
	it("should NOT delete when record does not exist", function(done) {
		ala.destroy({
			where: {wng_id: -1}
		}).then(function(result) {
			expect(result).toBe(0); // Numero de registros removidos
			done();
		});
	});
});
