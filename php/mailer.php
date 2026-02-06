<?php
// PHPMailer helper for sending activation emails.
// Loads Composer autoload if available, otherwise falls back to local phpmailer files.
// Only declare function once using function_exists() to prevent redeclaration errors.

$composer = __DIR__ . '/../vendor/autoload.php';
$local1 = __DIR__ . '/phpmailer/src/PHPMailer.php';
$local2 = __DIR__ . '/../phpmailer/src/PHPMailer.php';
$local3 = __DIR__ . '/../src/PHPMailer.php';  // Check for src/ at project root
$phpmailer_available = false;

if (file_exists($composer)) {
    require_once $composer;
    $phpmailer_available = true;
} elseif (file_exists($local1) && file_exists(__DIR__ . '/phpmailer/src/SMTP.php')) {
    require_once __DIR__ . '/phpmailer/src/PHPMailer.php';
    require_once __DIR__ . '/phpmailer/src/SMTP.php';
    require_once __DIR__ . '/phpmailer/src/Exception.php';
    $phpmailer_available = true;
} elseif (file_exists($local2) && file_exists(__DIR__ . '/../phpmailer/src/SMTP.php')) {
    require_once __DIR__ . '/../phpmailer/src/PHPMailer.php';
    require_once __DIR__ . '/../phpmailer/src/SMTP.php';
    require_once __DIR__ . '/../phpmailer/src/Exception.php';
    $phpmailer_available = true;
} elseif (file_exists($local3) && file_exists(__DIR__ . '/../src/SMTP.php')) {
    require_once __DIR__ . '/../src/PHPMailer.php';
    require_once __DIR__ . '/../src/SMTP.php';
    require_once __DIR__ . '/../src/Exception.php';
    $phpmailer_available = true;
}

// Only declare function once to avoid redeclaration errors
if (!function_exists('sendActivationEmail')) {
    function sendActivationEmail(string $toEmail, string $activationLink): bool
    {
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            // PHPMailer not available
            error_log("sendActivationEmail: PHPMailer class not found");
            return false;
        }

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Brevo SMTP settings (replace with your credentials)
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'a1afeb001@smtp-brevo.com';
            $mail->Password = 'xsmtpsib-7a1e342d67eb88ffb96f9bdea38ba31977e8560053073b81b29e25c34ce0a187-dZ2JIofUuw3osxNP';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email details
            $mail->setFrom('no-reply@brevo.com', 'Car Rental App');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Activate your Car Rental account';
            $mail->Body = "<h3>Welcome!</h3>
                <p>Please activate your account by clicking the link below:</p>
                <p><a href='{$activationLink}'>{$activationLink}</a></p>
                <p>This link expires in 24 hours.</p>";

            $mail->AltBody = "Activate your account: $activationLink";

            $mail->send();
            error_log("sendActivationEmail: Successfully sent activation email to $toEmail");
            return true;
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log("sendActivationEmail: PHPMailer Exception - " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            error_log("sendActivationEmail: General Exception - " . $e->getMessage());
            return false;
        }
    }
}

?>