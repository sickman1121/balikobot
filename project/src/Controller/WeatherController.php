<?php

namespace App\Controller;

use App\Validator\CityValidator;
use App\Service\OpenMeteoService;
use http\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{

    public function __construct()
    {
        $this->openMeteoService = new OpenMeteoService();
    }

    /**
     * @Route("/api/weather", methods={"POST"})
     */
    public function listWeather(Request $request): JsonResponse
    {
        $city = $request->post('city');

        $cityValidator = new CityValidator($city);

        if(!$cityValidator->isCityValid()){
            return new JsonResponse(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $response = $this->openMeteoService->getWeatherByCity($city);
        }catch (\Exception $e){
            return new JsonResponse(Response::HTTP_I_AM_A_TEAPOT);
        }
        // can't test this... so... I will go with the API specs
        return new JsonResponse(Response::HTTP_OK);
    }
}