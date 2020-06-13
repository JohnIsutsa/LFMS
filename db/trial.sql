CREATE TABLE `lfms`.`clients` ( `client_id` INT(11) NOT NULL AUTO_INCREMENT ,
 `client_name` VARCHAR(225) NOT NULL ,
  `contact_person_1` VARCHAR(225) NOT NULL ,
  `contact_person_2` VARCHAR(225) NOT NULL , 
  `email` VARCHAR(225) NOT NULL , 
  `phone` VARCHAR(225) NOT NULL , 
  `password` VARCHAR(225) NOT NULL , 
  `lawyer_id` INT(11) NOT NULL , 
  PRIMARY KEY (`client_id`(11))) ENGINE = InnoDB;