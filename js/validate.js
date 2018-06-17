$(function() {

  /*Validates user info on create account page as they type*/

  /*User name validation*/
  $("#username").keyup(function() {
    var usernameReg = /^[A-Za-z0-9-_\.]{3,40}$/;
    var username = $("#username").val();

    $.ajax({
      type: 'get',
      url: "/checkUsername.php",
      data:{username: username},
      success: function(usernameExists){
        if(usernameExists){
          $("#usernameError").addClass('error').removeClass('errorValid');
          $("#usernameError").text("Username already in use");
        } else if(username.length < 3 || username.length > 40){
          $("#usernameError").addClass('error').removeClass('errorValid');
          $("#usernameError").text("Username must be 3-40 characters");
        } else if(!usernameReg.test(username)) {
          $("#usernameError").addClass('error').removeClass('errorValid');
          $("#usernameError").text("Invalid");
        } else {
          $("#usernameError").addClass('errorValid').removeClass('error');
          $("#usernameError").text("Valid");
        }
      }
    });
  });

  /*email validation*/
  $("#email").keyup(function() {
    var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var email = $("#email").val();
    $.ajax({
      type: 'get',
      url: "/checkEmail.php",
      data:{email: email},
      success: function(emailExists){
        if(emailExists) {
          $("#emailError").addClass('error').removeClass('errorValid');
          $("#emailError").text("Email Already in Use.");
        }
        else if(!emailReg.test(email)) {
          $("#emailError").addClass('error').removeClass('errorValid');
          $("#emailError").text("Invalid Email Form");
        } else {
          $("#emailError").addClass('errorValid').removeClass('error');
          $("#emailError").text("Valid");
        }
      }
    });
  });

  /*password validation*/
  $("#password").keyup(function() {
    var passwordReg = /^.{5,50}$/;
    var password = $("#password").val();
    if(!passwordReg.test(password)) {
      $("#passwordError").addClass('error').removeClass('errorValid');
      $("#passwordError").text("Email must be 5-50 characters");
    } else {
      $("#passwordError").addClass('errorValid').removeClass('error');
      $("#passwordError").text("Valid");
    }
  });

  /*verify password validation*/
  $("#password, #passwordVal").keyup(function() {
    var password = $("#password").val();
    var passwordVal = $("#passwordVal").val();
    if(password != passwordVal){
      $("#passwordValError").addClass('error').removeClass('errorValid');
      $("#passwordValError").text("Passwords do not match");
    } else {
      $("#passwordValError").addClass('errorValid').removeClass('error');
      $("#passwordValError").text("Valid");
    }
  });


});
