<?php

namespace App\Service;


use App\Entity\WeatherCollection;
use App\Transformer\CityToGeologicalLocationTransformer;
use DateTime;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class OpenMeteoService
{

    public Client $client;

    private string $url;
    private DateTime $today;

    public function __construct()
    {
        $this->client = new Client([]);
        $this->url = getenv('OPEN_METEO_URL');
        $this->today = new DateTime();
    }

    public function getWeatherByCity($city): ResponseInterface
    {

        $cityToGeologicalLocationTransformer = new CityToGeologicalLocationTransformer($city);
        $geolocationOfTheCity = $cityToGeologicalLocationTransformer->transformCityToGeoLocation();
        $response = $this->client->post($this->url, [
            'start_date' => $this->today->format('Y-m-d'),
            'end_date' => $this->today->modify('+ 7 days')
                ->format('Y-m-d'),
            'latitude' => $geolocationOfTheCity->latitude,
            'longitude' => $geolocationOfTheCity->longitude,
            'daily' => 'temperature_2m_max',
            'daily' => 'temperature_2m_min'

        ]);

        $daily = $response->getBody()->getContents()['daily'];
        $weather = null;
        for ($i = 0; $i < count($daily['time']); $i++) {
            $temperature2mMax = $daily['temperature_2m_max'][$i];
            $temperature2mMin = $daily['temperature_2m_min'][$i];
            $day = new \DateTimeImmutable($daily['time'][$i]);
            $wheater[] = [
                'day' => $day->format('Y-m-d'),
                'max' => $temperature2mMax,
                'min' => $temperature2mMin,
            ];
        }

        return new WeatherCollection::fromResponse($weather);

    }
}