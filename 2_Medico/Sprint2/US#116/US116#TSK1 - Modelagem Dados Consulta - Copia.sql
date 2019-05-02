CREATE TABLE `Physician`
(
  `cpf` int PRIMARY KEY,
  `crm` int UNIQUE NOT NULL,
  `firstName` varchar(255),
  `lastName` varchar(255),
  `gender` enum,
  `birthDate` date,
  `phone` int,
  `email` varchar(255),
  `medicalSpecialty` varchar(255)
);

CREATE TABLE `Patient`
(
  `cpf` int PRIMARY KEY,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `phone` int,
  `email` varchar(255),
  `gender` enum,
  `birthDate` date,
  `addressId` int
);

CREATE TABLE `Address`
(
  `id` int PRIMARY KEY,
  `street` varchar(255) NOT NULL,
  `number` int NOT NULL,
  `complement` varchar(255),
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` int
);

CREATE TABLE `MedicalProcedure`
(
  `code` int PRIMARY KEY,
  `description` varchar(255) NOT NULL,
  `scale` tinytext,
  `operationalCost` float,
  `auxNumber` tinyint,
  `anesthesiaScale` tinyint,
  `categoryCode` int
);

CREATE TABLE `MedicalProcedureChapterCategory`
(
  `code` int PRIMARY KEY,
  `name` varchar(255) UNIQUE NOT NULL,
  `chapterNumber` tinyint NOT NULL,
  `chapterDescription` varchar(255) NOT NULL
);

CREATE TABLE `MedicalDiagnosis`
(
  `cid10` tinytext PRIMARY KEY,
  `description` varchar(255) NOT NULL
);

CREATE TABLE `MedicalConsultation`
(
  `id` int PRIMARY KEY,
  `objectives` varchar(255),
  `comments` varchar(255),
  `consultationDate` date,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `patient_cpf` int NOT NULL,
  `physician_cpf` int NOT NULL,
  `addressId` int NOT NULL,
  `Cid10` int NOT NULL
);

CREATE TABLE `MedicalConsultationDiagnosis`
(
  `consultationId` int PRIMARY KEY,
  `diagnosisCid10` int PRIMARY KEY
);

CREATE TABLE `MedicalConsultationProcedure`
(
  `consultationId` int PRIMARY KEY,
  `procedureCode` int PRIMARY KEY
);

ALTER TABLE `MedicalConsultation` ADD FOREIGN KEY (`patient_cpf`) REFERENCES `Patient` (`cpf`);

ALTER TABLE `MedicalConsultation` ADD FOREIGN KEY (`physician_cpf`) REFERENCES `Physician` (`cpf`);

ALTER TABLE `Patient` ADD FOREIGN KEY (`addressId`) REFERENCES `Address` (`id`);

ALTER TABLE `MedicalConsultation` ADD FOREIGN KEY (`id`) REFERENCES `MedicalConsultationProcedure` (`consultationId`);

ALTER TABLE `MedicalConsultation` ADD FOREIGN KEY (`id`) REFERENCES `MedicalConsultationDiagnosis` (`consultationId`);

ALTER TABLE `MedicalConsultation` ADD FOREIGN KEY (`addressId`) REFERENCES `Address` (`id`);

ALTER TABLE `MedicalProcedure` ADD FOREIGN KEY (`code`) REFERENCES `MedicalConsultationProcedure` (`procedureCode`);

ALTER TABLE `MedicalDiagnosis` ADD FOREIGN KEY (`cid10`) REFERENCES `MedicalConsultationDiagnosis` (`diagnosisCid10`);

ALTER TABLE `MedicalProcedure` ADD FOREIGN KEY (`categoryCode`) REFERENCES `MedicalProcedureChapterCategory` (`code`);

ALTER TABLE `MedicalConsultation` ADD FOREIGN KEY (`Cid10`) REFERENCES `MedicalConsultationDiagnosis` (`diagnosisCid10`);
