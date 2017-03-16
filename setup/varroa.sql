--
-- Database: varroa
--
PRAGMA encoding = "UTF-8"; 

-- --------------------------------------------------------
-- Information about the beekeeper
CREATE TABLE beekeeper (
   beekeeperid INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   name varchar(128) COLLATE NOCASE NOT NULL,
   email varchar(128) COLLATE NOCASE NOT NULL,
   password varchar(128) NOT NULL
);

-- --------------------------------------------------------
-- Records logins by this user
CREATE TABLE logins (
   beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE,
   time INTEGER NOT NULL
);

-- --------------------------------------------------------
-- Information about the beekeeper's apiaries
CREATE TABLE apiary (
   apiaryid INTEGER NOT NULL,
   beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE,
   name varchar(128) COLLATE NOCASE NOT NULL,
   location varchar(256),
   colonies INTEGER,
   PRIMARY KEY (beekeeperid, apiaryid)
);

-- --------------------------------------------------------
-- Information about the beekeeper's hives in each apiary
CREATE TABLE hive (
   queenid INTEGER NOT NULL,
   apiaryid INTEGER REFERENCES apiary (apiaryid) ON DELETE CASCADE,
   beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE,
   age INTEGER DEFAULT NULL,
   islocal INTEGER DEFAULT NULL,
   PRIMARY KEY (beekeeperid, apiaryid, queenid)
);

-- --------------------------------------------------------
-- The inspections of the hives
CREATE TABLE inspection (
   queenid INTEGER REFERENCES hive (queenid) ON DELETE CASCADE,
   apiaryid INTEGER REFERENCES apiary (apiaryid) ON DELETE CASCADE,
   beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE,
   timestamp INTEGER NOT NULL,
   lasttreated INTEGER DEFAULT NULL,
   mitecount INTEGER NOT NULL,
   comments varchar(1024),
   broodpct INTEGER NOT NULL,
   open INTEGER NOT NULL,
   drones INTEGER NOT NULL,
   docility INTEGER NOT NULL,
   steadiness INTEGER NOT NULL,
   pattern INTEGER NOT NULL,
   pollen INTEGER NOT NULL,
   comb INTEGER NOT NULL
);


