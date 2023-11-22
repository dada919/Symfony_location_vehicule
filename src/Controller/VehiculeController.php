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
        // et le retourner 

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            // dd($vehicule);
            $em->persist($vehicule); // va stocker les valeurs du formulaire 
            // DANS l'entité
            $em->flush();
            $this->addFlash("success", "vehicule bien crée");
            return $this->redirectToRoute("home");
        }

        return $this->render('back/vehicule.html.twig', [
            "form" => $form->createView() ,
            "title" => "créer un vehicule" ,
            "btn" => "créer"
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
    public function updatevehicule($id , vehiculeRepository $repo , Request $request, ManagerRegistry $doctrine):Response{

        $vehicule = $repo->find($id); // {id = 1 } => UPDATE
        dump($vehicule);

        $form = $this->createForm(vehiculeType::class , $vehicule);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            // dd($vehicule);
            $em->persist($vehicule); // va stocker les valeurs du formulaire 
            // DANS l'entité
            $em->flush();
            $this->addFlash("success", "vehicule bien crée");
            return $this->redirectToRoute("home");
        }

        return $this->render( "back/index.html.twig" , [
            "form" => $form ,
            "title" => "Mettre à jour un vehicule",
            "btn" => "update"
        ] );
    }

    #[Route("/vehicule/delete/{id}" , name:"vehicule_delete")]
    public function deletevehicule($id , vehiculeRepository $repo, ManagerRegistry $doctrine):Response{

        $vehicule = $repo->find($id);
        $em = $doctrine->getManager();
        $em->remove($vehicule);
        $em->flush();
        $this->addFlash("success", "vehicule $id a bien été supprimé");
        return $this->redirectToRoute("vehicule_list");

    }

}