<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route("/inscription" , name:"app_inscription")]
    public function inscription(Request $request , ManagerRegistry $doctrine , UserPasswordHasherInterface $hasher) : Response{

        // décrire formulaire 
        $membre = new Membre();
        $form =  $this->createForm(RegisterType::class, $membre);

        // remplir les champs du formulaire avec des infos
        $form->handleRequest($request);
        //dd($membre);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager(); 
            $passwordHashe = $hasher->hashPassword($membre, $membre->getPassword());
            $membre->setPassword($passwordHashe);
            $em->persist($membre);
            $em->flush();
            return $this->redirectToRoute("app_login");
        }

        return $this->render("security/inscription.html.twig" , [
            // envoie le formulaire à la vue pour qu'il s'affiche
            "form" => $form->createView()
        ]);
    }
}
