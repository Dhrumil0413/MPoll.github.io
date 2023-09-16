let Email = document.getElementById("Mail-Address");
let UserName = document.getElementById("UserName");
let Password = document.getElementById("password");
let Cpassword = document.getElementById("Confirmed-Password");
let SignUpForm = document.getElementById("signup-form");
let Avatar = document.getElementById("ChosenOne");

Email.addEventListener("blur", validateEmail);
UserName.addEventListener("blur", validateSignupUserName);
Password.addEventListener("blur", validateSignUpPassword);
Cpassword.addEventListener("blur", validateCpassword);
SignUpForm.addEventListener("submit", validateSignUpForm);
Avatar.addEventListener("blur", validateAvatarField);

