<?php
/**
 * Contact Form Handler for Vanam SARL Website
 * 
 * This script processes the contact form submission from contact.html,
 * validates the input, and sends an email to the admin.
 */

// Configuration - Update these with your actual email settings
$config = [
    'admin_email' => 'admin@vanam.fr', // Change to your actual email
    'email_subject' => 'New Contact Form Submission - Vanam SARL',
    'smtp_host' => 'smtp.example.com', // Update with your SMTP server
    'smtp_username' => 'your_username', // Update with your SMTP username
    'smtp_password' => 'your_password', // Update with your SMTP password
    'smtp_port' => 587, // Common ports: 25, 465, 587
    'smtp_secure' => 'tls', // Options: '', 'ssl', 'tls'
];

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

// Process only POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get form data and sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    // Validate inputs
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    // If validation passes, send email
    if (empty($errors)) {
        // Prepare email content
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        
        if (!empty($phone)) {
            $email_content .= "Phone: $phone\n";
        }
        
        $email_content .= "Message:\n$message\n";
        
        // Set up email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        try {
            // Check if PHPMailer is available
            if (file_exists('vendor/autoload.php')) {
                // Use PHPMailer for SMTP
                require 'vendor/autoload.php';
                
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                
                // Server settings
                $mail->isSMTP();
                $mail->Host = $config['smtp_host'];
                $mail->SMTPAuth = true;
                $mail->Username = $config['smtp_username'];
                $mail->Password = $config['smtp_password'];
                $mail->Port = $config['smtp_port'];
                
                if (!empty($config['smtp_secure'])) {
                    $mail->SMTPSecure = $config['smtp_secure'];
                }
                
                // Recipients
                $mail->setFrom($email, $name);
                $mail->addAddress($config['admin_email']);
                $mail->addReplyTo($email, $name);
                
                // Content
                $mail->isHTML(false);
                $mail->Subject = $config['email_subject'];
                $mail->Body = $email_content;
                
                $mail->send();
                $response['success'] = true;
                $response['message'] = 'Thank you for your message. We will get back to you soon!';
            } else {
                // Fallback to mail() function if PHPMailer is not available
                $mail_sent = mail($config['admin_email'], $config['email_subject'], $email_content, $headers);
                
                if ($mail_sent) {
                    $response['success'] = true;
                    $response['message'] = 'Thank you for your message. We will get back to you soon!';
                } else {
                    throw new Exception('Failed to send email');
                }
            }
        } catch (Exception $e) {
            $response['message'] = 'Sorry, there was an error sending your message. Please try again later.';
            // Log the error (in a production environment)
            // error_log('Email sending error: ' . $e->getMessage());
        }
    } else {
        $response['message'] = 'Please correct the errors in the form.';
        $response['errors'] = $errors;
    }
}

// Return JSON response for AJAX requests
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// For non-AJAX requests, redirect back to the contact page with status
if ($response['success']) {
    header('Location: contact.html?status=success');
} else {
    header('Location: contact.html?status=error');
}
exit;
?>
