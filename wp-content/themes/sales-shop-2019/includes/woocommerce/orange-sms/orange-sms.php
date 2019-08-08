<?php
/**
 * Orange SMS System API functional
 */
class OrangeSms
{
    private $access_token = null;
    private $access_token_type = null;
    private $access_token_api_url = "https://api.orange.com/oauth/v2/token";
    private $access_token_api_http_header = array('Authorization: Basic NHROR3Ywek5Kak13Z3hpUXpxZlk2T2daR0h0MHBaSDM6Z0FDRFl3YTFkemNMSUdwbg==');

    private $send_api_url = "https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B2240000/requests";

    public function __construct($token_type = 'Bearer')
    { 
        $this->access_token_type = $token_type;
        $this->access_token = $this->getAccessToken();
    }

    private function getAccessToken()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->access_token_api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            "grant_type=client_credentials"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->access_token_api_http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = json_decode(curl_exec($ch), true);
        

        curl_close($ch);

        return $server_output['access_token'];
    }

    public function sendMessage($sender, $receiver, $message)
    {
        $data = [
            'outboundSMSMessageRequest' => [
                'address' => 'tel:' . $receiver,
                'senderAddress' => 'tel:' . $sender,
                'outboundSMSTextMessage' => [
                    'message' => $message 
                ]
            ]
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->send_api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $this->access_token_type . ' ' . $this->access_token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $server_output;
    }
}
