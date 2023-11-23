<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin")]
class VehiculeController extends AbstractController
{
    #[Route('/vehicule/new', name: 'vehicule_new')]
    public function index( Request $request , ManagerRegistry $doctrine ): Response
    {
        $vehicule = new Vehicule();
        dump($vehicule);
        $form = $this->createForm(VehiculeType::class , $vehicule);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($vehicule);
            $em->flush();
            $this->addFlash("success", "vehicule bien crée");
            return $this->redirectToRoute("home");
        }

        return $this->render('back/vehicule.html.twig', [
            "form" => $form->createView() ,
            "title" => "créer un vehicule" ,
            "btn" => "Créer un véhicule"
        ]);
    }

    #[Route("/vehicule/list" , name:"vehicule_list")]
    public function listevehicules(vehiculeRepository $repo) :Response{

        $vehicules = $repo->findAll();

        return $this->render( "back/index.html.twig" , [
            "vehicules" => $vehicules 
        ] );

    }

    #[Route( "/vehicule/update/{id}", name:"vehicule_update")]
    public function updatevehicule($id , VehiculeRepository $repo , Request $request, ManagerRegistry $doctrine):Response{

        $vehicule = $repo->find($id);
        dump($vehicule);
        $form = $this->createForm(VehiculeType::class , $vehicule);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($vehicule);
            $em->flush();
            $this->addFlash("success", "vehicule $id a bien été modifié");
            return $this->redirectToRoute("vehicule_list");
        }

        return $this->render( "back/vehicule.html.twig" , [
            "form" => $form ,
            "title" => "Mettre à jour un vehicule",
            "btn" => "Mettre à jour la fiche du véhicule"
        ] );
    }

    #[Route("/vehicule/delete/{id}" , name:"vehicule_delete")]
    public function deletevehicule($id , VehiculeRepository $repo, ManagerRegistry $doctrine):Response{

        $vehicule = $repo->find($id);
        $em = $doctrine->getManager();
        $em->remove($vehicule);
        $em->flush();
        $this->addFlash("success", "vehicule $id a bien été supprimé");
        return $this->redirectToRoute("vehicule_list");

    }

}