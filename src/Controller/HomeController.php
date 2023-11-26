<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use App\Repository\MembreRepository;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vehicule;
use App\Entity\Commande;
use App\Form\ProfilType;
use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(VehiculeRepository $repo): Response
    {
        $voitures = $repo->findAll();

        return $this->render("home/index.html.twig", [
            "voitures" => $voitures,
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, EntityManagerInterface $entityManager): Response
    {
        $startDate = new \DateTime($request->query->get('start_date'));
        $endDate = new \DateTime($request->query->get('end_date'));

        $dql = "SELECT v
        FROM App\Entity\Vehicule v
        WHERE NOT EXISTS 
            (SELECT c.id_commande 
            FROM App\Entity\Commande c
            WHERE c.id_vehicule = v AND 
                ((c.date_heure_depart BETWEEN :start_date AND :end_date) OR 
                    (c.date_heure_fin BETWEEN :start_date AND :end_date)))";

        $query = $entityManager->createQuery($dql);
        $query->setParameter('start_date', $startDate);
        $query->setParameter('end_date', $endDate);

        $vehiculesDispo = $query->getResult();

        return $this->render('home/search.html.twig', [
            'start_date' => $startDate->format('d-m-Y H:i:s'),
            'end_date' => $endDate->format('d-m-Y H:i:s'),
            'vehicles' => $vehiculesDispo,
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
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'end_date' => $endDate->format('Y-m-d H:i:s'),
        ]);
    }

    #[Route( "/membre", name:"membre")]
    public function membre(MembreRepository $repo, VehiculeRepository $vehiculeRepo, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher, CommandeRepository $commandeRepository):Response{
        $user = $this->getUser();
        $id = $user->getIdMembre();
        $membre = $repo->find($id);
        dump($membre);
    
        $originalPassword = $membre->getPassword();

        $commandes = $commandeRepository->findBy(['id_membre' => $id]);
        $vehicules = $vehiculeRepo->findAll();
    
        $form = $this->createForm(ProfilType::class , $membre);
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid()){
    
            $em = $doctrine->getManager();
    
            if ($membre->getPassword() !== $originalPassword) {
                $passwordHashe = $hasher->hashPassword($membre, $membre->getPassword());
                $membre->setPassword($passwordHashe);
            }
    
            $em->persist($membre);
            $em->flush();
            $this->addFlash("success", "membre $id a bien été modifié");
            return $this->redirectToRoute("membre");
        }
    
        return $this->render( "home/profil.html.twig" , [
            "commandes" => $commandes,
            "vehicules" => $vehicules,
            "form" => $form ,
            "title" => "Gestion profil",
            "btn" => "Mettre à jour vos information"
        ] );
    }

}
