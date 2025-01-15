<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<title>Flappy bird: Scoreboard</title>
<style>
body {
    overflow-y: visible;
}

h1 {
    margin-top: calc(2rem + 5vh);
    font-size: 3rem;
}

table {
    min-width: calc(20vw + 2em);
    border-collapse: collapse;
    font-size: calc(1vw + 1.5rem);

    th, td {
        width: 100%;
        font-size: 0.5em;
        padding: 0.2em;
        border: 1px solid black;
    }

    tr.highlight {
        background-color: yellow;
    }
}
</style>
</head>
<body>
<h1>Scoreboard - Top 20</h1>
<table>
    <thead>
        <th>Username</th>
        <th>Score</th>
    </thead>

<?php
    include "../src/db.php";

    $result = $conn->query("
        SELECT u.id, u.username, s.score FROM
            scores s LEFT JOIN users u
            ON s.user_id = u.id
            ORDER BY score DESC
            LIMIT 20;
        ");
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($rows as $row) {
        if (isset($_SESSION["id"]) && $_SESSION["id"] == $row["id"]) {
            echo "<tr class=\"highlight\">";
        } else {
            echo "<tr>";
        }

        $username = $row["username"];
        $score = $row["score"];
        echo "<td>$username</td><td>$score</td></tr>";
    }
?>
</table>
</body>
</html>
