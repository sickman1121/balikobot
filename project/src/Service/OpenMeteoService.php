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

        //problem 4. musim vytvorit transofrmator z nazvu mesta na geo lokaci... zase... vazebni tabulka by byla lepsi ale pro pocet 6 je kodove zastoupeni rychlejsi
        $cityToGeologicalLocationTransformer = new CityToGeologicalLocationTransformer($city);
        $geolocationOfTheCity = $cityToGeologicalLocationTransformer->transformCityToGeoLocation();
        //problem 5. omlouvam se tohle mi uteklo...
        $response = $this->client->get($this->url, [
            'start_date' => $this->today->format('Y-m-d'),
            'end_date' => $this->today->modify('+ 7 days')
                ->format('Y-m-d'),
            'latitude' => $geolocationOfTheCity->latitude,
            'longitude' => $geolocationOfTheCity->longitude,
            // problem 8. ano vim ze tu jsou duplicitni klice... SA mi nefungovalo a takhle to proslo, a jelikoz me tlacil cas tak jsem to tak nechal, protoze jsem resil ostatni problemy.
            'daily' => 'temperature_2m_max',
            'daily' => 'temperature_2m_min'

        ]);

        $daily = $response->getBody()->getContents()['daily'];
        $weather = null;
        //problem 6. tady spoleham na spravnost odpovedi 3. strany coz je spatne ale ve shonu jsem to udelal takhle... protoze velikost poli se vzdy shoduje
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
// problem 7. tohle jsem nestihl dopsat zkusim to jeste domackat, ale myslenka je asi zrejma
        // chtel jsem vytvorit colekci objektu (DTO) ktere budou mit structuru podle zadani
        return new WeatherCollection::fromResponse($weather);

    }
}