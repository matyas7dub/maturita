<?php
include "../src/db.php";
session_start();
http_response_code(405);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    http_response_code(400);
} else {
    return;
}

$input = json_decode(file_get_contents("php://input"), true);
if (isset($input["score"]) && isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $score = mysqli_real_escape_string($conn, $input["score"]);

    $result = $conn->query("
            INSERT INTO scores (user_id, score)
                VALUES ($id, $score);
        ");
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
?>
