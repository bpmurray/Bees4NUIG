
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

var crypto = require('crypto');
var sqlite3 = require('sqlite3');

var db = new sqlite3.Database('db/varroarecords.db');

// ...
// Hash the password from the user-supplied value
function hashPassword(password, salt) {
   var hash = crypto.createHash('sha256');
   hash.update(password);
   hash.update(salt);
   return hash.digest('hex');
}

passport.use(new LocalStrategy(function(email, password, done) {
   db.get('SELECT salt FROM beekeepers WHERE email = ?', email, function(err, row) {
      if (!row)
         return done(null, false);
      var hash = hashPassword(password, row.salt);
      db.get('SELECT beekeeperid, name, admin FROM beekeepers WHERE email = ? AND password = ?', email, hash, function(err, row) {
         if (!row)
            return done(null, false);
         return done(null, row);
      });
   });
}));

passport.serializeUser(function(beekeeper, done) {
   return done(null, beekeeper.beekeeperid);
});

passport.deserializeUser(function(id, done) {
   db.get('SELECT beekeeperid, name. email, admin FROM beekeeper WHERE beekeeperid = ?', id, function(err, row) {
      if (!row)
         return done(null, false);
      return done(null, row);
   });
});

// ...

app.post('/login', passport.authenticate('local', { successRedirect: '/good-login',
                                                    failureRedirect: '/bad-login' }));

