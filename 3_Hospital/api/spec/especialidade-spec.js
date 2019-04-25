describe("Especialidade", function() {
	var especialidade = require('../models/especialidade-model');
	const ESP_DESC = 'Teste: Pediatria';

	it("should create", function(done) {
		especialidade.destroy({where: {esp_desc: ESP_DESC}}).then(function() {
			especialidade.create({
				esp_desc: ESP_DESC
			}).then(function(result) {
				expect(result.esp_desc).toBe(ESP_DESC);
				done();
			});
		});
	});

	it("should update", function(done) {
		especialidade.update({
			nome: 'Hospital 2',
			endereco: 'Rua dos Bobos, numero ZERO ZERO',
			telefone: '(21) 0987-6543'
        }, {
			where: {esp_desc: ESP_DESC}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

	it("should delete", function(done) {
		especialidade.destroy({
			where: {esp_desc: ESP_DESC}
		}).then(function(result) {
			expect(result).toBe(1); // Numero de registros removidos
			done();
		});
	});

});
