<?php

require "../vendor/autoload.php"; // Ensure you have installed PHPMailer via Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



header('Content-Type: application/json');

// Check POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email."]);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact-us@sakarimanagement.com';
        $mail->Password   = 'HolyCoder.8210';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port       = 587;
        // Recipients
        $mail->setFrom('contact-us@sakarimanagement.com', 'Sakari Website');
        $mail->addReplyTo($email, $name);

        $mail->addAddress('agency@sakariwellness.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Message: ' . $subject;
        $mail->Body = '
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #f9fbfd;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f9fbfd">
    <tr>
      <td align="center" style="padding: 50px 20px;">
        <!-- Container -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="max-width: 620px; margin: 0 auto; border-radius: 10px; box-shadow: 0 5px 30px rgba(0,0,0,0.06); overflow: hidden; border: 1px solid #f0f3f7;">
          <!-- Header -->
          <tr>
            <td style="padding: 35px 40px 30px; text-align: center; border-bottom: 1px solid #f0f3f7;">
              <h1 style="font-family: \'Segoe UI\', \'Helvetica Neue\', Arial, sans-serif; color: #341bca; font-size: 22px; font-weight: 600; margin: 0; letter-spacing: 0.3px; text-transform: uppercase;">
                New Contact Inquiry
              </h1>
              <p style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 14px; color: #718096; margin: 8px 0 0; font-weight: 500;">
                Sakari Management Group
              </p>
            </td>
          </tr>
          
          <!-- Content -->
          <tr>
            <td style="padding: 40px 40px 30px;">
              <!-- Details -->
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px; border-collapse: collapse;">
                <tr>
                  <td width="25%" style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 14px; color: #718096; padding: 10px 0; font-weight: 500; vertical-align: top;">Name:</td>
                  <td style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 15px; color: #2d3748; padding: 10px 0; font-weight: 500;">' . $name . '</td>
                </tr>
                <tr>
                  <td style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 14px; color: #718096; padding: 10px 0; font-weight: 500; vertical-align: top;">Email:</td>
                  <td style="padding: 10px 0;">
                    <a href="mailto:' . $email . '" style="font-family: \'Segoe UI\', Tahoma, sans-serif; color: #341bca; text-decoration: none; font-weight: 500; position: relative; padding-left: 22px;">
                      <span style="position: absolute; left: 0; top: 1px;">✉️</span> ' . $email . '
                    </a>
                  </td>
                </tr>
                <tr>
                  <td style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 14px; color: #718096; padding: 10px 0; font-weight: 500; vertical-align: top;">Subject:</td>
                  <td style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 15px; color: #2d3748; padding: 10px 0; font-weight: 500;">' . $subject . '</td>
                </tr>
              </table>
              
              <!-- Message -->
              <div style="margin-bottom: 35px;">
                <p style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 14px; color: #718096; font-weight: 500; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Message:</p>
                <div style="background: #fafbff; padding: 22px; border-radius: 6px; border: 1px solid #edf0f7; font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 15px; line-height: 1.7; color: #2d3748;">
                  ' . nl2br(htmlspecialchars($message)) . '
                </div>
              </div>
              
              <!-- Action -->
              <div style="text-align: center; padding: 5px 0 15px;">
                <a href="mailto:' . $email . '" style="display: inline-block; font-family: \'Segoe UI\', Tahoma, sans-serif; background-color: #ffffff; color: #341bca; text-decoration: none; padding: 12px 36px; border-radius: 4px; font-weight: 600; font-size: 14px; border: 1px solid #341bca; transition: all 0.3s ease;">
                  Reply to ' . explode(' ', trim($name))[0] . '
                </a>
              </div>
            </td>
          </tr>
          
          <!-- Divider -->
          <tr>
            <td style="padding: 0 40px;">
              <div style="border-top: 1px solid #f0f3f7; margin: 0 auto;"></div>
            </td>
          </tr>
          
          <!-- Footer -->
          <tr>
            <td style="padding: 25px 40px 30px;">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="text-align: center;">
                    <p style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 13px; color: #a0aec0; line-height: 1.6; margin: 0;">
                      This message was sent via your website contact form at ' . date('M j, Y \a\t g:i A') . '
                    </p>
                    <p style="font-family: \'Segoe UI\', Tahoma, sans-serif; font-size: 13px; color: #a0aec0; margin: 8px 0 0;">
                      &copy; ' . date('Y') . ' Sakari Management Group. All rights reserved.
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
';
        $mail->send();
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Your message has been sent successfully."
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Message could not be sent. Mailer Error: " . $mail->ErrorInfo
        ]);
    }
}
