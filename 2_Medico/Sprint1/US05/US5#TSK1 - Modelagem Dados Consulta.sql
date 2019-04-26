CREATE TABLE `PHYSICIAN`
(
  `phy_cpf` int PRIMARY KEY,
  `phy_name` varchar(255),
  `phy_email` varchar(255) UNIQUE,
  `phy_gender` varchar(255),
  `phy_birth` varchar(255),
  `phy_specialty` varchar(255)
);

CREATE TABLE `HOSPITAL_APPOIMENTS`
(
  `phy_cpf` int PRIMARY KEY,
  `app_id` int,
  `app_date` varchar(255),
  `app_procedure` varchar(255)
);

CREATE TABLE `PATIENT`
(
  `app_id` int PRIMARY KEY,
  `pat_cpf` varchar(255),
  `pat_name` varchar(255)
);

CREATE TABLE `APPOIMENT_LOCATION`
(
  `app_id` int PRIMARY KEY,
  `app_location` varchar(255)
);

ALTER TABLE `HOSPITAL_APPOIMENTS` ADD FOREIGN KEY (`phy_cpf`) REFERENCES `PHYSICIAN` (`phy_cpf`);

ALTER TABLE `PATIENT` ADD FOREIGN KEY (`app_id`) REFERENCES `HOSPITAL_APPOIMENTS` (`app_id`);

ALTER TABLE `APPOIMENT_LOCATION` ADD FOREIGN KEY (`app_id`) REFERENCES `PATIENT` (`app_id`);
