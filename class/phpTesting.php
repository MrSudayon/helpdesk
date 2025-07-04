<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);
try {

$mail->isSMTP();
$mail->SMTPDebug = 2;
				$mail->Host       = 'smtp.gmail.com';        // or your provider
				$mail->SMTPAuth   = true;
				$mail->Username   = 'sudayonfernando01@gmail.com';  // must be real
				$mail->Password   = 'ivfn tofh iych hkdd';     // Gmail: use App Password
				$mail->SMTPSecure = 'tls';
				$mail->Port       = 587;

				$mail->setFrom('fpsudayon@oxc-ph.com', 'Ticket System');
                $mail->addAddress('fpsudayon@oxc-ph.com', 'FPSudayon'); // ✅ Required!

				$mail->Subject = "🎫 New Ticket: ";
				$mail->Body = "test";

				$mail->send();
                    echo "✅ Email sent successfully!";
                    } catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}

                ?>