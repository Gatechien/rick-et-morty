<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/"), name="app_home", methods={"GET, POST"})
     */
    public function home(Request $request, PersonRepository $personRepository, PaginatorInterface $paginator): Response
    {
        $persons = $paginator->paginate(
            $personRepository->findAll(),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('home/header.html.twig', [
            'persons' => $persons,
        ]);
    }
}
