<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function getWeatherForCity(string $city): array
    {
        $response = Http::get($this->baseUrl, [
            'q' => $city,
            'units' => 'metric',
            'appid' => $this->apiKey,
        ]);

        if ($response->failed()) {
            return [
                'success' => false,
                'message' => 'Failed to fetch weather data',
                'status' => $response->status(),
            ];
        }

        return [
            'success' => true,
            'data' => [
                'weather' => $response->json()['weather'][0],
                'dt' =>  $response->json()['dt'],
            ],
            'status' => 200,
        ];
    }
}
