<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PropertyRepository $reposetory): Response
    {
        $properties = $reposetory->findLast();
        return $this->render('home/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
