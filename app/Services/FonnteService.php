<?php

namespace App\Services;

class FonnteService
{
    protected $token;
    protected $url = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = env('FONNTE_TOKEN');
    }

    /**
     * Kirim pesan WhatsApp via Fonnte
     * @param string $target Nomor WA tujuan (format 628xxxx)
     * @param string $message Pesan yang akan dikirim
     * @return array|null
     */
    public function sendMessage($target, $message)
    {
        $curl = curl_init();
        $postFields = [
            'target' => $target,
            'message' => $message,
        ];
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $this->token,
            ],
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if ($error) {
            return ['status' => false, 'error' => $error];
        }
        return json_decode($response, true);
    }
}
