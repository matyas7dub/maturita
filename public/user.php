<?php
include "../src/db.php";
session_start();
http_response_code(400);

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["name"]) && isset($_GET["password"])) {
            http_response_code(500);

            $name = $_GET["name"];
            $password = $_GET["password"];

            $result = $conn->query("
                SELECT * FROM users WHERE
                    (username=\"$name\" OR email=\"$name\")
                    AND password=\"$password\";
                ");
            $data = $result->fetch_assoc();

            if ($data != null) {
                $_SESSION["id"] = $data["id"];
                $_SESSION["username"] = $data["username"];
                $_SESSION["email"] = $data["email"];
                http_response_code(200);
            } else {
                http_response_code(404);
            }
        }
        break;

    case "POST":
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input["username"]) &&
            isset($input["email"]) &&
            isset($input["password"])) {
            http_response_code(500);

            $username = $input["username"];
            $email = $input["email"];
            $password = $input["password"];

            $result = $conn->query("
                SELECT username, email FROM users WHERE
                    username=\"$username\" OR
                    email=\"$email\"
                ");
            $data = $result->fetch_assoc();

            if ($data != null) {
                http_response_code(401);
                if ($data["username"] == $username) {
                    print("This username is already taken!");
                } else if ($data["email"] == $email) {
                    print("This email is already in use!");
                }
            } else {
                $conn->query("
                    INSERT INTO users (username, email, password)
                    VALUES (\"$username\", \"$email\", \"$password\");
                ");
                http_response_code(200);
            }
        }
        break;
}
?>
