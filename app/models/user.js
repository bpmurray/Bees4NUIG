// app/models/user.js
// load the things we need
var sqlite3  = require('sqlite3');
var configDB = require('../../config/database.js')

// define the schema for our user model
var User = function() {
   this.email     = null;
   this.password  = null;
   this.name      = null;
   this.salt      = null;
   this.admin     = 0;

   // methods ======================
   // generating a hash
   generateHash = function(password, salt) {
      var hash = crypto.createHash('sha256');
      hash.update(password);
      hash.update(salt);
      return hash.digest('hex');
   };

   // checking if password is valid
   validPassword = function(password) {
      return this.generateHash(password, this.salt) === this.password;
   };

   // Retrieve a user from the DB
   findOne = function(email, callback) {
      var found = false;
      var errcode = 0;
      var db = new sqlite3.Database(configDB.url);
      db.all('SELECT * FROM beekeeper WHERE email="'+email+'"', function(err, rows) {  
         errcode = err;
         rows.forEach(function(row) {
            found = true;
            this.email    = row.email;
            this.name     = row.name;
            this.password = row.password;
            this.salt     = row.salt;
            this.admin    = row.admin;
         })
      });   
      db.close();  
      callback(errcode, found? this : null);
   }

   // Save the user
   save = function(callback) {
      var errcode = 0;
      var db = new sqlite3.Database(configDB.url);
      var stmt = db.prepare("INSERT INTO beekeeper (name, email, password, admin, salt) VALUES (?,?,?,?,?)");
      stmt.run(this.name, this.email, this.password, this,admin, this.salt, function(err) {
         errcode = err;
      });
      stmt.finalize();
      db.close();  
      callback(errcode);
   }

   // Retrieve a user using ID
   findById = function(id) {
      console.log(id);
   }
}

module.exports = exports = User;

