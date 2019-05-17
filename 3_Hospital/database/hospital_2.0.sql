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
  PRIMARY KEY (`hsp_id`),
  UNIQUE INDEX `hsp_cnpj_unique` (`hsp_cnpj` ASC),
  INDEX `fk_hospital_situation_idx` (`hsp_sit_id` ASC),
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
  `pat_cpf` VARCHAR(20) NOT NULL,
  `pat_name` VARCHAR(200) NOT NULL COMMENT 'Nome do Paciente',
  `pat_gender` VARCHAR(1) NULL DEFAULT NULL COMMENT 'Genero do Paciente',
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
  `bed_desc` VARCHAR(45) NOT NULL COMMENT 'Descricao do Leito',
  `bed_wng_id` INT(11) NOT NULL,
  `bed_pat_cpf` VARCHAR(20) NULL,
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
-- Table `kiizj5q0n6quilvc`.`collaborator`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiizj5q0n6quilvc`.`collaborator` (
  `col_cpf` VARCHAR(20) NOT NULL,
  `col_name` VARCHAR(100) NOT NULL,
  `col_gender` CHAR(1) NOT NULL,
  `col_function_id` INT(11) NOT NULL,
  `col_hsp_id` INT(11) NOT NULL,
  PRIMARY KEY (`col_cpf`),
  INDEX `col_hsp_id` (`col_hsp_id` ASC),
  CONSTRAINT `collaborator_ibfk_1`
    FOREIGN KEY (`col_hsp_id`)
    REFERENCES `kiizj5q0n6quilvc`.`hospital` (`hsp_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
