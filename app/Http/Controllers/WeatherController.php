<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\WeatherRepositoryInterface;

/**
 * @OA\Tag(
 *     name="Weather",
 *     description="Endpoints for fetching data from openweathermap"
 * )
 */
class WeatherController extends Controller
{
    protected WeatherRepositoryInterface $weatherRepository;

    public function __construct(WeatherRepositoryInterface $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/weather/perth",
     *     tags={"Weather"},
     *     summary="Fetch weather data for Perth, Australia",
     *     description="Retrieves the current weather data for Perth using OpenWeatherMap API.",
     *     @OA\Response(
     *         response=200,
     *         description="Weather data retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="temperature", type="number", example=22.5),
     *                 @OA\Property(property="feels_like", type="number", example=21.8),
     *                 @OA\Property(property="humidity", type="integer", example=60),
     *                 @OA\Property(property="weather", type="string", example="clear sky"),
     *                 @OA\Property(property="wind_speed", type="number", example=5.1)
     *             ),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to fetch weather data"
     *     )
     * )
     */
    public function getWeatherData()
    {
        $result = $this->weatherRepository->fetch();

        return response()->json($result, $result['status']);
    }

}
