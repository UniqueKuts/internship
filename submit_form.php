<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $resume = $_FILES['resume'];

    $to = 'kiranu569@gmail.com';
    $subject = 'New Internship Application';
    $message = "Name: $name\nEmail: $email\nContact Number: $contact";
    $headers = "From: $email";

    $file_path = $resume['tmp_name'];
    $file_name = $resume['name'];
    $file_type = $resume['type'];
    $file_size = $resume['size'];

    $boundary = md5(uniqid(time()));

    $headers .= "\r\nMIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";

    $body = "--{$boundary}\r\n";
    $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n";
    $body .= "\r\n{$message}\r\n";

    if ($file_path) {
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: {$file_type}; name=\"{$file_name}\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"{$file_name}\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "\r\n" . chunk_split(base64_encode(file_get_contents($file_path))) . "\r\n";
    }

    $body .= "--{$boundary}--";

    if (mail($to, $subject, $body, $headers)) {
        echo "Application submitted successfully.";
    } else {
        echo "Failed to send application. Please try again.";
    }
}
?>