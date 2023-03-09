/* FORMS */

/* for all forms: as long as form is not complete, button is unclickable */

/* article form */
let articleForm = document.getElementById("articleForm");
let title = document.getElementById("title");
let content = document.getElementById("content");
let articleBtn = document.getElementById("articleBtn");

/* registration form */
let registrationForm = document.getElementById("registrationForm");
// booleans for validations
let pwIsValid = false;
let emailIsValid = false;

let username = document.getElementById("username");
let email = document.getElementById("email");
const regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
let emailMessage = document.getElementById("emailMessage");
let pw1 = document.getElementById("password1");
let pw2 = document.getElementById("password2");
let pwMessage = document.getElementById("pwMessage");
let checkboxPW = document.getElementById("checkboxPW");
let registerBtn = document.getElementById("registerBtn");

/* login form */
let loginForm = document.getElementById("loginForm");
let userEmail = document.getElementById("userEmail");
let userPassword = document.getElementById("userPassword");
let loginBtn = document.getElementById("loginBtn");

// article form (make button clickable)
validateArticleForm = () => {
    if ((title.value.trim() && content.value.trim()) === "") {
        articleBtn.disabled = true;
        articleBtn.setAttribute("style", "opacity: .6; cursor: no-drop");
    } else {
        articleBtn.disabled = false;
        articleBtn.setAttribute("style", "opacity: 1; cursor: pointer");
    }
}
if ((title && content) != undefined) {
    title.addEventListener('input', validateArticleForm);
    content.addEventListener('input', validateArticleForm);
}


// registration form
// check password match 
verifyPassword = () => {
    // if one or both fields are empty
    if ((pw1.value.trim() && pw2.value.trim()) === "") {
        pwMessage.style.display = "none";
        pw1.style.borderColor = "var(--lightgrey)";
        pw2.style.borderColor = "var(--lightgrey)";
        pwIsValid = false;
    } else {
        // else check if they match
        if (pw1.value !== pw2.value) {
            pwMessage.style.display = "block";
            pw1.style.borderColor = "var(--red)";
            pw2.style.borderColor = "var(--red)";
            pwIsValid = false;
        } else {
            pwMessage.style.display = "none";
            pw1.style.borderColor = "var(--brightgreen)";
            pw2.style.borderColor = "var(--brightgreen)";
            pwIsValid = true;
        }
    }
    return pwIsValid;
}
if ((pw1 && pw2) != undefined) {
    pw1.addEventListener('input', verifyPassword);
    pw2.addEventListener('input', verifyPassword);
}
// pw2.oninput = verifyPassword;

// verify email format
verifyEmail = () => {
    if (regexEmail.test(email.value.trim()) == true) {
        emailMessage.style.display = "none";
        emailIsValid = true;
        email.style.borderColor = "var(--lightgrey)";
    } else {
        emailMessage.style.display = "block";
        emailIsValid = false;
        email.style.borderColor = "var(--red)";
    }
    return emailIsValid;
}
if (email != undefined) {
    email.addEventListener('input', verifyEmail);
}

// validate form (make button clickable)
validateRegistrationForm = () => {
    if ((username.value.trim() && email.value.trim() && pw1.value.trim() && pw2.value.trim()) !== "" && pwIsValid === true && emailIsValid === true) {
        registerBtn.disabled = false;
        registerBtn.setAttribute("style", "opacity: 1; cursor: pointer");
    } else {
        registerBtn.disabled = true;
        registerBtn.setAttribute("style", "opacity: .6; cursor: no-drop");
    }
}
if ((username && email && pw1 & pw2) != undefined) {
    username.addEventListener('input', validateRegistrationForm);
    email.addEventListener('input', validateRegistrationForm);
    pw1.addEventListener('input', validateRegistrationForm);
    pw2.addEventListener('input', validateRegistrationForm);
}

// show password
// TODO: event delegation to toggle passwords in all forms
togglePassword = () => {
    if (pw2.type === "password") {
        pw2.type = "text";
    } else {
        pw2.type = "password";
    }
}
if (checkboxPW != undefined) {
    checkboxPW.addEventListener('click', togglePassword);
}




// login form (make button clickable)
validateLoginForm = () => {
    if ((userEmail.value.trim() && userPassword.value.trim()) === "") {
        loginBtn.disabled = true;
        loginBtn.setAttribute("style", "opacity: .6; cursor: no-drop");
    } else {
        loginBtn.disabled = false;
        loginBtn.setAttribute("style", "opacity: 1; cursor: pointer");
    }
}
if ((userEmail && userPassword) != undefined) {
    userEmail.addEventListener('input', validateLoginForm);
    userPassword.addEventListener('input', validateLoginForm);
}


// clear form on page reload (otherwise input events can't be triggered)
window.addEventListener('load', function () {
    if (articleForm != undefined) {
        articleForm.reset();
    }
    if (registrationForm != undefined) {
        registrationForm.reset();
    }
    if (loginForm != undefined) {
        loginForm.reset();
    }
});