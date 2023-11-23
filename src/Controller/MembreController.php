<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin")]
class MembreController extends AbstractController
{
    #[Route('/membre/new', name: 'membre_new')]
    public function index( Request $request , ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher): Response
    {
        $membre = new Membre();
        dump($membre);
        $form = $this->createForm(MembreType::class , $membre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $passwordHashe = $hasher->hashPassword($membre, $membre->getPassword());
            $membre->setPassword($passwordHashe);
            $em->persist($membre);
            $em->flush();
            $this->addFlash("success", "membre bien crée");
            return $this->redirectToRoute('membre_list');
        }

        return $this->render('back/membre.html.twig', [
            "form" => $form->createView() ,
            "title" => "créer un membre" ,
            "btn" => "Créer un membre"
        ]);
    }

    #[Route("/membre/list" , name:"membre_list")]
    public function listemembres(MembreRepository $repo) :Response{

        $membres = $repo->findAll();

        return $this->render( "back/membre_list.html.twig" , [
            "membres" => $membres 
        ] );

    }

    #[Route( "/membre/update/{id}", name:"membre_update")]
    public function updatemembre($id , MembreRepository $repo , Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher):Response{
    
        $membre = $repo->find($id);
        dump($membre);
    
        $originalPassword = $membre->getPassword();
    
        $form = $this->createForm(MembreType::class , $membre);
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
            return $this->redirectToRoute("membre_list");
        }
    
        return $this->render( "back/membre.html.twig" , [
            "form" => $form ,
            "title" => "Mettre à jour un membre",
            "btn" => "Mettre à jour la fiche du membre"
        ] );
    }
    

    #[Route("/membre/delete/{id}" , name:"membre_delete")]
    public function deletemembre($id , MembreRepository $repo, ManagerRegistry $doctrine):Response{

        $membre = $repo->find($id);
        $em = $doctrine->getManager();
        $em->remove($membre);
        $em->flush();
        $this->addFlash("success", "membre $id a bien été supprimé");
        return $this->redirectToRoute("membre_list");

    }

}