var crypto = require('crypto');
var sqlite3 = require('sqlite3').verbose();
var db = new sqlite3.Database('db/varroarecords.db');
var check;
db.serialize(function() {
   console.log("beekeeper: Information about the beekeeper");
   db.run("CREATE TABLE IF NOT EXISTS beekeeper ( beekeeperid INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, name TEXT COLLATE NOCASE NOT NULL, email TEXT COLLATE NOCASE NOT NULL, password TEXT NOT NULL, salt TEXT NOT NULL, admin INTEGER DEFAULT 0)");

   console.log("logins: Records logins by this user");
   db.run("CREATE TABLE IF NOT EXISTS logins ( beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE, time INTEGER NOT NULL)");

   console.log("apiary: Information about the beekeeper's apiaries");
   db.run("CREATE TABLE IF NOT EXISTS apiary ( apiaryid INTEGER NOT NULL, beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE, name TEXT COLLATE NOCASE NOT NULL, location TEXT, colonies INTEGER DEFAULT 0, PRIMARY KEY (beekeeperid, apiaryid))");

   console.log("hive: Information about the beekeeper's hives in each apiary");
   db.run("CREATE TABLE IF NOT EXISTS hive ( queenid INTEGER NOT NULL, apiaryid INTEGER REFERENCES apiary (apiaryid) ON DELETE CASCADE, beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE, age INTEGER DEFAULT 0, islocal INTEGER DEFAULT 0, PRIMARY KEY (beekeeperid, apiaryid, queenid))");

   console.log("inspection: The inspections of the hives");
   db.run("CREATE TABLE IF NOT EXISTS inspection ( queenid INTEGER REFERENCES hive (queenid) ON DELETE CASCADE, apiaryid INTEGER REFERENCES apiary (apiaryid) ON DELETE CASCADE, beekeeperid INTEGER REFERENCES beekeeper (beekeeperid) ON DELETE CASCADE, timestamp INTEGER NOT NULL, lasttreated INTEGER DEFAULT NULL, mitecount INTEGER NOT NULL, comments TEXT, broodpct INTEGER NOT NULL, open INTEGER NOT NULL, drones INTEGER NOT NULL, docility INTEGER NOT NULL, steadiness INTEGER NOT NULL, pattern INTEGER NOT NULL, pollen INTEGER NOT NULL, comb INTEGER NOT NULL)");

   console.log("Generating passwords");
   var ksalt = crypto.randomBytes(16).toString('hex');
   var khash = crypto.createHash('sha256');
   khash.update("Pa$$w0rd");
   khash.update(ksalt);
   var kpassword = khash.digest('hex');

   var bsalt = crypto.randomBytes(16).toString('hex');
   var bhash = crypto.createHash('sha256');
   bhash.update("Pa$$w0rd");
   bhash.update(bsalt);
   var bpassword = bhash.digest('hex');
   
   console.log("Adding administrators");
   db.run("INSERT INTO beekeeper (name, email, password, admin, salt) VALUES ('Brendan Murray', 'brendanpmurray@gmail.com', '" + bpassword + "', 1, '" + bsalt + "'), ('Keith Browne', 'k.browne4@nuigalway.ie', '" + kpassword + "', 1, '" + ksalt + "')");
});

db.close();

