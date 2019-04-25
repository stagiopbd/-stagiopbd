describe("Hospital", function() {
	var hospital = require('../models/hospital-model');
	const CNPJ = '30.193.751/0001-32';

	it("should create", function(done) {
		hospital.destroy({where: {cnpj: '30.193.751/0001-32'}}).then(function() {
			hospital.create({
				nome: 'Hospital 1',
				cnpj: CNPJ,
				endereco: 'Rua dos Bobos, numero ZERO',
				telefone: '(12) 3456-7890'
			}).then(function(hsp) {
				expect(hsp.nome).toBe('Hospital 1');
				expect(hsp.cnpj).toBe(CNPJ);
				done();
			});
		});
	});

	it("should update", function(done) {
		hospital.update({
			nome: 'Hospital 2',
			endereco: 'Rua dos Bobos, numero ZERO ZERO',
			telefone: '(21) 0987-6543'
        }, {
			where: {cnpj: CNPJ}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
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

});
