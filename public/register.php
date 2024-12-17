<!DOCTYPE html>
<html>
<head>
<link href="./css/style.css" rel="stylesheet"/>
<link href="./css/userForm.css" rel="stylesheet"/>
<title>Flappy bird: Register</title>
<style>
button {
    margin-top: 1em;
}
</style>
</head>
<body>
<div class="container">
    <div>
        <label for="username">Username</label>
        <input id="username" type="text" />
    </div>
    <div>
        <label for="email">E-Mail</label>
        <input id="email" type="email" />
    </div>
    <div>
        <label for="password1">Password</label>
        <input id="password1" type="password" />
    </div>
    <div>
        <label for="password2">Repeat password</label>
        <input id="password2" type="password" />
    </div>
    <span id="passwordErr" style="align-self: center; color: red; display: none;">Passwords must match!</span>

    <button id="regButton" onclick="register()">Register</button>
</div>
<script>
const usernameElem = document.getElementById("username");
const emailElem = document.getElementById("email");
const pass1 = document.getElementById("password1");
const pass2 = document.getElementById("password2");
const passErr = document.getElementById("passwordErr");
const regButton = document.getElementById("regButton");

pass1.addEventListener("change", event => {
    const pass = pass2.value;
    checkPasswords(pass, event.target.value);
})

pass2.addEventListener("change", event => {
    const pass = pass1.value;
    checkPasswords(pass, event.target.value);
})

function checkPasswords(first, second) {
    if (first && first !== second) {
        passErr.style.display = "block";
        regButton.disabled = true;
    } else {
        passErr.style.display = "none";
        regButton.disabled = false;
    }
}

function register() {
    const pass = pass1.value;
    const passCheck = pass2.value;
    if (pass !== passCheck) {
        return;
        // should not be necessary
    }

    const user = {
        username: usernameElem.value,
        email: emailElem.value,
        password: pass
    };

    console.debug(JSON.stringify(user));
}
</script>
</body>
</html>
