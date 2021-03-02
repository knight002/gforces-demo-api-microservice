-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema dbname
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbname
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbname` DEFAULT CHARACTER SET 'utf8mb4' ;
USE `dbname` ;

-- -----------------------------------------------------
-- Table `dbname`.`models`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbname`.`models` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(45) NULL,
  `make` VARCHAR(45) NULL DEFAULT NULL,
  `model` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = 'utf8mb4';

CREATE UNIQUE INDEX `uuid_UNIQUE` ON `dbname`.`models` (`uuid` ASC);


-- -----------------------------------------------------
-- Table `dbname`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbname`.`orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(45) CHARACTER SET 'utf8mb4' NOT NULL,
  `model_id` INT(11) NULL DEFAULT NULL,
  `total` DOUBLE NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `orders_model_id_fk`
    FOREIGN KEY (`model_id`)
    REFERENCES `dbname`.`models` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 35
DEFAULT CHARACTER SET = 'utf8mb4';

CREATE UNIQUE INDEX `guid_UNIQUE` ON `dbname`.`orders` (`uuid` ASC);

CREATE INDEX `orders_model_id_fk_idx` ON `dbname`.`orders` (`model_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
