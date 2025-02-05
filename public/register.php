<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<link href="/css/userForm.css" rel="stylesheet"/>
<link href="/favicon.png" rel="icon">
<?php include "../src/meta.php" ?>
<script src="/src/crypto.js"></script>
<title>Flappy bird: Register</title>
<style>
button {
    margin-top: 1em;
}
</style>
</head>
<body>
<?php include "../src/breadcrumbs.php" ?>
<h1>Register</h1>

<form onSubmit="register(event)">
    <div>
        <label for="username">Username</label>
        <input id="username" type="text"
            pattern="[a-zA-Z0-9_\-]{1,14}" required
            title="May contain only alphanumerical symbols or '_', '-', and at most 15 characters" />
    </div>
    <div>
        <label for="email">E-Mail</label>
        <input id="email" type="email" required />
    </div>
    <div>
        <label for="password1">Password</label>
        <input id="password1" type="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required
            title="Must contain at least one  number and one uppercase and lowercase letter, and at least 6 or more characters" />
    </div>
    <div>
        <label for="password2">Repeat password</label>
        <input id="password2" type="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required
            title="Must contain at least one  number and one uppercase and lowercase letter, and at least 6 or more characters" />
    </div>
    <span id="passwordErr" class="error">Passwords must match!</span>
    <span id="error" class="error"></span>

    <input id="regButton" class="submit" type="submit" value="Register" />
</form>
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

async function register(event) {
    event.preventDefault();

    const pass = pass1.value;
    const passCheck = pass2.value;
    if (pass !== passCheck) {
        return;
        // should not be necessary
    }

    const user = {
        username: usernameElem.value,
        email: emailElem.value,
        password: await sha256(pass)
    };

    fetch("/user.php", {
        method: "POST",
        body: JSON.stringify(user)
    })
    .then(async response => {
        if (response.ok) {
            window.location = "/login.php?toast=Registered successfully";
        } else {
            const errElem = document.getElementById("error");
            const error = await response.text();

            errElem.innerText = error;
            errElem.style.display = "block";
        }
    })
}
</script>
</body>
</html>
