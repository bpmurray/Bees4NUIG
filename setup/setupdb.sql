SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";

--
-- Database: `varroarecords`
--
CREATE DATABASE IF NOT EXISTS varroarecords
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_unicode_ci;

USE varroarecords;

--
-- Delete the tables
--
DROP TABLE IF EXISTS inspection;
DROP TABLE IF EXISTS hive;
DROP TABLE IF EXISTS apiary;
DROP TABLE IF EXISTS logins;
DROP TABLE IF EXISTS beekeeper;

--
-- Table: `beekeeper`
--
CREATE TABLE IF NOT EXISTS `beekeeper` (
       	beekeeperid INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
       	name TEXT NOT NULL,
       	email TEXT NOT NULL,
       	password TEXT NOT NULL,
       	salt TEXT NOT NULL,
       	token TEXT NOT NULL,
       	timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	activated TINYINT(1) DEFAULT 0,
       	admin INTEGER DEFAULT 0
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table: `logins`
--
CREATE TABLE IF NOT EXISTS `logins` (
       	beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE,
       	time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table: `apiary`
--
CREATE TABLE IF NOT EXISTS `apiary` (
       	apiaryid INTEGER AUTO_INCREMENT,
       	beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE,
       	name TEXT NOT NULL,
       	location TEXT,
       	colonies INTEGER DEFAULT 0,
       	PRIMARY KEY (apiaryid, beekeeperid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table: `hive`
--
CREATE TABLE IF NOT EXISTS `hive` (
       	queenid INTEGER NOT NULL,
       	apiaryid INTEGER REFERENCES apiary (apiaryid) ON DELETE CASCADE,
       	beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE,
       	age INTEGER DEFAULT 0,
       	islocal INTEGER DEFAULT 0,
       	PRIMARY KEY (beekeeperid, apiaryid, queenid)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table: `inspection`
--
CREATE TABLE IF NOT EXISTS `inspection` (
       	queenid INTEGER REFERENCES hive (queenid) ON DELETE CASCADE,
       	apiaryid INTEGER REFERENCES apiary (apiaryid) ON DELETE CASCADE,
       	beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE,
       	time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
       	lasttreated DATE DEFAULT NULL,
       	mitecount INTEGER NOT NULL,
       	comments TEXT,
       	broodpct INTEGER NOT NULL,
       	open INTEGER NOT NULL,
       	drones INTEGER NOT NULL,
       	docility INTEGER NOT NULL,
       	steadiness INTEGER NOT NULL,
       	pattern INTEGER NOT NULL,
       	pollen INTEGER NOT NULL,
       	comb INTEGER NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

