describe("Hospital", function() {
	var hospital = require('../models/hospital-model');
	const CNPJ = '30.193.751/0001-32';

	it("should create", function(done) {
		hospital.destroy({where: {cnpj: '30.193.751/0001-32'}}).then(function() {
			hospital.create({
				nome: 'Hospital 1',
				cnpj: CNPJ,
				endereco: 'Atalaia Leste do Mar, Muralha',
				telefone: '(12) 3456-7890'
			}).then(function(result) {
				expect(result.nome).toBe('Hospital 1');
				expect(result.cnpj).toBe(CNPJ);
				done();
			});
		});
	});

	it("should NOT be created when CPNJ is duplicated", function(done) {
		hospital.create({
			nome: 'Hospital 2',
			cnpj: CNPJ,
			endereco: 'Baixada das Pulgas, Porto Real',
			telefone: '(21) 0987-6543'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

	it("should NOT be created when CPNJ has an invalid format", function(done) {
		hospital.create({
			nome: 'Hospital 2',
			cnpj: '30.193.751/0001-3',
			endereco: 'Baixada das Pulgas, Porto Real',
			telefone: '(21) 0987-6543'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

	it("should NOT be created when CPNJ has invalid verifier digits", function(done) {
		hospital.create({
			nome: 'Hospital 2',
			cnpj: '30.193.751/0001-22',
			endereco: 'Baixada das Pulgas, Porto Real',
			telefone: '(21) 0987-6543'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

	it("should update", function(done) {
		hospital.update({
			nome: 'Hospital 2',
			endereco: 'Baixada das Pulgas, Porto Real',
			telefone: '(21) 0987-6543'
		}, {
			where: {cnpj: CNPJ}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

	it("should NOT update when record does not exist", function(done) {
		hospital.update({
			nome: 'Hospital 2',
			endereco: 'Baixada das Pulgas, Porto Real',
			telefone: '(21) 0987-6543'
		}, {
			where: {hsp_id: -1}
		}).then(function(result) {
			expect(result[0]).toBe(0); // Numero de registros alterados
			done();
		});
	});

	it("should delete", function(done) {
		hospital.destroy({
			where: {cnpj: CNPJ}
		}).then(function(result) {
			expect(result).toBe(1); // Numero de registros removidos
			done();
		});
	});

	it("should NOT delete when record does not exist", function(done) {
		hospital.destroy({
			where: {hsp_id: -1}
		}).then(function(result) {
			expect(result).toBe(0); // Numero de registros removidos
			done();
		});
	});

});
