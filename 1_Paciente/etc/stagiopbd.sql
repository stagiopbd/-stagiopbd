SET GLOBAL log_bin_trust_function_creators = 1;

DELIMITER $
 CREATE FUNCTION calc_patient_has_sarampo_vaccine() RETURNS INT
 BEGIN
  RETURN (SELECT count(p.pat_cpf) FROM patient as p INNER JOIN patient_has_vaccine as v on p.pat_cpf = v.vac_pat_cpf 
  WHERE v.vac_med_id in (2270, 8979, 9068, 9209, 9210, 15367, 15446, 15455, 23131));
 END $
DELIMITER ;

##################################################################################

DELIMITER $
CREATE VIEW list_people_dont_have_sarampo_vaccine AS
SELECT * FROM patient p WHERE p.pat_cpf 
NOT IN 
(SELECT p.pat_cpf FROM patient as p INNER JOIN patient_has_vaccine as v on p.pat_cpf = v.vac_pat_cpf 
WHERE v.vac_med_id in (2270, 8979, 9068, 9209, 9210, 15367, 15446, 15455, 23131));

DELIMITER $
CREATE VIEW list_patient_has_sarampo AS
 SELECT m.cns_date, c.dig_code_cid, m.cns_pat_cpf FROM medicalconsultation as m 
   INNER JOIN consultation_diagnosis as c
   ON m.cns_protocol = c.dig_cns_protocol
   WHERE c.dig_code_cid IN ('B050', 'B051', 'B052', 'B053', 'B054', 'B058', 'B059') $

DELIMITER $
SELECT * FROM list_patient_has_sarampo$

##################################################################################

DELIMITER $
CREATE VIEW list_patient_dont_have_penta_vaccine AS
SELECT p.* FROM patient p WHERE p.pat_cpf NOT IN 
(SELECT p.pat_cpf FROM patient p INNER JOIN patient_has_vaccine v on p.pat_cpf = v.vac_pat_cpf 
WHERE v.vac_med_id IN (2105, 2106, 8953))$

DELIMITER $
CREATE PROCEDURE send_email_for_penta_vaccine ()
BEGIN
 SELECT * FROM list_patient_dont_have_penta_vaccine as p
 WHERE datediff(curdate(), p.pat_birthdate) > 45 AND datediff(curdate(), p.pat_birthdate) <= 60;
END $
DELIMITER ;

CALL send_email_for_penta_vaccine();

##################################################################################

DELIMITER $
CREATE TRIGGER send_to_quarentenee AFTER INSERT
ON medicalconsultation
FOR EACH ROW
BEGIN
	CALL isBedRequest(new.cns_phy_cpf, new.cns_pat_cpf, new.cns_date); 
END $
DELIMITER ;

DELIMITER $
CREATE PROCEDURE isBedRequest(physician_cpf VARCHAR(11), patient_cpf VARCHAR(11), consultation_date DATETIME)
BEGIN
    DECLARE cid varchar(5);
    IF (SELECT count(l.cns_pat_cpf) FROM list_patient_has_sarampo as l WHERE l.cns_pat_cpf = patient_cpf ORDER BY l.cns_date = consultation_date) > 0 THEN
		SET cid = (SELECT l.dig_code_cid FROM list_patient_has_sarampo as l WHERE l.cns_pat_cpf = patient_cpf ORDER BY l.cns_date = consultation_date);
        INSERT INTO bed_request(pat_cpf, phy_cpf, cid_code, status) VALUES(patient_cpf, physician_cpf, cid, null);
    END IF;
END$
DELIMITER ;

SELECT * FROM list_patient_has_sarampo ORDER BY cns_date DESC LIMIT 1;

###################################################################################

DELIMITER $
CREATE TRIGGER sarampo_vaccine AFTER INSERT
ON patient_has_vaccine
FOR EACH ROW
BEGIN
	DECLARE contador INT;
    IF new.vac_med_id in (2270, 8979, 9068, 9209, 9210, 15367, 15446, 15455, 23131) THEN
    SET contador = (SELECT COUNT(v.vac_pat_cpf) FROM patient_has_vaccine WHERE v.vac_pat_cpf = new.vac_pat_cpf AND v.vac_date = new.vac_date AND v.vac_med_id in (2270, 8979, 9068, 9209, 9210, 15367, 15446, 15455, 23131));
	INSERT INTO notification (ntf_type, ntf_from, ntf_to, ntf_datetime, ntf_title, ntf_text, ntf_protocol) VALUES("count", "stagiopbd@stagiopbd.com.br", "patient@stagiopbd.com.br", CURDATE(), "Counter People has Sarampo Vaccine", CONCAT("We have ", contador, " patients with Sarampo Vaccine"), "extra");
    END IF;
END$
DELIMITER ;


