<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link href="./css/style.css" rel="stylesheet"/>
<link href="./css/userForm.css" rel="stylesheet"/>
<script src="../src/crypto.js"></script>
<title>Flappy bird: Login</title>
</head>
<body>
<div class="container">
    <div>
        <label for="name">Username/E-Mail</label>
        <input id="name" type="text" />
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" />
    </div>

    <span id="error" class="error">Invalid credentials!</span>

    <a href="./register.html" style="align-self: center; margin: 1em;"
    >Not registered yet? Make an account here!</a>

    <button onclick="login()">Login</button>
</div>
<script>
const nameInput = document.getElementById("name");
const passInput = document.getElementById("password");

async function login() {
    const name = nameInput.value;
    const password = await sha256(passInput.value);

    fetch(`./user.php?name=${name}&password=${password}`)
    .then(response => {
        const errElem = document.getElementById("error");
        if (response.ok) {
            window.location.assign("./index.php");
        } else {
            errElem.style.display = "block";
        }
    });
}
</script>
</body>
</html>
