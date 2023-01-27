<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use App\Exceptions\MagpieAPIException;
use GuzzleHttp\Promise\PromiseInterface;

class MagpieAPI
{
    /**
     * @throws MagpieAPIException
     */
    public function getCheckoutSession(array $data): PromiseInterface|Response
    {
        try {
            $secret = env('MAGPIE_API_SK');
            $token = base64_encode($secret);
            $http = Http::withToken('Basic ' . $token, null)
            ->post('https://pay.magpie.im/api/v2/sessions', $data);
        } catch (Exception $e) {
            throw new MagpieAPIException("Connection Error : {$e->getMessage()}", 500);
        }

        return $http;
    }
}