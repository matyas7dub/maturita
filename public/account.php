<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
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
<link href="./css/style.css" rel="stylesheet"/>
<link href="./css/userForm.css" rel="stylesheet"/>
<link href="./favicon.png" rel="icon">
<?php include "../src/meta.php" ?>
<script src="../src/crypto.js"></script>
<title><?php echo $_SESSION["username"]; ?></title>
<style>
div.warning {
    font-size: 0.7em;
    margin-top: -0.5em;
    margin-bottom: 0.5em;

    span {
        color: #F8B82F;
        margin-right: 1em;
    }
}
</style>
</head>
<body>
<?php
include "../src/breadcrumbs.php";
include "../src/toast.php";
?>
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
    <?php
    include "../src/db.php";

    $id = $_SESSION["id"];
    $result = $conn->query("
        SELECT id FROM users WHERE
            id=$id AND NOT verified=\"yes\"
            LIMIT 1;
        ");
    $data = $result->fetch_assoc();

    if ($data != null) {
        echo "
            <div class=\"warning\">
                <span>Your email is not verified!</span>
                <button type=\"button\" onclick=\"resendEmail()\">Resend email</button>
            </div>
            ";
    }
    ?>
    <div>
        <label for="password">New password</label>
        <input id="password" type="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
            title="Must contain at least one  number and one uppercase and lowercase letter, and at least 6 or more characters" />
    </div>
    <div id="passwordCheckDiv" style="display: none;">
        <label for="passwordCheck">Repeat password</label>
        <input id="passwordCheck" type="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
            title="Must contain at least one  number and one uppercase and lowercase letter, and at least 6 or more characters" />
    </div>

    <div style="display: flex; flex-direction: row">
        <button type="button" onclick="logout()">Logout</button>
        <!-- I have no idea why I can't use align or justify -->
        <div style="visibility: hidden; flex-grow: 1"></div>
        <button disabled type="submit" class="submit" id="submit">Update</button>
    </div>

    <div style="display: flex; flex-direction: row">
        <button type="button" style="color: #FC3500" onclick="deleteAccount()">Delete</button>
        <div style="visibility: hidden; flex-grow: 1"></div>
    </div>
</form>

<dialog id="passwordDialog">
    <form onsubmit="closeDialog(event)">
        <label for="dialogPassword">Enter your password</label>
        <input id="dialogPassword" type="password" required autofocus />

        <button type="submit" class="submit">Confirm</button>
    </form>
</dialog>
<script>
const usernameInput = document.getElementById("username");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const passwordCheckInput = document.getElementById("passwordCheck");
const passwordDialog = document.getElementById("passwordDialog");
const dialogPasswordInput = document.getElementById("dialogPassword");

const submitButton = document.getElementById("submit");

const passwordCheckDiv = document.getElementById("passwordCheckDiv");
const passwordError = document.getElementById("passError");

passwordInput.addEventListener("change", () => {
    if (passwordInput.value) {
        passwordCheckDiv.style.display = "block";
    } else {
        passwordCheckDiv.style.display = "none";
    }
});

const dialogCallback = { current: () => {} };
function closeDialog(event) {
    event.preventDefault();
    passwordDialog.close();
    dialogCallback.current(dialogPasswordInput.value);
}

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

function toggleUpdateButton() {
    <?php
        $username = $_SESSION["username"];
        $email = $_SESSION["email"];
        echo "const username = \"$username\";";
        echo "const email = \"$email\";";
    ?>

    if (usernameInput.value !== username ||
        emailInput.value !== email ||
        passwordInput.value !== "") {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
}

usernameInput.addEventListener("change", toggleUpdateButton);
emailInput.addEventListener("change", toggleUpdateButton);
passwordInput.addEventListener("change", toggleUpdateButton);

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

    dialogCallback.current = async dialogPassword => {
        const header = new Headers();
        header.append("Authorization", await sha256(dialogPassword));

        fetch("./user.php", {
            method: "PUT",
            body: JSON.stringify(request),
            headers: header
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    };
    passwordDialog.showModal();
}

function logout() {
    fetch("./account.php", { method: "DELETE" }).then(() => {
        window.location = "./index.php?toast=Logged out successfully&toastType=success";
    });
}

async function deleteAccount() {
    dialogCallback.current = async dialogPassword => {
        const header = new Headers();
        header.append("Authorization", await sha256(dialogPassword));

        fetch("./user.php", {
          method: "DELETE",
          headers: header
        })
        .then(async response => {
            if (response.ok) {
                fetch("./account.php", { method: "DELETE" })
                .then(() => {window.location = "./index.php?toast=Account deleted successfully&toastType=success";});
            }
            // TODO: else show wrong password error
        });
    };
    passwordDialog.showModal();
}

function resendEmail() {
    dialogCallback.current = async dialogPassword => {
        const header = new Headers();
        header.append("Authorization", await sha256(dialogPassword));

        fetch("./user.php", {
            method: "PUT",
            body: JSON.stringify({
                email: "<?php echo $_SESSION["email"] ?>"
            }),
            headers: header
        })
        .then(response => {
            if (response.ok) {
                window.location = "./account.php?toast=Email sent successfully&toastType=success";
            }
        });
    };
    passwordDialog.showModal();
}
</script>
</body>
</html>
