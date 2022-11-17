<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/"), name="app_home", methods={"GET, POST"})
     */
    public function index(CallApiService $api): Response
    {
        $apiEpisode = $api->fetchDataEpisodeApi();
        $episodes = $apiEpisode['results'];
        /*
            $data = "https://rickandmortyapi.com/api/character/125";
            $toto = explode("https://rickandmortyapi.com/api/character/", $data);

            $tata = intval($toto);

            dd($toto[1]);
        */
        return $this->render('home/index.html.twig', [
            'episodes' => $episodes
        ]);
    }
}
