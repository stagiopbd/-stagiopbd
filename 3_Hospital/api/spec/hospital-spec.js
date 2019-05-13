describe("Hospital", function() {
	var hospital = require('../models/hospital-model');
	const CNPJ = '30.193.751/0001-32';

	it("should create", function(done) {
		hospital.destroy({where: {hsp_cnpj: '30.193.751/0001-32'}}).then(function() {
			hospital.create({
				hsp_name: 'Hospital 1',
				hsp_cnpj: CNPJ,
				hsp_address: 'Atalaia Leste do Mar, Muralha',
				hsp_telephone: '(12) 3456-7890',
				hsp_sit_id: 1
			}).then(function(result) {
				expect(result.hsp_name).toBe('Hospital 1');
				expect(result.hsp_cnpj).toBe(CNPJ);
				done();
			});
		});
	});

	it("should NOT be created when CPNJ is duplicated", function(done) {
		hospital.create({
			hsp_name: 'Hospital 2',
			hsp_cnpj: CNPJ,
			hsp_address: 'Baixada das Pulgas, Porto Real',
			hsp_telephone: '(21) 0987-6543',
			hsp_sit_id: 1
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

	it("should NOT be created when CPNJ has an invalid format", function(done) {
		hospital.create({
			hsp_name: 'Hospital 2',
			hsp_cnpj: '30.193.751/0001-3',
			hsp_address: 'Baixada das Pulgas, Porto Real',
			hsp_telephone: '(21) 0987-6543',
			hsp_sit_id: 1
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

	it("should NOT be created when CPNJ has invalid verifier digits", function(done) {
		hospital.create({
			hsp_name: 'Hospital 2',
			hsp_cnpj: '30.193.751/0001-22',
			hsp_address: 'Baixada das Pulgas, Porto Real',
			hsp_telephone: '(21) 0987-6543',
			hsp_sit_id: 1
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

	it("should update", function(done) {
		hospital.update({
			hsp_name: 'Hospital 2',
			hsp_address: 'Baixada das Pulgas, Porto Real',
			hsp_telephone: '(21) 0987-6543'
		}, {
			where: {hsp_cnpj: CNPJ}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

	it("should NOT update when record does not exist", function(done) {
		hospital.update({
			hsp_name: 'Hospital 2',
			hsp_address: 'Baixada das Pulgas, Porto Real',
			hsp_telephone: '(21) 0987-6543'
		}, {
			where: {hsp_id: -1}
		}).then(function(result) {
			expect(result[0]).toBe(0); // Numero de registros alterados
			done();
		});
	});

	it("should delete", function(done) {
		hospital.destroy({
			where: {hsp_cnpj: CNPJ}
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
