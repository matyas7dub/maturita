<!DOCTYPE html>
<html>
<head>
<link href="./css/style.css" rel="stylesheet"/>
<link href="./css/userForm.css" rel="stylesheet"/>
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

    <a href="./register.php" style="align-self: center; margin: 1em;"
    >Not registered? Make an account</a>

    <button onclick="login()">Login</button>
</div>
<script>
const nameInput = document.getElementById("name");
const passInput = document.getElementById("password");

function login() {
    const name = nameInput.value;
    const password = passInput.value;

    console.debug(`Name: ${name}, password: ${password}`);
}
</script>
</body>
</html>
