-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema kiizj5q0n6quilvc
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema kiizj5q0n6quilvc
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kiizj5q0n6quilvc` DEFAULT CHARACTER SET utf8 ;
USE `kiizj5q0n6quilvc` ;

-- -----------------------------------------------------
-- Table `kiizj5q0n6quilvc`.`situation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`situation` (
  `sit_id` INT(11) NOT NULL AUTO_INCREMENT,
  `sit_desc` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`sit_id`),
  UNIQUE INDEX `sit_desc_unique` (`sit_desc` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kiizj5q0n6quilvc`.`hospital`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`hospital` (
  `hsp_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `hsp_cnpj` VARCHAR(20) NOT NULL COMMENT 'Campo de CNPJ',
  `hsp_name` VARCHAR(100) NOT NULL COMMENT 'Nome do Hospital',
  `hsp_address` VARCHAR(200) NOT NULL COMMENT 'Endereco do Hospital',
  `hsp_telephone` VARCHAR(30) NOT NULL COMMENT 'Telefone do Hospital',
  `hsp_sit_id` INT(11) NOT NULL,
  `hsp_create` DATETIME NULL,
  `hsp_update` DATETIME NULL,
  PRIMARY KEY (`hsp_id`),
  UNIQUE INDEX `hsp_cnpj_unique` (`hsp_cnpj` ASC),
  INDEX `fk_hsp_sit_idx` (`hsp_sit_id` ASC),
  CONSTRAINT `fk_hospital_situation`
    FOREIGN KEY (`hsp_sit_id`)
    REFERENCES `kiizj5q0n6quilvc`.`situation` (`sit_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kiizj5q0n6quilvc`.`speciality`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`speciality` (
  `spc_id` INT(11) NOT NULL AUTO_INCREMENT,
  `spc_desc` VARCHAR(45) NOT NULL COMMENT 'Descricao da Especialidade',
  PRIMARY KEY (`spc_id`),
  UNIQUE INDEX `spc_desc_unique` (`spc_desc` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kiizj5q0n6quilvc`.`wing`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`wing` (
  `wng_id` INT(11) NOT NULL AUTO_INCREMENT,
  `wng_desc` VARCHAR(45) NOT NULL COMMENT 'Descricao da Ala',
  `wng_hsp_id` INT(11) NOT NULL,
  `wng_sit_id` INT(11) NOT NULL,
  `wng_spc_id` INT(11) NOT NULL,
  PRIMARY KEY (`wng_id`),
  UNIQUE INDEX `wng_desc_unique` (`wng_hsp_id` ASC, `wng_desc` ASC),
  INDEX `fk_wing_hospital1_idx` (`wng_hsp_id` ASC),
  INDEX `fk_wing_situation1_idx` (`wng_sit_id` ASC),
  INDEX `fk_wing_speciality1_idx` (`wng_spc_id` ASC),
  CONSTRAINT `fk_wing_hospital1`
    FOREIGN KEY (`wng_hsp_id`)
    REFERENCES `kiizj5q0n6quilvc`.`hospital` (`hsp_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wing_situation1`
    FOREIGN KEY (`wng_sit_id`)
    REFERENCES `kiizj5q0n6quilvc`.`situation` (`sit_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wing_speciality1`
    FOREIGN KEY (`wng_spc_id`)
    REFERENCES `kiizj5q0n6quilvc`.`speciality` (`spc_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kiizj5q0n6quilvc`.`patient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`patient` (
  `pat_cpf` VARCHAR(11) NOT NULL,
  `pat_name` VARCHAR(200) NOT NULL COMMENT 'Nome do Paciente',
  `pat_gender` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Genero do Paciente',
  `pat_blood_type` VARCHAR(3) NULL DEFAULT NULL COMMENT 'Tipo sanguineo e fator RH do Paciente',
  `pat_birthdate` DATE NULL DEFAULT NULL COMMENT 'Data de Nascimento',
  PRIMARY KEY (`pat_cpf`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kiizj5q0n6quilvc`.`bed`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`bed` (
  `bed_id` INT(11) NOT NULL AUTO_INCREMENT,
  `bed_desc` VARCHAR(100) NOT NULL COMMENT 'Descricao do Leito',
  `bed_wng_id` INT(11) NOT NULL,
  `bed_pat_cpf` VARCHAR(11) NULL,
  PRIMARY KEY (`bed_id`),
  UNIQUE INDEX `bed_desc_unique` (`bed_wng_id` ASC, `bed_desc` ASC),
  INDEX `fk_bed_wing1_idx` (`bed_wng_id` ASC),
  INDEX `fk_bed_patient1_idx1` (`bed_pat_cpf` ASC),
  CONSTRAINT `fk_bed_wing1`
    FOREIGN KEY (`bed_wng_id`)
    REFERENCES `kiizj5q0n6quilvc`.`wing` (`wng_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bed_patient1`
    FOREIGN KEY (`bed_pat_cpf`)
    REFERENCES `kiizj5q0n6quilvc`.`patient` (`pat_cpf`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kiizj5q0n6quilvc`.`function`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`function` (
  `func_id` INT(11) NOT NULL,
  `func_descr` VARCHAR(45) NOT NULL COMMENT 'Descriçao da Funcao',
  PRIMARY KEY (`func_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kiizj5q0n6quilvc`.`collaborator`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`collaborator` (
  `col_cpf` VARCHAR(11) NOT NULL,
  `col_name` VARCHAR(100) NOT NULL,
  `col_gender` VARCHAR(10) NOT NULL,
  `col_function_id` INT(11) NOT NULL,
  `col_hsp_id` INT(11) NOT NULL,
  PRIMARY KEY (`col_cpf`),
  INDEX `fk_col_hsp_id` (`col_hsp_id` ASC),
  INDEX `fk_col_func_idx` (`col_function_id` ASC),
  CONSTRAINT `collaborator_ibfk_1`
    FOREIGN KEY (`col_hsp_id`)
    REFERENCES `kiizj5q0n6quilvc`.`hospital` (`hsp_id`),
  CONSTRAINT `fk_collaborator_function1`
    FOREIGN KEY (`col_function_id`)
    REFERENCES `kiizj5q0n6quilvc`.`function` (`func_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `kiizj5q0n6quilvc` ;

-- -----------------------------------------------------
-- Placeholder table for view `kiizj5q0n6quilvc`.`hsp_bed`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`hsp_bed` (`hsp_id` INT, `hsp_name` INT, `wng_desc` INT, `bed_id` INT, `bed_desc` INT, `bed_pat_cpf` INT);

-- -----------------------------------------------------
-- Placeholder table for view `kiizj5q0n6quilvc`.`hsp_wing`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`hsp_wing` (`hsp_id` INT, `hsp_cnpj` INT, `hsp_name` INT, `hsp_sit_id` INT, `wng_id` INT, `wng_desc` INT, `wng_sit_id` INT, `wng_spc_id` INT);

-- -----------------------------------------------------
-- Placeholder table for view `kiizj5q0n6quilvc`.`wing_bed`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`wing_bed` (`wng_id` INT, `wng_desc` INT, `wng_hsp_id` INT, `wng_sit_id` INT, `wng_spc_id` INT, `bed_id` INT, `bed_desc` INT, `bed_wng_id` INT, `bed_pat_cpf` INT);

-- -----------------------------------------------------
-- procedure Internacao
-- -----------------------------------------------------

DELIMITER $$
USE `kiizj5q0n6quilvc`$$
CREATE DEFINER=`u8m691gex60b7dqt`@`%` PROCEDURE `Internacao`(in cpf varchar(255),in wingTipo varchar(255))
BEGIN
 Declare vHsp int;
 DECLARE vBed Int;
 
 
 if (SELECT count( bed_id) FROM wing_bed where bed_pat_cpf = cpf) = 0 then
 
	 SELECT min(hsp_id)  FROM hsp_bed
		where wng_desc = wingTipo
		and bed_pat_cpf is null
		into vHsp;

	 select min(bed_id) FROM hsp_bed h
		where  wng_desc = wingTipo
		and  hsp_id = vHsp
		and bed_pat_cpf is null
		into vBed;
	 
	 update bed set bed_pat_cpf = cpf where bed_id =vBed;
	 
end if;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- View `kiizj5q0n6quilvc`.`hsp_bed`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kiizj5q0n6quilvc`.`hsp_bed`;
USE `kiizj5q0n6quilvc`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`u8m691gex60b7dqt`@`%` SQL SECURITY DEFINER VIEW `kiizj5q0n6quilvc`.`hsp_bed` AS select `h`.`hsp_id` AS `hsp_id`,`h`.`hsp_name` AS `hsp_name`,`w`.`wng_desc` AS `wng_desc`,`b`.`bed_id` AS `bed_id`,`b`.`bed_desc` AS `bed_desc`,`b`.`bed_pat_cpf` AS `bed_pat_cpf` from ((`kiizj5q0n6quilvc`.`hospital` `h` join `kiizj5q0n6quilvc`.`wing` `w`) join `kiizj5q0n6quilvc`.`bed` `b`) where ((`h`.`hsp_id` = `w`.`wng_hsp_id`) and (`w`.`wng_id` = `b`.`bed_wng_id`)) order by `h`.`hsp_name`,`w`.`wng_desc`,`b`.`bed_desc`;

-- -----------------------------------------------------
-- View `kiizj5q0n6quilvc`.`hsp_wing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kiizj5q0n6quilvc`.`hsp_wing`;
USE `kiizj5q0n6quilvc`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`u8m691gex60b7dqt`@`%` SQL SECURITY DEFINER VIEW `kiizj5q0n6quilvc`.`hsp_wing` AS select `kiizj5q0n6quilvc`.`hospital`.`hsp_id` AS `hsp_id`,`kiizj5q0n6quilvc`.`hospital`.`hsp_cnpj` AS `hsp_cnpj`,`kiizj5q0n6quilvc`.`hospital`.`hsp_name` AS `hsp_name`,`kiizj5q0n6quilvc`.`hospital`.`hsp_sit_id` AS `hsp_sit_id`,`kiizj5q0n6quilvc`.`wing`.`wng_id` AS `wng_id`,`kiizj5q0n6quilvc`.`wing`.`wng_desc` AS `wng_desc`,`kiizj5q0n6quilvc`.`wing`.`wng_sit_id` AS `wng_sit_id`,`kiizj5q0n6quilvc`.`wing`.`wng_spc_id` AS `wng_spc_id` from (`kiizj5q0n6quilvc`.`hospital` join `kiizj5q0n6quilvc`.`wing` on((`kiizj5q0n6quilvc`.`hospital`.`hsp_id` = `kiizj5q0n6quilvc`.`wing`.`wng_hsp_id`)));

-- -----------------------------------------------------
-- View `kiizj5q0n6quilvc`.`wing_bed`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kiizj5q0n6quilvc`.`wing_bed`;
USE `kiizj5q0n6quilvc`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`u8m691gex60b7dqt`@`%` SQL SECURITY DEFINER VIEW `kiizj5q0n6quilvc`.`wing_bed` AS select `kiizj5q0n6quilvc`.`wing`.`wng_id` AS `wng_id`,`kiizj5q0n6quilvc`.`wing`.`wng_desc` AS `wng_desc`,`kiizj5q0n6quilvc`.`wing`.`wng_hsp_id` AS `wng_hsp_id`,`kiizj5q0n6quilvc`.`wing`.`wng_sit_id` AS `wng_sit_id`,`kiizj5q0n6quilvc`.`wing`.`wng_spc_id` AS `wng_spc_id`,`kiizj5q0n6quilvc`.`bed`.`bed_id` AS `bed_id`,`kiizj5q0n6quilvc`.`bed`.`bed_desc` AS `bed_desc`,`kiizj5q0n6quilvc`.`bed`.`bed_wng_id` AS `bed_wng_id`,`kiizj5q0n6quilvc`.`bed`.`bed_pat_cpf` AS `bed_pat_cpf` from (`kiizj5q0n6quilvc`.`wing` join `kiizj5q0n6quilvc`.`bed` on((`kiizj5q0n6quilvc`.`wing`.`wng_id` = `kiizj5q0n6quilvc`.`bed`.`bed_wng_id`)));
USE `kiizj5q0n6quilvc`;

DELIMITER $$
USE `kiizj5q0n6quilvc`$$
CREATE DEFINER = CURRENT_USER TRIGGER `hospital_BEFORE_INSERT` BEFORE INSERT ON hospital FOR EACH ROW
BEGIN
set NEW.hsp_create = NOW();
END$$

USE `kiizj5q0n6quilvc`$$
CREATE TRIGGER `hospital_AFTER_UPDATE` BEFORE UPDATE ON hospital FOR EACH ROW
BEGIN
set new.hsp_update = NOW();
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
