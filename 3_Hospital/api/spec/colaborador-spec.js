describe("Collaborator", function() {
	var colaborador = require('../models/colaborador-model');
	var hospital = require('../models/hospital-model');

	const COL_CPF = '641.914.970-30';

	beforeAll(function(done) {
		Promise.all([
			hospital.create({
				hsp_id: -100,
				hsp_name: 'Hospital 1',
				hsp_cnpj: '41.419.836/0001-02',
				hsp_address: 'Atalaia Leste do Mar, Muralha',
				hsp_telephone: '(12) 3456-7890',
				hsp_sit_id: 1
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
		colaborador.destroy({ where: { col_hsp_id: -100 } }, { truncate: true }).then(function() {
			Promise.all([
				hospital.destroy({ where: { hsp_id: -100 } }, { truncate: true })
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
		colaborador.destroy({where: {col_hsp_id: -100, col_cpf: COL_CPF}}).then(function() {
			colaborador.create({
				col_hsp_id: -100,
				col_gender: '1',
				col_function_id: 1,
				col_name: 'Teste: Nome',
				col_cpf: COL_CPF
			}).then(function(result) {
				expect(result.col_cpf).toBe(COL_CPF);
				done();
			});
		});
	});

// ** TC002 *****************************************************************
	it("should NOT create when COL_CPF already exists in the same hospital", function(done) {
		colaborador.create({
			col_hsp_id: -100,
			col_gender: '1',
			col_function_id: 1,
			col_name: 'Teste: Nome',
			col_cpf: COL_CPF
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC003 *****************************************************************
	it("should NOT create when COL_CPF  has an invalid format", function(done) {
		colaborador.create({
			col_hsp_id: -100,
			col_gender: '1',
			col_function_id: 1,
			col_name: 'Teste: Nome',
			col_cpf: '641.914.970'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC004 ******************************************************************
	it("should NOT create when COL_CPF has invalid verifier digits", function(done) {
		colaborador.create({
			col_hsp_id: -100,
			col_gender: '1',
			col_function_id: 1,
			col_name: 'Teste: Nome',
			col_cpf: '641.914.970-29'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC005 ******************************************************************
	it("should update", function(done) {
		colaborador.update({
			col_name: 'Teste: Nome 2'
		}, {
			where: {col_hsp_id: -100, col_cpf: COL_CPF}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

// ** TC006 ******************************************************************
	it("should NOT update when record does not exist", function(done) {
		colaborador.update({
			col_name: 'Teste: Nome 2'
		}, {
			where: {col_hsp_id: -100, col_cpf: '-1'}
		}).then(function(result) {
			expect(result[0]).toBe(0); // Numero de registros alterados
			done();
		});
	});

// ** TC007 ******************************************************************
	it("should delete", function(done) {
		colaborador.destroy({
			where: {col_hsp_id: -100, col_cpf: COL_CPF}
		}).then(function(result) {
			expect(result).toBe(1); // Numero de registros removidos
			done();
		});
	});

// ** TC008 ******************************************************************
	it("should NOT delete when record does not exist", function(done) {
		colaborador.destroy({
			where: {col_hsp_id: -100, col_cpf: '-1'}
		}).then(function(result) {
			expect(result).toBe(0); // Numero de registros removidos
			done();
		});
	});
});
