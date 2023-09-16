// When user blurs or submit form if the input is invalid it should trigger

let UserName = document.getElementById("UserName");
UserName.addEventListener("blur", validateUserName);

let Password = document.getElementById("Password");
Password.addEventListener("blur", validatePassword);

let loginForm = document.getElementById("login-form");
loginForm.addEventListener("submit", validateLoginForm);

setInterval(checkForNewPoll, 90000);

