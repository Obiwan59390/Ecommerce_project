<?php

namespace App\Controller;

use App\Entity\Adresse;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdresseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AdresseController extends AbstractController
{
    #[Route('/mes_adresses', name: 'adresse_controler')]
    public function displayAdress(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Adresse::class);
        $adresses = $repository->findAll();  
        return $this->render('carnetAdresse/carnetAdresse.html.twig', [
            'Adresses' => $adresses,
        ]);
    }

    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/adresse/modifier', name: 'modifierAdresse')]
    public function index(Request $request, UserPasswordHasherInterface $uphi): Response
    {
        $notif = null;
        
        $user = $this->getUser();
        $form = $this->createForm(ModifierPasswordType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ancienPassword = $form->get("ancienPassword")->getData();
            if($uphi->isPasswordValid($user, $ancienPassword)){
                // Modification du mot de passe dans la BDD
                // récupérer le nouveau mot de passe 
                $nouveauPassword = $form->get("nouveauPassword")->getData();
                // crypter le nouveau mot de passe
                $pwd = $uphi->hashPassword($user, $nouveauPassword);
                // placer le mot de passe crypté dans l'objet $user 
                $user->setPassword($pwd);
                // Actualiser dans la BDD
                //$this->em->persist($user);
                $this->em->flush();
                $notif = "Félicitation mot de passe modifier correctement";
            }else{
                $notif = "Le mot de passe actuel n'est pas correct";
            }
        }

        return $this->render('profil/modifierPassword.html.twig', [
            'f' => $form->createView(),
            'notif' => $notif
        ]);
    }
}