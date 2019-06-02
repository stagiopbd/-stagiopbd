CREATE TABLE screening (
	pat_cpf VARCHAR(11) NOT NULL, 
	scr_reddish_spots BOOLEAN NOT NULL,
	scr_fever BOOLEAN NOT NULL,
	scr_cough BOOLEAN NOT NULL,
	scr_malaise BOOLEAN NOT NULL,
	scr_conjunctivitis BOOLEAN NOT NULL,
	scr_coryza BOOLEAN NOT NULL,
	scr_loss_of_appetite BOOLEAN NOT NULL,
	scr_white_spots BOOLEAN NOT NULL,
	scr_diarrhea BOOLEAN NOT NULL,
	scr_convulsion BOOLEAN NOT NULL,
	scr_ear_infection BOOLEAN NOT NULL,
	scr_percentage DOUBLE NOT NULL,
	scr_date DATE NOT NULL,
	FOREIGN KEY(pat_cpf) REFERENCES patient(pat_cpf)
);