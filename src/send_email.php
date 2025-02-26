<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMAiler\SMTP;

require_once(dirname(__FILE__).'../vendor/phpmailer/phpmailer/src/Exception.php');
require_once(dirname(__FILE__).'../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once(dirname(__FILE__).'../vendor/phpmailer/phpmailer/src/SMTP.php');


function send_email($addr_to, $subject, $body)
{
    $retc = true;
    try {
        $email = new PHPMailer();

        $email->SMTPDebug = SMTP::DEBUG_SERVER;
        $email->isSMTP();
        $email->Host = "smtp.gmail.com";

        $email->SMTPAuth = true;
        $email->Username = "matyas7dub@gmail.com";
        $email->Password = $_ENV["EMAIL_PASSWORD"];

        $email->SMTPSecure = PHPMAiler::ENCRYPTION_SMTPS;
        $email->Port = 465;

        $email->SetFrom('noreply@7dub.dev');
        $email->addReplyTo('matyas@7dub.dev', 'Matyáš Sedmidubský');

        $email->IsHTML(true);
        $email->CharSet = "UTF-8";
        $email->Subject = $subject;
        $email->Body = $body;

        $email->AddAddress($addr_to);


        if(!$email->send()) {
            echo "Mailer Error: " . $email->ErrorInfo;
            $retc = false;
        }

    } catch (Exception $e) {
        $retc = false;
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        $retc = false;
        echo $e->getMessage(); //Boring error messages from anything else!
    }


    return $retc;
}

function send_verification_email($addr_to, $uuid) {
    $domain = $_ENV["DOMAIN"];
    send_email($addr_to, "Verify your email", "
            <a href=\"https://$domain/verify.php?uuid=$uuid\">Verify your email here</a>
        ");
}
?>
