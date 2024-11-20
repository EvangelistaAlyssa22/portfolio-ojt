<?php

// Replace this with your own email address
$siteOwnersEmail = 'alyssaevangelista8@gmail.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Initialize error array
    $error = [];

    // Validate Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }

    // Validate Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }

    // Default Subject if not provided
    if (empty($subject)) {
        $subject = "Contact Form Submission";
    }

    // If there are no errors, send the email
    if (empty($error)) {
        // Set email message content
        $message = "Email from: " . $name . "<br />";
        $message .= "Email address: " . $email . "<br />";
        $message .= "Message: <br />" . nl2br($contact_message);  // Handle line breaks
        $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

        // Set From header
        $from =  $name . " <" . $email . ">";

        // Email Headers
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Send the email
        ini_set("sendmail_from", $siteOwnersEmail);  // For Windows servers (optional)
        if (mail($siteOwnersEmail, $subject, $message, $headers)) {
            echo 'OK';  // Return success response
        } else {
            echo 'Something went wrong. Please try again.';  // Return failure message
        }

    } else {
        // Return validation errors
        $response = "";
        if (isset($error['name'])) {
            $response .= $error['name'] . "<br /> \n";
        }
        if (isset($error['email'])) {
            $response .= $error['email'] . "<br /> \n";
        }
        if (isset($error['message'])) {
            $response .= $error['message'] . "<br />";
        }
        echo $response;  // Return errors
    }
}
?>
