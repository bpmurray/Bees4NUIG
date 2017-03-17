console.log("OK, I'm here!");

//*** Below is some code to access the DB
//*** API at: https://github.com/mapbox/node-sqlite3/wiki/API
//*** var sqlite3 = require('sqlite3').verbose()
//*** var db = new sqlite3.Database('db/varroarecords.db');
//*** db.serialize(function() {
//*** 
//***   var stmt = db.prepare("INSERT INTO user_info VALUES (?)");
//***   for (var i = 0; i < 10; i++) {
//***       stmt.run("Ipsum " + i);
//***   }
//***   stmt.finalize();
//*** 
//***   db.each("SELECT rowid AS id, info FROM user_info", function(err, row) {
//***       console.log(row.id + ": " + row.info);
//***   });
//*** 
//***   //Perform SELECT Operation
//***   db.all("SELECT * from blah blah blah where this="+that,function(err,rows){
//***      //rows contain values while errors, well you can figure out.
//***   });
//***   
//*** });
//*** 
//*** db.close();
