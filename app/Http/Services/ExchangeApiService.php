<?php
namespace App\Http\Services;

use App\Models\Share;

class ExchangeApiService
{
    public function getStock($symbol)
    {
        $httpClient = new \GuzzleHttp\Client();
        $request =
            $httpClient
                ->get("https://v6.exchangerate-api.com/v6/" . env('EXC_API_KEY') . "/latest/{$symbol}");

        $response = json_decode($request->getBody()->getContents());        
        return $response;
    }
}
