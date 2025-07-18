function sendMail($to, $name, $subject, $bodyMessage) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST'); // smtp.secureserver.net
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USER'); // your GoDaddy email
        $mail->Password   = getenv('SMTP_PASS'); // your GoDaddy password
        $mail->SMTPSecure = 'tls';               // TLS
        $mail->Port       = getenv('SMTP_PORT'); // 587

        $mail->setFrom(getenv('SMTP_USER'), 'Astu Foundation');
        $mail->addAddress($to, $name);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $bodyMessage;

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
    }
}
