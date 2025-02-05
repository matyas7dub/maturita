<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<link href="/favicon.png" rel="icon">
<?php include "../src/meta.php" ?>
<title>Flappy bird</title>
</head>
<body>
<div class="menu">
    <span id="title">Flappy bird</span>

    <a href="/game.php"><button>Play</button></a>
    <a href="/scoreboard.php"><button>Scoreboard</button></a>
    <?php
    if (isset($_SESSION["username"]) && isset($_SESSION["id"])) {
        echo "<a href=\"/account.php\"><button>Account</button></a>";
    } else {
        echo "<a href=\"/login.php\"><button>Login</button></a>";
    }
    ?>
</div>
</body>
</html>
