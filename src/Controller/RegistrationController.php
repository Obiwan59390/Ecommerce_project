<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
// entityManager : Doctrine : exécuter les requêtes
private $em;
public function __construct(EntityManagerInterface $em)
{
    $this->em = $em;
}
#[Route('/inscription', name: 'inscription')]
public function index(Request $request, UserPasswordHasherInterface $uphi): Response
{
    $user = new User();
    $form = $this->createForm(RegistrationFormType::class, $user);

    // écoute de la requête du submit 
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        // récupérer les données du formulaire
        $user = $form->getData();
        $pwd = $user->getPassword();
        $pwd = $uphi->hashPassword($user, $pwd);
        $user->setPassword($pwd);
        // figer les données à envoyer vers la BDD
        $this->em->persist($user);
        // Sauvegarde dans la BDD 
        $this->em->flush();
    }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
