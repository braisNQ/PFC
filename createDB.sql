-- Plataforma de xestión de torneos online
-- Modificado: 2014/07/24
--
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema pfc
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `pfc` ;
CREATE SCHEMA IF NOT EXISTS `pfc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `pfc` ;

-- -----------------------------------------------------
-- Table `pfc`.`Equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pfc`.`Equipo` ;

CREATE TABLE IF NOT EXISTS `pfc`.`Equipo` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `ID_propietario` INT NOT NULL,
  `codigo_ingreso` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  INDEX `ID_propietario_idx` (`ID_propietario` ASC),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC),
  CONSTRAINT `fk_ID_propietario_equipo`
    FOREIGN KEY (`ID_propietario`)
    REFERENCES `pfc`.`Usuario` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pfc`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pfc`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `pfc`.`Usuario` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(50) NOT NULL,
  `contrasinal` VARCHAR(50) NOT NULL,
  `nome` VARCHAR(50) NOT NULL,
  `tipo` TINYINT NOT NULL,
  `ID_equipo` INT NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC),
  UNIQUE INDEX `id_UNIQUE` (`ID` ASC),
  INDEX `ID_equipo_idx` (`ID_equipo` ASC),
  CONSTRAINT `fk_ID_equipo_usuario`
    FOREIGN KEY (`ID_equipo`)
    REFERENCES `pfc`.`Equipo` (`ID`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pfc`.`Torneo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pfc`.`Torneo` ;

CREATE TABLE IF NOT EXISTS `pfc`.`Torneo` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `numero_voltas` INT NOT NULL,
  `puntos_victoria` TINYINT NOT NULL,
  `puntos_empate` TINYINT NOT NULL,
  `puntos_derrota` TINYINT NOT NULL,
  `iniciado` VARCHAR(45) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pfc`.`Partido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pfc`.`Partido` ;

CREATE TABLE IF NOT EXISTS `pfc`.`Partido` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `ID_torneo` INT NOT NULL,
  `ID_equipo1` INT NOT NULL,
  `ID_equipo2` INT NOT NULL,
  `data` DATETIME NULL,
  `data_modificado` INT NULL,
  `data_confirmada` TINYINT(1) NOT NULL DEFAULT 0,
  `resultado_eq1` INT NULL,
  `resultado_eq2` INT NULL,
  `resultado_modificado` INT NULL,
  `resultado_confirmado` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  INDEX `ID_torneo_idx` (`ID_torneo` ASC),
  INDEX `ID_equipo1_idx` (`ID_equipo1` ASC),
  INDEX `ID_equipo2_idx` (`ID_equipo2` ASC),
  CONSTRAINT `fk_ID_torneo_partido`
    FOREIGN KEY (`ID_torneo`)
    REFERENCES `pfc`.`Torneo` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ID_equipo1_partido`
    FOREIGN KEY (`ID_equipo1`)
    REFERENCES `pfc`.`Equipo` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ID_equipo2_partido`
    FOREIGN KEY (`ID_equipo2`)
    REFERENCES `pfc`.`Equipo` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pfc`.`Incidencia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pfc`.`Incidencia` ;

CREATE TABLE IF NOT EXISTS `pfc`.`Incidencia` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `ID_partido` INT NOT NULL,
  `ID_creador` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  INDEX `ID_partido_idx` (`ID_partido` ASC),
  INDEX `ID_creador_idx` (`ID_creador` ASC),
  CONSTRAINT `fk_ID_partido_incidencia`
    FOREIGN KEY (`ID_partido`)
    REFERENCES `pfc`.`Partido` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ID_creador_incidencia`
    FOREIGN KEY (`ID_creador`)
    REFERENCES `pfc`.`Usuario` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pfc`.`Mensaxe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pfc`.`Mensaxe` ;

CREATE TABLE IF NOT EXISTS `pfc`.`Mensaxe` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `ID_remitente` INT NOT NULL,
  `ID_destinatario` INT NOT NULL,
  `ID_Resposta` INT NULL,
  `ID_incidencia` INT NULL,
  `data` DATETIME NOT NULL,
  `asunto` VARCHAR(50) NOT NULL,
  `texto` TEXT NOT NULL,
  `visto` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  INDEX `ID_resposta_idx` (`ID_Resposta` ASC),
  INDEX `ID_incidencia_idx` (`ID_incidencia` ASC),
  INDEX `ID_remitente_idx` (`ID_remitente` ASC),
  INDEX `ID_destinatario_idx` (`ID_destinatario` ASC),
  CONSTRAINT `fk_ID_resposta_mensaxe`
    FOREIGN KEY (`ID_Resposta`)
    REFERENCES `pfc`.`Mensaxe` (`ID`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ID_incidencia_mensaxe`
    FOREIGN KEY (`ID_incidencia`)
    REFERENCES `pfc`.`Incidencia` (`ID`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ID_remitente_mensaxe`
    FOREIGN KEY (`ID_remitente`)
    REFERENCES `pfc`.`Usuario` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ID_destinatario_mensaxe`
    FOREIGN KEY (`ID_destinatario`)
    REFERENCES `pfc`.`Usuario` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pfc`.`EquipoTorneo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pfc`.`EquipoTorneo` ;

CREATE TABLE IF NOT EXISTS `pfc`.`EquipoTorneo` (
  `ID_torneo` INT NOT NULL,
  `ID_equipo` INT NOT NULL,
  PRIMARY KEY (`ID_torneo`, `ID_equipo`),
  INDEX `ID_equipo_idx` (`ID_equipo` ASC),
  CONSTRAINT `fk_ID_torneo_equipotorneo`
    FOREIGN KEY (`ID_torneo`)
    REFERENCES `pfc`.`Torneo` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ID_equipo_equipotorneo`
    FOREIGN KEY (`ID_equipo`)
    REFERENCES `pfc`.`Equipo` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pfc`.`TorneoModerador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pfc`.`TorneoModerador` ;

CREATE TABLE IF NOT EXISTS `pfc`.`TorneoModerador` (
  `ID_torneo` INT NOT NULL,
  `ID_moderador` INT NOT NULL,
  PRIMARY KEY (`ID_torneo`, `ID_moderador`),
  INDEX `ID_moderador_idx` (`ID_moderador` ASC),
  CONSTRAINT `fk_ID_torneo_torneomoderador`
    FOREIGN KEY (`ID_torneo`)
    REFERENCES `pfc`.`Torneo` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ID_moderador_torneomoderador`
    FOREIGN KEY (`ID_moderador`)
    REFERENCES `pfc`.`Usuario` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `pfc`.`Usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `pfc`;
INSERT INTO `pfc`.`Usuario` (`ID`, `login`, `contrasinal`, `nome`, `tipo`, `ID_equipo`) VALUES (1, 'administrador', '91f5167c34c400758115c2a6826ec2e3', 'administrador', 1, NULL);

COMMIT;

