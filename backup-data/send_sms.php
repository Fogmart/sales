<?php
function auth()
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://api.orange.com/oauth/v2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic NHROR3Ywek5Kak13Z3hpUXpxZlk2T2daR0h0MHBaSDM6Z0FDRFl3YTFkemNMSUdwbg=='));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = json_decode(curl_exec($ch), true);

    curl_close ($ch);

    var_dump($server_output);
}

function send_sms($phone)
{
    $access = [
        "token_type" => "Bearer",
        "access_token" => "lDcGKypCBCDEOZ561LxhnVlHlGyg"
    ];
    $data = [
        'outboundSMSMessageRequest' => [
            'address' => 'tel:' . $phone,
            'senderAddress' => 'tel:+2240000',
            'outboundSMSTextMessage' => [
                'message' => 'Hello!'
            ]
        ]
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B2240000/requests");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $access['token_type'] . ' ' . $access['access_token'],
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = json_decode(curl_exec($ch), true);

    curl_close ($ch);

    var_dump($server_output);
}
//send_sms('+224660585276');
//send_sms('+224656319263');
// send_sms('+224657202816');