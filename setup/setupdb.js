var sqlite3 = require('sqlite3').verbose();
var db = new sqlite3.Database('db/varroarecords.db');
var check;
db.serialize(function() {
   console.log("beekeeper: Information about the beekeeper");
   db.run("CREATE TABLE IF NOT EXISTS beekeeper ( beekeeperid INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, name varchar(128) COLLATE NOCASE NOT NULL, email varchar(128) COLLATE NOCASE NOT NULL, password varchar(128) NOT NULL, admin INTEGER DEFAULT 0)");

   console.log("logins: Records logins by this user");
   db.run("CREATE TABLE IF NOT EXISTS logins ( beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE, time INTEGER NOT NULL)");

   console.log("apiary: Information about the beekeeper's apiaries");
   db.run("CREATE TABLE IF NOT EXISTS apiary ( apiaryid INTEGER NOT NULL, beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE, name varchar(128) COLLATE NOCASE NOT NULL, location varchar(256), colonies INTEGER DEFAULT 0, PRIMARY KEY (beekeeperid, apiaryid))");

   console.log("hive: Information about the beekeeper's hives in each apiary");
   db.run("CREATE TABLE IF NOT EXISTS hive ( queenid INTEGER NOT NULL, apiaryid INTEGER REFERENCES apiary (apiaryid) ON DELETE CASCADE, beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE, age INTEGER DEFAULT 0, islocal INTEGER DEFAULT 0, PRIMARY KEY (beekeeperid, apiaryid, queenid))");

   console.log("inspection: The inspections of the hives");
   db.run("CREATE TABLE IF NOT EXISTS inspection ( queenid INTEGER REFERENCES hive (queenid) ON DELETE CASCADE, apiaryid INTEGER REFERENCES apiary (apiaryid) ON DELETE CASCADE, beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE, timestamp INTEGER NOT NULL, lasttreated INTEGER DEFAULT NULL, mitecount INTEGER NOT NULL, comments varchar(1024), broodpct INTEGER NOT NULL, open INTEGER NOT NULL, drones INTEGER NOT NULL, docility INTEGER NOT NULL, steadiness INTEGER NOT NULL, pattern INTEGER NOT NULL, pollen INTEGER NOT NULL, comb INTEGER NOT NULL)");

   console.log("Adding administrators");
   db.run("INSERT INTO beekeeper (name, email, password, admin) VALUES ('Brendan Murray', 'brendanpmurray@gmail.com', 'XXX', 1), ('Keith Browne', 'k.browne4@nuigalway.ie', 'XXX', 1)");
});
db.close();

