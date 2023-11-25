<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin")]
class CommandeController extends AbstractController
{
    #[Route("/commande/list" , name:"commande_list")]
    public function listecommandes(commandeRepository $repo) :Response{

        $commandes = $repo->findAll();

        return $this->render( "back/commande_list.html.twig" , [
            "commandes" => $commandes 
        ] );

    }

    #[Route( "/commande/update/{id}", name:"commande_update")]
    public function updatecommande($id , CommandeRepository $repo , Request $request, ManagerRegistry $doctrine):Response{

        $commande = $repo->find($id);
        dump($commande);
        $form = $this->createForm(CommandeType::class , $commande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($commande);
            $em->flush();
            $this->addFlash("success", "commande $id a bien été modifié");
            return $this->redirectToRoute("commande_list");
        }

        return $this->render( "back/commande.html.twig" , [
            "form" => $form ,
            "title" => "Mettre à jour une commande",
            "btn" => "Mettre à jour la commande"
        ] );
    }

    #[Route("/commande/delete/{id}" , name:"commande_delete")]
    public function deletecommande($id , CommandeRepository $repo, ManagerRegistry $doctrine):Response{

        $commande = $repo->find($id);
        $em = $doctrine->getManager();
        $em->remove($commande);
        $em->flush();
        $this->addFlash("success", "commande $id a bien été supprimé");
        return $this->redirectToRoute("commande_list");

    }

}