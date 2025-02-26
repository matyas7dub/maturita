<?php
include "../src/db.php";
http_response_code(400);

if (isset($_GET["uuid"])) {
    http_response_code(404);

    $uuid = mysqli_real_escape_string($conn, $_GET["uuid"]);

    $result = $conn->query("
           UPDATE users
                SET verified=\"yes\"
                WHERE verified=\"$uuid\"
                LIMIT 1;
        ");

    if (mysqli_affected_rows($conn)) {
        header("Location: ./login.php?toast=E-Mail verified successfully&toastType=success", true, 302);
    }
}
?>
