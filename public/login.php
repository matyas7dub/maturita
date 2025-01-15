<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<link href="/css/userForm.css" rel="stylesheet"/>
<link href="/favicon.png" rel="icon">
<script src="/src/crypto.js"></script>
<title>Flappy bird: Login</title>
</head>
<body>
<h1>Login</h1>

<form onsubmit="login(event)">
    <div>
        <label for="name">Username/E-Mail</label>
        <input id="name" type="text" required />
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" required />
    </div>

    <span id="error" class="error">Invalid credentials!</span>

    <a href="/register.html" style="align-self: center; margin: 1em;"
    >Not registered yet? Make an account here!</a>

    <input class="submit" type="submit" value="Login" />
</form>
<script>
const nameInput = document.getElementById("name");
const passInput = document.getElementById("password");

async function login(event) {
    event.preventDefault();

    if (!nameInput.value || !passInput.value) {
        return;
    }
    const name = nameInput.value;
    const password = await sha256(passInput.value);

    fetch(`/user.php?name=${name}&password=${password}`)
    .then(response => {
        const errElem = document.getElementById("error");
        if (response.ok) {
            window.location = "/";
        } else {
            errElem.style.display = "block";
        }
    });
}
</script>
</body>
</html>
