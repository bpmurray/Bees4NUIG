// JavaScript Document

$('document').ready(function()
{ 
   var delay = 600;
   $(document).tooltip();

   /* validation */
   if ($("#register-form").length) {
      $("#register-form").validate({
        rules: {
           name: {
              required: true,
              minlength: 2
           },
           email: {
              required: true,
              email: true
           },
           password: {
              minlength: 8,
              maxlength: 15
           },
           cpassword: {
              equalTo: '#password'
           }
        },
        messages: {
           name: "please enter your name",
           email: "please enter a valid email address",
           password:{
              required: "please create a password",
              minlength: "password must have at least have 8 characters"
           },
           cpassword:{
              required: "please retype your password",
              equalTo: "passwords don't match !"
           }
         },
         submitHandler: submitForm   
      });  
   }
     
   /* form submit */
   function submitForm() {      
      var data = $("#register-form").serialize();
           
      $.ajax({
         async: true,
         type : 'POST',
         url  : 'register.php',
         data : data,
         beforeSend: function() {   
            $("#error").fadeOut();
            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
         },
         success : function(data) {                  
            if (data==1) {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Sorry - this user already exists!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account');
               });
            } else if (data=="registered") {
               $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Signing Up ...');
               setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("success.php"); }); ', delay);
            } else {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; '+data+' !</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account');
               });
            }
         }
      });
      return false;
   }


   /* validation */
   if ($("#admin-form").length) {
      $("#admin-form").validate({
        rules: {
           email: {
              required: true,
              email: true
           },
           password: {
              required: true,
              minlength: 8,
              maxlength: 15
           }
         },
         messages: {
           password:{
              required: "please provide a password",
              minlength: "password at least have 8 characters"
           },
           user_email: "please enter a valid email address",
         },
         submitHandler: adminForm   
      });
   }
     
   /* form cancel */
   function adminForm() {      
      var data = $("#admin-form").serialize();
           
      $.ajax({
         async: true,
         type : 'POST',
         url  : 'admchk.php',
         data : data,
         beforeSend: function() {   
            $("#error").fadeOut();
            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
         },
         success : function(data) {                  
            if (data==1) {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Sorry email not found!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; List attendees');
               });
            } else if (data=="notadmin") {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; You don\'t have administrative permissions!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; List attendees');
               });
            } else if (data=="notactivated") {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; You have not activated your account from the E-mail!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Login');
               });
            } else if (data=="badpassword") {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Sorry password incorrect!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Login');
               });
            } else if (data=="loggedin") {
               $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Retrieving attendees ...');
               setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("listall.php"); }); ', delay);
            } else {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; '+data+' !</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; List attendees');
               });
            }
         }
      });
      return false;
   }

   /* validation */
   if ($("#login-form").length) {
      $("#login-form").validate({
        rules: {
           email: {
              required: true,
              email: true
           },
           password: {
              required: true
           }
         },
         messages: {
           password:{
              required: "please provide your password"
           },
           user_email: "please enter a valid email address",
         },
         submitHandler: loginForm   
      });
   }
     
   function loginForm() {      
      var data = $("#login-form").serialize();
           
      $.ajax({
         async: true,
         type : 'POST',
         url  : 'login.php',
         data : data,
         beforeSend: function() {   
            $("#error").fadeOut();
            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
         },
         success : function(data) {                  
            if (data==1 || data=="badpassword") {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Sorry - email or password incorrect!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Login');
               });
            } else if (data=="notactivated") {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Account not activated - please click on the link in the E-mail you received.</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Login');
               });
            } else if (data=="ok") {
               $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Logging in ...');
               //setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("showuser.php"); }); ', delay);
               setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = "showuser.php"; }); ', delay);
            } else {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; '+data+' !</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Login');
               });
            }
         }
      });
      return false;
   }

   /* validation */
   if ($("#addapiary-form").length) {

     //$("#ccount").spinner({
     //   spin: function( event, ui ) {
     //            if ( ui.value < 0 ) {
     //               $(this).spinner( "value", 0 );
     //               return false;
     //            }
     //         },
     //   classes: {
     //      "ui-spinner": "fullwidth"
     //   }
     //   });
     
//     $("#btn-cancel").click(function(e) {
//         e.preventDefault();
//         setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = "showuser.php"; }); ', delay);
//     });

     $("#addapiary-form").validate({
        rules: {
           aname: {
              required: true
           },
           where: {
              required: true
           },
           ccount: {
              required: true,
              number: true
           }
         },
         messages: {
           aname:{
              required: "please give a name to your apiary",
           },
           where:{
              required: "please state where the apiary is located",
           },
           ccount:{
              required: "please provide the number of hives",
           }
         },
         submitHandler: addapiaryForm   
      });
   }
     
   function addapiaryForm() {      
      var data = $("#addapiary-form").serialize();
           
      $.ajax({
         async: true,
         type : 'POST',
         url  : 'addapiary.php',
         data : data,
         beforeSend: function() {   
            $("#error").fadeOut();
            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Sending ...');
         },
         success : function(data) {                  
            if (data=="alreadyexists") {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Sorry - email or password incorrect!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-ok-circle"></span> &nbsp; Add');
               });
            } else if (data=="ok") {
               $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Adding ...');
               //setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("showuser.php"); }); ', delay);
               setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = "showuser.php"; }); ', delay);
            } else {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; '+data+' !</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-ok-circle"></span> &nbsp; Add');
               });
            }
         }
      });
      return false;
   }

   /* validation */
   if ($("#showuser-form").length) {
     $("#btn-submit").click(function(e) {
        e.preventDefault();
        //setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("addapiary.php"); }); ', delay);
        setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = "addapiary.php"; }); ', delay);
     });
   }

   /* validation */
   if ($("#newpassword-form").length) {
      $("#newpassword-form").validate({
        rules: {
           email: {
              required: true,
              email: true
           }
        },
        messages: {
           email: "please enter a valid email address"
         },
         submitHandler: newpasswordForm   
      });  
   }
     
   /* form submit */
   function newpasswordForm() {      
      var data = $("#newpassword-form").serialize();
           
      $.ajax({
         async: true,
         type : 'POST',
         url  : 'newpassword.php',
         data : data,
         beforeSend: function() {   
            $("#error").fadeOut();
            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
         },
         success : function(data) {                  
            if (data==1) {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Sorry - this user doesn\'t exist!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Change Password');
               });
            } else if (data=="mailsent") {
               $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Sending mail ...');
               setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("successpwd.php"); }); ', delay);
            } else {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; '+data+' !</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Change Password');
               });
            }
         }
      });
      return false;
   }

   /* validation */
   if ($("#changepassword-form").length) {
      $("#changepassword-form").validate({
         rules: {
            password: {
               minlength: 8,
               maxlength: 15
            },
            cpassword: {
               equalTo: '#password'
            }
         },
         messages: {
         },
         submitHandler: changepasswordForm   
      });  
   }
     
   /* form submit */
   function changepasswordForm() {      
      var data = $("#changepassword-form").serialize();
           
      $.ajax({
         async: true,
         type : 'POST',
         url  : 'changepassword.php',
         data : data,
         beforeSend: function() {   
            $("#error").fadeOut();
            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
         },
         success : function(data) {                  
            if (data==1) {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Something went wrong! Please try again later.</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Change Password');
               });
            } else if (data=="updated") {
               setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = "login.php"; }); ', delay);
            } else {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; '+data+' !</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Change Password');
               });
            }
         }
      });
      return false;
   }


   /* validation */
   if ($("#delete-form").length) {
      $("#delete-form").validate({
         submitHandler: deleteForm   
      });
   }
     
   /* form cancel */
   function deleteForm() {      
      var data = $("#delete-form").serialize();
           
      $.ajax({
         async: true,
         type : 'POST',
         url  : 'delete.php',
         data : data,
         beforeSend: function() {   
            $("#error").fadeOut();
            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
         },
         success : function(data) {                  
            if (data==1) {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Something went wrong!</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Delete');
               });
            } else if (data.startsWith("goto:")) {
               var target = data.substr(5);
               $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Deleted ...');
               setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = target; }); ', delay);
            } else {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; '+data+' !</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Delete');
               });
            }
         }
      });
      return false;
   }

   /* validation */
   if ($("#showapiary-form").length) {
      $("#showapiary-form").validate({
         submitHandler: showapiaryForm   
      });  
   }
     
   /* form submit */
   function showapiaryForm() {      
      var data = $("#showapiary-form").serialize();
           
      $.ajax({
         async: true,
         type : 'POST',
         url  : 'showapiary.php',
         data : data,
         beforeSend: function() {   
            $("#error").fadeOut();
            $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
         },
         success : function(data) {                  
            if (data==1) {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Something went wrong! Please try again later.</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Add Hive');
               });
            } else if (data=="delete") {
               setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = "delete.php"; }); ', delay);
            } else if (data=="edit") {
               setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = "editapiary.php"; }); ', delay);
            } else if (data=="add") {
               setTimeout('$(".form-signin").fadeOut(500, function(){ window.location.href = "addhive.php"; }); ', delay);
            } else {
               $("#error").fadeIn(1000, function(){
                  $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; '+data+' !</div>');
                  $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Change Password');
               });
            }
         }
      });
      return false;
   }



});
