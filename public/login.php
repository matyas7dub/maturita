<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<link href="/css/userForm.css" rel="stylesheet"/>
<link href="/favicon.png" rel="icon">
<?php include "../src/meta.php" ?>
<script src="/src/crypto.js"></script>
<title>Flappy bird: Login</title>
</head>
<body>
<?php include "../src/breadcrumbs.php" ?>
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

    <a href="/register.php" style="align-self: center; margin: 1em;"
    >Not registered yet? Make an account here!</a>

    <input class="submit" type="submit" value="Login" />
</form>

<?php include "../src/toast.php" ?>
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
            window.location = "/?toast=Logged in successfully";
        } else {
            errElem.style.display = "block";
        }
    });
}
</script>
</body>
</html>
