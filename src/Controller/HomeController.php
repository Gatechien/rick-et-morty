<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\EpisodeRepository;
use App\Repository\LocationRepository;
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
     * @Route("/", name="home", methods={"GET"})
     * 
     * @return Response
     */
    public function home():Response
    {
        return $this->render('front/home.html.twig');
    }

    /**
     * @Route("/person", name="person", methods={"GET"})
     * 
     * @param Request $request
     * @param PersonRepository $personRepository
     * @param PaginatorInterface $paginator
     * 
     * @return Response
     */
    public function list(Request $request, PersonRepository $personRepository, PaginatorInterface $paginator): Response
    {
        $persons = $paginator->paginate(
            $personRepository->findAll(),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('front/person.html.twig', [
            'persons' => $persons,
        ]);
    }

    /**
     * @Route("/episode", name="episode", methods={"GET"})
     * 
     * @param Request $request
     * @param EpisodeRepository $episodeRepository
     * @param PaginatorInterface $paginator
     * 
     * @return Response
     */
    public function episode(Request $request, EpisodeRepository $episodeRepository, PaginatorInterface $paginator): Response
    {
        $episodes = $paginator->paginate(
            $episodeRepository->findAll(),
            $request->query->getInt('page', 1),
            13
        );

        return $this->render('front/episode.html.twig', [
            'episodes' => $episodes,
        ]);
    }

    /**
     * @Route("/location", name="location", methods={"GET"})
     * 
     * @param Request $request
     * @param LocationRepository $locationRepository
     * @param PaginatorInterface $paginator
     * 
     * @return Response
     */
    public function location(Request $request, LocationRepository $locationRepository, PaginatorInterface $paginator): Response
    {
        $locations = $paginator->paginate(
            $locationRepository->findAll(),
            $request->query->getInt('page', 1),
            22
        );

        return $this->render('front/location.html.twig', [
            'locations' => $locations,
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"}, requirements={"slug"="[\w-]+"})
     * 
     * @param Person $person
     * 
     * @return Response
     */
    public function show(Person $person): Response
    {
        return $this->render('front/show.html.twig', [
            'person' => $person,
        ]);
    }
}
