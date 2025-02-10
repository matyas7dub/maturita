<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link href="/css/style.css" rel="stylesheet"/>
<link href="/favicon.png" rel="icon">
<?php include "../src/meta.php" ?>
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
        font-size: 0.5em;
        padding: 0.2em;
        border: 2px solid #533545;
        text-align: center;
    }

    td.wide {
        text-align: left;
        width: 100%;
    }

    tr.personal {
        border-top: 4px solid #533545;
        border-bottom: 4px solid #533545;
    }

    tr.highlight {
        background-color: #4EC0CA;
    }
}
</style>
</head>
<body>
<?php include "../src/breadcrumbs.php" ?>
<h1>Scoreboard - Top 20</h1>
<table>
    <thead>
        <th>Rank</th>
        <th>Username</th>
        <th>Score</th>
    </thead>

<?php
    include "../src/db.php";

    if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $result = $conn->query("
                WITH numbered_rows AS (
                    SELECT u.id, u.username, s.score, ROW_NUMBER() OVER (ORDER BY score DESC) as row_index FROM
                        scores s LEFT JOIN users u
                        ON s.user_id = u.id
                )
                SELECT * FROM numbered_rows
                WHERE id = $id
                LIMIT 1;
            ");
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        if (count($rows)) {
            $row = $rows[0];

            $index = $row["row_index"];
            $username = $row["username"];
            $score = $row["score"];
            echo "<tr class=\"highlight personal\">
                    <td>$index</td>
                    <td class=\"wide\">$username</td>
                    <td>$score</td>
                </tr>";
        }
    }

    $result = $conn->query("
        SELECT u.id, u.username, s.score, ROW_NUMBER() OVER (ORDER BY score DESC) as row_index FROM
            scores s LEFT JOIN users u
            ON s.user_id = u.id
            LIMIT 20;
        ");
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($rows as $row) {
        if (isset($_SESSION["id"]) && $_SESSION["id"] == $row["id"]) {
            echo "<tr class=\"highlight\">";
        } else {
            echo "<tr>";
        }

        $index = $row["row_index"];
        $username = $row["username"];
        $score = $row["score"];
        echo "<td>$index</td><td class=\"wide\">$username</td><td>$score</td></tr>";
    }
?>
</table>
</body>
</html>
