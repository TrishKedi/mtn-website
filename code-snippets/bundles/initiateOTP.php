function initiate_otp_request($user_number){
    // Set URL for OTP API
    $url = 'YOUR_OTP_API_URL';
    $key = 'YOUR_API_KEY';

    // Create payload for OTP request
    $payload = [
        "msisdn" => $user_number,
        "vendor" => "your_vendor",
        "operation" => "your_operation",
    ];

    // Set request headers
    $headers = [
        'Content-Type' => 'application/json',
        "x-api-key" => $key,
        "x-countryCode" => "UGA"
    ];

    // Send POST request to OTP API
    $options = [
        'headers' => $headers,
        'body' => wp_json_encode($payload)
    ];
    
    $response = wp_remote_post($url, $options);
    return $response;
}
