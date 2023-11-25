<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vehicule;
use App\Entity\Commande;
use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, VehiculeRepository $repo): Response
    {
        $voitures = $repo->findAll();

        $startDate = $request->query->get('start_date');
        $endDate = $request->query->get('end_date');

        return $this->render("home/index.html.twig", [
            "voitures" => $voitures,
            "start_date" => $startDate,
            "end_date" => $endDate,
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        $startDate = new \DateTime($request->query->get('start_date'));
        $endDate = new \DateTime($request->query->get('end_date'));
        $availableVehicles = $vehiculeRepository->findAvailableVehicles($startDate, $endDate);

        return $this->render('search/index.html.twig', [
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'vehicles' => $availableVehicles,
        ]);
    }

    #[Route('/confirm_reservation/{id}', name: 'confirm_reservation')]
    public function confirmReservation(Vehicule $vehicule, Request $request, VehiculeRepository $repo, ManagerRegistry $doctrine, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }

        $startDate = new \DateTime($request->query->get('start_date'));
        $endDate = new \DateTime($request->query->get('end_date'));

        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            $membreId = $user->getIdMembre();

            $vehiculeId = $request->request->get('idVehicule');
            $vehicule = $repo->find($vehiculeId);
            $startDate = new \DateTime($request->request->get('start_date_from'));
            $endDate = new \DateTime($request->request->get('end_date_form'));
            $prixTotal = $request->request->get('total_cost_form');

            $em = $doctrine->getManager();
            $commande = new Commande();
            $commande
                ->setIdMembre($membreId)
                ->setIdVehicule($vehiculeId)
                ->setDateHeureDepart($startDate)
                ->setDateHeureFin($endDate)
                ->setPrixTotal($prixTotal)
                ->setDateEnregistrement(new \DateTime());

            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/confirm_reservation.html.twig', [
            'vehicule' => $vehicule,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ]);
    }

}
