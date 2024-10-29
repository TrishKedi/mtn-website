function validate_otp_request($user_number, $otp, $transaction_id){
    // Set URL for token validation API
    $url = 'YOUR_TOKEN_VALIDATION_API_URL';
    $key = 'YOUR_API_KEY';

    // Create payload for OTP validation
    $payload = [
        "msisdn" => $user_number,
        "vendor" => "your_vendor",
        "operation" => "your_operation",
        "otp" => $otp,
        "transactionId" => $transaction_id
    ];

    // Set request headers
    $headers = [
        'Content-Type' => 'application/json',
        "x-api-key" => $key,
        "x-countryCode" => "UGA"
    ];

    // Send POST request to validate OTP
    $options = [
        'headers' => $headers,
        'body' => wp_json_encode($payload)
    ];
    
    $response = wp_remote_post($url, $options);
    return $response;
}
