<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/"), name="app_home", methods={"GET, POST"})
     */
    public function home(PersonRepository $personRepository): Response
    {
        return $this->render('home/header.html.twig', [
            'persons' => $personRepository->findAllPersonLimitSQL(),
        ]);
    }
}
