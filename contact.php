<?php
/**
 * Contact Form Handler for Vanam SARL Website
 * 
 * This script processes the contact form submission from contact.html,
 * validates the input, and sends an email to the admin.
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log the raw POST data for debugging
file_put_contents('debug_post.log', date('Y-m-d H:i:s') . " - Raw POST data: " . print_r($_POST, true) . "\n", FILE_APPEND);

// Configuration - Update these with your actual email settings
$config = [
    'admin_email' => 'reCAPTCHA', // Change to your actual email
    'email_subject' => 'New Contact Form Submission - Vanam SARL',
    'smtp_host' => 'mail.vanam.fr', // Update with your SMTP server
    'smtp_username' => 'sales@vanam.fr', // Update with your SMTP username
    'smtp_password' => 'Vanam13010', // Update with your SMTP password
    'smtp_port' => 587, // Common ports: 25, 465, 587
    'smtp_secure' => 'tls', // Options: '', 'ssl', 'tls'
    'smtp_auth_type' => 'LOGIN', // Force LOGIN authentication method
    'recaptcha_secret' => '6LdFyhkrAAAAAB2UQcgQdvDUb_rJov550ry5t_Vi', // Test secret key - replace with your actual secret key in production
];

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

// Process only POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify reCAPTCHA first
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
    
    if (empty($recaptcha_response)) {
        $response['message'] = 'Please complete the reCAPTCHA verification.';
        $response['errors'][] = 'reCAPTCHA verification is required';
    } else {
        // Verify the reCAPTCHA response
        $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $config['recaptcha_secret'],
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $verify_response = file_get_contents($verify_url, false, $context);
        $captcha_success = json_decode($verify_response);
        
        // Log reCAPTCHA verification response
        file_put_contents('recaptcha_log.log', date('Y-m-d H:i:s') . " - reCAPTCHA response: " . print_r($captcha_success, true) . "\n", FILE_APPEND);
        
        if (!$captcha_success->success) {
            $response['message'] = 'reCAPTCHA verification failed. Please try again.';
            $response['errors'][] = 'Invalid reCAPTCHA';
        } else {
            // reCAPTCHA verified, proceed with form processing
            
            // Get form data and sanitize inputs
            $name = htmlspecialchars(trim($_POST['name']));
            $email = htmlspecialchars(trim($_POST['email']));
            $message = htmlspecialchars(trim($_POST['message']));
            $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
            
            // For testing purposes - log the form submission
            $log_file = 'contact_submissions.log';
            $log_entry = date('Y-m-d H:i:s') . " - Name: $name, Email: $email, Phone: $phone, Message: $message\n";
            file_put_contents($log_file, $log_entry, FILE_APPEND);
            
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
                $headers = "From: {$config['smtp_username']}\r\n";
                $headers .= "Reply-To: $email\r\n";
                
                try {
                    // For testing purposes - always succeed in test mode
                    $test_mode = false; // Set to false in production
                    
                    if ($test_mode) {
                        // Log the email that would have been sent
                        $log_file = 'email_sent.log';
                        $log_entry = date('Y-m-d H:i:s') . " - Email would be sent to: {$config['admin_email']}\n";
                        $log_entry .= "Subject: {$config['email_subject']}\n";
                        $log_entry .= "Content:\n$email_content\n";
                        $log_entry .= "-----------------------------------\n";
                        file_put_contents($log_file, $log_entry, FILE_APPEND);
                        
                        // Simulate success
                        $response['success'] = true;
                        $response['message'] = 'Thank you for your message. We will get back to you soon! (Test Mode)';
                    }
                    // Use PHPMailer from the uploaded directory
                    else {
                        // Use PHPMailer for SMTP
                        require 'PHPMailer-master/src/PHPMailer.php';
                        require 'PHPMailer-master/src/SMTP.php';
                        require 'PHPMailer-master/src/Exception.php';
                        
                        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                        
                        // Server settings
                        $mail->SMTPDebug = 0; // Set to 0 for production (2 for debug)
                        $mail->isSMTP();
                        $mail->Host = $config['smtp_host'];
                        $mail->SMTPAuth = true;
                        $mail->Username = $config['smtp_username'];
                        $mail->Password = $config['smtp_password'];
                        $mail->Port = $config['smtp_port'];
                        
                        if (!empty($config['smtp_secure'])) {
                            $mail->SMTPSecure = $config['smtp_secure'];
                        }
                        
                        // Force specific authentication type if specified
                        if (!empty($config['smtp_auth_type'])) {
                            $mail->AuthType = $config['smtp_auth_type'];
                        }
                        
                        // Recipients
                        $mail->setFrom($config['smtp_username'], 'Vanam Contact Form'); // Use SMTP username as From
                        $mail->addAddress($config['admin_email']);
                        $mail->addReplyTo($email, $name);
                        
                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = $config['email_subject'];
                        
                        // Create HTML email body
                        $htmlContent = "<h3>New Message From Contact Form</h3>
                                        <p><strong>Name:</strong> {$name}</p>
                                        <p><strong>Email:</strong> {$email}</p>";
                        
                        if (!empty($phone)) {
                            $htmlContent .= "<p><strong>Phone:</strong> {$phone}</p>";
                        }
                        
                        $htmlContent .= "<p><strong>Message:</strong></p>
                                        <p>" . nl2br($message) . "</p>";
                        
                        $mail->Body = $htmlContent;
                        $mail->AltBody = $email_content; // Plain text version
                        
                        $mail->send();
                        $response['success'] = true;
                        $response['message'] = 'Thank you for your message. We will get back to you soon!';
                    }
                } catch (Exception $e) {
                    $response['message'] = 'Sorry, there was an error sending your message. Please try again later.';
                    // Log the error
                    error_log('Email sending error: ' . $e->getMessage());
                    file_put_contents('email_error.log', date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . "\n", FILE_APPEND);
                }
            } else {
                $response['message'] = 'Please correct the errors in the form.';
                $response['errors'] = $errors;
            }
        }
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
