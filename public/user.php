<?php
include "../src/db.php";
include "../src/send_email.php";
include "../src/uuid.php";
session_start();
http_response_code(400);

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["name"]) && isset($_GET["password"])) {
            http_response_code(500);

            $name = mysqli_real_escape_string($conn, $_GET["name"]);
            $password = mysqli_real_escape_string($conn, $_GET["password"]);

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

            $username = mysqli_real_escape_string($conn, $input["username"]);
            $email = mysqli_real_escape_string($conn, $input["email"]);
            $password = mysqli_real_escape_string($conn, $input["password"]);

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
                $uuid = get_uuid();
                $conn->query("
                    INSERT INTO users (username, email, password, verified)
                    VALUES (\"$username\", \"$email\", \"$password\", \"$uuid\");
                ");

                http_response_code(200);

                // this hangs for a second or two, but I didn't find a good way
                // to respond to the request before exiting the script entirely
                send_verification_email($email, $uuid);
            }
        }
        break;

    case "PUT":
        $id = $_SESSION["id"];
        $input = json_decode(file_get_contents("php://input"), true);
        $authPassword = mysqli_real_escape_string($conn, $_SERVER["HTTP_AUTHORIZATION"]);

        $values = array();
        if (isset($input["username"])) {
            $username = mysqli_real_escape_string($conn, $input["username"]);
            $values[] = "username=\"$username\"";
        }
        if (isset($input["email"])) {
            $email = mysqli_real_escape_string($conn, $input["email"]);
            $values[] = "email=\"$email\"";
            $uuid = get_uuid();
            $values[] = "verified=\"$uuid\"";
            register_shutdown_function(function() use ($email, $uuid) {
                send_verification_email($email, $uuid);
            });
        }
        if (isset($input["password"])) {
            $password = mysqli_real_escape_string($conn, $input["password"]);
            $values[] = "password=\"$password\"";
        }

        if (count($values) === 0) {
            break;
        }

        $columns = implode(", ", $values);

        $result = $conn->query("
                UPDATE users
                    SET $columns
                    WHERE id=$id AND password=\"$authPassword\";
            ");

        if (mysqli_affected_rows($conn)) {
            if (isset($input["username"])) {
                $_SESSION["username"] = $input["username"];
            }
            if (isset($input["email"])) {
                $_SESSION["email"] = $input["email"];
            }

            http_response_code(200);
        } else {
            http_response_code(404);
        }
        break;

    case "DELETE":
        http_response_code(500);
        $id = $_SESSION["id"];
        $authPassword = mysqli_real_escape_string($conn, $_SERVER["HTTP_AUTHORIZATION"]);

        $result = $conn->query("
                DELETE s FROM scores s LEFT JOIN users u
                    on s.user_id = u.id
                    WHERE s.user_id=$id AND u.password=\"$authPassword\";
            ");

        $result = $conn->query("
                DELETE FROM users WHERE
                    id=$id AND password=\"$authPassword\";
            ");

        if (mysqli_affected_rows($conn)) {
            http_response_code(200);
        } else {
            http_response_code(404);
        }
        break;
}
?>
