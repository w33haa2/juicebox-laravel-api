<?php

namespace App\Repositories\Implementations;

use App\Models\WeatherData;
use App\Repositories\Contracts\WeatherRepositoryInterface;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Cache;

class WeatherRepository implements WeatherRepositoryInterface
{
    protected WeatherService $weatherService;
   
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function fetch(): array
    {

        $cacheKey = "weather-data";

        // Check if data exists in cache
        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);

            return [
                'success' => true,
                'data' => $cachedData,
                'status' => 200
            ];
        }
        // If not, fetch data from API
        $result = $this->weatherService->getWeatherForCity('Perth,AU');
        Cache::put($cacheKey, $result['data'], 300); // updates every 5 minutes for testing purposes
        // for history purposes
        WeatherData::create([
            'weather_id' => $result['data']['weather']['id'],
            'main' => $result['data']['weather']['main'],
            'description' => $result['data']['weather']['description'],
            'icon' => $result['data']['weather']['icon'],
            'dt' => $result['data']['dt'], // or \Carbon\Carbon::createFromTimestamp($dt)
        ]);
        return $result;
    }
}
