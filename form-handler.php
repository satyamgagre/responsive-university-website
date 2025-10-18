<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form inputs
    $name = trim(htmlspecialchars($_POST['name']));
    $visitor_email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $subject = trim(htmlspecialchars($_POST['subject']));
    $message = trim(htmlspecialchars($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($visitor_email) || empty($subject) || empty($message)) {
        header("Location: contact.html?error=empty_fields");
        exit();
    }

    if (!filter_var($visitor_email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.html?error=invalid_email");
        exit();
    }

    $email_from = 'satyagagre@gmail.com';
    $email_subject = 'New Form Submission: ' . $subject;

    $email_body = "User Name: " . $name . "\n" .
                  "User Email: " . $visitor_email . "\n" .
                  "Subject: " . $subject . "\n" .
                  "User Message: " . $message . "\n";

    $to = "satyamgagre4@gmail.com";

    $headers = "From: " . $email_from . "\r\n";
    $headers .= "Reply-To: " . $visitor_email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send mail
    if (mail($to, $email_subject, $email_body, $headers)) {
        header("Location: contact.html?success=true");
        exit();
    } else {
        header("Location: contact.html?error=send_failed");
        exit();
    }
} else {
    header("Location: contact.html?error=invalid_request");
    exit();
}
?>