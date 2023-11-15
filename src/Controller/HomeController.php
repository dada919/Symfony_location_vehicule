<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(VehiculeRepository $repo): Response
    {
        $voitures = $repo->findAll();

        return $this->render("home/index.html.twig", ["voitures" => $voitures]);
    }
}
