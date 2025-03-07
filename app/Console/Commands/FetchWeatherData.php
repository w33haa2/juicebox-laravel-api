<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;
use App\Models\WeatherData;
use Illuminate\Support\Facades\Cache;

class FetchWeatherData extends Command
{
    protected $signature = 'weather:fetch-perth';

    protected $description = 'Fetch weather data for Perth, AU and save to database';

    public function handle()
    {
        $weatherService = app(WeatherService::class);
        $cacheKey = "weather-data";

        $this->info('Fetching weather data for Perth, AU...');

        $result = $weatherService->getWeatherForCity('Perth,AU');

        if ($result['success']) {
            $weather = $result['data']['weather'];
            Cache::put($cacheKey, $result['data'], 300); // updates every 5 minutes for testing purposes
            // for history purposes
            WeatherData::create([
                'weather_id' => $weather['id'],
                'main' => $weather['main'],
                'description' => $weather['description'],
                'icon' => $weather['icon'],
                'dt' => $result['data']['dt'],
            ]);

            $this->info('Weather data saved successfully.');
        } else {
            $this->error('Failed to fetch weather data.');
        }
    }
}
