<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "REMOVE") {
    // https://www.php.net/manual/en/function.session-destroy.php

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<link href="/css/userForm.css" rel="stylesheet"/>
<link href="/favicon.png" rel="icon">
<?php include "../src/meta.php" ?>
<script src="/src/crypto.js"></script>
<title><?php echo $_SESSION["username"]; ?></title>
</head>
<body>
<?php include "../src/breadcrumbs.php" ?>
<h1>Account</h1>

<?php
$username = $_SESSION["username"];
$email = $_SESSION["email"];
?>
<form onsubmit="update(event)">
    <div>
        <label for="username">Username</label>
        <input id="username" type="text" value=<?php echo "\"$username\""; ?> />
    </div>
    <div>
        <label for="email">E-Mail</label>
        <input id="email" type="email" value=<?php echo"\"$email\""; ?> />
    </div>
    <div>
        <label for="password">New password</label>
        <input id="password" type="password" />
    </div>
    <div id="passwordCheckDiv" style="display: none;">
        <label for="passwordCheck">Repeat password</label>
        <input id="passwordCheck" type="password" />
    </div>

    <div style="display: flex; flex-direction: row">
        <button onclick="logout()">Logout</button>
        <!-- I have no idea why I can't use align or justify -->
        <div style="visibility: hidden; flex-grow: 1"></div>
        <input type="submit" class="submit" value="Update" />
    </div>
</form>
<script>
const usernameInput = document.getElementById("username");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const passwordCheckInput = document.getElementById("passwordCheck");

const passwordCheckDiv = document.getElementById("passwordCheckDiv");
const passwordError = document.getElementById("passError");

passwordInput.addEventListener("change", () => {
    if (passwordInput.value) {
        passwordCheckDiv.style.display = "block";
    } else {
        passwordCheckDiv.style.display = "none";
    }
});

function checkPasswords() {
    if (passwordInput.value !== passwordCheckInput.value) {
        passwordCheckInput.setCustomValidity("Passwords don't match!");
    } else {
        passwordCheckInput.setCustomValidity("");
    }
    passwordCheckInput.reportValidity();
}

passwordInput.addEventListener("change", checkPasswords);
passwordCheckInput.addEventListener("change", checkPasswords);

async function update(event) {
    event.preventDefault();

    request = {};

    const username = usernameInput.value;
    const email = emailInput.value;
    const password = passwordInput.value;

    if (username && username !== <?php echo "\"$username\"" ?>) {
        Object.assign(request, {username: username});
    }
    if (email && email !== <?php echo "\"$email\"" ?>) {
        Object.assign(request, {email: email});
    }
    if (password) {
        if (password === passwordCheckInput.value) {
            Object.assign(request, {password: await sha256(password)});
        }
    }

    if (Object.keys(request).length === 0) {
        return;
    }

    const bearer = prompt("Enter your current password");
    const header = new Headers();
    header.append("Authorization", await sha256(bearer));

    fetch("/user.php", {
        method: "PUT",
        body: JSON.stringify(request),
        headers: header
    })
    .then(() => {
        window.location.reload();
    });
}

function logout() {
    fetch("/account.php", { method: "REMOVE" }).then(() => {
        window.location = "/";
    });
}
</script>
</body>
</html>
