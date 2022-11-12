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
     * @Route("/{id}"), name="app_home", methods={"GET, POST"})
     */
    public function indexnext(int $id, CallApiService $api): Response
    {
        $apiCharacter = $api->fetchDataCharacterApi($id);
        $characters = $apiCharacter['results'];

        return $this->render('home/index.html.twig', [
            'characters' => $characters
        ]);
    }
}
