CREATE TABLE `marts_database`.`library` (
  `libraryID` INT(11) NOT NULL,
  `libraryName` LONGTEXT NULL,
  `rating` INT(11) NULL,
  `images` LONGTEXT NULL,
  `latitude` DOUBLE NULL,
  `longitude` DOUBLE NULL,
  PRIMARY KEY (`libraryID`));

CREATE TABLE `marts_database`.`Review` (
  `reviewID` INT(11) NOT NULL,
  `libraryID` INT(11) NULL,
  `userID` INT(11) NULL,
  `rating` VARCHAR(45) NULL,
  `comments` LONGTEXT NULL,
  PRIMARY KEY (`reviewID`));

CREATE TABLE `marts_database`.`User` (
  `userID` INT(11) NOT NULL,
  `userName` VARCHAR(45) NULL,
  `userPhoto` VARCHAR(45) NULL,
  `userPass` LONGTEXT NULL,
  `userSalt` MEDIUMTEXT NULL,
  `userEmail` MEDIUMTEXT NULL,
  `userBirthday` MEDIUMTEXT NULL,
  PRIMARY KEY (`userID`));

