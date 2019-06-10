DELIMITER //
Create Trigger before_insert_medicine BEFORE INSERT ON medicine FOR EACH ROW
BEGIN
IF NEW.med_ean2 = '' THEN SET NEW.med_ean2 = NULL; END IF;
IF NEW.med_ean3 = '' THEN SET NEW.med_ean3 = NULL; END IF;
END //