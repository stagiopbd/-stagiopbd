describe("Speciality", function() {
	var especialidade = require('../models/especialidade-model');
	const SPC_DESC = 'Teste: Pediatria';
	const NEW_SPC_DESC = 'Teste: Oftalmologia';

// ** TC001 ******************************************************************
	it("should create", function(done) {
		especialidade.destroy({where: {spc_desc: SPC_DESC}}).then(function() {
			especialidade.create({
				spc_desc: SPC_DESC
			}).then(function(result) {
				expect(result.spc_desc).toBe(SPC_DESC);
				done();
			});
		});
	});

// ** TC002 ******************************************************************
	it("should NOT create when speciality already exists", function(done) {
		especialidade.create({
			spc_desc: SPC_DESC
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC003 ******************************************************************
	it("should NOT create when SPC_DESC has less than 5 characters", function(done) {
		especialidade.create({
			spc_desc: '123'
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC004 ******************************************************************
	it("should NOT create when SPC_DESC is longer than 45 characters", function(done) {
		especialidade.create({
			spc_desc: '123456789 123456789 123456789 123456789 123456789 '
		}).then(function(result) {
			fail('Registro equivocadamente inserido');
			done();
		}).catch(function(err) {
			done();
	  	});
	});

// ** TC005 ******************************************************************
	it("should update", function(done) {
		especialidade.update({
			spc_desc: NEW_SPC_DESC
		}, {
			where: {spc_desc: SPC_DESC}
		}).then(function(result) {
			expect(result[0]).toBe(1); // Numero de registros alterados
			done();
		});
	});

// ** TC006 ******************************************************************
	it("should NOT update when record does not exist", function(done) {
		especialidade.update({
			spc_desc: NEW_SPC_DESC
		}, {
			where: {spc_id: -1}
		}).then(function(result) {
			expect(result[0]).toBe(0); // Numero de registros alterados
			done();
		});
	});

// ** TC007 ******************************************************************
	it("should delete", function(done) {
		especialidade.destroy({
			where: {spc_desc: NEW_SPC_DESC}
		}).then(function(result) {
			expect(result).toBe(1); // Numero de registros removidos
			done();
		});
	});

// ** TC008 ******************************************************************
	it("should NOT delete when record does not exist", function(done) {
		especialidade.destroy({
			where: {spc_id: -1}
		}).then(function(result) {
			expect(result).toBe(0); // Numero de registros removidos
			done();
		});
	});

});
