-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema logic685_stagiopbd
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema logic685_stagiopbd
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `logic685_stagiopbd` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `logic685_stagiopbd` ;

-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`allergy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`allergy` (
  `alg_id` INT(11) NOT NULL,
  `alg_med_active_principle` MEDIUMTEXT NULL DEFAULT NULL,
  `alg_description` MEDIUMTEXT NOT NULL,
  `alg_classification` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`alg_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`hospital_sittuation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`hospital_sittuation` (
  `sit_id` INT(11) NOT NULL,
  `sit_description` VARCHAR(45) NULL DEFAULT NULL,
  `sit_bedroom` VARCHAR(45) NULL DEFAULT NULL,
  `sit_physician` VARCHAR(45) NULL DEFAULT NULL,
  `sit_available` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`sit_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`person`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`person` (
  `per_id` INT(11) NOT NULL AUTO_INCREMENT,
  `per_name` VARCHAR(100) NOT NULL,
  `per_cnpjcpf` CHAR(14) NOT NULL,
  `per_address` VARCHAR(50) NULL DEFAULT NULL,
  `per_number` INT(5) NULL DEFAULT NULL,
  `per_complement` VARCHAR(15) NULL DEFAULT NULL,
  `per_neighborhood` VARCHAR(45) NULL DEFAULT NULL,
  `per_city` VARCHAR(45) NULL DEFAULT NULL,
  `per_state` CHAR(2) NULL DEFAULT NULL,
  `per_zipcode` CHAR(8) NULL DEFAULT NULL,
  `per_country` VARCHAR(45) NULL DEFAULT NULL,
  `per_phone_inter_code` CHAR(2) NULL DEFAULT NULL,
  `per_phone_area_code` CHAR(3) NULL DEFAULT NULL,
  `per_phone_number` CHAR(9) NULL DEFAULT NULL,
  `per_email` VARCHAR(60) NULL DEFAULT NULL,
  `per_gender` INT(1) NULL,
  `per_birthdate` DATE NULL,
  PRIMARY KEY (`per_id`),
  UNIQUE INDEX `ppl_cnpjcpf_UNIQUE` (`per_cnpjcpf` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`hospital`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`hospital` (
  `hsp_id` INT(11) NOT NULL,
  `hsp_cnpj` VARCHAR(20) NOT NULL,
  `hsp_name` VARCHAR(100) NOT NULL,
  `hsp_address` VARCHAR(200) NOT NULL,
  `hsp_phone` VARCHAR(30) NOT NULL,
  `hsp_per_id` INT(11) NULL DEFAULT NULL,
  `hsp_sit_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`hsp_id`),
  INDEX `fk_hospital_hospital_sittuation1_idx` (`hsp_sit_id` ASC) VISIBLE,
  INDEX `fk_hospital_person1_idx` (`hsp_per_id` ASC) VISIBLE,
  CONSTRAINT `fk_hospital_hospital_sittuation1`
    FOREIGN KEY (`hsp_sit_id`)
    REFERENCES `logic685_stagiopbd`.`hospital_sittuation` (`sit_id`),
  CONSTRAINT `fk_hospital_person1`
    FOREIGN KEY (`hsp_per_id`)
    REFERENCES `logic685_stagiopbd`.`person` (`per_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`medical_speciality`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`medical_speciality` (
  `msp_code` INT(11) NOT NULL,
  `msp_name` VARCHAR(127) NOT NULL,
  PRIMARY KEY (`msp_code`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`hospital_wing`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`hospital_wing` (
  `wng_id` INT(11) NOT NULL,
  `wng_type` VARCHAR(45) NULL DEFAULT NULL,
  `wng_msp_code` INT(11) NOT NULL,
  `wng_sit_id` INT(11) NOT NULL,
  `wng_hsp_id` INT(11) NOT NULL,
  PRIMARY KEY (`wng_id`),
  INDEX `fk_hospital_wing_medical_speciality1_idx` (`wng_msp_code` ASC) VISIBLE,
  INDEX `fk_hospital_wing_hospital_sittuation1_idx` (`wng_sit_id` ASC) VISIBLE,
  INDEX `fk_hospital_wing_hospital1_idx` (`wng_hsp_id` ASC) VISIBLE,
  CONSTRAINT `fk_hospital_wing_hospital1`
    FOREIGN KEY (`wng_hsp_id`)
    REFERENCES `logic685_stagiopbd`.`hospital` (`hsp_id`),
  CONSTRAINT `fk_hospital_wing_hospital_sittuation1`
    FOREIGN KEY (`wng_sit_id`)
    REFERENCES `logic685_stagiopbd`.`hospital_sittuation` (`sit_id`),
  CONSTRAINT `fk_hospital_wing_medical_speciality1`
    FOREIGN KEY (`wng_msp_code`)
    REFERENCES `logic685_stagiopbd`.`medical_speciality` (`msp_code`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`patient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`patient` (
  `pat_cpf` VARCHAR(11) NOT NULL,
  `pat_name` VARCHAR(200) NOT NULL,
  `pat_gender` VARCHAR(1) NOT NULL,
  `pat_blood_type` VARCHAR(1) NOT NULL,
  `pat_birthdate` DATE NOT NULL,
  `pat_ppl_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`pat_cpf`),
  INDEX `fk_patient_people1_idx` (`pat_ppl_id` ASC) VISIBLE,
  CONSTRAINT `fk_patient_people1`
    FOREIGN KEY (`pat_ppl_id`)
    REFERENCES `logic685_stagiopbd`.`person` (`per_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`patient_health`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`patient_health` (
  `phl_pat_cpf` VARCHAR(11) NOT NULL,
  `phl_weight` FLOAT NOT NULL,
  `phl_height` FLOAT NOT NULL,
  `phl_imc` VARCHAR(50) NULL DEFAULT NULL,
  `phl_smokeoften` VARCHAR(10) NOT NULL,
  `phl_drinkoften` VARCHAR(10) NOT NULL,
  `phl_trainingoften` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`phl_pat_cpf`),
  INDEX `fk_patient_health_patient1_idx` (`phl_pat_cpf` ASC) VISIBLE,
  CONSTRAINT `fk_patient_health_patient1`
    FOREIGN KEY (`phl_pat_cpf`)
    REFERENCES `logic685_stagiopbd`.`patient` (`pat_cpf`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`bedroom`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`bedroom` (
  `bed_id` INT(11) NOT NULL,
  `bed_wng_id` INT(11) NOT NULL,
  `bed_pat_cpf` VARCHAR(11) NULL DEFAULT NULL,
  PRIMARY KEY (`bed_id`),
  INDEX `fk_bedroom_hospital_wing1_idx` (`bed_wng_id` ASC) VISIBLE,
  INDEX `fk_bedroom_patient_health1_idx` (`bed_pat_cpf` ASC) VISIBLE,
  CONSTRAINT `fk_bedroom_hospital_wing1`
    FOREIGN KEY (`bed_wng_id`)
    REFERENCES `logic685_stagiopbd`.`hospital_wing` (`wng_id`),
  CONSTRAINT `fk_bedroom_patient_health1`
    FOREIGN KEY (`bed_pat_cpf`)
    REFERENCES `logic685_stagiopbd`.`patient_health` (`phl_pat_cpf`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`exam_group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`exam_group` (
  `exg_id` INT(11) NOT NULL AUTO_INCREMENT,
  `exg_name` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`exg_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`exam_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`exam_item` (
  `exi_id` INT(11) NOT NULL AUTO_INCREMENT,
  `exi_name` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`exi_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`physician`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`physician` (
  `phy_cpf` VARCHAR(11) NOT NULL,
  `phy_phone_pro` VARCHAR(15) NULL DEFAULT NULL,
  `phy_per_id` INT(11) NOT NULL,
  PRIMARY KEY (`phy_cpf`),
  INDEX `fk_physician_people1_idx` (`phy_per_id` ASC) VISIBLE,
  CONSTRAINT `fk_physician_people1`
    FOREIGN KEY (`phy_per_id`)
    REFERENCES `logic685_stagiopbd`.`person` (`per_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`supplier_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`supplier_type` (
  `spt_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `spt_name` VARCHAR(128) NOT NULL,
  `spt_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `spt_updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`spt_id`),
  UNIQUE INDEX `nome` (`spt_name` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`supplier`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`supplier` (
  `sup_id` INT(11) NOT NULL AUTO_INCREMENT,
  `sup_fantasy_name` VARCHAR(100) NOT NULL,
  `sup_open_date` DATETIME NULL DEFAULT NULL,
  `sup_spt_id` INT(10) UNSIGNED NOT NULL,
  `sup_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sup_updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sup_deleted_at` TIMESTAMP NULL DEFAULT NULL,
  `sup_ppl_id` INT(11) NOT NULL,
  PRIMARY KEY (`sup_id`),
  INDEX `fk_tipo_fornecedor` (`sup_spt_id` ASC) VISIBLE,
  INDEX `fk_supplier_people1_idx` (`sup_ppl_id` ASC) VISIBLE,
  CONSTRAINT `fk_supplier_people1`
    FOREIGN KEY (`sup_ppl_id`)
    REFERENCES `logic685_stagiopbd`.`person` (`per_id`),
  CONSTRAINT `fk_tipo_fornecedor`
    FOREIGN KEY (`sup_spt_id`)
    REFERENCES `logic685_stagiopbd`.`supplier_type` (`spt_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`exam_request`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`exam_request` (
  `exr_id` INT(11) NOT NULL AUTO_INCREMENT,
  `exr_phy_cpf` VARCHAR(11) NOT NULL,
  `exr_pat_cpf` VARCHAR(11) NOT NULL,
  `exr_sup_id` INT(11) NOT NULL,
  `exr_hsp_id` INT(11) NOT NULL,
  `exr_date_request` DATETIME NULL DEFAULT NULL,
  `exr_date_forecast_release` DATETIME NULL DEFAULT NULL,
  `exr_date_delivery` DATETIME NULL DEFAULT NULL,
  `exr_urgency` TINYINT(4) NULL DEFAULT NULL COMMENT '1-Yes\\n2-No',
  PRIMARY KEY (`exr_id`),
  INDEX `fk_exam_request_physician1_idx` (`exr_phy_cpf` ASC) VISIBLE,
  INDEX `fk_exam_request_patient1_idx` (`exr_pat_cpf` ASC) VISIBLE,
  INDEX `fk_exam_request_supplier1_idx` (`exr_sup_id` ASC) VISIBLE,
  INDEX `fk_exam_request_hospital1_idx` (`exr_hsp_id` ASC) VISIBLE,
  CONSTRAINT `fk_exam_request_hospital1`
    FOREIGN KEY (`exr_hsp_id`)
    REFERENCES `logic685_stagiopbd`.`hospital` (`hsp_id`),
  CONSTRAINT `fk_exam_request_patient1`
    FOREIGN KEY (`exr_pat_cpf`)
    REFERENCES `logic685_stagiopbd`.`patient` (`pat_cpf`),
  CONSTRAINT `fk_exam_request_physician1`
    FOREIGN KEY (`exr_phy_cpf`)
    REFERENCES `logic685_stagiopbd`.`physician` (`phy_cpf`),
  CONSTRAINT `fk_exam_request_supplier1`
    FOREIGN KEY (`exr_sup_id`)
    REFERENCES `logic685_stagiopbd`.`supplier` (`sup_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`exam_subitem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`exam_subitem` (
  `exs_id` INT(11) NOT NULL AUTO_INCREMENT,
  `exs_name` VARCHAR(45) NULL DEFAULT NULL,
  `exs_exi_id` INT(11) NOT NULL,
  PRIMARY KEY (`exs_id`),
  INDEX `fk_exam_subitem_exam_item1_idx` (`exs_exi_id` ASC) VISIBLE,
  CONSTRAINT `fk_exam_subitem_exam_item1`
    FOREIGN KEY (`exs_exi_id`)
    REFERENCES `logic685_stagiopbd`.`exam_item` (`exi_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`exam_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`exam_type` (
  `ext_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ext_exg_id` INT(11) NOT NULL,
  `ext_exs_id` INT(11) NOT NULL,
  `ext_code` CHAR(15) NULL DEFAULT NULL,
  `ext_description` VARCHAR(100) NULL DEFAULT NULL,
  `ext_technical` VARCHAR(45) NULL DEFAULT NULL,
  `ext_indication` VARCHAR(45) NULL DEFAULT NULL,
  `ext_details` TINYTEXT NULL DEFAULT NULL,
  `ext_paraminitial` FLOAT NULL DEFAULT NULL,
  `ext_paramfinal` FLOAT NULL DEFAULT NULL,
  PRIMARY KEY (`ext_id`),
  INDEX `fk_exam_type_exam_group1_idx` (`ext_exg_id` ASC) VISIBLE,
  INDEX `fk_exam_type_exam_subitem1_idx` (`ext_exs_id` ASC) VISIBLE,
  CONSTRAINT `fk_exam_type_exam_group1`
    FOREIGN KEY (`ext_exg_id`)
    REFERENCES `logic685_stagiopbd`.`exam_group` (`exg_id`),
  CONSTRAINT `fk_exam_type_exam_subitem1`
    FOREIGN KEY (`ext_exs_id`)
    REFERENCES `logic685_stagiopbd`.`exam_subitem` (`exs_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`exam_request_has_exam_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`exam_request_has_exam_type` (
  `ert_exr_id` INT(11) NOT NULL,
  `ert_ext_id` INT(11) NOT NULL,
  `ert_measurement` FLOAT NULL DEFAULT NULL,
  `ert_collect_date` DATETIME NULL DEFAULT NULL,
  `ert_rpt_id` INT(11) NOT NULL,
  PRIMARY KEY (`ert_exr_id`, `ert_ext_id`),
  INDEX `fk_exam_request_has_exam_type_exam_type1_idx` (`ert_ext_id` ASC) VISIBLE,
  INDEX `fk_exam_request_has_exam_type_exam_request1_idx` (`ert_exr_id` ASC) VISIBLE,
  INDEX `fk_exam_request_has_exam_type_responsible_technician1_idx` (`ert_rpt_id` ASC) VISIBLE,
  CONSTRAINT `fk_exam_request_has_exam_type_exam_request1`
    FOREIGN KEY (`ert_exr_id`)
    REFERENCES `logic685_stagiopbd`.`exam_request` (`exr_id`),
  CONSTRAINT `fk_exam_request_has_exam_type_exam_type1`
    FOREIGN KEY (`ert_ext_id`)
    REFERENCES `logic685_stagiopbd`.`exam_type` (`ext_id`),
  CONSTRAINT `fk_exam_request_has_exam_type_responsible_technician1`
    FOREIGN KEY (`ert_rpt_id`)
    REFERENCES `logic685_stagiopbd`.`responsible_technician` (`rpt_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`medicaldiagnosis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`medicaldiagnosis` (
  `cid_id` INT(10) UNSIGNED NOT NULL,
  `cid_diagnosis` TINYTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`cid_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`medicalconsultationdiagnosis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`medicalconsultationdiagnosis` (
  `mcd_id` INT(11) NOT NULL,
  `mcd_cid_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`mcd_id`),
  INDEX `fk_medicalconsultationdiagnosis_medicaldiagnosis1_idx` (`mcd_cid_id` ASC) VISIBLE,
  CONSTRAINT `fk_medicalconsultationdiagnosis_medicaldiagnosis1`
    FOREIGN KEY (`mcd_cid_id`)
    REFERENCES `logic685_stagiopbd`.`medicaldiagnosis` (`cid_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`symptoms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`symptoms` (
  `stm_id` INT(11) NOT NULL,
  `stm_symptoms` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`stm_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`medicalconsultation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`medicalconsultation` (
  `cns_id` INT(11) NOT NULL,
  `cns_objectives` VARCHAR(255) NULL DEFAULT NULL,
  `cns_comments` VARCHAR(255) NULL DEFAULT NULL,
  `cns_consultationDate` DATE NULL DEFAULT NULL,
  `cns_createdAt` DATETIME NOT NULL,
  `cns_updatedAt` DATETIME NOT NULL,
  `cns_cid10_id` INT(10) NOT NULL,
  `cns_pat_cpf` VARCHAR(11) NOT NULL,
  `cns_phy_cpf` VARCHAR(11) NOT NULL,
  `cns_stm_id` INT(11) NOT NULL,
  `cns_mcd_id` INT(11) NOT NULL,
  PRIMARY KEY (`cns_id`),
  INDEX `fk_medicalconsultation_patient1_idx` (`cns_pat_cpf` ASC) VISIBLE,
  INDEX `fk_medicalconsultation_physician1_idx` (`cns_phy_cpf` ASC) VISIBLE,
  INDEX `fk_medicalconsultation_patient_has_symptoms1_idx` (`cns_stm_id` ASC) VISIBLE,
  INDEX `fk_medicalconsultation_medicalconsultationdiagnosis1_idx` (`cns_mcd_id` ASC) VISIBLE,
  CONSTRAINT `fk_medicalconsultation_medicalconsultationdiagnosis1`
    FOREIGN KEY (`cns_mcd_id`)
    REFERENCES `logic685_stagiopbd`.`medicalconsultationdiagnosis` (`mcd_id`),
  CONSTRAINT `fk_medicalconsultation_patient1`
    FOREIGN KEY (`cns_pat_cpf`)
    REFERENCES `logic685_stagiopbd`.`patient` (`pat_cpf`),
  CONSTRAINT `fk_medicalconsultation_patient_has_symptoms1`
    FOREIGN KEY (`cns_stm_id`)
    REFERENCES `logic685_stagiopbd`.`symptoms` (`stm_id`),
  CONSTRAINT `fk_medicalconsultation_physician1`
    FOREIGN KEY (`cns_phy_cpf`)
    REFERENCES `logic685_stagiopbd`.`physician` (`phy_cpf`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`medicalconsultationprocedure`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`medicalconsultationprocedure` (
  `mcp_id` INT(11) NOT NULL,
  `mcp_procedureCode` INT(11) NULL DEFAULT NULL,
  `mcp_cns_id` INT(11) NOT NULL,
  PRIMARY KEY (`mcp_id`),
  INDEX `fk_medicalconsultationprocedure_medicalconsultation1_idx` (`mcp_cns_id` ASC) VISIBLE,
  CONSTRAINT `fk_medicalconsultationprocedure_medicalconsultation1`
    FOREIGN KEY (`mcp_cns_id`)
    REFERENCES `logic685_stagiopbd`.`medicalconsultation` (`cns_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`product_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`product_type` (
  `pdt_id` INT(11) NOT NULL AUTO_INCREMENT,
  `pdt_description` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`pdt_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`stripe`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`stripe` (
  `stp_id` INT(11) NOT NULL AUTO_INCREMENT,
  `stp_description` VARCHAR(15) NULL DEFAULT NULL,
  PRIMARY KEY (`stp_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`therapeutic_class`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`therapeutic_class` (
  `thc_id` INT(11) NOT NULL AUTO_INCREMENT,
  `thc_descripition` VARCHAR(120) NULL DEFAULT NULL,
  `thc_code` CHAR(5) NULL DEFAULT NULL,
  PRIMARY KEY (`thc_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`medicine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`medicine` (
  `med_id` INT(11) NOT NULL AUTO_INCREMENT,
  `med_active_principle` MEDIUMTEXT NULL DEFAULT NULL,
  `med_code_ggrem` CHAR(15) NULL DEFAULT NULL,
  `med_register` CHAR(13) NULL DEFAULT NULL,
  `med_ean1` CHAR(14) NULL DEFAULT NULL,
  `med_ean2` CHAR(14) NULL DEFAULT NULL,
  `med_ean3` CHAR(14) NULL DEFAULT NULL,
  `med_product_description` VARCHAR(120) NULL DEFAULT NULL,
  `med_presentation` VARCHAR(200) NULL DEFAULT NULL,
  `med_hospital_restrictions` TINYINT(4) NULL DEFAULT NULL,
  `med_cap` TINYINT(4) NULL DEFAULT NULL,
  `med_confaz87` TINYINT(4) NULL DEFAULT NULL,
  `med_marketing_year` INT(4) NULL DEFAULT NULL,
  `med_sup_id` INT(11) NOT NULL,
  `med_thc_id` INT(11) NOT NULL,
  `med_pdt_id` INT(11) NOT NULL,
  `med_stp_id` INT(11) NOT NULL,
  PRIMARY KEY (`med_id`),
  INDEX `fk_medicine_supplier1_idx` (`med_sup_id` ASC) VISIBLE,
  INDEX `fk_medicine_therapeutic_class1_idx` (`med_thc_id` ASC) VISIBLE,
  INDEX `fk_medicine_product_type1_idx` (`med_pdt_id` ASC) VISIBLE,
  INDEX `fk_medicine_stripe1_idx` (`med_stp_id` ASC) VISIBLE,
  CONSTRAINT `fk_medicine_product_type1`
    FOREIGN KEY (`med_pdt_id`)
    REFERENCES `logic685_stagiopbd`.`product_type` (`pdt_id`),
  CONSTRAINT `fk_medicine_stripe1`
    FOREIGN KEY (`med_stp_id`)
    REFERENCES `logic685_stagiopbd`.`stripe` (`stp_id`),
  CONSTRAINT `fk_medicine_supplier1`
    FOREIGN KEY (`med_sup_id`)
    REFERENCES `logic685_stagiopbd`.`supplier` (`sup_id`),
  CONSTRAINT `fk_medicine_therapeutic_class1`
    FOREIGN KEY (`med_thc_id`)
    REFERENCES `logic685_stagiopbd`.`therapeutic_class` (`thc_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`password_resets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`password_resets` (
  `psw_email` VARCHAR(255) NOT NULL,
  `psw_token` VARCHAR(255) NOT NULL,
  `psw_created_at` TIMESTAMP NULL DEFAULT NULL,
  INDEX `password_resets_idx` (`psw_email`(191) ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`patient_has_allergy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`patient_has_allergy` (
  `palg_pat_cpf` VARCHAR(11) NOT NULL,
  `palg_id` INT(11) NOT NULL,
  `palg_dgn_id` INT(11) NULL DEFAULT NULL,
  `palg_date` DATE NOT NULL,
  PRIMARY KEY (`palg_pat_cpf`, `palg_id`),
  INDEX `fk_patient_has_allergy_allergy1_idx` (`palg_id` ASC) VISIBLE,
  INDEX `fk_patient_has_allergy_patient1_idx` (`palg_pat_cpf` ASC) VISIBLE,
  CONSTRAINT `fk_patient_has_allergy_allergy1`
    FOREIGN KEY (`palg_id`)
    REFERENCES `logic685_stagiopbd`.`allergy` (`alg_id`),
  CONSTRAINT `fk_patient_has_allergy_patient1`
    FOREIGN KEY (`palg_pat_cpf`)
    REFERENCES `logic685_stagiopbd`.`patient` (`pat_cpf`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`physician_speciality`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`physician_speciality` (
  `spc_msp_code` INT(11) NOT NULL,
  `spc_phy_cpf` VARCHAR(11) NOT NULL,
  INDEX `fk_physician_speciality_medical_speciality1_idx` (`spc_msp_code` ASC) VISIBLE,
  INDEX `fk_physician_speciality_physician1_idx` (`spc_phy_cpf` ASC) VISIBLE,
  CONSTRAINT `fk_physician_speciality_medical_speciality1`
    FOREIGN KEY (`spc_msp_code`)
    REFERENCES `logic685_stagiopbd`.`medical_speciality` (`msp_code`),
  CONSTRAINT `fk_physician_speciality_physician1`
    FOREIGN KEY (`spc_phy_cpf`)
    REFERENCES `logic685_stagiopbd`.`physician` (`phy_cpf`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `logic685_stagiopbd`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logic685_stagiopbd`.`users` (
  `usr_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usr_name` VARCHAR(255) NOT NULL,
  `usr_email` VARCHAR(128) NOT NULL,
  `usr_password` VARCHAR(255) NOT NULL,
  `usr_remember_token` VARCHAR(100) NOT NULL,
  `usr_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usr_id`),
  UNIQUE INDEX `usr_email` (`usr_email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
