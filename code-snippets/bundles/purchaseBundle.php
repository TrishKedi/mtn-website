function purchase_bundle($user_number, $beneficiary, $consent_token, $bundle_id, $pay_type){
    // Set URL for bundle validation API
    $url = 'YOUR_BUNDLE_VALIDATION_API_URL';
    $key = 'YOUR_API_KEY';
    $bundle_category = "Bundles";
    $transactionId = time();

    // Define special bundle categories
    $gaga_bundles = ["GAGA_VIDEO_SY", "GAGA_GAMING_SY", "GAGA_SUPER_SY"];
    if (in_array($bundle_id, $gaga_bundles)) {
        $bundle_category = "FiveG";
    }

    // Create payload for bundle purchase
    $payload = [
        "msisdn" => $user_number,
        "vendor" => "your_vendor",
        "operation" => "your_operation",
        "consentToken" => $consent_token,
        "data" => (object)[
            "category" => $bundle_category,
            "notificationContact" => "null",
            "channel" => [
                (object)[
                    "id" => "YOUR_CHANNEL_ID",
                    "role" => "",
                    "name" => "YOUR_CHANNEL_NAME"
                ]
            ],
            "relatedParty" => [
                (object)[
                    "id" => "CIS",
                    "role" => "provider"
                ],
                (object)[
                    "id" => $user_number,
                    "role" => "primarymsisdn"
                ],
                (object)[
                    "id" => $user_number == $beneficiary ? "" : $beneficiary,
                    "role" => "beneficiarymsisdn"
                ]
            ],
            "payment" => [
                (object)[
                    "id" => $pay_type,
                    "name" => "paySrc"
                ]
            ],
            "productOrderItem" => [
                (object)[
                    "action" => "add",
                    "product" => (object)[
                        "isBundle" => true,
                        "@type" => "Others",
                        "productSpecification" => (object)[
                            "id" => $bundle_id,
                            "name" => "CIS Offer"
                        ]
                    ],
                    "itemPrice" => [
                        (object)[
                            "priceType" => "nonRecurring",
                            "priceAlteration" => [
                                (object)[
                                    "price" => (object)[
                                        "taxIncludedAmount" => (object)[
                                            "unit" => "string",
                                            "value" => ""
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    // Adjust related party for beneficiary
    if ($user_number == $beneficiary && $bundle_category === 'FiveG') {
        foreach ($payload['data']->relatedParty as $rkey => $relatedParty) {
            if ($relatedParty->role === "beneficiarymsisdn") {
                unset($payload['data']->relatedParty[$rkey]);
            }
        }
    }

    // Reindex the related party array after removal
    $payload['data']->relatedParty = array_values($payload['data']->relatedParty);

    // Set request headers
    $headers = [
        'Content-Type' => 'application/json',
        "x-api-key" => $key,
        "x-countryCode" => "UGA",
        "transactionId" => $transactionId
    ];

    // Send POST request for bundle purchase
    $options = [
        'headers' => $headers,
        'body' => wp_json_encode($payload)
    ];
    
    $response = wp_remote_post($url, $options);
    return $response;
}
